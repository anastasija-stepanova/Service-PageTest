(function() {
  $('.collapse').collapse();

  [].forEach.call(document.getElementsByClassName('panel'), function(item) {
    new DomainDashboardSettings(item);
  });
  buildChart();
})();