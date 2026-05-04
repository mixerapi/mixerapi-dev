<?php

namespace MixerApi\ExceptionRender\Test\TestCase;

use Cake\Event\EventManager;
use Cake\Http\Exception\HttpException;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use MixerApi\ExceptionRender\MixerApiExceptionRenderer;
use MixerApi\ExceptionRender\ValidationException;

class MixerApiExceptionRenderTest extends TestCase
{
    public function test_chained_exceptions_serialize_as_structured_arrays(): void
    {
        $previous = new \RuntimeException('Connection refused', 111);
        $exception = new HttpException('Service unavailable', 503, $previous);

        $request = new ServerRequest();
        $request = $request->withHeader('Accept', 'application/json');
        $request = $request->withHeader('Content-Type', 'application/json');

        $response = (new MixerApiExceptionRenderer($exception, $request))->render();

        $body = json_decode((string)$response->getBody(), true);
        $exceptions = $body['exceptions'];

        $this->assertCount(2, $exceptions);

        $this->assertEquals('HttpException', $exceptions[0]['class']);
        $this->assertEquals('Service unavailable', $exceptions[0]['message']);
        $this->assertEquals(503, $exceptions[0]['code']);
        $this->assertArrayHasKey('file', $exceptions[0]);
        $this->assertArrayHasKey('line', $exceptions[0]);

        $this->assertEquals('RuntimeException', $exceptions[1]['class']);
        $this->assertEquals('Connection refused', $exceptions[1]['message']);
        $this->assertEquals(111, $exceptions[1]['code']);
        $this->assertArrayHasKey('file', $exceptions[1]);
        $this->assertArrayHasKey('line', $exceptions[1]);
    }

    public function test_exception_chain_is_capped_at_max_depth(): void
    {
        $exception = new \RuntimeException('root');
        for ($i = 0; $i < 11; $i++) {
            $exception = new \RuntimeException("level $i", 0, $exception);
        }

        $request = new ServerRequest();
        $request = $request->withHeader('Accept', 'application/json');
        $request = $request->withHeader('Content-Type', 'application/json');

        $response = (new MixerApiExceptionRenderer($exception, $request))->render();

        $body = json_decode((string)$response->getBody(), true);
        $this->assertCount(10, $body['exceptions']);
    }

    public function test_chained_exceptions_are_throwable_for_event_listeners(): void
    {
        $previous = new \RuntimeException('Connection refused', 111);
        $exception = new HttpException('Service unavailable', 503, $previous);

        $request = new ServerRequest();
        $request = $request->withHeader('Accept', 'application/json');
        $request = $request->withHeader('Content-Type', 'application/json');

        $captured = null;
        EventManager::instance()->on(
            'MixerApi.ExceptionRender.beforeRender',
            function ($event) use (&$captured) {
                $captured = $event->getSubject()->getViewVars()['exceptions'];
            }
        );

        (new MixerApiExceptionRenderer($exception, $request))->render();

        $this->assertCount(2, $captured);
        $this->assertInstanceOf(\Throwable::class, $captured[0]);
        $this->assertInstanceOf(\Throwable::class, $captured[1]);
        $this->assertEquals('Service unavailable', $captured[0]->getMessage());
        $this->assertEquals('Connection refused', $captured[1]->getMessage());

        EventManager::instance()->off('MixerApi.ExceptionRender.beforeRender');
    }

    public function test_get_error(): void
    {
        $this->assertInstanceOf(
            ValidationException::class,
            (new MixerApiExceptionRenderer(new ValidationException()))->getError()
        );
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
