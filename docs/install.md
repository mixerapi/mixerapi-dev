# Install

<!-- The easiest way to install MixerAPI is through the app skeleton. 
You may also install via composer into your existing CakePHP project or install the individual plugins as-needed. The 
documentation includes steps for installing plugins separately. For either method you will need 
[composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos), which is dependency manager for PHP.

## App Skeleton

Installing from the application skeleton is great if you are starting your API from scratch. It will install the 
latest version of CakePHP and MixerAPI. The App Skeleton also comes with an optional 
[docker-compose](https://docs.docker.com/compose/) setup.

```console
composer create-project -s dev --prefer-dist mixerapi/app 
```

## Composer

If you have an existing application or feel comfortable doing things yourself then you can install with composer.
-->

MixerAPI can be installed in your existing CakePHP project using 
[composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos). 

```console
composer require mixerapi/mixerapi
bin/cake plugin load MixerApi
```

Running `plugin load MixerApi` simply adds the plugin to your `Application::boostrap` like so:

```php
# src/Application.php
public function bootstrap(): void
{
    // other logic...
    $this->addPlugin('MixerApi');
}
```

## Setup

There are just a few steps to perform after installation.

### OpenAPI (Swagger)

After install you will need to define a few configurations for the SwaggerBake. If you are not splitting your API into 
plugins then the installer will handle this for you.

```console
bin/cake swagger install
```

For setups that have split their applications into APIs check out the manual installation instructions. This is also a 
great time to learn about the amazing functionality it offers.

[Learn More](/cakephp-swagger-bake){: .md-button }

### Exception Rendering

This is optional, but provides some improvements on the default CakePHP exceptions. In your `config/app.php` file 
change the default `exceptionRenderer`:

```php
'Error' => [
    'errorLevel' => E_ALL,
    'exceptionRenderer' => MixerApi\ExceptionRender\MixerApiExceptionRenderer::class,
    'skipLog' => [],
    'log' => true,
    'trace' => true,
],
```

[Learn More](/exception-render){: .md-button }

### Bake Your API Skeleton

You can bake your entire application using the MixerApi/Bake theme. This time saver is of course optional.

[Learn More](/bake){: .md-button }

### RESTful Routes

Skip building routes while you are learning MixerAPI with AutoRouter.

[Learn More](/rest){: .md-button }

## What's Next?

Check out the Getting Started documentation and skim the other MixerAPI packages.

[Getting Started](/workflow){: .md-button }