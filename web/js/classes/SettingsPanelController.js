class SettingsPanelController {
  constructor(model, view, item) {
    let thisPtr = this;

    let deleteUrlsButton = view.deleteUrlsButton;
    let addLocationButton = view.addLocationButton;
    let addUrlButton = view.addUrlButton;
    let editSettingsButton = view.editSettingsButton;
    let saveSettingButton = view.saveSettingButton;
    let domain = view.domain;
    let checkedLocations = view.checkedLocations;
    let deletableUrls = view.deletableUrls;
    let newUrlContainer = view.newUrlContainer;
    let newDomainContainer = view.newDomainContainer;
    let deleteSettingsBlock = view.deleteSettingsBlock;
    let domainUrlsContainer = view.domainUrlsContainer;
    let existingDomain = view.existingDomain;

    editSettingsButton.addEventListener('click', function(event) {
      event.preventDefault();
      thisPtr.initializeEditSettingButton(editSettingsButton, deleteUrlsButton, addLocationButton, addUrlButton);
    });

    addLocationButton.addEventListener('click', function(event) {
      event.preventDefault();
      view.blockAvailableLocations.classList.remove('hidden');
    });

    addUrlButton.addEventListener('click', function(event) {
      event.preventDefault();
      view.blockAdditionUrl.classList.remove('hidden')
    });

    saveSettingButton.addEventListener('click', function(event) {
      event.preventDefault();
      model.editLocations(domain, checkedLocations);
      model.saveDomain(thisPtr.getValueNewDomain(item, newDomainContainer));
      model.saveUrl(domain, thisPtr.getValueNewUrl(newUrlContainer));
      model.deleteUrls(domain, deletableUrls);
    });

    deleteSettingsBlock.addEventListener('click', function(event) {
      event.preventDefault();
      model.deleteSettings(domain, checkedLocations, thisPtr.getDomainUrls(domainUrlsContainer));
    });

    let currentDomain = existingDomain.value;
    existingDomain.addEventListener('blur', function() {
      let newDomain = existingDomain.value;
      model.editDomain(currentDomain, newDomain);
    });
  }

  initializeEditSettingButton(editSettingsButton, deleteUrlsButton, addLocationButton, addUrlButton) {
    editSettingsButton.classList.add('hidden');

    [].forEach.call(deleteUrlsButton, function(item) {
      item.classList.remove('hidden');
    });
    addLocationButton.classList.remove('hidden');
    addUrlButton.classList.remove('hidden');
  }

  getValueNewUrl(newUrlContainer) {
    if (!newUrlContainer.classList.contains('hidden')) {
      return newUrlContainer.getElementsByTagName('input')[0].value;
    }
    return null;
  }

  getValueNewDomain(item, newDomainContainer) {
    if (!item.classList.contains('hidden') && newDomainContainer.hasChildNodes()) {
      return newDomainContainer.getElementsByTagName('input')[0].value;
    }
    return null;
  }

  getDomainUrls(domainUrlsContainer) {
    let urls = [];
    [].forEach.call(domainUrlsContainer, function(item) {
      urls.push(item.getAttribute('data-value'));
    });

    return urls;
  }
}