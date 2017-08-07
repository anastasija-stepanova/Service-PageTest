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
          <div class="button_block">
            <button id="authorization" type="submit" class="home_page_button">Authorization</button>
            <button id="registration" type="submit" class="home_page_button">Registration</button>
          </div>
          <div class="background_modal" id="modalWindow">
            <div id="modalAuth" class="modal_auth">
              <h3 class="modal_title">Authorization</h3>
              <a class="close_button" id="closeButton"></a>
              <form>
                <div class="form-group">
                  <label for="exampleInputEmail1">Login</label>
                  <input type="text" class="form-control" id="login" placeholder="Enter login">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" class="form-control" id="password" placeholder="Password">
                </div>
                <button id="sendFormButton" type="submit" class="btn btn-primary">Enter</button>
              </form>
            </div>
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