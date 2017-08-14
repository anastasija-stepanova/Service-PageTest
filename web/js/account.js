let dashboardClass = 'dashboard';

let dashboard = document.getElementsByClassName(dashboardClass);

class Dashboard {
  constructor(item) {
    this.container = item;
    let domainExists = this.container.getElementsByClassName('domain_container')[0].innerHTML.trim();
    if (domainExists) {
      this.hideAdditionBlock('block_addition_domain')
    } else {
      this.showAdditionBlock('block_addition_domain');
      let saveButton = this.container.getElementsByClassName('save_new_domain')[0];
      let _this = this;
      saveButton.addEventListener('click', function(event) {
        event.preventDefault();
        _this.saveDomain();
        _this.hideAdditionBlock('block_addition_domain');
        _this.container.getElementsByClassName('input_addition_domain').value = '';
      });
    }

    let saveLocationButton = this.container.getElementsByClassName('save_location_button')[0];
    let listLocations = this.container.getElementsByClassName('list_locations')[0];
    saveLocationButton.addEventListener('click', function(event) {
      event.preventDefault();
      this.saveLocations(listLocations);
    });

    let addNewUrlButton = this.container.getElementsByClassName('add_new_url');
    let _this = this;
    for (let i = 0; i < addNewUrlButton.length; i++) {
      addNewUrlButton[i].addEventListener('click', function(event) {
        event.preventDefault();
        _this.showAdditionBlock('block_addition_url');
        let saveButton = _this.container.getElementsByClassName('save_new_url')[0];
        saveButton.addEventListener('click', function(event) {
          event.preventDefault();
          _this.saveUrl();
          _this.hideAdditionBlock('blockAdditionUrl');
          _this.container.getElementsByClassName('input_addition_url').value = '';
        });
      });
    }
  }

  saveUrl() {
    let newUrl = document.getElementsByClassName('input_addition_url').value;
    let keyValue = {
      'value': newUrl
    };
    let jsonString = 'url=' + JSON.stringify(keyValue);
    ajaxPost(FILE_SAVE_USER_DOMAIN_URL, jsonString, function(response) {
      let listUrls = document.getElementById('listUrls');
      let result = document.getElementById('newUrl').innerHTML = response.responseText;
      return listUrls + result;
    });
  }

  saveLocations(listLocations) {
    let checkedArray = this.formDataArray(listLocations);
    let keyValue = {
      'value': checkedArray
    };
    let jsonString = 'locations=' + JSON.stringify(keyValue);
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
    let newDomain = this.container.getElementsByClassName('input_addition_domain').value;
    let keyValue = {
      'value': newDomain
    };
    let jsonString = 'domain=' + JSON.stringify(keyValue);
    ajaxPost(FILE_SAVE_USER_DOMAIN, jsonString, function(response) {
      return this.container.getElementsByClassName('domain_container')[0].innerHTML = response.responseText;
    });
  }

}

[].forEach.call(dashboard, function(item) {
  new Dashboard(item);
});

let addNewSettingsBlockButton = document.getElementById('addNewSettings');
let dashboardContainer = document.getElementById('dashboardContainer');
let dashboardTemplate = document.getElementById('dashboardTemplate');
addNewSettingsBlockButton.addEventListener('click', function(event) {
  event.preventDefault();
  let dashboardCopy = dashboardTemplate.cloneNode(true);
  dashboardCopy.classList.remove('hidden');
  dashboardContainer.append(dashboardCopy);
  new Dashboard(dashboardCopy);
});