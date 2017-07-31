<?php

class CommonTestResultCreator
{
    public static function createFromMobileBrowser($response)
    {
        $commonTestResult = new CommonTestResult();

        $dataArray = [];
        $commonTestResult->setLoadTime($response['loadTime']);
        $dataArray[] = $commonTestResult->getLoadTime();

        $commonTestResult->setTtfb($response['TTFB']);
        $dataArray[] = $commonTestResult->getTtfb();

        $commonTestResult->setBytesOut($response['bytesOut']);
        $dataArray[] = $commonTestResult->getBytesOut();

        $commonTestResult->setBytesOutDoc($response['bytesOutDoc']);
        $dataArray[] = $commonTestResult->getBytesOutDoc();

        $commonTestResult->setBytesIn($response['bytesIn']);
        $dataArray[] = $commonTestResult->getBytesIn();

        $commonTestResult->setBytesInDoc($response['bytesInDoc']);
        $dataArray[] = $commonTestResult->getBytesInDoc();

        $commonTestResult->setConnections($response['connections']);
        $dataArray[] = $commonTestResult->getConnections();

        $commonTestResult->setRequests($response['requests']);
        $dataArray[] = $commonTestResult->getRequests();

        $commonTestResult->setRequestsDoc($response['requestsDoc']);
        $dataArray[] = $commonTestResult->getRequestsDoc();

        $commonTestResult->setResponses200($response['responses_200']);
        $dataArray[] = $commonTestResult->getResponses200();

        $commonTestResult->setResponses404($response['responses_404']);
        $dataArray[] = $commonTestResult->getResponses404();

        $commonTestResult->setResponsesOther($response['responses_other']);
        $dataArray[] = $commonTestResult->getResponsesOther();

        $commonTestResult->setRenderTime($response['render']);
        $dataArray[] = $commonTestResult->getRenderTime();

        $commonTestResult->setFullyLoaded($response['fullyLoaded']);
        $dataArray[] = $commonTestResult->getFullyLoaded();

        $commonTestResult->setDocTime($response['docTime']);
        $dataArray[] = $commonTestResult->getDocTime();

        $commonTestResult->setBasePageRedirects($response['final_base_page_request']);
        $dataArray[] = $commonTestResult->getBasePageRedirects();

        $commonTestResult->setDomElements($response['domElements']);
        $dataArray[] = $commonTestResult->getDomElements();

        $commonTestResult->setTitleTime($response['titleTime']);
        $dataArray[] = $commonTestResult->getTitleTime();

        $commonTestResult->setLoadEventStart($response['loadEventStart']);
        $dataArray[] = $commonTestResult->getLoadEventStart();

        $commonTestResult->setLoadEventEnd($response['loadEventEnd']);
        $dataArray[] = $commonTestResult->getLoadEventEnd();

        $commonTestResult->setDomContentLoadedEventStart($response['domContentLoadedEventStart']);
        $dataArray[] = $commonTestResult->getDomContentLoadedEventStart();

        $commonTestResult->setDomContentLoadedEventEnd($response['domContentLoadedEventEnd']);
        $dataArray[] = $commonTestResult->getDomContentLoadedEventEnd();

        $commonTestResult->setFirstPaint($response['firstPaint']);
        $dataArray[] = $commonTestResult->getFirstPaint();

        $commonTestResult->setDomInteractive($response['domInteractive']);
        $dataArray[] = $commonTestResult->getDomInteractive();

        $commonTestResult->setDomLoading($response['chromeUserTiming.domLoading']);
        $dataArray[] = $commonTestResult->getDomLoading();

        $commonTestResult->setVisualComplete($response['chromeUserTiming.domComplete']);
        $dataArray[] = $commonTestResult->getVisualComplete();

        return $dataArray;
    }

