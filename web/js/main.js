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

        $('.panel').each(function() {
          let _this = $(this);
          let sliderRange = _this.find('.slider_range');
          sliderRange.bootstrapSlider({
            range: true,
            min: new Date(timeRange[0]).getTime(),
            max: new Date(timeRange[maxIndexTimeArray]).getTime(),
            step: MILLISECONDS_IN_DAY,
            value: [defaultMinTime, defaultMaxTime],
            triggerChangeEvent: true,
            triggerSlideEvent: true,
            tooltip: 'always',
            formatter: function(value) {
              return timeToDayMonth(new Date(parseInt(value[0]))) + ':' + timeToDayMonth(new Date(parseInt(value[1])));
            }
          }).on('slide', function(item) {
            _this.find('.min_date').text(timeToDayMonth(new Date(item.value[0])) + ' -');
            _this.find('.max_date').text(timeToDayMonth(new Date(item.value[1])));
          });

          let dateRangeValues = sliderRange.val().split(',');
          _this.find('.min_date').text(timeToDayMonth(new Date(parseInt(dateRangeValues[0]))) + '-');
          _this.find('.max_date').text(timeToDayMonth(new Date(parseInt(dateRangeValues[1]))));
        });
      }
    }
  });

  [].forEach.call(document.getElementsByClassName('panel'), function(item) {
    new DomainDashboardSettings(item);
  });
  buildChart();
})();

function timeToDayMonth(date) {
  return date.getDate() + '.' + parseInt(date.getMonth() + 1);
}