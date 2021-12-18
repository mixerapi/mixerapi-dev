<?php
declare(strict_types=1);

namespace MixerApi\Core\Response;

use Cake\Event\Event;
use Cake\Event\EventManager;

class ResponseModifier
{
    /**
     * @param string $type Type Alias that will be used to modify the response e.g. jsonld or hal+json
     * @param string $viewClass The View Class associated with $this->type alias
     */
    public function __construct(private string $type, private string $viewClass)
    {
    }

    /**
     * Registers Controller.initialize listener which performs the following actions:
     * - Modifies the CakePHP Response type map if necessary to add additional mime types (note: this will be removed
     * in a future version of the application).
     * - Sets the view class map to render responses in the requested mime type.
     *
     * @return void
     */
    public function listen(): void
    {
        EventManager::instance()
            ->on('Controller.initialize', function (Event $event) {

                /** @var \Cake\Controller\Controller $controller */
                $controller = $event->getSubject();
                if ($controller->components()->has('RequestHandler')) {
                    $controller->RequestHandler->setConfig(
                        'viewClassMap.' . $this->type,
                        $this->viewClass
                    );
                }
            });
    }
}
