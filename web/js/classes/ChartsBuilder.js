class ChartsBuilder {
  constructor(domainId, locationId, typeView, minTime, maxTime) {

    let chartsDataProvider = new ChartsDataProvider(domainId, locationId, typeView, minTime, maxTime);
    let chartsWrapper = new ChartistWrapper();
    document.addEventListener('buildCharts', function() {
      chartsWrapper.buildChart(chartsDataProvider.chartContainerName + '1', chartsDataProvider.ttfb, chartsDataProvider.domainUrls, chartsDataProvider.axisYNames[0]);
      chartsWrapper.buildChart(chartsDataProvider.chartContainerName + '2', chartsDataProvider.docTime, chartsDataProvider.domainUrls, chartsDataProvider.axisYNames[1]);
      chartsWrapper.buildChart(chartsDataProvider.chartContainerName + '3', chartsDataProvider.fullyLoaded, chartsDataProvider.domainUrls, chartsDataProvider.axisYNames[2]);
    });
  }
}