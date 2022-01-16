# MixerAPI Bake

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mixerapi/bake.svg?style=flat-square)](https://packagist.org/packages/mixerapi/bake)
[![Build](https://github.com/mixerapi/mixerapi-dev/workflows/Build/badge.svg?branch=master)](https://github.com/mixerapi/mixerapi-dev/actions?query=workflow%3ABuild)
[![Coverage Status](https://coveralls.io/repos/github/mixerapi/mixerapi-dev/badge.svg?branch=master)](https://coveralls.io/github/mixerapi/mixerapi-dev?branch=master)
[![MixerApi](https://mixerapi.com/assets/img/mixer-api-red.svg)](http://mixerapi.com)
[![CakePHP](https://img.shields.io/badge/cakephp-^4.2-red?logo=cakephp)](https://book.cakephp.org/4/en/index.html)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%208.0-8892BF.svg?logo=php)](https://php.net/)

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

MixerApi/Bake will automatically detect the following plugins and adjust the bake output accordingly:

- [MixerApi/Crud](https://github.com/mixerapi/crud)
- [MixerApi/ExceptionRender](https://github.com/mixerapi/exception-render)
- [SwaggerBake](https://github.com/cnizzardini/cakephp-swagger-bake)

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
