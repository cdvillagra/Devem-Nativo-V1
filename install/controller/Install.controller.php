<?php

/* 
-------------------------------------------------------------------- 
DEVEM License, versão 1.0 [Nativo]
Copyright (c) 2015 DVillagra. All rights reserved.
--------------------------------------------------------------------

Algumas observações de uso da framework:

  1. O uso de métodos e funções nativas da framework, requer um certo
     conhecimento mínimo de programação e lógica, com enfase em orientação
     a objeto e conhecimento em arquitetura MVC.
 
  2. Como sugestão, ao realizar alterações em quaquer arquivo do path Core
     o desenvolvedor deverá executar a sua implementação de forma generica
     para que em qualquer parte do sistema que utilizar o bloco implementado
     se comporte da forma esperada.

  3. Qualquer comunicação que o terceiro precisar realizar com a equipe
     de desenvolvimento ou qualquer outra equipe da DVILLAGRA, terá que
     ser realizada via formulário através da seguinte URL:
     <http://www.dvillagra.com.br/contato>".

ESTE SOFTWARE É FORNECIDO PELA EQUIPE DE DESENVOLVIMENTO DA DVILLAGRA
E POR SER UM SOFTWARE OPENSOURCE, NÃO GARANTE QUALQUER FUNCIONAMENTO
DA APLICAÇÃO DESENVOLVIDA PELO TERCEIRO, EM QUALQUER CIRCUNSTANCIA.
A CONTRIBUIÇÃO [IMPLEMENTAÇÃO] COM A FRAMEWORK É SEMPRE BEM VINDA, 
PORTANTO O TERCEIRO PODERÁ ENVIAR SUA CONTRIBUIÇÃO SEMPRE QUE QUISER
PARA QUE A EQUIPE DE HOMOLOGAÇÃO ANALISE E APROVE/REPROVE. EM CASO DE
APROVAÇÃO A CONTRIBUIÇÃO SERÁ INCLUIDA COMO PATCH VERSION. QUALQUER 
OUTRA INCLUSÃO DE SERVIDOR SERÁ REALIZADA PELA EQUIPE DE DESENVOLVIMENTO
DA DVILLAGRA, ONDE ALTERAÇÕES GERAIS HOMOLOGADAS SERÃO INSERIDAS COMO 
MINOR VERSION E FECHAMENTOS DE VERSÃO SERÁ INSERIDA COMO MAJOR VERSION.
--------------------------------------------------------------------
*/

/** 
 * Controller Install
 *
 * @package     app
 * @subpackage  controller 
 * @author      Christopher Villagra <christopher@dvillagra.com.br> 
 * @copyright   (c) 2015 - DEVEM
**/

session_start();

final class InstallController {

    private $request;

    /**
    * Metodo Construtor da Classe
    *
    * @author    Christopher Dencker Villagra
    * @return    resource
    */

	public function __construct($request) {

        $this->request = $request;

        // error_reporting(0);

	}

    public function installBanco(){

      $v_db_ativo = 'false';

      if($this->existeSession('db_no')){

        $arquivo = 'config\\conn.php';

        $this->gravaDado($arquivo, '[CONFIG_DB_SERVER]', $this->getSession('db_host'));
        $this->gravaDado($arquivo, '[CONFIG_DB_USUARIO]', $this->getSession('db_user'));
        $this->gravaDado($arquivo, '[CONFIG_DB_SENHA]', $this->getSession('db_pass'));
        $this->gravaDado($arquivo, '[CONFIG_DB_DATABASE]', $this->getSession('db_db'));

        require_once('../model/Install.model.php');

        $model = new InstallModel;

        $model->installBanco();

        $v_db_ativo = 'true';

      }

      $arquivo = 'config\\globals.php';

      $this->gravaDado($arquivo, "'[CONFIG_DB_ATIVO]'", $v_db_ativo);

      self::response(true);

    }

    public function installArquivos(){

      $arquivo = 'config\\globals.php';

      $v_api_key = md5(md5($this->keys()));

      $this->gravaDado($arquivo, '[CONFIG_G_API_KEY]', $v_api_key);

      $arquivo = 'api\\class\\service.class.php';

      $this->gravaDado($arquivo, '[CONFIG_G_API_KEY]', md5($v_api_key));

      self::response(true);

    }

