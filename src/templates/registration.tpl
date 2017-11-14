<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Service PageLoad</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400" rel="stylesheet">
    <link rel="stylesheet" href="../bower_components/chartist/dist/chartist.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
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
                <label>Логин</label>
                <input name="userLogin" type="text" class="form-control" id="login" placeholder="Введите логин" data-min="5">
              </div>
              <div class="form-group">
                <label>Пароль</label>
                <input name="userPassword" type="password" class="form-control" placeholder="Введите пароль" data-min="6">
              </div>
              <div class="form-group">
                <label>Повторите пароль</label>
                <input name="userPasswordChecked" type="password" class="form-control" placeholder="Повторите пароль">
              </div>
              <div class="form-group">
                <label>Введите API ключ</label>
                <input name="apiKey" type="text" class="form-control" placeholder="Введите API ключ">
              </div>
              <button id="sendFormButton" type="submit" class="btn btn-info">Готово</button>
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
    <script src="../js/ajax.js"></script>
    <script src="../js/vendor/jquery.js"></script>
    <script src="../js/registration.js"></script>
  </body>
</html>