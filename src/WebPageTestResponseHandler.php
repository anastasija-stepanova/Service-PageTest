<?php
class WebPageTestResponseHandler
{
    private $database;

    public function __construct()
    {
        $this->database = new Database(Config::MYSQL_HOST, Config::MYSQL_DATABASE, Config::MYSQL_USERNAME, Config::MYSQL_PASSWORD);
    }

    public function writeRawData($response)
    {
        $data = $response['data'];

        if ($data['standardDeviation'])
        {
            unset($data['standardDeviation']);
        }

        $json = json_encode($response);
        $this->database->executeQuery("INSERT INTO " . DatabaseTablesConfig::RAW_DATA . "(json_data) VALUES (?)", [$json]);
    }

    public function writeTestInfo($response)
    {
        $data = $response['data'];

        if ($data)
        {
            $id = $data['id'];
            $url = $data['url'];
            $location = $data['location'];
            $from = $data['from'];
            $completed = $data['completed'];
            $testerDns = $data['testerDNS'];

            $this->database->executeQuery("INSERT INTO " . DatabaseTablesConfig::TEST_INFO .
                                          "(id, test_url, location, from_place, completed, tester_dns) 
                                          VALUES (?, ?, ?, ?, ?, ?)", [$id, $url, $location, $from, $completed, $testerDns]);
        }
    }

    public function writeListUrls($response)
    {
        $data = $response['data'];

        if ($data)
        {
            $site_url = $data['url'];

            $this->database->executeQuery("INSERT INTO " . DatabaseTablesConfig::LIST_URL_SITES .
                                          "(site_url) VALUES (?)", [$site_url]);
        }
    }

    public function writeAverageResult($response)
    {
        $data = $response['data'];

        if ($data)
        {
            $firstView = $data['average']['firstView'];
            $loadTime = $firstView['loadTime'];
            $ttfb = $firstView['TTFB'];
            $bytesOut = $firstView['bytesOut'];
            $bytesOutDoc = $firstView['bytesOutDoc'];
            $bytesIn = $firstView['bytesIn'];
            $bytesInDoc = $firstView['bytesInDoc'];
            $connections = $firstView['connections'];
            $requests = $firstView['requests'];
            $requestsFull = $firstView['requestsFull'];
            $requestsDoc = $firstView['requestsDoc'];
            $response200 = $firstView['responses_200'];
            $response404 = $firstView['responses_404'];
            $response_other = $firstView['responses_other'];
            $render = $firstView['render'];
            $fullyLoaded = $firstView['fullyLoaded'];
            $docTime = $firstView['docTime'];
            $imageTotal = $firstView['image_total'];
            $basePageRedirects = $firstView['base_page_redirects'];
            $optimizationChecked = $firstView['optimization_checked'];
            $domElements = $firstView['domElements'];
            $pageSpeedVersion = $firstView['pageSpeedVersion'];
            $titleTime = $firstView['titleTime'];
            $loadEventStart = $firstView['loadEventStart'];
            $loadEventEnd = $firstView['loadEventEnd'];
            $domContentLoadedEventStart = $firstView['domContentLoadedEventStart'];
            $domContentLoadedEventEnd = $firstView['domContentLoadedEventEnd'];
            $lastVisualChange = $firstView['lastVisualChange'];
            $firstPaint = $firstView['firstPaint'];
            $domInterective = $firstView['domInteractive'];
            $domLoading = $firstView['domLoading'];
            $basePageTtfb = $firstView['base_page_ttfb'];
            $visualComplete = $firstView['visualComplete'];
            $speedIndex = $firstView['SpeedIndex'];
            $certificateBytes = $firstView['certificate_bytes'];

            $this->database->executeQuery("INSERT INTO " . DatabaseTablesConfig::AVERAGE_RESULT .
                                          "(type_view, load_time, ttfb, bytes_out, bytes_out_doc, bytes_in, 
                                            bytes_in_doc, connections, requests, requests_full, requests_doc, response_200, 
                                            response_400, response_other, render, fully_loaded, doc_time, image_total, 
                                            base_page_redirects, optimization_checked, dom_elements, page_speed_version, 
                                            title_time, load_event_start, load_event_end, dom_content_loaded_event_start, 
                                            dom_content_loaded_event_end, last_visual_change, first_paint, dom_interactive, 
                                            dom_loading, base_page_ttfb, visual_complete, speed_index, sertificate_bytes) 
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 
                                            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
                                            [1, $loadTime, $ttfb, $bytesOut, $bytesOutDoc, $bytesIn, $bytesInDoc,
                                            $connections, $requests, $requestsFull, $requestsDoc, $response200, $response404,
                                            $response_other, $render, $fullyLoaded, $docTime, $imageTotal, $basePageRedirects,
                                            $optimizationChecked, $domElements, $pageSpeedVersion, $titleTime,
                                            $loadEventStart, $loadEventEnd, $domContentLoadedEventStart, $domContentLoadedEventEnd,
                                            $lastVisualChange, $firstPaint, $domInterective, $domLoading, $basePageTtfb,
                                            $visualComplete, $speedIndex, $certificateBytes]);
        }
    }
}