<?php
declare(strict_types=1);

namespace MixerApi\ExceptionRender;

use Cake\Core\Configure;
use Cake\Core\Exception\CakeException;
use Cake\Error\Debugger;
use Cake\Error\Renderer\WebExceptionRenderer;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Http\Exception\HttpException;
use Psr\Http\Message\ResponseInterface;
use ReflectionClass;
use Throwable;

/**
 * Exception Renderer.
 *
 * Captures and handles all unhandled exceptions. Displays helpful framework errors when debug is true.
 * When debug is false a ExceptionRenderer will render 404 or 500 errors. If an uncaught exception is thrown
 * and it is a type that ExceptionHandler does not know about it will be treated as a 500 error.
 *
 * ### Implementing application specific exception rendering
 *
 * You can implement application specific exception handling by creating a subclass of
 * ExceptionRenderer and configure it to be the `exceptionRenderer` in config/error.php
 *
 * #### Using a subclass of ExceptionRenderer
 *
 * Using a subclass of ExceptionRenderer gives you full control over how Exceptions are rendered, you
 * can configure your class in your config/app.php.
 *
 * @uses \MixerApi\ExceptionRender\ErrorDecorator
 * @uses ReflectionClass
 * @uses \Cake\Event\Event
 * @uses \Cake\Event\EventManager
 */
class MixerApiExceptionRenderer extends WebExceptionRenderer
{
    /**
     * Renders the response for the exception.
     *
     * @return \Cake\Http\Response The response to be sent.
     */
    public function render(): ResponseInterface
    {
        $exception = $this->error;
        $code = $this->getHttpCode($exception);
        $method = $this->_method($exception);
        $template = $this->_template($exception, $method, $code);
        $this->clearOutput();

        if (method_exists($this, $method)) {
            return $this->_customMethod($method, $exception);
        }

        $message = $this->_message($exception, $code);
        $url = $this->controller->getRequest()->getRequestTarget();
        $response = $this->controller->getResponse();

        if ($exception instanceof CakeException) {
            $responseHeaders = $exception->getAttributes()['responseHeaders'] ?? [];
            foreach ((array)$responseHeaders as $key => $value) {
                $response = $response->withHeader($key, $value);
            }
        }
      
        if ($exception instanceof HttpException) {
            foreach ($exception->getHeaders() as $name => $value) {
                $response = $response->withHeader($name, $value);
            }
        }
        $response = $response->withStatus($code);

        $exceptions = [$exception];
        $previous = $exception->getPrevious();
        while ($previous != null) {
            $exceptions[] = $previous;
            $previous = $previous->getPrevious();
        }

        $viewVars = [
            'exception' => (new ReflectionClass($exception))->getShortName(),
            'message' => $message,
            'url' => h($url),
            'code' => $code,
            'error' => $exception,
            'exceptions' => $exceptions,
        ];

        if ($this->error instanceof ValidationException) {
            $viewVars['violations'] = $this->error->getErrors();
            $viewVars['message'] = $this->error->getMessage();
        }

        $viewVars = $this->debugViewVars($exception, $viewVars);
        $serialize = array_keys($viewVars);

        $errorDecorator = new ErrorDecorator($viewVars, $serialize);
        EventManager::instance()->dispatch(
            new Event(
                'MixerApi.ExceptionRender.beforeRender',
                $errorDecorator,
                ['exception' => $this]
            )
        );
        $viewVars = $errorDecorator->getViewVars();
        $serialize = $errorDecorator->getSerialize();

        $this->controller->set($viewVars);
        $this->controller->viewBuilder()->setOption('serialize', $serialize);

        if ($exception instanceof CakeException && Configure::read('debug')) {
            $this->controller->set($exception->getAttributes());
        }

        $this->controller->setResponse($response);

        return $this->_outputMessage($template);
    }

    /**
     * @return \Throwable
     */
    public function getError(): Throwable
    {
        return $this->error;
    }

    /**
     * Updates the viewVars with debug data if debug is enabled.
     *
     * @param mixed $exception instance of Cake Core Exception or Error
     * @param array $viewVars the current viewVars array
     * @return array
     */
    private function debugViewVars($exception, array $viewVars): array
    {
        if (!Configure::read('debug')) {
            unset($viewVars['error']);
            unset($viewVars['exceptions']);

            return $viewVars;
        }

        $trace = (array)Debugger::formatTrace(
            $exception->getTrace(),
            [
                'format' => 'array',
                'args' => false,
            ]
        );

        $origin = [
            'file' => $exception->getFile() ?: 'null',
            'line' => $exception->getLine() ?: 'null',
        ];

        // traces don't include the origin file/line.
        array_unshift($trace, $origin);
        $viewVars['trace'] = $trace;
        $viewVars += $origin;

        return $viewVars;
    }
}
