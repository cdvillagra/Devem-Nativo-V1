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

require_once 'functions.class.php';
require_once 'response.class.php';

final class webService{

	//# Definindo variaveis privadas
	private $hashPass = '[CONFIG_G_API_KEY]';
	private $request;
	private $requestKey;
	private $requestFormat;
	
	/**
    * Metodo Construtor da Classe
    *
    * @author    Christopher Dencker Villagra
    * @return    resource
    */
	
	function __construct(){

		$this->r = new response;

	}

	/**
     * Método que inicia e verifica os serviços
     *
     * @author  Christopher Villagra
    */
	
	public function iniciaWs(){

		if(!$this->trataRequest())
			throw new Exception($this->r->errorRequest(901));

		if(!$this->authRequest())
			throw new Exception($this->r->errorRequest(902));

		if(!$this->actionRequest())
			throw new Exception($this->r->errorRequest());

	}

	/**
     * Método de tratamento de erro do request
     *
     * @author  Christopher Villagra
     * @param   [$_POST/$_GET/$_REQUEST]
     * @return  boolean
    */
	
	private function trataRequest(){

		//# Tratamento simples para que qualquer argumento de qualquer verbo seja inserido na variavel $this->request
		$this->request = (!empty($_POST) ? $_POST : (!empty($_GET) ? $_GET : (!empty($_REQUEST) ? $_REQUEST : false)));

		//# Inicia o tratamento das variaveis e do proprio obj request
		if(!$this->request)
			return false;

		if(!isset($this->request['key']) || empty($this->request['key']))
			throw new Exception($this->r->errorRequest(902));

		if(!isset($this->request['format']) || empty($this->request['format']))
			throw new Exception($this->r->errorRequest(903));

		if(!isset($this->request['method']) || empty($this->request['method']))
			throw new Exception($this->r->errorRequest(904));

		if(!isset($this->request['module']) || empty($this->request['module']))
			throw new Exception($this->r->errorRequest(905));

		$this->requestKey = $this->request['key'];

		return true;

	}

	/**
     * Método que autentica e autoriza o consumo do ws
     *
     * @author  Christopher Villagra
     * @param   obj
     * @return  boolean
    */
	
	private function authRequest(){

		//# Verifica se a chave do serviço é o mesmo enviado no request
		if($this->hashPass != md5($this->requestKey))
			throw new Exception($this->r->errorRequest(902));

		return true;

	}

	/**
     * Método que seta o método que sera executado
     *
     * @author  Christopher Villagra
     * @param   obj
     * @return  boolean
    */
	
	private function actionRequest(){

		$this->f = new functions($this->request);

		$acao = $this->f->{$this->request['method']}();

		if(!$acao)
			return false;

		$this->r->responseRequest(000, $acao);

		return true;

	}

}