    public static function createFromDesktopBrowser($response)
    {
        $commonTestResult = new CommonTestResult();

        $dataArray = [];
        $commonTestResult->setLoadTime($response['loadTime']);
        $dataArray[] = $commonTestResult->getLoadTime();

        $commonTestResult->setTtfb($response['TTFB']);
        $dataArray[] = $commonTestResult->getTtfb();

        $commonTestResult->setBytesOut($response['bytesOut']);
        $dataArray[] = $commonTestResult->getBytesOut();

        $commonTestResult->setBytesOutDoc($response['bytesOutDoc']);
        $dataArray[] = $commonTestResult->getBytesOutDoc();

        $commonTestResult->setBytesIn($response['bytesIn']);
        $dataArray[] = $commonTestResult->getBytesIn();

        $commonTestResult->setBytesInDoc($response['bytesInDoc']);
        $dataArray[] = $commonTestResult->getBytesInDoc();

        $commonTestResult->setConnections($response['connections']);
        $dataArray[] = $commonTestResult->getConnections();

        $commonTestResult->setRequests($response['requests']);
        $dataArray[] = $commonTestResult->getRequests();

        $commonTestResult->setRequestsDoc($response['requestsDoc']);
        $dataArray[] = $commonTestResult->getRequestsDoc();

        $commonTestResult->setResponses200($response['responses_200']);
        $dataArray[] = $commonTestResult->getResponses200();

        $commonTestResult->setResponses404($response['responses_404']);
        $dataArray[] = $commonTestResult->getResponses404();

        $commonTestResult->setResponsesOther($response['responses_other']);
        $dataArray[] = $commonTestResult->getResponsesOther();

        $commonTestResult->setRenderTime($response['render']);
        $dataArray[] = $commonTestResult->getRenderTime();

        $commonTestResult->setFullyLoaded($response['fullyLoaded']);
        $dataArray[] = $commonTestResult->getFullyLoaded();

        $commonTestResult->setDocTime($response['docTime']);
        $dataArray[] = $commonTestResult->getDocTime();

        $commonTestResult->setBasePageRedirects($response['base_page_redirects']);
        $dataArray[] = $commonTestResult->getBasePageRedirects();

        $commonTestResult->setDomElements($response['domElements']);
        $dataArray[] = $commonTestResult->getDomElements();

        $commonTestResult->setTitleTime($response['titleTime']);
        $dataArray[] = $commonTestResult->getTitleTime();

        $commonTestResult->setLoadEventStart($response['loadEventStart']);
        $dataArray[] = $commonTestResult->getLoadEventStart();

        $commonTestResult->setLoadEventEnd($response['loadEventEnd']);
        $dataArray[] = $commonTestResult->getLoadEventEnd();

        $commonTestResult->setDomContentLoadedEventStart($response['domContentLoadedEventStart']);
        $dataArray[] = $commonTestResult->getDomContentLoadedEventStart();

        $commonTestResult->setDomContentLoadedEventEnd($response['domContentLoadedEventEnd']);
        $dataArray[] = $commonTestResult->getDomContentLoadedEventEnd();

        $commonTestResult->setFirstPaint($response['firstPaint']);
        $dataArray[] = $commonTestResult->getFirstPaint();

        $commonTestResult->setDomInteractive($response['domInteractive']);
        $dataArray[] = $commonTestResult->getDomInteractive();

        $commonTestResult->setDomLoading($response['domLoading']);
        $dataArray[] = $commonTestResult->getDomLoading();

        $commonTestResult->setVisualComplete($response['visualComplete']);
        $dataArray[] = $commonTestResult->getVisualComplete();

        return $dataArray;
    }

    public static function createFromDullesLinuxChrome($response)
    {
        $commonTestResult = new CommonTestResult();

        $dataArray = [];
        $commonTestResult->setLoadTime($response['loadTime']);
        $dataArray[] = $commonTestResult->getLoadTime();

        $commonTestResult->setTtfb($response['TTFB']);
        $dataArray[] = $commonTestResult->getTtfb();

        $commonTestResult->setBytesOut($response['bytesOut']);
        $dataArray[] = $commonTestResult->getBytesOut();

        $commonTestResult->setBytesOutDoc($response['bytesOutDoc']);
        $dataArray[] = $commonTestResult->getBytesOutDoc();

        $commonTestResult->setBytesIn($response['bytesIn']);
        $dataArray[] = $commonTestResult->getBytesIn();

        $commonTestResult->setBytesInDoc($response['bytesInDoc']);
        $dataArray[] = $commonTestResult->getBytesInDoc();

        $commonTestResult->setConnections($response['connections']);
        $dataArray[] = $commonTestResult->getConnections();

        $commonTestResult->setRequests($response['requests']);
        $dataArray[] = $commonTestResult->getRequests();

        $commonTestResult->setRequestsDoc($response['requestsDoc']);
        $dataArray[] = $commonTestResult->getRequestsDoc();

        $commonTestResult->setResponses200($response['responses_200']);
        $dataArray[] = $commonTestResult->getResponses200();

        $commonTestResult->setResponses404($response['responses_404']);
        $dataArray[] = $commonTestResult->getResponses404();

        $commonTestResult->setResponsesOther($response['responses_other']);
        $dataArray[] = $commonTestResult->getResponsesOther();

        $commonTestResult->setRenderTime($response['render']);
        $dataArray[] = $commonTestResult->getRenderTime();

        $commonTestResult->setFullyLoaded($response['fullyLoaded']);
        $dataArray[] = $commonTestResult->getFullyLoaded();

        $commonTestResult->setDocTime($response['docTime']);
        $dataArray[] = $commonTestResult->getDocTime();

        $commonTestResult->setBasePageRedirects(0);
        $dataArray[] = $commonTestResult->getBasePageRedirects();

        $commonTestResult->setDomElements($response['domElements']);
        $dataArray[] = $commonTestResult->getDomElements();

        $commonTestResult->setTitleTime($response['titleTime']);
        $dataArray[] = $commonTestResult->getTitleTime();

        $commonTestResult->setLoadEventStart($response['loadEventStart']);
        $dataArray[] = $commonTestResult->getLoadEventStart();

        $commonTestResult->setLoadEventEnd($response['loadEventEnd']);
        $dataArray[] = $commonTestResult->getLoadEventEnd();

        $commonTestResult->setDomContentLoadedEventStart($response['domContentLoadedEventStart']);
        $dataArray[] = $commonTestResult->getDomContentLoadedEventStart();

        $commonTestResult->setDomContentLoadedEventEnd($response['domContentLoadedEventEnd']);
        $dataArray[] = $commonTestResult->getDomContentLoadedEventEnd();

        $commonTestResult->setFirstPaint($response['firstPaint']);
        $dataArray[] = $commonTestResult->getFirstPaint();

        $commonTestResult->setDomInteractive($response['domInteractive']);
        $dataArray[] = $commonTestResult->getDomInteractive();

        $commonTestResult->setDomLoading($response['domLoading']);
        $dataArray[] = $commonTestResult->getDomLoading();

        $commonTestResult->setVisualComplete($response['visualComplete']);
        $dataArray[] = $commonTestResult->getVisualComplete();

        return $dataArray;
    }

