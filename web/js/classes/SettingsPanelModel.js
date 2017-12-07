class SettingsPanelModel {
  constructor(){
    this.domainName = null;
    this.urls = [];
    this.urlName = null;
    this.checkedLocations = [];
    this.idLocations = [];
    this.newDomainName = null;
  }

  /**
   * @public
   */
  deleteUrls(domainName, urls) {
    this.domainName = domainName;
    this.urls = urls;
    let keyValue = {
      'domain': this.domainName,
      'urls': this.urls
    };

    let requestParam = 'deletableUrls=' + JSON.stringify(keyValue);
    ajaxPost(FILE_EDIT_USER_DOMAIN_URL, requestParam, function(response) {
      return response.responseText;
    })
  }

  /**
   * @public
   */
  saveUrl(domainName, urlName) {
    this.domainName = domainName;
    this.urlName = urlName;
    let keyValue = {
      'domain': this.domainName,
      'url': this.urlName
    };

    let requestParam = 'preservedUrl=' + JSON.stringify(keyValue);
    ajaxPost(FILE_EDIT_USER_DOMAIN_URL, requestParam, function(response) {
      return response.responseText;
    });
  }

  /**
   * @public
   */
  editLocations(domainName, checkedLocations) {
    this.domainName = domainName;
    this.checkedLocations = checkedLocations;
    let keyValue = {
      'domain': this.domainName,
      'locationIds': this.checkedLocations
    };

    let requestParam = 'locations=' + JSON.stringify(keyValue);
    ajaxPost(FILE_EDIT_USER_LOCATIONS, requestParam, function(response) {
      return response.responseText;
    });
  }

  /**
   * @public
   */
  saveDomain(domainName) {
    this.domainName = domainName;
    let keyValue = {
      'value': this.domainName
    };

    let requestParam = 'domain=' + JSON.stringify(keyValue);
    ajaxPost(FILE_EDIT_USER_DOMAIN, requestParam, function(response) {
      return response.responseText;
    });
  }

  /**
   * @public
   */
  deleteSettings(domainName, idLocations, urls) {
    this.domainName = domainName;
    this.idLocations = idLocations;
    this.urls = urls;
    let keyValue = {
      'domain': this.domainName,
      'locationIds': this.idLocations,
      'urls': this.urls
    };

    let requestParam = 'deletableSettings=' + JSON.stringify(keyValue);
    ajaxPost(FILE_DELETE_SETTINGS_BLOCK, requestParam, function(response) {
      return response.responseText;
    });
  }

  /**
   * @public
   */
  editDomain(currentDomain, newDomainName){
    this.domainName = currentDomain;
    this.newDomainName = newDomainName;
    let keyValue = {
      'currentDomain': this.domainName,
      'newDomain': this.newDomainName
    };

    let requestParam = 'editableDomain=' + JSON.stringify(keyValue);
    ajaxPost(FILE_EDIT_USER_DOMAIN, requestParam, function(response) {
      return response.responseText;
    });
  }
}