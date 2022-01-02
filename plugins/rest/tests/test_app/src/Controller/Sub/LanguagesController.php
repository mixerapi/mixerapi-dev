<?php
declare(strict_types=1);

namespace MixerApi\Rest\Test\App\Controller\Sub;

use MixerApi\Rest\Test\App\Controller\AppController;
use SwaggerBake\Lib\Annotation as Swag;

/**
 * Languages Controller
 *
 * This is an example of using a prefix and scoped route
 *
 * @property \App\Model\Table\LanguagesTable $Languages
 * @method \App\Model\Entity\Language[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LanguagesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
     * @Swag\SwagPaginator()
     */
    public function index()
    {
        $this->request->allowMethod('get');
        $languages = $this->paginate($this->Languages);

        $this->set(compact('languages'));
        $this->viewBuilder()->setOption('serialize', 'languages');
    }

    /**
     * View method
     *
     * @param string|null $id Language id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
     */
    public function view($id = null)
    {
        $this->request->allowMethod('get');

        $language = $this->Languages->get($id, [
            'contain' => ['Films'],
        ]);

        $this->set('language', $language);
        $this->viewBuilder()->setOption('serialize', 'language');
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
        $language = $this->Languages->newEmptyEntity();
        $language = $this->Languages->patchEntity($language, $this->request->getData());
        if ($this->Languages->save($language)) {
            $this->set('language', $language);
            $this->viewBuilder()->setOption('serialize', 'language');
            return;
        }
        throw new \Exception("Record not created");
    }

    /**
     * Edit method
     *
     * @param string|null $id Language id.
     * @return \Cake\Http\Response|null|void HTTP 200 on successful edit
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
     * @throws \Exception
     */
    public function edit($id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
        $language = $this->Languages->get($id, [
            'contain' => [],
        ]);
        $language = $this->Languages->patchEntity($language, $this->request->getData());
        if ($this->Languages->save($language)) {
            $this->set('language', $language);
            $this->viewBuilder()->setOption('serialize', 'language');
            return;
        }
        throw new \Exception("Record not saved");
    }

    /**
     * Delete method
     *
     * @param string|null $id Language id.
     * @return \Cake\Http\Response|null|void HTTP 204 on success
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
     * @throws \Exception
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);
        $response = $this->response->withHeader('_demo_mode_', 'DELETES ARE DISABLED IN DEMO MODE');
        return $response->withStatus(422);
        /*
        $this->request->allowMethod(['delete']);
        $language = $this->Languages->get($id);
        if ($this->Languages->delete($language)) {
            return $this->response->withStatus(204);
        }
        throw new \Exception("Record not deleted");
        */
    }
}
