{% extends "layout.tpl" %}

{% block title %}
Account
{% endblock %}
{% block content %}
{% autoescape false %}
<div id="settingsContainer">
  {% for key, domain in userSettings %}
  <div class="settings_block">
    <div class="row">
      <div class="block_domains col-xs-12">
        <h2>
          <small>Домен</small>
          <span class="domain_value">{{ key }}</span></h2>
        <div class="domain_container horizontal_divider">
          <div></div>
        </div>
        <div class="domain_addition_block">
          <div class="input-group">
            <input class="domain_addition_input form-control" placeholder="Введите имя домена">
          </div>
          <button type="button" class="btn btn-primary save_new_domain">Сохранить домен</button>
        </div>
      </div>
      <div class="block_locations col-xs-12 col-md-7">
        <h2>Местоположения</h2>
        <ol class="list_locations">
          {% for location in domain.locations %}
          <li>{{ location.description }}</li>
          {% endfor %}
        </ol>
        <div class="available_locations_block hidden">
          <div class="available_locations">
            {% for location in locationsData %}
            <div class='checkbox'>
              <label>
                <input type='checkbox' name='location' value='{{ location.id }}'>{{ location.description }}
              </label>
            </div>
            {% endfor %}
          </div>
          <button class="btn btn-primary save_location_button">Сохранить местоположения</button>
        </div>
        <button type="button" class="btn btn-success add_button add_new_location">Добавить местоположения</button>
      </div>
      <div class="block_urls col-xs-12 col-md-5">
        <h2>Список URLs</h2>
        <ol class="list_urls">
          {% for url in domain.urls %}
          <li>{{url}}</li>
          {% endfor %}
          <li class="new_url hidden"></li>
        </ol>
        <div class="url_addition_block hidden">
          <input class="url_addition_input" placeholder="Введите URL">
          <button type="button" class="btn btn-primary save_new_url">Сохранить URL</button>
        </div>
        <button type="button" class="btn btn-success add_button add_new_url">Добавить URL</button>
      </div>
    </div>
  </div>
  {% endfor %}
</div>
<div id="settingsTemplate" class="settings_block hidden">
  <div class="row">
    <div class="block_domains col-xs-12">
      <h2>
        <small>Домен</small>
        <span class="domain_value domain_container"></span></h2>
      <div class="domain_container horizontal_divider">
      </div>
      <div class="domain_addition_block">
        <div class="input-group">
          <input class="input_addition_domain form-control" placeholder="Введите имя домена">
        </div>
        <button type="button" class="btn btn-primary save_new_domain">Сохранить домен</button>
      </div>
    </div>
    <div class="block_locations col-xs-12 col-md-7">
      <h2>Местоположения</h2>
      <ol class="list_locations">
      </ol>
      <div class="available_locations_block hidden">
        <div class="available_locations">
          {% for location in locationsData %}
          <div class='checkbox'>
            <label>
              <input type='checkbox' name='location' value='{{ location.id }}'>{{ location.description }}
            </label>
          </div>
          {% endfor %}
        </div>
        <button class="btn btn-primary save_location_button">Сохранить местоположения</button>
      </div>
      <button type="button" class="btn btn-success add_button add_new_location">Добавить местоположения</button>
    </div>
    <div class="block_urls col-xs-12 col-md-5">
      <h2>Список URLs</h2>
      <ol class="list_urls">
        <li class="new_url hidden"></li>
      </ol>
      <div class="url_addition_block hidden">
        <input class="input_addition_url" placeholder="Введите URL">
        <button type="button" class="btn btn-primary save_new_url">Сохранить URL</button>
      </div>
      <button type="button" class="btn btn-success add_button add_new_url">Добавить URL</button>
    </div>
  </div>
</div>
{% endautoescape %}
<div>
  <button id="addNewSettings" type="button" class="btn btn-success add_button">Добавить блок настроек</button>
</div>
{% endblock %}
{% block fileJs %}
<script src="../js/SettingsPanel.js"></script>
<script src="../js/account.js"></script>
{% endblock %}