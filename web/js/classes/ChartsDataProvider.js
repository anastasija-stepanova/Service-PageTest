class ChartsDataProvider {
  constructor(domainId = null, locationId = null, typeView = null, minTime = null, maxTime = null) {
    this.initializeRequest(domainId, locationId, typeView, minTime, maxTime);
    let thisPtr = this;
    document.addEventListener('hasAnswer', function() {
      let event = new CustomEvent('buildCharts');
      thisPtr.axisYNames = ChartsDataProvider.getAxisName(thisPtr.response);
      thisPtr.chartContainerName = ChartsDataProvider.getChartContainerName(thisPtr.response);
      thisPtr.response = ChartsDataProvider.setChartsData(thisPtr.response);
      if (thisPtr.response) {
        thisPtr.ttfbSubArray = thisPtr.response[0];
        thisPtr.docTimeSubArray = thisPtr.response[1];
        thisPtr.fullyLoadedSubArray = thisPtr.response[2];
        thisPtr.domainUrls = thisPtr.response[3];
        thisPtr.time = thisPtr.response[4];
        thisPtr.ttfb = [];
        thisPtr.docTime = [];
        thisPtr.fullyLoaded = [];
        thisPtr.ttfb = [];
        ChartsDataProvider.initializeArrayForCharts(thisPtr.ttfbSubArray, thisPtr.ttfb);
        ChartsDataProvider.initializeArrayForCharts(thisPtr.docTimeSubArray, thisPtr.docTime);
        ChartsDataProvider.initializeArrayForCharts(thisPtr.fullyLoadedSubArray, thisPtr.fullyLoaded);
        document.dispatchEvent(event);
      }
    });
  }

  /**
   * @private
   */
  static initializeArrayForCharts(subArr, finalArr) {
    for (let i = 0; i < subArr.length; i++) {
      let objectDocTime = [];
      let objectArray = [];
      for (let j = 0; j < subArr[i].length; j++) {
        objectDocTime = {
          x: new Date(subArr[i][j][0]),
          y: subArr[i][j][1]
        };
        objectArray.push(objectDocTime);
      }
      finalArr.push(objectArray);
    }
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
      thisPtr.response = response;
      let event = new CustomEvent('hasAnswer');
      document.dispatchEvent(event);
    });
  }

  /**
   * @private
   */
  static setChartsData(response) {
    if (!'response' in response) {
      return null;
    }
    if (response.response != undefined) {
      let jsonDecoded = JSON.parse(response['response']);
      if (!'testResult' in jsonDecoded) {
        return null;
      }
      return ChartsDataProvider.generateDataTestResult(jsonDecoded['testResult']);
    }
  }

  /**
   * @private
   */
  static getAxisName(response) {
    if (!'response' in response) {
      return null;
    }
    if (response.response != undefined) {
      let jsonDecoded = JSON.parse(response['response']);
      if (!'axisYName' in jsonDecoded) {
        return null;
      }
      return jsonDecoded['axisYName'];
    }
  }

  /**
   * @private
   */
  static getChartContainerName(response) {
    if (!'response' in response) {
      return null;
    }
    if (response.response != undefined) {
      let jsonDecoded = JSON.parse(response['response']);
      if (!'chartContainerName' in jsonDecoded) {
        return null;
      }
      return jsonDecoded['chartContainerName'];
    }
  }

  /**
   * @private
   */
  static generateDataTestResult(testResult) {
    let ttfb = [];
    let docTime = [];
    let domainUrls = [];
    let fullyLoaded = [];
    let urlInfo = null;
    let subArray = [];
    let subTtfb = [];
    let subDocTime = [];
    let subFullyLoaded = [];
    for (let urls in testResult) {
      if (testResult.hasOwnProperty(urls)) {
        domainUrls = Object.keys(testResult[urls]);

        for (let i = 0; i < domainUrls.length; i++) {
          urlInfo = testResult[urls][domainUrls[i]];

          for (let j = 0; j < urlInfo.ttfb.length; j++) {
            ttfb.push(urlInfo.ttfb[j]);
          }

          for (let k = 0; k < urlInfo.doc_time.length; k++) {
            docTime.push(urlInfo.doc_time[k]);
          }
          for (let n = 0; n < urlInfo.fully_loaded.length; n++) {
            fullyLoaded.push(urlInfo.fully_loaded[n]);
          }

          subTtfb.push(ttfb);
          subDocTime.push(docTime);
          subFullyLoaded.push(fullyLoaded);
          ttfb = [];
          docTime = [];
          fullyLoaded = [];
        }
      }
    }

    subArray.push(subTtfb);
    subArray.push(subDocTime);
    subArray.push(subFullyLoaded);
    subArray.push(domainUrls);

    return subArray;
  }
}