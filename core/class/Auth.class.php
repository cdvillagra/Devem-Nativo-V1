<?php

abstract class Auth
{

    protected static $base;

	public function __construct()
	{

		 self::$base = isset($_REQUEST['admin']) ? 'admin' : 'app';
	}

	public static function atualizaLogado(){

		$code = str_replace('.', '', str_replace(' ', '', microtime()));

		Session::set('login_validate', true);
		Session::set('login_key', $code);
		Session::set('force_key', md5(md5($code)));

	}

	public static function atualizaDeslogado(){

		Session::setNull('login_validate');
		Session::setNull('login_key');
		Session::setNull('force_key');

	}

	public static function loginValido(){

		$return = false;

		if(
			Session::realmenteExiste('login_validate') &&
			Session::realmenteExiste('login_key') &&
			Session::realmenteExiste('force_key') &&
			(Session::get('force_key') == md5(md5(Session::get('login_key'))))
		  )
			$return = true;

		return $return;

	}

}