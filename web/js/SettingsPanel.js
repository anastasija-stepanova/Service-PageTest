class SettingsPanel {
  constructor(item) {
    this.container = item;
    let domainExists = this.container.getElementsByClassName('domain_container')[0].innerHTML.trim();

    if (domainExists) {
      this.hideAdditionBlock('domain_addition_block');
    } else {
      this.showAdditionBlock('domain_addition_block');
      this.initializeSaveDomainButton();
    }

    let _this = this;

    let addNewLocationButton = this.container.getElementsByClassName('add_new_location')[0];
    addNewLocationButton.addEventListener('click', function(event) {
      event.preventDefault();
      _this.container.getElementsByClassName('available_locations_block')[0].classList.remove('hidden');
    });

    let saveLocationButton = this.container.getElementsByClassName('save_location_button')[0];
    let availableLocations = this.container.getElementsByClassName('available_locations')[0];
    let checkedArray = this.formDataArray(availableLocations);
    saveLocationButton.addEventListener('click', function(event) {
      event.preventDefault();
      _this.saveLocations(_this, checkedArray);
    });

    let addNewUrlButton = this.container.getElementsByClassName('add_new_url')[0];
    addNewUrlButton.addEventListener('click', function(event) {
      event.preventDefault();
      _this.showAdditionBlock('url_addition_block');
      let saveButton = _this.container.getElementsByClassName('save_new_url')[0];
      saveButton.addEventListener('click', function(event) {
        event.preventDefault();
        _this.saveUrl(_this);
        _this.hideAdditionBlock('url_addition_block');
        _this.container.getElementsByClassName('url_addition_input')[0].value = '';
      });
    });
  }

  saveUrl(_this) {
    let domain = _this.container.getElementsByClassName('domain_value')[0].innerHTML;
    let newUrl = _this.container.getElementsByClassName('url_addition_input')[0].value;
    let keyValue = {
      'domain': domain,
      'url': newUrl
    };
    let jsonString = 'data=' + JSON.stringify(keyValue);
    ajaxPost(FILE_SAVE_USER_DOMAIN_URL, jsonString, function(response) {
      let listUrls = document.getElementsByClassName('list_urls')[0];
      let result = document.getElementsByClassName('new_url')[0].innerHTML = response.responseText;
      return listUrls + result;
    });
  }

  saveLocations(_this, checkedArray) {
    let domain = _this.container.getElementsByClassName('domain_value')[0].innerHTML;
    let keyValue = {
      'domain': domain,
      'locations': checkedArray
    };
    let jsonString = 'data=' + JSON.stringify(keyValue);
    ajaxPost(FILE_SAVE_USER_LOCATIONS, jsonString);
  }

  formDataArray(list) {
    let itemsList = list.getElementsByClassName('checkbox');
    let checkedArray = [];

    for (let i = 0; i < itemsList.length; i++) {
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
      })
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
    let newDomain = this.container.getElementsByClassName('domain_addition_input')[0].value;
    let keyValue = {
      'value': newDomain
    };
    let jsonString = 'domain=' + JSON.stringify(keyValue);
    console.log(newDomain);
    ajaxPost(FILE_SAVE_USER_DOMAIN, jsonString, function(response) {
      return this.container.getElementsByClassName('domain_container')[0].innerHTML = response.responseText;
    });
  }

  initializeSaveDomainButton()
  {
    let saveButton = this.container.getElementsByClassName('save_new_domain')[0];
    let _this = this;
    saveButton.addEventListener('click', function(event) {
      event.preventDefault();
      _this.saveDomain();
      _this.hideAdditionBlock('domain_addition_block');
      _this.container.getElementsByClassName('domain_addition_input').value = '';
    });
  }
}