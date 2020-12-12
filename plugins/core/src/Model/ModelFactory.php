<?php
declare(strict_types=1);

namespace MixerApi\Core\Model;

use Cake\Datasource\ConnectionInterface;
use Cake\ORM\Table;

class ModelFactory
{
    /**
     * @var \Cake\Datasource\ConnectionInterface
     */
    private $connection;

    /**
     * @var \Cake\ORM\Table
     */
    private $table;

    /**
     * @param \Cake\Datasource\ConnectionInterface $connection db connection instance
     * @param \Cake\ORM\Table $table Table instance
     */
    public function __construct(ConnectionInterface $connection, Table $table)
    {
        $this->connection = $connection;
        $this->table = $table;
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
