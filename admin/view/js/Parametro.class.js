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
if (typeof devem.parametro == 'undefined') { devem.parametro = new Object(); }

//# Decladração das funções dentro do objeto criado
devem.parametro = {

    register: function (){

        devem.parametro.init();

    },

    init: function(){

        $("#bt_novo_parametro").click(function(){

            $.fancybox({
                'type': 'ajax',
                'href': devem.core.defaults.url('configura/parametroNovo', null, true)

            });

        });

        $("#bt_salvar_parametros").click(function(){

            var bt = 'Confirmar';
            var bt_acao = 'devem.parametro.parametroSalvar();';
            var titulo = 'Salvar Parâmetros';
            var texto = 'Realmente deseja ataulizar a sua lista de paramêtros?';

            $.fancybox({
                'type': 'ajax',
                'href': devem.core.defaults.url('principal/confirma?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt+'&acao_bt='+bt_acao, null, true)

            });

        });

        $(".excluir-parametro").click(function(){

            var bt = 'Confirmar';
            var bt_acao = 'devem.parametro.excluirParametro('+$(this).attr('opt-id')+');';
            var titulo = 'Excluir Parâmetro';
            var texto = 'Realmente deseja excluir este parametro? Lembre-se que ele pode estar sendo utilizado em qualquer parte do sistema';

            $.fancybox({
                'type': 'ajax',
                'href': devem.core.defaults.url('principal/confirma?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt+'&acao_bt='+bt_acao, null, true)

            });

        });

    },

    gravar: function(){

      var val = true;
      var campos = [];

      $('#form_parametro_novo .form-devem-rec').each(function(){

          if($(this).val() == ''){

              campos.push($(this).attr('id'));

              val = false;
              
          }

      });

      if(val !== false){

          $.post(devem.core.defaults.url("configura/parametroGrava", null, true), $("#form_parametro_novo").serialize() ,function(data){

            if(data){

              var bt = 'Ok';
              var titulo = 'Gravar Parâmetro';
              var texto = 'O parametro foi inserido com sucesso.';
              var acao = 'location.reload();'; 

              $.fancybox({
                  'type': 'ajax',
                  'href': devem.core.defaults.url('principal/alerta/?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt+'&acao_bt='+acao, null, true),
                  'padding': 0

              });

            }else{

              var bt = 'Ok';
              var titulo = 'Gravar Parâmetro';
              var texto = 'Ocorreu um erro ao gravar o parâmetros, verifique as suas permissões e tente novamente, ou entre em contato com o administrador do sistema';

              $.fancybox({
                  'type': 'ajax',
                  'href': devem.core.defaults.url('login/alerta/?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt, null, true),
                  'padding': 0

              });

            }

          });

      }else{

          devem.core.tratamentoerro.formcamposComErro(campos);

      }

      

    },

    parametroSalvar: function(id){

      $.post(devem.core.defaults.url("configura/parametroSalvar", null, true), $("#form_parametro").serialize() ,function(data){

        if(data){

          var bt = 'Ok';
          var titulo = 'Salvar Parâmetro';
          var texto = 'Sua lista de parâmetros foi atualizada com sucesso.';
          var acao = 'location.reload();'; 

          $.fancybox({
              'type': 'ajax',
              'href': devem.core.defaults.url('principal/alerta/?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt+'&acao_bt='+acao, null, true),
              'padding': 0

          });

        }else{

          var bt = 'Ok';
          var titulo = 'Salvar Parâmetro';
          var texto = 'Ocorreu um erro ao atualizar a sua lista de parâmetros, verifique as suas permissões e tente novamente, ou entre em contato com o administrador do sistema';

          $.fancybox({
              'type': 'ajax',
              'href': devem.core.defaults.url('login/alerta/?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt, null, true),
              'padding': 0

          });

        }

      });

    },

    excluirParametro: function(id){

      $.post(devem.core.defaults.url("configura/parametroExcluir", null, true), {id:id},function(data){

        if(data){

          var bt = 'Ok';
          var titulo = 'Excluir Parâmetro';
          var texto = 'O parâmetro foi excluido com sucesso.';
          var acao = 'location.reload();'; 

          $.fancybox({
              'type': 'ajax',
              'href': devem.core.defaults.url('principal/alerta/?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt+'&acao_bt='+acao, null, true),
              'padding': 0

          });

        }else{

          var bt = 'Ok';
          var titulo = 'Excluir Parâmetro';
          var texto = 'Ocorreu um erro ao excluir o parâmetro, verifique as suas permissões e tente novamente, ou entre em contato com o administrador do sistema';

          $.fancybox({
              'type': 'ajax',
              'href': devem.core.defaults.url('login/alerta/?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt, null, true),
              'padding': 0

          });

        }

      });

    }

};

//# Chama a função de registro depois que terminar de ler o documento
$(document).ready(devem.parametro.register);