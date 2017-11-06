class ChartsDataProvider {
  constructor(domainId, locationId, typeView, minTime, maxTime) {
    let subArray = this.sendRequest(domainId, locationId, typeView, minTime, maxTime);
    console.log(subArray);
    this.ttfb = [];
    this.docTime = [];
    this.fullyLoaded = [];
    this.time = [];
    this.domainUrls = [];
  }

  sendRequest(domainId, locationId, typeView, minTime, maxTime) {
    let dataArray = {
      'domainId': domainId,
      'locationId': locationId,
      'typeView': typeView,
      'minTime': minTime,
      'maxTime': maxTime
    };
    let jsonString = 'data=' + JSON.stringify(dataArray);
    ajaxPost(FILE_GET_TEST_RESULT_FOR_CHART, jsonString, this.setChartsData);
  }

  setChartsData(response) {
    if ('response' in response) {
      let jsonDecoded = JSON.parse(response['response']);
      let time = [];
      let ttfb = [];
      let docTime = [];
      let domainUrls = [];
      let fullyLoaded = [];
      let urlInfo = null;
      let subArray = [];
      if ('testResult' in jsonDecoded) {
        let testResult = jsonDecoded['testResult'];
        //this.subArray = this.generateDataTestResult(jsonDecoded['testResult'][1]);
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
      }
      subArray.push(ttfb);
      subArray.push(docTime);
      subArray.push(fullyLoaded);
      subArray.push(time[0]);
      subArray.push(domainUrls);
      console.log(subArray);
    }
  }

  generateDataTestResult(testResult) {
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
    console.log(ttfb);
    subArray.push(ttfb);
    subArray.push(docTime);
    subArray.push(fullyLoaded);
    subArray.push(time[0]);
    subArray.push(domainUrls);
  }
}