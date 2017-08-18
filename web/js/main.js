(function() {
  let domain = '';
  let location = '';
  let settings = document.getElementsByClassName('settings')[0];
  settings.addEventListener('click', function(event) {
    let listDomains = document.getElementsByClassName('list_domains_block');
    for (let i = 0; i < listDomains.length; i++) {
      listDomains[i].addEventListener('click', function() {
        let itemsList = listDomains[i].getElementsByClassName('radio');
        for (let i = 0; i < itemsList.length; i++) {
          itemsList[i].addEventListener('change', function(event) {
            let element = event.target.value;
            domain = {
              'domain': element
            };
          })
        }
      })
    }

    let listLocations = document.getElementsByClassName('list_locations_block');
    for (let i = 0; i < listLocations.length; i++) {
      listLocations[i].addEventListener('click', function() {
        let itemsList = listLocations[i].getElementsByClassName('radio');
        for (let i = 0; i < itemsList.length; i++) {
          itemsList[i].addEventListener('change', function(event) {
            let element = event.target.value;
            location = {
              'location': element
            };
          })
        }
      })
    }
  });

  let keyValue = {
    domain,
    location
  };

  let jsonString = 'data=' + JSON.stringify(keyValue);
  ajaxPost(FILE_GET_DATA_FOR_CHART, jsonString, function(response) {
    console.log(response);
  })
})();