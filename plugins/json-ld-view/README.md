# MixerAPI JsonLdView

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mixerapi/json-ld-view.svg?style=flat-square)](https://packagist.org/packages/mixerapi/json-ld-view)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE.txt)
[![Build](https://github.com/mixerapi/json-ld-view/workflows/Build/badge.svg?branch=master)](https://github.com/mixerapi/mixerapi-dev/actions?query=workflow%3ABuild)
[![Coverage Status](https://coveralls.io/repos/github/mixerapi/json-ld-view/badge.svg?branch=master)](https://coveralls.io/github/mixerapi/json-ld-view?branch=master)
[![MixerApi](https://mixerapi.com/assets/img/mixer-api-red.svg)](https://mixerapi.com)
[![CakePHP](https://img.shields.io/badge/cakephp-^4.0-red?logo=cakephp)](https://book.cakephp.org/4/en/index.html)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.2-8892BF.svg?logo=php)](https://php.net/)

!!! warning ""
    This is an alpha stage plugin.

A [JSON-LD](https://json-ld.org/) View for CakePHP. Read more at [MixerAPI.com](https://mixerapi.com).

## Installation

!!! info ""
    You can skip this step if MixerAPI is installed.

```console
composer require mixerapi/json-ld-view
bin/cake plugin load MixerApi/JsonLdView
```

Alternatively after composer installing you can manually load the plugin in your Application:

```php
# src/Application.php
public function bootstrap(): void
{
    // other logic...
    $this->addPlugin('MixerApi/JsonLdView');
}
```

## Setup

Setup for this plugin is very easy. Just load the RequestHandler component and create a route for contexts and
vocab. Then create a `config/jsonld_config.php` config file (recommended) and implement JsonLdDataInterface on your
entities.

#### Config (recommended)

Create a [config/jsonld_config](assets/jsonld_config.php). If you skip this step then the defaults listed in the
sample config will be used.

#### RequestHandler

Your controllers must be using the `RequestHandler` component. This is typically loaded in your `AppController`. In
most cases this is already loaded.

```php
# src/Controller/AppController.php
public function initialize(): void
{
    parent::initialize();
    $this->loadComponent('RequestHandler');
    // other logic...
}
```

#### Routes

The contexts route displays your JSON-LD schema for an entity, while the vocab route will display all entities and
additional metadata.

```php
# config/routes.php
$routes->scope('/', function (RouteBuilder $builder) {
    $builder->connect('/contexts/*', [
        'plugin' => 'MixerApi/JsonLdView', 'controller' => 'JsonLd', 'action' => 'contexts'
    ]);
    $builder->connect('/vocab', [
        'plugin' => 'MixerApi/JsonLdView', 'controller' => 'JsonLd', 'action' => 'vocab'
    ]);
    // ... other code
});
```

You should now be able see entities JSON-LD schema by browsing to `/contexts/{entity-name}`. For further customization
you can copy the JsonLdController into your own project.

#### Route Extension (optional)

If you would like to request JSON-LD by extension (e.g. `/index.jsonld`) you'll need to set the extension in your
`config/routes.php`, example:

```php
# config/routes.php
$routes->scope('/', function (RouteBuilder $builder) {
    $builder->setExtensions(['jsonld']);
    // ... other code
});
```

## Usage

Once setup is complete request types of `application/ld+json` will automatically be rendered as JSON-LD.

### Entity Schema

This plugin will map basic types (int, string, decimal etc.) to their corresponding schema.org values. For instance,
`int` is mapped to `https://schema.org/Number`. You can improve the mappings by defining proper Validations on your
Table class. For instance, fields with the `email` rule will be mapped to `https://schema.org/email`. For a full list
of default mappings refer to `MixerApi\JsonLdView\SchemaMapper`.

You can further customize the schema mapping by implementing `MixerApi\JsonLdView\JsonLdDataInterface` on your
applications Entities.

<details><summary>See the doc block comments in the example for additional insight:</summary>
  <p>

```php
# App/Model/Entity/Film.php
class Film extends Entity implements JsonLdDataInterface
{
    // ...other code

    /**
     * This is the context URL that you defined in your routes during Setup. This is used to browse the schema
     * definitions and appears as `@context` when displaying collection or item results
     *
     * @return string
     */
    public function getJsonLdContext(): string
    {
        return '/contexts/Film';
    }

    /**
     * This is the Entities schema description and appears as `@type` when displaying collection or item results
     *
     * @return string
     */
    public function getJsonLdType(): string
    {
        return 'https://schema.org/movie';
    }

    /**
     * This is the Entities URL and appears as `@id` when displaying collection or item results
     *
     * @param EntityInterface $entity
     * @return string
     */
    public function getJsonLdIdentifier(EntityInterface $entity): string
    {
        return '/films/' . $entity->get('id');
    }

    /**
     * You can define custom schemas here. These definitions take precedence and will appear when browsing to the
     * entities context URL. You can simply return an empty array if you don't care to define a schema.
     *
     * @return \MixerApi\JsonLdView\JsonLdSchema[]
     */
    public function getJsonLdSchemas(): array
    {
        return [
            (new JsonLdSchema())->setProperty('title')->setSchemaUrl('https://schema.org/name')->setDescription('optional'),
            (new JsonLdSchema())->setProperty('description')->setSchemaUrl('https://schema.org/about'),
            (new JsonLdSchema())->setProperty('length')->setSchemaUrl('https://schema.org/duration'),
            (new JsonLdSchema())->setProperty('rating')->setSchemaUrl('https://schema.org/contentRating'),
            (new JsonLdSchema())->setProperty('release_year')->setSchemaUrl('https://schema.org/copyrightYear'),
        ];
    }
}
```
</p>
</details>

### Collections

We get the `@id` and `@context` properties because these Entities implement `JsonLdDataInterface`. This interface is
of course optional and data will return without it minus the aforementioned properties. Pagination data is added in
the `view` property per the Hydra [PartialCollectionView](https://www.w3.org/community/hydra/wiki/Pagination)
 specification.

```php
#src/Controller/FilmsController.php
public function index()
{
    $this->request->allowMethod('get');
    $actors = $this->paginate($this->Films, [
        'contain' => ['Languages'],
    ]);
    $this->set(compact('films'));
    $this->viewBuilder()->setOption('serialize', 'films');
}
```

<details><summary>Example:</summary>
  <p>

```json
{
  "@context": "/context/Film",
  "@id": "/films",
  "@type": "Collection",
  "pageItems": 20,
  "totalItems": 1,
  "view": {
    "@id": "/films",
    "@type": "PartialCollectionView",
    "next": "/films?page=2",
    "prev": "",
    "first": "",
    "last": "/films?page=50"
  },
  "member": [
    {
      "id": 1,
      "title": "ACADEMY DINOSAUR",
      "description": "A Epic Drama of a Feminist And a Mad Scientist who must Battle a Teacher in The Canadian Rockies",
      "modified": "2006-02-15T05:03:42+00:00",
      "language": {
        "id": 1,
        "name": "English",
        "@id": "/languages/1",
        "@type": "https://schema.org/Language",
        "@context": "/context/Language"
      },
      "@id": "/films/1",
      "@type": "https://schema.org/Movie",
      "@context": "/context/Film"
    }
  ]
}
```
</p>
</details>

### Items

```php
#src/Controller/LanguagesController.php
public function view($id = null)
{
    $this->request->allowMethod('get');
    $languages = $this->Languages->get($id);
    $this->set('languages', $languages);
    $this->viewBuilder()->setOption('serialize', 'languages');
}
```

Output:

```json
{
  "@id": "/languages/1",
  "@type": "https://schema.org/Language",
  "@context": "/context/Language",
  "id": 1,
  "name": "English"
}
```

### Contexts

Browsing to the contexts route will display information about that entity. To fine tune to the data you will need to
implement JsonLdDataInterface. Using the Film entity as an example, the context looks like this when browsing to
`/contexts/Film`:

```json
{
  "@context": {
    "@vocab": "/vocab",
    "hydra": "http://www.w3.org/ns/hydra/core#",
    "title": "https://schema.org/name",
    "description": "https://schema.org/about",
    "length": "https://schema.org/duration",
    "rating": "https://schema.org/contentRating",
    "release_year": "https://schema.org/copyrightYear",
    "id": "https://schema.org/identifier",
    "language_id": "https://schema.org/Number",
    "rental_duration": "https://schema.org/Number",
    "rental_rate": "https://schema.org/Float",
    "replacement_cost": "https://schema.org/Float",
    "special_features": "https://schema.org/Text",
    "modified": "https://schema.org/DateTime"
  }
}
```

#### Vocab

Any entities implementing the JsonLdDataInterface will appear when browsing to the route you created for vocab
(e.g. /vocab):

<details><summary>Sample:</summary>
  <p>

```json

{
    "@contexts": {
        "@vocab": "/vocab",
        "rdf": "http://www.w3.org/1999/02/22-rdf-syntax-ns#",
        "rdfs": "http://www.w3.org/2000/01/rdf-schema#",
        "xmls": "http://www.w3.org/2001/XMLSchema#",
        "owl": "http://www.w3.org/2002/07/owl#",
        "schema": "http://schema.org"
    },
    "@id": "/vocab",
    "@type": "ApiDocumentation",
    "title": "API Documentation",
    "description": "",
    "supportedClass": [
        {
            "@id": "https://schema.org/Language",
            "@type": "Class",
            "title": "Language",
            "supportedProperty": [
                {
                    "@type": "supportedProperty",
                    "property": {
                        "@id": "https://schema.org/name",
                        "@type": "rdf:Property",
                        "rdfs:label": "name",
                        "domain": "https://schema.org/Language",
                        "range": "xmls:char"
                    },
                    "title": "name",
                    "required": false,
                    "readable": true,
                    "writeable": true,
                    "description": ""
                }
            ]
        }
        // ...and other items
    ]
}
```
</p>
</details>

### Serializing

Optionally, you can manually serialize data into JSON-LD using `JsonSerializer`. Example:

```php
use MixerApi\JsonLdView\JsonSerializer;

# json
$json = (new JsonSerializer($data))->asJson(JSON_PRETTY_PRINT); // argument is optional

# array
$hal = (new JsonSerializer($data))->getData();

# json-ld with pagination meta data
use Cake\Http\ServerRequest;
use Cake\View\Helper\PaginatorHelper;
$json = (new JsonSerializer($data, new ServerRequest(), new PaginatorHelper()))->asJson();
```
