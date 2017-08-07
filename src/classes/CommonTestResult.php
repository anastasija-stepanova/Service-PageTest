<?php

class CommonTestResult
{
    private $loadTime = 0;
    private $ttfb = 0;
    private $bytesOut = 0;
    private $bytesOutDoc = 0;
    private $bytesIn = 0;
    private $bytesInDoc = 0;
    private $connections = 0;
    private $requests = 0;
    private $requestsDoc = 0;
    private $responses200 = 0;
    private $responses404 = 0;
    private $responsesOther = 0;
    private $renderTime = 0;
    private $fullyLoaded = 0;
    private $docTime = 0;
    private $domElements = 0;
    private $titleTime = 0;
    private $loadEventStart = 0;
    private $loadEventEnd = 0;
    private $domContentLoadedEventStart = 0;
    private $domContentLoadedEventEnd = 0;
    private $firstPaint = 0;
    private $domInteractive = 0;
    private $domLoading = 0;
    private $visualComplete = 0;

    public function setLoadTime($value)
    {
        $this->loadTime = $value;
    }

    public function getLoadTime()
    {
        return $this->loadTime;
    }

    public function setTtfb($value)
    {
        $this->ttfb = $value;
    }

    public function getTtfb()
    {
        return $this->ttfb;
    }

    public function setBytesOut($value)
    {
        $this->bytesOut = $value;
    }

    public function getBytesOut()
    {
        return $this->bytesOut;
    }

    public function setBytesOutDoc($value)
    {
        $this->bytesOutDoc = $value;
    }

    public function getBytesOutDoc()
    {
        return $this->bytesOutDoc;
    }

    public function setBytesIn($value)
    {
        $this->bytesIn = $value;
    }

    public function getBytesIn()
    {
        return $this->bytesIn;
    }

    public function setBytesInDoc($value)
    {
        $this->bytesInDoc = $value;
    }

    public function getBytesInDoc()
    {
        return $this->bytesInDoc;
    }

    public function setConnections($value)
    {
        $this->connections = $value;
    }

    public function getConnections()
    {
        return $this->connections;
    }

    public function setRequests($value)
    {
        $this->requests = $value;
    }

    public function getRequests()
    {
        return $this->requests;
    }

    public function setRequestsDoc($value)
    {
        $this->requestsDoc = $value;
    }

    public function getRequestsDoc()
    {
        return $this->requestsDoc;
    }

    public function setResponses200($value)
    {
        $this->responses200 = $value;
    }

    public function getResponses200()
    {
        return $this->responses200;
    }

    public function setResponses404($value)
    {
        $this->responses404 = $value;
    }

    public function getResponses404()
    {
        return $this->responses404;
    }

    public function setResponsesOther($value)
    {
        $this->responsesOther = $value;
    }

    public function getResponsesOther()
    {
        return $this->responsesOther;
    }

    public function setRenderTime($value)
    {
        $this->renderTime = $value;
    }

    public function getRenderTime()
    {
        return $this->renderTime;
    }

    public function setFullyLoaded($value)
    {
        $this->fullyLoaded = $value;
    }

    public function getFullyLoaded()
    {
        return $this->fullyLoaded;
    }

    public function setDocTime($value)
    {
        $this->docTime = $value;
    }

    public function getDocTime()
    {
        return $this->docTime;
    }

    public function setDomElements($value)
    {
        $this->domElements = $value;
    }

    public function getDomElements()
    {
        return $this->domElements;
    }

    public function setTitleTime($value)
    {
        $this->titleTime = $value;
    }

    public function getTitleTime()
    {
        return $this->titleTime;
    }

    public function setLoadEventStart($value)
    {
        $this->loadEventStart = $value;
    }

    public function getLoadEventStart()
    {
        return $this->loadEventStart;
    }

    public function setLoadEventEnd($value)
    {
        $this->loadEventEnd = $value;
    }

    public function getLoadEventEnd()
    {
        return $this->loadEventEnd;
    }

    public function setDomContentLoadedEventStart($value)
    {
        $this->domContentLoadedEventStart = $value;
    }

    public function getDomContentLoadedEventStart()
    {
        return $this->domContentLoadedEventStart;
    }

    public function setDomContentLoadedEventEnd($value)
    {
        $this->domContentLoadedEventEnd = $value;
    }

    public function getDomContentLoadedEventEnd()
    {
        return $this->domContentLoadedEventEnd;
    }

    public function setFirstPaint($value)
    {
        $this->firstPaint = $value;
    }

    public function getFirstPaint()
    {
        return $this->firstPaint;
    }

    public function setDomInteractive($value)
    {
        $this->domInteractive = $value;
    }

    public function getDomInteractive()
    {
        return $this->domInteractive;
    }

    public function setDomLoading($value)
    {
        $this->domLoading = $value;
    }

    public function getDomLoading()
    {
        return $this->domLoading;
    }

    public function setVisualComplete($value)
    {
        $this->visualComplete = $value;
    }

    public function getVisualComplete()
    {
        return $this->visualComplete;
    }

    public function getAsArray()
    {
        return [
            $this->loadTime,
            $this->ttfb,
            $this->bytesOut,
            $this->bytesOutDoc,
            $this->bytesIn,
            $this->bytesInDoc,
            $this->connections,
            $this->requests,
            $this->requestsDoc,
            $this->responses200,
            $this->responses404,
            $this->responsesOther,
            $this->renderTime,
            $this->fullyLoaded,
            $this->docTime,
            $this->domElements,
            $this->titleTime,
            $this->loadEventStart,
            $this->loadEventEnd,
            $this->domContentLoadedEventStart,
            $this->domContentLoadedEventEnd,
            $this->firstPaint,
            $this->domInteractive,
            $this->domLoading,
            $this->visualComplete,
        ];
    }
}