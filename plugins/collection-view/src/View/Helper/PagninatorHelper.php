<?php
declare(strict_types=1);

namespace MixerApi\CollectionView\View\Helper;

use Cake\View\Helper\PaginatorHelper;

class PagninatorHelper extends PaginatorHelper
{
    /**
     * Overwrite base method to never escape URLs.
     *
     * @inheritdoc
     */
    public function generateUrl(
        array $options = [],
        array $url = [],
        array $urlOptions = []
    ): string {
        $urlOptions += [
            'escape' => false,
            'fullBase' => false,
        ];

        return $this->Url->build($this->generateUrlParams($options, $url), $urlOptions);
    }
}
