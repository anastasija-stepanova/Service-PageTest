(function() {
  let sendFormButton = document.getElementById('sendFormButton');
  let registrationForm = document.getElementById('registrationForm');
  let commonServerResponse = registrationForm.getElementsByClassName('server_response')[0];
  let serverResponseLogin = registrationForm.getElementsByClassName('server_response_login')[0];
  let serverResponseApiKey = registrationForm.getElementsByClassName('server_response_api_key')[0];
  let serverResponsePassword = registrationForm.getElementsByClassName('server_response_password')[0];
  let serverResponsePasswordChecked = registrationForm.getElementsByClassName('server_response_password_checked')[0];

  sendFormButton.addEventListener('click', function(event) {
    event.preventDefault();

    checkLogin(registrationForm, commonServerResponse, serverResponseLogin, serverResponsePassword, serverResponsePasswordChecked, serverResponseApiKey);
    checkPasswords(registrationForm, commonServerResponse, serverResponseLogin, serverResponsePassword, serverResponsePasswordChecked, serverResponseApiKey);
    checkPassword(registrationForm, commonServerResponse, serverResponseLogin, serverResponsePassword, serverResponsePasswordChecked, serverResponseApiKey);
    checkApiKey(registrationForm, commonServerResponse, serverResponseLogin, serverResponsePassword, serverResponsePasswordChecked, serverResponseApiKey);

    let formData = new FormData(registrationForm);
    ajaxPost(FILE_REGISTRATION, getQueryString(formData), function(response) {
      if ('response' in response) {
        switch (parseInt(response['response'])) {
          case SUCCESS_STATUS:
            commonServerResponse.innerHTML = 'Вы успешно зарегистрированы. <a href="auth.php" title="Авторизоваться">Авторизоваться</a>';
            serverResponseLogin.innerHTML = '';
            serverResponsePassword.innerHTML = '';
            serverResponsePasswordChecked.innerHTML = '';
            serverResponseApiKey.innerHTML = '';
            break;
          case REGISTRATION_ERROR:
            commonServerResponse.innerHTML = 'Ошибка регистрации. Попробуйте позже.';
            serverResponseLogin.innerHTML = '';
            serverResponsePassword.innerHTML = '';
            serverResponsePasswordChecked.innerHTML = '';
            serverResponseApiKey.innerHTML = '';
            break;
          case USER_EXISTS:
            serverResponseLogin.innerHTML = 'Пользователь с таким логин уже существует.';
            commonServerResponse.innerHTML = '';
            serverResponsePassword.innerHTML = '';
            serverResponsePasswordChecked.innerHTML = '';
            serverResponseApiKey.innerHTML = '';
            break;
          case PASSWORDS_NOT_MATCH:
            serverResponsePasswordChecked.innerHTML = 'Пароли не совпадают.';
            serverResponseLogin.innerHTML = '';
            serverResponsePassword.innerHTML = '';
            commonServerResponse.innerHTML = '';
            serverResponseApiKey.innerHTML = '';
            break;
          case API_KEY_EXISTS:
            serverResponseApiKey.innerHTML = 'API key уже занят.';
            serverResponseLogin.innerHTML = '';
            serverResponsePassword.innerHTML = '';
            serverResponsePasswordChecked.innerHTML = '';
            commonServerResponse.innerHTML = '';
            break;
          case INVALID_LOGIN:
            serverResponseLogin.inneHTML = 'Невалидный логин.';
            commonServerResponse.innerHTML = '';
            serverResponsePassword.innerHTML = '';
            serverResponsePasswordChecked.innerHTML = '';
            serverResponseApiKey.innerHTML = '';
            break;
          case INVALID_PASSWORD:
            serverResponsePassword.innerHTML = 'Невалидный пароль.';
            serverResponseLogin.innerHTML = '';
            commonServerResponse.innerHTML = '';
            serverResponsePasswordChecked.innerHTML = '';
            serverResponseApiKey.innerHTML = '';
            break;
          case INVALID_API_KEY:
            serverResponseApiKey.innerHTML = 'Невалидный API key.';
            serverResponseLogin.innerHTML = '';
            serverResponsePassword.innerHTML = '';
            serverResponsePasswordChecked.innerHTML = '';
            commonServerResponse.innerHTML = '';
            break;
        }
      }
    })
  });

  [].forEach.call(registrationForm.getElementsByClassName('form-group'), function(item) {
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

function checkLogin(registrationForm, commonServerResponse, serverResponseLogin, serverResponsePassword, serverResponsePasswordChecked, serverResponseApiKey) {
  let userName = registrationForm.getElementsByClassName('login')[0];
  if (userName.value.length < userName.getAttribute('data-min')) {
    serverResponseLogin.innerHTML = 'Длина логина должна быть более ' + userName.getAttribute('data-min') + ' символов.';
    commonServerResponse.innerHTML = '';
    serverResponsePassword.innerHTML = '';
    serverResponsePasswordChecked.innerHTML = '';
    serverResponseApiKey.innerHTML = '';
    let formGroup = userName.closest('.form-group');
    formGroup.classList.add('has-error');
  }
}

function checkPasswords(registrationForm, commonServerResponse, serverResponseLogin, serverResponsePassword, serverResponsePasswordChecked, serverResponseApiKey) {
  let password = registrationForm.getElementsByClassName('password')[0];
  let passwordChecked = registrationForm.getElementsByClassName('password_checked')[0];
  if (password.value != passwordChecked.value) {
    serverResponsePasswordChecked.innerHTML = 'Пароли не совпадают, повторите ввод.';
    serverResponseLogin.innerHTML = '';
    serverResponsePassword.innerHTML = '';
    commonServerResponse.innerHTML = '';
    serverResponseApiKey.innerHTML = '';
    let formGroupPassword = password.closest('.form-group');
    formGroupPassword.classList.add('has-error');
    let formGroupPasswordChecked = password.closest('.form-group');
    formGroupPasswordChecked.classList.add('has-error');
  }
}

function checkPassword(registrationForm, commonServerResponse, serverResponseLogin, serverResponsePassword, serverResponsePasswordChecked, serverResponseApiKey) {
  let password = registrationForm.getElementsByClassName('password')[0];
  if (password.value.length < password.getAttribute('data-min')) {
    serverResponsePassword.innerHTML = 'Длина пароля должна быть более ' + password.getAttribute('data-min') + ' символов';
    serverResponseLogin.innerHTML = '';
    commonServerResponse.innerHTML = '';
    serverResponsePasswordChecked.innerHTML = '';
    serverResponseApiKey.innerHTML = '';
    let formGroup = password.closest('.form-group');
    formGroup.classList.add('has-error');
  }
}

function checkApiKey(registrationForm, commonServerResponse, serverResponseLogin, serverResponsePassword, serverResponsePasswordChecked, serverResponseApiKey) {
  let apiKey = registrationForm.getElementsByClassName('api_key')[0];
  if (apiKey.value.length == '') {
    serverResponseApiKey.innerHTML = 'Введите API key';
    serverResponseLogin.innerHTML = '';
    serverResponsePassword.innerHTML = '';
    serverResponsePasswordChecked.innerHTML = '';
    commonServerResponse.innerHTML = '';
    let formGroup = apiKey.closest('.form-group');
    formGroup.classList.add('has-error');
  }
}