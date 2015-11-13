$(document).ready(function () {
  drawChart1();
  drawChart2();
  drawChart3();
  drawChart4();
})

function drawChart1() {
  jQuery('#russia').vectorMap({
    map: 'russia_en',
    backgroundColor: '#CBDBE4',
    color: '#ffffff',
    hoverOpacity: 0.7,
    selectedColor: '#999999',
    enableZoom: true,
    showTooltip: true,
    values: sample_data,
    scaleColors: ['#ffffff'],
    normalizeFunction: 'polynomial'
  });
};


function drawChart2() {
  jQuery('#usa').vectorMap({
    map: 'usa_en',
    backgroundColor: '#CBDBE4',
    color: '#ffffff',
    hoverOpacity: 0.7,
    selectedColor: '#e9854f',
    enableZoom: true,
    showTooltip: true,
    selectedRegion: 'MO'
  });
};


function drawChart3() {
  jQuery('#world').vectorMap({
    map: 'world_en',
    backgroundColor: '#CBDBE4',
    color: '#ffffff',
    hoverOpacity: 0.7,
    selectedColor: '#e9854f',
    enableZoom: true,
    showTooltip: true,
    values: sample_data,
    scaleColors: ['#ffffff'],
    normalizeFunction: 'polynomial'
  });
};

function drawChart4() {
  jQuery('#germany').vectorMap({
    map: 'germany_en',
    backgroundColor: '#CBDBE4',
    color: '#fff',
    hoverOpacity: 0.7,
    selectedColor: '#e9854f',
    onRegionClick: function(element, code, region){
    var message = 'You clicked "'
    + region 
    + '" which has the code: '
    + code.toUpperCase();
      alert(message);
    }
  });
};



//Resize charts and graphs on window resize
$(document).ready(function () {
  $(window).resize(function(){
    drawChart1();
    drawChart2();
    drawChart3();
    drawChart4();
  });
});
