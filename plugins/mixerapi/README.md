<h1 align="center">
  MixerAPI
</h1>
<p align="center">
  <a href="http://mixerapi.com/">
    <img alt="MixerAPI" src="https://mixerapi.com/assets/logo.png" />
  </a>
</p>
<h3 align="center">
  Streamline development of API-first applications in CakePHP
</h3>
<p align="center">
    <a href="https://packagist.org/packages/mixerapi/mixerapi" target="_blank">
        <img alt="Packagist" src="https://img.shields.io/packagist/v/mixerapi/mixerapi.svg?style=flat-square">
    </a>
    <a href="https://github.com/mixerapi/mixerapi-dev/actions?query=workflow%3ABuild" target="_blank">
        <img alt="Build Status" src="https://github.com/mixerapi/mixerapi-dev/workflows/Build/badge.svg?branch=master">
    </a>
    <a href="https://coveralls.io/github/mixerapi/mixerapi-dev?branch=master" target="_blank">
        <img alt="Coverage Status" src="https://coveralls.io/repos/github/mixerapi/mixerapi-dev/badge.svg?branch=master">
    </a>
    <a href="https://book.cakephp.org/4/en/index.html">
        <img alt="CakePHP ^4.2" src="https://img.shields.io/badge/cakephp-^4.2-red?logo=cakephp">
    </a>
    <a href="https://php.net/" target="_blank">
        <img alt="PHP ^8.0" src="https://img.shields.io/badge/php-^8.0-8892BF.svg?logo=php">
    </a>
    <a href="LICENSE.txt" target="_blank">
        <img alt="Software License" src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square">
    </a>
</p>

MixerAPI is a plugin of plugins, that is to say, it combines many CakePHP libraries into a coherent package to
streamline API development for CakePHP applications. It eases following a [REST](https://restfulapi.net)
architecture style and [HATEOS](https://restfulapi.net/hateoas/). In other words, it makes developing APIs a piece
of cake.

[Documentation](https://mixerapi.com) |
[Demo Application](https://demo.mixerapi.com) |
[Demo Source Code](https://github.com/mixerapi/demo)

This is a read-only repository. Please submit issues and PRs to
[mixerapi/mixerapi-dev](https://github.com/mixerapi/mixerapi-dev)

## Installation

```console
composer require mixerapi/mixerapi
bin/cake plugin load MixerApi
```

Alternatively after composer installing you can manually load the plugin in your Application:

```php
# src/Application.php
public function bootstrap(): void
{
    // other logic...
    $this->addPlugin('MixerApi');
}
```

### Automated Install

The automated install will overwrite your `config/app.php` and `config/routes.php`, and create a welcome page at your
applications index route.

```console
bin/cake mixerapi install
```

You should now be able to browse to your index page and see the welcome page.

### Manual Install

Manually installing can be a bit cumbersome which is why the automated installer is recommended. If you ar integrating
MixerApi into an existing project or prefer to do things yourself follow along below:

- Follow installation steps in [SwaggerBake](https://github.com/cnizzardini/cakephp-swagger-bake)
- Follow installation steps in [MixerApi/ExceptionRender](https://github.com/mixerapi/exception-render)
- Copy `assets/WelcomeController.php` to your `src/Controller` directory.
- Copy routes from `assets/routes.php` to your `config/routes.php`
- Copy welcome schemas from `assets/swagger.yml` to your `config/swagger.yml`

## Loading Plugins as-needed

You can also load plugins individually. For instance, if your project only requires HalView and SwaggerBake your
`Application->bootstrap()` would resemble this:

```php
# src/Application.php
public function bootstrap(): void
{
    // other logic...
    $this->addPlugin('MixerApi/HalView');
    $this->addPlugin('SwaggerBake');
}
```

If you don't need the entire suite of plugins simply `composer require` on an as-needed basis. It's up to you!

## MixerAPI Core Plugins

MixerAPI automatically installs the following plugins for your RESTful API project:

| Plugin | Description |
| ------------- | ------------- |
| [MixerApi/Bake](https://github.com/mixerapi/bake) | A custom bake template focused on creating RESTful CakePHP controllers in seconds |
| [MixerApi/CollectionView](https://github.com/mixerapi/collection-view) | A Collection View for displaying configurable pagination meta-data in JSON or XML collection responses |
| [MixerApi/ExceptionRender](https://github.com/mixerapi/exception-render) | Handles rendering entity validation errors and other exceptions for your API |
| [MixerApi/HalView](https://github.com/mixerapi/hal-view) | A Hypertext Application Language ([HAL+JSON](http://stateless.co/hal_specification.html)) View for CakePHP |
| [MixerApi/JsonLdView](https://github.com/mixerapi/json-ld-view) | A [JSON-LD](https://json-ld.org/) View for CakePHP |
| [MixerApi/Rest](https://github.com/mixerapi/rest) | Gets your API project up and going quickly by creating routes for you |
| [SwaggerBake](https://github.com/cnizzardini/cakephp-swagger-bake) | A delightfully tasty tool for generating Swagger documentation with OpenApi 3.0.0 schema |

## Recommended Plugins

| Plugin | Description |
| ------------- | ------------- |
| [MixerApi/Crud](https://github.com/mixerapi/crud) | A service provider for CRUD (Create/Read/Update/Delete) operations. Since this plugin uses the experimental CakePHP dependency injection it must be enabled separately. |
| [Search](https://github.com/FriendsOfCake/search) | Search provides a simple interface to create paginate-able filters for your CakePHP application. |
