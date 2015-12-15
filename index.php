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

//# Define a versão do Devem Atual
define('DEVEM_VERSAO', 'Devem Nativo V 1.1.4');

//# Verifica se existe a pasta install para instalar as dependencias da framework
if(is_dir('install')){

    //# Direciona para o diretorio de instalação
    header('location: '.$_SERVER['REQUEST_URI'].'install');
    die;

}

//# Inicia a session
session_start();

//# Inicia o armazenamento em buffer
ob_start('ob_gzhandler');

//# Seta o tipo de conteudo e o charset
header("Content-Type: text/html; charset=UTF-8", true);

//# Sets de localização
setlocale(LC_ALL, NULL);
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
set_time_limit(300);

//# Define a conexão com o banco de dados
require_once ('config/globals.php');

//# Define se é uma atividade no Admin
$sessionId = isset($_REQUEST['admin']) ? SESSION_ADMIN : SESSION_APP;
define('SESSION_ID', $sessionId);
define('ADMIN_USE', isset($_REQUEST['admin']));

//# Chama a classe de autoloader para iniciar todas as classes do sistema
require_once ('core/class/Autoloader.class.php');

//# Chamada do método estático que registra todas as classes
Autoloader::Register();


//# Condição que aguarda o recebimento da variavel que habilita a visualização dos erros na página
if(isset($_GET['SHOW_E'])){

    //# Cria a variavel de sessão para a exibição de erro de acordo com o recebimento da variavel GET
    Session::set('SHOW_E', filter_var($_GET['SHOW_E'], FILTER_VALIDATE_BOOLEAN));

}else{

    //# Caso a variavel de sessão ainda não exista, ele cria a variavel com o valor booleano FALSE
    if(!Session::realmenteExiste('SHOW_E'))
        Session::set('SHOW_E', false);

}

//# Realiza a verificação da variavel de sessão de controle de exibição de erros, exibindo-os quando for TRUE
if(Session::get('SHOW_E') !== false){

    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    
} 


//#verifica URL customizada iniciadas em www
$valida_customer = Url::checkURLCustomer();

if($valida_customer !== false){

    header('Location: http://'. $valida_customer);
    die();

}

//# Define a conexão com o banco de dados
require_once ('config/conn.php');


//# Define Url Default do sistema
define('URL', Url::defineUrl());

if(ADMIN_USE !== false){
  
  //# Verifica se está logado
  $cLogin = new LoginController;
  $cLogin->checkLoginCookie();

}


try {

    //# Trata as rotas do MVC
    $GerarRota = new Rotas();
    $GerarRota->Dispara();

    unset($GerarRota);

} catch (Exception $e) {
    
    if(Session::get('SHOW_E') === false){

        //# Redireciona para a pagina de erro
        if(Rotas::$autenticacao){

            Utilitarios::errorpage(404);

        }else{

            Utilitarios::redirect((isset($_REQUEST['admin']) ? 'admin/' : '').'login');

        }

    }else{

        //# Exibe a trace da exception
        echo '<pre>';
        print_r($e->getMessage());
        print_r($e->getTrace());
        echo '</pre>';

    }

}
