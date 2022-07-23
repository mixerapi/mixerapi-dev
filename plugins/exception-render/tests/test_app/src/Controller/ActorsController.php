<?php
declare(strict_types=1);

namespace MixerApi\ExceptionRender\Test\App\Controller;

use Cake\Http\Exception\InternalErrorException;

class ActorsController extends AppController
{
    /**
     * Index method
     *
     * @Swag\SwagPaginator
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
     */
    public function index()
    {
        $this->request->allowMethod('get');
        $actors = $this->paginate($this->Actors, [
            'contain' => ['Films'],
            'limit' => 2
        ]);

        $this->set(compact('actors'));
        $this->viewBuilder()->setOption('serialize', 'actors');
    }

    /**
     * View method
     *
     * @param string|null $id Actor id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
     */
    public function view($id = null)
    {
        $this->request->allowMethod('get');

        $actor = $this->Actors->get($id, [
            'contain' => ['Films' => ['Inventories' => ['Stores']]],
        ]);

        $this->set('actor', $actor);
        $this->viewBuilder()->setOption('serialize', 'actor');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void HTTP 200 on successful add
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
     * @throws \Exception
     */
    public function add()
    {
        $this->request->allowMethod('post');
        $actor = $this->Actors->newEmptyEntity();
        $actor = $this->Actors->patchEntity($actor, $this->request->getData());
        if ($this->Actors->save($actor)) {
            $this->viewBuilder()->setOption('serialize', 'actor');
            $this->set('actor', $actor);
            return;
        }
        throw new \Exception("Record failed to save");
    }

    /**
     * Edit method
     *
     * @param string|null $id Actor id.
     * @return \Cake\Http\Response|null|void HTTP 200 on successful edit
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
     * @throws \Exception
     */
    public function edit($id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
        $actor = $this->Actors->get($id, [
            'contain' => [],
        ]);
        $actor = $this->Actors->patchEntity($actor, $this->request->getData());
        if ($this->Actors->save($actor)) {
            $this->set('actor', $actor);
            $this->viewBuilder()->setOption('serialize', 'actor');
            return;
        }
        throw new \Exception("Record not saved");
    }

    /**
     * Delete method
     *
     * @param string|null $id Actor id.
     * @return \Cake\Http\Response|null|void HTTP 204 on success
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
     * @throws \Exception
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);
        $actor = $this->Actors->get($id);
        if ($this->Actors->delete($actor)) {
            return $this->response->withStatus(204);
        }
        throw new \Exception("Record not deleted");
    }

    public function exception()
    {
        throw new InternalErrorException('testing');
    }
}
