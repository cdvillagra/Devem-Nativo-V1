var $grid_color = "#eee";
var $border_color = "#e1e8ed";
var $default_black = "#666";
var $red = "#3693cf";


// Just Gage
var gg1 = new JustGage({
  id: "gg1",
  value : 4960,
  min: 100,
  max: 9999,
  gaugeWidthScale: 1,
  counter: true,
  formatNumber: true,
  gaugeColor: $grid_color,
  levelColors: [$red],
  label: "30 segundos"
});
setInterval(function() {
  gg1.refresh(getRandomInt(10, 9999));
}, 2000);



//Flot Graphs

// Monthly Revenue & Growth
var $border_color = "#F5F8FA";
var $grid_color = "#F5F8FA";
var $default_black = "#666";

$(function () {    
  var data1 = [
    [1354586000000, 20], [1364587000000, 60], [1374588000000, 100],
    [1384589000000, 200], [1394590000000, 320], [1404591000000, 200],
    [1414592000000, 100], [1424593000000, 360], [1434594000000, 800],
    [1444595000000, 1100], [1454596000000, 1000], [1464597000000, 1200]
  ];

  var data2 = [
    [1354586000000, 10], [1364587000000, 85], [1374588000000, 158],
    [1384589000000, 113], [1394590000000, 280], [1404591000000, 398],
    [1414592000000, 480], [1424593000000, 374], [1434594000000, 800],
    [1444595000000, 1100], [1454596000000, 1000], [1464597000000, 400]
  ];
 
  var data = [{
    label: "Vendas",
    data: data1,
    bars: {
      show: true,
      lineWidth: 0,
      barWidth: 30 * 60 * 60 * 1000 * 80,
      fillColor: { colors: [ { opacity: 1 }, { opacity: 1 } ] }
    }
  },{
    label: "Orçamentos",
    data: data2,
    lines: {
      show: true,
      lineWidth: 2,
      fillColor: { colors: [ { opacity: 1 }, { opacity: 1 } ] }
    },
    points:{
      show:true,
      radius: 5,
      fill: true,
      fillColor: "#ffffff",
      lineWidth: 2
    }
  }];
 
  var options = {
    series: {
    shadowSize: 0,
    bars: {
      lineWidth: 2,
      fillColor: { colors: [ { opacity: 1 }, { opacity: 1 } ] }
    }
  },
  grid: {
    hoverable: true,
    clickable: false,
    borderWidth: 1,
    tickColor: $border_color,
    borderColor: $grid_color,
  },
  legend:{   
    show: true,
    position: 'nw',
    noColumns: 0,
  },
  tooltip: true,
  tooltipOpts: {
    content: '%x: %y'
  },

  xaxis: {mode: "time", ticks:3, tickDecimals: 0},
  yaxis: {ticks:3, tickDecimals: 0},

  colors: ['#0084B4', '#666666', '#333333', '#999999', '#CCCCCC'],
};
 
  var plot = $.plot($("#monthlyRevenueGrowth"), data, options);  
});

// Monthly Expenses & Cancellations
$(function () {    
  var data3 = [
    [1354586000000, 30], [1364587000000, 60], [1374588000000, 90],
    [1384589000000, 200], [1394590000000, 240], [1404591000000, 280],
    [1414592000000, 300], [1424593000000, 430], [1434594000000, 420],
    [1444595000000, 1030], [1454596000000, 1460], [1464597000000, 1664]
  ];

  var data4 = [
    [1354586000000, 20], [1364587000000, 20], [1374588000000, 40],
    [1384589000000, 60], [1394590000000, 200], [1404591000000, 80],
    [1414592000000, 30], [1424593000000, 10], [1434594000000, 10],
    [1444595000000, 290], [1454596000000, 1040], [1464597000000, 1300]
  ];
 
  var data = [{
    label: "Expenses",
    data: data3,
    bars: {
      show: true,
      lineWidth: 0,
      barWidth: 30 * 60 * 60 * 1000 * 80,
      fillColor: { colors: [ { opacity: 1 }, { opacity: 1 } ] }
    }
  },{
    label: "Cancelamentos",
    data: data4,
    lines: {
      show: true,
      lineWidth: 2,
      fillColor: { colors: [ { opacity: 1 }, { opacity: 1 } ] }
    },
    points:{
      show:true,
      radius: 5,
      fill: true,
      fillColor: "#ffffff",
      lineWidth: 2
    }
  }];
 
  var options = {
    series: {
    shadowSize: 0,
    bars: {
      lineWidth: 2,
      fillColor: { colors: [ { opacity: 1 }, { opacity: 1 } ] }
    }
  },
  grid: {
    hoverable: true,
    clickable: false,
    borderWidth: 1,
    tickColor: $border_color,
    borderColor: $grid_color,
  },
  legend:{   
    show: true,
    position: 'nw',
    noColumns: 0,
  },
  tooltip: true,
  tooltipOpts: {
    content: '%x: %y'
  },

  xaxis: {mode: "time", ticks:3, tickDecimals: 0},
  yaxis: {ticks:3, tickDecimals: 0},

  colors: ['#e1e8ed', '#666666', '#999999', '#666666', '#CCCCCC'],
};
 
  var plot = $.plot($("#monthlyExpensesCancellations"), data, options);  
});


