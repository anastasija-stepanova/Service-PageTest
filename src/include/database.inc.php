<?php
function dbConnect()
{
    $database = new Config();
    $connection = mysqli_connect($database::MYSQL_HOST, $database::MYSQL_USERNAME, $database::MYSQL_PASSWORD, $database::MYSQL_DATABASE, $database::MYSQL_PORT);
    return $connection;
}

function dbQuery($query)
{
    $connection = dbConnect();
    $result = mysqli_query($connection, $query);
    mysqli_close($connection);
    return $result;
}

function dbQueryGetResult($query)
{
    $connection = dbConnect();
    $data = [];
    $result = mysqli_query($connection, $query);
    if ($result)
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            array_push($data, $row);
        }
        mysqli_free_result($result);
    }
    mysqli_close($connection);
    return $data;
}

function dbSelect($dbName)
{
    $connection = dbConnect();
    mysqli_select_db($connection, $dbName);
    mysqli_close($connection);
}