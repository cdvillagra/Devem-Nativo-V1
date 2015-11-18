<?php

class Utilitarios
{

	public static function xmlToArray($caminho){

		$out = false;

		if(file_exists($caminho)){
		
			$arrayXml = simplexml_load_file($caminho);

		    $out = self::xmlToarray2($arrayXml);

		}

	    return $out;

	}

	public static function xmlToarray2 ( $xmlObject, $out = array () )
	{

	    foreach ( (array) $xmlObject as $index => $node )
	        $out[$index] = ( is_object ( $node ) ) ? self::xmlToarray2 ( $node ) : $node;

	    return $out;

	}

	public static function arrayToIn($var){

		$aux = '';
		$k = true;

		foreach ($var as $k) {

			if(!is_int($k))
				$k = false;

			$aux .= ','.(!$k ? "'" : "").$k.(!$k ? "'" : "");

			$k = true;
		}

		return ' in ('.substr($aux, 1).')';

	}

	public static function urlToNome($var){

		$aux = explode('-', $var);

		$var = '';

		foreach ($aux as $k) {
			
			$var .= ' '.ucfirst($k);

		}

		return substr($var, 1);

	}

	public static function dataDiaMes($var){

		$aux = explode('-', $var);

		$var = $aux[2].' de '.self::intToStrMes($aux[1]);

		return $var;

	}

	public static function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
	{

		$lmin = 'abcdefghijklmnopqrstuvwxyz';
		$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$num = '1234567890';
		$simb = '!@#$%*-';
		$retorno = '';
		$caracteres = '';
	
		$caracteres .= $lmin;

		if ($maiusculas) $caracteres .= $lmai;
		if ($numeros) $caracteres .= $num;
		if ($simbolos) $caracteres .= $simb;
	
		$len = strlen($caracteres);

		for ($n = 1; $n <= $tamanho; $n++) {

			$rand = mt_rand(1, $len);
			$retorno .= $caracteres[$rand-1];

		}

		return $retorno;

	}

	static function get_user_prop($className, $property) {

	  if(!class_exists($className)) return null;
	  if(!property_exists($className, $property)) return null;

	  $vars = get_class_vars($className);

	  return $vars[$property];

	}

	public static function strToIntMes($var){

		switch (strtolower($var)) {
			case 'janeiro':
				$var = 1;
				break;
			case 'fevereiro':
				$var = 2;
				break;
			case 'marco':
				$var = 3;
				break;
			case 'abril':
				$var = 4;
				break;
			case 'maio':
				$var = 5;
				break;
			case 'junho':
				$var = 6;
				break;
			case 'julho':
				$var = 7;
				break;
			case 'agosto':
				$var = 8;
				break;
			case 'setembro':
				$var = 9;
				break;
			case 'outubro':
				$var = 10;
				break;
			case 'novembro':
				$var = 11;
				break;
			case 'dezembro':
				$var = 12;
				break;
		}

		return $var;

	}

	public static function intToStrMes($var){

		switch (strtolower($var)) {
			case '01':
				$var = 'janeiro';
				break;
			case '02':
				$var = 'fevereiro';
				break;
			case '03':
				$var = 'março';
				break;
			case '04':
				$var = 'abril';
				break;
			case '05':
				$var = 'maio';
				break;
			case '06':
				$var = 'junho';
				break;
			case '07':
				$var = 'julho';
				break;
			case '08':
				$var = 'agosto';
				break;
			case '09':
				$var = 'setembro';
				break;
			case '10':
				$var = 'outubro';
				break;
			case '11':
				$var = 'novembro';
				break;
			case '12':
				$var = 'dezembro';
				break;
		}

		return $var;

	}

	static function intToStrMesAbv($var){

		switch (strtolower($var)) {
			case '01':
				$var = 'JAN';
				break;
			case '02':
				$var = 'FEV';
				break;
			case '03':
				$var = 'MAR';
				break;
			case '04':
				$var = 'ABR';
				break;
			case '05':
				$var = 'MAI';
				break;
			case '06':
				$var = 'JUN';
				break;
			case '07':
				$var = 'JUL';
				break;
			case '08':
				$var = 'AGO';
				break;
			case '09':
				$var = 'SET';
				break;
			case '10':
				$var = 'OUT';
				break;
			case '11':
				$var = 'NOV';
				break;
			case '12':
				$var = 'DEZ';
				break;
		}

		return $var;

	}

	public function stringMoeda($val){

		$val = number_format($val, 2, ',', '.');

		return $val;

	}

	static public function getUfs(){

		$arrUfs = array(
						'AC',
						'AL',
						'AM',
						'AP',
						'BA',
						'CE',
						'DF',
						'ES',
						'GO',
						'MA',
						'MG',
						'MS',
						'MT',
						'PA',
						'PB',
						'PE',
						'PI',
						'PR',
						'RJ',
						'RN',
						'RO',
						'RR',
						'RS',
						'SC',
						'SE',
						'SP',
						'TO'
						);

		return $arrUfs;

	}

