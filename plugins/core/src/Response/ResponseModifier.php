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
     * Type Alias that will be used to modify the response
     *
     * @example `jsonld` or `hal+json`
     * @var string
     */
    private $type;

    /**
     * MIME Type mapping array, these are the mime type's associated with the type alias. For example, jsonld has a
     * mime type mapping of ['application/ld+json']. Some type aliases can be associated with multiple mime types,
     * which are requested via the HTTP Header `accepts`.
     *
     * @example `['application/ld+json']`
     * @var string[]
     */
    private $mimeTypes;

    /**
     * The View Class associated with $this->type alias
     *
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

                // @codeCoverageIgnoreStart
                if ((new Response())->getMimeType($this->type) === false) {
                    $response = $this->modify(
                        $controller->getRequest(),
                        $controller->getResponse()
                    );
                    $controller->setResponse($response);
                }
                // @codeCoverageIgnoreEnd

                if ($controller->components()->has('RequestHandler')) {
                    $controller->RequestHandler->setConfig(
                        'viewClassMap.' . $this->type,
                        $this->viewClass
                    );
                }
            });
    }

    /**
     * Adds unsupported mime types to the CakePHP response object. Note, as of CakePHP 4.2 hal+json, hal+xml, and
     * ld+json are valid mimetypes. See https://github.com/cakephp/cakephp/issues/14796, this code can be removed
     * in future versions of this application.
     *
     * @todo remove when version 4.1 or lower is no longer supported
     * @param \Cake\Http\ServerRequest $request cake ServerRequest
     * @param \Cake\Http\Response $response cake Response
     * @return \Cake\Http\Response
     */
    public function modify(ServerRequest $request, Response $response): Response
    {
        if ($this->isRequestOfThisMimeType($request)) {
            $response->setTypeMap($this->type, $this->mimeTypes);
        }

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
