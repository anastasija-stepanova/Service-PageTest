{% extends "layout.tpl" %}

{% block title %}
Index
{% endblock %}
{% block content %}
<div class="row settings">
  {% for key, domain in userSettings %}
  <div class="list_domains_block col-xs-12 col-sm-6">
    <div class="radio">
      <label>
        <input type='radio' name='domain' value="{{ key }}">{{ key }}
      </label>
    </div>
  </div>
  <div class="list_locations_block col-xs-12 col-sm-6">
    {% for location in domain.locations %}
    <div class="list_locations">
      <div class="radio">
        <label>
          <input type='radio' name='location' value="{{ location.description }}">{{ location.description }}
        </label>
      </div>
    </div>
    {% endfor %}
  </div>
  {% endfor %}
</div>
<div class="row">
  <h2>TTFB</h2>
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
<script src="../js/build_chart.js"></script>
<script src="../js/main.js"></script>
{% endblock %}