(function() {
  let domainBlocks = document.getElementsByClassName('domain');
  for (let i = 0; i < domainBlocks.length; i++)
  {
    if (domainBlocks[i].innerHTML != '')
    {
      hideAdditionBlock('block_addition_domain')
    } else
    {
      showAdditionBlock('block_addition_domain');
      let saveButton = document.getElementsByClassName('save_new_domain');
      saveButton.addEventListener('click', function(event) {
        event.preventDefault();
        saveDomain();
        hideAdditionBlock('block_addition_domain');
        document.getElementsByClassName('input_addition_domain').value = '';
      });
    }
  }

  let saveLocationButton = document.getElementById('saveLocation');
  let listLocations = document.getElementById('listLocations');
  saveLocationButton.addEventListener('click', function(event) {
    event.preventDefault();
    saveLocations(listLocations);
  });

  let addNewUrlButton = document.getElementsByClassName('add_new_url');
  for (let i = 0; i < addNewUrlButton.length; i++)
  {
    addNewUrlButton[i].addEventListener('click', function(event) {
      event.preventDefault();
      showAdditionBlock('block_addition_url');
      let saveButton = document.getElementsByClassName('save_new_url');
      saveButton.addEventListener('click', function(event) {
        event.preventDefault();
        saveUrl();
        hideAdditionBlock('blockAdditionUrl');
        document.getElementsByClassName('input_addition_url').value = '';
      });
    });
  }

  let addNewSettingsBlockButton = document.getElementById('addNewSettings');
  addNewSettingsBlockButton.addEventListener('click', function(event) {
    event.preventDefault();
    showAdditionBlock('block_settings');
  })
})();

function saveUrl() {
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

function saveLocations(listLocations) {
    let checkedArray = formDataArray(listLocations);
    let keyValue = {
      'value': checkedArray
    };
    let jsonString = 'locations=' + JSON.stringify(keyValue);
    ajaxPost(FILE_SAVE_USER_LOCATIONS, jsonString);
}

function formDataArray(list) {
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

function showAdditionBlock(classBlock) {
  for (let i = 0; i < document.getElementsByClassName(classBlock).length; i++)
  {
    document.getElementsByClassName(classBlock)[i].classList.remove('hidden');
  }
}

function hideAdditionBlock(classBlock) {
  for (let i = 0; i < document.getElementsByClassName(classBlock).length; i++)
  {
    document.getElementsByClassName(classBlock)[i].classList.add('hidden');
  }
}

function saveDomain() {
  let newDomain = document.getElementsByClassName('input_addition_domain').value;
  let keyValue = {
    'value': newDomain
  };
  let jsonString = 'domain=' + JSON.stringify(keyValue);
  ajaxPost(FILE_SAVE_USER_DOMAIN, jsonString, function(response) {
    let listDomains = document.getElementById('domain');
    let result = document.getElementById('newDomain').innerHTML = response.responseText;
    return listDomains + result;
  });
}