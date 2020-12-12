<?php
declare(strict_types=1);

namespace MixerApi\JsonLdView;

use Cake\Validation\ValidationRule;
use MixerApi\Core\Model\ModelProperty;

class SchemaMapper
{
    private const PRIMARY_KEY = 'https://schema.org/identifier';
    private const NUMBER = 'https://schema.org/Number';
    private const FLOAT = 'https://schema.org/Float';
    private const TEXT = 'https://schema.org/Text';
    private const DATE = 'https://schema.org/Date';
    private const TIME = 'https://schema.org/Time';
    private const DATE_TIME = 'https://schema.org/DateTime';
    private const BOOLEAN = 'https://schema.org/Boolean';

    /**
     * Please submit PRs for missing/inaccurate schemas
     *
     * @var string[]
     */
    private const VALIDATION_SCHEMAS = [
        'creditCard' => 'https://schema.org/CreditCard',
        'date' => self::DATE,
        'datetime' => self::DATE_TIME,
        'email' => 'https://schema.org/email',
        'geoCoordinate' => 'https://schema.org/GeoCoordinates',
        'latitude' => 'https://schema.org/latitude',
        'longitude' => 'https://schema.org/longitude',
        'money' => 'https://schema.org/MonetaryAmount',
        'time' => self::TIME,
        'url' => 'https://schema.org/url',
    ];

    /**
     * Please submit PRs for missing/inaccurate schemas
     *
     * @var string[]
     */
    private const DB_SCHEMAS = [
        'int' => self::NUMBER,
        'integer' => self::NUMBER,
        'smallinteger' => self::NUMBER,
        'biginteger' => self::NUMBER,
        'mediuminteger' => self::NUMBER,
        'decimal' => self::FLOAT,
        'text' => self::TEXT,
        'varchar' => self::FLOAT,
        'char' => self::FLOAT,
        'date' => self::DATE,
        'time' => self::TIME,
        'datetime' => self::DATE_TIME,
        'tinyint' => self::BOOLEAN,
        'boolean' => self::BOOLEAN,
        'bool' => self::BOOLEAN,
    ];

    /**
     * Returns a schema.org url based on table validations. This will return the first one it finds or null.
     *
     * @param \MixerApi\Core\Model\ModelProperty $property mixerapi ModelProperty
     * @return string
     */
    public static function findSchemaFromModelProperty(ModelProperty $property): string
    {
        foreach (self::VALIDATION_SCHEMAS as $rule => $schema) {
            if ($property->getValidationSet()->rule($rule) instanceof ValidationRule) {
                return $schema;
            }
        }

        if ($property->isPrimaryKey()) {
            return self::PRIMARY_KEY;
        }

        foreach (self::DB_SCHEMAS as $type => $schema) {
            if ($property->getType() === $type) {
                return $schema;
            }
        }

        return self::TEXT;
    }
}
