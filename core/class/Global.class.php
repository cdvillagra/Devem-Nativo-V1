<?php

/**
 * @author Christopher Villagra
*/

abstract class Global
{

    protected static $base;

	public function __construct()
	{

		 self::$base = isset($_REQUEST['admin']) ? 'admin' : 'app';
	}

	public static function existe($key = null) {

		return (is_null($key)) ? isset($GLOBALS) : isset($GLOBALS['_devem_'][self::$base][$key]);

	}
	public static function realmenteExiste($key = null) {

		return isset($GLOBALS['_devem_'][self::$base][$key]);

	}

	public static function get($val) 
	{	
		return @$GLOBALS['_devem_'][self::$base][$val];	
	}

	public static function set($key, $val = true) 
	{
		return @$GLOBALS['_devem_'][self::$base][$key] = $val;
	}

	public static function setNull($key)
	{
		if(!isset($GLOBALS['_devem_'][self::$base][$key]))
			throw new RuntimeException('Unset inesperado.');

		unset($GLOBALS['_devem_'][self::$base][$key]);
	}
	
}