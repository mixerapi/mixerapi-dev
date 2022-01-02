<?php
declare(strict_types=1);

namespace MixerApi\Rest\Test\App\Controller;

/**
 * Countries Controller
 *
 * @property \App\Model\Table\CountriesTable $Countries
 * @method \App\Model\Entity\Country[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CountriesController extends AppController
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
        $countries = $this->paginate($this->Countries);

        $this->set(compact('countries'));
        $this->viewBuilder()->setOption('serialize', 'countries');
    }

    /**
     * View method
     *
     * @param string|null $id Country id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
     */
    public function view($id = null)
    {
        $this->request->allowMethod('get');

        $country = $this->Countries->get($id, [
            'contain' => ['Cities'],
        ]);

        $this->set('country', $country);
        $this->viewBuilder()->setOption('serialize', 'country');
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
        $country = $this->Countries->newEmptyEntity();
        $country = $this->Countries->patchEntity($country, $this->request->getData());
        if ($this->Countries->save($country)) {
            $this->viewBuilder()->setOption('serialize', 'country');
            return;
        }
        throw new \Exception("Record not created");
    }

    /**
     * Edit method
     *
     * @param string|null $id Country id.
     * @return \Cake\Http\Response|null|void HTTP 200 on successful edit
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
     * @throws \Exception
     */
    public function edit($id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
        $country = $this->Countries->get($id, [
            'contain' => [],
        ]);
        $country = $this->Countries->patchEntity($country, $this->request->getData());
        if ($this->Countries->save($country)) {
            $this->viewBuilder()->setOption('serialize', 'country');
            return;
        }
        throw new \Exception("Record not saved");
    }

    /**
     * Delete method
     *
     * @param string|null $id Country id.
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
/*        $country = $this->Countries->get($id);
        if ($this->Countries->delete($country)) {
            return $this->response->withStatus(204);
        }
        throw new \Exception("Record not deleted");*/
    }
}
