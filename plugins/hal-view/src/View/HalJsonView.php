<?php
declare(strict_types=1);

namespace MixerApi\HalView\View;

use Cake\Core\Configure;
use Cake\View\JsonView;
use MixerApi\HalView\JsonSerializer;

/**
 * A view class that is used for HAL+JSON responses.
 *
 * @link http://stateless.co/hal_specification.html
 * @link https://apigility.org/documentation/api-primer/halprimer
 * @SuppressWarnings(\MixerApi\HalView\View\PHPMD)
 * @uses \Cake\Core\Configure
 * @uses \MixerApi\HalView\JsonSerializer
 */
class HalJsonView extends JsonView
{
    /**
     * @inheritDoc
     */
    protected string $layoutPath = 'haljson';

    /**
     * @inheritDoc
     */
    protected string $subDir = 'haljson';

    /**
     * Response type.
     *
     * @var string
     */
    protected string $_responseType = 'haljson';

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
            'templates' => 'MixerApi/HalView.paginator-template',
        ]);
    }

    /**
     * @inheritDoc
     */
    public static function contentType(): string
    {
        return 'application/hal+json';
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
