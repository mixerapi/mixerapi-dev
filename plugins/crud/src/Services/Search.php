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

class Search implements SearchInterface
{
    use CrudTrait;

    /**
     * @var \Cake\ORM\Locator\LocatorInterface
     */
    private $locator;

    /**
     * Does this application have https://github.com/FriendsOfCake/search
     *
     * @var bool
     */
    private $hasSearch;

    /**
     * The search collection name
     *
     * @var string
     */
    private $collectionName = 'default';

    /**
     * @param \Cake\ORM\Locator\LocatorInterface|null $locator locator
     * @param \Cake\Core\Plugin|null $plugin plugin
     */
    public function __construct(?LocatorInterface $locator = null, ?Plugin $plugin = null)
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
