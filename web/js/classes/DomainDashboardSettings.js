class DomainDashboardSettings {
  constructor(item) {
    let showButton = item.getElementsByClassName('save_options_button')[0];
    let domainId = item.getElementsByClassName('domain')[0].getAttribute('data-value');
    let locationId = null;
    let typeView = null;
    let minTime = null;
    let maxTime = null;
    let selectedLocation = null;
    showButton.addEventListener('click', function() {
      [].forEach.call(item.getElementsByClassName('form-control'), function(item) {
        selectedLocation = item.value;
      });

      [].forEach.call(item.getElementsByClassName('location'), function(item) {
        if (item.value == selectedLocation) {
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

      [].forEach.call(item.getElementsByClassName('min-slider-handle'), function(item) {
          minTime = item.getAttribute('aria-valuenow') / 1000;
          return false;
      });

      [].forEach.call(item.getElementsByClassName('max-slider-handle'), function(item) {
          maxTime = item.getAttribute('aria-valuenow') / 1000;
          return false;
      });

      let dataArray = {
        'domainId': domainId,
        'locationId': locationId,
        'typeView': typeView,
        'minTime': minTime,
        'maxTime': maxTime
      };

      let jsonString = 'data=' + JSON.stringify(dataArray);
      ajaxPost(FILE_GET_DATA_FOR_CHART, jsonString, function(response) {
        if ('response' in response) {
          let jsonDecoded = JSON.parse(response['response']);
          let time = [];
          let ttfb = [];
          let docTime = [];
          let domainUrls = [];
          let fullyLoaded = [];
          if ('testResult' in jsonDecoded) {
            let testResult = jsonDecoded['testResult'];

            for (let urls in testResult) {
              if (testResult.hasOwnProperty(urls)) {
                domainUrls = Object.keys(testResult[urls]);

                for (let i = 0; i < domainUrls.length; i++) {
                  ttfb.push(testResult[urls][domainUrls[i]].ttfb);
                  docTime.push(testResult[urls][domainUrls[i]].doc_time);
                  fullyLoaded.push(testResult[urls][domainUrls[i]].fully_loaded);
                  time.push(testResult[urls][domainUrls[i]].time)
                }
              }
            }
          }

          buildChart(CLASS_TTFB_CHART_CONTAINER, time, ttfb, domainUrls, ASIX_Y_TITLE_TTFB_CHART);
          buildChart(CLASS_DOC_TIME_CHART_CONTAINER, time, docTime, domainUrls, ASIX_Y_TITLE_DOC_TIME_CHART);
          buildChart(CLASS_FULLY_LOAD_TIME_CHART_CONTAINER, time, fullyLoaded, domainUrls, ASIX_Y_TITLE_FULLY_LOAD_TIME_CHART);
          $('#modalSettingDashboard').modal('hide');
        }
      });
    });
  }
}