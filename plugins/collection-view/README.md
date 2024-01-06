# MixerAPI CollectionView

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mixerapi/collection-view.svg?style=flat-square)](https://packagist.org/packages/mixerapi/collection-view)
[![Build](https://github.com/mixerapi/mixerapi-dev/workflows/Build/badge.svg?branch=master)](https://github.com/mixerapi/mixerapi-dev/actions?query=workflow%3ABuild)
[![Coverage Status](https://coveralls.io/repos/github/mixerapi/mixerapi-dev/badge.svg?branch=master)](https://coveralls.io/github/mixerapi/mixerapi-dev?branch=master)
[![MixerApi](https://mixerapi.com/assets/img/mixer-api-red.svg)](https://mixerapi.com)
[![CakePHP](https://img.shields.io/badge/cakephp-^4.2-red?logo=cakephp)](https://book.cakephp.org/4/en/index.html)
[![Minimum PHP Version](https://img.shields.io/badge/php-^8.0-8892BF.svg?logo=php)](https://php.net/)

A simple Collection View for displaying configurable pagination meta data in JSON or XML collection responses. Read
more at [MixerAPI.com](https://mixerapi.com).

## Installation

!!! info ""
    You can skip this step if MixerAPI is installed. However, you will still new to define your viewClasses (read below).

```console
composer require mixerapi/collection-view
bin/cake plugin load MixerApi/CollectionView
```

Alternatively after composer installing you can manually load the plugin in your Application:

```php
# src/Application.php
public function bootstrap(): void
{
    // other logic...
    $this->addPlugin('MixerApi/CollectionView');
}
```

## Setup

Your controllers must define their
[view classes for content negotiation](https://book.cakephp.org/5/en/views/json-and-xml-views.html#defining-view-classes-to-negotiate-with).

```php
use MixerApi\CollectionView\View\JsonCollectionView;
use MixerApi\CollectionView\View\XmlCollectionView;

public function viewClasses(): array
{
    return [JsonCollectionView::class, XmlCollectionView::class];
}
```

This can be done in your AppController to add them to all inheriting controllers or on a controller-by-controller basis.

## Usage

That's it, you're done. Perform `application/xml` or `application/json` requests as normal. You may also request by
`.xml` or `.json` extensions (assuming you've enabled them in your `config/routes.php`). This plugin will only modify
collections (e.g. controller::index action) requests, not item (e.g. controller::view action) requests.

<details><summary>JSON sample</summary>
  <p>

```json
{
    "collection": {
        "url": "/films?page=3&direction=desc",
        "count": 20,
        "total": 1000,
        "pages": 50,
        "next": "/films?page=4",
        "prev": "/films?page=2",
        "first": "/films",
        "last": "/films?page=50"
    },
    "data": [
        {
            "id": 1,
            "first_name": "PENELOPE",
            "last_name": "GUINESS",
            "modified": "2006-02-15T04:34:33+00:00",
            "films": [
                {
                    "id": 1,
                    "title": "ACADEMY DINOSAUR",
                    "description": "A Epic Drama of a Feminist And a Mad Scientist who must Battle a Teacher in The Canadian Rockies",
                    "release_year": "2006",
                    "language_id": 1,
                    "rental_duration": 6,
                    "length": 86,
                    "rating": "PG",
                    "special_features": "Deleted Scenes,Behind the Scenes",
                    "modified": "2006-02-15T05:03:42+00:00"
                }
            ]
        }
    ]
}
```
</p>
</details>

<details><summary>XML sample</summary>
  <p>

```xml
<response>
  <collection>
    <url>/films?page=3&amp;direction=desc</url>
    <count>20</count>
    <total>1000</total>
    <pages>50</pages>
    <next>/films?page=4</next>
    <prev>/films?page=2</prev>
    <first>/films</first>
    <last>/films?page=50</last>
  </collection>
  <data>
    <id>1</id>
    <first_name>PENELOPE</first_name>
    <last_name>GUINESS</last_name>
    <modified>2/15/06, 4:34 AM</modified>
    <films>
      <id>1</id>
      <title>ACADEMY DINOSAUR</title>
      <description>A Epic Drama of a Feminist And a Mad Scientist who must Battle a Teacher in The Canadian Rockies</description>
      <release_year>2006</release_year>
      <language_id>1</language_id>
      <rental_duration>6</rental_duration>
      <length>86</length>
      <rating>PG</rating>
      <special_features>Deleted Scenes,Behind the Scenes</special_features>
      <modified>2/15/06, 5:03 AM</modified>
    </films>
  </data>
</response>
```
</p>
</details>

## Configuration

This is optional. You can alter the names of the response keys, simply create a config/collection_view.php file. Using
the example below we can change the `collection` key to `pagination`, `data` to `items`, and alter some key names within
our new pagination object. Just keep the mapped items `{{names}}` as-is.

```php
# config/collection_view.php
return [
    'CollectionView' => [
        'pagination' => '{{collection}}', // array that holds pagination data
        'pagination.url' => '{{url}}', // url of current page
        'pagination.count' => '{{count}}', // items on the page
        'pagination.total' => '{{total}}', // total database records
        'pagination.pages' => '{{pages}}', // total pages
        'pagination.next' => '{{next}}', // next page url
        'pagination.prev' => '{{prev}}', // previous page url
        'pagination.first' => '{{first}}', // first page url
        'pagination.last' => '{{last}}', // last page url
        'items' => '{{data}}', // the collection of data
    ]
];
```
