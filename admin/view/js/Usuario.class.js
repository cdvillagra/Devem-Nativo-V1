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
if (typeof devem.usuario == 'undefined') { devem.usuario = new Object(); }

//# Decladração das funções dentro do objeto criado
devem.usuario = {

    register: function (){

        devem.usuario.init();

        devem.usuario.initConsulta();

    },

    init: function(){

        $("#bt_cadastrar").click(function(){

            devem.usuario.validaCadastro();

        });

    },

    validaCadastro: function(){

      var val = true;
      var campos = [];

      $('.form-devem-rec').each(function(){

          if($(this).val() == ''){

              campos.push($(this).attr('id'));

              val = false;
              
          }

      });

      if(!devem.core.validar.email($("#cd_email").val())){

        campos.push('cd_email');
        val = false;

      }

      if(val !== false){

          devem.usuario.cadastro();

      }else{

          devem.core.tratamentoerro.formcamposComErro(campos);

      }

    },

    cadastro: function(){

      devem.geral.displayLoader();

        $.post(devem.core.defaults.url("configura/cadastraUsuario", null, true), $("#form_cadastro").serialize(), function(data){

          devem.geral.displayLoader();

          if(!data){

                    var bt = 'Ok';
                    var titulo = 'Cadastro de Usuário';
                    var texto = 'Você não tem permissão executar este procedimento.';

                    $.fancybox({
                        'type': 'ajax',
                        'href': devem.core.defaults.url('principal/alerta?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt, null, true)

                    });

          }else{

              if(!data.erro){

                    var bt = 'Ok';
                    var titulo = 'Cadastro de Usuário';
                    var texto = 'Cadastro realizado com sucesso.';
                    var acao = 'location.reload();'; 

                    $.fancybox({
                        'type': 'ajax',
                        'href': devem.core.defaults.url('principal/alerta/?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt+'&acao_bt='+acao, null, true),
                        'padding': 0
                    });

              }else{

                    var bt = 'Ok';
                    var titulo = 'Cadastro de Usuário';
                    var texto = 'Este '+data.erro[0]+(data.erro.length > 1 ? ' e '+data.erro[1]: '')+' já est'+(data.erro.length > 1 ? 'ão': 'á')+' cadastrado'+(data.erro.length > 1 ? 's': '')+', tente algo diferente.';

                    $.fancybox({
                        'type': 'ajax',
                        'href': devem.core.defaults.url('principal/alerta?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt, null, true)

                    });

              }
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
        "sAjaxSource": devem.core.defaults.url('configura/listaUsuario', null, true),
        "aoColumns": [
          { "mDataProp": "idUsuario" },
          { "mDataProp": "auLogin" },
          { "mDataProp": "nivel" },
          { "mDataProp": "auNome" },
          { "mDataProp": "auEmail" },
          { "mDataProp": "auDataCadastro" }
        ],
        "fnInitComplete": function(oSettings, json) { 
          $('.dataTables_filter input').attr("placeholder", "Buscar");
          if($("#drillDownDataTable_info").html() == 'Showing 0 to 0 of 0 entries')
            $("#drillDownDataTable_info").remove();
        }
      });

    },

};

//# Chama a função de registro depois que terminar de ler o documento
$(document).ready(devem.usuario.register);