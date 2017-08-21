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
        }
      }

      buildChartTtfb(time, ttfbMainPage, ttfbIspringSuite, ttfbPricing, ttfbCompany);
      buildChartDocTime(time, docTimeMainPage, docTimeIspringSuite, docTimePricing, docTimeCompany);
      buildChartFullyLoaded(time, fullyLoadedMainPage, fullyLoadedIspringSuite, fullyLoadedPricing, fullyLoadedCompany);
    }
  });
}

function unique(array) {
  let obj = {};

  for (let i = 0; i < array.length; i++) {
    let str = array[i];
    obj[str] = true;
  }

  return Object.keys(obj);
}

function buildChartTtfb(time, ttfbMainPage, ttfbIspringSuite, ttfbPricing, ttfbCompany) {
  new Chartist.Line('.ct-chart1', {
    labels: unique(time),
    series: [
      ttfbMainPage,
      ttfbIspringSuite,
      ttfbPricing,
      ttfbCompany
    ]
  }, {
    chartPadding: {
      top: 60,
      bottom: 20,
      left: 20,
      areaBase: 50,
    },
    plugins: [
      Chartist.plugins.legend({
        legendNames: ['/', '/ispring-suite', '/pricing.html', '/company.html'],
        removeAll: true
      }),
      Chartist.plugins.tooltip({
        anchorToPoint: true,
        appendToBody: true
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

function buildChartDocTime(time, docTimeMainPage, docTimeIspringSuite, docTimePricing, docTimeCompany) {
  new Chartist.Line('.ct-chart2', {
    labels: unique(time),
    series: [
      docTimeMainPage,
      docTimeIspringSuite,
      docTimePricing,
      docTimeCompany
    ]
  }, {
    chartPadding: {
      top: 60,
      bottom: 20,
      left: 20
    },
    plugins: [
      Chartist.plugins.legend({
        legendNames: ['/', '/ispring-suite', '/pricing.html', '/company.html'],
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

function buildChartFullyLoaded(time, fullyLoadedMainPage, fullyLoadedIspringSuite, fullyLoadedPricing, fullyLoadedCompany) {
  new Chartist.Line('.ct-chart3', {
    labels: unique(time),
    series: [
      fullyLoadedMainPage,
      fullyLoadedIspringSuite,
      fullyLoadedPricing,
      fullyLoadedCompany
    ]
  }, {
    chartPadding: {
      top: 60,
      bottom: 20,
      left: 20
    },
    plugins: [
      Chartist.plugins.legend({
        legendNames: ['/', '/ispring-suite', '/pricing.html', '/company.html'],
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