<?php
/*
 * @Projeto: 	Devem
 * @Script: 	Classe de Log php no MVC
*/

class Log
{

	public function __construct()
	{
		parent::__construct(true);
	}

	static public function grava($mensagem, $id = null){

		$dataHj = date('Ymd');

		$path = getcwd()."\\log\\".$dataHj.".txt";

		$handle = fopen($path, "a+");

		$contents = date('d-m-Y H:i:s').' ->  '.$mensagem. "\n";

		fwrite($handle, $contents);

		fclose ( $handle ); 

	}

}