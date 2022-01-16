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
 * @SuppressWarnings(PHPMD)
 * @uses \MixerApi\JsonLdView\JsonSerializer
 */
class JsonLdView extends JsonView
{
    /**
     * Layouts are located in the 'jsonld' sub directory of `Layouts/`
     *
     * @var string
     */
    protected $layoutPath = 'jsonld';

    /**
     * Views are located in the 'jsonld' sub directory for controllers' views.
     *
     * @var string
     */
    protected $subDir = 'jsonld';

    /**
     * Response type.
     *
     * @var string
     */
    protected $_responseType = 'jsonld';

    /**
     * Default config options.
     *
     * Use ViewBuilder::setOption()/setOptions() in your controller to set these options.
     *
     * - `serialize`: Option to convert a set of view variables into a serialized response.
     *   Its value can be a string for single variable name or array for multiple
     *   names. If true all view variables will be serialized. If null or false
     *   normal view template will be rendered.
     * - `jsonOptions`: Options for json_encode(). For e.g. `JSON_HEX_TAG | JSON_HEX_APOS`.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'serialize' => null,
        'jsonOptions' => null,
    ];

    /**
     * @return void
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
