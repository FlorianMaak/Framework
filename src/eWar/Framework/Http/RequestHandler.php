<?php

namespace eWar\Framework\Http;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RequestHandler
 * @package eWar\Framework\Http
 */
class RequestHandler
{
    /**
     * @var Route[]
     */
    private $routes;

    /**
     * @var UrlMatcher
     */
    private $matcher;

    /**
     * @var array
     */
    private $routeData;


    /**
     * RequestHandler constructor.
     */
    public function __construct()
    {
        $this->routes = $this->loadRoutes();
        $routeCollection = $this->buildCollection();
        $context = new RequestContext('/');
        $this->matcher = new UrlMatcher($routeCollection, $context);
    }


    /**
     * getRoute
     * @return RequestObject
     */
    public function getRoute() : RequestObject
    {
        if(!$this->routeData) {
            $raw = $this->getRouteData();
            $payload = $raw->getPayload();

            if ($raw->getError()) {
                $this->throwError($raw->getError());
            }

            foreach ($raw->getPayload() as $name => $value) {
                settype($payload[$name], $this->routes[$raw->getName()]->types->$name ?? 'string');
            }

            $raw->setPayload($payload);
            $this->routeData = $raw;
        }


        return $this->routeData;
    }


    /**
     * getRouteData
     * @return RequestObject
     */
    public function getRouteData() : RequestObject
    {
        try {
            $data = $this->matcher->match($_GET['route'] ?? '/');
            $output = new RequestObject();
            $output->setName($data['_route']);
            $output->setController($this->routes[$data['_route']]->output->controller);
            $output->setAction($this->routes[$data['_route']]->output->action);
            $output->setMethod($this->routes[$data['_route']]->method ?? 'GET');
            $output->setType($this->routes[$data['_route']]->output->type ?? 'page');

            unset($data['_controller'], $data['_route']);
            $output->setPayload($data);
        } catch (\Exception $e) {
            $error = new RequestObject();
            $error->setError(404);

            return $error;
        }

        return $output;
    }


    /**
     * loadRoutes
     * @return array
     */
    private function loadRoutes() : array
    {
        if (! $this->routes) {
            $this->routes = (array) json_decode(file_get_contents(GLOBAL_DIR . '/config/routes.json'));
        }

        return $this->routes;
    }


    /**
     * buildCollection
     * @return RouteCollection
     */
    private function buildCollection() : RouteCollection
    {
        $collection = new RouteCollection();

        foreach ($this->routes as $name => $data) {
            $route = new Route($data->route, array('_controller' => $data->output->controller)
                , array(), array(), '', array(), array($data->method));
            $collection->add($name, $route);
        }

        return $collection;
    }


    /**
     * throwError
     *
     * @param int $statusCode Http-Statuscode to throw
     */
    public function throwError(int $statusCode) : void
    {
        switch ($statusCode) {
            case 404:
                header('HTTP/1.0 404 not found');
                break;
            case 403:
                header('HTTP/1.0 403 access denied');
                break;
            case 503:
                header('HTTP/1.0 503');
                break;
        }
        exit;
    }
}
