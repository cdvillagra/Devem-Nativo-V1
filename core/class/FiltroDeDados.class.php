<?php
class FiltroDeDados
{
    static function LimpaString( $st_string )
    {

    	return self::recursiveLimpaString($st_string);

    }

    private static function recursiveLimpaString($st_string){

    	if(is_array($st_string)){

    		$arrReturn = array();

    		foreach ($st_string as $key => $value)
    			$arrReturn[$key] = self::recursiveLimpaString($value);

    		return $arrReturn;

    	}else{

    		return addslashes(strip_tags($st_string));

    	}

    }
    
    static function RemoveNullOrWhiteSpace ( $st_string )
    {
    	return $st_string == 'undefined' || $st_string == null || trim($st_string) == '' ? '' : trim($st_string);
	}
    
    static function Cryptografa( $st_string )
    {
    	return md5($st_string);
    }
    
	static function RealParaDouble( $st_string )
    {
    	$st_string = str_replace('.', '', $st_string);
    	$st_string = str_replace(',', '.', $st_string);  
    	return $st_string;
    }

	static function DoubleParaReal( $st_string, $cifrao = false, $casas_decimais = 2 ) {
		$st_string = number_format((float)($st_string), $casas_decimais, ',', '.');

		if ($cifrao) {
			$st_string = 'R$ ' . $st_string;			
		}
		return $st_string;
    }

    static function CortaTexto($texto, $quantCort, $reticencias = true) {
    	if (strlen($texto) > $quantCort) {
    		do {
    			$arrayTitulo = explode(" ", $texto);
    			$texto = '';
    			$count = count($arrayTitulo);
    			$count --;
    			for ($aix = 0; $aix < $count; $aix ++) {
    				if ($aix != 0) {
    					$texto .= ' ';
    				}
    				$texto .= $arrayTitulo[$aix];
    			}
    		} while (strlen($texto) > $quantCort);
    		if ($reticencias) {
    			$texto .= '...';
    		}
    	}
    	return $texto;
    }

	static function ValidaExistenciaArquivo($urlDoArquivo, $urlDeFalha) {
		$return = $urlDeFalha;
		if ($urlDoArquivo <> '') {
			if (get_headers($urlDoArquivo, 1)) {
				$return = $urlDoArquivo;
			}
		}

		return $return;
    }

    static function PostToFiltro($POST) {
    	
    	@$filtro = array();
    	
	    $arrayKeys = array_keys($POST);
	    $count = count($arrayKeys);
	    for ($x = 0; $x < $count; $x++) {
	    	$filtroAtual = $arrayKeys[$x];
	    		
	    	$subCount = count($POST[$filtroAtual]);
	    	if ($subCount == 1) {
	    		@$filtro[$filtroAtual] = FiltroDeDados::RemoveNullOrWhiteSpace($POST[$filtroAtual]);
	    		@$filtro[$filtroAtual] = FiltroDeDados::LimpaString(@$filtro[$filtroAtual]);
	    	} else {
	    		for($y = 0; $y < $subCount; $y++) {
	    			@$filtro[$filtroAtual][$y] = FiltroDeDados::RemoveNullOrWhiteSpace($POST[$filtroAtual][$y]);
	    		}
	    	}
	    }
	    
	    return @$filtro;
    }
    
    static function FormataData($st_data, $mes_em_texto = false, $usar_barras = true, $mostrar_hora = false, $mostrar_segundos = false) {
    	$explode = explode(" ", $st_data);
    	$data = explode("-", $explode[0]);

    	$hora = "";
    	if(isset($explode[1]))
    		$hora = explode(":", $explode[1]);

    	unset($explode);
    
    	$data_formatada = '';
    	$data_formatada .= $data[2];
    
    	//# Adiciona barras ou espaço
    	if ($usar_barras) {
    		$data_formatada .= '/';
    	} else {
    		$data_formatada .= ' ';
    	}
    	
    	//# Transforma o valor em número para data
    	if ($mes_em_texto) {
	    	switch($data[1]) {
	    		case 1:
	    			$data_formatada .= 'Jan';
	    			break;
	    		case 2:
	    			$data_formatada .= 'Fev';
	    			break;
	    		case 3:
	    			$data_formatada .= 'Mar';
	    			break;
	    		case 4:
	    			$data_formatada .= 'Abr';
	    			break;
	    		case 5:
	    			$data_formatada .= 'Mai';
	    			break;
	    		case 6:
	    			$data_formatada .= 'Jun';
	    			break;
	    		case 7:
	    			$data_formatada .= 'Jul';
	    			break;
	    		case 8:
	    			$data_formatada .= 'Ago';
	    			break;
	    		case 9:
	    			$data_formatada .= 'Set';
	    			break;
	    		case 10:
	    			$data_formatada .= 'Out';
	    			break;
	    		case 11:
	    			$data_formatada .= 'Nov';
	    			break;
	    		case 12:
	    			$data_formatada .= 'Dez';
	    			break;
	    	}
	    	
    	} else {
    		//# Ou adiciona apenas o número mesmo
    		$data_formatada .= $data[1];
    	}
    	
    	//# Adiciona barras ou espaço
    	if ($usar_barras) {
    		$data_formatada .= '/';
    	} else {
    		$data_formatada .= ' ';
    	}
    	
    	$data_formatada .= $data[0];
    	unset($data);
    
    	if ($mostrar_hora) {
    		$data_formatada .= ' - ';
    		
	    	$data_formatada .= $hora[0];
	    	$data_formatada .= ":" . $hora[1];
	    	
	    	if ($mostrar_segundos) {
	    		$hora_formatada .= ":" . $hora[2];
	    	}
	    	
	    	unset($hora);
    	}
    	
    	return $data_formatada;
    }
  	
  	public static function RemoveAcentos($realname, $strip_spaces = true, $tolower = true) {
		$bad_chars = array("'", "\\", ' ', '/', ':', '*', '?', '"', '<', '>', '|');
	    $realname = preg_replace('/[àáâãåäæ]/iu', 'a', $realname);
	    $realname = preg_replace('/[èéêë]/iu', 'e', $realname);
	    $realname = preg_replace('/[ìíîï]/iu', 'i', $realname);
	    $realname = preg_replace('/[òóôõöø]/iu', 'o', $realname);
	    $realname = preg_replace('/[ùúûü]/iu', 'u', $realname);
	    $realname = preg_replace('/[ç]/iu', 'c', $realname);
	    $realname = rawurlencode(str_replace($bad_chars, '_', $realname));
	    $realname = preg_replace("/%(\w{2})/", '_', $realname);
	    while (strpos($realname, '__') !== false) {
	        $realname = str_replace("__", "_", $realname);
	    }
	    if ($strip_spaces === false) {
	        $realname = str_replace('_', ' ', $realname);
	    }

	    if ($realname[strlen($realname) - 1] == "_") {
	        $realname = substr($realname, 0, -1);
	    }

	    return ($tolower === true) ? strtolower($realname) : $realname;
	}  
}
?>