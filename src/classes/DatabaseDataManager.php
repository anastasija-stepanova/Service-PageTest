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
        $user = DatabaseTable::USER;
        return $this->database->executeQuery("SELECT id FROM $user", [], PDO::FETCH_COLUMN);
    }

    public function getUserDomainsData($userId)
    {
        $domain = DatabaseTable::DOMAIN;
        $userDomain = DatabaseTable::USER_DOMAIN;
        return $this->database->executeQuery("SELECT domain_name FROM $domain AS d LEFT JOIN $userDomain AS ud ON d.id = ud.domain_id 
                                              WHERE ud.user_id = ?", [$userId], PDO::FETCH_COLUMN);
    }

    public function getUserLocations($userId)
    {
        $wptLocation = DatabaseTable::WPT_LOCATION;
        $userDomainLocation = DatabaseTable::USER_DOMAIN_LOCATION;
        $userDomain = DatabaseTable::USER_DOMAIN;
        return $this->database->executeQuery("SELECT wl.id, wl.location FROM $wptLocation AS wl 
                                              LEFT JOIN $userDomainLocation AS udl ON udl.wpt_location_id = wl.id 
                                              LEFT JOIN $userDomain AS ud ON udl.domain_id = ud.domain_id WHERE user_id = ?", [$userId]);
    }

    public function getUserApiKey($userId)
    {
        $user = DatabaseTable::USER;
        $apiKey = $this->database->selectOneRow("SELECT api_key FROM $user WHERE id = ?", [$userId]);

        if (array_key_exists('api_key', $apiKey))
        {
            $apiKey = $apiKey['api_key'];
        }

        return $apiKey;
    }

    public function getPendingTestIds()
    {
        $testInfo = DatabaseTable::TEST_INFO;
        return $this->database->executeQuery("SELECT test_id FROM $testInfo WHERE test_status = ? AND test_status != ?",
                                             [TestStatus::NOT_COMPLETED, TestStatus::PROCESSED], PDO::FETCH_COLUMN);
    }

    public function getTableEntry($table, $testId)
    {
        return $this->database->selectOneRow("SELECT * FROM $table WHERE test_id = ?", [$testId]);
    }

    public function getBrowserType($testId)
    {
        $wptLocation = DatabaseTable::WPT_LOCATION;
        $testInfo = DatabaseTable::TEST_INFO;
        return $this->database->executeQuery("SELECT type_browser FROM $wptLocation AS wl 
                                              LEFT JOIN $testInfo AS ti ON wl.id = ti.location_id 
                                              WHERE ti.id = ?;", [$testId], PDO::FETCH_COLUMN);
    }

    public function testIsExists($testId)
    {
        $averageResult = DatabaseTable::AVERAGE_RESULT;
        return $this->database->executeQuery("SELECT type_view FROM $averageResult WHERE test_id = ?", [$testId]);
    }

    public function getUserData($userLogin, $userPassword)
    {
        $user = DatabaseTable::USER;
        return $this->database->executeQuery("SELECT id, login, u.password FROM $user AS u
                                              WHERE login = ? AND u.password = ?", [$userLogin, $userPassword]);
    }

    public function getLocationData()
    {
        $wptLocation = DatabaseTable::WPT_LOCATION;
        return $this->database->executeQuery("SELECT id, description FROM $wptLocation");
    }

    public function getExistingLocations($userId)
    {
        $userDomainLocation = DatabaseTable::USER_DOMAIN_LOCATION;
        $userDomain = DatabaseTable::USER_DOMAIN;
        return $this->database->executeQuery("SELECT domain_id, wpt_location_id FROM $userDomainLocation AS udl 
                                              LEFT JOIN $userDomain AS ud ON udl.domain_id = ud.domain_id 
                                              WHERE user_id = ?", [$userId]);
    }

    public function getUserUrlsData($userId)
    {
        $userDomainUrl = DatabaseTable::USER_DOMAIN_URL;
        $userDomain = DatabaseTable::USER_DOMAIN;
        return $this->database->executeQuery("SELECT udu.id, url FROM $userDomainUrl AS udu 
                                              LEFT JOIN $userDomain AS ud ON udu.domain_id = ud.domain_id 
                                              WHERE ud.user_id = ?", [$userId]);
    }

    public function getDomainId($newDomain)
    {
        $domain = DatabaseTable::DOMAIN;
        return $this->database->selectOneRow("SELECT id FROM $domain WHERE domain_name = ?", [$newDomain]);
    }

    public function getDomainsId()
    {
        $domain = DatabaseTable::DOMAIN;
        return $this->database->executeQuery("SELECT id FROM $domain", [], PDO::FETCH_COLUMN);
    }

    public function getUserDomains($userId)
    {
        $domain = DatabaseTable::DOMAIN;
        $userDomain = DatabaseTable::USER_DOMAIN;
        return $this->database->executeQuery("SELECT domain_name FROM $domain AS d 
                                              LEFT JOIN $userDomain AS ud ON d.id = ud.domain_id 
                                              WHERE user_id = ?", [$userId], PDO::FETCH_COLUMN);
    }

    public function updateTestInfoStatus($wptTestId)
    {
        $testInfo = DatabaseTable::TEST_INFO;
        $this->database->executeQuery("UPDATE $testInfo SET test_status = ? WHERE test_id = ?", [TestStatus::PROCESSED, $wptTestId]);
    }

    public function saveTestInfo($userId, $userUrl, $userLocation, $wptTestId)
    {
        $testInfo = DatabaseTable::TEST_INFO;
        $this->database->executeQuery("INSERT INTO $testInfo (user_id, url_id, location_id, test_id, test_status)VALUES (?, ?, ?, ?, ?)",
                                       [$userId, $userUrl[self::INDEX_ID], $userLocation[self::INDEX_ID],  $wptTestId, TestStatus::NOT_COMPLETED]);
    }

    public function saveAverageResult($averageResult)
    {
        $averageResultTable = DatabaseTable::AVERAGE_RESULT;
        $this->database->executeQuery("INSERT INTO $averageResultTable
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
        $rawData = DatabaseTable::RAW_DATA;
        $this->database->executeQuery("INSERT INTO $rawData (test_id, json_data) VALUES (?, ?)", [$testId, $jsonData]);
    }

    public function updateTestInfoCompletedTime($response, $wptTestId)
    {
        $testInfo = DatabaseTable::TEST_INFO;
        $this->database->executeQuery("UPDATE $testInfo SET completed_time = FROM_UNIXTIME(?), test_status = ?
                                       WHERE test_id = ?", [$response, TestStatus::COMPLETED, $wptTestId]);
    }

    public function getTestResult($userId)
    {
        $averageResult = DatabaseTable::AVERAGE_RESULT;
        $testInfo = DatabaseTable::TEST_INFO;
        return $this->database->executeQuery("SELECT ttfb, doc_time, fully_loaded, url_id
                                              FROM $averageResult AS ar 
                                              LEFT JOIN $testInfo AS ti ON ar.test_id = ti.id 
                                              WHERE user_id = ?", [$userId]);
    }

    public function getTestTime($userId)
    {
        $testInfo = DatabaseTable::TEST_INFO;
        return $this->database->executeQuery("SELECT DATE_FORMAT(completed_time, '%e %M') 
                                              FROM $testInfo 
                                              WHERE user_id = ? AND test_status = ?", [$userId, TestStatus::COMPLETED], PDO::FETCH_COLUMN);
    }

    public function saveDomain($newDomain)
    {
        $domain = DatabaseTable::DOMAIN;
        $this->database->executeQuery("INSERT INTO $domain (domain_name) VALUES (?)", [$newDomain]);
    }

    public function saveUserDomain($userId, $domainId)
    {
        $userDomain = DatabaseTable::USER_DOMAIN;
        $this->database->executeQuery("INSERT INTO $userDomain (user_id, domain_id) VALUES (?, ?)", [$userId, $domainId]);
    }

    public function saveUserDomainUrl($domainId, $newUrl)
    {
        $userDomainUrl = DatabaseTable::USER_DOMAIN_URL;
        $this->database->executeQuery("INSERT INTO $userDomainUrl (domain_id, url) VALUES (?, ?)", [$domainId, $newUrl]);
    }

    public function deleteUserDomainLocation($existingLocation, $value)
    {
        $userDomainLocation = DatabaseTable::USER_DOMAIN_LOCATION;
        $this->database->executeQuery("DELETE FROM $userDomainLocation 
                                       WHERE domain_id = ? and wpt_location_id = ?", [$existingLocation, $value]);
    }

    public function saveUserDomainLocation($existingLocation, $value)
    {
        $userDomainLocation = DatabaseTable::USER_DOMAIN_LOCATION;
        $this->database->executeQuery("INSERT INTO $userDomainLocation (domain_id, wpt_location_id) 
                                       VALUES (?, ?)", [$existingLocation, $value]);
    }
}