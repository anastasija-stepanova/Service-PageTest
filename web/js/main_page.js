(function() {
  buildChart();
})();

function buildChart() {
  let keyValue = {
    'result': 'ttfb'
  };
  let jsonString = 'data=' + JSON.stringify(keyValue);
  ajaxPost(FILE_GET_DATA_FROM_DB, jsonString, function(response) {
    if ('response' in response)
    {
      let jsonDecode = JSON.parse(response['response']);
      let ttfb = jsonDecode['ttfb'];
      let loadTime = jsonDecode['loadTime'];
      let requests = jsonDecode['requests'];
      let time = jsonDecode['time'];
      let dataOne = {
        labels: time,
        series: [ttfb
          ]
      };
      new Chartist.Line('.ct-chart1', dataOne);

      let dataTwo = {
        labels: time,
        series: [loadTime
          ]
      };
      new Chartist.Line('.ct-chart2', dataTwo);

      let dataThree = {
        labels: time,
        series: [requests
        ]
      };
      new Chartist.Line('.ct-chart3', dataThree);
    }
  });
}