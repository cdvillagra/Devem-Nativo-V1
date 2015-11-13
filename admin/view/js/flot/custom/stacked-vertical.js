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

	var d1, d2, d3, data, chartOptions;

	d1 = [
			[1325376000000, 1200], [1328054400000, 700], [1330560000000, 1000], [1333238400000, 600],
			[1335830400000, 350]
		];
 
		d2 = [
			[1325376000000, 800], [1328054400000, 600], [1330560000000, 300], [1333238400000, 350],
			[1335830400000, 300]
		];
 
		d3 = [
			[1325376000000, 650], [1328054400000, 450], [1330560000000, 150], [1333238400000, 200],
			[1335830400000, 150]
		];

		data = [{
			label: 'Referral',
			data: d1
		}, {
			label: 'Direct',
			data: d2
		}, {
			label: 'Organic',
			data: d3
		}];

		chartOptions = {
			xaxis: {
				min: (new Date(2011, 11, 15)).getTime(),
				max: (new Date(2012, 04, 18)).getTime(),
				mode: "time",
				tickSize: [2, "month"],
				monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
				tickLength: 0
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
			bars: {
			show: true,
			barWidth: 36*24*60*60*300,
				fill: true,
				align: 'center',
				lineWidth: 1,
				lineWidth: 0,
				fillColor: { colors: [ { opacity: 1 }, { opacity: 1 } ] }
			},
			shadowSize: 0,
			tooltip: true,
			tooltipOpts: {
				content: '%s: %y'
			},
			colors: [$green, $blue, $yellow, $teal, $yellow, $green],
		}

		var holder = $('#stacked-vertical-chart');

		if (holder.length) {
				$.plot(holder, data, chartOptions );
		}



});