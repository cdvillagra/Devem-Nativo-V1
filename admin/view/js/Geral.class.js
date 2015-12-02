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
if (typeof devem.geral == 'undefined') { devem.geral = new Object(); }

//# Decladração das funções dentro do objeto criado
devem.geral = {

    register: function (){

        devem.geral.init();

    },

    init: function(){

        $("#bt-copy").click(function(){

            // console.log($(this).attr('opt-id')).val());

            // window.prompt("Copy to clipboard: Ctrl+C, Enter", $('#'.$(this).attr('opt-id')).val());

        });

        devem.geral.initBtAdd();

        $(".bt_addProduto").click(function(){

          devem.geral.addProdutoPedido($(this).attr('opt-idprod'),1,true,$(this).attr('opt-prod'));

        });

    },

    fechaPedido: function(){

        devem.geral.displayLoader();

        $.post(devem.core.defaults.url("pedido/desistePedido", null, true),function(data){

            $.fancybox.close();

            location.reload();

        });

    },

    initBtAdd: function(){

        $(".carrinho div table td i").unbind('click').click(function(){

            var val_ant;      
            var val_atu;     
            var ac;     

            if($(this).hasClass('fa-minus')) {

                val_ant = parseInt($(this).next('span').html());    
                val_atu = (val_ant - 1);
                ac = 0;

                $(this).next('span').html(val_atu);
              
            }else{

                val_ant = parseInt($(this).prev().html());      
                val_atu = (val_ant + 1);
                ac = 1;

                $(this).prev().html(val_atu);

            }

          devem.geral.addProdutoPedido($(this).parent().attr('opt-prod'), ac);
          
        });

        $("#bt_excluir_pedido").unbind('click').click(function(){

            var bt = 'Confirmar';
            var bt_acao = 'devem.geral.fechaPedido();';
            var titulo = 'Desistir do Pedido';
            var texto = 'Realmente deseja desistir desse pedido?';

            $.fancybox({
                'type': 'ajax',
                'href': devem.core.defaults.url('principal/confirma?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt+'&acao_bt='+bt_acao, null, true)

            });
        });

        $("#br_finaliza_pedido").unbind('click').click(function(){

            $.fancybox({
                'type': 'ajax',
                'href': devem.core.defaults.url('pedido/confirma')

            });
            
        });

    },

    addProdutoPedido: function(id, ac, re, desc){

        if(typeof ac == 'undefined') ac = 1;

        if(typeof re == 'undefined') re = false;

        if(typeof desc == 'undefined') desc = null;

        $.post(devem.core.defaults.url("pedido/addProduto", null, true),{produto:id,ac:ac,desc:desc},function(data){

            if(ac){

                $(".carrinho").fadeIn();

                $(".carrinho div table tbody tr").each(function(){
                    $(this).remove();
                }); 

                $.each(data.produtos, function(i,k){

                    $(".carrinho div table tbody").append('<tr>'+
                                                              '<td>'+k.produto+'</td>'+
                                                              '<td>'+k.desc+'</td>'+
                                                              '<td opt-prod="'+k.produto+'"><i class="fa fa-minus"></i><span>'+k.quantidade+'</span><i class="fa fa-plus"></i></td>'+
                                                            '</tr>')

                });

                devem.geral.initBtAdd();

            }
                
              
        });

    },

    deslogar: function(){

        $.post('principal/deslogar',function(){

            window.location.href = devem.core.defaults.url('login', null, true);

        });

    },

    displayLoader: function(){

        $(".mask").toggle();
        $("#loader").toggle();

    }

};

//# Chama a função de registro depois que terminar de ler o documento
$(document).ready(devem.geral.register);