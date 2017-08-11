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
        let ttfb = jsonDecode['ttfb'];
        let docTime = jsonDecode['docTime'];
        let fullyLoaded = jsonDecode['fullyLoaded'];
        let time = jsonDecode['time'];
        let storeReset;
        let chart = new Chartist.Line('.ct-chart1', {
          labels: [time],
          series: [ttfb
          ]
        }, {
          plugins: [
            Chartist.plugins.zoom({
              onZoom: function(chart, reset) {
                storeReset(reset);
              }
            }),
            Chartist.plugins.tooltip({}),
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
          labels: [time],
          series: [docTime
          ]
        }, {
          plugins: [
            Chartist.plugins.zoom({
              onZoom: function(chart, reset) {
                storeReset(reset)
              }
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
          labels: [time],
          series: [fullyLoaded
          ]
        }, {
          plugins: [
            Chartist.plugins.zoom({
              onZoom: function(chart, reset) {
                storeReset(reset)
              }
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
      //   let dataOne = {
      //     labels: time,
      //     series: [ttfb
      //       ]
      //   };
      //   new Chartist.Line('.ct-chart1', dataOne);
      //
      //   let dataTwo = {
      //     labels: time,
      //     series: [docTime
      //       ]
      //   };
      //   new Chartist.Line('.ct-chart2', dataTwo);
      //
      //   let dataThree = {
      //     labels: time,
      //     series: [fullyLoaded
      //     ]
      //   };
      //   new Chartist.Line('.ct-chart3', dataThree);
      // }
      //
      // plugins: [
      //   Chartist.plugins.tooltip()
      // ]
    }
  );
}