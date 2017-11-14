class ChartsDataProvider {
  constructor(domainId = null, locationId = null, typeView = null, minTime = null, maxTime = null) {
    this.initializeRequest(domainId, locationId, typeView, minTime, maxTime);

    let thisPtr = this;
    let callbackInterval = setInterval(function() {
      if (thisPtr.subArray) {
        thisPtr.subArray = thisPtr.setChartsData(thisPtr.subArray);
        thisPtr.ttfb = thisPtr.subArray[0];
        thisPtr.docTime = thisPtr.subArray[1];
        thisPtr.fullyLoaded = thisPtr.subArray[2];
        thisPtr.time = thisPtr.subArray[3];
        thisPtr.domainUrls = thisPtr.subArray[4];
        clearInterval(callbackInterval);
      }
    }, 200);
  }

  /**
   * @private
   */
  initializeRequest(domainId, locationId, typeView, minTime, maxTime) {
    this.sendRequest(domainId, locationId, typeView, minTime, maxTime);
  }

  /**
   * @private
   */
  sendRequest(domainId, locationId, typeView, minTime, maxTime) {
    let dataArray = {
      'domainId': domainId,
      'locationId': locationId,
      'typeView': typeView,
      'minTime': minTime,
      'maxTime': maxTime
    };
    let requestParam = 'data=' + JSON.stringify(dataArray);

    let thisPtr = this;
    ajaxPost(FILE_GET_TEST_RESULT_FOR_CHART, requestParam, function(response) {
      thisPtr.subArray = response;
    });
  }

  /**
   * @private
   */
  setChartsData(response) {
    if (!'response' in response) {
      return null;
    }
    let jsonDecoded = JSON.parse(response['response']);
    if (!'testResult' in jsonDecoded) {
      return null;
    }
    let testResult = jsonDecoded['testResult'];
    return this.constructor.generateDataTestResult(jsonDecoded['testResult']);
  }

  /**
   * @private
   */
  static generateDataTestResult(testResult) {
    let time = [];
    let ttfb = [];
    let docTime = [];
    let domainUrls = [];
    let fullyLoaded = [];
    let urlInfo = null;
    let subArray = [];
    for (let urls in testResult) {
      if (testResult.hasOwnProperty(urls)) {
        domainUrls = Object.keys(testResult[urls]);

        for (let i = 0; i < domainUrls.length; i++) {
          urlInfo = testResult[urls][domainUrls[i]];
          ttfb.push(urlInfo.ttfb);
          docTime.push(urlInfo.doc_time);
          fullyLoaded.push(urlInfo.fully_loaded);
          time.push(urlInfo.time)
        }
      }
    }
    subArray.push(ttfb);
    subArray.push(docTime);
    subArray.push(fullyLoaded);
    subArray.push(time[0]);
    subArray.push(domainUrls);

    return subArray;
  }
}