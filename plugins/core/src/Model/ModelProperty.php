<?php
declare(strict_types=1);

namespace MixerApi\Core\Model;

use Cake\Validation\ValidationSet;

/**
 * This acts as a decorator of sorts for CakePHP model properties. It provides an object-oriented way to access data
 * about an entities properties and validation rule sets applied to the specific database field.
 */
class ModelProperty
{
    /**
     * @var string
     */
    private string $name = '';

    /**
     * @var string
     */
    private string $type = '';

    /**
     * @var string
     */
    private string $default = '';

    /**
     * @var bool
     */
    private bool $isPrimaryKey = false;

    /**
     * @var \Cake\Validation\ValidationSet|null
     */
    private ?ValidationSet $validationSet;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name Property name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type Property data type (string, integer, etc.)
     * @return $this
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getDefault(): string
    {
        return $this->default;
    }

    /**
     * @param string $default Default value for the property
     * @return $this
     */
    public function setDefault(string $default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPrimaryKey(): bool
    {
        return $this->isPrimaryKey;
    }

    /**
     * @param bool $isPrimaryKey Is this property a primary key?
     * @return $this
     */
    public function setIsPrimaryKey(bool $isPrimaryKey)
    {
        $this->isPrimaryKey = $isPrimaryKey;

        return $this;
    }

    /**
     * @return \Cake\Validation\ValidationSet|null
     */
    public function getValidationSet(): ?ValidationSet
    {
        return $this->validationSet;
    }

    /**
     * @param \Cake\Validation\ValidationSet $validationSet cake ValidationSet instance
     * @return $this
     */
    public function setValidationSet(ValidationSet $validationSet)
    {
        $this->validationSet = $validationSet;

        return $this;
    }
}
