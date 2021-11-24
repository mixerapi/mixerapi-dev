<?php
declare(strict_types=1);

namespace MixerApi\JsonLdView\Controller\Component;

use Cake\Collection\Collection;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Database\Connection;
use Cake\Datasource\ConnectionManager;
use MixerApi\Core\Model\Model;
use MixerApi\Core\Model\ModelFactory;
use MixerApi\Core\Model\ModelProperty;
use MixerApi\Core\Utility\NamespaceUtility;
use MixerApi\JsonLdView\JsonLdDataInterface;
use MixerApi\JsonLdView\JsonLdEntityContext;
use MixerApi\JsonLdView\JsonLdSchema;
use ReflectionClass;
use RuntimeException;

/**
 * Builds JSON-LD vocab for entities in your API.
 *
 * @link https://json-ld.org/learn.html
 * @uses \Cake\Collection\Collection
 * @uses \MixerApi\Core\Model\ModelFactory
 * @uses \MixerApi\Core\Utility\NamespaceUtility
 * @uses \MixerApi\JsonLdView\JsonLdEntityContext
 * @uses ReflectionClass
 */
class JsonLdVocabComponent extends Component
{
    private ?array $data;

    private string $hydraPrefix = '';

    private ?array $config;

    private string $hydra = '';

    /**
     * @param \Cake\Controller\ComponentRegistry $registry ComponentRegistry
     * @param array $config configurations
     */
    public function __construct(ComponentRegistry $registry, array $config = [])
    {
        parent::__construct($registry, $config);

        $this->config = Configure::read('JsonLdView');
        if ($this->config['isHydra']) {
            $this->hydra = 'hydra:';
        }

        $this->data = [
            '@contexts' => [
                '@vocab' => $this->config['vocabUrl'],
                'rdf' => 'http://www.w3.org/1999/02/22-rdf-syntax-ns#',
                'rdfs' => 'http://www.w3.org/2000/01/rdf-schema#',
                'xmls' => 'http://www.w3.org/2001/XMLSchema#',
                'owl' => 'http://www.w3.org/2002/07/owl#',
                'schema' => $this->config['schemaUrl'],
            ],
            '@id' => $this->getController()->getRequest()->getPath(),
            '@type' => $this->hydraPrefix . 'ApiDocumentation',
            $this->hydra . 'title' => $this->config['title'],
            $this->hydra . 'description' => $this->config['description'],
            $this->hydra . 'supportedClass' => [],
        ];
    }

    /**
     * Returns the entity in JSON-LD form as an array
     *
     * @return array
     * @throws \ReflectionException
     */
    public function build(): array
    {
        $connection = ConnectionManager::get('default');

        if (!$connection instanceof Connection) {
            throw new RuntimeException('Unable to get Database Connection instance');
        }

        $tables = NamespaceUtility::findClasses(Configure::read('App.namespace') . '\Model\Table');

        foreach ($tables as $table) {
            $model = (new ModelFactory($connection, new $table()))->create();
            if ($model === null) {
                continue;
            }

            $supportedClass = $this->buildSupportedClass($model);
            if ($supportedClass === null) {
                continue;
            }

            $this->data[$this->hydra . 'supportedClass'][] = $supportedClass;
        }

        if ($this->config['isHydra']) {
            $this->data['@contexts']['hydra'] = 'http://www.w3.org/ns/hydra/core#';
        }

        return $this->data;
    }

    /**
     * @param \MixerApi\Core\Model\Model $model an instance of Model
     * @return array|null
     * @throws \ReflectionException
     */
    private function buildSupportedClass(Model $model): ?array
    {
        $entity = $model->getEntity();

        if (!$entity instanceof JsonLdDataInterface) {
            return null;
        }

        $defaultMappings = (new JsonLdEntityContext($model))->build();

        $supportedClass = [
            '@id' => $entity->getJsonLdType(),
            '@type' => $this->hydraPrefix . 'Class',
            $this->hydra . 'title' => (new ReflectionClass(get_class($entity)))->getShortName(),
        ];

        foreach ($model->getProperties() as $property) {
            $schemaUrl = $defaultMappings[$property->getName()] ?? null;
            $schemaDescription = null;

            $jsonLdSchema = $this->findJsonLdSchema($entity, $property);
            if ($jsonLdSchema !== null) {
                $schemaUrl = $jsonLdSchema->getSchemaUrl();
                $schemaDescription = $jsonLdSchema->getDescription();
            }

            $supportedClass[$this->hydra . 'supportedProperty'][] = [
                '@type' => $this->hydra . 'supportedProperty',
                $this->hydra . 'property' => [
                    '@id' => $schemaUrl,
                    '@type' => 'rdf:Property',
                    'rdfs:label' => $property->getName(),
                    'domain' => $entity->getJsonLdType(),
                    'range' => 'xmls:' . $property->getType(),
                ],
                $this->hydra . 'title' => $property->getName(),
                $this->hydra . 'required' => $this->isPropertyRequired($property),
                $this->hydra . 'readable' => true,
                $this->hydra . 'writeable' => $this->isPropertyWriteable($property),
                $this->hydra . 'description' => $schemaDescription,
            ];
        }

        return $supportedClass;
    }

    /**
     * @param \MixerApi\JsonLdView\JsonLdDataInterface $entity JsonLdDataInterface
     * @param \MixerApi\Core\Model\ModelProperty $property ModelProperty
     * @return \MixerApi\JsonLdView\JsonLdSchema|null
     */
    private function findJsonLdSchema(JsonLdDataInterface $entity, ModelProperty $property): ?JsonLdSchema
    {
        $results = (new Collection($entity->getJsonLdSchemas()))->filter(
            function (JsonLdSchema $schema) use ($property) {
                return $schema->getProperty() == $property->getName();
            }
        );

        return $results->first();
    }

    /**
     * @param \MixerApi\Core\Model\ModelProperty $property ModelProperty
     * @return bool
     */
    private function isPropertyRequired(ModelProperty $property)
    {
        $validationSet = $property->getValidationSet();
        if (is_bool($validationSet->isPresenceRequired())) {
            return $validationSet->isPresenceRequired();
        }
        if (strtoupper($validationSet->isPresenceRequired()) === 'UPDATE') {
            return true;
        }

        return false;
    }

    /**
     * @param \MixerApi\Core\Model\ModelProperty $property ModelProperty
     * @return bool
     */
    private function isPropertyWriteable(ModelProperty $property)
    {
        if ($property->isPrimaryKey()) {
            return false;
        }

        $isTimeBehaviorField = in_array($property->getName(), ['created','modified']);
        $isDateTimeField = in_array($property->getType(), ['date','datetime','timestamp']);

        if ($isTimeBehaviorField && $isDateTimeField) {
            return false;
        }

        return true;
    }
}
