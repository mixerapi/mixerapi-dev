<?php
declare(strict_types=1);

namespace MixerApi\JsonLdView;

use MixerApi\Core\Model\Model;

/**
 * Provides context for a JSON-LD entity. This class will document schema.org values from the entities properties when
 * possible.
 *
 * @uses SchemaMapper
 */
class JsonLdEntityContext
{
    private Model $model;

    private array $data = [];

    /**
     * @param \MixerApi\Core\Model\Model $model an instance of Model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Returns $this->data which is a key-value array containing a property, schema.org url, and an optional
     * description.
     *
     * @return array
     */
    public function build(): array
    {
        $this->assignFromInterface();
        $this->assignFromValidations();

        return $this->data;
    }

    /**
     * @return void
     */
    private function assignFromInterface(): void
    {
        $entity = $this->model->getEntity();
        if (!$entity instanceof JsonLdDataInterface) {
            return;
        }

        $schemas = $entity->getJsonLdSchemas();
        foreach ($schemas as $schema) {
            $name = $schema->getProperty();
            $this->data[$name] = $schema->getSchemaUrl();
        }
    }

    /**
     * @return void
     */
    private function assignFromValidations(): void
    {
        foreach ($this->model->getProperties() as $property) {
            $name = $property->getName();
            if (isset($this->data[$name])) {
                continue;
            }

            $url = SchemaMapper::findSchemaFromModelProperty($property);

            if (is_string($url)) {
                $this->data[$name] = $url;
            }
        }
    }
}
