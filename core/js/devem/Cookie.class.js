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

if (typeof devem == 'undefined'){

	devem = new Object();
}

if (typeof devem.core == 'undefined'){

	devem.core = new Object();
}

if (typeof devem.core.Cookie == 'undefined'){

	devem.core.Cookie = new Object();
}

devem.core.Cookie = {

	set: function(cname, cvalue, exdays) {
	   
	    var d = new Date();
	   
	    d.setTime(d.getTime() + (exdays*24*60*60*1000));
	   
	    var expires = "expires="+d.toUTCString();
	   
	    document.cookie = cname + "=" + cvalue + "; " + expires;// + ";domain=.devem.com.br;path=/";
	},

	get: function(cname) {
	    
	    var name = cname + "=";
	    
	    var ca = document.cookie.split(';');
	    
	    for(var i=0; i<ca.length; i++) {
	        
	        var c = ca[i];
	        
	        while (c.charAt(0)==' ') c = c.substring(1);

	        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);

	    }

	    return "";
	},

	check: function(cname) {
	    
	    var name = cname + "=";
	    
	    var ca = document.cookie.split(';');
	    
	    for(var i=0; i<ca.length; i++) {
	        
	        var c = ca[i];
	        
	        while (c.charAt(0)==' ') c = c.substring(1);

	        if (c.indexOf(name) == 0) return true;

	    }

	    return false;
	},

	checkAndSet: function(cname, cvalue, exdays) {

		if(typeof exdays == 'undefined')
			var exdays = 365;

	    var validate = devem.core.Cookie.check(cname);

	    if(typeof cvalue != 'undefined')
            	devem.core.Cookie.set(cname, cvalue, exdays);

        return validate;

	}

};