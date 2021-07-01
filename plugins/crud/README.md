# MixerApi CRUD

![Stability][ico-stability]
[![Latest Version][ico-version]][link-version]
[![Build Status][ico-build]][link-build]
[![Coverage Status][ico-coverage]][link-coverage]
[![Mixerapi][ico-mixerapi]][link-mixerapi]
[![CakePHP][ico-cakephp]][link-cakephp]
[![PHP][ico-php]][link-php]
[![License: MIT][ico-license]][link-license]

[ico-stability]: https://img.shields.io/badge/stability-experimental-orange.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/mixerapi/crud.svg?style=flat-square
[ico-build]: https://github.com/mixerapi/mixerapi-dev/workflows/Build/badge.svg?branch=master
[ico-coverage]: https://coveralls.io/repos/github/mixerapi/mixerapi-dev/badge.svg?branch=master
[ico-mixerapi]: https://mixerapi.com/assets/img/mixer-api-red.svg
[ico-cakephp]: https://img.shields.io/badge/cakephp-^4.2-red?logo=cakephp
[ico-php]: https://img.shields.io/badge/php-%3E%3D%207.2-8892BF.svg?logo=php
[ico-license]: https://img.shields.io/badge/License-MIT-yellow.svg


[link-version]: https://packagist.org/packages/mixerapi/crud
[link-build]: https://github.com/mixerapi/mixerapi-dev/actions?query=workflow%3ABuild
[link-coverage]: https://coveralls.io/github/mixerapi/mixerapi-dev?branch=master
[link-mixerapi]: https://mixerapi.com
[link-cakephp]: https://book.cakephp.org/4/en/index.html
[link-php]: https://php.net/
[link-license]: LICENSE.txt

This experimental plugin provides CRUD (Create/Read/Update/Delete) services to your RESTful APIs controller actions
using [CakePHP's dependency injection container](https://book.cakephp.org/4/en/development/dependency-injection.html)
for CakePHP ^4.2 compatible projects. Serialization and allowed requests `$this-request->allowMethod()` enforcement is
handled automatically by event listeners. Crud plays nicely with existing MixerApi plugins, Pagination, CakePHP Search
and may installed on its own too.

You may also want to look at [CakePHP Crud](https://crud.readthedocs.io/en/latest/installation.html) which doesn't
rely on experimental code. If you're using this plugin without MixerApi/ExceptionRender or for a non-API projects
[read below](#other-usages).

## Installation

```console
composer require mixerapi/crud
bin/cake plugin load MixerApi/Crud
```

Alternatively after composer installing you can manually load the plugin in your Application:

```php
# src/Application.php
public function bootstrap(): void
{
    $this->addPlugin('MixerApi/Crud');
}
```

See [Plugin Options](#plugin-options) for additional configurations.


## Usage

Once enabled, the following services may be injected into your controller actions.

```php
use MixerApi\Crud\Interfaces\{CreateInterface, ReadInterface, UpdateInterface, DeleteInterface, SearchInterface};
```

| Interface | Injected Service | Use-cases |
| ------------- | ------------- |  ------------- |
| CreateInterface | MixerApi\Crud\Service\Create | `add()` actions |
| ReadInterface | MixerApi\Crud\Service\Read | `view()` actions |
| UpdateInterface | MixerApi\Crud\Service\Update | `edit()` actions |
| DeleteInterface | MixerApi\Crud\Service\Delete | `delete()` actions |
| SearchInterface | MixerApi\Crud\Service\Search | `index()` actions |

All Crud services infer the table name from the controller, you can change the table name by calling the
`setTableName($name)` method.

If you are using MixerApi\ExceptionRender then an event will catch validation errors and handle the response for you,
otherwise a `MixerApi\Crud\Exception\ResourceWriteException` is thrown.

See below regarding [path parameters](#path-parameters) if your path parameter is not `id`.

### Create

```php
public function add(CreateInterface $create)
{
    $this->set('data', $create->save($this));
}
```

### Read

```php
public function view(ReadInteface $read)
{
    $this->set('data', $read->read($this));
}
```

### Update

```php
public function edit(UpdateInterface $update)
{
    $this->set('data', $update->save($this));
}
```

### Delete

```php
public function edit(DeleteInterface $delete)
{
    return $delete->delete($this)->respond(); // calling respond() is optional
}
```

### Search

The Search service works with [Pagination](https://book.cakephp.org/4/en/controllers/components/pagination.html) and
optionally with [CakePHP Search](https://github.com/FriendsOfCake/search).

Example:

```php
public function index(SearchInterface $search)
{
    $this->set('data', $search->search($this));
}
```

To use [CakePHP Search](https://github.com/FriendsOfCake/search) initialize the component as normal in your controllers
`initialize()` method.  For custom CakePHP Search collections call the `setCollection($name)` method:

```php
$this->set('data', $search->setCollection('collection_name')->search($this));
```

Return a CakePHP Query object instead:

```php
$query = $search->query($this);
```

## Serialization

Serialization is handled by a `Controller.beforeRender` listener. It serializes the first viewVar found for all CRUD
operations and will not run for non-crud operations. See [Options](#plugin-options) for disabling serialization.

## Allowed HTTP Methods

Allowed methods is handled by a `Controller.initialize` listener. See [Plugin Options](#plugin-options) for disabling or
modifying the defaults.

| Action | HTTP method(s) |
| ------------- | ------------- |
| index | get |
| view | get |
| add | post |
| edit | post, put, and patch |
| delete | delete |

You may also call `setAllowMethods($methods)` on any service to overwrite the default behavior. This accepts a string
or any array as an argument just like the native `$request->allowedMethods()`.

## Plugin Options

You may customize functionality by passing in an options array when adding the plugin.

```php
# src/Application.php

public function bootstrap(): void
{
    $this->addPlugin('MixerApi/Crud', $options);
}
```

Customize allowed HTTP methods:

```php
    $options = [
        'allowedMethods' => [
            'add' => ['post'],
            'edit' => ['patch'],
            'delete' => ['delete'],
        ]
    ];
```

To disable automatic `$request->allowMethod()` entirely:

```php
    $options = [
        'allowedMethods' => []
    ];
```

Disable automatic serialization:

```php
    $options = [
        'doSerialize' => false, // default is true
    ];
```

## Bake Theme

Crud comes with its own bake template for scaffolding your controllers, just add `--theme MixerApi/Crud`, example:

```console
bin/cake bake controller all --theme MixerApi/Crud
```

## Misc

#### Path Parameters

If your path parameter for the resource is not `id` then pass the identifier as the second argument:

```php
public function view(ReadInteface $read, string $id)
{
    $this->set('data', $read->read($this, $id));
}
```

The above also works for Update and Delete.

#### Other Usages

This plugin works best with API projects using MixerApi/ExceptionRender which uses events to set the response in the
event of an error. That's okay, you can write a custom exception renderer and look for `ResourceWriteException`, then
alter the `viewVars` output using the `EntityInterface` from `ResourceWriteException::getEntity()`.

Read the [CakePHP Custom ExceptionRenderer](https://book.cakephp.org/4/en/development/errors.html#custom-exceptionrenderer)
documentation for more information.
