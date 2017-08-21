{% extends "layout.tpl" %}

{% block title %}
Account
{% endblock %}
{% block content %}
{% autoescape false %}
<div id="settingsContainer">
  {% for key, domain in userSettings %}
  <div class="settings_block col-xs-12 col-sm-6">
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
        </div>
      </div>
      <div class="block_locations col-xs-12 col-md-6">
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
        </div>
        <button type="button" class="btn btn-success add_button add_new_location">Добавить местоположения</button>
      </div>
      <div class="block_urls col-xs-12 col-md-6">
        <h2>Список URLs</h2>
        <ol class="list_urls">
          {% for url in domain.urls %}
          <li>{{url}}</li>
          {% endfor %}
          <li class="new_url hidden"></li>
        </ol>
        <div class="url_addition_block hidden">
          <input class="url_addition_input" placeholder="Введите URL">
        </div>
        <button type="button" class="btn btn-success add_button add_new_url">Добавить URL</button>
      </div>
    </div>
    <button type="button" class="btn btn-primary save_settings_button">Сохранить</button>
  </div>
  {% endfor %}
</div>
<div id="settingsTemplate" class="settings_block hidden col-xs-12 col-sm-6">
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
      </div>
    </div>
    <div class="block_locations col-xs-12 col-md-6">
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
      </div>
      <button type="button" class="btn btn-success add_button add_new_location">Добавить местоположения</button>
    </div>
    <div class="block_urls col-xs-12 col-md-6">
      <h2>Список URLs</h2>
      <ol class="list_urls">
        <li class="new_url hidden"></li>
      </ol>
      <div class="url_addition_block hidden">
        <input class="input_addition_url" placeholder="Введите URL">
      </div>
      <button type="button" class="btn btn-success add_button add_new_url">Добавить URL</button>
    </div>
  </div>
  <button type="button" class="btn btn-primary save_settings_button">Сохранить</button>
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