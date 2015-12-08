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

        $this->mUsuario = new UsuarioModel;
        $this->mDados = new DadosModel;

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

        $view->Show();

    }

    public function regrasAction(){

        //# Verifica Permissão do Usuário
        if((int)Session::get('auNivel') > 0){header('Refresh: 0;url='.Url::baseAdmin(''));die;}

        $view = new View("layout/regras.phtml");

        $view->Show();

    }

    public function ParametrosAction(){

        //# Verifica Permissão do Usuário
        if((int)Session::get('auNivel') > 0){header('Refresh: 0;url='.Url::baseAdmin(''));die;}

        $view = new View("layout/parametros.phtml");

        $view->pParametros($this->mDados->getListaParametro());

        $view->Show();

    }

    public function parametroExcluirAction(){

        //# Indica que o retorno é do tipo json
        header('Content-type: application/json');

        //# Verifica Permissão do Usuário
        if((int)Session::get('nivel') > 0){echo json_encode(false);die;}

        $this->mDados->pId(FiltroDeDados::LimpaString($_POST['id']));  

        echo json_encode(
                         $this->mDados->parametroExcluir()
                        );

    }

    public function parametroNovoAction(){

        $view = new View("layout/modal-parametro.phtml");

        $view->Show();

    }

    public function parametroGravaAction(){

        //# Indica que o retorno é do tipo json
        header('Content-type: application/json');

        //# Verifica Permissão do Usuário
        if((int)Session::get('nivel') > 0){echo json_encode(false);die;}

        $this->mDados->pArr(FiltroDeDados::LimpaString($_POST));

        echo json_encode(
                         $this->mDados->parametroGrava()
                        );

    }

    public function parametroSalvarAction(){

        //# Indica que o retorno é do tipo json
        header('Content-type: application/json');

        //# Verifica Permissão do Usuário
        if((int)Session::get('nivel') > 0){echo json_encode(false);die;}

        $arr = FiltroDeDados::LimpaString($_POST);  

        $arrDef = array();

        for ($i=0; $i < count($arr['pr_id']); $i++)
            $arrDef[] = array(
                                'idParametro' => $arr['pr_id'][$i],
                                'pAlias' => $arr['pr_alias'][$i],
                                'pChave' => $arr['pr_chave'][$i],
                                'pValorAtual' => $arr['pr_valor_atual'][$i],
                                'pDescricao' => $arr['pr_descricao'][$i]
                             );

        if(empty($arrDef)){echo json_encode(false);die;}

        $this->mDados->pArr($arrDef);

        echo json_encode(
                         $this->mDados->parametroSalvar()
                        );

    }


    public function listaUsuarioAction(){

        //# Indica que o retorno é do tipo json
        header('Content-type: application/json');

        //# Verifica Permissão do Usuário
        if((int)Session::get('nivel') > 1){echo json_encode(false);die;}

        $this->mUsuario->pPermissao(Session::get('auNivel'));  

        echo json_encode(array(
                                'aaData' => $this->mUsuario->getUsuarios(false)
                              ));

    }

    public function cadastraUsuarioAction(){

        //# Indica que o retorno é do tipo json
        header('Content-type: application/json');

        //# Verifica Permissão do Usuário
        if((int)Session::get('nivel') > 1){echo json_encode(false);die;}

        $this->mUsuario->pMail(FiltroDeDados::LimpaString($_POST['cd_email']));  

        $this->mUsuario->pLogin(FiltroDeDados::LimpaString($_POST['cd_nickname'])); 

        $validate = $this->mUsuario->checkExistente();

        if(empty($validate)){  

            $nivel = (int)FiltroDeDados::LimpaString($_POST['cd_nivel']);

            if(((int)Session::get('nivel') == 1) && ($nivel != 2))
                $nivel = 2;

            $this->mUsuario->pPermissao($nivel);  

            $this->mUsuario->pNome(FiltroDeDados::LimpaString($_POST['cd_nome']));   

            $senha = Utilitarios::geraSenha();

            $this->mUsuario->pSenha($senha);  

            $this->mUsuario->gravaUsuario();  

            $email = new Email;

            $conteudo = file_get_contents('admin/view/layout/mail-default.html');

            $conteudo = str_replace('[_TITULO_]', 'Cadastro Realizado', $conteudo);
            $conteudo = str_replace('[_SAUDACAO_]', 'Olá '.$this->mUsuario->pNome(), $conteudo);

            $texto = '<p>O usuário '.Session::get('auNome').' acaba de cadastrar você para utilizar o DevemAnager.</p><br />';
            $texto .= '<p>Seu nome de usuário é '.$this->mUsuario->pLogin().', e a sua chave de entrada é '.$senha.'. [GUARDE BEM ESTES DADOS]</p><br />';
            $texto .= '<p>Acesse <a href="'.Url::baseAdmin('login').'"> esse link</a> e começe a utilizar agora mesmo</p>';
            $texto .= '<p>Seja Bem Vindo, em nome da equipe Devem.</p>';

            $conteudo = str_replace('[_CONTEUDO_]', $texto, $conteudo);

            $arrMail = array('email_destino' => $this->mUsuario->pMail(),
                            'nome_destino' => $this->mUsuario->pNome(),
                            'assunto' => 'Cadastro - DevemAnager',
                            'html' => $conteudo
                );

            $email->send($arrMail);
            
        }

        $cadastro = array('erro' => (empty($validate) ? false : $validate));

        echo json_encode($cadastro);

    }

}
