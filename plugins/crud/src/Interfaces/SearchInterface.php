<?php
declare(strict_types=1);

namespace MixerApi\Crud\Interfaces;

use Cake\Controller\Controller;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Query;

/**
 * @experimental
 */
interface SearchInterface
{
    /**
     * Performs the search and returns a ResultSetInterface suitable for CakePHP view rendering
     *
     * @param \Cake\Controller\Controller $controller the cakephp controller instance
     * @return \Cake\Datasource\ResultSetInterface
     */
    public function search(Controller $controller): ResultSetInterface;

    /**
     * Builds a Query object and returns it
     *
     * @param \Cake\Controller\Controller $controller the cakephp controller instance
     * @return \Cake\ORM\Query
     */
    public function query(Controller $controller): Query;

    /**
     * @see https://github.com/FriendsOfCake/search
     * @param string $collection the cakephp search collection to use
     * @return $this
     */
    public function setCollection(string $collection);

    /**
     * @param string $table the table
     * @return $this
     */
    public function setTableName(string $table);

    /**
     * @param string|array $methods allowed http method(s)
     * @return $this
     */
    public function setAllowMethod($methods);
}