	static public function dataDbtoBr($var){

		$exp = explode(' ', $var);

		$data = $exp[0];
		$hora = $exp[1];

		$exp_data = explode('-', $data);
		$data = $exp_data[2].'/'.$exp_data[1].'/'.$exp_data[0];

		$exp_hora = explode(':', $hora);
		$hora = $exp_hora[0].':'.$exp_hora[1];

		return $data. ' ' .$hora;


	}

	static public function dataDbtoBrMes($var){

		$exp = explode(' ', $var);

			$mes = $exp[0];

			return $mes;
	}

	static public function dataDbtoBrAno($var){

		$exp = explode(' ', $var);

			$ano = $exp[1];

			return $ano;
	}

	static public function dataDbtoBrMesVer($var){

		$exp = explode(' ', $var);

			$mes = $exp[0];

			switch ($mes) {
				
			case 'Janeiro':
				$mes = 1;
				break;
			case 'Fevereiro':
				$mes = 2;
				break;
			case 'Março':
				$mes = 3;
				break;
			case 'Abril':
				$mes = 4;
				break;
			case 'Maio':
				$mes = 5;
				break;
			case 'Junho':
				$mes = 6;
				break;
			case 'Julho':
				$mes = 7;
				break;
			case 'Agosto':
				$mes = 8;
				break;
			case 'Setembro':
				$mes = 9;
				break;
			case 'Outubro':
				$mes = 10;
				break;
			case 'Novembro':
				$mes = 11;
				break;
			case 'Dezembro':
				$mes = 12;
				break;
		}

			return $mes;
	}

	static public function dataDb($var){

		$exp = explode(' ', $var);

		$data = $exp[0];
		
		$exp_data = explode('-', $data);
		$data = $exp_data[2].'/'.$exp_data[1].'/'.$exp_data[0];

		return $data;

	}

	public function VerificaSenha($senha, $len = 5){

		if (strlen($senha) > $len) {
			$tamanho = true;
		}

		$chunks = str_split($senha);

		for ($i=0; $i < count($chunks); $i++) { 
			if ( ctype_upper( $chunks[$i] )) {
				$maiuscula = true;
			} 
			if ( is_numeric( $chunks[$i] )) {
				$numero = true;
			}
		}
		if(!isset($tamanho) || !isset($maiuscula) || !isset($numero)){
			return false;
		}else{
			return true;
		}
	}

	public static function caminhoThumb($caminho) {

		$caminho_temp = explode('.', $caminho);

		if(count($caminho_temp) > 1) {

			$caminho = $caminho_temp[0] . '_thumb.' . $caminho_temp[1];
		}

		return $caminho;

	}

	public static function TrataAspas($string) {

		$string = str_replace('\'', '\\\'', $string);

		return $string;

	}
	
	public static function CalcularIdade($dia, $mes, $ano) {

	    $hoje = getdate();
	    $idade = $hoje['year'] - $ano;
	    if ($hoje['mon'] < $mes || ($hoje['mon'] == $mes && $hoje['mday'] < $dia))
	        $idade -= 1;

	    return $idade;
	}
	
	public static function ConvertNameFile($string) {
	    
		$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ/?®: _²º,.&';
		$b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr----------e';

		$string = utf8_decode($string);
						
		$string = strtr($string, utf8_decode($a), $b);

		$arrayRem = array(".", "'", "(", ")", "´", "`", "[", "]", "º", "ª", ",", ".", "²", ";", "\"", "+", "$");
		$countRem = count($arrayRem);

		for ($rem=0; $rem<$countRem; $rem++) {
			$string = str_replace($arrayRem[$rem], "", $string);
		}

		do {
			$string = str_replace("--", "-", $string);
		} while (strpos($string, '--') === true);
		
	    return strtolower($string);
	}
	
	public static function getGeocode($endereco) {

		if (!defined("URL")) {
			define("URL","http://maps.google.com/maps/api/geocode/json?address=");
		}

	    $url = URL.urlencode($endereco)."&sensor=true";
	    
	    $handle = fopen($url,"r");

	    $contents = '';

	    while (!feof($handle)) {
	        $contents .= fread($handle, 8192);
	    }
	    $contents = json_decode($contents)->results;
	    fclose($handle);
	    
	    return $contents;
	}
	
	public static function redirect($controller, $acao = null, $querystring = null) {

		if(!is_null($querystring) and !is_array($querystring))
			throw new Exception('A querystring precisa ser um array.');

		$qs = '';

		if(is_array($querystring))
			$qs = '&' . http_build_query($querystring);

		if(is_null($acao))
			$acao = '';

		header('Location: '. Url::base($controller.'/'. $acao . $qs));

	}

	public static function redirectToHome() {

		header('Location: '. Url::url());

	}

