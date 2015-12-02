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
if (typeof devem.pedido == 'undefined') { devem.pedido = new Object(); }

//# Decladração das funções dentro do objeto criado
devem.pedido = {

    register: function (){

        devem.pedido.init();

    },

    init: function(){

        if(devem.core.verificadorpagina.validaGetVar('acao', 'consulta')){
          devem.pedido.initConsulta();
          devem.pedido.initConsulta2();
        }

    },

    initConsulta: function(){

      // Add custom class to pagination div
      $.fn.dataTableExt.oStdClasses.sPaging = 'dataTables_paginate paging_bootstrap paging_custom';

      $('div.dataTables_filter input').addClass('form-control');
      $('div.dataTables_length select').addClass('form-control');

      /******************************************************/
      /**************** DRILL DOWN DATATABLE ****************/
      /******************************************************/

      var anOpen = [];

      var oTable03 = $('#drillDownDataTablepedido').dataTable({
        "sDom":
          "R<'row'<'col-md-6'l><'col-md-6'f>r>"+
          "t"+
          "<'row'<'col-md-4 sm-center'i><'col-md-4'><'col-md-4 text-right sm-center'p>>",
        "oLanguage": {
          "sSearch": "",
          "oPaginate": {
                      "sNext": "Próximo",
                      "sPrevious": "Anterior"
                    },
          "sInfo": "Total de registros: _TOTAL_ (_START_ até _END_)",
          "sEmptyTable": "Você ainda não realizou nenhum pedido",
          "sLengthMenu": "_MENU_ por página"
          
        },
        "aoColumnDefs": [
          { 'bSortable': false, 'aTargets': [ "no-sort" ] }
        ],
        "aaSorting": [[ 1, "asc" ]],
        "bProcessing": true,
        "sAjaxSource": devem.core.defaults.url('pedido/meusPedidos'),
        "aoColumns": [
          {
            "mDataProp": null,
            "sClass": "control text-center",
            "sDefaultContent": '<a href="#"><i class="fa fa-plus"></i></a>'
          },
          { "mDataProp": "post_id" },
          { "mDataProp": "total" },
          { "mDataProp": "post_status" },
          { "mDataProp": "post_date" }
        ],
        "fnInitComplete": function(oSettings, json) { 
          $('.dataTables_filter input').attr("placeholder", "Buscar");
          if($("#drillDownDataTable_info").html() == 'Showing 0 to 0 of 0 entries')
            $("#drillDownDataTable_info").remove();
          $("#drillDownDataTablepedido_length label select").removeClass('form-control');
        }
      });

      $(document).on( 'click', '#drillDownDataTablepedido td.control', function () {
        var nTr = this.parentNode;
        var i = $.inArray( nTr, anOpen );

        $(anOpen).each( function () {
          if ( this !== nTr ) {
            $('td.control', this).click();
          }
        });
        
        if ( i === -1 ) {
          $('i', this).removeClass().addClass('fa fa-minus');
          $(this).parent().addClass('drilled');
          var nDetailsRow = oTable03.fnOpen( nTr, devem.pedido.fnFormatDetails(oTable03, nTr), 'details' );
          $('div.innerDetails', nDetailsRow).slideDown();
          anOpen.push( nTr );
        }
        else {
          $('i', this).removeClass().addClass('fa fa-plus');
          $(this).parent().removeClass('drilled');
          $('div.innerDetails', $(nTr).next()[0]).slideUp( function () {
            oTable03.fnClose( nTr );
            anOpen.splice( i, 1 );
          } );
        }

        return false;
      });

    },

    fnFormatDetails: function(oTable03, nTr){

      var oData = oTable03.fnGetData( nTr );
        var sOut =
          '<div class="innerDetails">'+
            '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
              '<tr><td>ID:</td><td>'+oData.post_id+'</td></tr>'+
              '<tr><td>Valor Total:</td><td>'+oData.total+'</td></tr>'+
              //'<tr><td>Produtos:</td><td>'+oData.produtos.each(function(w,k){})+'</td></tr>'+
              '<tr><td>Status:</td><td>'+oData.post_status+'</td></tr>'+
              '<tr><td>Data do Pedido:</td><td>'+oData.post_date+'</td></tr>'+
            '</table>'+
          '</div>';

          
        return sOut;
    },

    initConsulta2: function(){

      // Add custom class to pagination div
      $.fn.dataTableExt.oStdClasses.sPaging = 'dataTables_paginate paging_bootstrap paging_custom';

      $('div.dataTables_filter input').addClass('form-control');
      $('div.dataTables_length select').addClass('form-control');

      /******************************************************/
      /**************** DRILL DOWN DATATABLE ****************/
      /******************************************************/

      var anOpen = [];

      var oTable032 = $('#drillDownDataTablepedido2').dataTable({
        "sDom":
          "R<'row'<'col-md-6'l><'col-md-6'f>r>"+
          "t"+
          "<'row'<'col-md-4 sm-center'i><'col-md-4'><'col-md-4 text-right sm-center'p>>",
        "oLanguage": {
          "sSearch": "",
          "oPaginate": {
                      "sNext": "Próximo",
                      "sPrevious": "Anterior"
                    },
          "sInfo": "Total de registros: _TOTAL_ (_START_ até _END_)",
          "sEmptyTable": "Seus clientes ainda não realizaram nenhum pedido",
          "sLengthMenu": "_MENU_ por página"
          
        },
        "aoColumnDefs": [
          { 'bSortable': false, 'aTargets': [ "no-sort" ] }
        ],
        "aaSorting": [[ 1, "asc" ]],
        "bProcessing": true,
        "sAjaxSource": devem.core.defaults.url('pedido/pedidosCliente'),
        "aoColumns": [
          {
            "mDataProp": null,
            "sClass": "control text-center",
            "sDefaultContent": '<a href="#"><i class="fa fa-plus"></i></a>'
          },
          { "mDataProp": "post_id" },
          { "mDataProp": "user_login" },
          { "mDataProp": "order_value" },
          { "mDataProp": "post_status" },
          { "mDataProp": "post_date" }
        ],
        "fnInitComplete": function(oSettings, json) { 
          $('.dataTables_filter input').attr("placeholder", "Buscar");
          if($("#drillDownDataTable_info").html() == 'Showing 0 to 0 of 0 entries')
            $("#drillDownDataTable_info").remove();
        }
      });

      $(document).on( 'click', '#drillDownDataTablepedido2 td.control', function () {
        var nTr = this.parentNode;
        var i = $.inArray( nTr, anOpen );

        $(anOpen).each( function () {
          if ( this !== nTr ) {
            $('td.control', this).click();
          }
        });
        
        if ( i === -1 ) {
          $('i', this).removeClass().addClass('fa fa-minus');
          $(this).parent().addClass('drilled');
          var nDetailsRow = oTable032.fnOpen( nTr, devem.pedido.fnFormatDetails2(oTable032, nTr), 'details' );
          $('div.innerDetails', nDetailsRow).slideDown();
          anOpen.push( nTr );
        }
        else {
          $('i', this).removeClass().addClass('fa fa-plus');
          $(this).parent().removeClass('drilled');
          $('div.innerDetails', $(nTr).next()[0]).slideUp( function () {
            oTable032.fnClose( nTr );
            anOpen.splice( i, 1 );
          } );
        }

        return false;
      });

    },

    fnFormatDetails2: function(oTable032, nTr){

      var oData = oTable032.fnGetData( nTr );

      var sOut =
        '<div class="innerDetails">'+
          '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
            '<tr><td>ID:</td><td>'+oData.post_id+'</td></tr>'+
            '<tr><td>Cliente:</td><td>'+oData.user_login+'</td></tr>'+
            '<tr><td>Valor Total:</td><td>'+oData.order_value+'</td></tr>'+
            //'<tr><td>Produtos:</td><td>'+oData.produtos.each(function(w,k){}+'</td></tr>'+
            '<tr><td>Status:</td><td>'+(oData.post_status == 'wc-completed' ? 'Aprovado' : 'Pendente')+'</td></tr>'+
            '<tr><td>Data do Pedido:</td><td>'+oData.post_date+'</td></tr>'+
          '</table>'+
        '</div>';

        return sOut;

    },

    finalizaPedido: function(){

      var id = $("#id_user_pedido").val();

      $.fancybox.close();

      devem.geral.displayLoader();

      $.post(devem.core.defaults.url("pedido/finalizar"),{id:id},function(data){

        devem.geral.displayLoader();

          if(!data.validate){

            var bt = 'Ok';
            var titulo = 'Pedido Não Realizado';
            var texto = 'Ocorreu um erro no seu pedido. <br> Tente realizar novamente.';
            var acao = '';

          }else{

            var bt = 'Ok';
            var titulo = 'Pedido Realizado';
            var texto = 'Seu pedido foi realizado com sucesso.';
            var acao = 'location.reload();'; 

          }

          $.fancybox({
              'type': 'ajax',
              'href': devem.core.defaults.url('principal/alerta/?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt+'&acao_bt='+acao),
              'padding': 0

          });



      });

    }

};

//# Chama a função de registro depois que terminar de ler o documento
$(document).ready(devem.pedido.register);