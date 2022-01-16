<?php
declare(strict_types=1);

namespace MixerApi\Core\Model;

use Cake\Datasource\ConnectionInterface;
use Cake\ORM\Table;

/**
 * Builds a Model
 *
 * @see Model
 */
class ModelFactory
{
    /**
     * @param \Cake\Datasource\ConnectionInterface $connection db connection instance
     * @param \Cake\ORM\Table $table Table instance
     */
    public function __construct(private ConnectionInterface $connection, private Table $table)
    {
    }

    /**
     * @return \MixerApi\Core\Model\Model|null
     */
    public function create(): ?Model
    {
        $entityFqn = $this->table->getEntityClass();

        return new Model(
            $this->connection->getSchemaCollection()->describe($this->table->getTable()),
            $this->table,
            new $entityFqn()
        );
    }
}
