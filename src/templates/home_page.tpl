<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Home page</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400" rel="stylesheet">
    <link rel="stylesheet" href="../bower_components/chartist/dist/chartist.min.css">
    <link rel="stylesheet" href="../web/css/bootstrap.min.css">
    <link rel="stylesheet" href="../web/css/main.css">
  </head>
  <body>
    <main class="home_page container-fluid">
      <div class="container">
        <div class="row">
          <div class="block_auth">
            <h3 class="form_title">Войти в личный кабинет</h3>
            <form action="../../web/auth.php" method="post" class="form_auth">
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
          <div id="responseAuth">
            {% autoescape false %}
              {{ response }}
            {% endautoescape %}
          </div>
          <div class="registration_link_block">
            <p>Еще не зарегистрированы?
              <a href="#" title="Создать аккаунт">Создать аккаунт</a>
            </p>
          </div>
        </div>
      </div>
    </main>
    <script src="../web/js/config.js"></script>
    <script src="../web/js/ajax.js"></script>
    {% block fileJs %}
    <script src="../web/js/home_page.js"></script>
    {% endblock %}
  </body>
</html>