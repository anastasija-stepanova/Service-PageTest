class DomainDashboardSettings {
  constructor(item) {
    let showButton = item.getElementsByClassName('save_options_button')[0];
    let domainId = item.getElementsByClassName('domain')[0].getAttribute('data-value');
    let locationId = null;
    let typeView = null;
    let minTime = null;
    let maxTime = null;
    let selectedLocation = null;
    showButton.addEventListener('click', function() {
      [].forEach.call(item.getElementsByClassName('form-control'), function(item) {
        selectedLocation = item.value;
      });

      [].forEach.call(item.getElementsByClassName('location'), function(item) {
        if (item.value == selectedLocation) {
          locationId = item.getAttribute('data-value');
          return false;
        }
      });

      [].forEach.call(item.getElementsByClassName('view'), function(item) {
        if (item.checked) {
          typeView = item.getAttribute('data-value');
          return false;
        }
      });

      [].forEach.call(item.getElementsByClassName('min-slider-handle'), function(item) {
          minTime = item.getAttribute('aria-valuenow') / 1000;
          return false;
      });

      [].forEach.call(item.getElementsByClassName('max-slider-handle'), function(item) {
          maxTime = item.getAttribute('aria-valuenow') / 1000;
          return false;
      });

      new ChartsBuilder(domainId, locationId, typeView, minTime, maxTime);
          $('#modalSettingDashboard').modal('hide');

    });
  }
}