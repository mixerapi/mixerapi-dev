<?php
/**
 * @var bool $isHydra: Whether to use hydra schema
 * @see http://www.hydra-cg.com/spec/latest/core/
 * default: `false`
 *
 * @var string $schemaUrl: Where schema definitions come from
 * default: `http://schema.org/`
 *
 * @var string $vocabUrl: A vocab endpoint
 * default: `/vocab`
 *
 * @var string $title: Title of your API
 * default: `Api Documentation`
 *
 * @var string $description: Description of your API
 * default: ``
 *
 * @var string $entrypointUrl: Describes API default entry point
 * default: `/`
 */
return [
    'JsonLdView' => [
        'isHydra' => false,
        'schemaUrl' => 'http://schema.org/',
        'vocabUrl' => '/vocab',
        'title' => 'API Documentation',
        'description' => '',
        'entrypointUrl' => '/'
    ]
];