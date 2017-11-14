$(function() {
  $('#registrationForm').on('submit', function(event) {
    event.preventDefault();
    let form = $(this);
    let serverResponse = form.find('.server_response');

    let userName = form.find('input[name="userLogin"]');
    if (userName.val().length < userName.data('min')) {
      serverResponse.html('Длина логина должна быть более ' + userName.data('min') + ' символов.');
      userName.closest('.form-group').addClass('has-error');
      return;
    }

    let password = form.find('input[name="userPassword"]');
    let passwordRepeat = form.find('input[name="userPasswordChecked"]');

    if (password.val() != passwordRepeat.val()) {
      serverResponse.html('<span class="text-danger">Пароли не совпадают, повторите ввод.</span>');
      password.closest('.form-group').addClass('has-error');
      passwordRepeat.closest('.form-group').addClass('has-error');
      return;
    }

    if (password.val().length < password.data('min')) {
      serverResponse.html('Длина пароля должна быть более ' + password.data('min') + ' символов');
      password.closest('.form-group').addClass('has-error');
      return;
    }

    $.ajax({
      url: 'registration.php',
      data: form.serialize(),
      method: 'POST',
      success: function(response) {
        switch (parseInt(response)) {
          case 0:
            location.href = 'auth.php';
            break;
          case 5:
            serverResponse.html('Ошибка регистрации. Попробуйте позже.');
            break;
          case 6:
            serverResponse.html('Повторите ввод.');
            break;
          case 7:
            serverResponse.html('Пользователь с таким логин уже существует');
            break;
        }
      },
      error: function() {
        serverResponse.html('Ошибка регистрации. Попробуйте позже.');
      }
    });
  }).find('.form-group').on('click', function() {
    if ($(this).hasClass('has-error')) {
      $(this).removeClass('has-error');
    }
  });
});