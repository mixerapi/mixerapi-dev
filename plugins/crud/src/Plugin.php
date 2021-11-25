<?php
declare(strict_types=1);

namespace MixerApi\Crud;

use Cake\Core\BasePlugin;
use Cake\Core\ContainerInterface;
use Cake\Core\PluginApplicationInterface;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Http\Exception\MethodNotAllowedException;

/**
 * Plugin for Crud
 *
 * @experimental
 */
class Plugin extends BasePlugin
{
    protected $name = 'MixerApi/Crud';

    /**
     * Console middleware
     *
     * @var bool
     */
    protected $consoleEnabled = false;

    /**
     * Enable middleware
     *
     * @var bool
     */
    protected $middlewareEnabled = false;

    /**
     * Load routes or not
     *
     * @var bool
     */
    protected $routesEnabled = false;

    /**
     * Enforce request->allowMethod() for the follow action/http-method pair.
     *
     * To alter: Set $options['allowedMethods'] to the mapping of your choice
     * To disable: Set $options['allowedMethods'] to an empty array to turn this functionality off.
     *
     * @var array
     */
    private $allowedMethods = [
        'add' => ['post'],
        'index' => ['get'],
        'view' => ['get'],
        'edit' => ['patch','put','patch'],
        'delete' => ['delete'],
    ];

    /**
     * Should viewVars be serialized automatically? Defaults to true, set to false to disable.
     *
     * @var bool
     */
    private $doSerialize = true;

    /**
     * See this class for allowed $options
     *
     * @param array $options options
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->allowedMethods = $options['allowedMethods'] ?? $this->allowedMethods;
        $this->doSerialize = $options['doSerialize'] ?? $this->doSerialize;
    }

    /**
     * Load all the plugin configuration and bootstrap logic.
     *
     * The host application is provided as an argument. This allows you to load
     * additional plugin dependencies, or attach events.
     *
     * @param \Cake\Core\PluginApplicationInterface $app The host application
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        $this->allowedMethodsEvent();
        $this->serializeEvent();
    }

    /**
     * Register application container services.
     *
     * @param \Cake\Core\ContainerInterface $container The Container to update.
     * @return void
     * @link https://book.cakephp.org/4/en/development/dependency-injection.html#dependency-injection
     */
    public function services(ContainerInterface $container): void
    {
        /** @var \League\Container\Container $container */
        $container->addServiceProvider(new CrudServiceProvider());
    }

    /**
     * Registers listener to enforce allowed methods
     *
     * @return void
     */
    private function allowedMethodsEvent(): void
    {
        if (empty($this->allowedMethods)) {
            return;
        }

        EventManager::instance()->on('Controller.initialize', function (Event $event) {
            /** @var \Cake\Controller\Controller $controller */
            $controller = $event->getSubject();
            $action = $controller->getRequest()->getParam('action');

            if (is_array($this->allowedMethods) && isset($this->allowedMethods[$action])) {
                try {
                    $controller->getRequest()->allowMethod($this->allowedMethods[$action]);
                } catch (MethodNotAllowedException $e) {
                    throw new MethodNotAllowedException(
                        'Method Not Allowed. Must be one of: ' . implode($this->allowedMethods[$action])
                    );
                }
            }
        });
    }

    /**
     * Register listener for automatic serialization on all responses with a status code in the 200-299 range.
     *
     * @return void
     */
    private function serializeEvent(): void
    {
        if (!$this->doSerialize) {
            return;
        }

        EventManager::instance()->on('Controller.beforeRender', function (Event $event) {
            /** @var \Cake\Controller\Controller $controller */
            $controller = $event->getSubject();
            $action = $controller->getRequest()->getParam('action');
            if (!in_array($action, ['index', 'view', 'add', 'edit', 'delete'])) {
                return;
            }

            if ($controller->getResponse()->getStatusCode() >= 300) {
                return;
            }

            $keys = array_keys($controller->viewBuilder()->getVars());
            if (!empty($keys)) {
                $controller->viewBuilder()->setOption('serialize', reset($keys));
            }
        });
    }
}
