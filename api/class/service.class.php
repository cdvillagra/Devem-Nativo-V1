<?

require_once 'functions.class.php';
require_once 'response.class.php';

final class webService{

	private $hashPass = '[CONFIG_G_API_KEY]';
	private $request;
	private $requestKey;
	private $requestFormat;
	
	function __construct(){

		$this->r = new response;

	}

	public function iniciaWs(){

		if(!$this->trataRequest())
			throw new Exception($this->r->errorRequest(901));

		if(!$this->authRequest())
			throw new Exception($this->r->errorRequest(902));

		if(!$this->actionRequest())
			throw new Exception($this->r->errorRequest());

	}

	private function trataRequest(){

		$this->request = (!empty($_POST) ? $_POST : (!empty($_GET) ? $_GET : (!empty($_REQUEST) ? $_REQUEST : false)));

		if(!$this->request)
			return false;

		if(!isset($this->request['key']) || empty($this->request['key']))
			throw new Exception($this->r->errorRequest(902));

		if(!isset($this->request['format']) || empty($this->request['format']))
			throw new Exception($this->r->errorRequest(903));

		if(!isset($this->request['method']) || empty($this->request['method']))
			throw new Exception($this->r->errorRequest(904));

		if(!isset($this->request['module']) || empty($this->request['module']))
			throw new Exception($this->r->errorRequest(905));

		$this->requestKey = $this->request['key'];

		return true;

	}

	private function authRequest(){


		
		if($this->hashPass != md5($this->requestKey))
			throw new Exception($this->r->errorRequest(902));

		return true;

	}

	private function actionRequest(){

		$this->f = new functions($this->request);

		$acao = $this->f->{$this->request['method']}();

		if(!$acao)
			return false;

		$this->r->responseRequest(000, $acao);

		return true;

	}

}