{% extends "layout.tpl" %}

{% block title %}
  Account
{% endblock %}
{% block content %}
  <div class="row">
    <div class="block_locations col-xs-12 col-md-5">
      <h2>Доступные местоположения</h2>
      <div class="list-locations" id="listLocations">
        {% autoescape false %}
          {{ listLocations }}
        {% endautoescape %}
      </div>
      <button id="saveLocation" type="submit" class="btn btn-primary">Save location</button>
    </div>
    <div class="block_urls col-xs-12 col-md-3">
      <h2>Список URLs</h2>
      <div id="listUrls">
        {% autoescape false %}
          {{ listUrls }}
        {% endautoescape %}
        <div id="newUrl"></div>
      </div>
    </div>
    <div class="block_add_url col-xs-12 col-md-3">
      <h2>Добавить URL</h2>
      <form>
        <input id="inputUrl" type="text" value="" title="">
        <button id="saveUrl" type="button" class="btn btn-success">Save url</button>
      </form>
    </div>
  </div>
{% endblock %}