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
 * Model Pedido
 *
 * @package     app
 * @subpackage  model 
 * @author      Christopher Villagra <christopher.villagra@antena1.com.br> 
 * @copyright   (c) 2015 - Antena1
**/

final class PedidoModel extends Repositorio
{

	//DECLARAÇÕES DE VARIAVEIS
    private $__id;
    private $__dataInicio;
    private $__dataFim;
    private $__array = array();
	
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
    public function pDataInicio($val="")
    {
        if($val === "") return $this->__dataInicio;
        else $this->__dataInicio = $val;
    }
    
    /**
    * Metodo de encapsulamento GETSET
    *
    * @author    Christopher Dencker Villagra
    */
    public function pDataFim($val="")
    {
        if($val === "") return $this->__dataFim;
        else $this->__dataFim = $val;
    }
    
    /**
    * Metodo de encapsulamento GETSET
    *
    * @author    Christopher Dencker Villagra
    */
    public function pArray($val="")
    {
        if($val === "") return $this->__array;
        else $this->__array = $val;
    }

    public function historico($qtd = false){

        $binds = array(
                        ':id' => $this->pId()
                    );


        $this->pQuery("select 
                            ".($qtd !== false ? 'null' : "post_id , post_status, post_date, (SELECT meta_value FROM rbc_postmeta where post_id = pm.post_id AND meta_key = '_order_total') as total")."
                        from 
                            rbc_postmeta pm 
                            LEFT JOIN rbc_posts p ON p.ID = pm.post_id
                        where 
                            p.post_status <> 'trash' AND
                            pm.meta_key = '_customer_user' AND 
                            pm.meta_value = :id");

        $this->ExecutaQuery($binds);

        if($qtd !== false)
            return $this->TotalRows();

        if($this->TotalRows() > 0)
            return $this->ListaAll();

        return false;

    }

    public function pedidoCliente($efetivado = false, $pendente = false, $qtd = false){

        $binds = array(
                        ':id' => $this->pId()
                    );

        $condicao = ($efetivado !== false ? " = 'wc-completed' " : ($pendente !== false ? "not in ('trash', 'wc-completed')" : " <> 'trash' "));


        $this->pQuery("SELECT 
                            ".($qtd !== false ? 'null' : 'u.user_login, p.post_date, pm.post_id , p.post_status, (SELECT pm2.meta_value FROM rbc_postmeta pm2 WHERE pm2.post_id = pm.post_id AND pm2.meta_key = \'_order_total\' LIMIT 1  ) as order_value')."
                        FROM 
                            rbc_postmeta pm 
                            JOIN rbc_users u ON u.ID = pm.meta_value
                            LEFT JOIN rbc_posts p ON p.ID = pm.post_id
                        WHERE 
                            p.post_status ".$condicao." AND
                            pm.meta_key = '_customer_user' AND 
                            u.user_representante = :id");

        $this->ExecutaQuery($binds);

        if($qtd !== false)
            return $this->TotalRows();

        if($this->TotalRows() > 0)
            return $this->ListaAll();

        return false;

    }

    public function produtosPedido($id){

        $binds = array(
                        ':id' => $id
                        );

        $this->pQuery("SELECT 
                                order_item_id, meta_key, meta_value
                            FROM 
                                rbc_woocommerce_order_itemmeta 
                            WHERE 
                                meta_key IN ('_product_id', '_qty') AND
                                order_item_id IN (SELECT 
                                                    order_item_id
                                                FROM 
                                                    rbc_woocommerce_order_items 
                                                WHERE 
                                                    order_id = :id
                                                )
                        ORDER BY meta_id, meta_key");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0){

            $arr = array();

            $id_item = 0;
            $id_produto = 0;
            $qty = 0;

            $dados = $this->ListaAll();

            foreach ($dados as $k) {

                if($k['meta_key'] == '_qty')
                    $qty = $k['meta_value'];

                if($k['meta_key'] == '_product_id'){

                    $id_produto = $k['meta_value'];
                    $id_item = $k['order_item_id'];

                    $arr[] = array('id_produto' => $id_produto,
                                    'quantidade' => $qty);
                    
                }
                
            }

            return $arr;

        }

        return false;

    }

    public function produtosPedidoPeriodo(){

        $binds = array(
                        ':dtIni' => $this->pDataInicio(),
                        ':dtFim' => $this->pDataFim(),
                        ':id' => $this->pId()
                        );

        $this->pQuery("SELECT 
                            im.meta_key, im.meta_value
                        FROM 
                            rbc_woocommerce_order_itemmeta im
                            JOIN rbc_woocommerce_order_items oi ON im.order_item_id = oi.order_item_id
                            JOIN rbc_posts p2 ON oi.order_id = p2.ID
                        WHERE 
                            im.meta_key in ('_product_id', '_qty') AND
                            im.order_item_id in (SELECT 
                                                        order_item_id 
                                                    FROM 
                                                        rbc_woocommerce_order_items 
                                                    WHERE 
                                                        order_id in (SELECT 
                                                                            post_id 
                                                                        FROM 
                                                                            rbc_postmeta pm 
                                                                            LEFT JOIN rbc_posts p ON p.ID = pm.post_id
                                                                        WHERE 
                                                                            p.post_status = 'wc-completed' AND
                                                                            pm.meta_key = '_customer_user' AND
                                                                            pm.meta_value = :id

                                                                        )
                                                    )
                            AND DATE(p2.post_date) BETWEEN :dtIni AND :dtFim 
                    ");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0){

            $in = '';

            $dados = $this->ListaAll();

            foreach ($dados as $k) {

                if($k['meta_key'] == '_qty')
                    $qty = $k['meta_value'];
                
                if($k['meta_key'] == '_product_id'){

                    $id_produto = $k['meta_value'];

                    $in .= ",(".$this->pId().",
                              ".$id_produto.",
                              ".$qty.")";
                    
                }
                
            }

            $this->pQuery("TRUNCATE TABLE rbc_devem_aux_produto");

            $this->ExecutaQuery();

            $this->pQuery("
                            INSERT INTO
                                rbc_devem_aux_produto
                            (id_user,
                             id_produto,
                             quantidade)
                                VALUES
                            ".substr($in, 1));

            $this->ExecutaQuery();


            $this->pQuery("
                            SELECT
                                id_user, id_produto, sum(quantidade) as quantidade
                            FROM
                                rbc_devem_aux_produto
                            GROUP BY id_user, id_produto");

            $this->ExecutaQuery();

            $dados2 = $this->ListaAll();

            $arrProd = array();

            $end = end($dados2);

            foreach ($dados2 as $z) {
                    
                $arrProd[] = array('id_produto' => $z['id_produto'],
                                'quantidade' => $z['quantidade']);


            }

            $this->pQuery("TRUNCATE TABLE rbc_devem_aux_produto");

            $this->ExecutaQuery();

            return $arrProd;

        }

        return false;

    }

    public function dadosProduto($id){

        $binds = array(
                        ':id' => $id
                    );

        $this->pQuery("SELECT 
                            meta_key, meta_value
                        FROM 
                            rbc_postmeta
                        WHERE
                            post_id = :id
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

    public function finalizaPedido(){

        if(!empty($this->__array)){

            $binds = array(
                            ':id' => $this->pId()
                        );

            $order_key = 'order_'.Utilitarios::geraSenha(13);

            $this->pQuery("INSERT INTO 
                                rbc_posts 
                            (post_author, 
                                post_date, 
                                post_date_gmt, 
                                post_content, 
                                post_title, 
                                post_excerpt, 
                                post_status, 
                                comment_status, 
                                ping_status, 
                                post_password, 
                                to_ping, 
                                pinged, 
                                post_modified, 
                                post_modified_gmt, 
                                post_content_filtered, 
                                post_parent, 
                                menu_order, 
                                post_type, 
                                post_mime_type, 
                                comment_count) 
                            VALUES 
                                (:id, 
                                NOW(), 
                                NOW(), 
                                '', 
                                'Order &ndash; ".date('F')." ".date('d').", ".date('Y')." @ ".date('h:i')." ".date('A')."', 
                                '', 
                                'wc-processing', 
                                'open', 
                                'closed', 
                                '".$order_key."', 
                                '', 
                                '', 
                                NOW(), 
                                NOW(), 
                                '', 
                                0, 
                                0, 
                                'shop_order', 
                                '', 
                                1);

                                ");
            $this->ExecutaQuery($binds);

            $id_order = $this->ultimoId();

            $this->pQuery("UPDATE
                                rbc_posts 
                            SET
                                post_name = 'pedido-".$id_order."',
                                guid = 'http://".Configuracoes::Subdominio().".aguarochabranca.com.br/?post_type=shop_order&#038;p=".$id_order."'
                            WHERE
                                id = ".$id_order."
                                ");

            $this->ExecutaQuery();
            

            //# loop de produtos

            $valor_total = '0.00';

            $returnProdutos = array();
            
            foreach ($this->__array as $w) {

                $this->pQuery("INSERT INTO 
                                rbc_woocommerce_order_items 
                                    (order_item_name, order_item_type, order_id) 
                                VALUES 
                                ('".$w['desc']."', 'line_item', ".$id_order.");

                                ");

                $this->ExecutaQuery();

                $order_item_id = $this->ultimoId();

                $dados_produto = $this->dadosProduto($w['produto']);

                $valor_produto = $dados_produto['_price'];

                $valor_line = ($valor_produto * $w['quantidade']);

                $returnProdutos[] = array('array' => $w,
                                          'dados' => $dados_produto);

                $bindsX = array(
                                ':order_item_id'    => $order_item_id,
                                ':quantidade'       => $w['quantidade'],
                                ':produto'          => $w['produto'],
                                ':total'            => number_format($valor_line,2,'.','')
                                );

                $this->pQuery("INSERT INTO 
                                    rbc_woocommerce_order_itemmeta 
                                (order_item_id, meta_key, meta_value) 
                                VALUES (:order_item_id, '_qty', :quantidade),
                                         (:order_item_id, '_tax_class', ''),
                                         (:order_item_id, '_product_id', :produto),
                                         (:order_item_id, '_variation_id', '0'),
                                         (:order_item_id, '_line_subtotal', :total),
                                         (:order_item_id, '_line_total', :total),
                                         (:order_item_id, '_line_subtotal_tax', '0'),
                                         (:order_item_id, '_line_tax', '0'),
                                         (:order_item_id, '_line_tax_data', 'a:2:{s:5:\"total\";a:0:{}s:8:\"subtotal\";a:0:{}}');

                                ");

                $this->ExecutaQuery($bindsX);

                $valor_total = (int)$valor_total + $valor_line;
            }

            $mCliente = new ClienteModel;

            $mCliente->pId($this->pId());

            $dadosCliente = $mCliente->dadosCliente();

            $binds2 = array(
                            ':id_order'     => $id_order,
                            ':order_key'    => 'wc.'.$order_key,
                            ':ip'           => Configuracoes::meuIP(),
                            ':agent'        => $_SERVER['HTTP_USER_AGENT'],
                            ':id'           => $this->pId(),
                            ':nome'         => $dadosCliente['billing_first_name'],
                            ':sobrenome'    => $dadosCliente['billing_last_name'],
                            ':tipo'         => $dadosCliente['billing_persontype'],
                            ':cpf'          => $dadosCliente['billing_cpf'],
                            ':cnpj'         => $dadosCliente['billing_cnpj'],
                            ':cep'          => $dadosCliente['billing_postcode'],
                            ':endereco'     => $dadosCliente['billing_address_1'],
                            ':numero'       => $dadosCliente['billing_number'],
                            ':complemento'  => $dadosCliente['billing_address_2'],
                            ':bairro'       => $dadosCliente['billing_neighborhood'],
                            ':cidade'       => $dadosCliente['billing_city'],
                            ':uf'           => $dadosCliente['billing_state'],
                            ':telefone'     => $dadosCliente['billing_phone'],
                            ':celular'      => $dadosCliente['billing_cellphone'],
                            ':email'        => $dadosCliente['billing_email'],
                            ':valor_total'  => number_format($valor_total,2,'.','')
                            );

            $this->pQuery("INSERT INTO 
                            rbc_postmeta 
                                (post_id, meta_key, meta_value) 
                            VALUES 
                                (:id_order, '_order_key', :order_key),
                                (:id_order, '_order_currency', 'BRL'),
                                (:id_order, '_prices_include_tax', 'no'),
                                (:id_order, '_customer_ip_address', :ip),
                                (:id_order, '_customer_user_agent', :agent),
                                (:id_order, '_customer_user', :id),
                                (:id_order, '_created_via', 'checkout'),
                                (:id_order, '_order_version', '2.4.7'),
                                (:id_order, '_billing_alt', '0'),
                                (:id_order, '_billing_first_name', :nome),
                                (:id_order, '_billing_last_name', :sobrenome),
                                (:id_order, '_billing_persontype', :tipo),
                                (:id_order, '_billing_cpf', :cpf),
                                (:id_order, '_billing_company', ''),
                                (:id_order, '_billing_cnpj', :cnpj),
                                (:id_order, '_billing_country', 'BR'),
                                (:id_order, '_billing_postcode', :cep),
                                (:id_order, '_billing_address_1', :endereco),
                                (:id_order, '_billing_number', :numero),
                                (:id_order, '_billing_address_2', ''),
                                (:id_order, '_billing_neighborhood', ''),
                                (:id_order, '_billing_city', :cidade),
                                (:id_order, '_billing_state', :uf),
                                (:id_order, '_billing_phone', :telefone),
                                (:id_order, '_billing_cellphone', :celular),
                                (:id_order, '_billing_email', :email),
                                (:id_order, '_shipping_alt', '0'),
                                (:id_order, '_shipping_first_name', :nome),
                                (:id_order, '_shipping_last_name', :sobrenome),
                                (:id_order, '_shipping_company', ''),
                                (:id_order, '_shipping_country', 'BR'),
                                (:id_order, '_shipping_postcode', :cep),
                                (:id_order, '_shipping_address_1', :endereco),
                                (:id_order, '_shipping_number', :numero),
                                (:id_order, '_shipping_address_2', ''),
                                (:id_order, '_shipping_neighborhood', ''),
                                (:id_order, '_shipping_city', :cidade),
                                (:id_order, '_shipping_state', :uf),
                                (:id_order, '_payment_method', 'cod'),
                                (:id_order, '_payment_method_title', 'Pagamento na entrega'),
                                (:id_order, '_order_shipping', ''),
                                (:id_order, '_cart_discount', '0'),
                                (:id_order, '_cart_discount_tax', '0'),
                                (:id_order, '_order_tax', '0'),
                                (:id_order, '_order_shipping_tax', '0'),
                                (:id_order, '_order_total', :valor_total),
                                (:id_order, '_download_permissions_granted', '1'),
                                (:id_order, '_recorded_sales', 'yes'),
                                (:id_order, '_order_stock_reduced', '1');
                        ");

            $this->ExecutaQuery($binds2);

            $this->pQuery("INSERT INTO 
                            rbc_comments 
                                (comment_post_ID, 
                                    comment_author, 
                                    comment_author_email, 
                                    comment_author_url, 
                                    comment_author_IP, 
                                    comment_date, 
                                    comment_date_gmt, 
                                    comment_content, 
                                    comment_karma, 
                                    comment_approved, 
                                    comment_agent, 
                                    comment_type, 
                                    comment_parent, 
                                    user_id) 
                            VALUES 
                                (".$id_order.", 
                                'WooCommerce', 
                                '', 
                                '', 
                                '', 
                                NOW(), 
                                NOW(), 
                                'O pagamento será efetuado no momento da entrega. Status do pedido alterado de Pagamento Pendente para Processando.', 
                                0, 
                                '1', 
                                'WooCommerce', 
                                'order_note', 
                                0, 
                                0);
                            ");

            $this->ExecutaQuery();

            return array('id_order'      => $id_order,
                         'dados_cliente' => $dadosCliente,
                         'dados_produto' => $returnProdutos);

        }else{

            return false;

        }

    }

    public function produtosValidos(){

        if(filter_var(Configuracoes::Valor('produtos_pedidos_regra'), FILTER_VALIDATE_BOOLEAN)){

            $cond = "AND post_id in (
                                SELECT
                                    id_produto
                                FROM
                                    rbc_devem_regra_produto
                                GROUP BY 1)";

        }

        $this->pQuery("SELECT
                            rp.comissao, rp.pontos, pm.*
                        FROM
                            rbc_postmeta pm
                            JOIN rbc_posts p ON p.ID = pm.post_id
                            LEFT JOIN rbc_devem_regra_produto rp ON rp.id_produto = p.ID AND rp.reputacao = (SELECT reputacao FROM rbc_devem_representante_indice WHERE id_user = ".Session::get('ID')." LIMIT 1)
                        WHERE
                            p.post_type = 'product' AND
                            p.post_status = 'publish' AND
                            pm.meta_key in ('_thumbnail_id', '_price', '_stock_status') 
                            ".@$cond."
                        GROUP BY pm.post_id, pm.meta_key
                            ");

        $this->ExecutaQuery();

        if($this->TotalRows() > 0){

            $arr = array();

            $id_item = 0;
            $id_produto = 0;
            $qty = 0;

            $dados = $this->ListaAll();

            foreach ($dados as $k) {

                if($k['meta_key'] == '_price')
                    $valor = number_format($k['meta_value'], 2, '.', ',');

                if($k['meta_key'] == '_stock_status')
                    $estoque = ($k['meta_value'] == 'instock' ? 'Pronta Entrega' : 'Esgotado');

                if($k['meta_key'] == '_thumbnail_id'){

                    $id_produto = $k['post_id'];

                    $ganho = $k['comissao'];

                    $pontos = $k['pontos'];

                    $this->pQuery("SELECT
                                        guid
                                    FROM
                                        rbc_posts
                                    WHERE
                                        ID = ".$k['meta_value']."
                                    LIMIT 1
                                        ");

                    $this->ExecutaQuery();

                    $exImg = $this->Lista();

                    $this->pQuery("SELECT
                                        post_title
                                    FROM
                                        rbc_posts
                                    WHERE
                                        ID = ".$id_produto."
                                    LIMIT 1
                                        ");

                    $this->ExecutaQuery();

                    $exProd = $this->Lista();

                    $produto = $exProd['post_title'];
                    $img = $exImg['guid'];

                    $arr[] = array('id_produto' => $id_produto,
                                    'produto' => $produto,
                                    'imagem' => $img,
                                    'estoque' => $estoque,
                                    'valor' => $valor,
                                    'ganho' => $ganho,
                                    'pontos' => $pontos);
                    
                }
                
            }

            return $arr;

        }
        
        return false;

    }

    public function checkPedidoInvalido(){

        $binds = array(
                        ':id' => $this->pId()
                    );

        $this->pQuery("SELECT 
                            pm.meta_value as usuario,
                            p.ID as pedido
                        FROM 
                            rbc_postmeta pm 
                            JOIN rbc_posts p ON pm.post_id = p.ID
                        WHERE
                            pm.meta_key = '_customer_user' AND
                            p.post_password = :id
                        LIMIT 1
                            ");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0){

            $dados = $this->Lista();

            $binds = array(
                        ':id' => $dados['pedido']
                    );

            $this->pQuery("UPDATE 
                                rbc_posts
                            SET
                                post_status = 'wc-cancelled',
                                comment_status = 'closed'
                            WHERE
                                ID = :id
                                ");

            $this->ExecutaQuery($binds);

            $binds2 = array(
                            ':id' => $dados['pedido'],
                            ':usuario' => $dados['usuario']
                        );

            $this->pQuery("INSERT INTO 
                                rbc_devem_pedido_indevido
                                (id_pedido, id_usuario, data_registro)
                            VALUES
                                (:id, :usuario, NOW())
                                ");

            $this->ExecutaQuery($binds2);

            return true;

        }

        return false;




    }
	
}