// Donut Chart
$(function () {

  var data, chartOptions;
  
  data = [
    { label: "Mobile", data: Math.floor (Math.random() * 100 + 350) }, 
    { label: "Desktop", data: Math.floor (Math.random() * 100 + 190) }, 
  ];

  chartOptions = {        
    series: {
      pie: {
        show: true,  
        innerRadius: .4, 
        stroke: {
          width: 0,
        }
      }
    }, 
    shadowSize: 0,
    legend: {
      show: false,
    },
    
    tooltip: true,

    tooltipOpts: {
      content: '%s: %y'
    },
    
    grid:{
      hoverable: true,
      clickable: false,
      borderWidth: 1,
      tickColor: $border_color,
      borderColor: $grid_color,
    },
    shadowSize: 0,
    colors: ['#5cb85c', '#058DC7', '#999999', '#CCCCCC'],
  };

  var holder = $('#mobVsDesk');

  if (holder.length) {
    $.plot(holder, data, chartOptions );
  } 
});


// Session
$(function () {
    
  var d1, data, chartOptions;

  var d1 = [[1262304000000, 6], [1264982400000, 3057], [1267401600000, 20434], [1270080000000, 31982], [1272672000000, 26602], [1275350400000, 27826], [1277942400000, 24302], [1280620800000, 24237], [1283299200000, 21004], [1285891200000, 12144], [1288569600000, 10577], [1291161600000, 10295]];

  data = [{ 
    label: "Sessões", 
    data: d1
  }];

  chartOptions = {
    xaxis: {
      min: (new Date(2009, 12, 1)).getTime(),
      max: (new Date(2010, 11, 2)).getTime(),
      mode: "tempo",
      tickSize: [1, "mês"],
      monthNames: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
      tickLength: 0
    },
    yaxis: {

    },
    series: {
      lines: {
        show: true, 
        fill: true,
        fill: 0.1,
        lineWidth: 2
      },
      points: {
        show: true,
        radius: 5,
        fill: true,
        fillColor: "#ffffff",
        lineWidth: 2,
      }
    },
    grid:{
      hoverable: true,
      clickable: false,
      borderWidth: 0,
      tickColor: "#eee",
      borderColor: "#ccc",
    },
    legend: {
      show: true,
      position: 'nw'
    },
    tooltip: true,
    tooltipOpts: {
      content: '%s: %y'
    },
    shadowSize: 0,
    colors: ['#058DC7', '#666666', '#333333', '#CCCCCC'],
  };

  var holder = $('#area-chart');

  if (holder.length) {
    $.plot(holder, data, chartOptions);
  }
});

// Vertical Chart
$(function () {

  var d1, d2, data, chartOptions;

  d1 = [
    [1325376000000, 1200], [1328054400000, 700], [1330560000000, 1000], [1333238400000, 600],
    [1335830400000, 350]
  ];

  d2 = [
    [1325376000000, 800], [1328054400000, 1200], [1330560000000, 600], [1333238400000, 250],
    [1335830400000, 300]
  ];

  data = [{
    label: 'Homem',
    data: d1
  },{
    label: 'Mulher',
    data: d2
  }];

  chartOptions = {
    xaxis: {
      min: (new Date(2011, 11, 15)).getTime(),
      max: (new Date(2012, 04, 18)).getTime(),
      mode: "tempo",
      tickSize: [2, "mês"],
      monthNames: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
      tickLength: 0
    },
    grid:{
      hoverable: true,
      clickable: false,
      borderWidth: 1,
      tickColor: $border_color,
      borderColor: $grid_color,
    },
    bars: {
      show: true,
      barWidth: 24*24*60*60*300,
      fill: true,
      lineWidth: 1,
      order: true,
      lineWidth: 0,
      fillColor: { colors: [ { opacity: 1 }, { opacity: 1 } ] }
    },
    shadowSize: 0,
    tooltip: true,
    tooltipOpts: {
      content: '%s: %y'
    },
    colors: ['#058DC7', '#f782aa'],
  }

  var holder = $('#mob-desktop');

  if (holder.length) {
    $.plot(holder, data, chartOptions );
  }

});



//Datepicker
$(function() {
  $("#datepicker" ).datepicker();
});

// Appointments
$( "ul.appointments li" ).click(function() {
  $(this).css('text-decoration', 'line-through');
});
