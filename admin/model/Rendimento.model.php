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
 * Model Rendimento
 *
 * @package     app
 * @subpackage  model 
 * @author      Christopher Villagra <christopher.villagra@antena1.com.br> 
 * @copyright   (c) 2015 - Antena1
**/

final class RendimentoModel extends Repositorio
{

	//DECLARAÇÕES DE VARIAVEIS
    private $__id;
    private $__idRepresentante;
    private $__pedido;
    private $__limite = 15;
    private $__array = array();
    private $__valor;
	
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
    public function pIdRepresentante($val="")
    {
        if($val === "") return $this->__idRepresentante;
        else $this->__idRepresentante = $val;
    }
    
    /**
    * Metodo de encapsulamento GETSET
    *
    * @author    Christopher Dencker Villagra
    */
    public function pIdPedido($val="")
    {
        if($val === "") return $this->__pedido;
        else $this->__pedido = $val;
    }
    
    /**
    * Metodo de encapsulamento GETSET
    *
    * @author    Christopher Dencker Villagra
    */
    public function pLimite($val="")
    {
        if($val === "") return $this->__limite;
        else $this->__limite = $val;
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
    
    /**
    * Metodo de encapsulamento GETSET
    *
    * @author    Christopher Dencker Villagra
    */
    public function pValor($val="")
    {
        if($val === "") return $this->__valor;
        else $this->__valor = $val;
    }

    public function cronPontos(){

        $this->pQuery("SELECT 
                            pm.post_id, i.reputacao, u.user_representante, u.ID
                        FROM 
                            rbc_postmeta pm 
                            JOIN rbc_users u ON u.ID = pm.meta_value
                            LEFT JOIN rbc_posts p ON p.ID = pm.post_id
                            JOIN rbc_devem_desempenho i ON i.id_user = u.user_representante
                        WHERE 
                            p.post_status = 'wc-completed'
                        GROUP BY 1 ");

        $this->ExecutaQuery();

        if($this->TotalRows() > 0){

            $comissao = 0;

            $pontos = 0;

            $dado = $this->ListaAll();

            $mPedido = new PedidoModel;

            foreach ($dado as $k) {
                
                $binds2 = array(
                            ':id' => $k['post_id']
                        );

                $this->pQuery("SELECT 
                                    null
                                FROM 
                                    rbc_postmeta
                                WHERE 
                                    post_id = :id AND
                                    meta_key = '_ganho_check'");

                $this->ExecutaQuery($binds2);

                if($this->TotalRows() == 0){

                    $binds3 = array(
                                    ':id' => $k['post_id'],
                                    ':key' => '_ganho_check',
                                    'value' => 'TRUE'
                                    );

                    $this->pQuery("INSERT INTO
                                        rbc_postmeta 
                                    (post_id, meta_key, meta_value)
                                    VALUES
                                        (:id, :key, :value)");

                    $this->ExecutaQuery($binds3);

                    $produtos = $mPedido->produtosPedido($k['post_id']);

                    for($i = 0; $i < count($produtos); $i++){

                        $validaProduto = $this->produtosComRegras($produtos[$i]['id_produto'], $k['reputacao'], true);

                        if($validaProduto !== false){

                            $comissao = ($validaProduto['comissao'] * $produtos[$i]['quantidade']);

                            $pontos = ($validaProduto['pontos'] * $produtos[$i]['quantidade']);

                            $this->pIdRepresentante($k['user_representante']);
                            $this->pId($k['ID']);
                            $this->pIdPedido($k['post_id']);

                            $this->addPontos($comissao, $pontos);

                        }

                    }

                }

            }

            return true;

        }

        return false;

    }


    public function produtosComRegras($produto = false, $reputacao = false, $unique = false){

        $this->pQuery("SELECT
                            p.ID, p.post_title, rp.reputacao, rp.comissao, rp.pontos
                        FROM 
                            rbc_posts p 
                            JOIN rbc_devem_regra_produto rp ON rp.id_produto = p.ID
                        WHERE
                            p.post_type = 'product' AND
                            p.post_status = 'publish'
                            ".($produto !== false ? ' AND rp.id_produto = '.$produto : '')
                            .($reputacao !== false ? ' AND rp.reputacao = '.$reputacao : '')
                            .($unique !== false ? ' LIMIT 1' : '')
                            );

        $this->ExecutaQuery();

        if($this->TotalRows() > 0){

            if($unique !== false)
                return $this->Lista();

            return $this->ListaAll();

        }

        return false;

    }

    public function getRegrasPotencial(){

        $this->pQuery("SELECT
                            id_regra, json
                        FROM 
                            rbc_devem_regra_rendimento
                        WHERE
                            status = 1
                            "
                            );

        $this->ExecutaQuery();

        $potencial_default = [];

        if($this->TotalRows() > 0){

            $dados = $this->ListaAll();

            foreach ($dados as $k)
                $potencial_default[] = array('id' => $k['id_regra'], 'json' => json_decode($k['json'], true));

            $potencial_default['regras'] = $potencial_default;

            return $potencial_default;

        }

        return false;

    }

    public function addPontos($comissao = false, $pontos = false){

        if(!$comissao && $pontos)
            return false;

        $binds = array(':id' => $this->pIdRepresentante(),
                        ':idCliente' => $this->pId(),
                        ':idPedido' => $this->pIdPedido());

        if($pontos !== false)
            $binds[':pontos'] = $pontos;

        if($comissao !== false)
            $binds[':comissao'] = $comissao;

        $this->pQuery("INSERT INTO
                        rbc_devem_ganho_log
                            (id_user, 
                            id_cliente, 
                            id_pedido, 
                            ".($pontos !== false ? 'pontos, ' : '').
                             ($comissao !== false ? 'ganho, ' : '')."
                            data_registro)
                        VALUES
                            (:id,
                             :idCliente,
                             :idPedido
                             ".($pontos !== false ? ', :pontos' : '').
                             ($comissao !== false ? ', :comissao' : '')."
                             , NOW())");

        $this->ExecutaQuery($binds);

        unset($binds);

        $binds = array(':id' => $this->pIdRepresentante(),
                        ':pontos' => (!$pontos ? '' : $pontos),
                        ':ganho' => (!$comissao ? '' : $comissao)
                        );

        $this->pQuery("UPDATE
                            rbc_devem_ganho
                        SET
                            ganho = ganho + :ganho,
                            ganho_total = ganho_total + :ganho,
                            pontos_total = pontos_total + :pontos
                        WHERE
                            id_user = :id");

        $this->ExecutaQuery($binds);

        return true;

    }

    public function reorganizaRanking(){

        $this->pQuery("SELECT 
                            g.id_user, g.pontos_total, g.ganho_total
                        FROM 
                            rbc_devem_ganho g
                            JOIN rbc_users u ON g.id_user = u.ID
                        WHERE 
                            u.user_status_representante = 1 AND
                            u.user_activation_key is null AND
                            u.user_status = 1
                        ORDER BY
                            g.pontos_total, g.ganho_total, u.ID");

        $this->ExecutaQuery();

        $dados = $this->ListaAll();

        $posicao = 1;

        $in = '';

        foreach ($dados as $k) {

            $in = ", (".$posicao.",".$k['id_user'].",".$k['pontos_total'].",".$k['ganho_total'].", NOW())";

            $posicao++;
            
        }

        $this->pQuery("TRUNCATE table rbc_devem_ranking");

        $this->ExecutaQuery();

        $this->pQuery("INSERT INTO
                            rbc_devem_ranking 
                        (posicao, id_user, pontuacao, rendimento, data_registro)
                        VALUES
                            ".substr($in, 1));

        if(!empty($in))
            $this->ExecutaQuery();

    }

    public function getDado($campo){

        $binds = array(':id' => $this->pId());

        $this->pQuery("SELECT
                            {$campo}
                        FROM
                            rbc_devem_ranking
                        WHERE
                            id_user = :id
                        LIMIT 1
                        ");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0){

            $dado = $this->Lista();

            return $dado[$campo];
        }

        return false;

    }

    public function getRendimento($campo){

        $binds = array(':id' => $this->pId());

        $this->pQuery("SELECT
                            {$campo}
                        FROM
                            rbc_devem_desempenho
                        WHERE
                            id_user = :id
                        LIMIT 1
                        ");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0){

            $dado = $this->Lista();

            return $dado[$campo];
        }

        return false;

    }

    public function reputacaoClientePotencialRendimento(){

        $binds = array(
                        ':id' => $this->pId()
                    );

        $nr = Configuracoes::Valor('nivel_reputacao');

        $arrReturn = array();

        $this->pQuery("SELECT 
                            d.reputacao, count(d.reputacao) as qtd
                        FROM 
                            rbc_users u
                            JOIN rbc_devem_desempenho d ON u.ID = d.id_user
                        WHERE
                            u.user_representante = :id AND
                            u.user_activation_key is null AND
                            u.user_status = 1
                        GROUP BY 1
                        ORDER BY 1
                            ");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0){

            $dados = $this->ListaAll();

            foreach ($dados as $k) 
                $arrNivel[$k['reputacao']] = $k['qtd'];

            for ($i=0; $i < $nr; $i++){

                if(!isset($arrNivel[$i]))
                    $arrNivel[$i] = 0;

                array_push($arrReturn, (int)$arrNivel[$i]);

            }

            return $arrReturn; 

        }

        return array(0,0,0);

    }

    public function desempenhoPeriodo(){

        if(empty($this->__array))
            return false;

        $in = '';
        $inLog = '';
        $inPer = '';

        $nr = Configuracoes::Valor('nivel_reputacao');
        $per = Configuracoes::Valor('base_potencial_periodo');

        foreach ($this->__array as $k) {

            $count_per = 0;

            $desempenho = 0;

            $desempenhoParcial = 0;

            $RPa = 0;

            $regras = $k['regras'];

            $total_regras = count($k['regras']);

            foreach ($regras as $w => $r){

                $inLog .= ", (".$k['id_user'].",".$r['id'].",".$r['validate'].", NOW())";

                $desempenhoParcial = $desempenhoParcial + (int)$r['validate'];

                if((($w + 1)%($total_regras/$per)) == 0){

                    $DPx = round(($desempenhoParcial * 100) / $total_regras);

                    $RPx = ceil($DPx * $nr / 100);

                    if($DPx == 100)
                        $RPx = $nr - 1;

                    $RPa = $RPa + $RPx;

                    if($count_per == 0)
                        $potencial = $DPx;

                    $potencial = ($potencial + $DPx) / 2;

                    $inPer .= ", (".$k['id_user'].",".$count_per.",".$DPx.",".$RPx.", NOW())";

                    $count_per++;

                    $desempenho = $desempenho + $DPx;

                    $desempenhoParcial = 0;

                }

            }

            $DPa = round($desempenho / $per);

            $RPa = ceil($DPa * $nr / 100);

            if($DPa == 100)
                $RPa = $nr - 1;

            $in .= ", (".$k['id_user'].",".$RPa.",".$DPa.",".round($potencial).",".$total_regras.", NOW())";
            
        }

        $this->pQuery("INSERT INTO
                            rbc_devem_desempenho_log
                        (id_user, id_regra, validate, data_registro)
                        VALUES
                            ".substr($inLog, 1));

        $this->ExecutaQuery();

        $this->pQuery("INSERT INTO
                            rbc_devem_desempenho_periodo
                        (id_user, periodo, desempenho, reputacao, data_registro)
                        VALUES
                            ".substr($inPer, 1));

        $this->ExecutaQuery();

        $this->pQuery("REPLACE INTO
                            rbc_devem_desempenho
                        (id_user, reputacao, desempenho, potencial, regras_total, data_registro)
                        VALUES
                            ".substr($in, 1));

        $this->ExecutaQuery();


    }

    public function atualizaRepresentantes(){

        $this->pQuery("SELECT
                            ux.user_representante, 
                            SUM(d.reputacao) as reputacao, 
                            SUM(d.desempenho) as desempenho, 
                            SUM(d.potencial) as potencial, 
                            COUNT(d.id_user) as total
                        FROM
                            rbc_devem_desempenho d
                            JOIN rbc_users ux ON d.id_user = ux.ID
                        WHERE
                            d.id_user in (SELECT
                                                    u2.ID
                                                FROM
                                                    rbc_users u
                                                    JOIN rbc_users u2 ON u.ID = u2.user_representante
                                                WHERE
                                                    u.user_status_representante = 1
                                                    AND u.user_status = 1)
                        GROUP BY 1
                        ");

        $this->ExecutaQuery();

        if($this->TotalRows() > 0)
            $dados = $this->ListaAll();

        $this->pQuery("UPDATE
                            rbc_devem_representante_indice
                        SET
                            atualizado = 0
                        ");

        $this->ExecutaQuery();

        if(isset($dados)){

            $in = '';

            foreach ($dados as $k) {

                $desempenho = $k['desempenho']/$k['total'];
                
                $potencial = $k['potencial']/$k['total'];
                
                $reputacao = ceil($k['reputacao']/$k['total']);

                $in .= ",(".$k['user_representante'].", ".$reputacao.", ".($desempenho == 1 ? 0 : $desempenho).", ".($potencial == 1 ? 0 : $potencial).", 1, NOW())";

            }

            $this->pQuery("REPLACE INTO
                                rbc_devem_representante_indice
                            (id_user, reputacao, desempenho, potencial, atualizado, data_registro)
                            VALUES
                                ".substr($in, 1));

            $this->ExecutaQuery();

        }
        return false;



    }

    public function getRanking(){

        $binds = array(':id' => $this->pId());

        $this->pQuery("SELECT
                            r.posicao, 
                            u.user_login, 
                            r.pontuacao,
                            COALESCE(u2.user_login, '- - -') as representante,
                            '1' as insignia
                        FROM
                            rbc_devem_ranking r
                            JOIN rbc_users u ON r.id_user = u.ID
                            LEFT JOIN rbc_users u2 ON u.user_representante = u2.ID
                        WHERE
                            u.user_status_representante = 1 AND
                            u.user_activation_key is null AND
                            u.user_status = 1
                        ORDER BY 1
                        LIMIT 
                        ".$this->pLimite());

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0)
            return $this->ListaAll();

        return false;


    }

    public function getGanho(){

        $binds = array(':id' => $this->pId());

        $this->pQuery("SELECT
                            *
                        FROM
                            rbc_devem_ganho
                        WHERE
                            id_user = :id
                        ");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0)
            return $this->Lista();

        return false;


    }

    public function getRendimentoReputacao(){

        $binds = array(':id' => $this->pId());

        $this->pQuery("SELECT
                            *
                        FROM
                            rbc_devem_ganho_log
                        WHERE
                            id_user = :id
                        ");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0)
            return $this->ListaAll();

        return false;

    }

    public function ganhoMesesAnteriores(){

        $binds = array(':id' => $this->pId());

        $this->pQuery("SELECT
                            COALESCE((SUM(valor) / COUNT(1)), '0,00') as total
                        FROM
                            rbc_devem_resgate
                        WHERE
                            id_user = :id
                        ");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0){

            $dados = $this->Lista();

            return $dados['total'];

        }

        return 0;

    }

    public function rendimentoDisponivel(){

        $binds = array(':id' => $this->pId());

        $this->pQuery("SELECT
                            ganho
                        FROM
                            rbc_devem_ganho
                        WHERE
                            id_user = :id
                        ");

        $this->ExecutaQuery($binds);

        if($this->TotalRows() > 0){

            $dados = $this->Lista();

            return $dados['ganho'];

        }

        return 0;

    }

    public function cadastrarResgate(){

        $binds = array(
                        ':id' => $this->pId(),
                        ':valor' => $this->pValor()
                      );

        $this->pQuery("INSERT INTO
                            rbc_devem_resgate
                        (id_user, valor, data_registro)
                        VALUES
                        (:id, :valor, NOW())
                        ");

        $this->ExecutaQuery($binds);

        $this->pQuery("UPDATE
                            rbc_devem_ganho
                        SET
                            resgatado = resgatado + :valor,
                            ganho = ganho - :valor
                        WHERE
                            id_user = :id
                        ");

        $this->ExecutaQuery($binds);

    }
	
}