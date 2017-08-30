(function() {
  $('.collapse').collapse();

  [].forEach.call(document.getElementsByClassName('panel'), function(item) {
    new DomainDashboardSettings(item);
  });
  [].forEach.call(document.getElementsByClassName('dashboard'), function(item) {
    new Dashboard(item);
  });
  buildChart();
})();