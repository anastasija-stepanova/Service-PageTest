<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>{% block title %}{% endblock %}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400" rel="stylesheet">
    <link rel="stylesheet" href="../bower_components/chartist/dist/chartist.css">
    <link rel="stylesheet" href="../bower_components/chartist-plugin-tooltip/dist/chartist-plugin-tooltip.css">
    <link rel="stylesheet" href="../bower_components/chartist-plugin-legend/css/chartist-plugin-legend.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/main.css">
  </head>
  <body>
    <header class="header container-fluid">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-6 logo">
            <a href="/" title="PageLoadTest"><img class="img-responsive" src="../../img/logo.png" title="Logo" alt="Logo"></a>
          </div>
          <div class="col-xs-12 col-sm-6">
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
                  <li><a class="menu_item" title="Главная" href="index.php">Главная</a></li>
                  <li><a class="menu_item" title="Личный кабинет" href="account.php">Личный кабинет</a></li>
                  <li><a class="menu_item" title="Выход" href="logout.php">Выход</a></li>
                </ul>
              </div>
            </nav>
          </div>
        </div>
      </div>
    </header>
    <main class="main container">
      {% block content %}{% endblock %}
    </main>
    <footer class="footer container-fluid">
      <div class="container">
        <div class="row">
          <p>Copyright</p>
          <p>2017</p>
        </div>
      </div>
      <script src="../js/jquery.min.js"></script>
      <script src="../js/bootstrap.min.js"></script>
      {% block chartistJs %}{% endblock %}
      <script src="../js/config.js"></script>
      <script src="../js/ajax.js"></script>
      {% block fileJs %}{% endblock %}
    </footer>
  </body>
</html>