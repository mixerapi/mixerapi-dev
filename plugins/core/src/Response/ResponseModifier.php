<?php
declare(strict_types=1);

namespace MixerApi\Core\Response;

use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Http\Response;
use Cake\Http\ServerRequest;

class ResponseModifier
{
    /**
     * Type Alias
     *
     * @example `jsonld` or `hal+json`
     * @var string
     */
    private $type;

    /**
     * MIME Type mapping array
     *
     * @example `['application/ld+json']`
     * @var string[]
     */
    private $mimeTypes;

    /**
     * @example MixerApi/JsonLdView.JsonLd
     * @var string
     */
    private $viewClass;

    /**
     * @param string $type mime type alias (extension)
     * @param array $mimeTypes mime type mapping array
     * @param string $viewClass view class
     */
    public function __construct(string $type, array $mimeTypes, string $viewClass)
    {
        $this->type = $type;
        $this->mimeTypes = $mimeTypes;
        $this->viewClass = $viewClass;
    }

    /**
     * Registers Controller.startup listener
     *
     * @return void
     */
    public function listen(): void
    {
        EventManager::instance()
            ->on('Controller.initialize', function (Event $event) {

                /** @var \Cake\Controller\Controller $controller */
                $controller = $event->getSubject();

                if ((new Response())->getMimeType($this->type) === false) {
                    $response = $this->modify(
                        $controller->getRequest(),
                        $controller->getResponse()
                    );
                    $controller->setResponse($response);
                }

                if ($controller->components()->has('RequestHandler')) {
                    $controller->RequestHandler->setConfig(
                        'viewClassMap.' . $this->type,
                        $this->viewClass
                    );
                }
            });
    }

    /**
     * Appends JSON-LD MIME types to the Response if the ServerRequest accepts JSON-LD
     *
     * @param \Cake\Http\ServerRequest $request cake ServerRequest
     * @param \Cake\Http\Response $response cake Response
     * @return \Cake\Http\Response
     */
    public function modify(ServerRequest $request, Response $response): Response
    {
        if (!$this->isRequestOfThisMimeType($request)) {
            return $response;
        }

        $response->setTypeMap($this->type, $this->mimeTypes);

        return $response;
    }

    /**
     * @param \Cake\Http\ServerRequest $request cake ServerRequest
     * @return bool
     */
    private function isRequestOfThisMimeType(ServerRequest $request): bool
    {
        if ($request->getParam('_ext') == $this->type) {
            return true;
        }

        foreach ($this->mimeTypes as $type) {
            if ($request->accepts($type)) {
                return true;
            }
        }

        return false;
    }
}
