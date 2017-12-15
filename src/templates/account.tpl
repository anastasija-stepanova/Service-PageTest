{% extends "layout.tpl" %}

{% block title %}
Личный кабинет
{% endblock %}
{% block content %}
{% autoescape false %}
<div id="settingsContainer">
  {% for key, domain in userSettings %}
  <div class="settings_block col-xs-12 col-sm-6">
    <div class="row">
      <div class="block_domain col-xs-12">
        <h2>
          <small>Домен</small>
          <input data-domain-value="{{ key }}" title="" value="{{ key }}" class="domain_value">
        </h2>
        <div class="domain_container horizontal_divider clear"></div>
      </div>
      <span class="delete_settings"></span>
      <div class="block_locations col-xs-12 col-md-7">
        <h2>Местоположения</h2>
        <ol class="list_locations rounded">
          {% set chosenLocationsId = [] %}
          {% for location in domain.locations %}
            <li value='{{ location.id }}'>{{ location.description }}</li>
            {% set chosenLocationsId = chosenLocationsId|merge([location.id]) %}
          {% endfor %}
        </ol>
        <div class="available_locations_block hidden">
          <div class="available_locations">
            {% for location in locationsData %}
            <div class='checkbox'>
              <label>
                <input
                    class='location_checkbox'
                    type='checkbox'
                    name='location'
                    value='{{ location.id }}'
                    {% if location.id in chosenLocationsId %} checked {% endif %}>
                {{ location.description }}
              </label>
            </div>
            {% endfor %}
          </div>
        </div>
        <button type="button" class="btn btn-success add_button add_new_location hidden">Добавить местоположения</button>
      </div>
      <div class="block_urls col-xs-12 col-md-5">
        <h2>Список URLs</h2>
        <ol class="list_urls rounded">
          {% for url in domain.urls %}
          <li><span data-url-value="{{ url }}" class="value_url">{{ url }}</span><span class="delete_url hidden"></span></li>
          {% endfor %}
          <li class="new_url hidden"></li>
        </ol>
        <div class="url_addition_block hidden">
          <input type="text" class="url_addition_input" placeholder="Введите URL">
        </div>
        <button type="button" class="btn btn-success add_button add_new_url hidden">Добавить URL</button>
      </div>
    </div>
    <button type="button" class="btn btn-primary edit_settings_button">Редактировать</button>
    <button type="button" class="btn btn-primary save_settings_button">Сохранить</button>
  </div>
  {% endfor %}
</div>
<div class="modal fade bs-example-modal-sm response_modal" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

    </div>
  </div>
</div>
<div id="settingsTemplate" class="settings_block hidden col-xs-12 col-sm-6">
  <div class="row">
    <div class="block_domains col-xs-12">
      <h2>
        <small>Домен</small>
        <span class="domain_value"></span>
      </h2>
      <div class="domain_container horizontal_divider clear">
        <div class="domain_addition_block clear">
          <input type="text" class="input_addition_domain form-control" placeholder="Введите имя домена">
          <div class="clear"></div>
        </div>
      </div>
    </div>
    <span class="delete_settings"></span>
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
  <button type="button" class="btn btn-primary edit_settings_button hidden">Редактировать</button>
  <button type="button" class="btn btn-primary save_settings_button">Сохранить</button>
</div>
{% endautoescape %}
<div class="col-xs-12">
  <button id="addNewSettings" type="button" class="btn btn-success add_button">Добавить блок настроек</button>
</div>
{% endblock %}
{% block fileJs %}
<script src="../js/response_status.js"></script>
<script src="../js/classes/SettingsPanelModel.js"></script>
<script src="../js/classes/SettingsPanelView.js"></script>
<script src="../js/classes/SettingsPanelController.js"></script>
<script src="../js/account.js"></script>
{% endblock %}