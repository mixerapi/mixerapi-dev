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
     * @var string Column (field) name from the database definition
     */
    private string $name = '';

    /**
     * @var string Data type from the database definition
     */
    private string $type = '';

    /**
     * @var string Default value from the database definition
     */
    private string $default = '';

    /**
     * @var bool Is this column a primary key (using db definition)
     */
    private bool $isPrimaryKey = false;

    /**
     * @var bool Should this field be hidden from responses (using CakePHP Entity $_hidden)
     */
    private bool $isHidden = false;

    /**
     * @var bool The mass assignment of this field (using CakePHP Entity $_accessible)
     */
    private bool $isAccessible = false;

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
     * @return bool
     */
    public function isHidden(): bool
    {
        return $this->isHidden;
    }

    /**
     * @param bool $isHidden Is this property readable in responses
     * @return $this
     */
    public function setIsHidden(bool $isHidden)
    {
        $this->isHidden = $isHidden;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAccessible(): bool
    {
        return $this->isAccessible;
    }

    /**
     * @param bool $isAccessible Is this property writable in requests
     * @return $this
     */
    public function setIsAccessible(bool $isAccessible)
    {
        $this->isAccessible = $isAccessible;

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
