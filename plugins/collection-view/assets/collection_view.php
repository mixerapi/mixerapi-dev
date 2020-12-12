<?php
/**
 * Optionally change the naming for collection keys in your response. Must keep the same array depth and template
 * {{vars}}. This will not handle adding new fields or removing existing ones. Only edit the keys, not the values.
 */
return [
    'CollectionView' => [
        'collection' => '{{collection}}', // array that holds pagination data
        'collection.url' => '{{url}}', // url of current page
        'collection.count' => '{{count}}', // items on this page
        'collection.pages' => '{{pages}}', // total pages
        'collection.total' => '{{total}}', // total records in the database
        'collection.next' => '{{next}}', // next page url
        'collection.prev' => '{{prev}}', // previous page url
        'collection.first' => '{{first}}', // first page url
        'collection.last' => '{{last}}', // last page url
        'data' => '{{data}}', // the collection of data
    ]
];