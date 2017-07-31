<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>PageLoadTest</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400" rel="stylesheet">
    <link rel="stylesheet" href="../bower_components/chartist/dist/chartist.min.css">
    <link rel="stylesheet" href="../web/css/bootstrap.min.css">
    <link rel="stylesheet" href="../web/css/main.css">
  </head>
  <body>
    <header class="header container-fluid">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <nav class="navbar menu" role="navigation">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle hamburger-button" data-toggle="collapse"
                        data-target="#mobileMenu">
                  <span class="icon_bar nav-icon"></span>
                  <span class="icon_bar nav-icon"></span>
                  <span class="icon_bar nav-icon"></span>
                </button>
              </div>
              <div class="collapse navbar-collapse" id="mobileMenu">
                <ul class="nav navbar-nav">
                  <li><a class="menu_item" title="Главная" href="#">Главная</a></li>
                  <li><a class="menu_item" title="История тестов" href="#">История тестов</a></li>
                  <li><a class="menu_item" title="Личный кабинет" href="index.php">Личный кабинет</a></li>
                </ul>
              </div>
            </nav>
          </div>
        </div>
      </div>
    </header>
    <main class="main container">
      {% autoescape false %}
        {{ content }}
      {% endautoescape %}
    </main>
    <footer class="footer container-fluid">
      <div class="container">
        <div class="row">
          <p>Copyright</p>
          <p>2017</p>
        </div>
      </div>
      <script src="../bower_components/chartist/dist/chartist.min.js"></script>
      <script src="../web/js/config.js"></script>
      <script src="../web/js/ajax.js"></script>
      <script src="../web/js/main.js"></script>
    </footer>
  </body>
</html>