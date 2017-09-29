<?php

namespace eWar\Framework\Connector;

use eWar\Framework\Database\Connection;

/**
 * Interface ConnectorInterface
 * @package eWar\Framework\Database
 */
interface ConnectorInterface
{
    /**
     * ConnectorInterface constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection);
}
