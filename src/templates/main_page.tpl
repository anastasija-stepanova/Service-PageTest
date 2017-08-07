{% extends "layout.tpl" %}

{% block title %}
  Index
{% endblock %}
{% block content %}
<div class="row">
  <h2>Change TTFB over time</h2>
  <div class="ct-chart1 ct-major-tenth"></div>
  <h2>Change LoadTime over time</h2>
  <div class="ct-chart2 ct-major-tenth"></div>
  <h2>Change Requests over time</h2>
  <div class="ct-chart3 ct-major-tenth"></div>
</div>
{% endblock %}
{% block chartistJs %}
  <script src="../bower_components/chartist/dist/chartist.min.js"></script>
{% endblock %}
{% block fileJs %}
  <script src="../web/js/main_page.js"></script>
{% endblock %}