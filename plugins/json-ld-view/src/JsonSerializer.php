<?php
declare(strict_types=1);

namespace MixerApi\JsonLdView;

use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\Paging\PaginatedResultSet;
use Cake\Datasource\ResultSetInterface;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Http\ServerRequest;
use Cake\ORM\Entity;
use Cake\View\Helper\PaginatorHelper;
use MixerApi\Core\View\SerializableAssociation;
use ReflectionException;
use RuntimeException;

/**
 * Creates a JSON-LD resource
 *
 * @link https://json-ld.org/
 * @link https://lists.w3.org/Archives/Public/public-hydra/2015Oct/0163.html
 */
class JsonSerializer
{
    public const BEFORE_SERIALIZE_EVENT = 'MixerApi.JsonLdView.beforeSerialize';
    public const AFTER_SERIALIZE_EVENT = 'MixerApi.JsonLdView.afterSerialize';

    /**
     * JSON-LD data array
     *
     * @var mixed
     */
    private mixed $data;

    /**
     * JsonLd config
     *
     * @var array|null
     */
    private ?array $config;

    /**
     * @var string
     */
    private string $hydra = '';

    /**
     * If constructed without parameters collection meta data will not be added to JSON-LD $data
     *
     * @param mixed $serialize the data to be converted into a JSON-LD array
     * @param \Cake\Http\ServerRequest|null $request optional ServerRequest
     * @param \Cake\View\Helper\PaginatorHelper|null $paginator optional PaginatorHelper
     */
    public function __construct(
        mixed $serialize,
        private ?ServerRequest $request = null,
        private ?PaginatorHelper $paginator = null
    ) {
        $jsonLd = $this->recursion($serialize);
        $this->config = Configure::read('JsonLdView');
        if (isset($this->config['isHydra']) && $this->config['isHydra']) {
            $this->hydra = 'hydra:';
        }

        if ($jsonLd instanceof ResultSetInterface || $jsonLd instanceof PaginatedResultSet) {
            $this->data = $this->collection($jsonLd);
        } elseif (is_subclass_of($jsonLd, Entity::class)) {
            $this->data = $this->item($jsonLd);
        } else {
            $this->data = $serialize;
        }
    }

    /**
     * Serializes data as json-ld
     *
     * @param int $jsonOptions JSON options see https://www.php.net/manual/en/function.json-encode.php
     * @return string
     * @throws \RuntimeException
     */
    public function asJson(int $jsonOptions = 0): string
    {
        EventManager::instance()->dispatch(new Event(self::BEFORE_SERIALIZE_EVENT, $this));

        $json = json_encode($this->data, $jsonOptions);

        if ($json === false) {
            throw new RuntimeException(json_last_error_msg(), json_last_error());
        }

        EventManager::instance()->dispatch(new Event(self::AFTER_SERIALIZE_EVENT, $this, [
            'data' => $json,
        ]));

        return $json;
    }

    /**
     * Get JSON-LD data as an array
     *
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @param mixed $data The data to be serialized
     * @return void
     */
    public function setData(mixed $data): void
    {
        $this->data = $data;
    }

    /**
     * @return \Cake\Http\ServerRequest|null
     */
    public function getRequest(): ?ServerRequest
    {
        return $this->request;
    }

    /**
     * @return \Cake\View\Helper\PaginatorHelper|null
     */
    public function getPaginatorHelper(): ?PaginatorHelper
    {
        return $this->paginator;
    }

    /**
     * Recursive method for converting mixed data into JSON-LD. This method converts instances of Cake\ORM\Entity into
     * JSON-LD resources, but does not serialize the data.
     *
     * @param mixed $mixed data to be serialized
     * @return array|\Cake\Datasource\EntityInterface|\Cake\Datasource\ResultSetInterface
     */
    private function recursion(mixed &$mixed): mixed
    {
        if ($mixed instanceof ResultSetInterface || $mixed instanceof PaginatedResultSet || is_array($mixed)) {
            foreach ($mixed as $item) {
                $this->recursion($item);
            }
        } elseif ($mixed instanceof EntityInterface) {
            $serializableAssocation = new SerializableAssociation($mixed);

            $mixed = $this->resource($mixed, $serializableAssocation);

            foreach ($serializableAssocation->getAssociations() as $value) {
                $this->recursion($value);
            }
        }

        return $mixed;
    }

    /**
     * JSON-LD array for collection requests
     *
     * @param mixed $jsonLd the data to be converted into a JSON-LD array
     * @return array
     */
    private function collection(mixed $jsonLd): array
    {
        $return = [];

        try {
            if ($jsonLd instanceof PaginatedResultSet) {
                $entity = $jsonLd->toArray()[0];
            } else {
                $entity = $jsonLd->first();
            }

            if ($entity instanceof JsonLdDataInterface) {
                $return['@context'] = $entity->getJsonLdContext();
            }
        } catch (ReflectionException $e) {
        }

        if ($this->request instanceof ServerRequest) {
            $return['@id'] = $this->request->getPath();
        }

        $return['@type'] = $this->hydra . 'Collection';
        $return[$this->hydra . 'pageItems'] = intval($jsonLd->count());
        $return[$this->hydra . 'totalItems'] = null;

        if ($this->paginator instanceof PaginatorHelper) {
            $url = (string)$this->request->getUri();
            $id = parse_url($url, PHP_URL_PATH);
            $query = parse_url($url, PHP_URL_QUERY);

            if (!empty($query)) {
                $id .= '?' . $query;
            }

            $return['view'] = [
                '@id' => $id,
                '@type' => 'PartialCollectionView',
                $this->hydra . 'next' => $this->paginator->next(),
                $this->hydra . 'prev' => $this->paginator->prev(),
                $this->hydra . 'first' => $this->paginator->first(),
                $this->hydra . 'last' => $this->paginator->last(),
            ];
            $return[$this->hydra . 'totalItems'] = intval($this->paginator->counter());
        }

        $return[$this->hydra . 'member'] = $jsonLd;

        return $return;
    }

    /**
     * JSON-LD array for item requests
     *
     * @param mixed $jsonLd the data to be converted into a JSON-LD array
     * @return array
     */
    private function item(mixed $jsonLd): array
    {
        $links = [];

        if ($this->request instanceof ServerRequest) {
            $links['@id'] = $this->request->getPath();
        }

        if ($jsonLd instanceof JsonLdDataInterface) {
            $links['@type'] = $jsonLd->getJsonLdType();
            $links['@context'] = $jsonLd->getJsonLdContext();
        }

        if (!is_array($jsonLd)) {
            $jsonLd = $jsonLd->toArray();
        }

        return array_merge($links, $jsonLd);
    }

    /**
     * Creates a JSON-LD Resource
     *
     * Requires an instance of Cake\ORM\Entity or EntityInterface and a SerializableAssociation instance
     *
     * @param \Cake\Datasource\EntityInterface $entity Cake\ORM\Entity or EntityInterface
     * @param \MixerApi\Core\View\SerializableAssociation $serializable SerializableAssociation
     * @return \Cake\Datasource\EntityInterface
     */
    private function resource(EntityInterface $entity, SerializableAssociation $serializable): EntityInterface
    {
        foreach ($serializable->getAssociations() as $property => $value) {
            if (!is_array($value) && !$value instanceof EntityInterface) {
                $entity->unset($property);
            }
        }

        if ($entity instanceof JsonLdDataInterface) {
            $entity->set('@id', $entity->getJsonLdIdentifier($entity));
            $entity->set('@type', $entity->getJsonLdType());
            $entity->set('@context', $entity->getJsonLdContext());
        }

        return $entity;
    }
}
