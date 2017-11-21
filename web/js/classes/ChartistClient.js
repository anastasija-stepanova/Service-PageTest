class ChartistClient {
  /**
   * @public
   */
  buildChart(classChartContainer, axisXValues, axisYValues, legends, axisYTitle) {
    let data = this.constructor.initializeData(axisXValues, axisYValues);
    let options = this.initializeOptions(legends, axisYTitle);
    let responsiveOptions = this.initializeResponsiveOptions();
    new Chartist.Line(classChartContainer, data, options, responsiveOptions)
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
    return {
      chartPadding: {
        top: PADDING_TOP,
        bottom: PADDING_BOTTOM,
        left: PADDING_LEFT,
        areaBase: AREA_BASE,
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
              x: AXIS_X_OFFSET_X,
              y: AXIS_X_OFFSET_Y
            },
            textAnchor: 'middle'
          },
          axisY: {
            axisTitle: axisYTitle,
            axisClass: 'ct-axis-title',
            type: Chartist.AutoScaleAxis,
            offset: {
              x: AXIS_Y_OFFSET_X,
              y: AXIS_Y_OFFSET_Y
            }
          }
        })
      ]
    };
  };

  /**
   * @private
   */
  initializeResponsiveOptions() {
    const MAX_VISIBLE_LENGTH_WITHOUT_PERIOD = 20;
    const PERIOD_OUTPUT_POINTS = 4;
    return {
      axisX: {
        labelInterpolationFnc: function skipLabels(value, index, labels) {
          if (labels.length > MAX_VISIBLE_LENGTH_WITHOUT_PERIOD) {
            return index % PERIOD_OUTPUT_POINTS === 0 ? value : null;
          }
          return value;
        }
      }
    };
  };
}

const PADDING_TOP = 60;
const PADDING_BOTTOM = 20;
const PADDING_LEFT = 20;
const AREA_BASE = 50;
const AXIS_X_OFFSET_X = 0;
const AXIS_X_OFFSET_Y = 43;
const AXIS_Y_OFFSET_X = -50;
const AXIS_Y_OFFSET_Y = -3;