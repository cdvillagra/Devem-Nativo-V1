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
if (typeof devem.install == 'undefined') { devem.install = new Object(); }

//# Decladração das funções dentro do objeto criado
devem.install = {

    register: function (){

        devem.install.init();

    },

    init: function(){

        var mg = ( ( $(window).height() / 2 ) - ( $('.content').height() / 2 ) );

        if(mg > 100)
            mg = 100;
      
		$('.content').css('margin-top',mg);  

        $('#bt-iniciar').click(function(){

            window.location.href = 'banco';

        });

        $('#db_no').click(function(){

            if($(this).is(':checked')){

                $('input[type="text"], input[type="password"]').prop('disabled', true);

            }else{

                $('input[type="text"], input[type="password"]').prop('disabled', false);

            }

        });

        $('#bt-testeDb').click(function(){

            devem.install.testDb();

        });

        $('#bt-avancar-p2').click(function(){

            devem.install.validaP2();

        });

        $('#bt-avancar-p3').click(function(){

            devem.install.validaP3();

        });

        $('#bt-avancar-p4').click(function(){

            devem.install.validaP4();

        });

        $("#bt-concluir").click(function(){

            window.location.href = 'http://'+window.location.hostname+'/instalacao-concluida';

        });

    },

    validaP2: function(){

        var validate = true;

        $('input.req').each(function(){

            if($(this).val() == '')
                validate = false;

        });

        if($('#db_no').is(':checked'))
            validate = true;

        if(validate){

            var msg = 'Aguarde';
            var bg = "orange";

            devem.install.alertMsg(msg, bg, true);

            $.post('controller/Install.controller.php',$('form').serialize(),function(data){

                if((data) || $('#db_no').is(':checked')){

                    if(typeof data.db_criar != 'undefined'){

                        msg = 'Conexão Ok, porém esta base não existe';
                        bg = "red";

                    }else{

                        $('#method').val('gravaSession');

                        $.post('controller/Install.controller.php',$('form').serialize(),function(){

                            window.location.href = 'parametros';

                        });

                    }

                }else{

                    msg = 'Uuups, erro na conexão com o seu banco';
                    bg = "red";

                    devem.install.alertMsg(msg, bg, false, true);

                }

            });

        }else{

            devem.install.alertMsg('Preencha os campos para avançar', 'red');

        }

    },

    validaP3: function(){

        if(confirm('Todos os dados de parametros poderão ser alterados no Admin, após a instalação.')){

            $.post('controller/Install.controller.php',$('form').serialize(),function(){

                window.location.href = 'login';

            });

        }
    },

    validaP4: function(){

        if(confirm('Confirma a instalação dos pré requisitos do Devem?')){

            $.post('controller/Install.controller.php',$('form').serialize(),function(){

                window.location.href = 'instalando';

            });

        }
        
    },

    instalar: function(){

        // $.post('controller/Install.controller.php',{method : 'installAdmin'},function(data){
        //     console.log(data);
        // },'json');

        setTimeout(function(){

            $('.txt_loader').text('Criando banco de dados');

            //criando banco de dados
            $.post('controller/Install.controller.php',{method : 'installBanco'},function(data){

                setTimeout(function(){

                    $('.txt_loader').text('Criando alguns arquivos do sistema');

                    //criando alguns arquivos do sistema
                    $.post('controller/Install.controller.php',{method : 'installArquivos'},function(data){

                        setTimeout(function(){

                            $('.txt_loader').text('Configurando os parametros');

                            //configurando parametros
                            $.post('controller/Install.controller.php',{method : 'installParametros'},function(data){

                                setTimeout(function(){

                                    $('.txt_loader').text('Configurando informações do administrador');

                                    //configurando informações do administrador
                                    $.post('controller/Install.controller.php',{method : 'installAdmin'},function(data){

                                        setTimeout(function(){

                                            $('.txt_loader').text('Finalizando');

                                            //configurando informações do administrador
                                            $.post('controller/Install.controller.php',{method : 'installFinish'},function(data){

                                                setTimeout(function(){

                                                    window.location.href = 'sucesso';
                                                    

                                                },4000);

                                            });
                                            

                                        },4000);

                                    });

                                },4000);

                            });

                        },4000);

                    });

                },4000);

            });

        },4000);
    },

    testDb: function(){

        var validate = true;

        $('input.req').each(function(){

            if($(this).val() == '')
                validate = false;

        });

        if(validate && !$('#db_no').is(':checked')){

            var msg = 'Aguarde';
            var bg = "orange";

            devem.install.alertMsg(msg, bg, true);

            $('#method').val('testeDb');

            $.post('controller/Install.controller.php',$('form').serialize(),function(data){

                var msg;
                var bg = "green";

                if(typeof data.db != 'undefined'){

                    msg = 'Conexão Ok, porém esta base não existe';
                    bg = "red";

                }else{

                    if(!data){
                        msg = 'Uuups, erro na conexão com o seu banco';
                        bg = "red";
                    }else{
                        msg = 'Ufa, Conexão Ok';
                    }

                }

                devem.install.alertMsg(msg, bg, false, true);

            });

        }else if($('#db_no').is(':checked')){

            devem.install.alertMsg('Ok, então você não precisará de banco de dados', 'orange');

        }else{

            devem.install.alertMsg('Preencha os campos para testar a conexão', 'red');

        }

    },

    alertMsg: function(msg, bg, add, remove){

        if(typeof add == 'undefined')
            var add = false;

        if(typeof remove == 'undefined')
            var remove = false;

        if((typeof msg != 'undefined') && (typeof bg != 'undefined'))
            $('.alert').css('background',bg).html(msg);

        if(!add && !remove)
            $('.alert').show("slide", { direction: "up" }, 400).delay(2000).hide("slide", { direction: "up" }, 400);

        if(add){
            $('.alert').show("slide", { direction: "up" }, 400);
            return false;
        }

        if(remove){
            $('.alert').delay(2000).hide("slide", { direction: "up" }, 400);
            return false;
        }

    }

};

//# Chama a função de registro depois que terminar de ler o documento
$(document).ready(devem.install.register);