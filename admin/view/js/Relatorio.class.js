/* 
-------------------------------------------------------------------- 
DEVEM License, versão 1.0 [Nativo]
Copyright (c) 2015 DVillagra. All rights reserved.
--------------------------------------------------------------------

Algumas observações de uso da framework:

  1. O uso de métodos e funções nativas da framework, requer um certo
     conhecimento mínimo de programação e lógica, com enfase em orientação
     a objeto e conhecimento em arquitetura MVC.
 
  2. Como sugestão, ao realizar alterações em quaquer arquivo do path Core
     o desenvolvedor deverá executar a sua implementação de forma generica
     para que em qualquer parte do sistema que utilizar o bloco implementado
     se comporte da forma esperada.

  3. Qualquer comunicação que o terceiro precisar realizar com a equipe
     de desenvolvimento ou qualquer outra equipe da DVILLAGRA, terá que
     ser realizada via formulário através da seguinte URL:
     <http://www.dvillagra.com.br/contato>".

ESTE SOFTWARE É FORNECIDO PELA EQUIPE DE DESENVOLVIMENTO DA DVILLAGRA
E POR SER UM SOFTWARE OPENSOURCE, NÃO GARANTE QUALQUER FUNCIONAMENTO
DA APLICAÇÃO DESENVOLVIDA PELO TERCEIRO, EM QUALQUER CIRCUNSTANCIA.
A CONTRIBUIÇÃO [IMPLEMENTAÇÃO] COM A FRAMEWORK É SEMPRE BEM VINDA, 
PORTANTO O TERCEIRO PODERÁ ENVIAR SUA CONTRIBUIÇÃO SEMPRE QUE QUISER
PARA QUE A EQUIPE DE HOMOLOGAÇÃO ANALISE E APROVE/REPROVE. EM CASO DE
APROVAÇÃO A CONTRIBUIÇÃO SERÁ INCLUIDA COMO PATCH VERSION. QUALQUER 
OUTRA INCLUSÃO DE SERVIDOR SERÁ REALIZADA PELA EQUIPE DE DESENVOLVIMENTO
DA DVILLAGRA, ONDE ALTERAÇÕES GERAIS HOMOLOGADAS SERÃO INSERIDAS COMO 
MINOR VERSION E FECHAMENTOS DE VERSÃO SERÁ INSERIDA COMO MAJOR VERSION.
--------------------------------------------------------------------
*/

//# Cria objeto primario caso não exista
if (typeof devem == 'undefined') { devem = new Object(); }

//# Cria objeto secundário relacionado à classe quando não existir
if (typeof devem.relatorio == 'undefined') { devem.relatorio = new Object(); }

