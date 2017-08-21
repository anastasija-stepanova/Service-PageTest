class DomainDashboardSettings {
  constructor(item) {
    let showButton = item.getElementsByClassName('save_options_button')[0];
    let domainId = item.getElementsByClassName('domain')[0].getAttribute('data-value');
    let locationId = null;
    let typeView = null;
    showButton.addEventListener('click', function() {
      [].forEach.call(item.getElementsByClassName('location'), function(item) {
        if (item.checked) {
          locationId = item.getAttribute('data-value');
          return false;
        }
      });
      [].forEach.call(item.getElementsByClassName('view'), function(item) {
        if (item.checked) {
          typeView = item.getAttribute('data-value');
          return false;
        }
      });

      let dataArray = {
        'domainId': domainId,
        'locationId': locationId,
        'typeView': typeView
      };
      let jsonString = 'data=' + JSON.stringify(dataArray);
      ajaxPost(FILE_GET_DATA_FOR_CHART, jsonString, function(response) {
        if ('response' in response) {
          console.log(response['response']);
          let jsonDecode = JSON.parse(response['response']);
          let ttfbMainPage = [];
          let ttfbIspringSuite = [];
          let ttfbPricing = [];
          let ttfbCompany = [];
          let docTimeMainPage = [];
          let docTimeIspringSuite = [];
          let docTimePricing = [];
          let docTimeCompany = [];
          let fullyLoadedMainPage = [];
          let fullyLoadedIspringSuite = [];
          let fullyLoadedPricing = [];
          let fullyLoadedCompany = [];
          let time = [];
          if ('testResult' in jsonDecode) {
            let testResult = jsonDecode['testResult'];

            for (let i = 0; i < testResult.length; i++) {
              time.push(testResult[i]["DATE_FORMAT(ar.completed_time, '%e %M')"]);

              if (testResult[i].url_id == 1) {
                ttfbMainPage.push(testResult[i].ttfb);
                docTimeMainPage.push(testResult[i].doc_time);
                fullyLoadedMainPage.push(testResult[i].fully_loaded);
              }
              if (testResult[i].url_id == 2) {
                ttfbIspringSuite.push(testResult[i].ttfb);
                docTimeIspringSuite.push(testResult[i].doc_time);
                fullyLoadedIspringSuite.push(testResult[i].fully_loaded);
              }
              if (testResult[i].url_id == 3) {
                ttfbPricing.push(testResult[i].ttfb);
                docTimePricing.push(testResult[i].doc_time);
                fullyLoadedPricing.push(testResult[i].fully_loaded);
              }
              if (testResult[i].url_id == 4) {
                ttfbCompany.push(testResult[i].ttfb);
                docTimeCompany.push(testResult[i].doc_time);
                fullyLoadedCompany.push(testResult[i].fully_loaded);
              }
              if (testResult[i].url_id == 5) {
                ttfbMainPage.push(testResult[i].ttfb);
                docTimeMainPage.push(testResult[i].doc_time);
                fullyLoadedMainPage.push(testResult[i].fully_loaded);
              }
              if (testResult[i].url_id == 6) {
                ttfbIspringSuite.push(testResult[i].ttfb);
                docTimeIspringSuite.push(testResult[i].doc_time);
                fullyLoadedIspringSuite.push(testResult[i].fully_loaded);
              }
              if (testResult[i].url_id == 7) {
                ttfbPricing.push(testResult[i].ttfb);
                docTimePricing.push(testResult[i].doc_time);
                fullyLoadedPricing.push(testResult[i].fully_loaded);
              }
              if (testResult[i].url_id == 8) {
                ttfbCompany.push(testResult[i].ttfb);
                docTimeCompany.push(testResult[i].doc_time);
                fullyLoadedCompany.push(testResult[i].fully_loaded);
              }
            }
          }

          buildChartTtfb(time, ttfbMainPage, ttfbIspringSuite, ttfbPricing, ttfbCompany);
          buildChartDocTime(time, docTimeMainPage, docTimeIspringSuite, docTimePricing, docTimeCompany);
          buildChartFullyLoaded(time, fullyLoadedMainPage, fullyLoadedIspringSuite, fullyLoadedPricing, fullyLoadedCompany);
          $('#modalSettingDashboard').modal('hide');
        }
      });
    });
  }
}