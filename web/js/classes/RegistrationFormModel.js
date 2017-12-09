class RegistrationFormModel {
  constructor() {
    this.statusCode = null;
  }

  /**
   * @public
   */
  sendRequest(formData) {
    ajaxPost(FILE_REGISTRATION, this.constructor.getQueryString(formData), this.constructor.getStatus.bind(this));
  }

  /**
   * @private
   */
  static getStatus(response) {
    let event = new CustomEvent('hasAnswer');
    if ('response' in response) {
      switch (parseInt(response.response)) {
        case SUCCESS_STATUS:
          this.statusCode = SUCCESS_STATUS;
          document.dispatchEvent(event);
          break;
        case REGISTRATION_ERROR:
          this.statusCode = REGISTRATION_ERROR;
          document.dispatchEvent(event);
          break;
        case USER_EXISTS:
          this.statusCode = USER_EXISTS;
          document.dispatchEvent(event);
          break;
        case PASSWORDS_NOT_MATCH:
          this.statusCode = PASSWORDS_NOT_MATCH;
          document.dispatchEvent(event);
          break;
        case API_KEY_EXISTS:
          this.statusCode = API_KEY_EXISTS;
          document.dispatchEvent(event);
          break;
        case INVALID_LOGIN:
          this.statusCode = INVALID_LOGIN;
          document.dispatchEvent(event);
          break;
        case INVALID_PASSWORD:
          this.statusCode = INVALID_PASSWORD;
          document.dispatchEvent(event);
          break;
        case INVALID_API_KEY:
          this.statusCode = INVALID_API_KEY;
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