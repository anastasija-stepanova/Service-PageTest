<?php

class CommonTestResultCreator
{
    private const DEFAULT_VALUE = null;

    public static function createFromMobileBrowser(array $response): CommonTestResult
    {
        $commonTestResult = new CommonTestResult();

        $commonTestResult->setLoadTime(self::getArrayValue($response, 'loadTime'));
        $commonTestResult->setTtfb(self::getArrayValue($response, 'TTFB'));
        $commonTestResult->setBytesOut(self::getArrayValue($response, 'bytesOut'));
        $commonTestResult->setBytesOutDoc(self::getArrayValue($response, 'bytesOutDoc'));
        $commonTestResult->setBytesIn(self::getArrayValue($response, 'bytesIn'));
        $commonTestResult->setBytesInDoc(self::getArrayValue($response, 'bytesInDoc'));
        $commonTestResult->setConnections(self::getArrayValue($response, 'connections'));
        $commonTestResult->setRequests(self::getArrayValue($response, 'requests'));
        $commonTestResult->setRequestsDoc(self::getArrayValue($response, 'requestsDoc'));
        $commonTestResult->setResponses200(self::getArrayValue($response, 'responses_200'));
        $commonTestResult->setResponses404(self::getArrayValue($response, 'responses_404'));
        $commonTestResult->setResponsesOther(self::getArrayValue($response, 'responses_other'));
        $commonTestResult->setRenderTime(self::getArrayValue($response, 'render'));
        $commonTestResult->setFullyLoaded(self::getArrayValue($response, 'fullyLoaded'));
        $commonTestResult->setDocTime(self::getArrayValue($response, 'docTime'));
        $commonTestResult->setDomElements(self::getArrayValue($response, 'domElements'));
        $commonTestResult->setTitleTime(self::getArrayValue($response, 'titleTime'));
        $commonTestResult->setLoadEventStart(self::getArrayValue($response, 'loadEventStart'));
        $commonTestResult->setLoadEventEnd(self::getArrayValue($response, 'loadEventEnd'));
        $commonTestResult->setDomContentLoadedEventStart(self::getArrayValue($response,'domContentLoadedEventStart'));
        $commonTestResult->setDomContentLoadedEventEnd(self::getArrayValue($response, 'domContentLoadedEventEnd'));
        $commonTestResult->setFirstPaint(self::getArrayValue($response,'firstPaint'));
        $commonTestResult->setDomInteractive(self::getArrayValue($response,'domInteractive'));
        $commonTestResult->setDomLoading(self::getArrayValue($response, 'chromeUserTiming.domLoading'));
        $commonTestResult->setVisualComplete(self::getArrayValue($response, 'chromeUserTiming.domComplete'));

        return $commonTestResult;
    }

    public static function createFromDesktopBrowser(array $response): CommonTestResult
    {
        $commonTestResult = new CommonTestResult();

        $commonTestResult->setLoadTime(self::getArrayValue($response, 'loadTime'));
        $commonTestResult->setTtfb(self::getArrayValue($response, 'TTFB'));
        $commonTestResult->setBytesOut(self::getArrayValue($response, 'bytesOut'));
        $commonTestResult->setBytesOutDoc(self::getArrayValue($response, 'bytesOutDoc'));
        $commonTestResult->setBytesIn(self::getArrayValue($response, 'bytesIn'));
        $commonTestResult->setBytesInDoc(self::getArrayValue($response, 'bytesInDoc'));
        $commonTestResult->setConnections(self::getArrayValue($response, 'connections'));
        $commonTestResult->setRequests(self::getArrayValue($response, 'requests'));
        $commonTestResult->setRequestsDoc(self::getArrayValue($response, 'requestsDoc'));
        $commonTestResult->setResponses200(self::getArrayValue($response, 'responses_200'));
        $commonTestResult->setResponses404(self::getArrayValue($response, 'responses_404'));
        $commonTestResult->setResponsesOther(self::getArrayValue($response, 'responses_other'));
        $commonTestResult->setRenderTime(self::getArrayValue($response, 'render'));
        $commonTestResult->setFullyLoaded(self::getArrayValue($response, 'fullyLoaded'));
        $commonTestResult->setDocTime(self::getArrayValue($response, 'docTime'));
        $commonTestResult->setDomElements(self::getArrayValue($response, 'domElements'));
        $commonTestResult->setTitleTime(self::getArrayValue($response, 'titleTime'));
        $commonTestResult->setLoadEventStart(self::getArrayValue($response, 'loadEventStart'));
        $commonTestResult->setLoadEventEnd(self::getArrayValue($response, 'loadEventEnd'));
        $commonTestResult->setDomContentLoadedEventStart(self::getArrayValue($response,'domContentLoadedEventStart'));
        $commonTestResult->setDomContentLoadedEventEnd(self::getArrayValue($response, 'domContentLoadedEventEnd'));
        $commonTestResult->setFirstPaint(self::getArrayValue($response,'firstPaint'));
        $commonTestResult->setDomInteractive(self::getArrayValue($response,'domInteractive'));
        $commonTestResult->setDomLoading(self::getArrayValue($response, 'domLoading'));
        $commonTestResult->setVisualComplete(self::getArrayValue($response, 'visualComplete'));

        return $commonTestResult;
    }

    private static function getArrayValue(array $array, string $key, $defaultValue = self::DEFAULT_VALUE)
    {
        return array_key_exists($key, $array) ? $array[$key] : $defaultValue;
    }
}