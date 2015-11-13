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
 * Controller Tipografia
 *
 * @package     app
 * @subpackage  controller 
 * @author      Christopher Villagra <christopher@dvillagra.com.br> 
 * @copyright   (c) 2015 - DEVEM
**/

final class ExtraController extends Controller {

    private $__mod = 'extra';

    /**
    * Metodo Construtor da Classe
    *
    * @author    Christopher Dencker Villagra
    * @return    resource
    */

	public function __construct() {

	}

    public function blogAction(){

        $view = new View('layout/blog.phtml');

        $view->pParametros(array('mod' => $this->__mod));

        $view->Show();
        
    }

    public function blogArtigoAction(){

        $view = new View('layout/blog_artigo.phtml');

        $view->pParametros(array('mod' => $this->__mod));

        $view->Show();
        
    }

    public function perfilAction(){

        $view = new View('layout/perfil.phtml');

        $view->pParametros(array('mod' => $this->__mod));

        $view->Show();
        
    }

    public function defaultAction(){

        $view = new View('layout/default.phtml');

        $view->pParametros(array('mod' => $this->__mod));

        $view->Show();
        
    }

    public function ajudaAction(){

        $view = new View('layout/ajuda.phtml');

        $view->pParametros(array('mod' => $this->__mod));

        $view->Show();
        
    }

    public function invoiceAction(){

        $view = new View('layout/invoice.phtml');

        $view->pParametros(array('mod' => $this->__mod));

        $view->Show();
        
    }

    public function e404Action(){

        $view = new View('layout/404.phtml');

        $view->pParametros(array('mod' => $this->__mod));

        $view->Show();
        
    }

    public function e500Action(){

        $view = new View('layout/500.phtml');

        $view->pParametros(array('mod' => $this->__mod));

        $view->Show();
        
    }
    
}
