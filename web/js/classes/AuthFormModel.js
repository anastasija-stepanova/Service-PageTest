class AuthFormModel {
  constructor() {
    this.statusCode = null;
  }

  /**
   * @public
   *
   */
  sendRequest(formData) {
    ajaxPost(FILE_AUTH, AuthFormModel.getQueryString(formData), AuthFormModel.getStatus.bind(this));
  }

  /**
   * @private
   */
  static getStatus(response) {
    if ('response' in response) {
      let event = new CustomEvent('hasAnswer');
      switch (parseInt(response.response)) {
        case SUCCESS_STATUS:
          this.statusCode = SUCCESS_STATUS;
          document.dispatchEvent(event);
          break;
        case LOGIN_PASSWORD_INCORRECT:
          this.statusCode = LOGIN_PASSWORD_INCORRECT;
          document.dispatchEvent(event);
          break;
      }
    }
  }

  static getQueryString(formData) {
    let pairs = [];
    for (let [key, value] of formData.entries()) {
      pairs.push(encodeURIComponent(key) + '=' + encodeURIComponent(value));
    }
    return pairs.join('&');
  }
}