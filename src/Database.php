<?php

class Database
{
    private $pdo;

    private function dbConnect()
    {
        try
        {
            $database = new Config();
            $this->pdo = new PDO('mysql:host=' . $database::MYSQL_HOST . ';dbname=' . $database::MYSQL_DATABASE,
                                  $database::MYSQL_USERNAME, $database::MYSQL_PASSWORD);
            return $this->pdo;
        } catch (PDOException $e)
        {
            $this->pdo = null;
            return $this->pdo;
        }
    }

    public function dbQuery($query)
    {
        $connect = $this->dbConnect();
        if ($connect != null)
        {
            $result = $connect->query($query);
            $connect = null;
        }
        else
        {
            $result = null;
        }
        return $result;
    }

    public function dbQueryGetResult($query)
    {
        $connect = $this->dbConnect();
        if ($connect != null)
        {
            $data = [];
            $result = $connect->query($query);

            if ($result)
            {
                $sth = $connect->prepare($query);
                $sth->execute();
                while ($row = $sth->fetch(PDO::FETCH_ASSOC))
                {
                    array_push($data, $row);
                }
                $sth->closeCursor();
            }

            $connect = null;
            return $data;
        }
        else
        {
            $data = null;
        }
        return $data;
    }
}