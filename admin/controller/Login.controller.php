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
 * Controller Login
 *
 * @package     app
 * @subpackage  controller 
 * @author      Christopher Villagra <christopher@dvillagra.com.br> 
 * @copyright   (c) 2015 - DEVEM
**/

final class LoginController extends Controller {

    /**
    * Metodo Construtor da Classe
    *
    * @author    Christopher Dencker Villagra
    * @return    resource
    */

	public function __construct() {

        $this->model = new LoginModel;

	}

    public function indexAction(){

        $view = new View('layout/login.phtml');

        $view->Show();
    }

    public function confirmaAction(){

        $view = new View('layout/modal-confirma.phtml');

        $view->pParametros(array(
                                'titulo' => $_GET['titulo'],
                                'texto' => $_GET['texto'],
                                'label_bt' => $_GET['label_bt'],
                                'acao_bt' => $_GET['acao_bt']
                                )
                        );

        $view->Show();
    }

    public function alertaAction(){

        $view = new View('layout/modal-alerta.phtml');

        $view->pParametros(array(
                                'titulo' => $_GET['titulo'],
                                'texto' => $_GET['texto'],
                                'label_bt' => $_GET['label_bt']
                                )
                        );

        $view->Show();
    }

    public function esqueciAction(){

        $view = new View('layout/login-esqueci.phtml');

        $view->Show();
    }

    public function esqueciConfirmacaoAction(){

        $view = new View('layout/login-esqueci-confirmacao.phtml');

        $view->Show();
    }

    

    public function validarAction(){

        //# Indica que o retorno é do tipo json
        header('Content-type: application/json');

        //# Atribui os valores do e-mail e senha inserido pelo usuario nas propriedades de EMAIL e SENHA
        $usr = FiltroDeDados::LimpaString($_POST['lg_usuario']);
        $psw = FiltroDeDados::LimpaString($_POST['lg_senha']);
        $con = FiltroDeDados::LimpaString(@$_POST['contectado']); 

        $validador = $this->login($usr, $psw, $con); 


        echo json_encode($validador);

    }

    public function checkLoginCookie(){

        if(!Session::get('login') && Cookie::verificaCookie('devem_lg_adm_connect_'.ADM_KEY)){


            $this->model->pcodeCookie(Cookie::valorCookie('devem_lg_adm_connect_'.ADM_KEY));

            $retorno = $this->model->checkLoginCookie();

            if($retorno)
               $this->login($retorno['auLogin'], false, true, $retorno['auCodeCookie']); 

        }

    }

    private function login($usr, $psw, $con = false, $cookie = false){

        $this->model->pUsuario($usr);

        $this->model->pSenha($psw);

        if($cookie !== false)
            $this->model->pCodeCookie($cookie);

        $validador = $this->model->validaLogin();
        
        if($validador !== false){

            if(($cookie === false) && ($con !== false))
                $code = $this->loginCookie($validador['idUsuario'], $con);

            Session::set($validador);

            Session::set('login', true);

            $this->model->pId($validador['idUsuario']);
            $this->model->pCode(Auth::atualizaLogado());

            if(isset($code))
                $this->model->pCodeCookie($code);

            $this->model->atualizaCode();

            $validador = true;

        }

        return $validador;

    }

    private function loginCookie($id, $con){

        $con = filter_var($con, FILTER_VALIDATE_BOOLEAN);

        if($con !== false){

            $cod = md5(Utilitarios::geraSenha());

            Cookie::criaCookie('devem_lg_adm_connect_'.ADM_KEY, $cod, false);

        }else{

            $cod = null;

            Cookie::excluirCookie('devem_lg_adm_connect_'.ADM_KEY, false);

        }

        return $cod;

    }

    public function enviarSenhaAction(){

        //# Indica que o retorno é do tipo json
        header('Content-type: application/json');

        $this->model->pAberto(FiltroDeDados::LimpaString($_POST['es_email']));

        $existe = $this->model->cadastroExistente(true);

        if($existe !== false){

            $key = Utilitarios::geraSenha(9);

            $email = new Email;

            $conteudo = '<h3>Redefinição de senha do DevemAnager</h3>';
            $conteudo .= '<p>Uma redefinição de senha foi solicitada, acessando o link abaixo você poderá redefinir a senha e acessar o sistema.</p>';
            $conteudo .= '<p><a href="'.Url::baseAdmin('login/redefinirSenha/'.$existe['idUsuario'].'/'.$key).'">Redefina sua senha aqui</a></p>';
            $conteudo .= '<p>Caso não tenha solicitado essa redefinição, ignore esta mensagem.</p>';
            
            $conteudo .= '<br /><br />Fim da mensagem';

            $arrMail = array('email_destino' => $existe['auEmail'],
                            'nome_destino' => $existe['auEmail'],
                            'assunto' => 'Redefinição de Senha - DevemAnager',
                            'html' => $conteudo
                );

            $email->send($arrMail);

            $this->model->pId($existe['idUsuario']);

            $this->model->pCode($key);

            $this->model->atualizaCodigoRedefinicao();

        }

        echo json_encode($existe);

    }

    public function redefinirSenhaAction(){

        $this->model->pId(FiltroDeDados::LimpaString(@$_GET['id']));
        $this->model->pCode(FiltroDeDados::LimpaString(@$_GET['code']));

        $pagina = 'login-redefinicao-inexistente';

        $arrParametros = array('code' => null, 'id' => null);

        if(($this->model->pId() != '') && ($this->model->pCode() != '')){

            $existe = $this->model->redefinicaoExistente();

            if($existe !== false){

                $pagina = 'login-redefinicao';

                $arrParametros = array('code' => $this->model->pCode(), 'id' => $existe['idUsuario']);

            }

        }

        $view = new View('layout/'.$pagina.'.phtml');

        $view->pParametros($arrParametros);

        $view->Show();
    
    }

    public function redefinirAction(){

        //# Indica que o retorno é do tipo json
        header('Content-type: application/json');

        $this->model->pId(FiltroDeDados::LimpaString($_POST['rd_id']));
        $this->model->pCode(FiltroDeDados::LimpaString($_POST['rd_code']));
        $this->model->pSenha(FiltroDeDados::LimpaString($_POST['rd_pass']));

        $redefinir = $this->model->redefinicaoExistente();

        $this->model->validaRedefinicao();

        if($redefinir !== false)
            $redefinir = $this->login($redefinir['auLogin'], $this->model->pSenha());

        echo json_encode($redefinir);

    }

}
