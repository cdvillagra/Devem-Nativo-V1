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
 * Model Cliente
 *
 * @package     app
 * @subpackage  model 
 * @author      Christopher Villagra <christopher.villagra@antena1.com.br> 
 * @copyright   (c) 2015 - Antena1
**/

final class ClienteModel extends Repositorio
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
    private $__idRepresentante;
	
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

    public function pIdRepresentante($val="")
    {
        if($val === "") return $this->__idRepresentante;
        else $this->__idRepresentante = $val;
    }

    public function getGanhoTotal(){

        $binds = array(
                        ':id' => $this->pId()
                    );

        $this->pQuery("SELECT 
                            g.ganho_total 
                        FROM 
                            rbc_devem_ganho g
                            JOIN rbc_users u ON g.id_user = u.ID
                        WHERE
                            u.ID = :id AND
                            u.user_status_representante = 1 AND
                            u.user_activation_key is null AND
                            u.user_status = 1
                            ");

        $this->ExecutaQuery($binds);

        $dado = $this->Lista();

        return $dado['ganho_total'];

    }

    public function getGanhoMensal(){

        $binds = array(
                        ':id' => $this->pId()
                    );

        $this->pQuery("SELECT 
                            COALESCE(SUM(l.ganho), 0) as total_mes 
                        FROM 
                            rbc_devem_ganho_log l
                            JOIN rbc_users u ON l.id_user = u.ID
                        WHERE
                            u.ID = :id AND
                            u.user_status_representante = 1 AND
                            u.user_activation_key is null AND
                            u.user_status = 1 AND
                            MONTH(l.data_registro) = '".date('m')."'
                            ");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0){

            $dado = $this->Lista();

            return $dado['total_mes'];

        }

        return 0;

    }

    public function getClientes($total = false, $limit = false){

        $binds = array(
                        ':id' => $this->pId()
                    );

        $this->pQuery("SELECT 
                            ".($total !== false ? 'null' : 'u.ID as id, u.user_login, o.origem, u.user_registered as data_registro')." 
                        FROM 
                            rbc_users u
                            JOIN rbc_devem_origem o ON u.id_origem = o.id_origem
                        WHERE
                            u.user_representante = :id AND
                            u.user_status = 1
                            ".($limit !== false ? ' LIMIT '.$limit : ''));

        $this->ExecutaQuery($binds);

        if($total !== false)
            return $this->TotalRows();

        if($this->TotalRows() > 0)
            return $this->ListaAll();

        return array();

    }

    public function getClientesCompleto(){

        $binds = array(
                        ':id' => $this->pId()
                    );

        $this->pQuery("SELECT 
                            u.ID as id,
                            CONCAT(
                                    (SELECT meta_value FROM rbc_usermeta WHERE user_id = u.ID AND meta_key = 'first_name' LIMIT 1),
                                    ' ',
                                    (SELECT meta_value FROM rbc_usermeta WHERE user_id = u.ID AND meta_key = 'last_name' LIMIT 1)
                                  ) as nome,
                            u.user_login as usuario,
                            u.user_email as email,
                            o.origem,
                            CASE d.reputacao
                                WHEN 0 THEN 'Ruim'
                                WHEN 1 THEN 'Regular'
                                WHEN 2 THEN 'Ótimo'
                                ELSE '-'
                            END as reputacao,
                            COALESCE(d.desempenho, '-') as desempenho, 
                            COALESCE(r.posicao, '-') as posicao,
                            u.user_registered as data_registro,
                            
                            (SELECT 
                                count(1)
                            FROM
                                rbc_postmeta pm 
                                LEFT JOIN rbc_posts p ON p.ID = pm.post_id
                              WHERE 
                                p.post_status = 'wc-completed' AND
                                pm.meta_key = '_customer_user' AND 
                                pm.meta_value = u.ID) as pedidos_aprovados,
                            
                            (SELECT 
                                count(1)
                            FROM
                                rbc_postmeta pm 
                                LEFT JOIN rbc_posts p ON p.ID = pm.post_id
                              WHERE 
                                p.post_status not in ('trash', 'wc-completed') AND
                                pm.meta_key = '_customer_user' AND 
                                pm.meta_value = u.ID) as pedidos_pendente
                        FROM 
                            rbc_users u
                            JOIN rbc_devem_origem o ON u.id_origem = o.id_origem
                            LEFT JOIN rbc_devem_desempenho d ON d.id_user = u.ID
                            LEFT JOIN rbc_devem_ranking r ON r.id_user = u.ID
                        WHERE
                            u.user_representante = :id AND
                            u.user_status = 1
                            ");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0)
            return $this->ListaAll();

        return false;

    }

    public function getClientesMensagem(){

        $binds = array(
                        ':id' => $this->pId()
                    );

        $this->pQuery("SELECT 
                            u.ID, u.user_login, u.user_email
                        FROM 
                            rbc_users u
                        WHERE
                            u.user_representante = :id AND
                            u.user_status = 1
                        ORDER BY 1
                            ");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0)
            return $this->ListaAll();

        return false;

    }

    public function getIdClientesValidos(){

        $this->pQuery("SELECT 
                            u.ID, DATE(u.user_registered) as user_registered
                        FROM 
                            rbc_users u
                        WHERE
                            u.user_representante is not null AND
                            u.user_status = 1
                        ORDER BY 1
                            ");

        $this->ExecutaQuery();

        $arrReturn = array();

        if($this->TotalRows() > 0){

            $dados = $this->ListaAll();

            foreach ($dados as $k) 
                array_push($arrReturn, array('id' => $k['ID'], 'data' => $k['user_registered']));

            return $arrReturn;

        }

        return false;

    }

    public function getClientesMes($total = false){

        $binds = array(
                        ':id' => $this->pId()
                    );

        $this->pQuery("SELECT 
                            ".($total !== false ? 'null' : '*')." 
                        FROM 
                            rbc_users
                        WHERE
                            user_representante = :id AND
                            user_status = 1 AND
                            MONTH(user_registered) = '".date('m')."'
                            ");

        $this->ExecutaQuery($binds);

        if($total !== false)
            return $this->TotalRows();

        if($this->TotalRows() > 0)
            return $this->ListaAll();

        return false;

    }

    public function potencialClientes(){

        $binds = array(
                        ':id' => $this->pId()
                    );

        $this->pQuery("SELECT 
                            sum(potencial) / count(potencial) as media
                        FROM 
                            rbc_users u
                            JOIN rbc_devem_desempenho d ON u.ID = d.id_user
                        WHERE
                            u.user_representante = :id AND
                            u.user_status = 1
                            ");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0){
            $dado = $this->Lista();
            return round($dado['media']);
        }

        return false;

    }

    public function dadosCliente(){

        $binds = array(
                        ':id' => $this->pId()
                    );

        $this->pQuery("SELECT 
                            meta_key, meta_value
                        FROM 
                            rbc_usermeta
                        WHERE
                            user_id = :id
                            ");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0){

            $dados = $this->ListaAll();

            $arrReturn = array();

            foreach ($dados as $k)
                $arrReturn[$k['meta_key']] = $k['meta_value'];

            return $arrReturn;

        }

        return false;

    }

    public function cadastroExistente($aberto = false, $facebook = null){

        $return = false;

        if(!is_null($facebook)){

            $binds = array(
                        ':id_facebook' => $facebook['id']
                    );

        }else{

            $binds = array(
                            ':aberto' => ($aberto !== false ? $this->pAberto() : $this->pEmail())
                        );

        }

        $binds2 = array(
                        ':cpf' => ($aberto !== false ? $this->pAberto() : $this->pCpf())
                    );

        $this->pQuery("SELECT
                            ID,
                            user_status_representante,
                            user_email,
                            user_login,
                            id_facebook
                        FROM
                            rbc_users
                        WHERE
                            ".(!is_null($facebook) ? 'id_facebook = :id_facebook' : '(user_email = :aberto) OR (user_login = :aberto)')." 
                        LIMIT 1
                        ;");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0){

            $return = $this->Lista();

            if(!is_null($facebook) && empty($retorno['id_facebook'])){

                $bindsU = array('id_user' => $retorno['ID'],
                                'id_facebook' => $facebook['id']);

                $this->pQuery("UPDATE
                                SET
                                    id_facebook = :id_facebook
                                FROM
                                    rbc_users
                                WHERE
                                    ID = :id_user
                                ;");

                $this->ExecutaQuery($bindsU);

            }

        }else{

            if(is_null($facebook)){

                $this->pQuery("SELECT
                                    u.ID,
                                    u.user_status_representante,
                                    u.user_email
                                FROM
                                    rbc_usermeta m
                                    JOIN rbc_users u ON u.ID = m.user_id
                                WHERE
                                    m.meta_key = 'billing_cpf' AND
                                    m.meta_value = :cpf 
                                LIMIT 1
                                ;");

                $this->ExecutaQuery($binds2);

                if($this->TotalRows() > 0)
                    $return = $this->Lista();
            }

        }

        return $return;

    }

    public function gravaCadastro($byRep = false){

        $binds = array(
                        ':login' => $this->pUsuario(),
                        ':senha' => md5($this->pSenha()),
                        ':email' => $this->pEmail(),
                        ':code' => md5($this->pCode())
                    );

        $this->pQuery("INSERT INTO 
                            rbc_users 
                        (user_login, 
                            user_representante,
                            user_pass, 
                            user_nicename, 
                            user_email, 
                            user_registered, 
                            user_activation_key, 
                            user_status_representante, 
                            display_name,
                            id_origem) 
                        VALUES 
                        (:login, 
                            ".(!empty($this->__idRepresentante) ? $this->pIdRepresentante() : 'DEFAULT').",
                            :senha, 
                            :login, 
                            :email, 
                            NOW(), 
                            :code, 
                            ".($byRep !== false ? 0 : 1).",
                            :login,
                            1)
                        ;");
        
        $this->ExecutaQuery($binds);

        $id = $this->ultimoId();

        $binds2 = array(
                        ':id' => $id,
                        ':login' => $this->pUsuario(),
                        ':nome' => $this->pNome(),
                        ':sobrenome' => $this->pSobrenome(),
                        ':tipo' => $this->ptipo(),
                        ':cpf' => $this->pCpf(),
                        ':cnpj' => $this->pCnpj(),
                        ':pais' => 'BR',
                        ':cep' => $this->pCep(),
                        ':endereco' => $this->pEndereco(),
                        ':numero' => $this->pNumero(),
                        ':bairro' => $this->pBairro(),
                        ':cidade' => $this->pCidade(),
                        ':estado' => $this->pEstado(),
                        ':telefone' => $this->pTelefone(),
                        ':celular' => $this->pCelular(),
                        ':email' => $this->pEmail()
                    );

        $this->pQuery("INSERT INTO 
                            rbc_usermeta 
                        (user_id, 
                            meta_key, 
                            meta_value) 
                        VALUES 
                        (:id, 'nickname', :login),
                        (:id, 'first_name', :nome),
                        (:id, 'last_name', :sobrenome),
                        (:id, 'description', ''),
                        (:id, 'rich_editing', 'true'),
                        (:id, 'comment_shortcuts', 'false'),
                        (:id, 'admin_color', 'fresh'),
                        (:id, 'use_ssl', '0'),
                        (:id, 'show_admin_bar_front', 'true'),
                        (:id, 'rbc_capabilities', 'a:1:{s:8:\"customer\";b:1;}'),
                        (:id, 'rbc_user_level', '0'),
                        (:id, 'wc_multiple_shipping_addresses', ''),
                        (:id, 'billing_first_name', :nome),
                        (:id, 'billing_last_name', :sobrenome),
                        (:id, 'billing_persontype', :tipo),
                        (:id, 'billing_cpf', :cpf),
                        (:id, 'billing_company', ''),
                        (:id, 'billing_cnpj', :cnpj),
                        (:id, 'billing_country', :pais),
                        (:id, 'billing_postcode', :cep),
                        (:id, 'billing_address_1', :endereco),
                        (:id, 'billing_number', :numero),
                        (:id, 'billing_address_2', ''),
                        (:id, 'billing_neighborhood', :bairro),
                        (:id, 'billing_city', :cidade),
                        (:id, 'billing_state', :estado),
                        (:id, 'billing_phone', :telefone),
                        (:id, 'billing_cellphone', :celular),
                        (:id, 'billing_email', :email),
                        (:id, '_woocommerce_persistent_cart', 'a:1:{s:4:\"cart\";a:0:{}}')
                        ;");

        $this->ExecutaQuery($binds2);

        $binds3 = array(
                        ':id' => $id
                    );

        $this->pQuery("INSERT INTO rbc_devem_ganho (id_user, data_registro) VALUES (:id, NOW());
                        ;");

        $this->ExecutaQuery($binds3);

        return $id;

    }

    public function cadastroExistenteById(){

        $return = false;

        $binds = array(
                        ':id' => $this->pId()
                    );

        $this->pQuery("SELECT
                            ID,
                            user_status_representante,
                            user_email
                        FROM
                            rbc_users
                        WHERE
                            ID = :id
                        LIMIT 1
                        ;");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0)
            $return = $this->Lista();

        return $return;

    }

    public function alteraStatusRepresentanteLoja(){


        $binds = array(
                        ':id' => $this->pId(),
                        ':code' => md5($this->pCode())
                    );

        $this->pQuery("UPDATE
                            rbc_users
                        SET
                            ".(!empty($this->__idRepresentante) ? "user_representante = ".$this->pIdRepresentante()."," : '')."
                            user_status_representante = 1,
                            user_activation_key = :code
                        WHERE
                            ID = :id 
                        ;");

        $this->ExecutaQuery($binds);


    }

    public function representantesValidos(){

        $return = array();

        $this->pQuery("SELECT
                            ID,
                            user_login
                        FROM
                            rbc_users
                        WHERE
                            user_status_representante = 1 AND
                            user_status = 1
                        ;");

        $this->ExecutaQuery();

        if($this->TotalRows() > 0)
            $return = $this->ListaAll();

        return $return;



    }
	
}