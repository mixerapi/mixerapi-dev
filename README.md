<h1 align="center">
  MixerAPI
</h1>
<p align="center">
  <a href="http://mixerapi.com/">
    <img alt="MixerAPI" src="https://mixerapi.com/assets/logo.png" />
  </a>
</p>

<p align="center">
    <a href="LICENSE.txt" target="_blank">
        <img alt="Software License" src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square">
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
</p>

This is the development repository for MixerAPI. If you are looking to install MixerAPI please visit
[mixerapi.com](https://mixerapi.com/) or go to [MixerApi/MixerApi](https://github.com/mixerapi/mixerapi).

Changes to this repository are automatically pushed to the plugin repositories via
[Subtree Split](https://www.subtreesplit.com/).

## Install

Clone the project and install composer dependencies for mixerapi-dev and all MixerAPI plugins.

```console
git clone git@github.com:mixerapi/mixerapi-dev.git
composer install
```

## Development

You can require mixerapi/mixerapi-dev in other projects for local development by modifying your composer.json. First,
remove mixerapi/mixerapi:

```console
composer remove mixerapi/mixerapi
```

Next, reference mixerapi/mixerapi-dev using a path repository. The `url` can be relative or absolute:

```json
    "repositories": [
        {
            "type": "path",
            "url": "../mixerapi-dev",
            "options": {
                "symlink": true
            }
        }
    ]
```

Then just require mixerapi/mixerapi-dev:

```console
composer require mixerapi/mixerapi-dev @dev
```

No code changes should be necessary though you may need to run `composer dump-autoload`.

### Unit Tests

Runs unit tests for each plugin.

```console
composer test
```

### Code Standards + Unit Tests

Runs static code analysis and unit tests.

```console
composer analyze
```

Git pre-commit hooks run these analyzers via [grumphp](https://github.com/phpro/grumphp). To set up:

```console
vendor/bin/grumphp git:init
vendor/bin/grumphp run
```

## Documentation

See the official documentation at [MixerAPI.com](https://mixerapi.com).

Documentation was built using [MkDocs](https://squidfunk.github.io/mkdocs-material/). It is designed to pull in the
README.md files from all MixerAPI plugins. Additional documentation can be added in the `docs/` directory and mapped
to the navigation in `mkdocs.yml`.

You can run documentation locally:

```console
composer mkdocs-run
```

_Browse to http://localhost:8000/_

To build:

```console
composer mkdocs-build
```

