<?php

class CommonTestResultCreator
{
    public static function createFromMobileBrowser($response)
    {
        $commonTestResult = new CommonTestResult();

        $commonTestResult->setLoadTime($response['loadTime']);
        $commonTestResult->setTtfb($response['TTFB']);
        $commonTestResult->setBytesOut($response['bytesOut']);
        $commonTestResult->setBytesOutDoc($response['bytesOutDoc']);
        $commonTestResult->setBytesIn($response['bytesIn']);
        $commonTestResult->setBytesInDoc($response['bytesInDoc']);
        $commonTestResult->setConnections($response['connections']);
        $commonTestResult->setRequests($response['requests']);
        $commonTestResult->setRequestsDoc($response['requestsDoc']);
        $commonTestResult->setResponses200($response['responses_200']);
        $commonTestResult->setResponses404($response['responses_404']);
        $commonTestResult->setResponsesOther($response['responses_other']);
        $commonTestResult->setRenderTime($response['render']);
        $commonTestResult->setFullyLoaded($response['fullyLoaded']);
        $commonTestResult->setDocTime($response['docTime']);
        $commonTestResult->setDomElements($response['domElements']);
        $commonTestResult->setTitleTime($response['titleTime']);
        $commonTestResult->setLoadEventStart($response['loadEventStart']);
        $commonTestResult->setLoadEventEnd($response['loadEventEnd']);
        $commonTestResult->setDomContentLoadedEventStart($response['domContentLoadedEventStart']);
        $commonTestResult->setDomContentLoadedEventEnd($response['domContentLoadedEventEnd']);
        $commonTestResult->setFirstPaint($response['firstPaint']);
        $commonTestResult->setDomInteractive($response['domInteractive']);
        $commonTestResult->setDomLoading($response['chromeUserTiming.domLoading']);
        $commonTestResult->setVisualComplete($response['chromeUserTiming.domComplete']);

        return $commonTestResult;
    }

    public static function createFromDesktopBrowser($response)
    {
        $commonTestResult = new CommonTestResult();

        $commonTestResult->setLoadTime($response['loadTime']);
        $commonTestResult->setTtfb($response['TTFB']);
        $commonTestResult->setBytesOut($response['bytesOut']);
        $commonTestResult->setBytesOutDoc($response['bytesOutDoc']);
        $commonTestResult->setBytesIn($response['bytesIn']);
        $commonTestResult->setBytesInDoc($response['bytesInDoc']);
        $commonTestResult->setConnections($response['connections']);
        $commonTestResult->setRequests($response['requests']);
        $commonTestResult->setRequestsDoc($response['requestsDoc']);
        $commonTestResult->setResponses200($response['responses_200']);
        $commonTestResult->setResponses404($response['responses_404']);
        $commonTestResult->setResponsesOther($response['responses_other']);
        $commonTestResult->setRenderTime($response['render']);
        $commonTestResult->setFullyLoaded($response['fullyLoaded']);
        $commonTestResult->setDocTime($response['docTime']);
        $commonTestResult->setDomElements($response['domElements']);
        $commonTestResult->setTitleTime($response['titleTime']);
        $commonTestResult->setLoadEventStart($response['loadEventStart']);
        $commonTestResult->setLoadEventEnd($response['loadEventEnd']);
        $commonTestResult->setDomContentLoadedEventStart($response['domContentLoadedEventStart']);
        $commonTestResult->setDomContentLoadedEventEnd($response['domContentLoadedEventEnd']);
        $commonTestResult->setFirstPaint($response['firstPaint']);
        $commonTestResult->setDomInteractive($response['domInteractive']);
        $commonTestResult->setDomLoading($response['domLoading']);
        $commonTestResult->setVisualComplete($response['visualComplete']);

        return $commonTestResult;
    }

    private function getArrayValue()
    {

    }
}