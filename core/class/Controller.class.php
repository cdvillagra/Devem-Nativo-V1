<?php

/** 
 * Controller principal
 *
 * @package 	app
 * @subpackage 	controller 
 * @author 	   	Christopher Villagra <christopher@dvillagra.com.br> 
 * @copyright 	(c) 2015 - Devem
**/ 

//require_once 'app/controller/Login.controller.php';

class Controller
{
	protected $model;

	public function __construct($auth) {

		// # Se a execução for via CLI, ignora as permissões de visualização de Rotas.
		// if(php_sapi_name() == 'cli')
  //           return false;  

		// if(!$auth)
		// 	return false;
				
		// LoginController::validaAutenticacaoOcorre();
	}
}