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
 * Controller Principal
 *
 * @package     app
 * @subpackage  controller 
 * @author      Christopher Villagra <christopher@dvillagra.com.br> 
 * @copyright   (c) 2015 - DEVEM
**/

final class PrincipalController extends Controller {

    /**
    * Metodo Construtor da Classe
    *
    * @author    Christopher Dencker Villagra
    * @return    resource
    */

	public function __construct() {

        // MonitorController::checkLogado(true);

        $this->mLogin = new LoginModel;
        $this->mDados = new DadosModel;
	}

    public function indexAction(){
 
        $view = new View("layout/home.phtml");

        $view->pParametros(
                            array(
                                   "uud" => $this->mDados->getPageView(true,true),
                                   "uudTotal" => $this->mDados->getPageView(true,true,true),
                                   "pvd" => $this->mDados->getPageView(),
                                   "pvdTotal" => $this->mDados->getPageView(true,false,true),
                                   "cld" => $this->mDados->getCliques(),
                                   "cldTotal" => $this->mDados->getCliques(true, true),
                                   "pud" => $this->mDados->getCliquePublicidade(),
                                   "pudTotal" => $this->mDados->getCliquePublicidade(true, true)
                                )
                            );

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
                                'label_bt' => $_GET['label_bt'],
                                'acao_bt' => @$_GET['acao_bt']
                                )
                        );

        $view->Show();
    }

    public function deslogarAction(){

        //# Indica que o retorno é do tipo json
        header('Content-type: application/json');

        $this->mLogin->pId(Session::get('idUsuario'));
        $this->mLogin->deslogaCode();

        Session::setNull('login');

        Auth::atualizaDeslogado();

        Cookie::excluirCookie('devem_lg_adm_connect_'.ADM_KEY);

        echo json_encode(Auth::loginValido());

    }
}
