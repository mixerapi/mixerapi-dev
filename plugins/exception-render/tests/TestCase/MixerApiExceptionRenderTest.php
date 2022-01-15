<?php

namespace MixerApi\ExceptionRender\Test\TestCase;

use Cake\Core\Exception\CakeException;
use Cake\Http\Exception\HttpException;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use MixerApi\ExceptionRender\MixerApiExceptionRenderer;
use MixerApi\ExceptionRender\ValidationException;

class MixerApiExceptionRenderTest extends TestCase
{
    public function test_get_error(): void
    {
        $this->assertInstanceOf(
            ValidationException::class,
            (new MixerApiExceptionRenderer(new ValidationException()))->getError()
        );
    }

    public function test_render_cake_exception_with_headers(): void
    {
        $request = new ServerRequest();
        $request = $request->withHeader('Accept', 'application/json');
        $request = $request->withHeader('Content-Type', 'application/json');

        $response = (new MixerApiExceptionRenderer(new CakeException(), $request))->render();
        $this->assertNotEmpty($response->getHeaders());
    }

    public function test_render_http_exception_with_headers(): void
    {
        $request = new ServerRequest();
        $request = $request->withHeader('Accept', 'application/json');
        $request = $request->withHeader('Content-Type', 'application/json');

        $response = (new MixerApiExceptionRenderer(new HttpException(), $request))->render();
        $this->assertNotEmpty($response->getHeaders());
    }
}
