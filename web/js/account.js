const SETTINGS_CLASS = 'settings_block';
let settingsBlock = document.getElementsByClassName(SETTINGS_CLASS);

[].forEach.call(settingsBlock, function(item) {
  new SettingsPanel(item);
});

let addNewSettingsBlockButton = document.getElementById('addNewSettings');
let settingsContainer = document.getElementById('settingsContainer');
let settingsTemplate = document.getElementById('settingsTemplate');
addNewSettingsBlockButton.addEventListener('click', function(event) {
  event.preventDefault();
  let settingsCopy = settingsTemplate.cloneNode(true);
  settingsCopy.classList.remove('hidden');
  settingsContainer.append(settingsCopy);
  new SettingsPanel(settingsCopy);
});