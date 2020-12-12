# MixerApi HAL View
[![Latest Version on Packagist](https://img.shields.io/packagist/v/mixerapi/hal-view.svg?style=flat-square)](https://packagist.org/packages/mixerapi/hal-view)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE.txt)
[![Build](https://github.com/mixerapi/hal-view/workflows/Build/badge.svg?branch=master)](https://github.com/mixerapi/hal-view/actions)
[![Coverage Status](https://coveralls.io/repos/github/mixerapi/hal-view/badge.svg?branch=master)](https://coveralls.io/github/mixerapi/hal-view?branch=master)
[![MixerApi](https://mixerapi.com/assets/img/mixer-api-red.svg)](http://mixerapi.com)
[![CakePHP](https://img.shields.io/badge/cakephp-%3E%3D%204.0-red?logo=cakephp)](https://book.cakephp.org/4/en/index.html)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.2-8892BF.svg?logo=php)](https://php.net/)

!!! warning ""
    This is an alpha stage plugin.

A Hypertext Application Language ([HAL+JSON](http://stateless.co/hal_specification.html)) View for CakePHP. This plugin 
supports links, pagination, and embedded resources. Once setup any request with `application/hal+json` will be 
rendered by this plugin.

## Table of Contents

- [Installation](#installation)
- [Setup](#setup)
- [Usage](#usage)
- [Serializing](#serializing)

## Installation

!!! note ""
    You can skip this step if MixerAPI is installed.

```console
composer require mixerapi/hal-view
bin/cake plugin load MixerApi/HalView
```

Alternatively after composer installing you can manually load the plugin in your Application:

```php
# src/Application.php
public function bootstrap(): void
{
    // other logic...
    $this->addPlugin('MixerApi/HalView');
}
```

## Setup

Your controllers must be using the `RequestHandler` component. This is typically loaded in your `AppController`.

```php
# src/Controller/AppController.php
public function initialize(): void
{
    parent::initialize();
    $this->loadComponent('RequestHandler');
    // other logic... 
}
```

## Usage

For `_link.self.href` support you will need to implement `MixerApi\HalView\HalResourceInterface` on entities that you 
want to expose as HAL resources. This informs the plugin that the Entity should be treated as a HAL resource and 
provides the mapper with a `_link.self.href` URL.

<details><summary>Example</summary>
  <p>
  
```php
<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use MixerApi\HalView\HalResourceInterface;
use Cake\Datasource\EntityInterface;

class Actor extends Entity implements HalResourceInterface
{
    // your various properties and logic

    /**
     * @param EntityInterface $entity
     * @return array|\string[][]
     */
    public function getHalLinks(EntityInterface $entity): array
    {
        return [
            'self' => [
                'href' => '/actors/' . $entity->get('id')
            ]
        ];
    }
}
```
</p>
</details>

Now an HTTP GET to the `/actors/149` endpoint will render HAL using the CakePHP native serialization process:

```php
#src/Controller/ActorsController.php
public function view($id = null)
{
    $this->request->allowMethod('get');
    $actor = $this->Actors->get($id, [
        'contain' => ['Films'],
    ]);
    $this->set('actor', $actor);
    $this->viewBuilder()->setOption('serialize', 'actor');
}
```

<details><summary>Example</summary>
  <p>

```json
{
  "_links": {
    "self": {
      "href": "/actors/149"
    }
  },
  "id": 149,
  "first_name": "RUSSELL",
  "last_name": "TEMPLE",
  "modified": "2006-02-15T04:34:33+00:00",
  "_embedded": {
    "films": [
      {
        "id": 53,
        "title": "BANG KWAI",
        "description": "A Epic Drama of a Madman And a Cat who must Face a A Shark in An Abandoned Amusement Park",
        "release_year": "2006",
        "language_id": 1,
        "rental_duration": 5,
        "rental_rate": "2.99",
        "length": 87,
        "replacement_cost": "25.99",
        "rating": "NC-17",
        "special_features": "Commentaries,Deleted Scenes,Behind the Scenes",
        "modified": "2006-02-15T05:03:42+00:00"
        "_links": {
          "self": {
            "href": "/films/53"
          }
        }
      }
    ]
  }
}
```
</p>
</details>

If your Entity does not implement the interface it will still be returned as HAL resource when serialized, but minus 
the `_links` property. Collection requests will work without this interface as well, example:

```php
#src/Controller/ActorsController.php
public function index()
{
    $this->request->allowMethod('get');
    $actors = $this->paginate($this->Actors, [
        'contain' => ['Films'],
    ]);
    $this->set(compact('actors'));
    $this->viewBuilder()->setOption('serialize', 'actors');
}
```

<details><summary>Example</summary>
  <p>

```json
{
  "_links": {
    "self": {
      "href": "/actors?page=3"
    },
    "next": {
      "href": "/actors?page=4"
    },
    "prev": {
      "href": "/actors?page=2"
    },
    "first": {
      "href": "/actors?page=1"
    },
    "last": {
      "href": "/actors?page=11"
    }
  },
  "count": 20,
  "total": 207,
  "_embedded": {
    "actors": [
      {
        "id": 1,
        "first_name": "PENELOPE",
        "last_name": "GUINESS",
        "modified": "2006-02-15T04:34:33+00:00"
        "_embedded": {
          "films": [
            {
              "id": 1,
              "title": "ACADEMY DINOSAUR",
              "description": "A Epic Drama of a Feminist And a Mad Scientist who must Battle a Teacher in The Canadian Rockies",
              "release_year": "2006",
              "language_id": 1,
              "rental_duration": 6,
              "rental_rate": "0.99",
              "length": 86,
              "replacement_cost": "20.99",
              "rating": "PG",
              "special_features": "Deleted Scenes,Behind the Scenes",
              "modified": "2006-02-15T05:03:42+00:00"
            }
          ]
        }
      }
    ]
  }
}
```
</p>
</details>

If the Actor and Film entities were implementing `MixerApi\HalView\HalResourceInterface` then the example above would 
include the `_links` property for each serialized entity.

Try it out for yourself:

```console
# json
curl -X GET "http://localhost:8765/actors" -H "accept: application/hal+json"
```

## Serializing

Optionally, you can manually serialize data into HAL using `JsonSerializer`. This is the same class that the main HalJsonView uses. Example:

```php
use MixerApi\HalView\JsonSerializer;

# json
$json = (new JsonSerializer($data))->asJson(JSON_PRETTY_PRINT); // asJson argument is optional

# array
$hal = (new JsonSerializer($data))->getData();

# json with `_links.self.href` and pagination meta data
use Cake\Http\ServerRequest;
use Cake\View\Helper\PaginatorHelper;
$json = (new JsonSerializer($data, new ServerRequest(), new PaginatorHelper()))->asJson();
```

## Unit Tests

```console
# unit test only
vendor/bin/phpunit

# standards checking
composer check
```
