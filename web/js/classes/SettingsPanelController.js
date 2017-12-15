class SettingsPanelController {
  constructor(model, view, item) {
    let thisPtr = this;

    this.domain = item.getElementsByClassName('domain_value')[0].getAttribute('data-domain-value');
    this.newUrlContainer = item.getElementsByClassName('url_addition_block')[0];
    this.newDomainContainer = item.getElementsByClassName('domain_container')[0];
    this.domainUrlsContainer = item.getElementsByClassName('value_url');
    this.deletableUrls = this.formDeletableUrlsArray(item.getElementsByClassName('delete_url'));
    this.currentDomain = view.currentDomain;
    this.checkedLocations = model.checkedLocations;

    view.saveSettings = function() {
      if (thisPtr.domain == null) {
        thisPtr.domain = SettingsPanelController.getValueNewDomain(item, thisPtr.newDomainContainer);
      }
      model.editLocations(thisPtr.domain, thisPtr.checkedLocations);
      model.saveDomain(SettingsPanelController.getValueNewDomain(item, thisPtr.newDomainContainer));
      model.saveUrl(thisPtr.domain, SettingsPanelController.getValueNewUrl(thisPtr.newUrlContainer));
      model.deleteUrls(thisPtr.domain, thisPtr.deletableUrls);
      document.addEventListener('hasAnswer', function() {
        view.printResponse(model.statusCode);
      });
    };

    view.deleteSettingsBlock = function() {
      model.deleteSettings(thisPtr.domain, thisPtr.checkedLocations, thisPtr.getDomainUrls(thisPtr.domainUrlsContainer));
      document.addEventListener('hasAnswer', function() {
        view.printResponse(model.statusCode);
      });
    };

    view.editDomain = function() {
      model.editDomain(model.domainName, thisPtr.currentDomain.value);
      document.addEventListener('hasAnswer', function() {
        view.printResponse(model.statusCode);
      });
    };
  }

  /**
   * @private
   */
  static getValueNewUrl(newUrlContainer) {
    if (!newUrlContainer.classList.contains('hidden')) {
      return newUrlContainer.getElementsByTagName('input')[0].value;
    }
    return null;
  }

  /**
   * @private
   */
  static getValueNewDomain(item, newDomainContainer) {
    if (!item.classList.contains('hidden') && newDomainContainer.hasChildNodes()) {
      return newDomainContainer.getElementsByTagName('input')[0].value;
    }
    return null;
  }

  /**
   * @private
   */
  getDomainUrls(domainUrlsContainer) {
    let urls = [];
    [].forEach.call(domainUrlsContainer, function(item) {
      urls.push(item.getAttribute('data-url-value'));
    });

    return urls;
  }

  /**
   * @private
   */
  formDeletableUrlsArray(list) {
    let deletableUrls = [];
    [].forEach.call(list, function(item) {
      item.addEventListener('click', function() {
        let listUrls = item.parentNode.parentNode;
        let urlContainer = item.parentNode;
        deletableUrls.push(urlContainer.textContent);
        listUrls.removeChild(urlContainer);
      })
    });

    return deletableUrls;
  }
}