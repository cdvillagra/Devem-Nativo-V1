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
if (typeof devem.rendimento == 'undefined') { devem.rendimento = new Object(); }

//# Decladração das funções dentro do objeto criado
devem.rendimento = {

    register: function (){

        devem.rendimento.init();

    },

    init: function(){

      $("#bt_resgate").click(function(){

        devem.rendimento.resgatar();

      });

    },

    resgatar: function(){

      if($("#valor_resgate").val() > 0){

        devem.geral.displayLoader();

        $.post(devem.core.defaults.url("rendimento/resgatar"),{valor : $("#valor_resgate").val()}, function(data){

          devem.geral.displayLoader();

          if(!data.validate){

            var bt = 'Ok';
            var titulo = 'Resgate de rendimentos';
            var texto = 'Ocorreu um erro no seu resgate. <br> Verifique se o valor que você inseriu não é maior que o valor disponível.';
            var acao = '';

          }else{

            var bt = 'Ok';
            var titulo = 'Resgate de rendimentos';
            var texto = 'Sua solicitação de resgate foi enviada com sucesso, aguarde a confirmação por e-mail.';
            var acao = 'location.reload()'; 

          }

          $.fancybox({
              'type': 'ajax',
              'href': devem.core.defaults.url('principal/alerta/?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt+'&acao_bt='+acao),
              'padding': 0

          });

        },'json');


      }else{

          var bt = 'Ok';
          var titulo = 'Resgate de rendimentos';
          var texto = 'Preencha o valor de resgate.';

          $.fancybox({
              'type': 'ajax',
              'href': devem.core.defaults.url('principal/alerta/?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt),
              'padding': 0

          });

      }

    }

};

//# Chama a função de registro depois que terminar de ler o documento
$(document).ready(devem.rendimento.register);