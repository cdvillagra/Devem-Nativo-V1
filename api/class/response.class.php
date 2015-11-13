<?

class response {
	
	function __construct(){

	}

	public function errorRequest($code = ''){

		header('Content-type: application/json');

		switch ($code) {
			case 001:
				$mensagem = 'Nenhum dado recebido';
				break;

			case 902:
				$mensagem = 'Erro ao autenticar requisicao';
				break;

			case 903:
				$mensagem = 'Formato de resposta nao especificado';
				break;

			case 904:
				$mensagem = 'Metodo nao especificado';
				break;

			case 905:
				$mensagem = 'Modulo nao especificado';
				break;
			
			default:
				$mensagem = 'Erro inesperado';
				break;
		}

		$arrReturn = array('response' => false,
							'error_report' => $mensagem);

		echo json_encode($arrReturn);

	}

	public function responseRequest($code = '', $arquivo = false){

		header('Content-type: application/json');

		switch ($code) {

			case 001:
				$mensagem = 'Dados processados com sucesso';
				break;

			case 002:
				$mensagem = 'Dados atualizados com sucesso';
				break;

			case 003:
				$mensagem = 'Dados inseridos com sucesso';
				break;

			case 004:
				$mensagem = 'Dados excluidos com sucesso';
				break;
			
			default:
				$mensagem = 'Nenhuma resposta para o request';
				break;
		}

		$arrReturn = array('response' => true,
							'message_report' => $mensagem,
							'nome_arquivo' => $arquivo);

		echo json_encode($arrReturn);

	}

}