<?php

/**
 * @author Christopher Villagra
*/

abstract class Session
{

    static private $base = SESSION_ID;

	public function __construct()
	{


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

		if(is_array($key)){

			foreach ($key as $k => $v) {
				$_SESSION['_devem_'][self::$base][$k] = $v;
			}

		}else{

			$_SESSION['_devem_'][self::$base][$key] = $val;

		}
	}

	public static function setNull($key)
	{
		unset($_SESSION['_devem_'][self::$base][$key]);
	}

	public static function destroy()
	{
		unset($_SESSION['_devem_'][self::$base]);
	}
	
}