<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Service PageLoad</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400" rel="stylesheet">
    <link rel="stylesheet" href="../bower_components/chartist/dist/chartist.css">
    <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="../css/main.css">
  </head>
  <body>
    <main class="home_page container-fluid">
      <div class="container">
        <div class="row">
          <div class="block_auth">
            <h3 class="form_title">Зарегистрироваться</h3>
            <form class="form_registration" id="registrationForm">
              <div class="form-group">
                <label>Логин <span class="demand">(Не менее 5 строчных букв, цифр. Первый символ-буква.)</span></label>
                <input name="userLogin" type="text" class="form-control login" placeholder="Введите логин" data-min="5">
                <span class="server_response_login error_message_container"></span>
              </div>
              <div class="form-group">
                <label>Пароль <span class="demand">(Не менее 6 строчных-заглавных букв, цифр)</span></label>
                <input name="userPassword" type="password" class="form-control password" placeholder="Введите пароль" data-min="6">
                <span class="server_response_password error_message_container"></span>
              </div>
              <div class="form-group">
                <label>Повторите пароль</label>
                <input name="userPasswordChecked" type="password" class="form-control password_checked" placeholder="Повторите пароль">
                <span class="server_response_password_checked error_message_container"></span>
              </div>
              <div class="form-group">
                <label>Введите API ключ
                  <span class="demand">(Получить
                    <a href="https://www.webpagetest.org/getkey.php" title="Получить API key" target="_blank">здесь</a>)
                  </span>
                </label>
                <input name="apiKey" type="text" class="form-control api_key" placeholder="Введите API ключ">
                <span class="server_response_api_key error_message_container"></span>
              </div>
              <button id="sendFormButton" type="submit" class="btn btn-info">Отправить</button>
              <div class="server_response"></div>
            </form>
          </div>
          <div class="auth_link_block">
            <a href="auth.php" title="Войти">Войти</a>
          </div>
        </div>
      </div>
    </main>
    <script src="../js/config.js"></script>
    <script src="../js/response_status.js"></script>
    <script src="../js/ajax.js"></script>
    <script src="../js/classes/RegistrationFormModel.js"></script>
    <script src="../js/classes/RegistrationFormView.js"></script>
    <script src="../js/registration.js"></script>
  </body>
</html>