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
            <h3 class="form_title">Войти в личный кабинет</h3>
            <form id="authForm" class="form_auth">
              <div class="form-group">
                <label for="login">Логин</label>
                <input name="userLogin" type="text" class="form-control login" id="login" placeholder="Введите логин">
                <div class="server_response"></div>
              </div>
              <div class="form-group">
                <label for="password">Пароль</label>
                <input name="userPassword" type="password" class="form-control password" id="password" placeholder="Введите пароль">
                <div class="server_response"></div>
              </div>
              <button id="sendFormButton" type="submit" class="btn btn-info">Войти</button>
            </form>
          </div>
          <div class="registration_link_block">
            <p>Еще не зарегистрированы?
              <a href="registration.php" title="Создать аккаунт">Создать аккаунт</a>
            </p>
          </div>
        </div>
      </div>
    </main>
    <script src="../js/config.js"></script>
    <script src="../js/ajax.js"></script>
    <script src="../js/response_status.js"></script>
    <script src="../js/classes/AuthFormModel.js"></script>
    <script src="../js/classes/AuthFormView.js"></script>
    <script src="../js/auth.js"></script>
  </body>
</html>