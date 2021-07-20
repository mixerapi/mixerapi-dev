<?php
declare(strict_types=1);

namespace MixerApi\Crud;

use Cake\Http\Exception\BadRequestException;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\Utility\Xml;

/**
 * @experimental
 */
class Deserializer
{
    /**
     * @var \Cake\Http\Response
     */
    private $response;

    /**
     * @param \Cake\Http\Response|null $response the response
     */
    public function __construct(?Response $response = null)
    {
        $this->response = $response ?? new Response();
    }

    /**
     * Deserializes the request body
     *
     * @param \Cake\Http\ServerRequest $request the request
     * @return array
     */
    public function deserialize(ServerRequest $request): array
    {
        if ($this->response->mapType($request->contentType()) === 'xml') {
            $array = Xml::toArray(Xml::build((string)$request->getBody()));

            if (empty($array)) {
                // @codeCoverageIgnoreStart
                throw new BadRequestException('Xml payload is empty');
                // @codeCoverageIgnoreEnd
            }

            $keys = array_keys($array);
            $node = reset($keys);

            if (!isset($array[$node]) || empty($array[$node])) {
                throw new BadRequestException('Xml not not found');
            }

            return $array[$node];
        }

        return $request->getData();
    }
}
