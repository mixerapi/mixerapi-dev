<?php
declare(strict_types=1);

namespace MixerApi\Crud\Services;

use Cake\Controller\Controller;
use Cake\Core\Plugin;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Locator\LocatorInterface;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
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
     * @param \Cake\ORM\Locator\LocatorInterface|null $locator LocatorInterface to locate the table.
     * @param \Cake\Core\Plugin|null $plugin CakePHP Plugin class to help find if the Search plugin is loaded.
     */
    public function __construct(private ?LocatorInterface $locator = null, ?Plugin $plugin = null)
    {
        $this->locator = $locator ?? TableRegistry::getTableLocator();
        $this->hasSearch = ($plugin ?? new Plugin())::isLoaded('Search');
    }

    /**
     * @inheritDoc
     */
    public function search(Controller $controller): ResultSetInterface
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
        $table = $this->locator->get($this->whichTable($controller));

        if (!$this->hasSearch || !$table->hasBehavior('Search')) {
            return $table->find('all');
        }

        return $table->find('search', [
            'search' => $controller->getRequest()->getQueryParams(),
            'collection' => $this->collectionName,
        ]);
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
