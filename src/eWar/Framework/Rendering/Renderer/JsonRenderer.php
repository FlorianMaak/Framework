<?php

namespace eWar\Framework\Rendering\Renderer;

use eWar\Framework\Http\RequestHandler;
use eWar\Framework\Rendering\ViewControllerInterface;

/**
 * Class JsonRenderer
 * @package eWar\Framework\Rendering
 */
class JsonRenderer implements RendererInterface
{
    /**
     * @var RequestHandler
     */
    private $requestHandler;


    /**
     * JsonRenderer constructor.
     *
     * @param RequestHandler $requestHandler
     * @param string         $appDir
     */
    public function __construct(RequestHandler $requestHandler, string $appDir)
    {
        $this->requestHandler = $requestHandler;
    }


    /**
     * prepare
     *
     * @param ViewControllerInterface $ctrl
     */
    public function prepare(ViewControllerInterface $ctrl) : void
    {

    }


    /**
     * output
     *
     * @param array $data
     * @param array ...$args
     */
    public function output(array $data, ...$args) : void
    {
        echo json_encode($data);
    }


    /**
     * throwError
     *
     * @param int $statusCode
     */
    public function throwError(int $statusCode) : void
    {
        $this->requestHandler->throwError($statusCode);
    }
}
