<?php

namespace eWar\Framework;

use eWar\Framework\Connector\ConnectorPool;
use eWar\Framework\Database\Connection;
use eWar\Framework\Http\RequestHandler;
use eWar\Framework\Rendering\Renderer\RendererInterface;

/**
 * Class AbstractApplication
 * @package eWar\Framework
 */
abstract class AbstractApplication
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var RequestHandler
     */
    private $requestHandler;

    /**
     * @var ConnectorPool
     */
    private $connectorPool;

    /**
     * @var array
     */
    private $config;

    /**
     * @var string
     */
    private $appDir;


    /**
     * Application constructor.
     */
    public function __construct()
    {
        define('PUBLIC_DIR', $_SERVER['DOCUMENT_ROOT']);
        define('GLOBAL_DIR', PUBLIC_DIR . '/../');

        $this->requestHandler = new RequestHandler($this->getRoutes());

        $this->loadRoute();
    }


    /**
     * loadRoute
     */
    private function loadRoute() : void
    {
        $routeData = $this->requestHandler->getRoute();
        $rendererType = $routeData->getType();

        try {
            if (! class_exists($routeData->getController())) {
                $this->requestHandler->throwError(404);
            }

            $reflection = new \ReflectionClass($routeData->getController());
            $instance = $reflection->newInstanceWithoutConstructor();
            $controller = $routeData->getController();
            $viewController = new $controller($this->getConnectors($instance::getConnectors()));
            $this->renderer = new $rendererType($this->requestHandler, $this->getAppDir());
            $this->renderer->prepare($viewController);
            $viewController->{$routeData->getAction()}($this->renderer, $routeData);
        } catch (\ReflectionException $e) {
            $this->requestHandler->throwError(503);
        }
    }


    /**
     * getAppDir
     * @return string
     */
    public function getAppDir() : string
    {
        if (! $this->appDir) {
            try {
                $reflector = new \ReflectionClass(get_class($this));
                $this->appDir = dirname($reflector->getFileName());
            } catch (\ReflectionException $e) {
                $this->requestHandler->throwError(503);
            }
        }

        return $this->appDir;
    }


    /**
     * getRoutes
     * @return array
     */
    abstract public function getRoutes() : array;


    /**
     * getConnectors
     *
     * @param string[] $connectorNames
     *
     * @return ConnectorPool
     */
    private function getConnectors(array $connectorNames) : ConnectorPool
    {
        if (! $this->connectorPool) {
            $this->connectorPool = new ConnectorPool($connectorNames, new Connection($this->loadConfig('database')));
        }

        return $this->connectorPool;
    }


    /**
     * loadConfig
     *
     * @param string $name
     *
     * @return array
     */
    private function loadConfig(string $name) : array
    {
        if (! $this->config[$name]) {
            $this->config[$name] = (array) json_decode(file_get_contents(GLOBAL_DIR . '/config/' . $name . '.json'));
        }

        return $this->config[$name];
    }
}
