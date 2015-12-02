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
if (typeof devem.mensagem == 'undefined') { devem.mensagem = new Object(); }

//# Decladração das funções dentro do objeto criado
devem.mensagem = {

    register: function (){

        devem.mensagem.init();

    },

    init: function(){



        if(devem.core.verificadorpagina.validaGetVar('controle', 'mensagem')){

          //load wysiwyg editor
          $('#msg-box').summernote({
            toolbar: false,
            height: 161   //set editable area's height
          });
          
          devem.mensagem.initConsulta();

        }

        $('#bt_enviar_mensagem').click(function(){

            devem.mensagem.validaEnvio();

        });

        //multiselect input
      $(".chosen-select").chosen({disable_search_threshold: 10});

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

      var oTable03 = $('#drillDownDataTableMensagem').dataTable({
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
          "sEmptyTable": "Você não possui nenhuma mensagem",
          "sLengthMenu": "_MENU_ por página"
          
        },
        "aoColumnDefs": [
          { 'bSortable': false, 'aTargets': [ "no-sort" ] }
        ],
        "aaSorting": [[ 1, "asc" ]],
        "bProcessing": true,
        "sAjaxSource": devem.core.defaults.url('mensagem/listaMensagens'),
        "aoColumns": [
          {
            "mDataProp": null,
            "sClass": "control text-center",
            "sDefaultContent": '<a href="#"><i class="fa fa-plus"></i></a>'
          },
          { "mDataProp": "id" },
          { "mDataProp": "nome" },
          { "mDataProp": "assunto" },
          { "mDataProp": "data_envio" }
        ],
        "fnInitComplete": function(oSettings, json) { 
          $('.dataTables_filter input').attr("placeholder", "Buscar");
          if($("#drillDownDataTable_info").html() == 'Showing 0 to 0 of 0 entries')
            $("#drillDownDataTable_info").remove();
        }
      });

      $(document).on( 'click', '#drillDownDataTableMensagem td.control', function () {
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
          var nDetailsRow = oTable03.fnOpen( nTr, devem.mensagem.fnFormatDetails(oTable03, nTr), 'details' );
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
            '<tr><td>ID:</td><td>'+oData.id+'</td></tr>'+
            '<tr><td>Nome do Remetente:</td><td>'+oData.nome+'</td></tr>'+
            '<tr><td>Login do Remetente:</td><td>'+oData.usuario+'</td></tr>'+
            '<tr><td>Email do Remetente:</td><td>'+oData.email+'</td></tr>'+
            '<tr><td>Assunto:</td><td>'+oData.assunto+'</td></tr>'+
            '<tr><td>Mensagem:</td><td>'+oData.mensagem+'</td></tr>'+
            '<tr><td>Data de Envio:</td><td>'+oData.data_envio+'</td></tr>'+
          '</table>'+
        '</div>';
          
        return sOut;
        
    },

    validaEnvio: function(){

        $('#msg-box').next().find('div').each(function(){
  
          if($(this).attr('contenteditable') == 'true')
            $('#msg_msgn').val($(this).html());
          
          
        });

        var validate = true;

        $('#form_mensagem .cp_msg').each(function(){

            if($(this).val() == '')
                validate = false;

        });

        if($('#msg_dest').val() === null)
            validate = false;

        if(validate !== false){

            devem.mensagem.enviar();

        }else{

            var bt = 'Ok';
            var titulo = 'Envio de Mensagem';
            var texto = 'Preencha todos os campos do formulário para enviar a mensagem.';

            $.fancybox({
                'type': 'ajax',
                'href': devem.core.defaults.url('principal/alerta/?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt),
                'padding': 0

            });

        }

    },

    enviar: function(){

        devem.geral.displayLoader();

        $.post('mensagem/cadastrar', $('#form_mensagem').serialize(), function(data){

            devem.geral.displayLoader();

            $('#form_mensagem input').val('');

            $('#msg_msgn').val('');

            $('#msg_dest').val('');

            $('#msg-box').next().find('div').each(function(){
              
              $(this).html('');
              
            });

            $('.search-choice-close').each(function(){
               
              $(this).trigger('click');
              
            });

            var bt = 'Ok';
            var titulo = 'Envio de Mensagem';
            var texto = 'Seu envio foi realizado com sucesso.';

            $.fancybox({
                'type': 'ajax',
                'href': devem.core.defaults.url('principal/alerta/?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt),
                'padding': 0

            });

        }, 'json');

    }

};

//# Chama a função de registro depois que terminar de ler o documento
$(document).ready(devem.mensagem.register);