<?php

class Database
{
    private $pdo;

    public function __construct(string $host, string $database, string $userName, string $password)
    {
        $this->pdo = new PDO("mysql:host=" . $host . ';dbname=' . $database, $userName, $password);
    }

    public function executeQuery(string $query, array $params = [], $style = PDO::FETCH_ASSOC): array
    {
        $data = [];
        $stm = $this->pdo->prepare($query);
        if ($stm)
        {
            $stm->execute($params);
            while ($row = $stm->fetch($style))
            {
                array_push($data, $row);
            }
            $stm->closeCursor();
        }

        return $data;
    }

    public function selectOneRow(string $query, array $params = []): array
    {
        $result = $this->executeQuery($query, $params);

        return array_key_exists(0, $result) ? $result[0] : [];
    }
}