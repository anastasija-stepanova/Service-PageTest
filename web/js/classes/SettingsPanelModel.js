class SettingsPanelModel {
  constructor(){
    this.domainName = null;
    this.urls = [];
    this.urlName = null;
    this.checkedLocations = [];
    this.idLocations = [];
    this.newDomainName = null;
  }
  deleteUrls(domainName, urls) {
    this.domainName = domainName;
    this.urls = urls;
    let keyValue = {
      'domain': this.domainName,
      'urls': this.urls
    };

    let postParam = 'deletableUrls=' + JSON.stringify(keyValue);
    ajaxPost(FILE_EDIT_USER_DOMAIN_URL, postParam, function(response) {
      return response.responseText;
    })
  }

  saveUrl(domainName, urlName) {
    this.domainName = domainName;
    this.urlName = urlName;
    let keyValue = {
      'domain': this.domainName,
      'url': this.urlName
    };

    let postParam = 'preservedUrl=' + JSON.stringify(keyValue);
    ajaxPost(FILE_EDIT_USER_DOMAIN_URL, postParam, function(response) {
      return response.responseText;
    });
  }

  editLocations(domainName, checkedLocations) {
    this.domainName = domainName;
    this.checkedLocations = checkedLocations;
    let keyValue = {
      'domain': this.domainName,
      'locationIds': this.checkedLocations
    };

    let postParam = 'locations=' + JSON.stringify(keyValue);
    ajaxPost(FILE_EDIT_USER_LOCATIONS, postParam, function(response) {
      return response.responseText;
    });
  }

  saveDomain(domainName) {
    this.domainName = domainName;
    let keyValue = {
      'value': this.domainName
    };

    let postParam = 'domain=' + JSON.stringify(keyValue);
    ajaxPost(FILE_EDIT_USER_DOMAIN, postParam, function(response) {
      return response.responseText;
    });
  }

  deleteSettings(domainName, idLocations, urls) {
    this.domainName = domainName;
    this.idLocations = idLocations;
    this.urls = urls;
    let keyValue = {
      'domain': this.domainName,
      'locationIds': this.idLocations,
      'urls': this.urls
    };

    let postParam = 'deletableSettings=' + JSON.stringify(keyValue);
    ajaxPost(FILE_DELETE_SETTINGS_BLOCK, postParam, function(response) {
      return response.responseText;
    });
  }

  editDomain(currentDomain, newDomainName){
    this.domainName = currentDomain;
    this.newDomainName = newDomainName;
    let keyValue = {
      'currentDomain': this.domainName,
      'newDomain': this.newDomainName
    };

    let postParam = 'editableDomain=' + JSON.stringify(keyValue);
    ajaxPost(FILE_EDIT_USER_DOMAIN, postParam, function(response) {
      return response.responseText;
    });
  }
}