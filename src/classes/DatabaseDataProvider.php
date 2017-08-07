<?php

class DatabaseDataProvider
{
    private $database;

    public function __construct()
    {
        $this->database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);
    }

    public function getUsersId()
    {
        return $this->database->executeQuery("SELECT id FROM " . DatabaseTable::USER, [], PDO::FETCH_COLUMN);
    }

    public function getUserUrls($userId)
    {
        return $this->database->executeQuery("SELECT id, url FROM " . DatabaseTable::USER_URL . " WHERE user_id = ?",
                                              [$userId]);
    }

    public function getUserLocations($userId)
    {
        return $this->database->executeQuery("SELECT u_l.wpt_location_id, location FROM " . DatabaseTable::USER_LOCATION . " AS u_l 
                                              LEFT JOIN " . DatabaseTable::WPT_LOCATION . " AS w_l ON u_l.wpt_location_id = w_l.id 
                                              WHERE user_id = ?", [$userId]);
    }

    public function getUserApiKey($userId)
    {
        $apiKey = $this->database->executeQuery("SELECT api_key FROM " . DatabaseTable::USER . " WHERE id = ?", [$userId], PDO::FETCH_COLUMN);

        if (array_key_exists(0, $apiKey))
        {
            $apiKey = $apiKey[0];
        }

        return $apiKey;
    }

    public function getPendingTestIds()
    {
        return $this->database->executeQuery("SELECT test_id FROM " . DatabaseTable::TEST_INFO .
                                             " WHERE test_status = ? AND test_status != ?",
                                             [TestStatus::NOT_COMPLETED, TestStatus::PROCESSED], PDO::FETCH_COLUMN);
    }

    public function getTableEntry($table, $testId)
    {
        return $this->database->selectOneRow("SELECT * FROM $table WHERE test_id = ?", [$testId]);
    }

    public function getBrowserType($testId)
    {
        return $this->database->executeQuery("SELECT type_browser FROM " . DatabaseTable::WPT_LOCATION .
                                             " AS w_l LEFT JOIN " . DatabaseTable::TEST_INFO .
                                             " AS t_i ON w_l.id = t_i.location_id 
                                               WHERE t_i.id = ?;", [$testId], PDO::FETCH_COLUMN);
    }

    public function checkExistenceRecord($testId)
    {
        return $this->database->executeQuery("SELECT type_view FROM " . DatabaseTable::AVERAGE_RESULT . " WHERE test_id = ?", [$testId]);
    }
}