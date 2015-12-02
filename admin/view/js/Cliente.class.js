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
if (typeof devem.cliente == 'undefined') { devem.cliente = new Object(); }

//# Decladração das funções dentro do objeto criado
devem.cliente = {

    register: function (){

        devem.cliente.init();

    },

    init: function(){

        if(devem.core.verificadorpagina.validaGetVar('controle', 'cliente'))
          devem.cliente.initConsulta();

        $('#bt_cadastrar').click(function() {

            var val = true;
            var campos = [];

            $('.form-devem-rec').each(function(){

                if($(this).val() == ''){

                    campos.push($(this).attr('id'));

                    val = false;
                    
                }

            });

            if(val !== false){

                devem.cliente.cadastro();

            }else{

                devem.core.tratamentoerro.formcamposComErro(campos);

            }

        });

    },

    cadastro: function(){

      devem.geral.displayLoader();

        $.post(devem.core.defaults.url("cliente/gravaCadastro"), $("#form_cadastro").serialize(), function(data){

          devem.geral.displayLoader();
          
            if(data.ativacao){

                if(!data.cli_loja){

                  var bt = 'Ok';
                  var titulo = 'Cadastro de Cliente';
                  var texto = 'Cliente cadastrado com sucesso. Será necessário uma ativação da conta, através de um e-mail enviado para o cliente.';
                  var acao = 'location.reload();'; 

                  $.fancybox({
                      'type': 'ajax',
                      'href': devem.core.defaults.url('principal/alerta/?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt+'&acao_bt='+acao),
                      'padding': 0

                  });
                }else{

                    var bt = 'Confirmar';
                    var bt_acao = 'devem.cliente.gravaCadastroAlteracao('+data.cli_loja+');';
                    var titulo = 'Ativação de cliente de Loja';
                    var texto = 'Notamos que você já comprou em nossa loja, e por isso, já possui um cadastro. E seus dados anteriores serão mantidos. <br />';
                    texto += 'Para ativar a sua conta de representante vinculada pressione "Confirmar". <br />';
                    texto += 'Caso contrario, realize um novo cadastros com dados diferentes do seu cadastro realizado na loja.';

                    $.fancybox({
                        'type': 'ajax',
                        'href': devem.core.defaults.url('principal/confirma?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt+'&acao_bt='+bt_acao)

                    });

                }
                
            }else{


                var bt = 'Ok';
                var titulo = 'Cadastro de Cliente';
                var texto = 'Ocorreu alguem erro ao realizar o seu cadastro, verifique seus dados ou entre em contato com o administrador do sistema.';

                $.fancybox({
                    'type': 'ajax',
                    'href': devem.core.defaults.url('principal/alerta?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt)

                });
                
            }

        },'json');

    },

    gravaCadastroAlteracao: function(id){

      devem.geral.displayLoader();

        $.post(devem.core.defaults.url("cliente/gravaCadastroAlteracao"), {id : id}, function(data){

          devem.geral.displayLoader();

            if(data){

                window.location.href = devem.core.defaults.url('login/cadastroConfirmacao');
                
            }else{


                var bt = 'Ok';
                var titulo = 'Cadastro';
                var texto = 'Ocorreu alguem erro ao realizar o seu cadastro, verifique seus dados ou entre em contato com o administrador do sistema.';

                $.fancybox({
                    'type': 'ajax',
                    'href': devem.core.defaults.url('principal/alerta?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt)

                });
                
            }

        },'json');

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

      var oTable03 = $('#drillDownDataTable').dataTable({
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
          "sEmptyTable": "Você não possui nenhum cliente",
          "sLengthMenu": "_MENU_ por página"
          
        },
        "aoColumnDefs": [
          { 'bSortable': false, 'aTargets': [ "no-sort" ] }
        ],
        "aaSorting": [[ 1, "asc" ]],
        "bProcessing": true,
        "sAjaxSource": devem.core.defaults.url('cliente/listaClientes'),
        "aoColumns": [
          {
            "mDataProp": null,
            "sClass": "control text-center",
            "sDefaultContent": '<a href="#"><i class="fa fa-plus"></i></a>'
          },
          { "mDataProp": "id" },
          { "mDataProp": "nome" },
          { "mDataProp": "posicao" },
          { "mDataProp": "reputacao" },
          { "mDataProp": "desempenho" },
          { "mDataProp": "data_registro" }
        ],
        "fnInitComplete": function(oSettings, json) { 
          $('.dataTables_filter input').attr("placeholder", "Buscar");
          if($("#drillDownDataTable_info").html() == 'Showing 0 to 0 of 0 entries')
            $("#drillDownDataTable_info").remove();
        }
      });

      $(document).on( 'click', '#drillDownDataTable td.control', function () {
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
          var nDetailsRow = oTable03.fnOpen( nTr, devem.cliente.fnFormatDetails(oTable03, nTr), 'details' );
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
            '<tr><td>Nome Completo:</td><td>'+oData.nome+'</td></tr>'+
            '<tr><td>Usuário:</td><td>'+oData.usuario+'</td></tr>'+
            '<tr><td>Email:</td><td>'+oData.email+'</td></tr>'+
            '<tr><td>Origem do cadastro:</td><td>'+oData.origem+'</td></tr>'+
            '<tr><td>Reputação:</td><td>'+oData.reputacao+'</td></tr>'+
            '<tr><td>Desempenho (%):</td><td>'+oData.desempenho+'</td></tr>'+
            '<tr><td>Posição no Ranking:</td><td>'+oData.posicao+'</td></tr>'+
            '<tr><td>Pedidos Aprovados:</td><td>'+oData.pedidos_aprovados+'</td></tr>'+
            '<tr><td>Pedidos Pendentes:</td><td>'+oData.pedidos_pendente+'</td></tr>'+
            '<tr><td>Data Registro:</td><td>'+oData.data_registro+'</td></tr>'+
          '</table>'+
        '</div>';

        return sOut;

    }

};

//# Chama a função de registro depois que terminar de ler o documento
$(document).ready(devem.cliente.register);