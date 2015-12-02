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
 * Model Mensagem
 *
 * @package     app
 * @subpackage  model 
 * @author      Christopher Villagra <christopher.villagra@antena1.com.br> 
 * @copyright   (c) 2015 - Antena1
**/

final class MensagemModel extends Repositorio
{

	//DECLARAÇÕES DE VARIAVEIS
    private $__id;
    private $__remetente;
    private $__destinatario;
    private $__assunto;
    private $__mensagem;
    private $__msgPai;
	
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
    public function pRemetente($val="")
    {
        if($val === "") return $this->__remetente;
        else $this->__remetente = $val;
    }
    
    /**
    * Metodo de encapsulamento GETSET
    *
    * @author    Christopher Dencker Villagra
    */
    public function pDestinatario($val="")
    {
        if($val === "") return $this->__destinatario;
        else $this->__destinatario = $val;
    }
    
    /**
    * Metodo de encapsulamento GETSET
    *
    * @author    Christopher Dencker Villagra
    */
    public function pAssunto($val="")
    {
        if($val === "") return $this->__assunto;
        else $this->__assunto = $val;
    }
    
    /**
    * Metodo de encapsulamento GETSET
    *
    * @author    Christopher Dencker Villagra
    */
    public function pMensagem($val="")
    {
        if($val === "") return $this->__mensagem;
        else $this->__mensagem = $val;
    }
    
    /**
    * Metodo de encapsulamento GETSET
    *
    * @author    Christopher Dencker Villagra
    */
    public function pMsgPai($val="")
    {
        if($val === "") return $this->__msgPai;
        else $this->__msgPai = $val;
    }

    public function enviar(){

        $binds = array(
                        ':remetente' => $this->pRemetente(),
                        ':destinatario' => $this->pDestinatario(),
                        ':assunto' => $this->pAssunto(),
                        ':mensagem' => $this->pMensagem()
                    );

        if($this->pMsgPai() != '')
            array_push($binds, array(':msgpai' => $this->pMsgPai()));

        $this->pQuery("INSERT INTO 
                            rbc_devem_mensagem
                        (id_remetente, 
                            id_destinatario, 
                            assunto, 
                            mensagem, 
                            data_registro
                            ".($this->pMsgPai() != '' ? ',id_mensagem_pai' : '').")
                        VALUES
                        (:remetente, 
                            :destinatario, 
                            :assunto, 
                            :mensagem, 
                            NOW() 
                            ".($this->pMsgPai() != '' ? ',:msgpai' : '').")
                            ");
        $this->ExecutaQuery($binds);

    }

    public function ultimasMensagens(){

        $binds = array(
                        ':id' => $this->pId()
                    );

       
        $this->pQuery("SELECT 
                            m.id_mensagem as idm,
                            u.user_login as lgu,
                            m.data_registro as reg,
                            m.assunto as ast,
                            u.user_img as img
                        FROM 
                            rbc_devem_mensagem m
                            JOIN rbc_users u ON u.ID = m.id_destinatario
                        WHERE
                            m.status_leitura = 0 AND
                            u.ID = :id
                        ");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0)
            return $this->ListaAll();

        return false;

    }

    public function getMensagens(){

        $binds = array(
                        ':id' => $this->pId()
                    );

       
        $this->pQuery("SELECT 
                            m.id_mensagem as id,
                            u.user_login as usuario,
                            u.user_email as email,
                            m.data_registro as data_envio,
                            m.assunto as assunto,
                            m.mensagem as mensagem,
                            CONCAT(
                                    (SELECT meta_value FROM rbc_usermeta WHERE user_id = u.ID AND meta_key = 'first_name' LIMIT 1),
                                    ' ',
                                    (SELECT meta_value FROM rbc_usermeta WHERE user_id = u.ID AND meta_key = 'last_name' LIMIT 1)
                                  ) as nome
                        FROM 
                            rbc_devem_mensagem m
                            JOIN rbc_users u ON u.ID = m.id_remetente
                        WHERE
                            m.id_destinatario = :id
                        ");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0)
            return $this->ListaAll();

        return false;

    }
	
}