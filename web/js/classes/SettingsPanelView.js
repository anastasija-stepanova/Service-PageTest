class SettingsPanelView {
  constructor(model, item) {
    let thisPtr = this;

    this.responseModal = $('#responseModal');

    this.saveSettings = new Event(this);
    this.deleteSettingsBlock = new Event(this);
    this.editDomain = new Event(this);

    this.deleteUrlsButton = item.getElementsByClassName('delete_url');
    this.addLocationButton = item.getElementsByClassName('add_new_location')[0];
    this.addUrlButton = item.getElementsByClassName('add_new_url')[0];
    this.editSettingsButton = item.getElementsByClassName('edit_settings_button')[0];
    this.blockAvailableLocations = item.getElementsByClassName('available_locations_block')[0];
    this.blockAdditionUrl = item.getElementsByClassName('url_addition_block')[0];
    this.saveSettingButton = item.getElementsByClassName('save_settings_button')[0];
    this.deleteSettingsBlock = item.getElementsByClassName('delete_settings')[0];
    this.currentDomain = item.getElementsByClassName('domain_value')[0];

    model.domainName = item.getElementsByClassName('domain_value')[0].getAttribute('data-domain-value');
    model.checkedLocations = this.formCheckedLocationsArray(item.getElementsByClassName('available_locations')[0]);

    this.editSettingsButton.addEventListener('click', function() {
      SettingsPanelView.initializeEditSettingButton(thisPtr.editSettingsButton, thisPtr.deleteUrlsButton, thisPtr.addLocationButton, thisPtr.addUrlButton);
    });

    this.addLocationButton.addEventListener('click', function() {
      thisPtr.blockAvailableLocations.classList.remove('hidden');
    });

    this.addUrlButton.addEventListener('click', function() {
      thisPtr.blockAdditionUrl.classList.remove('hidden')
    });

    this.saveSettingButton.addEventListener('click', function () {
      thisPtr.saveSettings();
    });

    this.deleteSettingsBlock.addEventListener('click', function() {
      thisPtr.deleteSettingsBlock();
    });

   this.currentDomain.addEventListener('blur', function() {
      thisPtr.editDomain();
    });
  }

  /**
   * @public
   */
   printResponse(statusCode) {
    switch (statusCode) {
      case INVALID_URL:
        this.responseModal.modal('show');
        document.getElementsByClassName('modal-content')[0].innerHTML = 'Невалидный URL';
        break;
      case SUCCESS_STATUS:
        this.responseModal.modal('show');
        document.getElementsByClassName('modal-content')[0].innerHTML = 'Настройки успешно изменены!';
        break;
      case INVALID_DOMAIN:
        this.responseModal.modal('show');
        document.getElementsByClassName('modal-content')[0].innerHTML = 'Невалидный домен!';
        break;
      case JSON_ERROR:
        this.responseModal.modal('show');
        document.getElementsByClassName('modal-content')[0].innerHTML = 'Ошибка JSON!';
        break;
      case URL_EXISTS:
        this.responseModal.modal('show');
        document.getElementsByClassName('modal-content')[0].innerHTML = 'Такой URL уже существует!';
        break;
    }
  }

  /**
   * @private
   */
  static initializeEditSettingButton(editSettingsButton, deleteUrlsButton, addLocationButton, addUrlButton) {
    editSettingsButton.classList.add('hidden');

    [].forEach.call(deleteUrlsButton, function(item) {
      item.classList.remove('hidden');
    });
    addLocationButton.classList.remove('hidden');
    addUrlButton.classList.remove('hidden');
  }

  /**
   * @private
   */
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
}