(function() {
  buildChart();
})();
function buildChart() {
  let keyValue = {
    'result': 'ttfb'
  };
  let jsonString = 'data=' + JSON.stringify(keyValue);
  ajaxPost(FILE_GET_DATA_FROM_DB, jsonString, function(response) {
      if ('response' in response) {
        let jsonDecode = JSON.parse(response['response']);
        let ttfbMainPage;
        let ttfbIspringSuite;
        let ttfbPricing;
        let ttfbCompany;
        let docTimeMainPage;
        let docTimeIspringSuite;
        let docTimePricing;
        let docTimeCompany;
        let fullyLoadedMainPage;
        let fullyLoadedIspringSuite;
        let fullyLoadedPricing;
        let fullyLoadedCompany;
        if ('testResult' in jsonDecode) {
          let testResult = jsonDecode['testResult'];
          for (let i = 0; i < testResult.length; i++) {
            if (testResult[i].url_id == 1) {
              ttfbMainPage = testResult[i].ttfb;
              docTimeMainPage = testResult[i].doc_time;
              fullyLoadedMainPage = testResult[i].fully_loaded;
            }
            if (testResult[i].url_id == 2) {
              ttfbIspringSuite = testResult[i].ttfb;
              docTimeIspringSuite = testResult[i].doc_time;
              fullyLoadedIspringSuite = testResult[i].fully_loaded;
            }
            if (testResult[i].url_id == 3) {
              ttfbPricing = testResult[i].ttfb;
              docTimePricing = testResult[i].doc_time;
              fullyLoadedPricing = testResult[i].fully_loaded;
            }
            if (testResult[i].url_id == 4) {
              ttfbCompany = testResult[i].doc_time;
              docTimeCompany = testResult[i].doc_time;
              fullyLoadedCompany = testResult[i].fully_loaded;
            }
          }
        }

        let time = [];
        if ('time' in jsonDecode) {
          time = jsonDecode['time'];
        }

        new Chartist.Line('.ct-chart1', {
          labels: time,
          series: [
            [ttfbMainPage],
            [ttfbIspringSuite],
            [ttfbPricing],
            [ttfbCompany]
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

        new Chartist.Line('.ct-chart2', {
          labels: time,
          series: [
            [docTimeMainPage],
            [docTimeIspringSuite],
            [docTimePricing],
            [docTimeCompany]
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
        });

        new Chartist.Line('.ct-chart3', {
          labels: time,
          series: [
            [fullyLoadedMainPage],
            [fullyLoadedIspringSuite],
            [fullyLoadedPricing],
            [fullyLoadedCompany]
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
    }
  );
}