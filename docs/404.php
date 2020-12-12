<?php
/**
 * Handles redirects 404s on links to source files found on github
 * Configure webserver to send redirects here
 */
$uri = getenv('REQUEST_URI');
$pieces = explode('/', $uri);
array_shift($pieces);

$dir = reset($pieces);
$packages = [
    'bake',
    'collection-view',
    'exception-render',
    'hal-view',
    'json-ld-view',
    'rest',
];

if ($dir == 'cakephp-swagger-bake') {
    $url = 'https://github.com/cnizzardini/cakephp-swagger-bake/blob/master/';
    array_shift($pieces);

    if (reset($pieces) == 'docs') {
        array_shift($pieces);
    }
    if (reset($pieces) == 'extensions') {
        array_shift($pieces);
    }

    $url.= implode('/', $pieces);
    header("Location: $url",TRUE,302);
    exit(0);
} else if (in_array($dir, $packages)) {
    $url = "https://github.com/mixerapi/$dir/blob/master/";
    array_shift($pieces);

    if (reset($pieces) == 'docs') {
        array_shift($pieces);
    }

    $url.= implode('/', $pieces);
    header("Location: $url",TRUE,302);
    exit(0);
}

header("Location: /404.html",TRUE,302);