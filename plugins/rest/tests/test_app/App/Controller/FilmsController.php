<?php
declare(strict_types=1);

namespace MixerApi\Rest\Test\App\Controller;

/**
 * Films Controller
 *
 * @property \App\Model\Table\FilmsTable $Films
 * @method \App\Model\Entity\Film[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FilmsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
     */
    public function index()
    {
        $this->request->allowMethod('get');
        $this->paginate = [
            'contain' => ['Languages'],
        ];
        $films = $this->paginate($this->Films);

        $this->set(compact('films'));
        $this->viewBuilder()->setOption('serialize', 'films');
    }

    /**
     * View method
     *
     * @param string|null $id Film id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
     */
    public function view($id = null)
    {
        $this->request->allowMethod('get');

        $film = $this->Films->get($id, [
            'contain' => ['Languages', 'FilmActors', 'FilmCategories', 'FilmTexts', 'Inventories'],
        ]);

        $this->set('film', $film);
        $this->viewBuilder()->setOption('serialize', 'film');
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
        $film = $this->Films->newEmptyEntity();
        $film = $this->Films->patchEntity($film, $this->request->getData());
        if ($this->Films->save($film)) {
            $this->viewBuilder()->setOption('serialize', 'film');
            $this->set('film', $film);
            return;
        }
        throw new \Exception("Record failed to save");
    }

    /**
     * Edit method
     *
     * @param string|null $id Film id.
     * @return \Cake\Http\Response|null|void HTTP 200 on successful edit
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
     * @throws \Exception
     */
    public function edit($id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
        $film = $this->Films->get($id, [
            'contain' => [],
        ]);
        $film = $this->Films->patchEntity($film, $this->request->getData());
        if ($this->Films->save($film)) {
            $this->set('film', $film);
            $this->viewBuilder()->setOption('serialize', 'film');
            return;
        }
        throw new \Exception("Record not saved");
    }

    /**
     * Delete method
     *
     * @param string|null $id Film id.
     * @return \Cake\Http\Response|null|void HTTP 204 on success
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
     * @throws \Exception
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);
        $film = $this->Films->get($id);
        if ($this->Films->delete($film)) {
            return $this->response->withStatus(204);
        }
        throw new \Exception("Record not deleted");
    }

    public function actors()
    {
        $this->request->allowMethod('get');
        $this->paginate = [
            'contain' => ['FilmActors' => ['Actors']],
        ];
        $films = $this->paginate($this->Films);

        $this->set(compact('films'));
        $this->viewBuilder()->setOption('serialize', 'films');
    }
}
