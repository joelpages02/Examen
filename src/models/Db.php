<?php

class Db {


    private PDO $sql;

    public function __construct($config)
    {
        $dsn = "mysql:dbname={$config['db']['name']};host={$config['db']['host']}";
        
        $user = $config["db"]["user"];
        $password = $config["db"]["pass"];
        try {
            $this->sql = new PDO($dsn, $user, $password);
        } catch (\PDOException $e) {
            die('Ha fallat la connexió: ' . $e->getMessage());
        }
    }

    public function get(): PDO {
        return $this->sql;
    }

}