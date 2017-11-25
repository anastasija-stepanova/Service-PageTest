class RegistrationFormView {
  constructor(model) {
    this.sendFormButton = document.getElementById('sendFormButton');
    this.registrationForm = document.getElementById('registrationForm');
    this.commonServerResponse = this.registrationForm.getElementsByClassName('server_response')[0];
    this.serverResponseLogin = this.registrationForm.getElementsByClassName('server_response_login')[0];
    this.serverResponseApiKey = this.registrationForm.getElementsByClassName('server_response_api_key')[0];
    this.serverResponsePassword = this.registrationForm.getElementsByClassName('server_response_password')[0];
    this.serverResponsePasswordChecked = this.registrationForm.getElementsByClassName('server_response_password_checked')[0];
    this.userLogin = this.registrationForm.getElementsByClassName('login')[0];
    this.password = this.registrationForm.getElementsByClassName('password')[0];
    this.passwordChecked = this.registrationForm.getElementsByClassName('password_checked')[0];
    this.apiKey = this.registrationForm.getElementsByClassName('api_key')[0];
    this.initializeSendFormButton(model);
  }

  /**
   * @private
   */
  initializeSendFormButton(model) {
    let thisPtr = this;
    this.sendFormButton.addEventListener('click', function(event) {
      event.preventDefault();
      thisPtr.checkUserLogin();
      thisPtr.checkMatchPasswords();
      thisPtr.checkPassword();
      thisPtr.checkApiKey();
      thisPtr.removeErrorClass();
      let formData = new FormData(thisPtr.registrationForm);
      model.sendRequest(formData);
      thisPtr.printResponse(model.statusCode);
    });
  }

  /**
   * @private
   */
  printResponse(statusCode) {
    let thisPtr = this;
    switch (statusCode) {
      case SUCCESS_STATUS:
        thisPtr.commonServerResponse.innerHTML = 'Вы успешно зарегистрированы. <a href="auth.php" title="Авторизоваться">Авторизоваться</a>';
        break;
      case REGISTRATION_ERROR:
        thisPtr.commonServerResponse.innerHTML = 'Ошибка регистрации. Попробуйте позже.';
        break;
      case USER_EXISTS:
        thisPtr.serverResponseLogin.innerHTML = 'Пользователь с таким логин уже существует.';
        thisPtr.constructor.addElementClassError(thisPtr.userLogin);
        break;
      case PASSWORDS_NOT_MATCH:
        thisPtr.serverResponsePasswordChecked.innerHTML = 'Пароли не совпадают.';
        thisPtr.constructor.addElementClassError(thisPtr.password);
        thisPtr.constructor.addElementClassError(thisPtr.passwordChecked);
        break;
      case API_KEY_EXISTS:
        thisPtr.serverResponseApiKey.innerHTML = 'API key уже занят.';
        thisPtr.constructor.addElementClassError(thisPtr.apiKey);
        break;
      case INVALID_LOGIN:
        thisPtr.serverResponseLogin.innerHTML = 'Невалидный логин.';
        thisPtr.constructor.addElementClassError(thisPtr.userLogin);
        break;
      case INVALID_PASSWORD:
        thisPtr.serverResponsePassword.innerHTML = 'Невалидный пароль.';
        thisPtr.constructor.addElementClassError(thisPtr.password);
        break;
      case INVALID_API_KEY:
        thisPtr.serverResponseApiKey.innerHTML = 'Невалидный API key.';
        thisPtr.constructor.addElementClassError(thisPtr.apiKey);
        break;
    }
  }

  /**
   * @private
   */
  checkUserLogin() {
    let thisPtr = this;
    let minLengthLogin = this.userLogin.getAttribute('data-min');
    if (this.userLogin.value.length < minLengthLogin) {
      thisPtr.serverResponseLogin.innerHTML = 'Длина логина должна быть более ' + minLengthLogin + ' символов.';
      thisPtr.constructor.addElementClassError(this.userLogin);
      thisPtr.validationError = true;
    }
  }

  /**
   * @private
   */
  checkMatchPasswords() {
    let thisPtr = this;
    if (this.password.value != this.passwordChecked.value) {
      thisPtr.serverResponsePasswordChecked.innerHTML = 'Пароли не совпадают, повторите ввод.';
      thisPtr.constructor.addElementClassError(this.password);
      thisPtr.constructor.addElementClassError(this.passwordChecked);
      thisPtr.validationError = true;
    }
  }

  /**
   * @private
   */
  checkPassword() {
    let thisPtr = this;
    let minLengthPassword = this.password.getAttribute('data-min');
    if (this.password.value.length < minLengthPassword) {
      thisPtr.serverResponsePassword.innerHTML = 'Длина пароля должна быть более ' + minLengthPassword + ' символов';
      thisPtr.constructor.addElementClassError(this.password);
      thisPtr.validationError = true;
    }
  }

  /**
   * @private
   */
  checkApiKey() {
    let thisPtr = this;
    if (this.apiKey.value.length == '') {
      thisPtr.serverResponseApiKey.innerHTML = 'Введите API key';
      thisPtr.constructor.addElementClassError(this.apiKey);
      thisPtr.validationError = true;
    }
  }

  /**
   * @private
   */
  removeErrorClass() {
    [].forEach.call(this.registrationForm.getElementsByClassName('form-group'), function(item) {
      let input = item.getElementsByTagName('input')[0];
      input.addEventListener('focus', function() {
        if (item.classList.contains('has-error')) {
          item.classList.remove('has-error');
          item.getElementsByClassName('error_message_container')[0].innerHTML = '';
        }
      })
    });
  }

  /**
   * @private
   */
  static addElementClassError(element) {
    let formGroup = element.closest('.form-group');
    formGroup.classList.add('has-error');
  }
}