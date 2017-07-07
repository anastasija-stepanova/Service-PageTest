<?php

class Database
{
    private $pdo;

    public function __construct($host, $database, $userName, $password)
    {
        try
        {
            $this->pdo = new PDO("mysql:host=" . $host . ';dbname=' . $database, $userName, $password);
        }
        catch (PDOException $e)
        {
            return null;
        }
    }

    public function executeQuery($query)
    {
        $data = [];
        if ($this->pdo != null)
        {
            $stn = $this->pdo->prepare($query);
            $stn->execute();
            while ($row = $stn->fetch(PDO::FETCH_ASSOC))
            {
                array_push($data, $row);
            }
            $stn->closeCursor();
        }
        return $data;
    }
}