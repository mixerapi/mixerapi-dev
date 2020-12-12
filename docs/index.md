---
title: MixerAPI - Streamline RESTful API Development
---

# MixerAPI / Streamline API Development

!!! warning ""
    This is an alpha stage library

Streamline development of modern RESTful APIs for your teams CakePHP project. Designed around a component-based 
architecture, MixerAPI enables developers to pick and choose the functionality they need for developing REST/HATEOAS APIs.

!!! note ""
    Check out the live demo and browse the demo source code for examples.

[Live Demo](https://demo.mixerapi.com){: .md-button .md-button--primary }
[Source code](https://github.com/mixerapi/demo){: .md-button }

## Features

- **Rapid Prototyping:** Scaffold your API in seconds with a custom Bake template geared towards modern REST architecture.
- **OpenAPI:** Automatically generates [OpenAPI](https://www.openapis.org/) from your existing code into 
[Swagger](https://swagger.io/) and [Redoc](https://redoc.ly/). Annotations provided, but not required.
- **Error Handling:** Handles exception rendering in XML or JSON.
- **Data Formats:** Formats responses in JSON, XML, HAL+JSON, or JSON-LD.
- **Integrations:** Integrates well with other CakePHP 4 compatible plugins.
- **Minimalist Configuration:** Built for developing, not writing YAML configurations. Most components require zero 
configuration files.
- **Non-opinionated:** Develop your way.

## Install

<!-- MixerAPI can be setup using an app skeleton that contains a docker-compose setup. -->
You can also install via composer into your existing (or new) project. Read the installation guide to get started and 
getting started page afterwards.

!!! note ""
<!--
    Skip the guide and get started with the application skeleton 
    ```console 
    composer create-project -s dev --prefer-dist mixerapi/app 
    ```
    or composer 
-->
    ```console
    composer require mixerapi/mixerapi
    ```

[Install Guide](/install){: .md-button .md-button--primary }
[Workflow](/workflow){: .md-button }

## Contributing

Contributions are welcome to any of the [MixerAPI plugins](https://github.com/mixerapi). This documentation can be 
improved by modifying the README.md files for plugins, docs directory (if it exists for the plugin), and via  
[https://github.com/mixerapi/mixerapi.com](https://github.com/mixerapi/mixerapi.com) which is powered by MkDocs.
