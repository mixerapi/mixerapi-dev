<?php
declare(strict_types=1);

namespace MixerApi\Rest\Lib;

use Cake\Event\Event;
use Cake\Event\EventManager;

/**
 * Changes default response status codes for POST and DELETE
 */
class ResponseStatusCodeModifier
{
    /**
     * Listens for the Controller.beforeRender event and changes the response status code based on $statusCode values.
     *
     * @param array $statusCodes A key-value pair of action => status code
     * @return void
     */
    public function listen(array $statusCodes): void
    {
        EventManager::instance()
            ->on('Controller.beforeRender', function (Event $event) use ($statusCodes) {
                /** @var \Cake\Controller\Controller $controller */
                $controller = $event->getSubject();
                $action = $controller->getRequest()->getParam('action');
                $currentStatusCode = $controller->getResponse()->getStatusCode();
                if (array_key_exists($action, $statusCodes) && in_array($currentStatusCode, range(200, 299))) {
                    $controller->setResponse($controller->getResponse()->withStatus($statusCodes[$action]));
                }
            });
    }
}
