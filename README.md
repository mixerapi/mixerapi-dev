<h1 align="center">
  MixerAPI
</h1>
<p align="center">
  <a href="http://mixerapi.com/">
    <img alt="MixerAPI" src="assets/mixer-api-200x-178x.png" />
  </a>
</p>

This is the development repository for MixerAPI. If you are looking to install MixerAPI please visit
[mixerapi.com](https://mixerapi.com/) or go to [MixerApi/MixerApi](https://github.com/mixerapi/mixerapi).

## Install

Clone the project and install composer dependencies for mixerapi-dev and all MixerAPI plugins.

## Development

Changes are automatically pushed to the plugin repositories via [Subtree Split](https://www.subtreesplit.com/).

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

## Unit Tests

Runs unit tests for each plugin.

```console
make test
```

## Code Standards + Unit Tests

Runs static code analysis and unit tests.

```console
make check
```
