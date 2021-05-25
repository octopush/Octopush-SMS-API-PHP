<?php

declare(strict_types=1);

namespace Octopush\Request;

abstract class BaseRequest
{
    /** @var string */
    protected $uri;

    /** @var string */
    protected $method;
    
    protected bool $simulation_mode;

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }
    
    public function setSimulationMode(bool $mode): void
    {
        $this->simulation_mode = $mode;
    }   

    abstract public function getQueryArray(): array;

    /**
     * @param array $parameters
     *
     * @return array
     */
    protected function filterQueryString(array $parameters): array
    {
        return array_filter($parameters, function ($item) {
            return $item !== null;
        });
    }
}
