<?php
/*
 * @Projeto: 	Devem
 * @Script: 	Classe de Url php no MVC
*/

class Url
{

	public function __construct()
	{
		parent::__construct(true);
	}

	static function urlSite($arquivo = ''){

		return 'http://[SUA_URL_HARDCODE]/'.$arquivo;

	}

	static function defineUrl(){

		$host = $_SERVER['HTTP_HOST'];

		$name = $_SERVER['SERVER_NAME'];

		$protocolo_s = $_SERVER['SERVER_PROTOCOL'];
		$protocolo = 'http://';

		if(strstr($host, ':8080'))
			$host = $name;

		if(strpos(strtolower($protocolo_s), 'https') !== false)
			$protocolo = 'https://';

		$uri = explode('/',$_SERVER['REQUEST_URI']);

		return $protocolo . $host . '/' . $uri[1] . '/' ;

	}

	static function url(){
		return URL;
	}

	static function base($arquivo, $url_base = false, $custom = false){

		$prefix = URL;

		if($url_base)
			$prefix = '';

		if(($custom !== false) && (file_exists(Configuracoes::CustomerTemp().$arquivo)))
			return $prefix.Configuracoes::CustomerTemp().$arquivo;

		if(file_exists(Configuracoes::PasteCustomer().$arquivo))
			return $prefix.Configuracoes::PasteCustomer().$arquivo;

		return $prefix.$arquivo;

	}

	static function baseAdmin($arquivo){

		$prefix = URL.'admin/';

		return $prefix.$arquivo;

	}

	static function checkURLCustomer(){

		$retorno = false;

		$host = $_SERVER['HTTP_HOST'];
		$name = $_SERVER['SERVER_NAME'];

		if(strstr($host, ':8080'))
			$host = $name;

		if($host != 'localhost'){

			$exp_host = explode('.', $host);

			if($exp_host[1] != '[nome_seu_dominio_sem_prefixo]')
				$retorno = substr($host, 4);

		}

		return $retorno;

	}

	static function imgApp($arquivo, $custom = false, $admin = false){

		$path_default = 'app/view/default/img/';

		if($admin !== false)
			$path_default = 'admin/view/img/';

		if(($custom !== false) && (file_exists(Configuracoes::CustomerTemp().$path_default.$arquivo)))
			return URL.Configuracoes::CustomerTemp().$path_default.$arquivo;

		if(file_exists(Configuracoes::PasteCustomer().$path_default.$arquivo))
			return URL.Configuracoes::PasteCustomer().$path_default.$arquivo;

		return URL.$path_default.$arquivo;

	}

	static function fileMedia($modulo, $arquivo){

		$path_default = 'media/';

		$url = $path_default.$modulo.'/'.$arquivo;

		return URL.$url;

	}

	static function fileUpload($arquivo){

		$path_default = 'upload/';

		$url = $path_default.$arquivo;

		return URL.$url;

	}

	static function fileS3($modulo, $arquivo){

		return Configuracoes::Valor('s3_url').$modulo.'/'.$arquivo;

	}

}