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
 * Controller Cliente
 *
 * @package     app
 * @subpackage  controller 
 * @author      Christopher Villagra <christopher@dvillagra.com.br> 
 * @copyright   (c) 2015 - DEVEM
**/

final class ClienteController extends Controller {

    /**
    * Metodo Construtor da Classe
    *
    * @author    Christopher Dencker Villagra
    * @return    resource
    */

	public function __construct() {

        $this->model = new ClienteModel;

	}

    public function cadastroAction(){

        $view = new View("layout/cliente-cadastro.phtml");

        $view->Show();

    }

    public function consultaAction(){

        $view = new View("layout/cliente-consulta.phtml");

        $view->Show();

    }

    public function listaClientesAction(){

        //# Indica que o retorno é do tipo json
        header('Content-type: application/json');

        $this->model->pId(Session::get('ID'));  

        echo json_encode(array(
                                'aaData' => $this->model->getClientesCompleto()
                              ));
    }

    public function gravaCadastroAction(){

        //# Indica que o retorno é do tipo json
        header('Content-type: application/json');

        echo json_encode($this->gravaCadastroCliente(true, Session::get('ID')));

    }

    public function gravaCadastroCliente($byRep = false, $idRep = null, $facebook = null){

        if(is_null($facebook)){

            $this->model->pEmail(FiltroDeDados::LimpaString($_POST['cd_email']));
            $this->model->pCpf(FiltroDeDados::LimpaString($_POST['cd_cpf']));

        }

        $this->model->pCode(Utilitarios::geraSenha());

        $existe = $this->model->cadastroExistente(false, $facebook);

        $ativacao = false;
        $cli_loja = false;

        if($existe !== false){

            if((!is_null($facebook)) && ($existe['user_status_representante'] == 1)){

                return true;

            }else if($existe['user_status_representante'] < 1){

                $ativacao = true;
                $cli_loja = $existe['ID'];

            }

        }else{

            if(!is_null($facebook)){

                $this->model->pEmail(FiltroDeDados::LimpaString($_POST['cd_email']));
                $this->model->pCpf(FiltroDeDados::LimpaString($_POST['cd_cpf']));
                $this->model->pUsuario(FiltroDeDados::LimpaString($_POST['cd_nickname']));
                $this->model->pNome(FiltroDeDados::LimpaString($_POST['cd_nome']));
                $this->model->pSobrenome(FiltroDeDados::LimpaString($_POST['cd_sobrenome']));
                $this->model->pTipo(FiltroDeDados::LimpaString($_POST['cd_tipo']));
                $this->model->pCep(FiltroDeDados::LimpaString($_POST['cd_cep']));
                $this->model->pNumero(FiltroDeDados::LimpaString($_POST['cd_numero']));
                $this->model->pComplemento(FiltroDeDados::LimpaString($_POST['cd_complemento']));
                $this->model->pBairro(FiltroDeDados::LimpaString($_POST['cd_bairro']));
                $this->model->pCidade(FiltroDeDados::LimpaString($_POST['cd_cidade']));
                $this->model->pEstado(FiltroDeDados::LimpaString($_POST['cd_estado']));
                $this->model->pTelefone(FiltroDeDados::LimpaString($_POST['cd_telefone']));
                $this->model->pCelular(FiltroDeDados::LimpaString($_POST['cd_celular']));

            }else{

                $this->model->pUsuario(FiltroDeDados::LimpaString($_POST['cd_nickname']));
                $this->model->pNome(FiltroDeDados::LimpaString($_POST['cd_nome']));
                $this->model->pSobrenome(FiltroDeDados::LimpaString($_POST['cd_sobrenome']));
                $this->model->pTipo(FiltroDeDados::LimpaString($_POST['cd_tipo']));
                $this->model->pCep(FiltroDeDados::LimpaString($_POST['cd_cep']));
                $this->model->pNumero(FiltroDeDados::LimpaString($_POST['cd_numero']));
                $this->model->pComplemento(FiltroDeDados::LimpaString($_POST['cd_complemento']));
                $this->model->pBairro(FiltroDeDados::LimpaString($_POST['cd_bairro']));
                $this->model->pCidade(FiltroDeDados::LimpaString($_POST['cd_cidade']));
                $this->model->pEstado(FiltroDeDados::LimpaString($_POST['cd_estado']));
                $this->model->pTelefone(FiltroDeDados::LimpaString($_POST['cd_telefone']));
                $this->model->pCelular(FiltroDeDados::LimpaString($_POST['cd_celular']));

            }

            if(is_null($idRep))
                $idRep = FiltroDeDados::LimpaString($_POST['cd_representante']);

            $this->model->pIdRepresentante($idRep);

            $senha_cliente = Utilitarios::geraSenha();

            if($byRep === false)
                $senha_cliente = FiltroDeDados::LimpaString($_POST['cd_senha']);

            $this->model->pSenha($senha_cliente);

            $mail_id = $this->model->gravaCadastro($byRep);
            $mail_mail = $this->model->pEmail();

            $email = new Email;

            $conteudo = '<h3>Ativação de usuário do sistema de representantes Rocha Branca</h3>';
            $conteudo .= '<p>Seu cadastro foi realizado com sucesso, com as seguintes credenciais:</p>';
            $conteudo .= '<br /> <p> Usuário: <b>'.$this->model->pUsuario().'</b><br /> Senha: <b>'.$this->model->pSenha().'</b></p> <br />';
            $conteudo .= '<p> Para finalizar a ativação do seu cadastro, confirme através do link abaixo.</p>';
            $conteudo .= '<p><a href="'.Url::base('login/'.($byRep !== false ? 'ativacaoCliente' : 'ativacao').'/'.$mail_id.'/'.$this->model->pCode()).'">Ativar conta</a></p>';
            $conteudo .= '<p>Caso não tenha solicitado essa ativação, ignore esta mensagem.</p>';
            $conteudo .= '<p>Atenciosamente Água Rocha Branca</p>';
            $conteudo .= '<br /><br />Fim da mensagem';

            $arrMail = array('email_destino' => $mail_mail,
                            'nome_destino' => $mail_mail,
                            'assunto' => 'Ativação de usuário - Água Rocha Branca',
                            'html' => $conteudo
                );

            $email->send($arrMail);

            $ativacao = true;

        }

        return array(
                    'ativacao' => $ativacao,
                    'cli_loja' => $cli_loja
                    );

    }


