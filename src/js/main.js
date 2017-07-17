(function () {
  saveUrl();
})();

let ajaxGet = function(path, param) {
  let xhr = new XMLHttpRequest();
  xhr.open('GET', path + param, true);
  xhr.send();
  const doneState = 4;
  xhr.onreadystatechange = function() {
    if (xhr.readyState == doneState) {
      if (xhr.responseText) {
        showResponse(xhr);
      }
    }
  }
};

function showResponse(xhr) {
  document.getElementById('result').innerHTML = xhr.responseText;
}

function saveUrl() {
  let saveUrlButton = document.getElementById('saveUrl');
  saveUrlButton.addEventListener('click', function(event) {
    event.preventDefault();
    let inputUrl = document.getElementById('inputUrl');
    let urlParam = '?url=' + inputUrl.value;
    ajaxGet('save_url.php', urlParam);
    inputUrl.value = '';
  })
}