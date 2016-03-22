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

    /**
     * Método que define variaveis de banco de dados e grava as globais para serem utilizadas futuramente na framework
     *
     * @author  Christopher Villagra
     * @param   session
     * @return  json
    */

    public function installBanco(){

      //# Pré define a variável de utilização de banco, que será setada nas globais
      $v_db_ativo = 'false';

      //# Realiza uma verificação se o usuário setou para utilizar ou não banco de dados
      if(filter_var($this->getSession('db_no'), FILTER_VALIDATE_BOOLEAN)){

        $arquivo = 'config'.DIRECTORY_SEPARATOR.'conn.php';

        //# Realiza os sets para as variaveis globais a ser utilizada pelo DEVEM
        $this->gravaDado($arquivo, '[CONFIG_DB_SERVER]', $this->getSession('db_host'));
        $this->gravaDado($arquivo, '[CONFIG_DB_USUARIO]', $this->getSession('db_user'));
        $this->gravaDado($arquivo, '[CONFIG_DB_SENHA]', $this->getSession('db_pass'));
        $this->gravaDado($arquivo, '[CONFIG_DB_DATABASE]', $this->getSession('db_db'));

        //# Instancia a model e cria as tabelas necessárias para a FW rodar
        require_once('../model/Install.model.php');

        $model = new InstallModel;
        $model->installBanco();

        //# Define a variável de utilização de banco, que será setada nas globais
        $v_db_ativo = 'true';

      }


      $arquivo = 'config'.DIRECTORY_SEPARATOR.'globals.php';

      $this->gravaDado($arquivo, "'[CONFIG_DB_ATIVO]'", $v_db_ativo);

      self::response(true);

    }

    /**
     * Método que define o key de acesso à api e grava as globais para serem utilizadas futuramente na framework
     *
     * @author  Christopher Villagra
     * @return  json
    */

    public function installArquivos(){

      //# Define a localização do arquivo e grava a variavel de autenticação com a api interna
      $arquivo = 'config'.DIRECTORY_SEPARATOR.'globals.php';

      $v_api_key = md5(md5($this->keys()));

      $this->gravaDado($arquivo, '[CONFIG_G_API_KEY]', $v_api_key);

      //# Define a localização do arquivo e grava a variavel de autenticação no arquivo de serviço da api interna
      $arquivo = 'api'.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'service.class.php';

      $this->gravaDado($arquivo, '[CONFIG_G_API_KEY]', md5($v_api_key));

      self::response(true);

    }

    /**
     * Método que define as variaveis de parametros, inseridas pelo usuário, e grava no banco de dados ou no arquivo de globais para serem utilizadas futuramente na framework
     *
     * @author  Christopher Villagra
     * @param   session
     * @return  json
    */

    public function installParametros(){

      $arquivo = 'config'.DIRECTORY_SEPARATOR.'globals.php';

      //# Realiza uma verificação se o usuário setou para utilizar ou não banco de dados
      if(filter_var($this->getSession('db_no'), FILTER_VALIDATE_BOOLEAN)){

        //# Instancia a model e inserir os parametros necessários, ou não, para a FW rodar
        require_once('../model/Install.model.php');

        $model = new InstallModel;
        $model->installParametros();

      }else{

        //# Grava todas os parametros no arquivo de globais, já que o usuário optou por não utilizar nenhuma base de dados
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

    /**
     * Método que define alguns dados do admin
     *
     * @author  Christopher Villagra
     * @param   session
     * @return  json
    */

    public function installAdmin(){

      //# Pré define a variável de utilização de banco pelo admin, que será setada nas globais
      $v_admin_via_db = 'true';

      $arquivo = 'config'.DIRECTORY_SEPARATOR.'globals.php';

      //# Realiza uma verificação se o usuário setou para utilizar ou não banco de dados
      if(filter_var($this->getSession('db_no'), FILTER_VALIDATE_BOOLEAN)){

        //# Instancia a model e inserir os dados de admin necessários, para o admin da FW rodar
        require_once('../model/Install.model.php');

        $model = new InstallModel;
        $model->installAdmin();

      }else{

        //# Inseri nas globais os dados de admin necessários, para o admin da FW rodar
        $this->gravaDado($arquivo, '[CONFIG_ADM_CONN_USUARIO]', $this->getSession('adm_usuario'));
        $this->gravaDado($arquivo, '[CONFIG_ADM_CONN_SENHA]', $this->getSession('adm_senha'));

        $v_admin_via_db = 'false';

      }

      $this->gravaDado($arquivo, "'[CONFIG_ADM_VIA_DB]'", $v_admin_via_db);

      self::response(true);

    }

    /**
     * Método que seta a instalação como concluída, para controle, caso algum passo seja interrompido no meio
     *
     * @author  Christopher Villagra
    */

    public function installFinish(){

      $arquivo = 'config'.DIRECTORY_SEPARATOR.'globals.php';

      $this->gravaDado($arquivo, '//#[DV_INSTALL]', 'define("DV_INSTALL", true);');

    }

    /**
     * Método que seta a instalação como concluída, para controle, caso algum passo seja interrompido no meio
     *
     * @author  Christopher Villagra
     * @param   REQUEST
    */

    public function testeDb(){

      if(!isset($this->request['db_nos'])){

        $conn = mysql_connect($this->request['db_host'], $this->request['db_user'], $this->request['db_pass']) or die(self::response(false)); 

        mysql_select_db($this->request['db_db'], $conn) or die (self::response(array('db'=> false)));
        
        self::response(true);

      }else{

        self::response(true);

      }
               

    }

    /**
     * Método que 'constroi' o retorno json para a requisição realizada pelo js
     *
     * @author  Christopher Villagra
     * @param   $data => [string/array/boolean]
     * @return  json
    */

     private static function response($data){

        header('Content-type: application/json');

        echo json_encode($data);

    }

    /**
     * Método que grava os dados do request na sessão
     *
     * @author  Christopher Villagra
     * @param   string/array/boolean
     * @return  json
    */

    public function gravaSession(){

        foreach ($this->request as $key => $value)
          $_SESSION['_devem_install_'][$key] = $value;

        self::response($_SESSION['_devem_install_']); 

    }

    /**
     * Método que checa se a chave existe na sessão
     *
     * @author  Christopher Villagra
     * @param   $key [string/int]
     * @return  boolean
    */

    public function existeSession($key){

      return isset($_SESSION['_devem_install_'][$key]);

    }

    /**
     * Método que checa se a chave existe na sessão
     *
     * @author  Christopher Villagra
     * @param   $key [string/int]
     * @return  [string/array/boolean]
    */

    private function getSession($key){

        return @$_SESSION['_devem_install_'][$key];

    }

    /**
     * Método que grava os dados nos arquivos de config
     *
     * @author  Christopher Villagra
     * @param   $arquivo [string]
     * @param   $campo [string]
     * @param   $valor [string]
    */

    private function gravaDado($arquivo, $campo, $valor){

      $path = str_replace('install'.DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR, "", getcwd().DIRECTORY_SEPARATOR.$arquivo);

      file_put_contents($path,str_replace($campo,$valor,file_get_contents($path)));

    }

    /**
     * Método auxiliar para criar chaves
     *
     * @author  Christopher Villagra
     * @param   $tamanho [int]
     * @param   $numeros [boolean]
     * @return  string
    */

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

//# Tratamento simples para que qualquer argumento de qualquer verbo seja inserido na variavel $data, como um request global
$data = (!empty($_POST) ? $_POST : (!empty($_GET) ? $_GET : (!empty($_REQUEST) ? $_REQUEST : false)));


//# Verifica se o metodo foi enviado na requisição
if(isset($data['method'])){

  //# Instancia a classe local e chama o método que foi recebido no request, se o mesmo existir
  $class = new InstallController($data);

  if(function_exists($class->$data['method']()))
    $class->$data['method']();

}
