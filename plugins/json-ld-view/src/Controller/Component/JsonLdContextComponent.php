<?php
declare(strict_types=1);

namespace MixerApi\JsonLdView\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Database\Connection;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Inflector;
use MixerApi\Core\Model\ModelFactory;
use MixerApi\Core\Utility\NamespaceUtility;
use MixerApi\JsonLdView\JsonLdEntityContext;

class JsonLdContextComponent extends Component
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @param \Cake\Controller\ComponentRegistry $registry ComponentRegistry
     * @param array $config configurations
     */
    public function __construct(ComponentRegistry $registry, array $config = [])
    {
        parent::__construct($registry, $config);

        $config = Configure::read('JsonLdView');
        if (!empty($config['vocabUrl'])) {
            $this->data['@vocab'] = $config['vocabUrl'];
        }
        if ($config['isHydra']) {
            $this->data['hydra'] = 'http://www.w3.org/ns/hydra/core#';
        }
    }

    /**
     * Returns the entity in JSON-LD form as an array
     *
     * @param string $entityName entity name (singular)
     * @return array
     */
    public function build(string $entityName): array
    {
        $table = NamespaceUtility::findClass(
            Configure::read('App.namespace') . '\Model\Table\\',
            Inflector::camelize(Inflector::pluralize($entityName)) . 'Table'
        );

        $connection = ConnectionManager::get('default');

        if (!$connection instanceof Connection) {
            throw new \RuntimeException('Unable to get Database Connection instance');
        }

        $model = (new ModelFactory($connection, new $table()))->create();

        return [
            '@context' => array_merge(
                $this->data,
                (new JsonLdEntityContext($model))->build()
            ),
        ];
    }
}
