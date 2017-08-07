(function() {
  showModalWindow();
  closeModalWindow();
  sendFormData();
})();

let classToggler = function(elementId, opacity) {
  this.element = document.getElementById(elementId);
  this.show = function() {
    this.element.classList.add('visible');
    let element = this;
    setTimeout(function() {
      element.element.classList.add(opacity);
    }, 400);
  };
  this.hide = function() {
    let element = this;
    setTimeout(function() {
      element.element.classList.remove(opacity);
    }, 500);
    setTimeout(function() {
      let valueOpacity = element.element.style.opacity;
      if (valueOpacity == 0) {
        setTimeout(function() {
          element.element.classList.remove('visible');
        }, 500);
      }
    }, 500);
  }
};

let modalWindow = new classToggler('modalWindow', 'opacity_1');

function showModalWindow() {
  let contactUsId = document.getElementById('authorization');
  contactUsId.addEventListener('click', function(event) {
    event.preventDefault();
    modalWindow.show();
    document.body.classList.add('overflow_hidden');
  });
}
function closeModalWindow() {
  let closeButtonId = document.getElementById('closeButton');
  closeButtonId.addEventListener('click', function(event) {
    event.preventDefault();
    modalWindow.hide();
    document.body.classList.remove('overflow_hidden');
  })
}

function sendFormData() {
  let sendFormButtonId = document.getElementById('sendFormButton');
  sendFormButtonId.addEventListener('click', function(event) {
    event.preventDefault();
    let login = document.getElementById('login').value;
    let password = document.getElementById('password').value;
    let keyValue = {
      'login': login,
      'password': password
    };
    let jsonString = 'dataForm=' + JSON.stringify(keyValue);
    ajaxPost('home_page.php', jsonString, function(response) {
      modalWindow.hide();
      document.getElementById('login').value = '';
      document.getElementById('password').value = '';
    });
  })
}
