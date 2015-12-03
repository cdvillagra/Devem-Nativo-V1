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
 * Model Usuario
 *
 * @package     app
 * @subpackage  model 
 * @author      Christopher Villagra <christopher.villagra@antena1.com.br> 
 * @copyright   (c) 2015 - Antena1
**/


final class UsuarioModel extends Repositorio
{

	//DECLARAÇÕES DE VARIAVEIS
    private $__id;
    private $__permissao;
    private $__nome;
    private $__mail;
    private $__login;
    private $__senha;
	
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
    
    /**
    * Metodo de encapsulamento GETSET
    *
    * @author    Christopher Dencker Villagra
    */
    public function pPermissao($val="")
    {
        if($val === "") return $this->__permissao;
        else $this->__permissao = $val;
    }
    
    /**
    * Metodo de encapsulamento GETSET
    *
    * @author    Christopher Dencker Villagra
    */
    public function pNome($val="")
    {
        if($val === "") return $this->__nome;
        else $this->__nome = $val;
    }
    
    /**
    * Metodo de encapsulamento GETSET
    *
    * @author    Christopher Dencker Villagra
    */
    public function pMail($val="")
    {
        if($val === "") return $this->__mail;
        else $this->__mail = $val;
    }
    
    /**
    * Metodo de encapsulamento GETSET
    *
    * @author    Christopher Dencker Villagra
    */
    public function pLogin($val="")
    {
        if($val === "") return $this->__login;
        else $this->__login = $val;
    }
    
    /**
    * Metodo de encapsulamento GETSET
    *
    * @author    Christopher Dencker Villagra
    */
    public function pSenha($val="")
    {
        if($val === "") return $this->__senha;
        else $this->__senha = $val;
    }

    public function getUsuarios($qtd = true){

        $return = false;

        $this->pQuery("SELECT
                            ".($qtd !== false ? 'null' : 'idUsuario, CASE auNivel WHEN 0 THEN \'Administrador\' WHEN 1 THEN \'Gerente\' ELSE \'Operacional\' END as nivel, auNome, auEmail, auLogin, auDataCadastro ')."
                        FROM
                            dv_admusuario
                        ".((int)$this->__permissao > 0 ? 'WHERE auNivel > 0' : '')."
                        
                        ;");

        $this->ExecutaQuery();

        if($qtd !== false){

            $return = $this->TotalRows();

        }else{

            if($this->TotalRows() > 0)
                $return = $this->ListaAll();

        }

        return $return;

    }

    public function gravaUsuario(){

        $binds = array(
                        ":permissao"    => $this->__permissao,
                        ":nome"         => $this->__nome,
                        ":login"        => $this->__login,
                        ":mail"         => $this->__mail,
                        ":senha"        => md5($this->__senha)
                        );

        $this->pQuery("INSERT INTO
                            dv_admusuario
                            (auNivel, auNome, auLogin, auEmail, auSenha, auDataCadastro)
                        VALUES
                            (:permissao, :nome, :login, :mail, :senha, NOW())
                        ;");

        $this->ExecutaQuery($binds);

    }

    public function checkExistente(){

        $retorno = array();

        $bindEmail = array(':mail' => $this->__mail);
        $bindLogin = array(':login' => $this->__login);

        $this->pQuery("SELECT
                            null
                        FROM
                            dv_admusuario
                       WHERE
                            auEmail = :mail
                        
                        ;");

        $this->ExecutaQuery($bindEmail);

        if($this->TotalRows() > 0)
            array_push($retorno, 'email');

        $this->pQuery("SELECT
                            null
                        FROM
                            dv_admusuario
                       WHERE
                            auLogin = :login
                        ;");

        $this->ExecutaQuery($bindLogin);

        if($this->TotalRows() > 0)
            array_push($retorno, 'login');

        return $retorno;


    }
	
}


