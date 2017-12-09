class ChartsBuilder {
  constructor(domainId, locationId, typeView, minTime, maxTime) {
    const CLASS_TTFB_CHART_CONTAINER = '.ct-chart1';
    const CLASS_DOC_TIME_CHART_CONTAINER = '.ct-chart2';
    const CLASS_FULLY_LOAD_TIME_CHART_CONTAINER = '.ct-chart3';

    const ASIX_Y_TITLE_TTFB_CHART = 'TTFB (ms)';
    const ASIX_Y_TITLE_DOC_TIME_CHART = 'Document Complete (ms)';
    const ASIX_Y_TITLE_FULLY_LOAD_TIME_CHART = 'Fully Load Time (ms)';

    let chartsDataProvider = new ChartsDataProvider(domainId, locationId, typeView, minTime, maxTime);
    let chartsWrapper = new ChartistWrapper();
    document.addEventListener('buildCharts', function() {
      if (chartsDataProvider.subArray) {
        chartsWrapper.buildChart(CLASS_TTFB_CHART_CONTAINER, chartsDataProvider.ttfb, chartsDataProvider.domainUrls, ASIX_Y_TITLE_TTFB_CHART);
        chartsWrapper.buildChart(CLASS_DOC_TIME_CHART_CONTAINER, chartsDataProvider.docTime, chartsDataProvider.domainUrls, ASIX_Y_TITLE_DOC_TIME_CHART);
        chartsWrapper.buildChart(CLASS_FULLY_LOAD_TIME_CHART_CONTAINER, chartsDataProvider.fullyLoaded, chartsDataProvider.domainUrls, ASIX_Y_TITLE_FULLY_LOAD_TIME_CHART);
      }
    });
  }
}