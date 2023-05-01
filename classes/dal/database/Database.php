<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/ConfigManager.php");

use \PDO as PDO;
// Data access object(DAO)
class DAO {
    private $username;
    private $password;
    private $host;
    private $connection;
    private $schemaName;

    public function __construct(string $host, string $un, string $psw, string $schema) {
        $this->host = $host;
        $this->username = $un;
        $this->password = $psw;
        $this->schemaName = $schema;
    }

    public function Connect() {
        if(empty($this->host)){
            throw new Exception("Invalid host");
        }
        try {
            // create connection with db. store it into $this->connection
            $this->connection = //new \PDO($this->host, $this->username, $this->password, $this->schemaName);
                new \PDO('mysql:host=' . $this->host . ';port='.ConfigManager::$DatabasePort.';dbname=' . $this->schemaName, $this->username, $this->password);
            $this->connection->query('SET NAMES \'utf8\'');
        } catch (\PDOException $e) {
            return new Message(2000, "Connection error to database");
        }
        return new Message(0,"ok");
    }

    /**
     * @param $sql
     * @param array $params
     * @return null|int
     */
    public function query($sql, $params = array()) :?\PDOStatement
    {
        if ($this->connection == null) {
            return null;
        }
        if ($params!=null && !is_array($params)) {
            $params = [$params];
        }

        /*if (empty($params)) {
             return $this->connection->query($sql);
        }*/

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function CloseCursor($stmt){
        try{
            $stmt->closeCursor();
        }catch(Exception $e){}
    }

    /**
     * @return string
     */
    public function getLastInsertId()
    {
        return $this->connection->lastInsertId();
    }
}