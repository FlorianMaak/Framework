<?php

namespace eWar\Framework\Rendering;

use eWar\Framework\Connector\ConnectorPool;

/**
 * Interface ViewControllerInterface
 * @package eWar\Blog\Core\Rendering
 */
interface ViewControllerInterface
{
    /**
     * ViewControllerInterface constructor.
     *
     * @param ConnectorPool $connectorPool
     */
    public function __construct(ConnectorPool $connectorPool);


    /**
     * getConnectors
     * @return array
     */
    public static function getConnectors() : array;
}
