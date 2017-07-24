<?php

class Database
{
    private $pdo;

    public function __construct($host, $database, $userName, $password)
    {
        $this->pdo = new PDO("mysql:host=" . $host . ';dbname=' . $database, $userName, $password);
    }

    public function executeQuery($query, $params = [])
    {
        $data = [];

        $stm = $this->pdo->prepare($query);

        if ($stm)
        {
            $stm->execute($params);

            while ($row = $stm->fetch(PDO::FETCH_ASSOC))
            {
                array_push($data, $row);
            }

            $stm->closeCursor();
        }

        return $data;
    }

    public function selectOneRowDatabase($query, $params = [])
    {
        $result = $this->executeQuery($query, $params);

        $oneRowResult = [];

        if (array_key_exists(0, $result))
        {
            $oneRowResult = $result[0];
        }

        return $oneRowResult;
    }
}