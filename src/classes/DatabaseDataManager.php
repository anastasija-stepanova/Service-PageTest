<?php

class DatabaseDataManager
{
    private $database;
    private const TOTAL_NUM_TEST_RECORD = 2;
    private const INDEX_ID = 'id';

    public function __construct()
    {
        $this->database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);
    }

    public function getUsersId(): array
    {
        $user = DatabaseTable::USER;
        return $this->database->executeQuery("
                                SELECT id 
                                FROM $user", [], PDO::FETCH_COLUMN);
    }

    public function getUserDomainsData($userId): array
    {
        $domain = DatabaseTable::DOMAIN;
        $userDomain = DatabaseTable::USER_DOMAIN;
        return $this->database->executeQuery("
                                  SELECT ud.id, domain_name 
                                  FROM $domain AS d 
                                    LEFT JOIN $userDomain AS ud ON d.id = ud.domain_id 
                                  WHERE ud.user_id = ?", [$userId]);
    }

    public function getUserLocations($userId, $domainId): array
    {
        $wptLocation = DatabaseTable::WPT_LOCATION;
        $userDomainLocation = DatabaseTable::USER_DOMAIN_LOCATION;
        $userDomain = DatabaseTable::USER_DOMAIN;
        return $this->database->executeQuery("
                                  SELECT wl.id, wl.location, wl.description 
                                  FROM $wptLocation AS wl 
                                    LEFT JOIN $userDomainLocation AS udl ON udl.wpt_location_id = wl.id 
                                    LEFT JOIN $userDomain AS ud ON udl.user_domain_id = ud.domain_id 
                                  WHERE user_id = ? AND udl.user_domain_id = ?", [$userId, $domainId]);
    }

    public function getUserApiKey($userId): string
    {
        $user = DatabaseTable::USER;
        $apiKey = $this->database->selectOneRow("
                                     SELECT api_key 
                                     FROM $user 
                                     WHERE id = ?", [$userId]);
        if (array_key_exists('api_key', $apiKey))
        {
            $apiKey = $apiKey['api_key'];
        }
        return $apiKey;
    }

    public function getPendingTestIds(): array
    {
        $testInfo = DatabaseTable::TEST_INFO;
        return $this->database->executeQuery("
                                  SELECT test_id 
                                  FROM $testInfo 
                                  WHERE test_status = ? AND test_status != ?",
            [TestStatus::NOT_COMPLETED, TestStatus::PROCESSED], PDO::FETCH_COLUMN);
    }

    public function getTableRowByTestId($table, $testId): array
    {
        return $this->database->selectOneRow("
                                  SELECT * 
                                  FROM $table 
                                  WHERE test_id = ?", [$testId]);
    }

    public function getBrowserType($testId): array
    {
        $wptLocation = DatabaseTable::WPT_LOCATION;
        $testInfo = DatabaseTable::TEST_INFO;
        return $this->database->executeQuery("
                                  SELECT type_browser 
                                  FROM $wptLocation AS wl 
                                    LEFT JOIN $testInfo AS ti ON wl.id = ti.location_id 
                                  WHERE ti.id = ?;", [$testId], PDO::FETCH_COLUMN);
    }

    public function doesTestExists($testId): bool
    {
        $averageResult = DatabaseTable::AVERAGE_RESULT;
        $testExists = $this->database->executeQuery("
                                         SELECT type_view 
                                         FROM $averageResult 
                                         WHERE test_id = ?", [$testId]);
        return count($testExists) < self::TOTAL_NUM_TEST_RECORD ? true : false;
    }

    public function getUserData($userLogin, $userPassword): array
    {
        $user = DatabaseTable::USER;
        return $this->database->executeQuery("
                                  SELECT id, login, u.password 
                                  FROM $user AS u
                                  WHERE login = ? AND u.password = ?", [$userLogin, $userPassword]);
    }

    public function getLocationData(): array
    {
        $wptLocation = DatabaseTable::WPT_LOCATION;
        return $this->database->executeQuery("
                                  SELECT id, description 
                                  FROM $wptLocation");
    }

    public function getExistingLocations($userId, $domainId): array
    {
        $userDomainLocation = DatabaseTable::USER_DOMAIN_LOCATION;
        $userDomain = DatabaseTable::USER_DOMAIN;
        return $this->database->executeQuery("
                                  SELECT user_domain_id, wpt_location_id 
                                  FROM $userDomainLocation AS udl 
                                    LEFT JOIN $userDomain AS ud ON udl.user_domain_id = ud.domain_id 
                                  WHERE user_id = ? AND user_domain_id = ?", [$userId, $domainId]);
    }

    public function getUserUrlsData($userId, $domainId): array
    {
        $userDomainUrl = DatabaseTable::USER_DOMAIN_URL;
        $userDomain = DatabaseTable::USER_DOMAIN;
        return $this->database->executeQuery("
                                  SELECT udu.id, url 
                                  FROM $userDomainUrl AS udu 
                                    LEFT JOIN $userDomain AS ud ON udu.user_domain_id = ud.domain_id 
                                  WHERE ud.user_id = ? AND udu.user_domain_id = ?", [$userId, $domainId]);
    }

    public function getDomainId($newDomain): array
    {
        $domain = DatabaseTable::DOMAIN;
        return $this->database->selectOneRow("
                                  SELECT id 
                                  FROM $domain 
                                  WHERE domain_name = ?", [$newDomain]);
    }

    public function getDomainsId(): array
    {
        $domain = DatabaseTable::DOMAIN;
        return $this->database->executeQuery("
                                  SELECT id 
                                  FROM $domain", [], PDO::FETCH_COLUMN);
    }

    public function getUserDomains($userId): array
    {
        $domain = DatabaseTable::DOMAIN;
        $userDomain = DatabaseTable::USER_DOMAIN;
        return $this->database->executeQuery("
                                  SELECT ud.id, domain_name 
                                  FROM $domain AS d 
                                    LEFT JOIN $userDomain AS ud ON d.id = ud.domain_id 
                                  WHERE user_id = ?", [$userId]);
    }

    public function getUserDomain($domainName): array
    {
        $userDomain = DatabaseTable::USER_DOMAIN;
        $domain = DatabaseTable::DOMAIN;
        return $this->database->selectOneRow("
                                  SELECT ud.id 
                                  FROM $userDomain AS ud
                                    LEFT JOIN $domain AS d ON ud.domain_id = d.id
                                  WHERE domain_name = ?", [$domainName], PDO::FETCH_COLUMN);
    }

    public function doesUserUrlExists($domainId, $url): array
    {
        $userDomainUrl = DatabaseTable::USER_DOMAIN_URL;
        return $this->database->executeQuery("
                                  SELECT user_domain_id, url 
                                  FROM $userDomainUrl
                                  WHERE user_domain_id = ? AND url = ?", [$domainId, $url]);
    }

    public function updateTestInfoStatus($wptTestId): void
    {
        $testInfo = DatabaseTable::TEST_INFO;
        $this->database->executeQuery("
                           UPDATE $testInfo 
                           SET test_status = ? 
                           WHERE test_id = ?", [TestStatus::PROCESSED, $wptTestId]);
    }

    public function saveTestInfo($userId, $userUrl, $userLocation, $wptTestId): void
    {
        $testInfo = DatabaseTable::TEST_INFO;
        $this->database->executeQuery("
                           INSERT INTO $testInfo (user_id, url_id, location_id, test_id, test_status)
                           VALUES (?, ?, ?, ?, ?)",
            [$userId, $userUrl[self::INDEX_ID], $userLocation[self::INDEX_ID], $wptTestId, TestStatus::NOT_COMPLETED]);
    }

    public function saveAverageResult($averageResult): void
    {
        $averageResultTable = DatabaseTable::AVERAGE_RESULT;
        $this->database->executeQuery("
                           INSERT INTO $averageResultTable
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

    public function saveRawData($testId, $jsonData): void
    {
        $rawData = DatabaseTable::RAW_DATA;
        $this->database->executeQuery("
                           INSERT INTO $rawData (test_id, json_data) 
                           VALUES (?, ?)", [$testId, $jsonData]);
    }

    public function updateTestInfoCompletedTime($response, $wptTestId): void
    {
        $testInfo = DatabaseTable::TEST_INFO;
        $this->database->executeQuery("
                           UPDATE $testInfo 
                           SET completed_time = FROM_UNIXTIME(?), test_status = ?
                           WHERE test_id = ?", [$response, TestStatus::COMPLETED, $wptTestId]);
    }

    public function getTestResult($userId, $domainId, $locationId, $typeView, $minTime, $maxTime): array
    {
        $averageResult = DatabaseTable::AVERAGE_RESULT;
        $testInfo = DatabaseTable::TEST_INFO;
        return $this->database->executeQuery("
                                  SELECT udu.user_domain_id, udu.url, ar.ttfb, ar.doc_time, ar.fully_loaded, DATE_FORMAT(ar.completed_time, '%e %M')
                                  FROM $averageResult AS ar
                                    LEFT JOIN $testInfo AS ti ON ar.test_id = ti.id
                                    LEFT JOIN user_domain_url AS udu ON udu.id = ti.url_id
                                  WHERE user_id = ? AND udu.user_domain_id = ? AND location_id = ? AND type_view = ? AND
                                  ar.completed_time > FROM_UNIXTIME(?) AND ar.completed_time < FROM_UNIXTIME(?)",
            [$userId, $domainId, $locationId, $typeView, $minTime, $maxTime]);
    }

    public function getTestTime($userId): array
    {
        $testInfo = DatabaseTable::TEST_INFO;
        return $this->database->executeQuery("
                                  SELECT DATE_FORMAT(completed_time, '%e %M') 
                                  FROM $testInfo 
                                  WHERE user_id = ? AND test_status = ?", [$userId, TestStatus::COMPLETED], PDO::FETCH_COLUMN);
    }

    public function saveDomain($newDomain): void
    {
        $domain = DatabaseTable::DOMAIN;
        $this->database->executeQuery("
                           INSERT INTO $domain (domain_name) 
                           VALUES (?)", [$newDomain]);
    }

    public function saveUserDomain($userId, $domainId): void
    {
        $userDomain = DatabaseTable::USER_DOMAIN;
        $this->database->executeQuery("
                           INSERT INTO $userDomain (user_id, domain_id) 
                           VALUES (?, ?)", [$userId, $domainId]);
    }

    public function saveUserDomainUrl($domainId, $newUrl): void
    {
        $userDomainUrl = DatabaseTable::USER_DOMAIN_URL;
        $this->database->executeQuery("
                           INSERT INTO $userDomainUrl (user_domain_id, url) 
                           VALUES (?, ?)", [$domainId, $newUrl]);
    }

    public function deleteUserDomainLocation($existingLocation, $value): void
    {
        $userDomainLocation = DatabaseTable::USER_DOMAIN_LOCATION;
        $this->database->executeQuery("
                           DELETE FROM $userDomainLocation 
                           WHERE user_domain_id = ? and wpt_location_id = ?", [$existingLocation, $value]);
    }

    public function saveUserDomainLocation($existingLocation, $value): void
    {
        $userDomainLocation = DatabaseTable::USER_DOMAIN_LOCATION;
        $this->database->executeQuery("
                           INSERT INTO $userDomainLocation (user_domain_id, wpt_location_id) 
                           VALUES (?, ?)", [$existingLocation, $value]);
    }

    public function getDefaultUserDomain(): int
    {
        $userDomain = DatabaseTable::USER_DOMAIN;
        $domainId = $this->database->selectOneRow("
                                  SELECT domain_id
                                  FROM $userDomain");
        if (array_key_exists('domain_id', $domainId))
        {
            $domainId = $domainId['domain_id'];
        }
        return $domainId;
    }

    public function getDefaultUserDomainLocation(): int
    {
        $userDomainLocation = DatabaseTable::USER_DOMAIN_LOCATION;
        $locationId = $this->database->selectOneRow("
                                           SELECT wpt_location_id
                                           FROM $userDomainLocation");
        if (array_key_exists('wpt_location_id', $locationId))
        {
            $locationId = $locationId['wpt_location_id'];
        }
        return $locationId;
    }

    public function getTimeRange(): array
    {
        $averageResult = DatabaseTable::AVERAGE_RESULT;
        $timeRange = $this->database->executeQuery("
                                        SELECT DISTINCT completed_time
                                        FROM $averageResult");
        return $timeRange;
    }

    public function deleteUrl($domainId, $url): void
    {
        $userDomainUrl = DatabaseTable::USER_DOMAIN_URL;
        $this->database->executeQuery("
                           DELETE FROM $userDomainUrl
                           WHERE user_domain_id = ? AND url = ?", [$domainId, $url]);
    }
}