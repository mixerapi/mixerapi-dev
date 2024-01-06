<?php
/**
 * Paginator Template
 *
 * @see https://book.cakephp.org/5/en/views/helpers/paginator.html#loading-templates-from-a-file
 */
return [
    'nextActive' => '{{url}}',
    'nextDisabled' => '{{url}}',
    'prevActive' => '{{url}}',
    'prevDisabled' => '{{url}}',
    'counterRange' => '{{count}}', // total records
    'counterPages' => '{{count}}', // total records
    'first' => '{{url}}',
    'last' => '{{url}}',
    'number' => '{{text}}',
    'current' => '{{text}}',
    'ellipsis' => '{{text}}',
    'sort' => '{{url}}',
    'sortAsc' => '{{url}}',
    'sortDesc' => '{{url}}',
    'sortAscLocked' => '{{url}}',
    'sortDescLocked' => '{{url}}',
];
