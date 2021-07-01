<?php
declare(strict_types=1);

namespace MixerApi\Crud\Test\App\Controller;

use MixerApi\Crud\Interfaces\{CreateInterface, ReadInterface, UpdateInterface, DeleteInterface, SearchInterface};

class ActorsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }

    public function index(SearchInterface $search)
    {
        $this->set('data', $search->search($this));
    }

    public function index_fail(SearchInterface $search)
    {
        $this->set('data', $search->setAllowMethod('nope')->search($this));
    }

    public function view(ReadInterface $read)
    {
        $this->set('data', $read->read($this));
    }

    public function add(CreateInterface $create)
    {
        $this->set('data', $create->save($this));
    }

    public function edit(UpdateInterface $update)
    {
        $this->set('data', $update->save($this));
    }
    
    public function delete(DeleteInterface $delete)
    {
        return $delete->delete($this)->respond();
    }
}
