class ChartsBuilder{
  constructor(domainId, locationId, typeView, minTime, maxTime){
    const CLASS_TTFB_CHART_CONTAINER = '.ct-chart1';
    const CLASS_DOC_TIME_CHART_CONTAINER = '.ct-chart2';
    const CLASS_FULLY_LOAD_TIME_CHART_CONTAINER = '.ct-chart3';

    const ASIX_Y_TITLE_TTFB_CHART = 'TTFB (ms)';
    const ASIX_Y_TITLE_DOC_TIME_CHART = 'Document Complete (ms)';
    const ASIX_Y_TITLE_FULLY_LOAD_TIME_CHART = 'Fully Load Time (ms)';

    let chartsDataProvider = new ChartsDataProvider(domainId, locationId, typeView, minTime, maxTime);
    let chartsWrapper = new ChartistWrapper();

    let callbackInterval = setInterval(function() {
      if (chartsDataProvider.subArray) {
        chartsWrapper.buildChart(CLASS_TTFB_CHART_CONTAINER, chartsDataProvider.time, chartsDataProvider.ttfb, chartsDataProvider.domainUrls, ASIX_Y_TITLE_TTFB_CHART);
        chartsWrapper.buildChart(CLASS_DOC_TIME_CHART_CONTAINER, chartsDataProvider.time, chartsDataProvider.docTime, chartsDataProvider.domainUrls, ASIX_Y_TITLE_DOC_TIME_CHART);
        chartsWrapper.buildChart(CLASS_FULLY_LOAD_TIME_CHART_CONTAINER, chartsDataProvider.time, chartsDataProvider.fullyLoaded, chartsDataProvider.domainUrls, ASIX_Y_TITLE_FULLY_LOAD_TIME_CHART);
        chartsWrapper.buildChart('.ct-chart4', chartsDataProvider.time, [
          [5, 5, 10, 8, 7, 5, 4, null, null, null, 10, 10, 7, 8, 6, 9],
          [10, 15, null, 12, null, 10, 12, 15, null, null, 12, null, 14, null, null, null],
          [null, null, null, null, 3, 4, 1, 3, 4,  6,  7,  9, 5, null, null, null],
          [{10: 5},{x: 4, y: 3}, {x: 5, y: undefined}, {x: 6, y: 4}, {x: 7, y: null}, {x: 8, y: 4}, {x: 9, y: 4}]], chartsDataProvider.domainUrls, ASIX_Y_TITLE_FULLY_LOAD_TIME_CHART);
        clearInterval(callbackInterval);
      }
    }, 200);
  }
}