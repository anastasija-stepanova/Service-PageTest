(function() {
  function initializeSettingsPanel(item) {
    let settingsPanelModel = new SettingsPanelModel();
    let settingsPanelView = new SettingsPanelView(settingsPanelModel, item);
    new SettingsPanelController(settingsPanelModel, settingsPanelView, item);
  }
  let settingsBlock = document.getElementsByClassName('settings_block');

  [].forEach.call(settingsBlock, function(item) {
    initializeSettingsPanel(item);
  });

  let addNewSettingsBlockButton = document.getElementById('addNewSettings');
  let settingsContainer = document.getElementById('settingsContainer');
  let settingsTemplate = document.getElementById('settingsTemplate');
  addNewSettingsBlockButton.addEventListener('click', function(event) {
    event.preventDefault();
    let settingsCopy = settingsTemplate.cloneNode(true);
    settingsCopy.classList.remove('hidden');
    settingsContainer.append(settingsCopy);
    initializeSettingsPanel(settingsCopy);
  });
})();