<?php

/**
 * @author Christopher Villagra
*/

abstract class Session
{

    protected static $base;

	public function __construct()
	{

		 self::$base = isset($_REQUEST['admin']) ? SESSION_ADMIN : SESSION_APP;
	}

	public static function existe($key = null) {

		return (is_null($key)) ? isset($_SESSION) : isset($_SESSION['_devem_'][self::$base][$key]);

	}
	public static function realmenteExiste($key = null) {

		return isset($_SESSION['_devem_'][self::$base][$key]);

	}

	public static function get($val) 
	{	
		return @$_SESSION['_devem_'][self::$base][$val];	
	}

	public static function set($key, $val = true) 
	{
		return @$_SESSION['_devem_'][self::$base][$key] = $val;
	}

	public static function setNull($key)
	{
		unset($_SESSION['_devem_'][self::$base][$key]);
	}
	
}