(function() {
  let saveUrlButton = document.getElementById('saveUrl');
  saveUrl(saveUrlButton);

  let saveLocationButton = document.getElementById('saveLocation');
  saveLocations(saveLocationButton);
})();

function saveUrl(saveButton) {
  saveButton.addEventListener('click', function(event) {
    event.preventDefault();
    let inputUrl = document.getElementById('inputUrl');
    let urlParam = 'url=' + inputUrl.value;
    ajaxPost(FILE_SAVE_URL, urlParam, function(response) {
      let listUrls = document.getElementById('listUrls');
      let result = document.getElementById('newUrl').innerHTML = response.responseText;
      return listUrls + result;
    });
    inputUrl.value = '';
  })
}

function saveLocations(saveButton) {
  let listLocations = document.getElementById('listLocations');
  let checkedArray = formDataArray(listLocations);

  saveButton.addEventListener('click', function(event) {
    event.preventDefault();
    let keyValue = {
      'value': checkedArray
    };
    let jsonString = 'locations=' + JSON.stringify(keyValue);
    ajaxPost(FILE_SAVE_USER_LOCATIONS, jsonString);
  })
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