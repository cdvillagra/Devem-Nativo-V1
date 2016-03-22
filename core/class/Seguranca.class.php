<?php
abstract class Seguranca
{

    private static $exceptionValidate = true;
    private static $exceptionKey = array();

    function __construct(){

    	self::$exceptionKey = array(   
                                    ADM_KEY.'-analytics-code'
                                );

    }

	public static function SQLAntiInjection($o)
	{
	    if (is_string($o)) {

	        $o = self::doSQLAntiInjection($o);

	        return $o;
	        
	    }
	    if (is_array($o)) {

	        foreach ($o as $k => $v) {

	        	foreach (self::$exceptionKey as $w) 
		        	if($k == $w)
		        		self::$exceptionValidate = false;

		        if(self::$exceptionValidate)
	            	$o[$k] = self::SQLAntiInjection($o[$k]);

	        }

	        return $o;

	    }
	    if (is_object($o)) {

	        $l = get_object_vars($o);

	        foreach ($l as $k => $v) 
	            $o->$k = self::SQLAntiInjection($v);

	    }
	    return $o;
	}
	
	public static function doSQLAntiInjection($str)
	{
	    $str = preg_replace('/<(.*?)>/i', '', $str);
	
	    if(!get_magic_quotes_gpc()){
	        $str = stripslashes($str);
	    }
	    
	    $str = strip_tags($str);
		$str = addslashes($str);
		
		#Este cara está dando problema com encode dos dados!
		//$str = htmlentities($str);
		

		$str = htmlspecialchars($str);
	
	    if(!is_array($str)) {
	    	
	        $str = @preg_replace("/(from|select|insert|delete|where|drop table|show tables)/i","",$str);
	        $str = @preg_replace('~&amp;#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $str);
	        $str = @preg_replace('~&amp;#([0-9]+);~e', 'chr("\\1")', $str);
	        $str = str_replace("<script","",$str);
	        $str = str_replace("script>","",$str);
	        $str = str_replace("<Script","",$str);
	        $str = str_replace("Script>","",$str);
	        $str = trim($str);
	        $tbl = get_html_translation_table(HTML_ENTITIES);
	        $tbl = array_flip($tbl);
	        $str = addslashes($str);
	        $str = strip_tags($str);
			
	       return strtr($str, $tbl);

	    }else{
	        return $str;
	    }
	}
}
?>