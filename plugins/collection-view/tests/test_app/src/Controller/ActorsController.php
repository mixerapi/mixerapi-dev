<?php
declare(strict_types=1);

namespace TestApp\Controller;

class ActorsController extends AppController
{
    public function index()
    {
        $this->request->allowMethod('get');
        $actors = $this->paginate($this->Actors);
        $this->set(compact('actors'));
        $this->viewBuilder()->setOption('serialize', 'actors');
    }
}
