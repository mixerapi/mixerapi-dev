<?php
declare(strict_types=1);

namespace MixerApi\Bake\Test\App\Controller;


/**
 * Departments Controller
 *
 * @property \MixerApi\Bake\Test\App\Model\Table\DepartmentsTable $Departments
 * @method \MixerApi\Bake\Test\App\Model\Entity\Department[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DepartmentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Http\Exception\MethodNotAllowedException When invalid method
     */
    public function index()
    {
        $this->request->allowMethod('get');
        $departments = $this->paginate($this->Departments);

        $this->set(compact('departments'));
        $this->viewBuilder()->setOption('serialize', 'departments');
    }

    /**
     * View method
     *
     * @param string|null $id Department id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     * @throws \Cake\Http\Exception\MethodNotAllowedException When invalid method
     */
    public function view($id = null)
    {
        $this->request->allowMethod('get');

        $department = $this->Departments->get($id, [
            'contain' => ['DepartmentEmployees'],
        ]);

        $this->set('department', $department);
        $this->viewBuilder()->setOption('serialize', 'department');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void HTTP 200 on successful add
     * @throws \Cake\Http\Exception\MethodNotAllowedException When invalid method
     * @throws \MixerApi\ExceptionRender\ValidationException
     * @throws \Exception
     */
    public function add()
    {
        $this->request->allowMethod('post');
        $department = $this->Departments->newEmptyEntity();
        $department = $this->Departments->patchEntity($department, $this->request->getData());
        if ($this->Departments->save($department)) {
            $this->set('department', $department);
            $this->viewBuilder()->setOption('serialize', 'department');

            return;
        }
        throw new \Exception("Record not created");
    }

    /**
     * Edit method
     *
     * @param string|null $id Department id.
     * @return \Cake\Http\Response|null|void HTTP 200 on successful edit
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     * @throws \Cake\Http\Exception\MethodNotAllowedException When invalid method
     * @throws \MixerApi\ExceptionRender\ValidationException
     * @throws \Exception
     */
    public function edit($id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
        $department = $this->Departments->get($id, [
            'contain' => [],
        ]);
        $department = $this->Departments->patchEntity($department, $this->request->getData());
        if ($this->Departments->save($department)) {
            $this->set('department', $department);
            $this->viewBuilder()->setOption('serialize', 'department');

            return;
        }
        throw new \Exception("Record not saved");
    }

    /**
     * Delete method
     *
     * @param string|null $id Department id.
     * @return \Cake\Http\Response|null|void HTTP 204 on success
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     * @throws \Cake\Http\Exception\MethodNotAllowedException When invalid method
     * @throws \Exception
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);
        $department = $this->Departments->get($id);
        if ($this->Departments->delete($department)) {
            return $this->response->withStatus(204);
        }
        throw new \Exception("Record not deleted");
    }
}
