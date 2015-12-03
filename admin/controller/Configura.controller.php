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
 * Controller Configura
 *
 * @package     app
 * @subpackage  controller 
 * @author      Christopher Villagra <christopher@dvillagra.com.br> 
 * @copyright   (c) 2015 - DEVEM
**/

final class ConfiguraController extends Controller {

    /**
    * Metodo Construtor da Classe
    *
    * @author    Christopher Dencker Villagra
    * @return    resource
    */

	public function __construct() {

        $this->uUsuario = new UsuarioModel;

	}

    public function parametroAction(){

        //# Indica que o retorno é do tipo json
        header('Content-type: application/json');

        $arrReturn = array(
                            'lg'    => self::checkLogado()
                            );

        echo json_encode($arrReturn);

    }

    public function usuarioAction(){

        //# Verifica Permissão do Usuário
        if((int)Session::get('auNivel') > 1){header('Refresh: 0;url='.Url::baseAdmin(''));die;}

        $view = new View("layout/usuario.phtml");

        // $view->pParametros(
        //                     array(
        //                            "uud" => $this->mDados->getPageView(true,true),
        //                            "uudTotal" => $this->mDados->getPageView(true,true,true),
        //                            "pvd" => $this->mDados->getPageView(),
        //                            "pvdTotal" => $this->mDados->getPageView(true,false,true),
        //                            "cld" => $this->mDados->getCliques(),
        //                            "cldTotal" => $this->mDados->getCliques(true, true),
        //                            "pud" => $this->mDados->getCliquePublicidade(),
        //                            "pudTotal" => $this->mDados->getCliquePublicidade(true, true)
        //                         )
        //                     );

        $view->Show();

    }

    public function listaUsuarioAction(){

        //# Indica que o retorno é do tipo json
        header('Content-type: application/json');

        //# Verifica Permissão do Usuário
        if((int)Session::get('nivel') > 1){echo json_encode(false);die;}

        $this->uUsuario->pPermissao(Session::get('auNivel'));  

        echo json_encode(array(
                                'aaData' => $this->uUsuario->getUsuarios(false)
                              ));

    }

    public function cadastraUsuarioAction(){

        //# Indica que o retorno é do tipo json
        header('Content-type: application/json');

        //# Verifica Permissão do Usuário
        if((int)Session::get('nivel') > 1){echo json_encode(false);die;}

        $this->uUsuario->pMail(FiltroDeDados::LimpaString($_POST['cd_email']));  

        $this->uUsuario->pLogin(FiltroDeDados::LimpaString($_POST['cd_nickname'])); 

        $validate = $this->uUsuario->checkExistente();

        if(empty($validate)){  

            $nivel = (int)FiltroDeDados::LimpaString($_POST['cd_nivel']);

            if(((int)Session::get('nivel') == 1) && ($nivel != 2))
                $nivel = 2;

            $this->uUsuario->pPermissao($nivel);  

            $this->uUsuario->pNome(FiltroDeDados::LimpaString($_POST['cd_nome']));   

            $senha = Utilitarios::geraSenha();

            $this->uUsuario->pSenha($senha);  

            $this->uUsuario->gravaUsuario();  

            $email = new Email;

            $conteudo = file_get_contents('admin/view/layout/mail-default.html');

            $conteudo = str_replace('[_TITULO_]', 'Cadastro Realizado', $conteudo);
            $conteudo = str_replace('[_SAUDACAO_]', 'Olá '.$this->uUsuario->pNome(), $conteudo);

            $texto = '<p>O usuário '.Session::get('auNome').' acaba de cadastrar você para utilizar o DevemAnager.</p><br />';
            $texto .= '<p>Seu nome de usuário é '.$this->uUsuario->pLogin().', e a sua chave de entrada é '.$senha.'. [GUARDE BEM ESTES DADOS]</p><br />';
            $texto .= '<p>Acesse <a href="'.Url::baseAdmin('login').'"> esse link</a> e começe a utilizar agora mesmo</p>';
            $texto .= '<p>Seja Bem Vindo, em nome da equipe Devem.</p>';

            $conteudo = str_replace('[_CONTEUDO_]', $texto, $conteudo);

            $arrMail = array('email_destino' => $this->uUsuario->pMail(),
                            'nome_destino' => $this->uUsuario->pNome(),
                            'assunto' => 'Cadastro - DevemAnager',
                            'html' => $conteudo
                );

            $email->send($arrMail);
            
        }

        $cadastro = array('erro' => (empty($validate) ? false : $validate));

        echo json_encode($cadastro);

    }

}
