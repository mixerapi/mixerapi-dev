# MixerAPI Bake

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mixerapi/bake.svg?style=flat-square)](https://packagist.org/packages/mixerapi/bake)
[![Build](https://github.com/mixerapi/bake/workflows/Build/badge.svg?branch=master)](https://github.com/mixerapi/bake)
[![Coverage Status](https://coveralls.io/repos/github/mixerapi/bake/badge.svg?branch=master)](https://coveralls.io/github/mixerapi/bake?branch=master)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE.txt)
[![MixerApi](https://mixerapi.com/assets/img/mixer-api-red.svg)](http://mixerapi.com)
[![CakePHP](https://img.shields.io/badge/cakephp-%3E%3D%204.0-red?logo=cakephp)](https://book.cakephp.org/4/en/index.html)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.2-8892BF.svg?logo=php)](https://php.net/)

Bake RESTful CakePHP controllers in seconds with this API focused bake template. Read more at 
[MixerAPI.com](https://mixerapi.com).

## Installation 

!!! note ""
    You can skip this step if MixerAPI is installed.

```console
composer require mixerapi/bake
bin/cake plugin load MixerApi/Bake
```

Alternatively after composer installing you can manually load the plugin in your Application:

```php
# src/Application.php
public function bootstrap(): void
{
    // other logic...
    $this->addPlugin('MixerApi/Bake');
}
```

## Usage

Add `--theme MixerApi/Bake` to your bake commands.

Bake all your controllers:
 
```console
bin/cake bake controller all --theme MixerApi/Bake
```

Bake a single controller:

```console
bin/cake bake controller {ControllerName} --theme MixerApi/Bake
```

Bake everything (theme only impacts controllers): 

```console
bin/cake bake all --everything --theme MixerApi/Bake
```

<details><summary>View sample controller</summary>
  <p>
  
```php
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
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
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
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
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
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
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
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
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
     * @throws \Cake\Datasource\Exception\MethodNotAllowedException When invalid method
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
    
```
</p>
</details>

## Unit Tests

```console
vendor/bin/phpunit
```

## Code Standards

```console
composer check
```
