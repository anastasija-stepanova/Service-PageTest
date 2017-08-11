{% extends "layout.tpl" %}

{% block title %}
  Index
{% endblock %}
{% block content %}
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
{% endblock %}
{% block fileJs %}
  <script src="../web/js/main_page.js"></script>
{% endblock %}