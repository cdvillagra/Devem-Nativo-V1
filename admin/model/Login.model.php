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
    private $__aberto;
	
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

    public function pAberto($val="")
    {
        if($val === "") return $this->__aberto;
        else $this->__aberto = $val;
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
                            auNome,
                            auEmail,
                            auNivel,
                            auImagem,
                            auDataAtualizacao
                        FROM
                            dv_admusuario
                        WHERE
                            auLogin = :usuario AND
                            au".($this->pSenha() !== false ? 'Senha' : 'CodeCookie')." = :senha AND
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
                            dv_admusuario
                        SET
                            auSenha = :senha,
                            auCodeRedefine = DEFAULT
                        WHERE
                            idUsuario = :id AND
                            auCodeRedefine = :code AND 
                            auStatus = 1
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
                            idUsuario,
                            auLogin
                        FROM
                            dv_admusuario
                        WHERE
                            idUsuario = :id AND
                            auCodeRedefine = :code AND
                            auStatus = 1
                        LIMIT 1
                        ;");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0)
            $return = $this->Lista();

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
                            dv_admusuario
                        SET
                            auCodeRedefine = :code
                        WHERE
                            idUsuario = :id
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

    public function cadastroExistente($aberto = false){

        $return = false;

        $binds = array(
                        ':aberto' => ($aberto !== false ? $this->pAberto() : $this->pEmail())
                    );

        $this->pQuery("SELECT
                            idUsuario,
                            auEmail,
                            auNome,
                            auLogin
                        FROM
                            dv_admusuario
                        WHERE
                            (auEmail = :aberto) OR (auLogin = :aberto)
                        LIMIT 1
                        ;");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0)
            $return = $this->Lista();

        return $return;

    }
	
}


