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
if (typeof devem.core.ajax == 'undefined') { devem.core.ajax = new Object(); }

devem.core.ajax = {
    registrar: function ()
    {
		devem.core.ajax.inicializar();
	},
	
	inicializar: function()
	{
		//devem.core.ajax.LerHistoricoNavegacao();
	},
	
	SalvaHistoricoNavegacao: function(historico)
	{
		window.location.hash = historico;
	},
	
	LerHistoricoNavegacao: function()
	{
		return window.location.hash.substring(1);
	},
	
	post: function(Url, IdObJform, IdRespContentDiv, ModoCarregar, Modal, optionSerialize)
	{	

		// var err = new Error(Url);
		// console.log(err.stack);

		if(typeof optionSerialize == 'undefined')
			optionSerialize = '';
		
		if(ModoCarregar == true){
			if(Modal == true){ devem.core.modal.openModal(IdRespContentDiv); }
			devem.core.ajax.inicializaCarregando(IdRespContentDiv);
		}
		$.post(Url,(typeof IdObJform == "string" ? $(IdObJform).serialize() + optionSerialize : IdObJform)).done(function( data ){
			if(ModoCarregar == true){
				devem.core.ajax.finalizaCarregando(IdRespContentDiv);
			}	
			if (IdRespContentDiv != '') { $(IdRespContentDiv).html(data); }
			if(Modal == true){ devem.core.modal.openModal(IdRespContentDiv); }
		})
		
		//devem.core.ajax.SalvaHistoricoNavegacao(devem.core.ajax.post(Url, IdObJform, IdRespContentDiv, ModoCarregar, Modal, optionSerialize));
	},
	
	get: function(json, Url,IdRespContentDiv, ModoCarregar, Modal){
		if(ModoCarregar == true){
			if(Modal == true){ devem.core.modal.openModal(IdRespContentDiv); }
			devem.core.ajax.inicializaCarregando(IdRespContentDiv);
		}
		$.ajax({
		  type: "GET",
		  url: Url,
		  data: json
		}).done(function(data) {
			if(ModoCarregar == true){
				devem.core.ajax.finalizaCarregando(IdRespContentDiv);
			}	
			$(IdRespContentDiv).html(data);
			if(Modal == true){ devem.core.modal.openModal(IdRespContentDiv); }
		});
		
		//devem.core.ajax.SalvaHistoricoNavegacao(devem.core.ajax.get(json, Url,IdRespContentDiv, ModoCarregar, Modal));
	},
	
	inicializaCarregando: function(Div)
	{
		$('body').append(devem.core.ajax.layoutLoading());
		/*$('body').append("<div id='notificacao_carregando' style='display:block;'>"+devem.core.ajax.layoutLoading()+"</div>");
		devem.core.modal.notificacao($('#notificacao_carregando'),500, '300px');*/
	},
	
	finalizaCarregando: function(Div)
	{
		$('#bg-loading').remove();
		$('.loader').remove();
		//$(Div).html("").fadeIn(1000);
		//$('#notificacao_carregando').remove();
	},
	
	layoutLoading: function(){
		var html = "";
		/*html += "<div>";
		html += "<img src=\"core/img/sys/icon-load-small.gif\" border=\"0\" />";
		html += "Carregando...";
		html += "</div>";*/
		html = '<div class="loader"><img border="0" src="app/view/img/loading_loop.gif" /></div><div id="bg-loading"></div>';
		return html;

	},
	responseHandler: function(JSON) {

		if(JSON.Error == true)
			throw new AjaxException(JSON.Message, JSON.File);

		delete JSON.Error;
		return JSON;	
	},	
	dataHandler: function(e) {

		if(e instanceof AjaxError) {
			// Manda o erro para o banco de dados.
		}
		else if(e instanceof Error) {
			console.log(e.Message);
		}
		
		return e;
	}
};


// Objeto de Exceção de Ajax.
function AjaxError(message, file) {
   this.Name = "AjaxError";
   this.Message = message;
   this.File = file;
}
AjaxError.protype = new Error();

$(document).ready(devem.core.ajax.registrar);