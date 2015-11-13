<?php

abstract class Configuracoes
{

	static function CustomerTemp(){

		$dia = date('Ymd');
		$hora = date('H:i:s');

		$arrReturn = false;

		$arrAgendamento = array();

		$getByXML = Utilitarios::xmlToArray('core/xml/envelopamento.xml');
		
		foreach ($getByXML as $k) {
			$arrAgendamento[] = $k;
		}
		

		if(empty($arrAgendamento))
			return false;

		foreach ($arrAgendamento as $k) {
			
			if(
				($k['dt_inicio'] <= $dia) && 
				(($k['dt_fim'] == null) || ($k['dt_fim'] >= $dia)) &&
				($k['hr_inicio'] <= $hora) 	&&
				(($k['hr_fim'] == null) || ($k['hr_fim'] >= $hora))
				){

				$arrReturn = 'customer/'.$k['pasta_customer'].'/';
				break;

			}

		}

		return $arrReturn;

	}

	public static function CheckFileCustomer($arquivo, $url = false, $fcustom = false, $fignore = false){

		$st_admin = isset($_REQUEST['admin']) ? true : false;

		$path_default = ($st_admin !== false ? 'admin/view' : 'app/view/default');

		$prefix = '';

		if($url !== false)
			$prefix = Url::url();

		if(substr($arquivo, 1) != '/')
			$path_default = $path_default.'/';
		
		if($fignore === false){

			if($fcustom !== false)
				return $prefix . self::CustomerTemp() .$path_default.$arquivo;
		}

		if(file_exists(Configuracoes::PasteCustomer().$path_default.$arquivo))
			return $prefix . Configuracoes::PasteCustomer().$path_default.$arquivo;

		return $prefix . $path_default.$arquivo;

	}

	public static function checkFileExist($file, $path = null, $customer = null){

		$prefix = '';

		if(is_null($path))
			$path = "app/view/default";

		if(!is_null($customer))
			$prefix = Configuracoes::PasteCustomer();

		return file_exists($prefix.'/'.$path.'/'.$file);

	}
	
	public static function Valor( $val )
    {	
    	if(DB_ATIVO !== false){

	        $repositorio = new Repositorio(true);
	    	$repositorio->pQuery("SELECT pValorAtual FROM dv_parametros WHERE pChave = '". FiltroDeDados::LimpaString($val) ."'");
			$repositorio->ExecutaQuery();

			# Controle de verificação de existência de parâmetros.
			if($repositorio->TotalRows() == 0)
				throw new RuntimeException("Parece que o parâmetro [". FiltroDeDados::LimpaString($val) ."] não existe no banco de dados.");

			$row = $repositorio->Lista();

			return $row['pValorAtual'];

		}else{

			if(!defined(strtoupper($val)))
				throw new RuntimeException("Parece que o parâmetro [". FiltroDeDados::LimpaString($val) ."] não existe no banco de dados.");

			return constant(strtoupper($val));

		}
	}

    public static function Set( $param, $val )
    {	
        $valor_anterior = self::Valor($param);

        $query = "UPDATE dv_parametros SET pValorAtual = :val WHERE pChave = :param";

        $binds = array(
        	':val'   => $val,
        	':param' => $param
        );

		return Repositorio::db()->pQuery($query)->executaQuery($binds);

	}

	public static function Subdominio(){

		$customer = $_SERVER['HTTP_HOST'];
		
		if(strstr($_SERVER['HTTP_HOST'], ':8080'))
			$customer = $_SERVER['SERVER_NAME'];

		$tmp = explode(".", $customer);
		
		return $tmp[0];

	}
	
	public static function PasteCustomer(){

		$customer = $_SERVER['HTTP_HOST'];

		if(strstr($_SERVER['HTTP_HOST'], ':8080'))
			$customer = $_SERVER['SERVER_NAME'];

		$tmp = explode(".", $customer);

		$custom_path = '';

		if($tmp[0] != 'www'){

			$custom_path = 'customer/'.$tmp[0].'/';

		}

		return $custom_path;

	}
	
	public static function ChecaViewCustomer($phtml, $type){

		$arquivo_customer = '../customer/'.Configuracoes::PasteCustomer().'/'.$type.'/'.$phtml;

		if(is_file($arquivo_customer)){

			$retorno = $arquivo_customer;

		}else{

			$retorno = 'app/view/layout/'.$phtml;

		}

		return $retorno;
	}

	public static function meuIP() {

		if(isset($_SERVER['HTTP_X_SUCURI_CLIENTIP'])){

		    $ipAddress = trim($_SERVER['HTTP_X_SUCURI_CLIENTIP']);

		}else{

		    $ipAddress = trim($_SERVER['REMOTE_ADDR']);

		}
	        
	    return($ipAddress);
	    
	}

}