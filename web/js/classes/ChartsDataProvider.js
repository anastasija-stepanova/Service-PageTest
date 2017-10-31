class ChartsDataProvider {
  constructor() {
    let thisPtr = this;
    this.time = [];
    this.ttfb = [];
    this.docTime = [];
    this.domainUrls = [];
    this.fullyLoaded = [];
    this.setChartsData(thisPtr);
  }

  setChartsData(thisPtr) {
    let keyValue = {
      'result': 'testResult'
    };
    let urls = [];
    let subArrayTime = [];
    let jsonString = 'data=' + JSON.stringify(keyValue);
    ajaxPost(FILE_GET_DATA_FOR_CHART, jsonString, function(response) {
      if ('response' in response) {
        let jsonDecoded = JSON.parse(response['response']);
        if ('testResult' in jsonDecoded) {
          let testResult = jsonDecoded['testResult'];
          for (let urls in testResult) {
            if (testResult.hasOwnProperty(urls)) {
              urls = Object.keys(testResult[urls]);
              for (let i = 0; i < this.domainUrls.length; i++) {
                this.ttfb.push(testResult[urls][this.domainUrls[i]].ttfb);
                this.docTime.push(testResult[urls][this.domainUrls[i]].doc_time);
                this.fullyLoaded.push(testResult[urls][this.domainUrls[i]].fully_loaded);
                subArrayTime.push(testResult[urls][this.domainUrls[i]].time);
              }
            }
          }
        }
      }
    });
    thisPtr.domainUrls = urls;
    thisPtr.time = subArrayTime[0];
  }
}