<?php

namespace eWar\Framework\Connector;

use eWar\Framework\Database\Connection;

/**
 * Class ConnectorPool
 * @package eWar\Framework\Connector
 */
class ConnectorPool
{
    /**
     * @var ConnectorInterface[]
     */
    private $connectors;


    /**
     * ConnectorPool constructor.
     *
     * @param array      $connectorNames
     * @param Connection $connection
     */
    public function __construct(array $connectorNames, Connection $connection)
    {
        foreach ($connectorNames as $name) {
            try {
                $reflection = new \ReflectionClass($name);
                $this->connectors[$reflection->getShortName()] = new $name($connection);
            } catch (\ReflectionException $e) {
                print('Connector not found!');
            }
        }
    }


    /**
     * getConnectors
     * @return ConnectorInterface[]
     */
    public function getConnectors() : array
    {
        return $this->connectors;
    }


    /**
     * getConnector
     *
     * @param string $className
     *
     * @return ConnectorInterface
     */
    public function getConnector(string $className) : ConnectorInterface
    {
        return $this->connectors[$className];
    }
}
