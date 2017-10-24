class SettingsPanelModel {
  deleteUrls(domain, urls) {
    let keyValue = {
      'domain': domain,
      'urls': urls
    };

    let postParam = 'deletableUrls=' + JSON.stringify(keyValue);
    ajaxPost(FILE_EDIT_USER_DOMAIN_URL, postParam, function(response) {
      return response.responseText;
    })
  }

  saveUrl(domain, url) {
    let keyValue = {
      'domain': domain,
      'url': url
    };

    let postParam = 'preservedUrl=' + JSON.stringify(keyValue);
    ajaxPost(FILE_EDIT_USER_DOMAIN_URL, postParam, function(response) {
      return response.responseText;
    });
  }

  editLocations(domain, checkedLocations) {
    let keyValue = {
      'domain': domain,
      'locationIds': checkedLocations
    };

    let postParam = 'locations=' + JSON.stringify(keyValue);
    ajaxPost(FILE_EDIT_USER_LOCATIONS, postParam, function(response) {
      return response.responseText;
    });
  }

  saveDomain(domain) {
    let keyValue = {
      'value': domain
    };

    let postParam = 'domain=' + JSON.stringify(keyValue);
    ajaxPost(FILE_EDIT_USER_DOMAIN, postParam, function(response) {
      return response.responseText;
    });
  }

  deleteSettings(domain, idLocations, urls) {
    let keyValue = {
      'domain': domain,
      'locationIds': idLocations,
      'urls': urls
    };

    let postParam = 'deletableSettings=' + JSON.stringify(keyValue);
    ajaxPost(FILE_DELETE_SETTINGS_BLOCK, postParam, function(response) {
      return response.responseText;
    });
  }

  editDomain(currentDomain, newDomain){
    let keyValue = {
      'currentDomain': currentDomain,
      'newDomain': newDomain
    };

    let postParam = 'editableDomain=' + JSON.stringify(keyValue);
    ajaxPost(FILE_EDIT_USER_DOMAIN, postParam, function(response) {
      return response.responseText;
    });
  }
}