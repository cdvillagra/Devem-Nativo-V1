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


<?

    header("Content-type: application/javascript");

    $uri = explode('/',$_SERVER['REQUEST_URI']);
    $uri = str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['SCRIPT_FILENAME']);
    $uri = str_replace('/core/js/devem/verificadorDePagina.class.js.php', '', $uri);

?>

if (typeof devem == 'undefined') { devem = new Object(); }
if (typeof devem.core == 'undefined') { devem.core = new Object(); }
if (typeof devem.core.verificadorpagina == 'undefined') { devem.core.verificadorpagina = new Object(); }

devem.core.verificadorpagina = {
		
    registrar: function () {
    	
		devem.core.verificadorpagina.inicializar();
		
	},
	
	inicializar: function() {

		this.getValue = [];
		
		var url = window.location.href.split('<?=$uri?>');
		var getVars = url[1].split('/');
		
		var count = getVars.length;

		var controle = 'principal';
		var acao = 'index';

		if(((typeof getVars[1] !== 'undefined') && (getVars[1].length != 0)) && (getVars[1] == 'admin')){

			controle = (((typeof getVars[2] === 'undefined') || (getVars[2].length == 0)) ? 'principal' : getVars[2]);
			acao = (((typeof getVars[3] === 'undefined') || (getVars[3].length == 0)) ? 'index' : getVars[3]);

		}else{

			controle = (((typeof getVars[1] === 'undefined') || (getVars[1].length == 0)) ? 'principal' : getVars[1]);
			acao = (((typeof getVars[2] === 'undefined') || (getVars[2].length == 0)) ? 'index' : getVars[2]);

		}

		this.getValue['controle'] = (controle.substring((controle.length - 1), controle.length) == '#' ? controle.substring( 0 , (controle.length - 1)) : controle);
		this.getValue['acao'] = (acao.substring((acao.length - 1), acao.length) == '#' ? acao.substring( 0 , (acao.length - 1)) : acao);

	},
	
	validaGetVar : function(tipo, valor) {

		if(typeof valor === 'undefined'){

			return this.getValue[tipo];

		}else{

			var retorno = false;

			if(this.getValue[tipo] == valor)
				retorno = true;

			return retorno;

		}
	}
	
};
$(document).ready(devem.core.verificadorpagina.registrar);