    public function gravaCadastroAlteracaoAction(){

        //# Indica que o retorno é do tipo json
        header('Content-type: application/json');

        echo json_encode($this->gravaCadastroAlteracaoCliente(Session::get('ID')));

    }

    public function gravaCadastroAlteracaoCliente($idRep = null){

        $this->model->pId(FiltroDeDados::LimpaString($_POST['id']));
        $this->model->pCode(Utilitarios::geraSenha());

        $existe = $this->model->cadastroExistenteByID();

        $ativacao = false;

        if($existe['user_status_representante'] < 1){

            $this->model->pId($existe['ID']);

            if(is_null($idRep))
                $idRep = FiltroDeDados::LimpaString($_POST['cd_representante']);

            $this->model->pIdRepresentante($idRep);

            $this->model->alteraStatusRepresentanteLoja();

            $mail_id = $existe['ID'];
            $mail_mail = $existe['user_email'];

            $email = new Email;

            $conteudo = '<h3>Ativação de usuário do sistema de representantes Rocha Branca</h3>';
            $conteudo .= '<p>Seu cadastro foi realizado com sucesso, faltando apenas ativar seu usuário através do link abaixo.</p>';
            $conteudo .= '<p><a href="'.Url::base('login/ativacao/'.$mail_id.'/'.$this->model->pCode()).'">Ativar conta</a></p>';
            $conteudo .= '<p>Caso não tenha solicitado essa ativação, ignore esta mensagem.</p>';
            $conteudo .= '<p>Atenciosamente Água Rocha Branca</p>';
            $conteudo .= '<br /><br />Fim da mensagem';

            $arrMail = array('email_destino' => $mail_mail,
                            'nome_destino' => $mail_mail,
                            'assunto' => 'Ativação de usuário - Água Rocha Branca',
                            'html' => $conteudo
                );

            $email->send($arrMail);

            $ativacao = true;

        }

        return $ativacao;


    }
}
