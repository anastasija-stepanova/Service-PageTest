{% extends "layout.tpl" %}

{% block title %}
  Account
{% endblock %}
{% block content %}
<div class="block_settings">
  <div class="row">
    <div class="block_locations col-xs-12 col-md-4">
      <h2>Доступные местоположения</h2>
      <div class="list_locations" id="listLocations">
        {% autoescape false %}
          {{ listLocations }}
        {% endautoescape %}
      </div>
      <button id="saveLocation" type="submit" class="btn btn-primary">Сохранить местоположения</button>
    </div>
    <div class="block_domains col-xs-12 col-md-3">
      <h2>Домен</h2>
      <div class="domain">
        {% autoescape false %}
            {{ domain }}
        {% endautoescape %}
      </div>
      <div class="block_addition_domain">
        <input class="input_addition_domain" placeholder="Введите имя домена">
        <button type="button" class="btn btn-success save_new_domain">Сохранить домен</button>
      </div>
    </div>
    <div class="block_urls col-xs-12 col-md-4">
      <h2>Список URLs</h2>
      <div id="listUrls">
        {% autoescape false %}
          {{ listUrls }}
        {% endautoescape %}
        <div id="newUrl"></div>
      </div>
      <div class="block_addition_url hidden">
        <input class="input_addition_url" placeholder="Введите URL">
        <button type="button" class="btn btn-success save_new_url">Сохранить URL</button>
      </div>
      <button type="button" class="btn btn-danger add_button add_new_url">Добавить URL</button>
    </div>
  </div>
</div>
<div class="block_settings hidden">
  <div class="row">
    <div class="block_locations col-xs-12 col-md-4">
      <h2>Доступные местоположения</h2>
      <div class="list_locations" id="listLocations">
        {% autoescape false %}
          {{ listLocations }}
        {% endautoescape %}
      </div>
      <button id="saveLocation" type="submit" class="btn btn-primary">Сохранить местоположения</button>
    </div>
    <div class="block_domains col-xs-12 col-md-3">
      <h2>Домен</h2>
      <div class="domain">
        {% autoescape false %}
          {{ domain }}
        {% endautoescape %}
      </div>
      <div class="block_addition_domain">
        <input class="input_addition_domain" placeholder="Введите имя домена">
        <button type="button" class="btn btn-success save_new_domain">Сохранить домен</button>
      </div>
    </div>
    <div class="block_urls col-xs-12 col-md-4">
      <h2>Список URLs</h2>
      <div id="listUrls">
        {% autoescape false %}
          {{ listUrls }}
        {% endautoescape %}
        <div id="newUrl"></div>
      </div>
      <div class="block_addition_url hidden">
        <input class="input_addition_url" placeholder="Введите URL">
        <button type="button" class="btn btn-success save_new_url">Сохранить URL</button>
      </div>
      <button type="button" class="btn btn-danger add_button add_new_url">Добавить URL</button>
    </div>
  </div>
</div>
<div>
  <button id="addNewSettings" type="button" class="btn btn-danger add_button">Добавить блок настроек</button>
</div>
{% endblock %}
{% block fileJs %}
  <script src="../web/js/account.js"></script>
{% endblock %}