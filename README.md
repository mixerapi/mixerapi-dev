<h1 align="center">
  MixerAPI
</h1>
<p align="center">
  <a href="http://mixerapi.com/">
    <img alt="MixerAPI" src="assets/mixer-api-200x-178x.png" />
  </a>
</p>

<p align="center">
    <a href="LICENSE.txt" target="_blank">
        <img alt="Software License" src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square">
    </a>
    <a href="https://travis-ci.org/mixerapi/mixerapi" target="_blank">
        <img alt="Build Status" src="https://github.com/mixerapi/mixerapi=dev/workflows/Build/badge.svg?branch=master">
    </a>
    <a href="https://coveralls.io/github/mixerapi/mixerapi?branch=master" target="_blank">
        <img alt="Coverage Status" src="https://coveralls.io/repos/github/mixerapi/mixerapi/badge.svg?branch=master">
    </a>
    <a href="https://book.cakephp.org/4/en/index.html">
        <img alt="CakePHP >= 4" src="https://img.shields.io/badge/cakephp-%3E%3D%204.0-red?logo=cakephp">
    </a>
    <a href="https://php.net/" target="_blank">
        <img alt="PHP >= 7.2" src="https://img.shields.io/badge/php-%3E%3D%207.2-8892BF.svg?logo=php">
    </a>
</p>

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