    public static function createFromDullesLinuxFirefox($response)
    {
        $commonTestResult = new CommonTestResult();

        $dataArray = [];
        $commonTestResult->setLoadTime($response['loadTime']);
        $dataArray[] = $commonTestResult->getLoadTime();

        $commonTestResult->setTtfb($response['TTFB']);
        $dataArray[] = $commonTestResult->getTtfb();

        $commonTestResult->setBytesOut($response['bytesOut']);
        $dataArray[] = $commonTestResult->getBytesOut();

        $commonTestResult->setBytesOutDoc($response['bytesOutDoc']);
        $dataArray[] = $commonTestResult->getBytesOutDoc();

        $commonTestResult->setBytesIn($response['bytesIn']);
        $dataArray[] = $commonTestResult->getBytesIn();

        $commonTestResult->setBytesInDoc($response['bytesInDoc']);
        $dataArray[] = $commonTestResult->getBytesInDoc();

        $commonTestResult->setConnections(0);
        $dataArray[] = $commonTestResult->getConnections();

        $commonTestResult->setRequests($response['requests']);
        $dataArray[] = $commonTestResult->getRequests();

        $commonTestResult->setRequestsDoc($response['requestsDoc']);
        $dataArray[] = $commonTestResult->getRequestsDoc();

        $commonTestResult->setResponses200($response['responses_200']);
        $dataArray[] = $commonTestResult->getResponses200();

        $commonTestResult->setResponses404($response['responses_404']);
        $dataArray[] = $commonTestResult->getResponses404();

        $commonTestResult->setResponsesOther($response['responses_other']);
        $dataArray[] = $commonTestResult->getResponsesOther();

        $commonTestResult->setRenderTime($response['render']);
        $dataArray[] = $commonTestResult->getRenderTime();

        $commonTestResult->setFullyLoaded($response['fullyLoaded']);
        $dataArray[] = $commonTestResult->getFullyLoaded();

        $commonTestResult->setDocTime($response['docTime']);
        $dataArray[] = $commonTestResult->getDocTime();

        $commonTestResult->setBasePageRedirects(0);
        $dataArray[] = $commonTestResult->getBasePageRedirects();

        $commonTestResult->setDomElements($response['domElements']);
        $dataArray[] = $commonTestResult->getDomElements();

        $commonTestResult->setTitleTime($response['titleTime']);
        $dataArray[] = $commonTestResult->getTitleTime();

        $commonTestResult->setLoadEventStart($response['loadEventStart']);
        $dataArray[] = $commonTestResult->getLoadEventStart();

        $commonTestResult->setLoadEventEnd($response['loadEventEnd']);
        $dataArray[] = $commonTestResult->getLoadEventEnd();

        $commonTestResult->setDomContentLoadedEventStart($response['domContentLoadedEventStart']);
        $dataArray[] = $commonTestResult->getDomContentLoadedEventStart();

        $commonTestResult->setDomContentLoadedEventEnd($response['domContentLoadedEventEnd']);
        $dataArray[] = $commonTestResult->getDomContentLoadedEventEnd();

        $commonTestResult->setFirstPaint($response['firstPaint']);
        $dataArray[] = $commonTestResult->getFirstPaint();

        $commonTestResult->setDomInteractive($response['domInteractive']);
        $dataArray[] = $commonTestResult->getDomInteractive();

        $commonTestResult->setDomLoading($response['domLoading']);
        $dataArray[] = $commonTestResult->getDomLoading();

        $commonTestResult->setVisualComplete($response['visualComplete']);
        $dataArray[] = $commonTestResult->getVisualComplete();

        return $dataArray;
    }
}