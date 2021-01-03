<?php
declare(strict_types=1);

namespace MixerApi\ExceptionRender;

class ErrorDecorator
{
    /**
     * @var array
     */
    private $viewVars;

    /**
     * @var array
     */
    private $serialize;

    /**
     * @param array $viewVars viewVars
     * @param array $serialize serialize
     */
    public function __construct(array $viewVars, array $serialize)
    {
        $this->viewVars = $viewVars;
        $this->serialize = $serialize;
    }

    /**
     * @return array
     */
    public function getViewVars(): array
    {
        return $this->viewVars;
    }

    /**
     * @param array $viewVars viewVars array
     * @return $this
     */
    public function setViewVars(array $viewVars)
    {
        $this->viewVars = $viewVars;

        return $this;
    }

    /**
     * @return array
     */
    public function getSerialize(): array
    {
        return $this->serialize;
    }

    /**
     * @param array $serialize list serializable viewVars
     * @return $this
     */
    public function setSerialize(array $serialize)
    {
        $this->serialize = $serialize;

        return $this;
    }
}
