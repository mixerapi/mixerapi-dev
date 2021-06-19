# Install

!!! info ""
Checkout the application skeleton https://github.com/mixerapi/app

MixerAPI can be installed in your existing CakePHP project using
[composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos).

```console
composer require mixerapi/mixerapi
bin/cake plugin load MixerApi
```

Running `plugin load MixerApi` simply adds the plugin to your `Application::bootstrap()` like so:

```php
# src/Application.php
public function bootstrap(): void
{
    // other logic...
    $this->addPlugin('MixerApi');
}
```

## Setup

For new projects the installer is the easiest way to get started:

```console
bin/cake mixerapi install
```

For existing projects the steps below are recommended.

### OpenAPI (Swagger)

After install you will need to define a few configurations for SwaggerBake. If you are not splitting your API into
plugins then the installer will handle this for you.

```console
bin/cake swagger install
```

For projects that have split their applications into plugins, check out the manual installation instructions. This is
also a great time to learn about the amazing functionality it offers.

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

[Learn More](/plugins/exception-render){: .md-button }

### Bake Your API Skeleton

You can bake your entire application using the MixerApi/Bake theme. This time saver is of course optional.

[Learn More](/plugins/bake){: .md-button }

### RESTful Routes

Skip building routes while you are learning MixerAPI with AutoRouter.

[Learn More](/plugins/rest){: .md-button }

## What's Next?

Check out the Getting Started documentation and skim the other MixerAPI packages.

[Getting Started](/workflow){: .md-button }
