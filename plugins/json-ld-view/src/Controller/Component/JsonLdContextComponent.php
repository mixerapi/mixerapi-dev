<?php
declare(strict_types=1);

namespace MixerApi\JsonLdView\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\ORM\Locator\LocatorAwareTrait;
use MixerApi\Core\Model\ModelFactory;
use MixerApi\JsonLdView\JsonLdEntityContext;

/**
 * Builds JSON-LD context for the given entity.
 *
 * @link https://json-ld.org/learn.html
 */
class JsonLdContextComponent extends Component
{
    use LocatorAwareTrait;

    /**
     * Returns the entity in JSON-LD form as an array
     *
     * @param string $tableAlias The Table alias
     * @return array
     */
    public function build(string $tableAlias): array
    {
        $config = Configure::read('JsonLdView');
        if (!empty($config['vocabUrl'])) {
            $data['@vocab'] = $config['vocabUrl'];
        }
        if ($config['isHydra']) {
            $data['hydra'] = 'http://www.w3.org/ns/hydra/core#';
        }

        $table = $this->getTableLocator()->get($tableAlias);
        $model = (new ModelFactory($table->getConnection(), $table))->create();

        return [
            '@context' => array_merge(
                $data ?? [],
                (new JsonLdEntityContext($model))->build()
            ),
        ];
    }
}
