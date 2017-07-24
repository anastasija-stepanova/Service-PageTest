<div class="row">
  <div class="list-users col-xs-12 col-md-4">
    <h2>Пользователи</h2>
    <div>
      {% autoescape false %}
        {{ listUsers }}
      {% endautoescape %}
    </div>
  </div>
  <div class="block_urls col-xs-12 col-md-4">
    <h2>Список URLs</h2>
    <div id="listUrls">
      {% autoescape false %}
        {{ listUserUrls }}
      {% endautoescape %}
      <div id="newUrl"></div>
    </div>
  </div>
  <div class="block_user_locations col-xs-12 col-md-4">
    <h2>Местоположения</h2>
    <div>
      {% autoescape false %}
        {{ listUserLocations }}
      {% endautoescape %}
    </div>
  </div>
</div>