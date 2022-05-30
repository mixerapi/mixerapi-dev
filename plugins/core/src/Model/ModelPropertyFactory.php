<?php
declare(strict_types=1);

namespace MixerApi\Core\Model;

use Cake\Database\Schema\TableSchema;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Builds ModelProperty
 *
 * @see ModelProperty
 */
class ModelPropertyFactory
{
    /**
     * @param \Cake\Database\Schema\TableSchema $schema cake TableSchema instance
     * @param \Cake\ORM\Table $table cake Table instance
     * @param string $columnName the tables column name
     * @param \Cake\Datasource\EntityInterface $entity EntityInterface
     */
    public function __construct(
        private TableSchema $schema,
        private Table $table,
        private string $columnName,
        private EntityInterface $entity
    ) {
    }

    /**
     * @return \MixerApi\Core\Model\ModelProperty
     */
    public function create()
    {
        $vars = $this->schema->__debugInfo();
        $default = $vars['columns'][$this->columnName]['default'] ?? '';

        return (new ModelProperty())
            ->setName($this->columnName)
            ->setType($this->schema->getColumnType($this->columnName))
            ->setDefault((string)$default)
            ->setIsPrimaryKey($this->isPrimaryKey($vars, $this->columnName))
            ->setIsHidden(in_array($this->columnName, $this->entity->getHidden()))
            ->setIsAccessible($this->isAccessible())
            ->setValidationSet($this->table->validationDefault(new Validator())->field($this->columnName));
    }

    /**
     * @param array $schemaDebugInfo debug array from TableSchema
     * @param string $columnName column name
     * @return bool
     */
    private function isPrimaryKey(array $schemaDebugInfo, string $columnName): bool
    {
        // ignore coverage since this condition should not be met
        if (!isset($schemaDebugInfo['constraints']['primary']['columns'])) {
            // @codeCoverageIgnoreStart
            return false;
            // @codeCoverageIgnoreEnd
        }

        return in_array($columnName, $schemaDebugInfo['constraints']['primary']['columns']);
    }

    /**
     * Returns accessibility of the property.
     *
     * @link https://book.cakephp.org/4/en/orm/entities.html#mass-assignment
     * @return bool
     */
    private function isAccessible(): bool
    {
        $accessible = $this->entity->getAccessible();
        if (isset($accessible[$this->columnName]) && is_bool($accessible[$this->columnName])) {
            return $accessible[$this->columnName];
        }

        if (isset($accessible['*']) && is_bool($accessible['*'])) {
            return $accessible['*'];
        }

        return false;
    }
}
