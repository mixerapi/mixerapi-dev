<?php
use Cake\Http\ServerRequest;

ServerRequest::addDetector(
    'haljson',
    [
        'accept' => ['application/hal+json','application/vnd.hal+json'],
        'param' => '_ext',
        'value' => 'haljson',
    ]
);