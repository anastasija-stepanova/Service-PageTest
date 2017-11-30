const PADDING_TOP = 60;
const PADDING_BOTTOM = 20;
const PADDING_LEFT = 20;
const AREA_BASE = 50;
const AXIS_X_OFFSET_X = 0;
const AXIS_X_OFFSET_Y = 43;
const AXIS_Y_OFFSET_X = -50;
const AXIS_Y_OFFSET_Y = -3;
const SCALE_MIN_SPACE = 20;

class ChartistWrapper {
  /**
   * @public
   */
  buildChart(classChartContainer, axisYValues, legends, axisYTitle) {
    let data = ChartistWrapper.initializeData(axisYValues);
    let options = this.initializeOptions(legends, axisYTitle);
    new Chartist.Line(classChartContainer, data, options);
  }

  /**
   * @private
   */
  static initializeData(axisYValues) {
    return {
      series: axisYValues
    };
  }

  /**
   * @private
   */
  initializeOptions(legends, axisYTitle) {
    const MAX_VISIBLE_LENGTH_WITHOUT_PERIOD = 20;
    const PERIOD_OUTPUT_POINTS = 4;
    return {
      chartPadding: {
        top: PADDING_TOP,
        bottom: PADDING_BOTTOM,
        left: PADDING_LEFT,
        areaBase: AREA_BASE,
      },
      axisX: {
        type: Chartist.AutoScaleAxis,
        scaleMinSpace: SCALE_MIN_SPACE,
        onlyInteger: true,
        labelInterpolationFnc: function skipLabels(value, index, labels) {
          if (labels.length > MAX_VISIBLE_LENGTH_WITHOUT_PERIOD) {
            return index % PERIOD_OUTPUT_POINTS === 0 ? new Date(value).toLocaleDateString() : null;
          }
          return new Date(value).toLocaleDateString();
        }
      },
      plugins: [
        ChartistWrapper.getPluginLegendOptions(legends),
        ChartistWrapper.getPluginTooltipOptions(axisYTitle),
        ChartistWrapper.getPluginAxisTitleOptions(axisYTitle)
      ]
    };
  }

  /**
   * @private
   */
  static getPluginAxisTitleOptions(axisYTitle) {
    return Chartist.plugins.ctAxisTitle({
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
  }

  /**
   * @private
   */
  static getPluginTooltipOptions() {
    return Chartist.plugins.tooltip({
      currencyFormatCallback: function getUnits(value) {
        let len = value.search(',');
        let dateMS = parseInt(value.substr(0, len));
        let date = new Date(dateMS).toLocaleDateString();
        value = value.replace(dateMS, date);
        value = value + ' ms';
        return value;
      },
      currency: 'ms',
    })
  }

  /**
   * @private
   */
  static getPluginLegendOptions(legends) {
    return Chartist.plugins.legend({
      legendNames: legends,
      removeAll: true,
    })
  }
}