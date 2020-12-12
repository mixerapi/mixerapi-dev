# Search

Paginateable search functionality is provided using [friendsofcake/search](https://github.com/FriendsOfCake/search). 
Please visit the [documentation](https://github.com/FriendsOfCake/search/tree/master/docs) for details.

!!! info ""
    Search is easy to integrate with your API and works out of the box for HTTP GET requests. You can document your APIs 
    search parameters in OpenAPI using the `@SwagSearch` annotation. Read more 
    [here](/cakephp-swagger-bake/docs/annotations/#swagsearch).
    
    
## Quick Example

Create a Search Filter Collection in `App\Model\Filter`:

```php
<?php
declare(strict_types=1);

namespace App\Model\Filter;

use Search\Model\Filter\FilterCollection;

class ActorsCollection extends FilterCollection
{
    public function initialize(): void
    {
        $this
            ->add('first_name', 'Search.Like', [
                'before' => true,
                'after' => true,
                'mode' => 'or',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['first_name'],
            ])
        ;
    }
}
```

Add the behavior to your Table classes initialize method: 

```php
public function initialize(array $config): void
{
    // ...other code
    $this->addBehavior('Search.Search');
    // ...other code
}
``` 

Modify your controller action to initialize the Search component, use the Search behavior and optionally annotate with 
SwagSearch to inform OpenAPI about the search options:

```php
<?php
declare(strict_types=1);

namespace App\Controller;

use SwaggerBake\Lib\Extension\CakeSearch\Annotation\SwagSearch;

class ActorsController extends AppController
{
    public function initialize() : void
    {
        parent::initialize();
        // ... other code
        $this->loadComponent('Search.Search', [
            'actions' => ['index'],
        ]);
        // ... other code
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
     * @SwagSearch(tableClass="\App\Model\Table\ActorsTable", collection="default")
     */
    public function index()
    {
        $this->request->allowMethod('get');
        $query = $this->Actors
            ->find('search', [
                'search' => $this->request->getQueryParams(),
                'collection' => 'default'
            ]);
        $actors = $this->paginate($query);
    
        $this->set(compact('actors'));
        $this->viewBuilder()->setOption('serialize', 'actors');
    }
}
```

Check out the demo for an example implementation.