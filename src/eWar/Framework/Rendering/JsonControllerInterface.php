<?php

namespace eWar\Framework\Rendering;

use eWar\Framework\Connector\ConnectorPool;

/**
 * Interface JsonControllerInterface
 * @package eWar\Blog\Core\Rendering
 */
interface JsonControllerInterface extends ViewControllerInterface
{
    /**
     * JsonControllerInterface constructor.
     *
     * @param ConnectorPool $connectorPool
     */
    public function __construct(ConnectorPool $connectorPool);


    /**
     * getConnectors
     * @return string[]
     */
    public static function getConnectors() : array;
}
