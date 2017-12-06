{% extends "layout.tpl" %}

{% block title %}
Главная
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
                <div class="list_locations_block col-xs-12 col-md-7">
                  <div class="form-group">
                    <label for="selectLocation">Местоположения</label>
                    <select class="form-control" id="selectLocation">
                      {% for location in domain.locations %}
                        <option class="location" name="location{{ domain.domain_id }}" data-value="{{ location.id }}">{{ location.description }}</option>
                      {% endfor %}
                    </select>
                  </div>
                </div>
                <div class="list_type_view col-xs-12 col-md-5">
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
                <div class="presets_block col-xs-12">
                  <p>
                    <span>
                      Диапазон:
                      <span data-value="" class="min_date"></span>
                      <span data-value="" class="max_date"></span>
                    </span>
                  </p>
                  <input title="Диапазон времени" class="slider_range" id="sliderRange" type="text"/>
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
<script src="../bower_components/chartist-plugin-axistitle/dist/chartist-plugin-axistitle.js"></script>
<script src="../bower_components/chartist-plugin-legend/dist/chartist-plugin-legend.js"></script>
{% endblock %}
{% block fileJs %}
<script src="../bower_components/seiyria-bootstrap-slider/dist/bootstrap-slider.js"></script>
<script src="../js/classes/DomainDashboardSettings.js"></script>
<script src="../js/classes/ChartsDataProvider.js"></script>
<script src="../js/classes/ChartistWrapper.js"></script>
<script src="../js/classes/ChartsBuilder.js"></script>
<script src="../js/build_chart.js"></script>
<script src="../js/main.js"></script>
{% endblock %}
