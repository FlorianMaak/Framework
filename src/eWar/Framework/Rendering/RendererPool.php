<?php

namespace eWar\Framework\Rendering;

use eWar\Framework\Http\RequestHandler;
use eWar\Framework\Rendering\Renderer\JsonRenderer;
use eWar\Framework\Rendering\Renderer\PageRenderer;
use eWar\Framework\Rendering\Renderer\RendererInterface;

/**
 * Class ConnectorPool
 * @package eWar\Framework\Rendering
 */
class RendererPool
{
    /**
     * @var RendererInterface[]
     */
    private $renderer;


    /**
     * RendererPool constructor.
     *
     * @param RequestHandler $requestHandler
     * @param string         $appDir
     */
    public function __construct(RequestHandler $requestHandler, string $appDir)
    {
        $type = $requestHandler->getRoute()->getType();
        $this->renderer[$type] = new $type($requestHandler, $appDir);
    }


    /**
     * getRenderers
     * @return RendererInterface[]
     */
    public function getRenderers() : array
    {
        return $this->renderer;
    }


    /**
     * getRenderer
     *
     * @param string $className
     *
     * @return RendererInterface
     */
    public function getRenderer(string $className) : RendererInterface
    {
        return $this->renderer[$className];
    }


    /**
     * getRendererByController
     *
     * @param string $name
     *
     * @return RendererInterface
     */
    public function getRendererByClass($class) : RendererInterface
    {
        return $this->renderer[$class];
    }
}
