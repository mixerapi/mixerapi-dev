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
        $exception = new CakeException();
        $exception->responseHeader(['x-test' => 'testing']);

        $response = (new MixerApiExceptionRenderer($exception, $request))->render();

        $this->assertEquals('application/json', $response->getHeaders()['Content-Type'][0]);
        $this->assertEquals('testing', $response->getHeaders()['x-test'][0]);
    }

    public function test_render_http_exception_with_headers(): void
    {
        $request = new ServerRequest();
        $request = $request->withHeader('Accept', 'application/json');
        $request = $request->withHeader('Content-Type', 'application/json');
        $exception = new HttpException();
        $exception->setHeaders(['x-test' => 'testing']);

        $response = (new MixerApiExceptionRenderer($exception, $request))->render();

        $this->assertEquals('application/json', $response->getHeaders()['Content-Type'][0]);
        $this->assertEquals('testing', $response->getHeaders()['x-test'][0]);
    }
}
