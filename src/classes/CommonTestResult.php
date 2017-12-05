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

    public function setLoadTime(int $value): void
    {
        $this->loadTime = $value;
    }

    public function getLoadTime(): int
    {
        return $this->loadTime;
    }

    public function setTtfb(int $value): void
    {
        $this->ttfb = $value;
    }

    public function getTtfb(): int
    {
        return $this->ttfb;
    }

    public function setBytesOut(int $value): void
    {
        $this->bytesOut = $value;
    }

    public function getBytesOut(): int
    {
        return $this->bytesOut;
    }

    public function setBytesOutDoc(int $value): void
    {
        $this->bytesOutDoc = $value;
    }

    public function getBytesOutDoc(): int
    {
        return $this->bytesOutDoc;
    }

    public function setBytesIn(int $value): void
    {
        $this->bytesIn = $value;
    }

    public function getBytesIn(): int
    {
        return $this->bytesIn;
    }

    public function setBytesInDoc(int $value): void
    {
        $this->bytesInDoc = $value;
    }

    public function getBytesInDoc(): int
    {
        return $this->bytesInDoc;
    }

    public function setConnections(int $value): void
    {
        $this->connections = $value;
    }

    public function getConnections(): int
    {
        return $this->connections;
    }

    public function setRequests(int $value): void
    {
        $this->requests = $value;
    }

    public function getRequests(): int
    {
        return $this->requests;
    }

    public function setRequestsDoc(int $value): void
    {
        $this->requestsDoc = $value;
    }

    public function getRequestsDoc(): int
    {
        return $this->requestsDoc;
    }

    public function setResponses200(int $value): void
    {
        $this->responses200 = $value;
    }

    public function getResponses200(): int
    {
        return $this->responses200;
    }

    public function setResponses404(int $value): void
    {
        $this->responses404 = $value;
    }

    public function getResponses404(): int
    {
        return $this->responses404;
    }

    public function setResponsesOther(int $value): void
    {
        $this->responsesOther = $value;
    }

    public function getResponsesOther(): int
    {
        return $this->responsesOther;
    }

    public function setRenderTime(int $value): void
    {
        $this->renderTime = $value;
    }

    public function getRenderTime(): int
    {
        return $this->renderTime;
    }

    public function setFullyLoaded(int $value): void
    {
        $this->fullyLoaded = $value;
    }

    public function getFullyLoaded(): int
    {
        return $this->fullyLoaded;
    }

    public function setDocTime(int $value): void
    {
        $this->docTime = $value;
    }

    public function getDocTime(): int
    {
        return $this->docTime;
    }

    public function setDomElements(int $value): void
    {
        $this->domElements = $value;
    }

    public function getDomElements(): int
    {
        return $this->domElements;
    }

    public function setTitleTime(int $value): void
    {
        $this->titleTime = $value;
    }

    public function getTitleTime(): int
    {
        return $this->titleTime;
    }

    public function setLoadEventStart(int $value): void
    {
        $this->loadEventStart = $value;
    }

    public function getLoadEventStart(): int
    {
        return $this->loadEventStart;
    }

    public function setLoadEventEnd(int $value): void
    {
        $this->loadEventEnd = $value;
    }

    public function getLoadEventEnd(): int
    {
        return $this->loadEventEnd;
    }

    public function setDomContentLoadedEventStart(int $value): void
    {
        $this->domContentLoadedEventStart = $value;
    }

    public function getDomContentLoadedEventStart(): int
    {
        return $this->domContentLoadedEventStart;
    }

    public function setDomContentLoadedEventEnd(int $value): void
    {
        $this->domContentLoadedEventEnd = $value;
    }

    public function getDomContentLoadedEventEnd(): int
    {
        return $this->domContentLoadedEventEnd;
    }

    public function setFirstPaint(int $value): void
    {
        $this->firstPaint = $value;
    }

    public function getFirstPaint(): int
    {
        return $this->firstPaint;
    }

    public function setDomInteractive(int $value): void
    {
        $this->domInteractive = $value;
    }

    public function getDomInteractive(): int
    {
        return $this->domInteractive;
    }

    public function setDomLoading(int $value = null): void
    {
        $this->domLoading = $value;
    }

    public function getDomLoading(): int
    {
        return $this->domLoading;
    }

    public function setVisualComplete(int $value = null): void
    {
        $this->visualComplete = $value;
    }

    public function getVisualComplete(): int
    {
        return $this->visualComplete;
    }

    public function getAsArray(): array
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