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

	//# Definindo variaveis privadas
	private $__request;
	private $__dir;
	
	/**
    * Metodo Construtor da Classe
    *
    * @author    Christopher Dencker Villagra
    * @return    resource
    */
	function __construct($request){

		//# Inseri todas as variaveis do request na variavel privada
		$this->__request = $request;

		//# Define a location caso seja enviado o módulo de forma correta
		$this->l = new location($this->__request['module']);

		//# Define o diretório que será salvo o arquivo a partir da location
		$this->__dir = $this->l->dir_usage;

	}

	/**
    * Metodo que salva o arquivo no diretório de media
    *
    * @author    Christopher Dencker Villagra
    * @return    string
    */
	public function uploadImage(){
		
		//# Define um novo nome para o arquivo
		$nome_novo = $this->__request['module'].'-'.str_replace('.', '', str_replace(' ', '', microtime())).'.'.$this->__request['type'];

		//# Define o diretório do arquivo e o caminho absoluto
		$path = getcwd().$this->__dir . (@$this->__request['id'] != 'null' ? DIRECTORY_SEPARATOR . @$this->__request['id'] . DIRECTORY_SEPARATOR : '');
		$path =  str_replace(DIRECTORY_SEPARATOR.'api','', $path);

		if(!is_dir($path))
			mkdir($path, 0775);

		$caminho =  $path .  $nome_novo;

		//# Abre ou cria o arquivo
	    $ifp = fopen($caminho, "wb"); 

		if(is_array($this->__request['data'])){
			$this->__request['data'] = implode('',$this->__request['data']);
		}
		
	    $data = explode(',', $this->__request['data']);

	    //# Grava o arquivo
	    fwrite($ifp, base64_decode($data[1])); 

	    fclose($ifp); 

		return $nome_novo;
		
	}	

}