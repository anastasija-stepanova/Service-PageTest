class DomainDashboardSettings {
  constructor(item) {
    let showButton = item.getElementsByClassName('save_options_button')[0];
    let domainId = item.getElementsByClassName('domain')[0].getAttribute('data-value');
    let locationId = null;
    let typeView = null;
    let presetId = null;
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

      [].forEach.call(item.getElementsByClassName('preset'), function(item) {
        if (item.checked) {
          presetId = item.getAttribute('data-value');
          return false;
        }
      });

      let dataArray = {
        'domainId': domainId,
        'locationId': locationId,
        'typeView': typeView,
        'presetId': presetId
      };

      let jsonString = 'data=' + JSON.stringify(dataArray);
      ajaxPost(FILE_GET_DATA_FOR_CHART, jsonString, function(response) {
        if ('response' in response) {
          let jsonDecode = JSON.parse(response['response']);
          let time = [];
          let ttfb = [];
          let docTime = [];
          let domainUrls = [];
          let fullyLoaded = [];
          if ('testResult' in jsonDecode) {
            let testResult = jsonDecode['testResult'];

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

          buildChartTtfb(time, ttfb, domainUrls);
          buildChartDocTime(time, docTime, domainUrls);
          buildChartFullyLoaded(time, fullyLoaded, domainUrls);
          $('#modalSettingDashboard').modal('hide');
        }
      });
    });
  }
}