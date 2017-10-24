(function() {
  buildCharts();
})();

function buildCharts() {
  let keyValue = {
    'result': 'testResult'
  };
  let jsonString = 'data=' + JSON.stringify(keyValue);
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
    }
  });
}

function buildChart(classChartContainer, time, resourceTestingData, domainUrls, axisYTitle) {
  const MAX_VISIBLE_LENGTH_WITHOUT_PERIOD = 20;
  const PERIOD_OUTPUT_POINTS = 4;
  new Chartist.Line(classChartContainer, {
    labels: time[0],
    series: resourceTestingData,
  }, {
    chartPadding: {
      top: 60,
      bottom: 20,
      left: 20,
      areaBase: 50,
    },
    plugins: [
      Chartist.plugins.legend({
        legendNames: domainUrls,
        removeAll: true,
      }),
      Chartist.plugins.tooltip({
        currencyFormatCallback: function getUnits(value) {
          value = value + ' ms';
          return value;
        },
        currency: 'ms',
      }),
      Chartist.plugins.ctAxisTitle({
        axisX: {
          axisTitle: 'Time (in days)',
          axisClass: 'ct-axis-title',
          type: Chartist.AutoScaleAxis,
          offset: {
            x: 0,
            y: 43
          },
          textAnchor: 'middle'
        },
        axisY: {
          axisTitle: axisYTitle,
          axisClass: 'ct-axis-title',
          type: Chartist.AutoScaleAxis,
          offset: {
            x: -50,
            y: -3
          },
        }
      }),
    ],
    axisX: {
      labelInterpolationFnc: function skipLabels(value, index, labels) {
        if (labels.length > MAX_VISIBLE_LENGTH_WITHOUT_PERIOD) {
          return index % PERIOD_OUTPUT_POINTS === 0 ? value : null;
        }
        return value;
      }
    },
  });
}