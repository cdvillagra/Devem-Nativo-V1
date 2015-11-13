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
if (typeof devem.core.paginacao == 'undefined') { devem.core.paginacao = new Object(); }

devem.core.paginacao = {
    advanced: function(form_id, url)
	{
		$('body').find('#paginacao_eventos_' + form_id).each(function(){
			$(this).click(function(){
				devem.core.paginacao.paginarAdvanced(form_id, url, $(this).attr('paginacao-params-href'));
			});
		});
	},
	
	paginarAdvanced: function(form_id, url, pagina)
	{
		var json = {
			paginacao_pg : pagina,
			paginacao_registros_por_pagina: $('#'+form_id).attr('paginacao-totalporpaginas'),
			paginacao_total_marcadores: $('#'+form_id).attr('paginacao-marcadores'),
			paginacao_modelo: $('#'+form_id).attr('paginacao-modelo'),
			paginacao_url: url,
			paginacao_div: '#' + $('#'+form_id).attr('paginacao-content'),
			paginacao_form_id: '#' + form_id
		};
		
			devem.core.ajax.post(json.paginacao_url, json.paginacao_form_id, json.paginacao_div, true, false, '&'+String.serializeJSON(json));
	},
	
	autoscroll: function(form_id, url, proximapagina, totaldepaginas)
	{
		var scrollcontent = '#' + $('#'+form_id).attr('paginacao-content');
		
		$(window).scroll(function(){
			if($(window).scrollTop() + $(window).height() == $(document).height())
		    {
	            if((eval(proximapagina) == eval(totaldepaginas)) && devem.core.paginacao.getBloqueio(form_id+"_bloqueio_paginacao") != '1')
	            {
	            	devem.core.paginacao.setBloqueio(form_id+"_bloqueio_paginacao","1");
	            	devem.core.paginacao.paginarAutoscroll(form_id, url, proximapagina);
	            }
	            	
	            if(eval(proximapagina) < eval(totaldepaginas)){
	            	devem.core.paginacao.setBloqueio(form_id+"_bloqueio_paginacao","0");
	            	devem.core.paginacao.paginarAutoscroll(form_id, url, proximapagina);
	            }	
		    }
		});
	},
	
	paginarAutoscroll: function(form_id, url, pagina)
	{
		var json = {
				paginacao_pg : pagina,
				paginacao_registros_por_pagina: $('#'+form_id).attr('paginacao-totalporpaginas'),
				paginacao_total_marcadores: $('#'+form_id).attr('paginacao-marcadores'),
				paginacao_modelo: $('#'+form_id).attr('paginacao-modelo'),
				paginacao_url: url,
				paginacao_div: '#' + $('#'+form_id).attr('paginacao-content'),
				paginacao_form_id: '#' + form_id
		};
		var div_autoscroll = form_id + "_" + json.paginacao_pg;
		if($("#"+div_autoscroll).length == false){
			$(json.paginacao_div).append("<div id='"+div_autoscroll+"'></div>");
			devem.core.ajax.post(json.paginacao_url, json.paginacao_form_id, '#' + div_autoscroll, true, false, '&'+String.serializeJSON(json));
		}	
	},
	
	scroll: function(form_id, url, proximapagina, totaldepaginas)
	{
		var scrollcontent = '#' + $('#'+form_id).attr('paginacao-content');
		
		$(window).scroll(function(){
			if($(window).scrollTop() + $(window).height() == $(document).height())
		    {
	            if((eval(proximapagina) == eval(totaldepaginas)) && devem.core.paginacao.getBloqueio(form_id+"_bloqueio_paginacao") != '1')
	            {
	            	devem.core.paginacao.setBloqueio(form_id+"_bloqueio_paginacao","1");
	            	devem.core.paginacao.paginarScroll(form_id, url, proximapagina);
	            }
	            	
	            if(eval(proximapagina) < eval(totaldepaginas)){
	            	devem.core.paginacao.setBloqueio(form_id+"_bloqueio_paginacao","0");
	            	devem.core.paginacao.paginarScroll(form_id, url, proximapagina);
	            }	
		    }
		});
	},
	
	paginarScroll: function(form_id, url, pagina)
	{
		var json = {
				paginacao_pg : pagina,
				paginacao_registros_por_pagina: $('#'+form_id).attr('paginacao-totalporpaginas'),
				paginacao_total_marcadores: $('#'+form_id).attr('paginacao-marcadores'),
				paginacao_modelo: $('#'+form_id).attr('paginacao-modelo'),
				paginacao_url: url,
				paginacao_div: '#' + $('#'+form_id).attr('paginacao-content'),
				paginacao_form_id: '#' + form_id
		};
		var div_autoscroll = form_id + "_" + json.paginacao_pg;
		if($("#"+div_autoscroll).length == false){
			$(json.paginacao_div).append("<div id='"+div_autoscroll+"'></div>");
			$("#"+div_autoscroll).html('<button id="'+form_id+'_btn_carrmais_paginacao" type="button" class="botao_carregarmais_paginacao">Carregar mais</button>');
			$('#' + form_id + '_btn_carrmais_paginacao').click(function(){
				devem.core.paginacao.clickScrollEvento(div_autoscroll, json);
			});
		}	
	},
	
	clickScrollEvento: function(div_autoscroll, json){
		devem.core.ajax.post(json.paginacao_url, json.paginacao_form_id, '#' + div_autoscroll, true, false, '&'+String.serializeJSON(json));
	},
    
    setBloqueio: function (cname, cvalue) {
	    var exdays = 1;
		var d = new Date();
	    d.setTime(d.getTime() + (exdays*24*60*60*1000));
	    var expires = "expires="+d.toGMTString();
	    document.cookie = cname + "=" + cvalue + "; " + expires;
	},

	getBloqueio: function (cname) {
	    var name = cname + "=";
	    var ca = document.cookie.split(';');
	    for(var i=0; i<ca.length; i++) {
	        var c = ca[i].trim();
	        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
	    }
	    return "";
	}
};