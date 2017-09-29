<?php

namespace eWar\Framework\Database;

/**
 * Class Connection
 * @package eWar\Framework\Database
 */
class Connection
{
    /**
     * @var string[]
     */
    private $queryString;

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var \PDOStatement[]
     */
    private $preparedStatement;

    /**
     * @var int
     */
    private $currentIndex;


    /**
     * Connection constructor.
     *
     * @param array $credentials
     */
    public function __construct(array $credentials)
    {
        $this->currentIndex = 0;
        $this->pdo = new \PDO(
            'mysql:host=' . $credentials['host'] . ';dbname=' . $credentials['database'],
            $credentials['user'],
            $credentials['password']
        );
    }


    /**
     * getQueryString
     * @return string|bool
     */
    private function getQueryString() : string
    {
        return $this->queryString[$this->currentIndex] ?? '';
    }


    /**
     * queryString
     *
     * @param string $data
     */
    private function queryString(string $data) : void
    {
        if (! isset($this->queryString[$this->currentIndex])) {
            $this->queryString[$this->currentIndex] = '';
        }

        $this->queryString[$this->currentIndex] .= $data;
    }


    /**
     * select
     *
     * @param array|null $columns
     *
     * @return Connection
     */
    public function select(array $columns = null) : Connection
    {
        if (! empty($this->getQueryString())) {
            $this->currentIndex++;
        }

        $this->queryString('SELECT *');

        if ($columns) {
            $this->queryString('SELECT ' . implode(',', $columns));
        }

        return $this;
    }


    /**
     * from
     *
     * @param string $tableName
     *
     * @return Connection
     */
    public function from(string $tableName) : Connection
    {
        $this->queryString(' FROM `' . $tableName . '`');

        return $this;
    }


    /**
     * where
     *
     * @param string $condition
     *
     * @return Connection
     */
    public function where(string $condition) : Connection
    {
        $this->queryString(' WHERE ' . $condition);

        return $this;
    }


    /**
     * andWhere
     *
     * @param string $condition
     *
     * @return Connection
     */
    public function andWhere(string $condition) : Connection
    {
        $this->queryString(' AND ' . $this->pdo->quote($condition));

        return $this;
    }


    /**
     * orWhere
     *
     * @param string $condition
     *
     * @return Connection
     */
    public function orWhere(string $condition) : Connection
    {
        $this->queryString(' OR ' . $this->pdo->quote($condition));

        return $this;
    }


    /**
     * getSingleResult
     * @return array|null
     */
    public function getSingleResult() : ?array
    {
        $this->getPreparedStatement()->execute();
        $result = $this->getPreparedStatement()->fetch();
        if ($this->currentIndex > 0) {
            $this->currentIndex--;
        }

        return $result ?: null;
    }


    /**
     * getResult
     * @return array|null
     */
    public function getResult() : ?array
    {
        $this->getPreparedStatement()->execute();
        $result = $this->getPreparedStatement()->fetchAll();

        if ($this->currentIndex > 0) {
            $this->currentIndex--;
        }

        return $result ?: null;
    }


    /**
     * bindParam
     *
     * @param string $needle
     * @param mixed  $value
     * @param string $type
     *
     * @return Connection
     */
    public function bindParam(string $needle, $value, string $type = 'string') : Connection
    {
        switch ($type) {
            case 'int':
                $type = \PDO::PARAM_INT;
                break;
            case 'null':
                $type = \PDO::PARAM_NULL;
                break;
            case 'bool':
                $type = \PDO::PARAM_BOOL;
                break;
            default:
            case 'string':
                $type = \PDO::PARAM_STR;
                break;
        }

        $this->getPreparedStatement()->bindParam($needle, $value, $type);

        return $this;
    }


    /**
     * limit
     *
     * @param int $count
     *
     * @return Connection
     */
    public function limit(int $count) : Connection
    {
        $this->queryString(' LIMIT ' . $count);

        return $this;
    }


    /**
     * prepare
     * @return \PDOStatement
     */
    private function getPreparedStatement() : \PDOStatement
    {
        if (! isset($this->preparedStatement[$this->currentIndex])) {
            $this->preparedStatement[$this->currentIndex] = $this->pdo->prepare($this->getQueryString());
        }

        return $this->preparedStatement[$this->currentIndex];
    }
}