    public function installParametros(){

      $arquivo = 'config\\globals.php';

      if(!$this->existeSession('db_no')){

        require_once('../model/Install.model.php');

        $model = new InstallModel;

        $model->installParametros();

      }else{

        $this->gravaDado($arquivo, '[CONFIG_S3_SECRET]', $this->getSession('s3_secret'));
        $this->gravaDado($arquivo, '[CONFIG_S3_KEY]', $this->getSession('s3_key'));
        $this->gravaDado($arquivo, '[CONFIG_S3_BUCKET]', $this->getSession('s3_bucket'));
        $this->gravaDado($arquivo, '[CONFIG_S3_URL]', $this->getSession('s3_url'));

        $this->gravaDado($arquivo, '[CONFIG_MAIL_HOST]', $this->getSession('email_host'));
        $this->gravaDado($arquivo, '[CONFIG_MAIL_SECU]', $this->getSession('email_secure'));
        $this->gravaDado($arquivo, '[CONFIG_MAIL_USUARIO]', $this->getSession('email_usuario'));
        $this->gravaDado($arquivo, '[CONFIG_MAIL_SENHA]', $this->getSession('email_senha'));
        $this->gravaDado($arquivo, '[CONFIG_MAIL_PORTA]', $this->getSession('email_porta'));
        $this->gravaDado($arquivo, '[CONFIG_MAIL_REMETENTE_NOME]', $this->getSession('email_rementente_nome'));
        $this->gravaDado($arquivo, '[CONFIG_MAIL_REMETENTE_EMAIL]', $this->getSession('email_rementente_email'));

      }

      $this->gravaDado($arquivo, "'[CONFIG_IGNORE_AUTH]'", ($this->existeSession('auth_app') ? 'true' : 'false' ));

      $this->gravaDado($arquivo, '[CONFIG_SESSION_APP]', $this->keys(5, true));
      $this->gravaDado($arquivo, '[CONFIG_SESSION_ADMIN]', $this->keys(5, true));

      $this->gravaDado($arquivo, '[CONFIG_ADM_KEY]', 'ADM'.$this->keys(10));

      self::response(true);

    }

    public function installAdmin(){

      $v_admin_via_db = 'true';

      $arquivo = 'config\\globals.php';

      if($this->existeSession('db_no')){

        require_once('../model/Install.model.php');

        $model = new InstallModel;

        $model->installAdmin();

      }else{

        $this->gravaDado($arquivo, '[CONFIG_ADM_CONN_USUARIO]', $this->getSession('adm_usuario'));
        $this->gravaDado($arquivo, '[CONFIG_ADM_CONN_SENHA]', $this->getSession('adm_senha'));

        $v_admin_via_db = 'false';

      }

      $this->gravaDado($arquivo, "'[CONFIG_ADM_VIA_DB]'", $v_admin_via_db);

      self::response(true);

    }

    public function installFinish(){

      $arquivo = 'config\\globals.php';

      $this->gravaDado($arquivo, '//#[DV_INSTALL]', 'define("DV_INSTALL", true);');

    }

    public function testeDb(){

      if(!isset($this->request['db_no'])){

        $conn = mysql_connect($this->request['db_host'], $this->request['db_user'], $this->request['db_pass']) or die(self::response(false)); 

         mysql_select_db($this->request['db_db'], $conn) or die (self::response(array('db'=> false)));
        
        self::response(true);

      }else{

        self::response(true);

      }
               

    }

    private static function response($data){

        header('Content-type: application/json');

        echo json_encode($data);

    }

    public function gravaSession(){

        foreach ($this->request as $key => $value)
          $_SESSION['_devem_install_'][$key] = $value;

        self::response($_SESSION['_devem_install_']); 

    }

    public function existeSession($key){

      return isset($_SESSION['_devem_install_'][$key]);

    }

    private function getSession($key){

        return @$_SESSION['_devem_install_'][$key];

    }

    private function gravaDado($arquivo, $campo, $valor){

      $path = str_replace("install\\controller\\", "", getcwd()."\\".$arquivo);

      file_put_contents($path,str_replace($campo,$valor,file_get_contents($path)));

    }

    private static function keys($tamanho = 8, $numeros = false)
    {

      $retorno = '';

      $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%*-';

      if($numeros)
        $caracteres = '1234567890';
    
      $len = strlen($caracteres);

      for ($n = 1; $n <= $tamanho; $n++) {

        $rand = mt_rand(1, $len);
        $retorno .= $caracteres[$rand-1];

      }

      return $retorno;

    }


}

$data = (!empty($_POST) ? $_POST : (!empty($_GET) ? $_GET : (!empty($_REQUEST) ? $_REQUEST : false)));

$class = new InstallController($data);

$class->$data['method']();
