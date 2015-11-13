	var $border_color = "#efefef";
	var $grid_color = "#ddd";
	var $default_black = "#666";
	var $green = "#8ecf67";
	var $yellow = "#fac567";
	var $orange = "#F08C56";
	var $blue = "#1e91cf";
	var $red = "#f74e4d";
	var $teal = "#28D8CA";
	var $grey = "#999999";
	var $dark_blue = "#0D4F8B";
$(function () {

  var ds=[], data, chartOptions;

  ds.push ([[2100, 1],[3300, 2],[3900, 3],[4500, 4], [5200, 5], [3100, 6]]);
  ds.push ([[1500, 1],[2200, 2],[2900, 3],[2300, 4], [3800, 5], [1600, 6]]);
  ds.push ([[600, 1],[1300, 2],[1900, 3],[3500, 4], [2700, 5], [3200, 6]]);

  data = [ {
    label: 'News',
    data: ds[1]
  }, {
    label: 'Sports',
    data: ds[0]
  }, {
    label: 'Movies',
    data: ds[2]
  }];

  chartOptions = {
    xaxis: {
        
    },
    grid:{
      hoverable: true,
      clickable: false,
      borderWidth: 1,
      tickColor: $border_color,
      borderColor: $grid_color,
    },
    series: {
      stack: true
    },
    legend: {
      position: 'se'
    },
    bars: {
      horizontal: true,
      show: true,
      barWidth: .25,
      fill: true,
      lineWidth: 0,
      fillColor: { colors: [ { opacity: 1 }, { opacity: 1 } ] }
    },
    shadowSize: 0,
    tooltip: true,

    tooltipOpts: {
      content: '%s: %x'
    },
    colors: [$green, $blue, $yellow, $teal, $yellow, $green],
  }

  var holder = $('#stacked-horizontal-chart');

  if (holder.length) {
    $.plot(holder, data, chartOptions );
  }

});