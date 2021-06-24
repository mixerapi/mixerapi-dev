<?php
declare(strict_types=1);

namespace MixerApi\CollectionView\View;

use Cake\Core\Configure;
use Cake\View\SerializedView;
use MixerApi\CollectionView\Serializer;

class XmlCollectionView extends SerializedView
{
    /**
     * @var string
     */
    protected $layoutPath = 'xml';

    /**
     * @var string
     */
    protected $subDir = 'xml';

    /**
     * Response type.
     *
     * @var string
     */
    protected $_responseType = 'xml';

    /**
     * Option to allow setting an array of custom options for Xml::fromArray()
     *
     * For e.g. 'format' as 'attributes' instead of 'tags'.
     *
     * @var array|null
     */
    protected $xmlOptions;

    /**
     * Default config options.
     *
     * Use ViewBuilder::setOption()/setOptions() in your controller to set these options.
     *
     * - `serialize`: Option to convert a set of view variables into a serialized response.
     *   Its value can be a string for single variable name or array for multiple
     *   names. If true all view variables will be serialized. If null or false
     *   normal view template will be rendered.
     * - `xmlOptions`: Option to allow setting an array of custom options for Xml::fromArray().
     *   For e.g. 'format' as 'attributes' instead of 'tags'.
     * - `rootNode`: Root node name. Defaults to "response".
     *
     * @var array
     * @psalm-var array{serialize:string|bool|null, xmlOptions: int|null, rootNode: string|null}
     */
    protected $_defaultConfig = [
        'serialize' => null,
        'xmlOptions' => null,
        'rootNode' => null,
    ];

    /**
     * @return void
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
        $rootNode = $this->getConfig('rootNode', 'response');

        if (is_array($serialize)) {
            if (empty($serialize)) {
                $serialize = '';
            } elseif (count($serialize) === 1) {
                $serialize = current($serialize);
            }
        }

        if (is_array($serialize)) {
            $data = [];
            foreach ($serialize as $alias => $key) {
                if (is_numeric($alias)) {
                    $alias = $key;
                }
                if (array_key_exists($key, $this->viewVars)) {
                    $data[$alias] = $this->viewVars[$key];
                }
            }
        } else {
            $data = $this->viewVars[$serialize] ?? [];
        }

        $options = $this->getConfig('xmlOptions', []);
        if (Configure::read('debug')) {
            $options['pretty'] = true;
        }

        return (new Serializer($data, $this->getRequest(), $this->Paginator))->asXml($options, $rootNode);
    }
}
