(function() {
  const MILLISECONDS_IN_DAY = 86400000;
  const MILLISECONDS_IN_WEEK = 604800000;
  $('.collapse').collapse();

  let keyValue = {
    'result': 'timeRange'
  };
  let jsonString = 'data=' + JSON.stringify(keyValue);
  let minTime = null;
  let maxTime = null;
  ajaxPost(FILE_GET_TIME_RANGE, jsonString, function(response) {
    if ('response' in response) {
      let jsonDecoded = JSON.parse(response['response']);
      if ('timeRange' in jsonDecoded) {
        let timeRange = jsonDecoded['timeRange'];
        let maxIndexTimeArray = timeRange.length - 1;
        minTime = new Date(timeRange[0]);
        maxTime = new Date(timeRange[maxIndexTimeArray]);
        let defaultMinTime = maxTime.getTime() - MILLISECONDS_IN_WEEK;
        let defaultMaxTime = new Date(timeRange[maxIndexTimeArray]).getTime();
        $(".slider_range").bootstrapSlider({
          range: true,
          min: new Date(timeRange[0]).getTime(),
          max: new Date(timeRange[maxIndexTimeArray]).getTime(),
          step: MILLISECONDS_IN_DAY,
          value: [defaultMinTime, defaultMaxTime],
          triggerChangeEvent: true,
          tooltip: 'always',
          formatter: function(value) {
            return timeToDM(new Date(parseInt(value[0]))) + ':' + timeToDM(new Date(parseInt(value[1])));
          }
        });
      }
    }
  });

  [].forEach.call(document.getElementsByClassName('panel'), function(item) {
    new DomainDashboardSettings(item);
  });
  buildChart();
})();

function timeToDM(date) {
  return date.getDate() + '.' + parseInt(date.getMonth() + 1);
}