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
if (typeof devem.login == 'undefined') { devem.login = new Object(); }

//# Decladração das funções dentro do objeto criado
devem.login = {

    register: function (){

        devem.login.init();

    },

    init: function(){



        $('#lg_senha').keypress(function(e){
            
            if(e.which == 13)
                devem.login.btAcao();

        })

        $('#bt_login').click(function() {

            devem.login.btAcao();
            

        });

        $('#bt_esqueci').click(function() {

            var email = $('#es_email').val();

            if((email != '') && (email.length > 4)){

                devem.login.esqueciSenha();

            }else{

                var arr = ['es_email'];
                devem.core.tratamentoerro.formcamposComErro(arr);

            }

        });

        $('#bt_retorna').click(function() {

            window.location.href = devem.core.defaults.url('login',null,true);

        });

        $('#bt_redefinir').click(function() {

            var val = true;
            var campos = [];

            if(
                (($('#rd_pass').val() == '') || ($('#rd_pass').val().length < 8)) ||
                (($('#rd_pass_confirm').val() == '') || ($('#rd_pass_confirm').val().length < 8)) ||
                ($('#rd_pass').val() != $('#rd_pass_confirm').val())
                ){

                campos.push('rd_pass');
                campos.push('rd_pass_confirm');

                val = false;
            }

            console.log(campos);
            if(val !== false){

                devem.login.redefinir();

            }else{

                devem.core.tratamentoerro.formcamposComErro(campos);

            }

        });

    },

    btAcao: function(){

        var val = true;
        var campos = [];

        if(($('#lg_usuario').val() == '') || ($('#lg_usuario').val().length < 5)){

            campos.push('lg_usuario');

            val = false;
            
        }

        if(($('#lg_senha').val() == '') || ($('#lg_senha').val().length < 6)){

            campos.push('lg_senha');

            val = false;
            
        }

        console.log(campos);

        if(val !== false){

            devem.login.validaLogin();

        }else{

            devem.core.tratamentoerro.formcamposComErro(campos);

        }

    },

    redefinir: function(){

        devem.geral.displayLoader();

        $.post(devem.core.defaults.url("login/redefinir", null, true), $("#form_redefinir").serialize(), function(data){
            
            devem.geral.displayLoader();

            if(data){

                window.location.href = devem.core.defaults.url('',null,true);

            }else{

                var bt = 'Ok';
                var titulo = 'Redefinição de senha';
                var texto = 'Ocorreu um erro na redefinição do seu e-mail, solicite a redefinição novamente ou entre em contato com o administrador do sistema';

                $.fancybox({
                    'type': 'ajax',
                    'href': devem.core.defaults.url('login/alerta/?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt, null, true),
                    'padding': 0

                });
                
            }

        },'json');

    },

    esqueciSenha: function(){

        devem.geral.displayLoader();

        $.post(devem.core.defaults.url("login/enviarSenha", null, true), $("#form_esqueci").serialize(), function(data){

            devem.geral.displayLoader();

            if(data){

                window.location.href = devem.core.defaults.url('login/esqueciConfirmacao', null, true);

            }else{

                var bt = 'Ok';
                var titulo = 'Esqueci a minha senha';
                var texto = 'Não encontramos o seu cadastro, verifique os dados e tente novamente ou entre em contato com o administrador do sistema';

                $.fancybox({
                    'type': 'ajax',
                    'href': devem.core.defaults.url('login/alerta/?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt, null, true),
                    'padding': 0

                });
                
            }

        },'json');

    },

    validaLogin: function(){

        var dados_login = $('#form_login').serialize();

        devem.geral.displayLoader();

        $.post(devem.core.defaults.url("login/validar", null, true), dados_login, function(data){

            devem.geral.displayLoader();

            if(data){

                window.location.href = devem.core.defaults.url('', null, true);

            }else{

                var bt = 'Ok';
                var titulo = 'Login';
                var texto = 'Erro ao logar , verifique suas credênciais ou entre em contato com o administrador do sistema.';

                $.fancybox({
                    'type': 'ajax',
                    'href': devem.core.defaults.url('login/alerta?titulo='+encodeURI(titulo)+'&texto='+encodeURI(texto)+'&label_bt='+bt, null, true)

                });
                
                
            }

        },'json');

    },

};

//# Chama a função de registro depois que terminar de ler o documento
$(document).ready(devem.login.register);