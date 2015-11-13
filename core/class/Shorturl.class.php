<?php


class Shorturl
{
	private $caracteres = '23456789weryuiokjhfsazxcvQWERYULKJHGFSAZXCV';
	private $tamanhoPadrao = 5;
	
	public function Chave($url, $chave = false){
		
		$chave = $this->verificaChave($chave);

        $repositorio = new Repositorio(true);
		$repositorio->pQuery(
					   'INSERT INTO shorturl
						(tx_chave, tx_url)
						VALUES 
						("' . $chave . '", "' . $url . '")
						');
		
		$repositorio->ExecutaQuery();
		return $chave;
		
	}
	
	public function Url($chave){
		
        $repositorio = new Repositorio(true);
    	$repositorio->pQuery("SELECT * FROM shorturl WHERE tx_chave = '{$chave}'");
		$repositorio->ExecutaQuery();

		if($repositorio->TotalRows() == 0){
			return false;
		}
		
		$row = $repositorio->Lista();

		return $row['tx_url'];
	}
	
	private function verificaChave($chave){
		if($chave){
			$chave = substr($chave, 0, 10);
		}
		else{
			$string = ''; 
			for($i = 0; $i < $this->tamanhoPadrao; $i++){
				$string .= $this->caracteres[rand(0, (strlen($this->caracteres) - 1))];
			}
			$chave = $string;
		}
		
        $repositorio = new Repositorio(true);
    	$repositorio->pQuery("SELECT * FROM shorturl WHERE tx_chave = '{$chave}'");
		$repositorio->ExecutaQuery();

		# Caso a chave já tenha correspondência, faz uma nova busca por uma chave aleatória
		if($repositorio->TotalRows() != 0){
			$chave = $this->verificaChave(false);
		}
		
		return $chave;
	}
}