<h1 align="center">
  MixerAPI
</h1>
<p align="center">
  <a href="http://mixerapi.com/">
    <img alt="MixerAPI" src="assets/mixer-api-200x-178x.png" />
  </a>
</p>

[![Build](https://github.com/mixerapi/mixerapi=dev/workflows/Build/badge.svg?branch=master)](https://github.com/mixerapi/mixerapi-dev)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE.txt)
[![MixerApi](https://mixerapi.com/assets/img/mixer-api-red.svg)](http://mixerapi.com)
[![CakePHP](https://img.shields.io/badge/cakephp-%3E%3D%204.0-red?logo=cakephp)](https://book.cakephp.org/4/en/index.html)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.2-8892BF.svg?logo=php)](https://php.net/)

This is the development repository for MixerAPI. If you are looking to install MixerAPI please visit
[mixerapi.com](https://mixerapi.com/) or go to [MixerApi/MixerApi](https://github.com/mixerapi/mixerapi).

## Install

Clone the project and install composer dependencies for mixerapi-dev and all MixerAPI plugins.

```console
git clone git@github.com:mixerapi/mixerapi-dev.git
make install
```

## Development

Changes are automatically pushed to the plugin repositories via [Subtree Split](https://www.subtreesplit.com/).

### Unit Tests

Runs unit tests for each plugin.

```console
make test
```

### Code Standards + Unit Tests

Runs static code analysis and unit tests.

```console
make check
```

## Documentation

See the official documentation at [MixerAPI.com](https://mixerapi.com).

Documentation was built using [MkDocs](https://squidfunk.github.io/mkdocs-material/). It is designed to pull in the
README.md files from all MixerAPI plugins. Additional documentation can be added in the `docs/` directory and mapped
to the navigation in `mkdocs.yml`.

You can run documentation locally with (browse to http://localhost:8000/):

```console
make mkdocs-run
```

To build:

```console
make mkdocs-build
```
