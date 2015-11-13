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

require_once 'class/location.class.php';

class functions{

	private $__request;

	private $__dir;
	
	function __construct($request){

		$this->__request = $request;

		$this->l = new location($this->__request['module']);

		$this->__dir = $this->l->dir_usage;

	}

	public function uploadImage(){
		
		$nome_novo = $this->__request['module'].'-'.str_replace('.', '', str_replace(' ', '', microtime())).'.'.$this->__request['type'];

		$path = getcwd().$this->__dir . (@$this->__request['id'] != 'null' ? '\\' . @$this->__request['id'] . '\\' : '');

		$path =  str_replace('\\api','', $path);
		if(!is_dir($path))
			mkdir($path, 0775);

		$caminho =  $path .  $nome_novo;

	    $ifp = fopen($caminho, "wb"); 

		if(is_array($this->__request['data'])){
			$this->__request['data'] = implode('',$this->__request['data']);
		}
		
	    $data = explode(',', $this->__request['data']);

	    fwrite($ifp, base64_decode($data[1])); 

	    fclose($ifp); 

		return $nome_novo;
		
	}	

}