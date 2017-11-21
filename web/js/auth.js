(function() {
  let sendFormButton = document.getElementById('sendFormButton');
  let authForm = document.getElementById('registrationForm');
  let serverResponse = authForm.getElementsByClassName('server_response')[0];

  sendFormButton.addEventListener('click', function(event) {
    event.preventDefault();

    let formData = new FormData(authForm);
    ajaxPost(FILE_AUTH, getQueryString(formData), function(response) {
      if ('response' in response) {
        switch (parseInt(response['response'])) {
          case SUCCESS_STATUS:
            location.href = 'index.php';
            break;
          case LOGIN_PASSWORD_INCORRECT:
            serverResponse.innerHTML = 'Пароль или логин неверн';
            break;
        }
      }
    })
  });

  [].forEach.call(authForm.getElementsByClassName('form-group'), function(item) {
    let input = item.getElementsByTagName('input')[0];
    input.addEventListener('click', function() {
      if (item.classList.contains('has-error')) {
        item.classList.remove('has-error');
      }
    })
  });
})();

function getQueryString(formData) {
  let pairs = [];
  for (let [key, value] of formData.entries()) {
    pairs.push(encodeURIComponent(key) + '=' + encodeURIComponent(value));
  }
  return pairs.join('&');
}