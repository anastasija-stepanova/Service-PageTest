(function() {
  let saveUrlButton = document.getElementById('saveUrl');
  saveUrl(saveUrlButton);
  let saveLocationButton = document.getElementById('saveLocation');
  saveLocations(saveLocationButton);
})();

function showResponse(xhr) {
  let listUrls = document.getElementById('listUrls');
  let result = document.getElementById('newUrl').innerHTML = xhr.responseText;
  return listUrls + result;
}

function saveUrl(saveButton) {
  saveButton.addEventListener('click', function(event) {
    event.preventDefault();
    let inputUrl = document.getElementById('inputUrl');
    let urlParam = '?url=' + inputUrl.value;
    ajaxGet(FILE_SAVE_URL, urlParam);
    inputUrl.value = '';
  })
}

function saveLocations(saveButton) {
  let listLocations = document.getElementById('listLocations');
  let itemsListLocations = listLocations.getElementsByClassName('checkbox');
  let checkedArray = [];
  for (let i = 0; i < itemsListLocations.length; i++) {
    itemsListLocations[i].addEventListener('change', function(event) {
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

  saveButton.addEventListener('click', function(event) {
    event.preventDefault();
    let keyValue = {
      'value': checkedArray
    };
    let jsonString = '?locations=' + JSON.stringify(keyValue);
    ajaxGet(FILE_SAVE_USER_LOCATIONS, jsonString);
  })
}