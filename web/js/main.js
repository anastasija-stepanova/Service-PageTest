(function() {
  let saveUrlButton = document.getElementById('saveUrl');
  if (saveUrlButton)
  {
    saveUrl(saveUrlButton);
  }

  let saveLocationButton = document.getElementById('saveLocation');
  if (saveLocationButton)
  {
    saveLocations(saveLocationButton);
  }

  let buildChartButton = document.getElementById('buildChart');
  if (buildChartButton)
  {
    buildChart(buildChartButton);
  }
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

function buildChart(buildChartButton) {
  buildChartButton.addEventListener('click', function(event) {
    event.preventDefault();
    let keyValue = {
      'result': 'ttfb'
    };
    let jsonString = 'data=' + JSON.stringify(keyValue);
    ajaxPost(FILE_GET_DATA_FROM_DB, jsonString, function(response) {
      if ('response' in response)
      {
        let jsonDecode = JSON.parse(response['response']);
        let ttfb = jsonDecode['ttfb'];
        let time = jsonDecode['time'];
        let data = {
          labels: [],
          series: [ttfb
            ]
        };

        new Chartist.Line('.ct-chart', data);
      }
    });
  });
}