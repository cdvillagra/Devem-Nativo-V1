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
		[1262304000000, 192], [1264982400000, 320], [1267401600000, 1605], [1270080000000, 1129], 
		[1272672000000, 1063], [1275350400000, 1105], [1277942400000, 2002], [1280620800000, 2917], 
		[1283299200000, 3100], [1285891200000, 1700], [1288569600000, 2100], [1291161600000, 1700]
	];

	d2 = [
		[1262304000000, 292], [1264982400000, 520], [1267401600000, 1905], [1270080000000, 1429],
		[1272672000000, 1363], [1275350400000, 1405], [1277942400000, 2302], [1280620800000, 3317], 
		[1283299200000, 3800], [1285891200000, 1900], [1288569600000, 2400], [1291161600000, 1900]
	];
 
	d3 = [
		[1262304000000, 392], [1264982400000, 720], [1267401600000, 2205], [1270080000000, 1729],
		[1272672000000, 1663], [1275350400000, 1705], [1277942400000, 2602], [1280620800000, 3717], 
		[1283299200000, 4200], [1285891200000, 2200], [1288569600000, 2800], [1291161600000, 2100]
	];

	data = [{ 
		label: "Likes", 
		data: d1
	}, {
		label: "Shares",
		data: d2
	}, {
		label: "Tweets",
		data: d3
	}];
 
		chartOptions = {
			xaxis: {
				min: (new Date(2009, 11, 2)).getTime(),
				max: (new Date(2010, 11, 6)).getTime(),
				mode: "time",
				tickSize: [1, "month"],
				monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
				tickLength: 0
			},
			yaxis: {

			},
			series: {
				stack: true,
				lines: {
					show: true, 
					fill: true,
					lineWidth: 1
				},
				points: {
					show: false,
					radius: 4,
					fill: true,
					fillColor: "#ffffff",
					lineWidth: 1
				}
			},
			grid:{
        hoverable: true,
        clickable: false,
        borderWidth: 1,
        tickColor: $border_color,
        borderColor: $grid_color,
      },
			legend: {
				show: true,
				position: 'nw'
			},
			shadowSize: 0,
			tooltip: true,
			tooltipOpts: {
			content: '%s: %y'
			},
			colors: [$green, $blue, $yellow, $teal, $yellow, $green],
		};

		var holder = $('#stacked-area-chart');

		if (holder.length) {
			$.plot(holder, data, chartOptions );
		}


});