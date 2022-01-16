# Installing MixerAPI

!!! tip ""
Checkout the application skeleton [https://github.com/mixerapi/app](https://github.com/mixerapi/app) to install via
docker-compose or locally.

## Composer

MixerAPI can be installed in your existing CakePHP project using
[composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos).

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

Next run the automated install or complete the installation manually.

### Automated Install

The automated install will overwrite your `config/app.php` and `config/routes.php`, and create a welcome page at your
applications index route.

```console
bin/cake mixerapi install
```

You should now be able to browse to your index page and see the welcome page.

### Manual Install

If you are integrating MixerApi into an existing project or prefer to do things yourself follow along below.

#### OpenAPI (Swagger)

After install you will need to define a few configurations for SwaggerBake. If you are not splitting your API into
plugins then the installer will handle this for you.

```console
bin/cake swagger install
```

For projects that have split their applications into plugins, check out the manual installation instructions. This is
also a great time to learn about the amazing functionality it offers.

[Learn More](/cakephp-swagger-bake){: .md-button }

#### Exception Rendering

This is optional, but provides some improvements on the default CakePHP exceptions. In your `config/app.php` file
change the default `exceptionRenderer`:

```php
'Error' => [
    'errorLevel' => E_ALL,
    'exceptionRenderer' => \MixerApi\ExceptionRender\MixerApiExceptionRenderer::class,
    'skipLog' => [],
    'log' => true,
    'trace' => true,
],
```

[Learn More](/plugins/exception-render){: .md-button }

## What's Next?

Check out the Getting Started documentation and skim the other MixerAPI packages.

[Getting Started](/workflow){: .md-button }