	public function validaNumerosCPF($cpf = null) {
 
	    // Verifica se um número foi informado
	    if(empty($cpf)) {
	        return false;
	    }
	 
	    // Elimina possivel mascara
	    $cpf = preg_match('[^0-9]', '', $cpf);
	    $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
	     
	    // Verifica se o numero de digitos informados é igual a 11 
	    if (strlen($cpf) != 11) {
	        return false;
	    }
	    // Verifica se nenhuma das sequências invalidas abaixo 
	    // foi digitada. Caso afirmativo, retorna falso
	    else if ($cpf == '00000000000' || 
	        $cpf == '11111111111' || 
	        $cpf == '22222222222' || 
	        $cpf == '33333333333' || 
	        $cpf == '44444444444' || 
	        $cpf == '55555555555' || 
	        $cpf == '66666666666' || 
	        $cpf == '77777777777' || 
	        $cpf == '88888888888' || 
	        $cpf == '99999999999') {
	        return false;
	     // Calcula os digitos verificadores para verificar se o
	     // CPF é válido
	     } else {   
	         
	        for ($t = 9; $t < 11; $t++) {
	             
	            for ($d = 0, $c = 0; $c < $t; $c++) {
	                $d += $cpf{$c} * (($t + 1) - $c);
	            }
	            $d = ((10 * $d) % 11) % 10;
	            if ($cpf{$c} != $d) {
	                return false;
	            }
	        }
	 
	        return true;
	    }
	}	

	static public function errorpage($code = 404){
		
		$view = new View("layout/errorpage.phtml");

		if(empty($code))
			$code = 404;

		switch ($code) {

			case '400':
				$sub = 'A REQUISIÇÃO NÃO FOI<br/>
						INTERPRETADA PELO SERVIDOR.';
				break;

			case '404':
				$sub = 'ESTA NÃO É A PÁGINA DA WEB<br/>
						QUE VOCÊ ESTÁ PROCURANDO.';
				break;

			case '408':
				$sub = 'O TEMPO LIMITE FOI EXCEDIDO,<br/>
						FAVOR, TENTE NOVAMENTE.';
				break;

			case '500':
				$sub = 'OCORREU UM ERRO<br/>
						INTERNO NO SERVIDOR.';
				break;

			case '502':
			case '503':
				$sub = 'SERVIÇO INDISPONIVEL,<br/>
						FAVOR, TENTE NOVAMENTE.';
				break;

			case '302':
				$sub = 'OCORREU UM ERRO INESPERADO,<br/>
						FAVOR, TENTE NOVAMENTE';

			default:
				$sub = 'OCORREU UM ERRO INESPERADO.';
				break;
		}

		$view->pParametros(
							array('code' => $code,
								  'sub' => $sub
								)
							);

		$view->Show();
		
	}

	static public function getTopBillboard($data, $top = 10){

		$ch = curl_init();

		$url = 'http://www.billboard.com/fe-ajax/birthdayin/379/'.$data.'/'.$top;

		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_HEADER, 0);

		$resposta = curl_exec($ch);

		curl_close($ch);

		return $resposta;

	}

	static function isJson($string) {

	 json_decode($string);

	 return (json_last_error() == JSON_ERROR_NONE);

	}

	static function returnJson($data){

		//# Indica que o retorno é do tipo json
		header('Content-type: application/json');
		
 		if(!self::isJson($data)){

 			echo $data;

 		}else{

			echo json_encode($data);

		}
		
	}

	static function deleteFolderRecursive($dir) {

	   if (is_dir($dir)) {

	     $objects = scandir($dir);

	     foreach ($objects as $object) {

	       if ($object != "." && $object != "..") {

	         if (filetype($dir."/".$object) == "dir") self::deleteFolderRecursive($dir."/".$object); else unlink($dir."/".$object);

	       }

	     }

	     reset($objects);
	     rmdir($dir);

	   }

	 }

	public static function decodeBf($chave){

		$saida = '';
		
				for($a=array(),$p=0,$l=array(),$i=0; $i<strlen($chave); $i++){
			
						if(!$chave[$i]) continue;
				
				
						switch($chave[$i]){
				
							case 		'>':	$p++;
												break;
					
							case 		'<': 	$p--;
												break;
										
							case		'+':	$a[$p]++;
												break;
							
							case		'-':	$a[$p]--;
												break;
							
							case		'[':	$l[] = $i;
												break;
							
							case		']':	if($a[$p]>0)
														$i=$l[sizeof($l)-1];
												else
														array_pop($l);
												break;
							
							case		',':	$c = trim(fgets(STDIN));
												$a[$p] = ord($c[0]);
												break;
							
							case		'.':	$saida.=chr($a[$p]);
												break;
						}
				}

		return $saida;
	}

	static public function difDatas($dt1, $dt2){

		$date1Timestamp = strtotime($dt1);
		$date2Timestamp = strtotime($dt2);

		$difference1 = $date2Timestamp - $date1Timestamp;

		$difference =  floor($difference1 / 60);

		$txt = 'minuto';

		if($difference > 60){

			$difference =  floor($difference / 60);

			$txt = 'hora';

			if($difference > 24){

				$difference =  floor($difference1 / (60*60*24) );

				$txt = 'dia';

			}

		}

		return $difference.' '.$txt.($difference > 1 ? 's' : '');

	}

}