# MixerApi REST

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mixerapi/cakephp-rest.svg?style=flat-square)](https://packagist.org/packages/mixerapi/cakephp-rest)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE.md)
[![Build](https://github.com/mixerapi/mixerapi-dev/workflows/Build/badge.svg?branch=master)](https://github.com/mixerapi/mixerapi-dev/actions?query=workflow%3ABuild)
[![Coverage Status](https://coveralls.io/repos/github/mixerapi/mixerapi-dev/badge.svg?branch=master)](https://coveralls.io/github/mixerapi/mixerapi-dev?branch=master)
[![MixerApi](https://mixerapi.com/assets/img/mixer-api-red.svg)](https://mixerapi.com)
[![CakePHP](https://img.shields.io/badge/cakephp-^4.0-red?logo=cakephp)](https://book.cakephp.org/4/en/index.html)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.2-8892BF.svg?logo=php)](https://php.net/)

This plugin gets your API project up and going quickly by creating routes for you. It can either:

- Build your `routes.php` file from a single command, or
- Automatically expose RESTful CRUD routes with a handy AutoRouter.

This plugin assumes you have already created models and controllers. For help with the latter check out
[MixerApi/Bake](https://github.com/mixerapi/bake). Check the official
[RESTful routing](https://book.cakephp.org/4/en/development/routing.html#restful-routing) documentation
for handling advanced routing scenarios not covered by this plugin.

Read more at [MixerAPI.com](https://mixerapi.com).

## Installation

!!! info ""
    You can skip this step if MixerAPI is installed.

```console
composer require mixerapi/rest
bin/cake plugin load MixerApi/Rest
```

Alternatively after composer installing you can manually load the plugin in your Application:

```php
# src/Application.php
public function bootstrap(): void
{
    // other logic...
    $this->addPlugin('MixerApi/Rest');
}
```

## AutoRouter

Creating routes is already pretty easy, but AutoRouter makes building CRUD routes effortless. This is great
if you are just getting started with building APIs in CakePHP.

In your `routes.php` simply add `\MixerApi\Rest\Lib\AutoRouter`:

```php
# config/routes.php
$routes->scope('/', function (RouteBuilder $builder) {
    // ... other routes
    (new AutoRouter($builder))->buildResources();
    // ... other routes
});
```

This will add routes for CRUD controller actions (index, add, edit, view, and delete). If your controller does not have
any CRUD methods, then the route will be skipped. AutoRouting works for plugins too:

```php
# in your plugins/{PluginName}/routes.php file
(new AutoRouter($builder, 'MyPlugin\Controller'))->buildResources();
```

## Create Routes

While AutoRouter makes life easy, it must scan your controllers to build RESTful resources. This has a slight
performance penalty. No worry, you can use `mixerapi:rest route create` to code your routes for you. This will write
routes directly to your routes.php file.

```console
# writes to `config/routes.php`
bin/cake mixerapi:rest route create
```

Use `--prefix` to specify a prefix:

```console
bin/cake mixerapi:rest route create --prefix /api
```

Use `--plugin` for plugins:

```console
# writes to `plugins/MyPlugin/config/routes.php`
bin/cake mixerapi:rest route create --plugin MyPlugin
```

To perform a dry-run use the `--display` option:

```console
bin/cake mixerapi:rest route create --display
```

For non-CRUD routes, sub-resources, and advanced routing please reference the CakePHP
[RESTful routing](https://book.cakephp.org/4/en/development/routing.html#restful-routing) documentation

#### List Routes

This works similar to `bin/cake routes` but shows only RESTful routes and improves some formatting of information.

```console
bin/cake mixerapi:rest route list
```

To limit output to a specific plugin use the `--plugin` option:

```console
# limit to a plugin:
bin/cake mixerapi:rest route list --plugin MyPlugin

#limit to main application:
bin/cake mixerapi:rest route list --plugin App
```
