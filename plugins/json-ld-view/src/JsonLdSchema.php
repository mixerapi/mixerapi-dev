<?php
declare(strict_types=1);

namespace MixerApi\JsonLdView;

class JsonLdSchema
{
    /**
     * The entity property name
     *
     * @var string
     */
    private $property;

    /**
     * A URL that describes the property
     *
     * @example https://schema.org/Person
     * @var string
     */
    private $schemaUrl;

    /**
     * A description of the property
     *
     * @var string
     */
    private $description = '';

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
            throw new \InvalidArgumentException("schema url must be a valid url, but `$schemaUrl` is not");
        }

        $this->schemaUrl = $schemaUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
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
