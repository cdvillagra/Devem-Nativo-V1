<?php


class Cookie {

	private static $__host;
	/**
	* Metodo Construtor da Classe
	*
	* @author    Christopher Dencker Villagra
	* @return    resource
	*/
	function __construct() {

		parent::__construct();

    	$host = '[seu_dominio_com_ou_sem_subdominio]';

		if(strstr($host, ':8080'))
			$host = $name;

		self::$__host = $host;
	}

static function verificaCookie($cookie_name){

		return isset($_COOKIE[$cookie_name]);

    }

    static function valorCookie($cookie_name){

		return (isset($_COOKIE[$cookie_name]) ? $_COOKIE[$cookie_name] : false); 
    }

    static function criaCookie($cookie_name, $cookie_value = 1){

    	self::excluirCookie($cookie_name);

		setcookie($cookie_name, $cookie_value, time() + ((86400 * 30) * 3), '/', self::$__host); 
    }

    static function excluirCookie($cookie_name, $session = true){

		unset($_COOKIE[$cookie_name]);
		setcookie($cookie_name, '', time() - 60, '/', self::$__host);

		if($session)
			session_destroy();

    }
    

}