<?php
declare(strict_types=1);

namespace MixerApi\Crud\Test\App\Model\Filter;

use Search\Model\Filter\FilterCollection;

class FilmsCollection extends FilterCollection
{
    /**
     * @return void
     */
    public function initialize(): void
    {
        $this
            ->add('title', 'Search.Like', [
                'before' => true,
                'after' => true,
                'mode' => 'or',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['title'],
            ]);
    }
}
