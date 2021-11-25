<?php
declare(strict_types=1);

namespace MixerApi\ExceptionRender;

class ErrorDecorator
{
    /**
     * @param array $viewVars The view variables set by the controller action.
     * @param array $serialize The items set to be serialized by the controller action.
     */
    public function __construct(private array $viewVars, private array $serialize)
    {
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
