<?
class geoPlugin {
	
	//the geoPlugin server
	private $host = 'http://www.geoplugin.net/php.gp?ip=';
	
	private $ip;
	
	function __construct($ip = null) {
	
		$this->ip = $ip;

	}
	
	public function locate() {
		
		$return = false;
		
		if ( is_null( $this->ip ) ) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		
		$data = array();
		
		$response = $this->fetch($this->host.$this->ip);
		
		$data = unserialize($response);

		print_r($data);

		$pos = strpos($data['geoplugin_region'], 'S&atilde;o Paulo');
		
		if($pos !== false)
			$return = true;
		
		return $return;
	}
	
	private function fetch($host) {

		if ( function_exists('curl_init') ) {
						
			//use cURL to fetch data
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $host);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, 'geoPlugin PHP Class v1.0');
			$response = curl_exec($ch);
			curl_close ($ch);
			
		} else if ( ini_get('allow_url_fopen') ) {
			
			//fall back to fopen()
			$response = file_get_contents($host, 'r');
			
		} else {

			trigger_error ('geoPlugin class Error: Cannot retrieve data. Either compile PHP with cURL support or enable allow_url_fopen in php.ini ', E_USER_ERROR);
			return;
		
		}
		
		return $response;
	}

	
}