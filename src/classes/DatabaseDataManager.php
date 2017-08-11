<?php

class DatabaseDataManager
{
    private $database;

    private const INDEX_ID = 'id';

    public function __construct()
    {
        $this->database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);
    }

    public function getUsersId()
    {
        return $this->database->executeQuery("SELECT id FROM " . DatabaseTable::USER, [], PDO::FETCH_COLUMN);
    }

    public function getUserDomainsData($userId)
    {
        return $this->database->executeQuery("SELECT domain_name FROM " . DatabaseTable::DOMAIN .
                                             " AS d LEFT JOIN " . DatabaseTable::USER_DOMAIN . " AS u_d ON d.id = u_d.domain_id 
                                               WHERE u_d.user_id = ?", [$userId], PDO::FETCH_COLUMN);
    }

    public function getUserLocations($userId)
    {
        return $this->database->executeQuery("SELECT w_l.id, w_l.location FROM " . DatabaseTable::WPT_LOCATION . " AS w_l 
                                              LEFT JOIN " . DatabaseTable::USER_DOMAIN_LOCATION . " AS u_d_l 
                                              ON u_d_l.wpt_location_id = w_l.id 
                                              LEFT JOIN " .DatabaseTable::USER_DOMAIN . " AS u_d 
                                              ON u_d_l.domain_id = u_d.domain_id WHERE user_id = ?", [$userId]);
    }

    public function getUserApiKey($userId)
    {
        $apiKey =  $this->database->executeQuery("SELECT api_key FROM " . DatabaseTable::USER . " WHERE id = ?", [$userId], PDO::FETCH_COLUMN);

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

    public function testIsExists($testId)
    {
        return $this->database->executeQuery("SELECT type_view FROM " . DatabaseTable::AVERAGE_RESULT . " WHERE test_id = ?", [$testId]);
    }

    public function getUserData($userLogin, $userPassword)
    {
        return $this->database->executeQuery("SELECT id, login, password FROM " . DatabaseTable::USER .
                                             " WHERE login = ? AND password = ?", [$userLogin, $userPassword]);
    }

    public function getLocationData()
    {
        return $this->database->executeQuery("SELECT id, description FROM " . DatabaseTable::WPT_LOCATION);
    }

    public function urlIsExists($newUrl)
    {
        return $this->database->executeQuery("SELECT id FROM " . DatabaseTable::USER_URL .
                                             " WHERE url = ? LIMIT 1", [$newUrl], PDO::FETCH_COLUMN);
    }

    public function getExistingLocations($userId)
    {
        return $this->database->executeQuery("SELECT domain_id, wpt_location_id FROM " . DatabaseTable::USER_DOMAIN_LOCATION .
                                             " AS u_d_l LEFT JOIN " . DatabaseTable::USER_DOMAIN .
                                             " AS u_d ON u_d_l.domain_id = u_d.domain_id WHERE user_id = ?", [$userId]);
    }

    public function getUserUrlsData($userId)
    {
        return $this->database->executeQuery("SELECT u_d_u.id, url FROM " . DatabaseTable::USER_DOMAIN_URL .
                                             " AS u_d_u LEFT JOIN " . DatabaseTable::USER_DOMAIN .
                                             " AS u_d ON u_d_u.domain_id = u_d.domain_id WHERE u_d.user_id = ?", [$userId]);
    }

    public function getDomainId($newDomain)
    {
        return $this->database->selectOneRow("SELECT id FROM " . DatabaseTable::DOMAIN . " WHERE domain_name = ?", [$newDomain]);
    }

    public function getDomainsId()
    {
        return $this->database->executeQuery("SELECT id FROM " . DatabaseTable::DOMAIN, [], PDO::FETCH_COLUMN);
    }

    public function getUserDomains($userId)
    {
        return $this->database->executeQuery("SELECT domain_name FROM " . DatabaseTable::DOMAIN .
                                             " AS d LEFT JOIN " . DatabaseTable::USER_DOMAIN .
                                             " AS u_d ON d.id = u_d.domain_id WHERE user_id = ?", [$userId], PDO::FETCH_COLUMN);
    }

    public function updateTestInfoStatus($wptTestId)
    {
        $this->database->executeQuery("UPDATE " . DatabaseTable::TEST_INFO . " SET test_status = ? WHERE test_id = ?",
                                       [TestStatus::PROCESSED, $wptTestId]);
    }

    public function saveTestInfo($userId, $userUrl, $userLocation, $wptTestId)
    {
        $this->database->executeQuery("INSERT INTO " . DatabaseTable::TEST_INFO . " (user_id, url_id, location_id, test_id, test_status)
                                       VALUES (?, ?, ?, ?, ?)",
                                       [$userId, $userUrl[self::INDEX_ID], $userLocation[self::INDEX_ID],  $wptTestId, TestStatus::NOT_COMPLETED]);
    }

    public function saveAverageResult($averageResult)
    {
        $this->database->executeQuery("INSERT INTO " . DatabaseTable::AVERAGE_RESULT . "
                                       (load_time, ttfb, bytes_out, bytes_out_doc,
                                        bytes_in, bytes_in_doc, connections, requests, requests_doc,
                                        responses_200, responses_404, responses_other, render_time,
                                        fully_loaded, doc_time, dom_elements, title_time,
                                        load_event_start, load_event_end, dom_content_loaded_event_start,
                                        dom_content_loaded_event_end, first_paint, dom_interactive,  dom_loading,
                                        visual_complete, test_id, type_view, completed_time)
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
                                        ?, ?, ?, ?, ?, ?, ?, ?, ?, FROM_UNIXTIME(?))", $averageResult);
    }

    public function saveRawData($testId, $jsonData)
    {
        $this->database->executeQuery("INSERT INTO " . DatabaseTable::RAW_DATA . " (test_id, json_data) 
                                       VALUES (?, ?)", [$testId, $jsonData]);
    }

    public function updateTestInfoCompletedTime($response, $wptTestId)
    {
        $this->database->executeQuery("UPDATE " . DatabaseTable::TEST_INFO . " SET completed_time = FROM_UNIXTIME(?), test_status = ?
                                       WHERE test_id = ?", [$response, TestStatus::COMPLETED, $wptTestId]);
    }

    public function getTestResult($userId)
    {
        return $this->database->executeQuery("SELECT ttfb, doc_time, fully_loaded, a_r.completed_time 
                                              FROM " .DatabaseTable::AVERAGE_RESULT . " AS a_r 
                                              LEFT JOIN " .DatabaseTable::TEST_INFO . " AS t_i 
                                              ON a_r.test_id = t_i.id 
                                              WHERE user_id = ?", [$userId]);
    }

    public function saveDomain($newDomain)
    {
        $this->database->executeQuery("INSERT INTO " . DatabaseTable::DOMAIN . " (domain_name) VALUES (?)", [$newDomain]);
    }

    public function saveUserDomain($userId, $domainId)
    {
        $this->database->executeQuery("INSERT INTO " . DatabaseTable::USER_DOMAIN . " (user_id, domain_id) 
                                       VALUES (?, ?)", [$userId, $domainId]);
    }

    public function saveUserDomainUrl($domainId, $newUrl)
    {
        $this->database->executeQuery("INSERT INTO " . DatabaseTable::USER_DOMAIN_URL . " (domain_id, url) 
                                       VALUES (?, ?)", [$domainId, $newUrl]);
    }

    public function deleteUserDomainLocation($existingLocation, $value)
    {
        $this->database->executeQuery("DELETE FROM " . DatabaseTable::USER_DOMAIN_LOCATION .
                                      " WHERE domain_id = ? and wpt_location_id = ?", [$existingLocation, $value]);
    }

    public function saveUserDomainLocation($existingLocation, $value)
    {
        $this->database->executeQuery("INSERT INTO  " . DatabaseTable::USER_DOMAIN_LOCATION . "(domain_id, wpt_location_id) 
                                       VALUES (?, ?)", [$existingLocation, $value]);
    }
}