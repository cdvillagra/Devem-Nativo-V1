<?php

final class Autoloader {

	private $custom_status = false;
	private $custom_path;
    private $st_admin;
        
    public static function Register() {

    	$self = new self();

    	$self->st_admin = isset($_REQUEST['admin']) ? true : false;

    	//# Verifica antes de mais nada se é um subdominio [Cliente customizado] para setar o path customizado
    	$customer = $_SERVER['HTTP_HOST'];

		if(strstr($_SERVER['HTTP_HOST'], ':8080'))
			$customer = $_SERVER['SERVER_NAME'];

		$tmp = explode(".", $customer);

		if($tmp[0] != 'www'){

			$self->custom_status = true;
			$self->custom_path = 'customer/'.$tmp[0].'/';

		}
    	
        spl_autoload_register(array($self, 'Loader'));
    }

    private function Loader($class) {

    	if(class_exists($class) || interface_exists($class))
    		return;

    	# Define as classes anciãs.
    	$ancients = array('Model', 'Controller', 'Helper', 'Interface');
    	$class_file = $class;

    	# Valida se a classe sendo incluída não é uma das anciãs.
    	if( !in_array($class, $ancients)) {

	        # Limpando o nome das classes.
	        foreach($ancients as $a)
	        	$class_file = str_replace($a, '', $class_file);
	        
		}

	    if(file_exists('core/class/'. $class_file .'.class.php')) {

	        require_once 'core/class/'. $class_file .'.class.php';
	    }

	    //# Load nas classes da camada Model, verificando se existe um arquivo customizado
	    if(($this->custom_status !== false) && (file_exists($this->custom_path.'app/model/'. $class_file .'.model.php') && strstr($class, 'Model'))) {

	    	require_once $this->custom_path.'app/model/'. $class_file .'.model.php';

	    }else if(file_exists(($this->st_admin !== false ? 'admin/' : 'app/').'model/'. $class_file .'.model.php') && strstr($class, 'Model')) {

	        require_once ($this->st_admin !== false ? 'admin/' : 'app/').'model/'. $class_file .'.model.php';
	    }

	    //# Load nas classes da camada Controller, verificando se existe um arquivo customizado
	    if(($this->custom_status !== false) && (file_exists($this->custom_path.'app/controller/'. $class_file .'.controller.php') && strstr($class, 'Controller'))) {

	        require_once $this->custom_path.'app/controller/'. $class_file .'.controller.php';

	    }else if(file_exists(($this->st_admin !== false ? 'admin/' : 'app/').'controller/'. $class_file .'.controller.php') && strstr($class, 'Controller')) {

	        require_once ($this->st_admin !== false ? 'admin/' : 'app/').'controller/'. $class_file .'.controller.php';
	    }

	    //# Load nas classes da camada Helper, verificando se existe um arquivo customizado
	    if(($this->custom_status !== false) && (file_exists($this->custom_path.'app/helper/'. $class_file .'.helper.php'))) {

	        require_once $this->custom_path.'app/helper/'. $class_file .'.helper.php';

    	}else if(file_exists(($this->st_admin !== false ? 'admin/' : 'app/').'helper/'. $class_file .'.helper.php')) {

	        require_once ($this->st_admin !== false ? 'admin/' : 'app/').'helper/'. $class_file .'.helper.php';
    	}

    	//# Load nas classes da camada Interface, verificando se existe um arquivo customizado
	    if(($this->custom_status !== false) && (file_exists($this->custom_path.'app/interface/'. $class_file .'.interface.php') && $class[0] == 'I')) {

	        require_once $this->custom_path.'app/interface/'. $class_file .'.interface.php';

	    }else if(file_exists(($this->st_admin !== false ? 'admin/' : 'app/').'interface/'. $class_file .'.interface.php') && $class[0] == 'I') {

	        require_once ($this->st_admin !== false ? 'admin/' : 'app/').'interface/'. $class_file .'.interface.php';
	    }

    	//# Load nas classes da camada Interface, verificando se existe um arquivo customizado
	   	if(file_exists('modulo/'.$class_file.'/'. $class_file .'.class.php')) {

	        require_once 'modulo/'.$class_file.'/'. $class_file .'.class.php';
	    }

    }
}