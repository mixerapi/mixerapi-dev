<?php
declare(strict_types=1);

namespace MixerApi\Crud;

use Cake\Http\ServerRequest;

interface DeserializerInterface
{
    /**
     * Deserializes the request body. This is only necessary for XML payloads. Returning
     *
     * @todo See if this can be removed in favor of BodyParserMiddleware
     * @link https://book.cakephp.org/4/en/controllers/middleware.html#body-parser-middleware
     * @param \Cake\Http\ServerRequest $request The CakePHP ServerRequest
     * @return array
     */
    public function deserialize(ServerRequest $request): array;
}
