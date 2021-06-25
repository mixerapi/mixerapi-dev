<?php
declare(strict_types=1);

namespace MixerApi\HalView;

use Cake\Collection\CollectionInterface;
use Cake\Datasource\EntityInterface;
use Cake\Http\ServerRequest;
use Cake\ORM\Entity;
use Cake\ORM\ResultSet;
use Cake\Utility\Inflector;
use Cake\View\Helper\PaginatorHelper;
use MixerApi\Core\View\SerializableAssociation;
use ReflectionClass;
use ReflectionException;
use RuntimeException;

/**
 * Creates a HAL+JSON resource
 *
 * @see https://tools.ietf.org/html/draft-kelly-json-hal-06
 */
class JsonSerializer
{
    /**
     * ServerRequest or null
     *
     * @var \Cake\Http\ServerRequest|null
     */
    private $request;

    /**
     * PaginatorHelper or null
     *
     * @var \Cake\View\Helper\PaginatorHelper|null
     */
    private $paginator;

    /**
     * HAL data array
     *
     * @var array
     */
    private $data;

    /**
     * If constructed without parameters collection meta data will not be added to HAL $data
     *
     * @param mixed $serialize the data to be converted into a HAL array
     * @param \Cake\Http\ServerRequest|null $request optional ServerRequest
     * @param \Cake\View\Helper\PaginatorHelper|null $paginator optional PaginatorHelper
     */
    public function __construct($serialize, ?ServerRequest $request = null, ?PaginatorHelper $paginator = null)
    {
        $this->request = $request;
        $this->paginator = $paginator;

        $hal = $this->recursion($serialize);

        if ($hal instanceof ResultSet) {
            $this->data = $this->collection($hal);
        } elseif (is_subclass_of($hal, Entity::class)) {
            $this->data = $this->item($hal);
        } else {
            $this->data = $serialize;
        }
    }

    /**
     * Serializes HAL data as hal+json
     *
     * @param int $jsonOptions JSON options see https://www.php.net/manual/en/function.json-encode.php
     * @return string
     * @throws \RuntimeException
     */
    public function asJson(int $jsonOptions = 0): string
    {
        $json = json_encode($this->data, $jsonOptions);

        if ($json === false) {
            throw new RuntimeException(json_last_error_msg(), json_last_error());
        }

        return $json;
    }

    /**
     * Get HAL data as an array
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Recursive method for converting mixed data into HAL. This method converts instances of Cake\ORM\Entity into
     * HAL resources, but does not serialize the data.
     *
     * @param mixed $mixed data to be serialized
     * @return array|\Cake\Datasource\EntityInterface|\Cake\ORM\ResultSet
     */
    private function recursion(&$mixed)
    {
        if ($mixed instanceof ResultSet || is_array($mixed)) {
            foreach ($mixed as $x => $item) {
                $this->recursion($item);
            }
        } elseif ($mixed instanceof EntityInterface) {
            $serializableAssociation = new SerializableAssociation($mixed);

            $mixed = $this->resource($mixed, $serializableAssociation);

            foreach ($serializableAssociation->getAssociations() as $property => $value) {
                $this->recursion($value);
            }
        }

        return $mixed;
    }

    /**
     * HAL array for collection requests
     *
     * @param \Cake\Collection\CollectionInterface $collection the data to be converted into a HAL array
     * @return array
     */
    private function collection(CollectionInterface $collection): array
    {
        try {
            $entity = $collection->first();
            $tableName = Inflector::tableize((new ReflectionClass($entity))->getShortName());
        } catch (ReflectionException $e) {
            $tableName = 'data';
        }

        $links = [];

        $return = [
            'count' => $collection->count(),
            'total' => null,
        ];

        if ($this->request instanceof ServerRequest) {
            $links = [
                'self' => ['href' => $this->request->getPath()],
            ];
        }

        if ($this->paginator instanceof PaginatorHelper) {
            $links = array_merge_recursive($links, [
                'next' => ['href' => $this->paginator->next()],
                'prev' => ['href' => $this->paginator->prev()],
                'first' => ['href' => $this->paginator->first()],
                'last' => ['href' => $this->paginator->last()],
            ]);
            $return['total'] = intval($this->paginator->counter());
        }

        $return['_links'] = $links;
        $return['_embedded'] = [$tableName => $collection];

        return $return;
    }

    /**
     * HAL array for item requests
     *
     * @param mixed $hal the data to be converted into a HAL array
     * @return array
     */
    private function item($hal): array
    {
        $links = [];

        if ($this->request instanceof ServerRequest) {
            $links = ['_links' => ['self' => $this->request->getPath()]];
        }

        if (!is_array($hal)) {
            $hal = $hal->toArray();
        }

        return array_merge($links, $hal);
    }

    /**
     * Creates a HAL+JSON Resource
     *
     * Requires an instance of Cake\ORM\Entity or EntityInterface and an EmbeddableHalResource instance
     *
     * @param \Cake\Datasource\EntityInterface $entity Cake\ORM\Entity or EntityInterface
     * @param \MixerApi\Core\View\SerializableAssociation $association SerializableAssociation
     * @return \Cake\Datasource\EntityInterface
     */
    private function resource(EntityInterface $entity, SerializableAssociation $association): EntityInterface
    {
        $embedded = [];

        foreach ($association->getAssociations() as $property => $value) {
            if (!is_array($value) && !$value instanceof EntityInterface) {
                continue;
            }
            $embedded[$property] = $value;
            $entity->unset($property);
        }

        if (!empty($embedded)) {
            $entity->set('_embedded', $embedded);
        }

        if ($entity instanceof HalResourceInterface) {
            $entity->set('_links', $entity->getHalLinks($entity));
        }

        return $entity;
    }
}
