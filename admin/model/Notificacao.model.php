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
 * Model Notificacao
 *
 * @package     app
 * @subpackage  model 
 * @author      Christopher Villagra <christopher.villagra@antena1.com.br> 
 * @copyright   (c) 2015 - Antena1
**/

final class NotificacaoModel extends Repositorio
{

	//DECLARAÇÕES DE VARIAVEIS
    private $__id;
	
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

    public function ultimasNotificacoes(){

        $binds = array(
                        ':id' => $this->pId()
                    );

       
        $this->pQuery("SELECT 
                            n.id_notificacao as idn,
                            u.user_login as lgu,
                            n.data_registro as reg,
                            n.notificacao as nt,
                            n.status_entregue as st
                        FROM 
                            rbc_devem_notificacao n
                            JOIN rbc_users u ON u.ID = n.id_user
                        WHERE
                            u.ID = :id
                        ");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0){

            $dados = $this->ListaAll();

            $in = '';
            
            foreach ($dados as $k){
                if($k['st'] == 0)
                    $in .= ','.$k['idn'];
            }

            if(!empty($in)){

                $this->pQuery("UPDATE 
                                    rbc_devem_notificacao
                                SET
                                    status_entregue = 1
                                WHERE
                                    id_notificacao in (".substr($in, 1).")
                                ");

                $this->ExecutaQuery();

            }

            return $dados;

        }

        return false;

    }
	
}