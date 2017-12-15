class AuthFormModel {
  constructor() {
    this.statusCode = null;
    this.event = new CustomEvent('hasAnswer');
  }

  /**
   * @public
   *
   */
  sendRequest(formData) {
    ajaxPost(FILE_AUTH, AuthFormModel.getQueryString(formData), AuthFormModel.getResponseStatus.bind(this));
  }

  /**
   * @private
   */
  static getResponseStatus(response) {
    if ('response' in response) {
      switch (parseInt(response.response)) {
        case SUCCESS_STATUS:
          this.statusCode = SUCCESS_STATUS;
          document.dispatchEvent(this.event);
          break;
        case LOGIN_PASSWORD_INCORRECT:
          this.statusCode = LOGIN_PASSWORD_INCORRECT;
          document.dispatchEvent(this.event);
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