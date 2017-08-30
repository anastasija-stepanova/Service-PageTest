{% extends "layout.tpl" %}

{% block title %}
Index
{% endblock %}
{% block content %}
<button type="button" class="btn btn-primary options_button" data-toggle="modal" data-target="#modalSettingDashboard">
  Настройки
</button>
<div class="modal fade" tabindex="-1" role="dialog" id="modalSettingDashboard">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                  aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Настройки</h4>
      </div>
      <div class="modal-body">
        <div class="list_domains_block panel-group" id="accordion" role="tablist" aria-multiselectable="true">
          {% for key, domain in userSettings %}
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading{{ domain.domain_id }}">
              <h4 class="panel-title">
                <a role="button" aria-expanded="true" aria-controls="collapse{{ domain.domain_id }}" class="domain"
                   data-toggle="collapse" data-parent="#accordion" href="#collapse{{ domain.domain_id }}"
                   data-value="{{ domain.domain_id }}">
                  {{ key }}
                </a>
              </h4>
            </div>
            <div id="collapse{{ domain.domain_id }}" class="panel-collapse
                                                         {% if loop.first %} in
                                                         {% else %} collapsing
                                                         {% endif %} " role="tabpanel"
                 aria-labelledby="heading{{ domain.domain_id }}">
              <div class="panel-body">
                <div class="list_locations_block col-xs-12 col-md-4">
                  <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                      Местоположения
                      <span class="caret"></span>
                    </button>
                    <ul class="list_locations dropdown-menu" aria-labelledby="dropdownMenu">
                      {% for location in domain.locations %}
                      <li class="radio">
                        <label>
                          <input {% if loop.first %} checked {% endif %} class="location"
                                                     name="location{{ domain.domain_id }}" type='radio'
                                                     data-value="{{ location.id }}">{{ location.description }}
                        </label>
                      </li>
                      {% endfor %}
                    </ul>
                  </div>
                </div>
                <div class="list_type_view col-xs-12 col-md-4">
                  <div class="radio">
                    <label>
                      <input checked class="view" type='radio' name="view{{ domain.domain_id }}" data-value="1">Первый просмотр
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input class="view" type='radio' name="view{{ domain.domain_id }}" data-value="2">Повторный просмотр
                    </label>
                  </div>
                </div>
                <div class="presets_block col-xs-12 col-md-4">
                  <div class="radio">
                    <label>
                      <input class="preset" type='radio' name="interval{{ domain.domain_id }}" data-value="1">День
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input checked class="preset" type='radio' name="interval{{ domain.domain_id }}" data-value="2">Неделя
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input class="preset" type='radio' name="interval{{ domain.domain_id }}" data-value="3">Месяц
                    </label>
                  </div>
                </div>
                <button type="button" id="saveOptions" class="btn btn-primary save_options_button">Показать</button>
              </div>
            </div>
          </div>
          {% endfor %}
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <h2>Time To First Byte</h2>
  <div class="ct-chart1 ct-major-tenth"></div>
  <h2>Document Complete Time</h2>
  <div class="ct-chart2 ct-major-tenth"></div>
  <h2>Fully Load Time</h2>
  <div class="ct-chart3 ct-major-tenth"></div>
</div>
{% endblock %}
{% block chartistJs %}
<script src="../bower_components/chartist/dist/chartist.js"></script>
<script src="../bower_components/chartist-plugin-tooltip/dist/chartist-plugin-tooltip.js"></script>
<script src="../bower_components/chartist-plugin-zoom/dist/chartist-plugin-zoom.js"></script>
<script src="../bower_components/chartist-plugin-axistitle/dist/chartist-plugin-axistitle.js"></script>
<script src="../bower_components/chartist-plugin-legend/dist/chartist-plugin-legend.js"></script>
{% endblock %}
{% block fileJs %}
<script src="../js/DomainDashboardSettings.js"></script>
<script src="../js/Dashboard.js"></script>
<script src="../js/build_chart.js"></script>
<script src="../js/main.js"></script>
{% endblock %}
