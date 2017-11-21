const doneState = 4;

let ajaxPost = function(path, param, callbackFunction) {
  let xhr = new XMLHttpRequest();
  xhr.open('POST', path, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(param);
  xhr.onreadystatechange = function() {
    if (xhr.readyState == doneState) {
      if (xhr.responseText) {
        if (callbackFunction) {
          callbackFunction(xhr);
        }
      }
    }
  }
};