<?php

class CommonTestResultCreator
{
    public static function createFromMobileBrowser($response)
    {
        $commonTestResult = new CommonTestResult();

        if (array_key_exists('loadTime', $response))
        {
            $commonTestResult->setLoadTime($response['loadTime']);
        }
        if (array_key_exists('TTFB', $response))
        {
            $commonTestResult->setTtfb($response['TTFB']);
        }
        if (array_key_exists('bytesOut', $response))
        {
            $commonTestResult->setBytesOut($response['bytesOut']);
        }
        if (array_key_exists('bytesOutDoc', $response))
        {
            $commonTestResult->setBytesOutDoc($response['bytesOutDoc']);
        }
        if (array_key_exists('bytesIn', $response))
        {
            $commonTestResult->setBytesIn($response['bytesIn']);
        }
        if (array_key_exists('bytesInDoc', $response))
        {
            $commonTestResult->setBytesInDoc($response['bytesInDoc']);
        }
        if (array_key_exists('connections', $response))
        {
            $commonTestResult->setConnections($response['connections']);
        }
        if (array_key_exists('requests', $response))
        {
            $commonTestResult->setRequests($response['requests']);
        }
        if (array_key_exists('requestsDoc', $response))
        {
            $commonTestResult->setRequestsDoc($response['requestsDoc']);
        }
        if (array_key_exists('responses_200', $response))
        {
            $commonTestResult->setResponses200($response['responses_200']);
        }
        if (array_key_exists('responses_404', $response))
        {
            $commonTestResult->setResponses404($response['responses_404']);
        }
        if (array_key_exists('responses_other', $response))
        {
            $commonTestResult->setResponsesOther($response['responses_other']);
        }
        if (array_key_exists('render', $response))
        {
            $commonTestResult->setRenderTime($response['render']);
        }
        if (array_key_exists('fullyLoaded', $response))
        {
            $commonTestResult->setFullyLoaded($response['fullyLoaded']);
        }
        if (array_key_exists('docTime', $response))
        {
            $commonTestResult->setDocTime($response['docTime']);
        }
        if (array_key_exists('domElements', $response))
        {
            $commonTestResult->setDomElements($response['domElements']);
        }
        if (array_key_exists('titleTime', $response))
        {
            $commonTestResult->setTitleTime($response['titleTime']);
        }
        if (array_key_exists('loadEventStart', $response))
        {
            $commonTestResult->setLoadEventStart($response['loadEventStart']);
        }
        if (array_key_exists('loadEventEnd', $response))
        {
            $commonTestResult->setLoadEventEnd($response['loadEventEnd']);
        }
        if (array_key_exists('domContentLoadedEventStart', $response))
        {
            $commonTestResult->setDomContentLoadedEventStart($response['domContentLoadedEventStart']);
        }
        if (array_key_exists('domContentLoadedEventEnd', $response))
        {
            $commonTestResult->setDomContentLoadedEventEnd($response['domContentLoadedEventEnd']);
        }
        if (array_key_exists('firstPaint', $response))
        {
            $commonTestResult->setFirstPaint($response['firstPaint']);
        }
        if (array_key_exists('domInteractive', $response))
        {
            $commonTestResult->setDomInteractive($response['domInteractive']);
        }
        if (array_key_exists('chromeUserTiming.domLoading', $response))
        {
            $commonTestResult->setDomLoading($response['chromeUserTiming.domLoading']);
        }
        if (array_key_exists('chromeUserTiming.domComplete', $response))
        {
            $commonTestResult->setVisualComplete($response['chromeUserTiming.domComplete']);
        }

        return $commonTestResult;
    }

    public static function createFromDesktopBrowser($response)
    {
        $commonTestResult = new CommonTestResult();

        if (array_key_exists('loadTime', $response))
        {
            $commonTestResult->setLoadTime($response['loadTime']);
        }
        if (array_key_exists('TTFB', $response))
        {
            $commonTestResult->setTtfb($response['TTFB']);
        }
        if (array_key_exists('bytesOut', $response))
        {
            $commonTestResult->setBytesOut($response['bytesOut']);
        }
        if (array_key_exists('bytesOutDoc', $response))
        {
            $commonTestResult->setBytesOutDoc($response['bytesOutDoc']);
        }
        if (array_key_exists('bytesIn', $response))
        {
            $commonTestResult->setBytesIn($response['bytesIn']);
        }
        if (array_key_exists('bytesInDoc', $response))
        {
            $commonTestResult->setBytesInDoc($response['bytesInDoc']);
        }
        if (array_key_exists('connections', $response))
        {
            $commonTestResult->setConnections($response['connections']);
        }
        if (array_key_exists('requests', $response))
        {
            $commonTestResult->setRequests($response['requests']);
        }
        if (array_key_exists('requestsDoc', $response))
        {
            $commonTestResult->setRequestsDoc($response['requestsDoc']);
        }
        if (array_key_exists('responses_200', $response))
        {
            $commonTestResult->setResponses200($response['responses_200']);
        }
        if (array_key_exists('responses_404', $response))
        {
            $commonTestResult->setResponses404($response['responses_404']);
        }
        if (array_key_exists('responses_other', $response))
        {
            $commonTestResult->setResponsesOther($response['responses_other']);
        }
        if (array_key_exists('render', $response))
        {
            $commonTestResult->setRenderTime($response['render']);
        }
        if (array_key_exists('fullyLoaded', $response))
        {
            $commonTestResult->setFullyLoaded($response['fullyLoaded']);
        }
        if (array_key_exists('docTime', $response))
        {
            $commonTestResult->setDocTime($response['docTime']);
        }
        if (array_key_exists('domElements', $response))
        {
            $commonTestResult->setDomElements($response['domElements']);
        }
        if (array_key_exists('titleTime', $response))
        {
            $commonTestResult->setTitleTime($response['titleTime']);
        }
        if (array_key_exists('loadEventStart', $response))
        {
            $commonTestResult->setLoadEventStart($response['loadEventStart']);
        }
        if (array_key_exists('loadEventEnd', $response))
        {
            $commonTestResult->setLoadEventEnd($response['loadEventEnd']);
        }
        if (array_key_exists('domContentLoadedEventStart', $response))
        {
            $commonTestResult->setDomContentLoadedEventStart($response['domContentLoadedEventStart']);
        }
        if (array_key_exists('domContentLoadedEventEnd', $response))
        {
            $commonTestResult->setDomContentLoadedEventEnd($response['domContentLoadedEventEnd']);
        }
        if (array_key_exists('firstPaint', $response))
        {
            $commonTestResult->setFirstPaint($response['firstPaint']);
        }
        if (array_key_exists('domInteractive', $response))
        {
            $commonTestResult->setDomInteractive($response['domInteractive']);
        }
        if (array_key_exists('domLoading', $response))
        {
            $commonTestResult->setDomLoading($response['domLoading']);
        }
        if (array_key_exists('visualComplete', $response))
        {
            $commonTestResult->setVisualComplete($response['visualComplete']);
        }

        return $commonTestResult;
    }
}