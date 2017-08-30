<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Home page</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400" rel="stylesheet">
    <link rel="stylesheet" href="../bower_components/chartist/dist/chartist.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/main.css">
  </head>
  <body>
    <main class="home_page container-fluid">
      <div class="container">
        <div class="row">
          <div class="block_auth">
            <h3 class="form_title">Войти в личный кабинет</h3>
            <form action="auth.php?url={{url}}" method="post" class="form_auth">
              <div class="form-group">
                <label for="exampleInputEmail1">Логин</label>
                <input name="userLogin" type="text" class="form-control" id="login" placeholder="Введите логин">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Пароль</label>
                <input name="userPassword" type="password" class="form-control" id="password" placeholder="Введите пароль">
              </div>
              <button id="sendFormButton" type="submit" class="btn btn-info">Войти</button>
            </form>
          </div>
          <div class="registration_link_block hidden">
            <p>Еще не зарегистрированы?
              <a href="#" title="Создать аккаунт">Создать аккаунт</a>
            </p>
          </div>
        </div>
      </div>
    </main>
    <script src="../js/config.js"></script>
    <script src="../js/ajax.js"></script>
  </body>
</html>