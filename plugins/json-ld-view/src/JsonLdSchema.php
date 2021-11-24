<?php
declare(strict_types=1);

namespace MixerApi\JsonLdView;

use InvalidArgumentException;

/**
 * Describes JSON-LD Schema for a property.
 */
class JsonLdSchema
{
    /**
     * @param string $property The entity property name
     * @param string $schemaUrl A URL that describes the property (e.g. https://schema.org/Person)
     * @param string|null $description A description of the property
     */
    public function __construct(
        private string $property,
        private string $schemaUrl,
        private ?string $description = null
    ) {
        $this->setSchemaUrl($this->schemaUrl);
    }

    /**
     * @return string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * @param string $property the name of the property
     * @return $this
     */
    public function setProperty(string $property)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * @return string
     */
    public function getSchemaUrl(): string
    {
        return $this->schemaUrl;
    }

    /**
     * @param string $schemaUrl a url describing the property
     * @return $this
     */
    public function setSchemaUrl(string $schemaUrl)
    {
        if (!filter_var($schemaUrl, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException("schema url must be a valid url, but `$schemaUrl` is not");
        }

        $this->schemaUrl = $schemaUrl;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description a description of the property
     * @return $this
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }
}
