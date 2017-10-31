class ChartsBuilder {
  buildChart(classChartContainer, time, resourceTestingData, domainUrls, axisYTitle){
    let data = this.initializeData(time, resourceTestingData);
    let options = this.initializeOptions();
    let responsiveOptions = this.initializeResponsiveOptions();
    let plugins = this.initializePlugins(domainUrls, axisYTitle);
    new Chartist.Line(classChartContainer, data, options, responsiveOptions, plugins)
  }

  initializeData(time, resourceTestingData) {
    let data = {
      labels: time,
      series: resourceTestingData,
    };

    return data;
  };

  initializeOptions() {
    let options = {
      chartPadding: {
        top: 60,
        bottom: 20,
        left: 20,
        areaBase: 50,
      },
    };

    return options;
  };

  initializeResponsiveOptions() {
    const MAX_VISIBLE_LENGTH_WITHOUT_PERIOD = 20;
    const PERIOD_OUTPUT_POINTS = 4;
    let responsiveOptions = {
      axisX: {
        labelInterpolationFnc: function skipLabels(value, index, labels) {
          if (labels.length > MAX_VISIBLE_LENGTH_WITHOUT_PERIOD) {
            return index % PERIOD_OUTPUT_POINTS === 0 ? value : null;
          }
          return value;
        }
      }
    };

    return responsiveOptions;
  };

  initializePlugins(domainUrls, axisYTitle) {
    let plugins = {
      plugins: [
        Chartist.plugins.legend({
          legendNames: domainUrls,
          removeAll: true,
        }),
        Chartist.plugins.tooltip({
          currencyFormatCallback: function getUnits(value) {
            value = value + ' ms';
            return value;
          },
          currency: 'ms',
        }),
        Chartist.plugins.ctAxisTitle({
          axisX: {
            axisTitle: 'Time (in days)',
            axisClass: 'ct-axis-title',
            type: Chartist.AutoScaleAxis,
            offset: {
              x: 0,
              y: 43
            },
            textAnchor: 'middle'
          },
          axisY: {
            axisTitle: axisYTitle,
            axisClass: 'ct-axis-title',
            type: Chartist.AutoScaleAxis,
            offset: {
              x: -50,
              y: -3
            }
          }
        })
      ]
    };

    return plugins;
  }
}