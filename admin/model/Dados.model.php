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
                            dv_admcliquePublicidade
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
	
}


