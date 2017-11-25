class ChartistWrapper {
  constructor() {
    this.PADDING_TOP = 60;
    this.PADDING_BOTTOM = 20;
    this.PADDING_LEFT = 20;
    this.AREA_BASE = 50;
    this.AXIS_X_OFFSET_X = 0;
    this.AXIS_X_OFFSET_Y = 43;
    this.AXIS_Y_OFFSET_X = -50;
    this.AXIS_Y_OFFSET_Y = -3;
  }
  /**
   * @public
   */
  buildChart(classChartContainer, axisXValues, axisYValues, legends, axisYTitle) {
    let data = this.constructor.initializeData(axisXValues, axisYValues);
    let options = this.initializeOptions(legends, axisYTitle);
    new Chartist.Line(classChartContainer, data, options);
  }

  /**
   * @private
   */
  static initializeData(axisXValues, axisYValues) {
    return {
      labels: axisXValues,
      series: axisYValues,
    };
  };

  /**
   * @private
   */
  initializeOptions(legends, axisYTitle) {
    const MAX_VISIBLE_LENGTH_WITHOUT_PERIOD = 20;
    const PERIOD_OUTPUT_POINTS = 4 ;
    return {
      chartPadding: {
        top: this.PADDING_TOP,
        bottom: this.PADDING_BOTTOM,
        left: this.PADDING_LEFT,
        areaBase: this.AREA_BASE,
      },
      axisX: {
        labelInterpolationFnc: function skipLabels(value, index, labels) {
          if (labels.length > MAX_VISIBLE_LENGTH_WITHOUT_PERIOD) {
            return index % PERIOD_OUTPUT_POINTS === 0 ? value : null;
          }
          return value;
        }
      },
      plugins: [
        Chartist.plugins.legend({
          legendNames: legends,
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
              x: this.AXIS_X_OFFSET_X,
              y: this.AXIS_X_OFFSET_Y
            },
            textAnchor: 'middle'
          },
          axisY: {
            axisTitle: axisYTitle,
            axisClass: 'ct-axis-title',
            type: Chartist.AutoScaleAxis,
            offset: {
              x: this.AXIS_Y_OFFSET_X,
              y: this.AXIS_Y_OFFSET_Y
            }
          }
        })
      ]
    };
  };
}