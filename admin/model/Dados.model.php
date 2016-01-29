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
 * Model Dados
 *
 * @package     app
 * @subpackage  model 
 * @author      Christopher Villagra <christopher.villagra@antena1.com.br> 
 * @copyright   (c) 2015 - Antena1
**/


final class DadosModel extends Repositorio
{

	//DECLARAÇÕES DE VARIAVEIS
    private $__id;
    private $__dtIni;
    private $__dtFim;
    private $__arr;
	
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
    public function pDtIni($val="")
    {
        if($val === "") return $this->__dtIni;
        else $this->__dtIni = $val;
    }
    
    /**
    * Metodo de encapsulamento GETSET
    *
    * @author    Christopher Dencker Villagra
    */
    public function pDtFim($val="")
    {
        if($val === "") return $this->__dtFim;
        else $this->__dtFim = $val;
    }
    
    /**
    * Metodo de encapsulamento GETSET
    *
    * @author    Christopher Dencker Villagra
    */
    public function pArr($val="")
    {
        if($val === "") return $this->__arr;
        else $this->__arr = $val;
    }

    public function getPageView($qtd = true, $uud = false, $dtAberto = false){

        $return = false;

        $this->pQuery("SELECT
                            ".($qtd !== false ? 'null' : '*')."
                        FROM
                            dv_admpageview
                        WHERE
                            ".((empty($this->__dtFim) || ($dtAberto === false)) ? 'DATE(pvDataRegistro) = CURDATE()' : '')."
                        ".($uud !== false ? ' GROUP BY pvIpCli ' : '')."
                        ;");

        $this->ExecutaQuery();

        if($qtd !== false){

            $return = $this->TotalRows();

        }else{

            if($this->TotalRows() > 0)
                $return = $this->Lista();

        }

        return $return;

    }

    public function getCliques($qtd = true, $dtAberto = false){

        $return = false;

        $this->pQuery("SELECT
                            ".($qtd !== false ? 'null' : '*')."
                        FROM
                            dv_admclique
                        WHERE
                            ".((empty($this->__dtFim) || ($dtAberto === false)) ? 'DATE(ckDataRegistro) = CURDATE()' : '')."
                        ;");

        $this->ExecutaQuery();

        if($qtd !== false){

            $return = $this->TotalRows();

        }else{

            if($this->TotalRows() > 0)
                $return = $this->Lista();

        }

        return $return;

    }

    public function getCliquePublicidade($qtd = true, $dtAberto = false){

        $return = false;

        $this->pQuery("SELECT
                            ".($qtd !== false ? 'null' : '*')."
                        FROM
                            dv_admcliquepublicidade
                        WHERE
                            ".((empty($this->__dtFim) || ($dtAberto === false)) ? 'DATE(cpDataRegistro) = CURDATE()' : '')."
                        ;");

        $this->ExecutaQuery();

        if($qtd !== false){

            $return = $this->TotalRows();

        }else{

            if($this->TotalRows() > 0)
                $return = $this->Lista();

        }

        return $return;

    }

    public function getListaParametro(){

        $return = false;

        $this->pQuery("SELECT
                            *
                        FROM
                            dv_parametros
                        WHERE
                            pStatus = 1
                        ;");

        $this->ExecutaQuery();

        if($this->TotalRows() > 0)
            $return = $this->ListaAll();

        return $return;

    }

    public function parametroExcluir(){

        $binds = array(':id' => $this->__id);

        $return = false;

        $this->pQuery("SELECT
                            null
                        FROM
                            dv_parametros
                        WHERE
                            idParametro = :id
                        ;");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0){

            $this->pQuery("UPDATE
                                dv_parametros
                            SET
                                pStatus = 0
                            WHERE
                                idParametro = :id
                            ;");

            $this->ExecutaQuery($binds);

            $return = true;

        }

        return $return;


    }

    public function parametroSalvar(){


        $this->pQuery("UPDATE
                            dv_parametros
                        SET
                            pAlias = :alias,
                            pChave = :chave,
                            pValorAtual = :valoratual,
                            pDescricao = :descricao
                        WHERE
                            idParametro = :id
                        ;");

        if(empty($this->__arr))
            return false;

        foreach ($this->__arr as $k) {

            $binds = array(
                            ':id'   => $k['idParametro'],
                            ':alias'   => ((empty($k['pAlias']) || ($k['pAlias'] == '- - -')) ? null : $k['pAlias']),
                            ':chave'   => ((empty($k['pChave']) || ($k['pChave'] == '- - -')) ? null : $k['pChave']),
                            ':valoratual'   => ((empty($k['pValorAtual']) || ($k['pValorAtual'] == '- - -')) ? null : $k['pValorAtual']),
                            ':descricao'   => ((empty($k['pDescricao']) || ($k['pDescricao'] == '- - -')) ? null : $k['pDescricao'])
                          );

            $this->ExecutaQuery($binds);
        }

        return true;

    }

    public function parametroGrava(){

        if(empty($this->__arr))
            return false;

        $binds = array(
                        ':alias'   => ((empty($this->__arr['pr_nv_alias']) || ($this->__arr['pr_nv_alias'] == '- - -')) ? null : $this->__arr['pr_nv_alias']),
                        ':chave'   => ((empty($this->__arr['pr_nv_chave']) || ($this->__arr['pr_nv_chave'] == '- - -')) ? null : $this->__arr['pr_nv_chave']),
                        ':valordefault'   => ((empty($this->__arr['pr_nv_valor_default']) || ($this->__arr['pr_nv_valor_default'] == '- - -')) ? null : $this->__arr['pr_nv_valor_default']),
                        ':valoratual'   => ((empty($this->__arr['pr_nv_valor_default']) || ($this->__arr['pr_nv_valor_default'] == '- - -')) ? null : $this->__arr['pr_nv_valor_default']),
                        ':descricao'   => ((empty($this->__arr['pr_nv_descricao']) || ($this->__arr['pr_nv_descricao'] == '- - -')) ? null : $this->__arr['pr_nv_descricao'])
                      );

        $this->pQuery("INSERT INTO
                            dv_parametros
                        (pAlias, pChave, pValorDefault, pValorAtual, pDescricao, pDataCadastro)
                        VALUES
                            (:alias, :chave, :valordefault, :valoratual, :descricao, NOW())
                        ;");

        $this->ExecutaQuery($binds);

        return true;

    }
	
}