//# Decladração das funções dentro do objeto criado
devem.relatorio = {

    register: function (){

        devem.relatorio.init();

    },

    init: function(){

        if(devem.core.verificadorpagina.validaGetVar('acao', 'ganho'))
          devem.relatorio.initGanho();

          devem.relatorio.initializeFlot();

    },

    initGanho: function(){

      // Line Chart

      var bars = false;
      var lines = true;
      var pie = false;

      
  
  // Combined flot chart 
      var d1 = [['JAN', 150], ['FEB', 181], ['Mar', 252], ['APR', 356],['MAY', 851], ['JUN', 1589], ['JUL', 951], ['AUG', 651],['SEP', 591], ['OCT', 382], ['NOV', 951], ['DEC', 741]];
      var d2 = [['JAN', 145], ['FEB', 178], ['Mar', 200], ['APR', 350],['MAY', 212], ['JUN', 486], ['JUL', 841], ['AUG', 546],['SEP', 571], ['OCT', 300], ['NOV', 854], ['DEC', 685]];
      $.plot('#combined-chart', [
      {
        label: 'Last Year',
        data: d1,
        bars: { 
          show: true, 
          barWidth:  0.5, 
          fill:  1, 
          align: 'center'  
        }
      },
      {
        label: 'This Year',
        data: d2,
        lines: { 
          show: true,
          lineWidth: 3
        }
      }],
      {
        colors: ['#418bca' ,'#22beef'],
        xaxis: { 
          mode: 'categories',
          tickLength: 0,
          font :{
            lineHeight: 24,
            weight: '300',
            color: 'rgba(255,255,255,.8)',
            size: 14
          } 
        },
        yaxis: { 
          tickColor: 'rgba(255,255,255,.2)' ,
          tickFormatter: function number(x) {  var num; if (x >= 1000) { num=(x/1000)+'k'; }else{ num=x; } return num; },
          font :{
            lineHeight: 13,
            weight: '300',
            color: 'rgba(255,255,255,.8)'
          }
        },  
        grid: { 
          borderWidth: {
            top: 0,
            right: 0, 
            bottom: 1, 
            left: 1
          },
          margin: 13,
          labelMargin:20,
          hoverable: true,
          clickable: true,
          mouseActiveRadius:6,
          color : 'rgba(255,255,255,.2)' 
        },
        legend: { show: true },
        tooltip: true
      });

      $("#combined-chart div.legend >div").css("background", "transparent");
      $("#combined-chart div.legend table").css("color", "rgba(255,255,255,.8)");

      // tooltips showing
      $('#combined-chart').bind("plothover", function (event, pos, item) {
        if (item) {
          var x = item.datapoint[0],
              y = item.datapoint[1];
          $("#flotTip").css({top: item.pageY-30});
        } else {
          $("#flotTip").hide();
        }
      });
      
    },

    initializeFlot: function(){
        
      var el = $('table.flot-chart');

      el.each(function(){
        var data = $(this).data();
        var colors = [];
        var gridColor = data.tickColor || 'rgba(0,0,0,.1)';

        $(this).find('thead th:not(:first)').each(function() {
          colors.push($(this).css('color'));
        });

        if(data.type){
          bars = data.type.indexOf('bars') != -1;
          lines = data.type.indexOf('lines') != -1;
          pie = data.type.indexOf('pie') != -1;
        }

        $(this).graphTable({
          series: 'columns',
          position: 'replace',
          colors: colors,
          width: data.width,
          height: data.height
        },
        {
          series: { 
            stack: data.stack,
            pie: {
              show: pie,
              innerRadius: data.innerRadius || 0,
              label:{ 
                show: data.pieLabel=='show' ? true:false
              }
            },
            bars: {
              show: bars,
              barWidth: data.barWidth || 0.5,
              fill: data.fill || 1,
              align: 'center'
            },
            lines: { 
              show: lines,
              fill: 0.1,
              lineWidth: 3
            },
            shadowSize: 0,
            points: {
              radius: 4
            }
          },
          xaxis: {
            mode: 'categories',
            tickLength: 0,
            font :{
              lineHeight: 24,
              weight: '300',
              color: data.fontColor,
              size: 14
            } 
          },
          yaxis: { 
            tickColor: gridColor,
            tickFormatter: function number(x) {  var num; if (x >= 1000) { num=(x/1000)+'k'; }else{ num=x; } return num; },
            max: data.yMax,
            font :{
              lineHeight: 13,
              weight: '300',
              color: data.fontColor
            }
          },  
          grid: { 
            borderWidth: {
              top: 0,
              right: 0,
              bottom: 1,
              left: 1
            },
            borderColor: gridColor,
            margin: 13,
            minBorderMargin:0,              
            labelMargin:20,
            hoverable: true,
            clickable: true,
            mouseActiveRadius:6
          },
          legend: { show: data.legend=='show' ? true:false },
          tooltip: data.toolTip=='show' ? true:false,
          tooltipOpts: { content: (pie ? '%p.0%, %s':'<b>%s</b> :  %y') }
        });
      });

      // tooltips showing
      $('.flot-graph').bind("plothover", function (event, pos, item) {
        if (item) {
          var x = item.datapoint[0],
              y = item.datapoint[1];
          $("#flotTip").css({top: item.pageY-30});
        } else {
          $("#flotTip").hide();
        }
      });
      
    },

};

//# Chama a função de registro depois que terminar de ler o documento
$(document).ready(devem.relatorio.register);