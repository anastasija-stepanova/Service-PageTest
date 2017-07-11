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

            return $data;
        }
        else
        {
            return null;
        }
    }
}