class SettingsPanelModel {
  constructor(){
    this.domainName = null;
    this.urls = [];
    this.urlName = null;
    this.checkedLocations = [];
    this.idLocations = [];
    this.newDomainName = null;
    this.statusCode = null;
    this.event = new CustomEvent('hasAnswer');
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
    ajaxPost(FILE_EDIT_USER_DOMAIN_URL, requestParam, SettingsPanelModel.getResponseStatus.bind(this))
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
    ajaxPost(FILE_EDIT_USER_DOMAIN_URL, requestParam, SettingsPanelModel.getResponseStatus.bind(this));
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
    ajaxPost(FILE_EDIT_USER_LOCATIONS, requestParam, SettingsPanelModel.getResponseStatus.bind(this));
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
    ajaxPost(FILE_EDIT_USER_DOMAIN, requestParam, SettingsPanelModel.getResponseStatus.bind(this));
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
    ajaxPost(FILE_DELETE_SETTINGS_BLOCK, requestParam, SettingsPanelModel.getResponseStatus.bind(this));
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
    ajaxPost(FILE_EDIT_USER_DOMAIN, requestParam, SettingsPanelModel.getResponseStatus.bind(this));
  }

  /**
   * @private
   */
  static getResponseStatus(response) {
    if ('response' in response) {
      switch (parseInt(response.response)) {
        case INVALID_URL:
          this.statusCode = INVALID_URL;
          document.dispatchEvent(this.event);
          break;
        case SUCCESS_STATUS:
          this.statusCode = SUCCESS_STATUS;
          document.dispatchEvent(this.event);
          break;
        case INVALID_DOMAIN:
          this.statusCode = INVALID_DOMAIN;
          document.dispatchEvent(this.event);
          break;
        case JSON_ERROR:
          this.statusCode = JSON_ERROR;
          document.dispatchEvent(this.event);
          break;
        case URL_EXISTS:
          this.statusCode = URL_EXISTS;
          document.dispatchEvent(this.event);
          break;
      }
    }
  }
}