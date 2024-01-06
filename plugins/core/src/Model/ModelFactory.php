<?php
declare(strict_types=1);

namespace MixerApi\Core\Model;

use Cake\Database\Connection;
use Cake\ORM\Table;

/**
 * Builds a Model
 *
 * @see Model
 */
class ModelFactory
{
    /**
     * @param \Cake\Database\Connection $connection db connection instance
     * @param \Cake\ORM\Table $table Table instance
     */
    public function __construct(private Connection $connection, private Table $table)
    {
    }

    /**
     * @return \MixerApi\Core\Model\Model|null
     */
    public function create(): ?Model
    {
        $entityFqn = $this->table->getEntityClass();

        /** @var \Cake\Database\Schema\TableSchema $tableSchema */
        $tableSchema = $this->connection->getSchemaCollection()->describe($this->table->getTable());

        return new Model($tableSchema, $this->table, new $entityFqn());
    }
}
