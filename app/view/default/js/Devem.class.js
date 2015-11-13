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
if (typeof devem.devemApp == 'undefined') { devem.devemApp = new Object(); }

//# Decladração das funções dentro do objeto criado
devem.devemApp = {

    register: function (){

        devem.devemApp.init();

    },

    init: function(){

        var mg = ( ( $(window).height() / 2 ) - ( $('.content').height() / 2 ) );

        if(mg > 100)
            mg = 100;
      
        $('.content').css('margin-top',mg); 

        var settings = {
            url: devem.core.defaults.url("customer/testeUploadApi"),
            dragDrop: true,
            fileName: "file",
            returnType: "json",
            uploadButtonClass: "btUpload",
            maxFileSize: 2097152,
            allowedTypes: 'jpg,JPG,jpeg,JPEG,gif,GIF,png,PNG',
            onSuccess: function (files, data, xhr)
            {
               alert('O arquivo foi salvo na pasta media');
            }
        }
        var uploadObj = $("#uploadfile").uploadFile(settings);

        $('#bt_file').click(function () {

            $('.upload-arquivo form').last().find('input[type=file]').trigger('click');

        });


    },

};

//# Chama a função de registro depois que terminar de ler o documento
$(document).ready(devem.devemApp.register);