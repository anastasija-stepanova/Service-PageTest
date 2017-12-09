class AuthFormView {
  constructor(model) {
    this.sendFormButton = document.getElementById('sendFormButton');
    this.authForm = document.getElementById('authForm');
    this.serverResponse = this.authForm.getElementsByClassName('server_response')[0];
    this.userLogin = this.authForm.getElementsByClassName('login')[0];
    this.password = this.authForm.getElementsByClassName('password')[0];
    this.initializeSendFormButton(model);
  }

  /**
   * @private
   */
  initializeSendFormButton(model) {
    let thisPtr = this;
    this.sendFormButton.addEventListener('click', function(e) {
      e.preventDefault();
      let formData = new FormData(thisPtr.authForm);
      model.sendRequest(formData);
      document.addEventListener('hasAnswer', function() {
        thisPtr.printResponse(model.statusCode);
        thisPtr.removeErrorClass();
      });
    });
  }

  /**
   * @private
   */
  printResponse(statusCode) {
    let thisPtr = this;
    switch (statusCode) {
      case SUCCESS_STATUS:
        location.href = 'index.php';
        break;
      case LOGIN_PASSWORD_INCORRECT:
        thisPtr.serverResponse.innerHTML = 'Пароль или логин неверн';
        AuthFormView.addElementClassError(thisPtr.userLogin);
        AuthFormView.addElementClassError(thisPtr.password);
        break;
    }
  }

  /**
   * @private
   */
  removeErrorClass() {
    [].forEach.call(this.authForm.getElementsByClassName('form-group'), function(item) {
      let input = item.getElementsByTagName('input')[0];
      input.addEventListener('focus', function() {
        if (item.classList.contains('has-error')) {
          item.classList.remove('has-error');
          item.getElementsByClassName('server_response')[0].innerHTML = '';
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