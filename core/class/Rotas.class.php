<?php

/*
 * @Projeto: 	Devem
 * @Script: 	Classe de Aplicação das Rotas do MVC
*/

class Rotas
{
    protected $st_controller;
    protected $st_action;
    protected $st_admin;

    private static $sem_autenticacao;

    private static $exceptionAdmin = array(   
                                                'login',
                                                '[OUTRAS_CONTROLLERS]'
                                            );

    private static $exceptionApp = array(   
                                                'customer',
                                                'principal' => array('index', '[OUTRAS_ACTIONS]'),
                                                'login',
                                                '[OUTRAS_CONTROLLERS]'
                                            );

    private static $ignore_autenticacao = IGNORE_AUTH;

    public static $autenticacao = true;
  
    private function LeRotas()
    {

        $_POST    = Seguranca::SQLAntiInjection($_POST);
        $_GET     = Seguranca::SQLAntiInjection($_GET);
        $_REQUEST = Seguranca::SQLAntiInjection($_REQUEST);


        if(!isset($_REQUEST['controle']) && !isset($_REQUEST['acao']))
            header(URL);
        
        $this->st_controller = isset($_REQUEST['controle']) ?  ucfirst(strtolower($_REQUEST['controle'])) : 'Principal';
        $this->st_action     = isset($_REQUEST['acao'])     ?  $_REQUEST['acao']     : 'index';
        $this->st_admin      = isset($_REQUEST['admin'])     ?  true     : false;

        self::$sem_autenticacao = $this->st_admin ? self::$exceptionAdmin : self::$exceptionApp;

        if(($this->st_admin) || ((!$this->st_admin) && (self::$ignore_autenticacao === false)))
            $this->validaAutenticacao();

        if((self::$autenticacao !== true) && !Auth::loginValido())
            throw new Exception('Acesso negado, este módulo necessita autenticação');
    }
    
    public function Dispara()
    {
        $this->LeRotas();

        $st_controller_file = ($this->st_admin !== false ? 'admin/' : 'app/').'controller/'. $this->st_controller .'.controller.php';

        if(file_exists(Configuracoes::PasteCustomer().'/'.$st_controller_file)){

            require_once Configuracoes::PasteCustomer().'/'.$st_controller_file;  

        }else if(file_exists($st_controller_file)){

            require_once $st_controller_file;  

        }else{

            throw new Exception('Arquivo '.$st_controller_file.' nao encontrado');

        }

        $st_class = $this->st_controller .'controller';

        if(!class_exists($st_class))
            throw new Exception("Esta classe '$st_class' nao existe no arquivo '$st_controller_file'");
        
        $o_class = new $st_class;
        $st_method = $this->st_action .'Action';

        if(!method_exists($o_class, $st_method))
             throw new BadMethodCallException("Este Metodo '$st_method' nao existe na classe $st_class'");

        /**
         * $args = ...$_REQUEST escapada;
         * @todo  $o_class->{$st_method}($args);
         */
        $o_class->{$st_method}();
    }

    public function validaAutenticacao() {

        $auth = false;

        foreach (self::$sem_autenticacao as $key => $value) {

            if(is_numeric($key) && (strtolower($value) == strtolower($this->st_controller))){
                $auth = true;
                break;
            }

            if(is_array($value) && (strtolower($key) == strtolower($this->st_controller))){

                foreach ($value as $k) {

                    if(strtolower($k) == strtolower($this->st_action)){
                        $auth = true;
                        break;
                    }

                }

            }

        }

        self::$autenticacao = $auth;
    }
}