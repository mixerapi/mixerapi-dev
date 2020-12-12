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

```console
git clone git@github.com:mixerapi/mixerapi-dev.git
make install
```

Next install [splitsh/lite](https://github.com/splitsh/lite#installation)

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
