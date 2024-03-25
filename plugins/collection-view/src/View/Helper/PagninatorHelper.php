<?php
declare(strict_types=1);

namespace MixerApi\CollectionView\View\Helper;

use Cake\View\Helper\PaginatorHelper;

class PagninatorHelper extends PaginatorHelper
{
    /**
     * Overwrite base method to never escape URLs.
     *
     * @param array<string, mixed> $options Pagination options.
     * @param array $url URL.
     * @param array<string, mixed> $urlOptions Array of options
     * @return string By default, returns a full pagination URL string for use in non-standard contexts (i.e. JavaScript)
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
