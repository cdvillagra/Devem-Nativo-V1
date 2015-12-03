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
if (typeof devem.core.tratamentoerro == 'undefined') { devem.core.tratamentoerro = new Object(); }

devem.core.tratamentoerro = {
    registrar: function ()
    {
		devem.core.tratamentoerro.inicializar();
	},
	
	inicializar: function()
	{
		devem.core.tratamentoerro.monitorar('ajax');
	},
	
	monitorar: function(tipo){
		switch(tipo){
			case 'conectividade':
				var state = navigator.onLine ? "online" : "offline";
			    if(state == "offline"){
			    	if ($('#sem_conexao').length == 0){
				    	var html_block = '<div class="cobertura" id="sem_conexao">';
				    	html_block += '<div class="caixa-sem-conexao">';
				    	html_block += '<p>Ops! Você está sem conexão.</p>';
				    	html_block += "</div></div>";
				    	$('body').append(html_block);
			    	}
			    }else{
			    	$('#sem_conexao').remove();
			    }
			break;
			case 'ajax':
				devem.core.tratamentoerro.tratamentoDeAjaxError();
			break;	
		}
	},
	
	tratamentoDeAjaxError: function(){
		$(function() {
			$.ajaxSetup({
		        error: function(jqXHR, exception) {
		            if (jqXHR.status === 0) {
		            	devem.core.tratamentoerro.displayErro('0','Erro de conex�o com a internet. Verifique sua Internet.');
		            } else if (jqXHR.status == 404) {
		            	devem.core.tratamentoerro.displayErro('404','P�gina n�o encontrada. [404]', jqXHR);
		            } else if (jqXHR.status == 500) {
		            	devem.core.tratamentoerro.displayErro('500','Erro Interno [500].', jqXHR);
		            } else if (exception === 'parsererror') {
		            	devem.core.tratamentoerro.displayErro('json','Erro de Json.', jqXHR);
		            } else if (exception === 'timeout') {
		            	devem.core.tratamentoerro.displayErro('timeout','Timeout no servidor.', jqXHR);
		            } else if (exception === 'abort') {
		            	devem.core.tratamentoerro.displayErro('ajaxaborto','Requisi��o Ajax foi abortado.', jqXHR);
		            } else {
		            	devem.core.tratamentoerro.displayErro('outros','Outros Erros: ' + jqXHR.responseText, jqXHR);
		            }
		        }
		    });
		});
	},
	
	displayErro: function(id, mensagem, jqXHR)
	{
		
		/*var infoNavegador = navigator.userAgent;
		var infoHeader = jqXHR.getAllResponseHeaders();
		var infoHeaderGlobal = jqXHR.getResponseHeader;
		var infoState = jqXHR.readyState;
		var infoStatus = jqXHR.statusText;
		var infoText = jqXHR.responseText;
		
		alert(infoHeaderGlobal);
		
		$('body').append("<div id='div_error_"+id+"' style='display:block;'>"+mensagem+"</div>");
    	devem.core.modal.notificacaoCenter('#div_error_'+id, 3000);*/
	},
	
	formcamposComErro: function(collection_id)
	{
		
		$('input').each(
			function() {
				//$(this).parent('.custom-input').removeClass('error');
				$(this).removeClass('error_devem_form');
			}
		);
		
		$('select').each(
			function() {
				$(this).parent('.custom-select').removeClass('error');
				$(this).parent('.select-devem').removeClass('error');

				if ($(this).hasClass('chosen-select')) {
					$(this).parent().find('.select2-choice').first().removeClass('error');
				}
			}
		);
		
		$('textarea').each(
			function() {
				$(this).parent('.custom-textarea').removeClass('error');
				$(this).parent('.textarea-devem').removeClass('error');
			}
		);
		
		var i;
		for(i=0; i < collection_id.length; i++)
		{
			if($('#' + collection_id[i]).is("input"))
			{
				$('#' + collection_id[i]).addClass('error_devem_form');
				$('#' + collection_id[i]).addClass('error_devem_form');
			}
			
			if($('#' + collection_id[i]).is("select"))
			{
				$('#' + collection_id[i]).parent('.custom-select').addClass('error');
				$('#' + collection_id[i]).parent('.select-devem').addClass('error');

				if ($('#' + collection_id[i]).hasClass('chosen-select')) {
					$('#' + collection_id[i]).parent().find('.select2-choice').first().addClass('error');
				}
			}
			
			if($('#' + collection_id[i]).is("textarea"))
			{
				$('#' + collection_id[i]).parent('.custom-textarea').addClass('error');
				$('#' + collection_id[i]).parent('.textarea-devem').addClass('error');
			}
		}
		
		$('#' + collection_id[0]).focus();
	}
};

$(document).ready(devem.core.tratamentoerro.registrar);