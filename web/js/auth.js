$(function() {
  $('#authForm').on('submit', function(event) {
    event.preventDefault();
    let form = $(this);
    let serverResponse = form.find('.server_response');

    $.ajax({
      url: 'auth.php',
      data: form.serialize(),
      method: 'POST',
      success: function(response) {
        console.log(response);
        switch (parseInt(response)) {
          case 0:
            location.href = 'index.php';
            break;
          case 9:
            serverResponse.html('Пароль или логин неверн');
            break;
        }
      },
      error: function() {
        serverResponse.html('Ошибка авторизации. Попробуйте позже.');
      }
    });
  });
});