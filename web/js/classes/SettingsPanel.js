class SettingsPanel {
  constructor(item) {
    this.container = item;
    let thisPtr = this;

    let editSettingsPanelButton = this.container.getElementsByClassName('edit_settings_button')[0];
    editSettingsPanelButton.addEventListener('click', function(event) {
      event.preventDefault();
      editSettingsPanelButton.classList.add('hidden');

      [].forEach.call(thisPtr.container.getElementsByClassName('delete_url'), function(item) {
        item.classList.remove('hidden');
      });

      let addNewLocationButton = thisPtr.container.getElementsByClassName('add_new_location')[0];
      addNewLocationButton.classList.remove('hidden');

      let addNewUrlButton = thisPtr.container.getElementsByClassName('add_new_url')[0];
      addNewUrlButton.classList.remove('hidden');

      addNewLocationButton.addEventListener('click', function(event) {
        event.preventDefault();
        thisPtr.container.getElementsByClassName('available_locations_block')[0].classList.remove('hidden');
      });

      addNewUrlButton.addEventListener('click', function(event) {
        event.preventDefault();
        thisPtr.showAdditionBlock('url_addition_block');
      });

      let availableLocations = thisPtr.container.getElementsByClassName('available_locations')[0];
      let checkedArray = thisPtr.formCheckedLocationsArray(availableLocations);

      let saveSettingsButton = thisPtr.container.getElementsByClassName('save_settings_button')[0];
      saveSettingsButton.addEventListener('click', function(event) {
        event.preventDefault();
        thisPtr.saveLocations(thisPtr, checkedArray);
        thisPtr.initializeSaveDomainButton();
        thisPtr.saveUrl(thisPtr);
        thisPtr.removeUrls(thisPtr);
        thisPtr.hideAdditionBlock('url_addition_block');
        thisPtr.container.getElementsByClassName('url_addition_input')[0].value = '';
      })
    });
  }

  initializeSaveDomainButton() {
      this.saveDomain();
      this.hideAdditionBlock('domain_addition_block');
      this.container.getElementsByClassName('domain_addition_input').value = '';
  }

  removeUrls(thisPtr) {
    let domain = thisPtr.container.getElementsByClassName('domain_value')[0].innerHTML;
    let removableUrls = thisPtr.formRemovableUrlsArray(thisPtr);
    let keyValue = {
      'domain': domain,
      'urls': removableUrls
    };
    let jsonString = 'removableUrls=' + JSON.stringify(keyValue);
    ajaxPost(FILE_SAVE_USER_DOMAIN_URL, jsonString, function(response) {
      console.log(response.responseText);
    });
  };

  formRemovableUrlsArray(thisPtr) {
    let removableUrls = [];
    [].forEach.call(thisPtr.container.getElementsByClassName('delete_url'), function(item) {
      item.addEventListener('click', function() {
        let listUrls = item.parentNode.parentNode;
        let urlContainer = item.parentNode;
        removableUrls.push(urlContainer.textContent);
        listUrls.removeChild(urlContainer);
      })
    });
    console.log(removableUrls);
    return removableUrls;
  }

  saveUrl(thisPtr) {
    let domain = thisPtr.container.getElementsByClassName('domain_value')[0].innerHTML;
    let newUrl = thisPtr.container.getElementsByClassName('url_addition_input')[0].value;
    let keyValue = {
      'domain': domain,
      'url': newUrl
    };
    let jsonString = 'preservedUrl=' + JSON.stringify(keyValue);
    ajaxPost(FILE_SAVE_USER_DOMAIN_URL, jsonString, function(response) {
      let listUrls = document.getElementsByClassName('list_urls')[0];
      let result = document.getElementsByClassName('new_url')[0].innerHTML = response.responseText;
      console.log(response.responseText);
      return listUrls + result;
    });
  }

  saveLocations(thisPtr, checkedArray) {
    let domain = thisPtr.container.getElementsByClassName('domain_value')[0].innerHTML;
    let keyValue = {
      'domain': domain,
      'locations': checkedArray
    };
    let jsonString = 'data=' + JSON.stringify(keyValue);
    ajaxPost(FILE_SAVE_USER_LOCATIONS, jsonString, function(response) {
      return response.responseText;
    });
  }

  formCheckedLocationsArray(list) {
    let checkedArray = [];

    let items = list.getElementsByClassName('location_checkbox');
    for (let i = 0; i < items.length; i++) {
      if (items[i].checked) {
        checkedArray.push(items[i].value);
      }
    }

    let itemsList = list.getElementsByClassName('checkbox');

    for (let i = 0; i < itemsList.length; i++) {
      if (itemsList[i].checked) {
        checkedArray.push(itemsList[i].value);
      }

      itemsList[i].addEventListener('change', function(event) {
        let element = event.target;
        let value = element.value;
        if (element.checked) {
          checkedArray.push(value);
        } else {
          let index = checkedArray.indexOf(value);
          if (index > -1) {
            checkedArray.splice(index, 1);
          }
        }
      });
    }

    return checkedArray;
  }

  showAdditionBlock(classBlock) {
    this.container.getElementsByClassName(classBlock)[0].classList.remove('hidden');
  }

  hideAdditionBlock(classBlock) {
    this.container.getElementsByClassName(classBlock)[0].classList.add('hidden');
  }

  saveDomain() {
    let thisPtr = this;
    let newDomain = this.container.getElementsByClassName('domain_addition_input')[0].value;
    let keyValue = {
      'value': newDomain
    };
    let jsonString = 'domain=' + JSON.stringify(keyValue);
    ajaxPost(FILE_SAVE_USER_DOMAIN, jsonString, function(response) {
      return thisPtr.container.getElementsByClassName('domain_container')[0].innerHTML = response.responseText;
    });
  }
}