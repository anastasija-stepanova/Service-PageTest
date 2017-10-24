class SettingsPanelView {
  constructor(model, item) {
    this.deleteUrlsButton = item.getElementsByClassName('delete_url');
    this.addLocationButton = item.getElementsByClassName('add_new_location')[0];
    this.addUrlButton = item.getElementsByClassName('add_new_url')[0];
    this.editSettingsButton = item.getElementsByClassName('edit_settings_button')[0];
    this.blockAvailableLocations = item.getElementsByClassName('available_locations_block')[0];
    this.blockAdditionUrl = item.getElementsByClassName('url_addition_block')[0];
    this.saveSettingButton = item.getElementsByClassName('save_settings_button')[0];
    this.checkedLocations = this.formCheckedLocationsArray(item.getElementsByClassName('available_locations')[0]);
    this.deletableUrls = this.formDeletableUrlsArray(this.deleteUrlsButton);
    this.domain = item.getElementsByClassName('domain_value')[0].getAttribute('data-value');
    this.newUrlContainer = item.getElementsByClassName('url_addition_block')[0];
    this.newDomainContainer = item.getElementsByClassName('domain_container')[0];
    this.deleteSettingsBlock = item.getElementsByClassName('delete_settings')[0];
    this.domainUrlsContainer = item.getElementsByClassName('value_url');
    this.existingDomain = item.getElementsByClassName('domain_value')[0];
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

  formDeletableUrlsArray(list) {
    let removableUrls = [];
    [].forEach.call(list, function(item) {
      item.addEventListener('click', function() {
        let listUrls = item.parentNode.parentNode;
        let urlContainer = item.parentNode;
        removableUrls.push(urlContainer.textContent);
        listUrls.removeChild(urlContainer);
      })
    });

    return removableUrls;
  }
}