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
        $this->renderer[PageRenderer::class] = new PageRenderer($requestHandler, $appDir);
        $this->renderer[JsonRenderer::class] = new JsonRenderer($requestHandler, $appDir);
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
    public function getRendererByName($name) : RendererInterface
    {
        if ($name === 'json') {
            return $this->renderer[JsonRenderer::class];
        }

        return $this->renderer[PageRenderer::class];
    }
}
