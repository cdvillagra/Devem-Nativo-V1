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
 * Model Login
 *
 * @package     app
 * @subpackage  model 
 * @author      Christopher Villagra <christopher.villagra@antena1.com.br> 
 * @copyright   (c) 2015 - Antena1
**/


final class LoginModel extends Repositorio
{

	//DECLARAÇÕES DE VARIAVEIS
    private $__id;
    private $__usuario;
    private $__email;
    private $__senha;
    private $__code;
    private $__codeCookie;
    private $__nome;
    private $__sobrenome;
    private $__tipo;
    private $__cep;
    private $__endereco;
    private $__numero;
    private $__complemento;
    private $__bairro;
    private $__cidade;
    private $__estado;
    private $__pais;
    private $__telefone;
    private $__celular;
    private $__cpf;
    private $__cnpj;
    private $__aberto;
    private $__usuarioFacebook;
    private $__arrFacebook;
	
	/**
    * Metodo Construtor da Classe
    *
    * @author    Christopher Dencker Villagra
    * @return    resource
    */
	public function __construct()
	{
		parent::__construct(true);
	}
	
	/**
    * Metodo de encapsulamento GETSET
    *
    * @author    Christopher Dencker Villagra
    */
    public function pId($val="")
    {
        if($val === "") return $this->__id;
        else $this->__id = $val;
    }

    public function pUsuario($val="")
    {
        if($val === "") return $this->__usuario;
        else $this->__usuario = $val;
    }

    public function pEmail($val="")
    {
        if($val === "") return $this->__email;
        else $this->__email = $val;
    }

    public function pSenha($val="")
    {
        if($val === "") return $this->__senha;
        else $this->__senha = $val;
    }

    public function pCode($val="")
    {
        if($val === "") return $this->__code;
        else $this->__code = $val;
    }

    public function pCodeCookie($val="")
    {
        if($val === "") return $this->__codeCookie;
        else $this->__codeCookie = $val;
    }

    public function pNome($val="")
    {
        if($val === "") return $this->__nome;
        else $this->__nome = $val;
    }

    public function pSobrenome($val="")
    {
        if($val === "") return $this->__sobrenome;
        else $this->__sobrenome = $val;
    }

    public function pTipo($val="")
    {
        if($val === "") return $this->__tipo;
        else $this->__tipo = $val;
    }

    public function pCep($val="")
    {
        if($val === "") return $this->__cep;
        else $this->__cep = $val;
    }

    public function pEndereco($val="")
    {
        if($val === "") return $this->__endereco;
        else $this->__endereco = $val;
    }

    public function pNumero($val="")
    {
        if($val === "") return $this->__numero;
        else $this->__numero = $val;
    }

    public function pComplemento($val="")
    {
        if($val === "") return $this->__complemento;
        else $this->__complemento = $val;
    }

    public function pBairro($val="")
    {
        if($val === "") return $this->__bairro;
        else $this->__bairro = $val;
    }

    public function pCidade($val="")
    {
        if($val === "") return $this->__cidade;
        else $this->__cidade = $val;
    }

    public function pEstado($val="")
    {
        if($val === "") return $this->__estado;
        else $this->__estado = $val;
    }

    public function pPais($val="")
    {
        if($val === "") return $this->__pais;
        else $this->__pais = $val;
    }

    public function pTelefone($val="")
    {
        if($val === "") return $this->__telefone;
        else $this->__telefone = $val;
    }

    public function pCelular($val="")
    {
        if($val === "") return $this->__celular;
        else $this->__celular = $val;
    }

    public function pCpf($val="")
    {
        if($val === "") return $this->__cpf;
        else $this->__cpf = $val;
    }

    public function pCnpj($val="")
    {
        if($val === "") return $this->__cnpj;
        else $this->__cnpj = $val;
    }

    public function pAberto($val="")
    {
        if($val === "") return $this->__aberto;
        else $this->__aberto = $val;
    }

    public function pUsuarioFacebook($val="")
    {
        if($val === "") return $this->__usuarioFacebook;
        else $this->__usuarioFacebook = $val;
    }

    public function pArrFacebook($val="")
    {
        if($val === "") return $this->__arrFacebook;
        else $this->__arrFacebook = $val;
    }

