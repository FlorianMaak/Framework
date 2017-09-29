<?php

namespace eWar\Framework\Http;

/**
 * Class RequestObject
 * @package eWar\Framework\Http
 */
class RequestObject
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $controller;

    /**
     * @var string
     */
    private $action;

    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    private $payload;
    /**
     * @var string
     */
    private $error;


    /**
     * RequestObject constructor.
     */
    public function __construct()
    {
    }


    /**
     * @return string
     */
    public function getError() : ?string
    {
        return $this->error;
    }


    /**
     * @param string $error
     */
    public function setError(string $error) : void
    {
        $this->error = $error;
    }


    /**
     * @return string
     */
    public function getName() : ?string
    {
        return $this->name;
    }


    /**
     * @param string $name
     */
    public function setName(string $name) : void
    {
        $this->name = $name;
    }


    /**
     * @return string
     */
    public function getType() : ?string
    {
        return $this->type;
    }


    /**
     * @param string $type
     */
    public function setType(string $type) : void
    {
        $this->type = $type;
    }


    /**
     * @return string
     */
    public function getController() : string
    {
        return $this->controller;
    }


    /**
     * @param string $controller
     */
    public function setController(string $controller) : void
    {
        $this->controller = $controller;
    }


    /**
     * @return string
     */
    public function getAction() : string
    {
        return $this->action;
    }


    /**
     * @param string $action
     */
    public function setAction(string $action) : void
    {
        $this->action = $action;
    }


    /**
     * @return string
     */
    public function getMethod() : string
    {
        return $this->method;
    }


    /**
     * @param string $method
     */
    public function setMethod(string $method) : void
    {
        $this->method = $method;
    }


    /**
     * @return array
     */
    public function getPayload() : ?array
    {
        return $this->payload;
    }


    /**
     * @param array $payload
     */
    public function setPayload(array $payload) : void
    {
        $this->payload = $payload;
    }

}
