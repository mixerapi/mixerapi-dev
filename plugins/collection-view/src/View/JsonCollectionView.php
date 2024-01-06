<?php
declare(strict_types=1);

namespace MixerApi\CollectionView\View;

use Cake\Core\Configure;
use Cake\View\JsonView;
use MixerApi\CollectionView\Serializer;

class JsonCollectionView extends JsonView
{
    /**
     * @inheritDoc
     */
    protected string $layoutPath = 'json';

    /**
     * @inheritDoc
     */
    protected string $subDir = 'json';

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
            'templates' => 'MixerApi/CollectionView.paginator-template',
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

        return (new Serializer($serialize, $this->getRequest(), $this->Paginator))->asJson($jsonOptions);
    }
}
