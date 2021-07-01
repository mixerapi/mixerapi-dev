<?php
declare(strict_types=1);

namespace MixerApi\Crud\Test\App\Controller;

use MixerApi\Crud\Interfaces\{CreateInterface, ReadInterface, UpdateInterface, DeleteInterface, SearchInterface};

class FilmsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Search.Search', [
            'actions' => ['index'],
            'modelClass' => 'Films'
        ]);
    }

    /**
     * Index method
     *
     * @param SearchInterface $search
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Http\Exception\MethodNotAllowedException When invalid method
     */
    public function index(SearchInterface $search)
    {
        $this->set('data', $search->setAllowMethod(['post','get'])->setCollection('default')->search($this));
    }
}
