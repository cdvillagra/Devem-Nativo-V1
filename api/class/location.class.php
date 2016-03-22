<?php

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

class location{

	public $dir_usage;

	//# Define os locais onde serão salvo os arquivos
	private $dir__default					= DIRECTORY_SEPARATOR;
	private $dir__upload 					= DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR;
	private $dir__arquivo 					= DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'arquivos'.DIRECTORY_SEPARATOR;
	private $dir__audio 					= DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'audio'.DIRECTORY_SEPARATOR;
	private $dir__imagem	 				= DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'imagem'.DIRECTORY_SEPARATOR;
	private $dir__video 					= DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.'video'.DIRECTORY_SEPARATOR;
	
	/**
    * Metodo Construtor da Classe
    *
    * @author    Christopher Dencker Villagra
    * @param 	 $modulo [string]
    */
	function __construct($modulo){

		switch ($modulo) {

			case 'upload':
				$this->dir_usage = $this->dir__upload;
				break;

			case 'arquivo':
				$this->dir_usage = $this->dir__arquivo;
				break;

			case 'audio':
				$this->dir_usage = $this->dir__audio;
				break;

			case 'imagem':
				$this->dir_usage = $this->dir__imagem;
				break;

			case 'video':
				$this->dir_usage = $this->dir__video;
				break;

			default:
				$this->dir_usage = $this->dir__default;
				break;
		}

	}

}