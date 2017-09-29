<?php

namespace eWar\Framework\Rendering\Renderer;

use eWar\Framework\Http\RequestHandler;
use eWar\Framework\Rendering\ViewControllerInterface;

/**
 * Interface RendererInterface
 * @package eWar\Blog\Core\Rendering\Renderer
 */
interface RendererInterface
{
    /**
     * RendererInterface constructor.
     *
     * @param RequestHandler $requestHandler
     * @param string         $appDir
     */
    public function __construct(RequestHandler $requestHandler, string $appDir);


    /**
     * prepare
     *
     * @param ViewControllerInterface $ctrl
     */
    public function prepare(ViewControllerInterface $ctrl) : void;


    /**
     * output
     *
     * @param array $data
     * @param array ...$args
     */
    public function output(array $data, ...$args) : void;


    /**
     * throwError
     *
     * @param int $statusCode
     */
    public function throwError(int $statusCode) : void;
}