    public function validaLogin(){

        $return = false;

        $binds = array(
                        ':usuario' => $this->pUsuario(),
                        ':senha' => ($this->pSenha() !== false ? md5($this->pSenha()) : $this->pCodeCookie())
                    );

        $this->pQuery("SELECT
                            idUsuario,
                            auLogin,
                            auEmail
                        FROM
                            dv_admusuario
                        WHERE
                            auLogin = :usuario AND
                            au".($this->pSenha() !== false ? 'Senha' : 'Cookie')." = :senha AND
                            auStatus = 1
                        LIMIT 1
                        ;");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0)
            $return = $this->Lista();

        return $return;


    }

    public function checkLoginCookie(){

        $return = false;

        $binds = array(
                        ':code' => $this->pCodeCookie()
                    );

        $this->pQuery("SELECT
                            idUsuario,
                            auLogin,
                            auCodeCookie
                        FROM
                            dv_admusuario
                        WHERE
                            auCodeCookie = :code AND
                            auStatus = 1
                        LIMIT 1
                        ;");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0)
            $return = $this->Lista();

        return $return;


    }

    public function atualizaCode(){

        $binds = array(
                        ':code' => $this->pCode(),
                        ':id' => $this->pId()
                    );

        $this->pQuery("UPDATE
                            dv_admusuario
                        SET
                            auCodeAuth = :code, 
                            auCodeCookie = ".(is_null($this->pCodeCookie()) ? 'DEFAULT' : "'".$this->pCodeCookie()."'")."
                        WHERE
                            idUsuario = :id
                        ;");

        $this->ExecutaQuery($binds);

    }

    public function validaRedefinicao(){

        $binds = array(
                        ':id' => $this->pId(),
                        ':code' => $this->pCode(),
                        ':senha' => md5($this->pSenha())
                    );

        $this->pQuery("UPDATE
                            rbc_users
                        SET
                            user_pass = :senha,
                            user_code_redefinicao = DEFAULT
                        WHERE
                            ID = :id AND
                            user_code_redefinicao = :code AND 
                            user_status = 1
                        ;");

        $this->ExecutaQuery($binds);

    }

    public function redefinicaoExistente(){

        $return = false;

        $binds = array(
                        ':id' => $this->pId(),
                        ':code' => $this->pCode()
                    );

        $this->pQuery("SELECT
                            ID,
                            user_login
                        FROM
                            rbc_users
                        WHERE
                            ID = :id AND
                            user_code_redefinicao = :code AND
                            user_status_representante = 1
                        LIMIT 1
                        ;");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0)
            $return = $this->Lista();

        return $return;

    }

    public function ativacaoExistente(){

        $return = false;

        $binds = array(
                        ':id' => $this->pId(),
                        ':code' => md5($this->pCode())
                    );

        $this->pQuery("SELECT
                            ID,
                            user_login,
                            user_email
                        FROM
                            rbc_users
                        WHERE
                            ID = :id AND
                            user_activation_key = :code AND
                            user_status = 0
                        LIMIT 1
                        ;");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0){

            $return = $this->Lista();

            $binds2 = array(
                            ':id' => $return['ID']
                        );

            $this->pQuery("UPDATE
                                rbc_users
                            SET
                                user_activation_key = DEFAULT,
                                user_status = 1
                            WHERE
                                ID = :id
                            ;");

            $this->ExecutaQuery($binds2);

        }

        return $return;

    }

    public function deslogaCode(){

        $binds = array(
                        ':id' => $this->pId()
                    );

        $this->pQuery("UPDATE
                            dv_admusuario
                        SET
                            auCodeAuth = DEFAULT,
                            auCodeCookie = DEFAULT
                        WHERE
                            idUsuario = :id
                        ;");

        $this->ExecutaQuery($binds);


    }

    public function atualizaCodigoRedefinicao(){

        $binds = array(
                        ':id' => $this->pId(),
                        ':code' => $this->pCode()
                    );

        $this->pQuery("UPDATE
                            rbc_users
                        SET
                            user_code_redefinicao = :code
                        WHERE
                            ID = :id
                        ;");

        $this->ExecutaQuery($binds);


    }

    public function checkLogado(){

        $return = false;

        $binds = array(
                        ':usuario' => $this->pId(),
                        ':code' => $this->pCode()
                    );

        $this->pQuery("SELECT
                            null
                        FROM
                            dv_admusuario
                        WHERE
                            idUsuario = :usuario AND
                            auCodeAuth = :code  AND
                            auStatus = 1
                        LIMIT 1
                        ;");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0)
            $return = true;

        return $return;

    }
	
}


