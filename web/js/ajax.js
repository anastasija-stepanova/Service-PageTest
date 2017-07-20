const doneState = 4;

let ajaxGet = function(path, param) {
  let xhr = new XMLHttpRequest();
  xhr.open('GET', path + param, true);
  xhr.send();
  xhr.onreadystatechange = function() {
    if (xhr.readyState == doneState) {
      if (xhr.responseText) {
        showResponse(xhr);
      }
    }
  }
};