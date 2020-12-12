<?php
declare(strict_types=1);

namespace MixerApi\CollectionView;

use Adbar\Dot;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\Event;
use Cake\Event\EventManager;

/**
 * Adds CollectionView as an OpenAPI schema to SwaggerBake
 *
 * @package MixerApi\CollectionView
 * @codeCoverageIgnore
 */
class SwaggerBakeExtension
{
    /**
     * Listen for `SwaggerBake.initialize` event
     *
     * @return void
     */
    public function listen(): void
    {
        if (!in_array('SwaggerBake', Plugin::loaded())) {
            return;
        }

        EventManager::instance()
            ->on('SwaggerBake.initialize', function (Event $event) {
                $this->addSchema($event);
            });
    }

    /**
     * OpenAPI Schema
     *
     * @param \Cake\Event\Event $event Cake event instance
     * @return mixed
     */
    private function addSchema(Event $event)
    {
        if (!class_exists(\SwaggerBake\Lib\OpenApi\Schema::class)) {
            return $event->getSubject();
        }
        if (!class_exists(\SwaggerBake\Lib\Swagger::class)) {
            return $event->getSubject();
        }
        if (!class_exists(\SwaggerBake\Lib\OpenApi\SchemaProperty::class)) {
            return null;
        }

        $config = Configure::read('CollectionView');

        $dot = new Dot();
        foreach ($config as $key => $value) {
            $dot->set($key, $value);
        }

        $keys = $dot->all();
        $collection = array_search('{{collection}}', $config);
        $url = array_search('{{url}}', $keys[$collection]);
        $count = array_search('{{count}}', $keys[$collection]);
        $pages = array_search('{{pages}}', $keys[$collection]);
        $total = array_search('{{total}}', $keys[$collection]);
        $next = array_search('{{next}}', $keys[$collection]);
        $prev = array_search('{{prev}}', $keys[$collection]);
        $first = array_search('{{first}}', $keys[$collection]);
        $last = array_search('{{last}}', $keys[$collection]);
        $data = array_search('{{data}}', $keys);

        $pagination = (new \SwaggerBake\Lib\OpenApi\Schema())
            ->setName($collection)
            ->setType('object')
            ->pushProperty($this->buildProperty($url, 'string', '/collection', 'url'))
            ->pushProperty($this->buildProperty($url, 'string', '/collection', 'url'))
            ->pushProperty($this->buildProperty($count, 'integer', 50))
            ->pushProperty($this->buildProperty($pages, 'integer', 20))
            ->pushProperty($this->buildProperty($total, 'integer', 200))
            ->pushProperty(
                $this->buildProperty($next, 'string', '/collection?page=:number', 'url')
            )
            ->pushProperty(
                $this->buildProperty($prev, 'string', '/collection?page=:number', 'url')
            )
            ->pushProperty(
                $this->buildProperty($first, 'string', '/collection?page=:number', 'url')
            )
            ->pushProperty(
                $this->buildProperty($last, 'string', '/collection?page=:number', 'url')
            );

        $swagger = $event->getSubject();
        $array = $swagger->getArray();

        $collection = (new \SwaggerBake\Lib\OpenApi\Schema())
            ->setType('object')
            ->pushProperty($pagination)
            ->setVendorProperty('x-data-element', $data);

        $array['x-swagger-bake']['components']['schemas']['Generic-Collection'] = $collection;

        $swagger->setArray($array);

        return $swagger;
    }

    /**
     * Returns instance of \SwaggerBake\Lib\OpenApi\SchemaProperty
     *
     * @param string $key array key
     * @param string $type property type
     * @param mixed $example optional example
     * @param string|null $format optional format
     * @return mixed
     */
    private function buildProperty(string $key, string $type, $example = null, ?string $format = null)
    {
        if (!class_exists(\SwaggerBake\Lib\OpenApi\SchemaProperty::class)) {
            return null;
        }

        $pieces = explode('.', $key);
        $name = end($pieces);
        $property = (new \SwaggerBake\Lib\OpenApi\SchemaProperty())->setName($name)->setType($type);

        if ($example) {
            $property->setExample($example);
        }

        if ($format) {
            $property->setFormat($format);
        }

        return $property;
    }
}
