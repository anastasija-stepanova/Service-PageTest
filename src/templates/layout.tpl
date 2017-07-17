<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>PageLoadTest</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../web/style/css/bootstrap.min.css">
    <link rel="stylesheet" href="../web/style/css/main.css">
  </head>
  <body>
    <header></header>
    <main>
      <div class="block_locations col-xs-12 col-md-4">
        [[$listLocations]]
        <button id="saveLocation" type="submit" class="btn btn-primary">Save location</button>
      </div>
      <div class="block_urls col-xs-12 col-md-4">
        <ol>
          [[$listUrls]]
        </ol>
        <div id="result"></div>
      </div>
      <div class="block_add_url">
        <form>
          <input id="inputUrl" type="text" value="" title="">
          <button id="saveUrl" type="button" class="btn btn-success">Save url</button>
        </form>
      </div>
    </main>
    <footer>
      <script src="../src/js/main.js"></script>
    </footer>
  </body>
</html>