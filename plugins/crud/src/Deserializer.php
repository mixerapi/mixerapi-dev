<?php
declare(strict_types=1);

namespace MixerApi\Crud;

use Cake\Http\Exception\BadRequestException;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\Utility\Xml;

/**
 * Deserializes a request body.
 *
 * @experimental
 */
class Deserializer implements DeserializerInterface
{
    /**
     * @param \Cake\Http\Response|null $response The CakePHP Response
     */
    public function __construct(private ?Response $response = null)
    {
        $this->response = $response ?? new Response();
    }

    /**
     * @inheritDoc
     */
    public function deserialize(ServerRequest $request): array
    {
        $contentType = $request->contentType() ?? '';

        $mappedType = $this->response->mapType($contentType);
        if (empty($mappedType)) {
            return $request->getData();
        }

        $mappedTypes = [];
        if (is_string($mappedType)) {
            $mappedTypes = [$mappedType];
        }

        if (in_array('xml', $mappedTypes)) {
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
