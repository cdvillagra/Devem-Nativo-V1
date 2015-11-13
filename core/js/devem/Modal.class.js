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

if (typeof devem == 'undefined') { devem = new Object(); }
if (typeof devem.core == 'undefined') { devem.core = new Object(); }
if (typeof devem.core.modal == 'undefined') { devem.core.modal = new Object(); }

devem.core.modal = {
	registrar: function ()
	{
		devem.core.modal.inicializar();
	},
	
	inicializar: function()
	{
		
	},
	
	/*
	notificacao: function(div, time, width){
		$.blockUI({ 
            message: $(div), 
            fadeIn: 700, 
            fadeOut: 700, 
            timeout: time, 
            showOverlay: false, 
            centerY: false, 
            baseZ: 1000,
            css: { 
                width: width, 
                top: '10px', 
                left: '', 
                right: '10px', 
                border: 'none', 
                padding: '5px', 
                backgroundColor: '#000', 
                '-webkit-border-radius': '10px', 
                '-moz-border-radius': '10px', 
                opacity: .6, 
                color: '#fff'
            }
        });
	},
	
	notificacaoCenter: function(div, time, width){
		$.blockUI({ 
            message: $(div), 
            fadeIn: 700, 
            fadeOut: 700, 
            timeout: time, 
            showOverlay: false, 
            centerY: false, 
            baseZ: 1000,
            css: { 
                width: width, 
                top: '10px',  
                border: 'none', 
                padding: '5px', 
                backgroundColor: '#000', 
                '-webkit-border-radius': '10px', 
                '-moz-border-radius': '10px', 
                opacity: .6, 
                color: '#fff'
            }
        });
	},
	*/
	
	notificacaoCenter: function(div, time){
		
		$(div).css('position','fixed').css('top','0px').css('left','50%').css('margin-left','-222.5px');
		$(div).stop(false,true).slideToggle().delay(time).slideToggle();
	},
	
	openModal: function(div){
            
        $(document).trigger("fancybox-load");

		$(div).appendTo('body').fadeIn(700).modal();
		devem.core.modal.redimensionarModal();
	},
	
	redimensionarModal: function(){
		$.modal.resize();
	},
	
	closeModal: function(){
		$.modal.close();
	}
};

$.fn.center = function () {
    this.css("position","absolute");
    this.css("top", ( $(window).height() - this.height() ) / 2+$(window).scrollTop() + "px");
    this.css("left", ( $(window).width() - this.width() ) / 2+$(window).scrollLeft() + "px");
    return this;
}

$(document).ready(devem.core.modal.registrar);