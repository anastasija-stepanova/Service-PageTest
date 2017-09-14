(function() {
  buildChart();
})();

function buildChart() {
  let keyValue = {
    'result': 'testResult'
  };
  let jsonString = 'data=' + JSON.stringify(keyValue);
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
    }
  });
}

function buildChartTtfb(time, ttfb, domainUrls) {
  new Chartist.Line('.ct-chart1', {
    labels: time[0],
    series:
      ttfb

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
        removeAll: true
      }),
      Chartist.plugins.tooltip({
      }),
      Chartist.plugins.ctAxisTitle({
        axisX: {
          axisTitle: 'Time (in days)',
          axisClass: 'ct-axis-title',
          type: Chartist.AutoScaleAxis,
          offset: {
            x: 0,
            y: 32
          },
          textAnchor: 'middle'
        },
        axisY: {
          axisTitle: 'TTFB (ms)',
          axisClass: 'ct-axis-title',
          type: Chartist.AutoScaleAxis,
          offset: {
            x: -50,
            y: -3
          },
        }
      }),
    ],
  });
}

function buildChartDocTime(time, docTime, domainUrls) {
  new Chartist.Line('.ct-chart2', {
    labels: time[0],
    series: docTime
  }, {
    chartPadding: {
      top: 60,
      bottom: 20,
      left: 20
    },
    plugins: [
      Chartist.plugins.legend({
        legendNames: domainUrls,
        removeAll: true
      }),
      Chartist.plugins.tooltip({}),
      Chartist.plugins.ctAxisTitle({
        axisX: {
          axisTitle: 'Time (in days)',
          axisClass: 'ct-axis-title',
          offset: {
            x: 0,
            y: 32
          },
          textAnchor: 'middle'
        },
        axisY: {
          axisTitle: 'Document Complete (ms)',
          axisClass: 'ct-axis-title',
          offset: {
            x: -50,
            y: -3
          },
        }
      }),
    ]
  })
}

function buildChartFullyLoaded(time, fullyLoaded, domainUrls) {
  new Chartist.Line('.ct-chart3', {
    labels: time[0],
    series: fullyLoaded
  }, {
    chartPadding: {
      top: 60,
      bottom: 20,
      left: 20
    },
    plugins: [
      Chartist.plugins.legend({
        legendNames: domainUrls,
        removeAll: true
      }),
      Chartist.plugins.tooltip({}),
      Chartist.plugins.ctAxisTitle({
        axisX: {
          axisTitle: 'Time (in days)',
          axisClass: 'ct-axis-title',
          offset: {
            x: 50,
            y: 32
          },
          textAnchor: 'middle'
        },
        axisY: {
          axisTitle: 'Fully Load Time (ms)',
          axisClass: 'ct-axis-title',
          offset: {
            x: -50,
            y: -3
          },
        }
      }),
    ]
  });
}