<?php

namespace eWar\Framework\Rendering;

use eWar\Framework\Connector\ConnectorPool;

/**
 * Interface PageControllerInterface
 * @package eWar\Blog\Core\Rendering
 */
interface PageControllerInterface extends ViewControllerInterface
{
    /**
     * PageControllerInterface constructor.
     *
     * @param ConnectorPool $connectorPool
     */
    public function __construct(ConnectorPool $connectorPool);


    /**
     * getPageTitle
     * @return string
     */
    public function getPageTitle() : string;


    /**
     * getConnectors
     * @return string[]
     */
    public static function getConnectors() : array;
}
