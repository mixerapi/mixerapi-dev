<?php
declare(strict_types=1);

namespace MixerApi\Crud\Services;

use Cake\Controller\Controller;
use Cake\Core\Plugin;
use Cake\Datasource\Paging\PaginatedInterface;
use Cake\Datasource\Paging\PaginatedResultSet;
use Cake\ORM\Query;
use MixerApi\Crud\Interfaces\SearchInterface;

/**
 * Implements SearchInterface and provides basic search functionality.
 *
 * @experimental
 */
class Search implements SearchInterface
{
    use CrudTrait;

    /**
     * @var bool Does this application have https://github.com/FriendsOfCake/search
     */
    private bool $hasSearch;

    /**
     * @var string The search collection name
     */
    private string $collectionName = 'default';

    /**
     * @param \Cake\Core\Plugin|null $plugin CakePHP Plugin class to help find if the Search plugin is loaded.
     */
    public function __construct(
        ?Plugin $plugin = null
    ) {
        $this->hasSearch = ($plugin ?? new Plugin())::isLoaded('Search');
    }

    /**
     * @inheritDoc
     */
    public function search(Controller $controller): PaginatedResultSet|PaginatedInterface
    {
        $this->allowMethods($controller);

        return $controller->paginate(
            $this->query($controller)
        );
    }

    /**
     * @inheritDoc
     */
    public function query(Controller $controller): Query
    {
        $table = $controller->getTableLocator()->get($this->whichTable($controller));

        if (!$this->hasSearch || !$table->hasBehavior('Search')) {
            return $table->find('all');
        }

        return $table->find(
            'search',
            search: $controller->getRequest()->getQueryParams(),
            collection: $this->collectionName
        );
    }

    /**
     * @inheritDoc
     */
    public function setCollection(string $collection)
    {
        $this->collectionName = $collection;

        return $this;
    }
}
