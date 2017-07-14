<?php
/**
 * Created by PhpStorm.
 * User: jean-baptistehuguenin
 * Date: 14/07/2017
 * Time: 18:18
 */

namespace Rest;


class Database
{
    private $connection;

    private static $instance;


    /**
     * Database constructor.
     * @param $host
     * @param $dbName
     * @param $user
     * @param $pass
     */
    public function __construct($host, $dbName, $user, $pass)
    {
        try {
            $this->connection = new \PDO(sprintf("mysql:host=%s;dbname=%s", $host, $dbName), $user, $pass);
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
        }
    }

    /**
     *
     */
    public function __destruct()
    {
        $this->connection = null;
    }

    /**
     * @param $config
     * @return Database
     */
    public static function getInstance($config)
    {
        if(!self::$instance) {
            return new self($config['host'], $config['dbname'], $config['user'], $config['pass']);
        }

        return self::$instance;
    }

    /**
     * @param $query
     * @param string $process
     * @param array $params
     * @param bool $return
     * @return array|bool|mixed
     */
    public function query($query, $process = '', $params = [], $return = true){
        // prepare statement
        $query = $this->connection->prepare($query);
        // check if there are parameter to bind then bind
        if(count($params) != 0)
            $status = $query->execute($params);
        else
            $status = $query->execute();
        if($return){
            // fetch data
            if($process == 'all')
                return $query->fetchAll(PDO::FETCH_ASSOC);
            else
                return  $query->fetch(PDO::FETCH_ASSOC);
        }
        return $status;
    }
}