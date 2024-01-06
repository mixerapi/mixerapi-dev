<?php
declare(strict_types=1);

namespace MixerApi\JsonLdView\View;

use Cake\Core\Configure;
use Cake\View\JsonView;
use MixerApi\JsonLdView\JsonSerializer;

/**
 * A view class that is used for JSON-LD responses.
 *
 * @see https://json-ld.org/
 * @SuppressWarnings(\MixerApi\JsonLdView\View\PHPMD)
 * @uses \MixerApi\JsonLdView\JsonSerializer
 */
class JsonLdView extends JsonView
{
    /**
     * @inheritDoc
     */
    protected string $layoutPath = 'jsonld';

    /**
     * @inheritDoc
     */
    protected string $subDir = 'jsonld';

    /**
     * @inheritDoc
     */
    protected array $_defaultConfig = [
        'serialize' => null,
        'jsonOptions' => null,
    ];

    /**
     * @inheritDoc
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadHelper('Paginator', [
            'templates' => 'MixerApi/JsonLdView.paginator-template',
        ]);
    }

    /**
     * @inheritDoc
     */
    public static function contentType(): string
    {
        return 'application/ld+json';
    }

    /**
     * @inheritDoc
     */
    protected function _serialize($serialize): string
    {
        $serialize = $this->_dataToSerialize($serialize);

        $jsonOptions = $this->getConfig('jsonOptions');

        if ($jsonOptions === null) {
            $jsonOptions = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_PARTIAL_OUTPUT_ON_ERROR;
        } elseif ($jsonOptions === false) {
            $jsonOptions = 0;
        }

        if (Configure::read('debug')) {
            $jsonOptions |= JSON_PRETTY_PRINT;
        }

        if (defined('JSON_THROW_ON_ERROR')) {
            $jsonOptions |= JSON_THROW_ON_ERROR;
        }

        return (new JsonSerializer($serialize, $this->getRequest(), $this->Paginator))->asJson($jsonOptions);
    }
}
