<?php

/*
 * @Projeto: 	Devem
 * @Script: 	Classe Repositorio de Manipulação de Dados com PDO.
 */


class Repositorio {

    /**
     * A instância de conexão com o banco de dados.
     * @var PDO
     */
    private static $DB = null;

    /**
     * A consulta no banco de dados.
     * @var string
     */
    private $DB_query;

    /**
     * Consulta preparada para ser executada.
     * @var PDOStatement
     */
    public $Statement;
    
    /**
     * SQl do tipo SELECT
     * @var bool
     */
    protected $isSelect;
    
    /**
     * Armazena resultado do COUNT (apenas para facilitar algumas interações)
     * @var int Count
     */
    protected $TotalCount;
    
    /**
     * Armazena resultado de rowCount (apenas para facilitar algumas interações)
     * @var int Count
     */
    protected $RowCount;
    
    /**
     * Index do Result
     * @var int
     */
    protected $ResultIndex = 0;

    /**
     * Resultado do fetch da query
     * @var array
     */
    protected $Result = array();
    
    /**
     *
     * @var boolean 
     */
    private static $log = true;

    /**
     * Propriedades
     */
    public static function db() {

        return new self();
    }

    private static function pDB($val = "") {
        if ($val === "") {

            # Caso seja iniciada uma execução de consulta sem que 
            # o PDO exista, então cria o PDO. O banco deve estar sempre disponível.
            if (!self::$DB)
                self::DefaultDAO();

            return self::$DB;
        } else
            self::$DB = $val;
    }

    public function pQuery($val = "") {
        if ($val === "") {

            return $this->DB_query;
        } else {
            
            $this->isSelect = (strtolower(substr(trim($val), 0, 6)) == 'select');
            $this->DB_query = $val;
            return $this;
        }
    }
    
    /**
     * Atribui ou obtém valor à propriedade Count
     *
     * @author Christopher Villagra
     * @param  bool $set : Atribuir ou Obter o valor da propriedade Count (True/False)
     * @return int
     */
    public function pTotalCount($set = false) {
        
        if( $set === false ) { 
            return !empty($this->TotalCount) ? $this->TotalCount : 0;
        } else { 
            $this->TotalCount = !empty($this->Result[0]["total"]) ? $this->Result[0]["total"] : 0;
        }
        
    }
    
    /**
     * Atribui ou obtém valor à propriedade Count
     *
     * @author Christopher Villagra
     * @param  bool $set : Atribuir ou Obter o valor da propriedade Count (True/False)
     * @return int
     */
    public function pRowCount($set = false) {
        
        if( $set === false ) { 
            return !empty($this->RowCount) ? $this->RowCount : 0;
        } else { 
            $this->RowCount = count( $this->Result );
        }
        
    }
    
    /**
     * Construtor da Classe
     * 
     * @author  Christopher Villagra
     * 
     * @param 	bool $is_conn_default : Carrega a base de dados padrão do sitema.
     * @return  resource
     */
    public function __construct($is_conn_default = true) {
        if ($is_conn_default)
            self::DefaultDAO();
    }

    /**
     * Cria o objeto de acesso à base de dados.
     *
     * @author  Christopher Villagra
     * 
     * @return  void
     */
    private static function DefaultDAO() {
        # Se ja existir uma conexão, mantenha a mesma.
        if (self::$DB)
            return;

        $dsn = 'mysql:dbname=' . DB_DATABASE . ';host=' . DB_SERVER . ';charset=utf8';

        try {
            self::pDB(
                    new PDO($dsn, DB_USUARIO, DB_SENHA, array(
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone = '-03:00', NAMES 'utf8', character_set_connection=utf8, character_set_client=utf8, character_set_results=utf8;"
                        )
                    )
            );
        }  catch (PDOException $e){
            $view = new View("layout/manutencao.phtml");
            $view->pParametros(array(
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ));
            $view->Show();
        }
    }
    
    
    
    /**
     * Retorna o último id inserido no banco de dados.
     *
     * @author Christopher Villagra
     * @return int
     */
    public function ultimoId() {
        return self::pDB()->lastInsertId();
    }
    
    /**
     * Executa a consulta preparada.
     *
     * @author  Christopher Villagra
     * 
     * @author  Christopher Villagra
     * @param   array $binds : Binds para os prepared-statements.
     * @param   array $memcache : 0 - Obter do mc / 1 - Salvar no mc / 2 - Timeout quando salvar (s).
     * @return  bool 
     */
    public function ExecutaQuery(array $binds = array(), array $memcache = array(false, false, 10)) {

        $this->Result = array();
        $this->ResultIndex = 0;
        $this->pRowCount(true);
        
        
        # Executa a consulta.
        $this->Statement = self::pDB()->prepare($this->pQuery());
        
        # Retorno da Execução da Query
        if ($this->Statement->execute($binds)) {
            
            if( $this->isSelect ) {
                
                $this->Result      = $this->Statement->fetchAll(PDO::FETCH_ASSOC);
                $this->ResultIndex = 0;
                $this->pRowCount(true);
            
            }
            if (self::$log)
                $this->queryLog('Sucesso', $binds);

            self::$log = true;

            return $this;
        }
        else {

            if (self::$log)
                $this->queryLog('Erro', $binds);

            self::$log = true;

            return false;
        }
    }

    /**
     * Executa Query em 'modo COUNT'.
     * 
     * @author  Christopher Villagra
     * @param   array $binds : Binds para os prepared-statements.
     * @param   array $memcache : 0 - Obter do mc / 1 - Salvar no mc / 2 - Timeout quando salvar.
     * @return  bool 
     */
    public function ExecutaQueryCount(array $binds = array(), array $memcache = array(false, false, 10)) {

        $newquery = $oldquery = $this->pQuery();

        if( substr_count(strtoupper($newquery), "GROUP BY") == 1 ) {
            $pos = strripos($newquery, "GROUP BY");
            if ($pos > 0) {
                $newquery = substr($newquery, 0, $pos);
            }
        }
        
        if( substr_count(strtoupper($newquery), "ORDER BY") == 1 ) {
            $pos = strripos($newquery, "ORDER BY");
            if ($pos > 0) {
                $newquery = substr($newquery, 0, $pos);
            }
        }
        
        $this->pQuery($newquery);

        $return = $this->ExecutaQuery($binds, $memcache);
        $this->pTotalCount(true);
        
        $this->pQuery($oldquery);

        unset($newquery);
        unset($oldquery);

        return $return;
    }
    
    /**
     * Retorna o total de resultados encontrados.
     * 
     * @author  Christopher Villagra
     * 
     * @author  Christopher Villagra
     * @return int
     */
    public function TotalRows($count = false) {

        if ( $count === true ) {
            return $this->TotalCount;
        }
        
        return $this->RowCount;
        
    }

    /**
     * Efetua o "fetch". Retorna o resultado referente à
     * posição do cursor da consulta no banco de dados.
     * 
     * @author  Christopher Villagra
     * 
     * @return  array
     */
    public function Lista() {

        # Caso não tenha mais nós retorna
        if ( $this->ResultIndex > count($this->Result) ) {
            return;
        }

        if( isset($this->Result[ $this->ResultIndex ]) ) {

            $return = $this->Result[ $this->ResultIndex ];
            $this->ResultIndex++;

            return $return;
            
    	}
        
        return;
        
    }

    /**
     * Retorna todos os resultados encontrados.
     *
     * 
     * @return  array
     */
    public function ListaAll() {

        return $this->Result;
        
    }

    public function Begin() {
        /**
         * @todo  begin transaction.
         */
    }

    public function Commit() {
        /**
         * @todo  commit transaction.
         */
    }

    /**
     * Gera um hash MD5 para a execução/resultado de uma query
     * Hash gerado através da concatenação de Server + Database + SQL + Variáveis Bind
     * 
     * @author Christopher Villagra
     * @return string
     */
    protected function getKeyHash($binds) {
        return md5( serialize( array(DB_server, DB_database, $this->pQuery(), $binds) ) );
    }
    
    /**
     * Exibe a consulta.
     * Essa implementação permite que
     * echo $this->pQuery() ou echo parent::pQuery(); funcionem corretamente.
     * 
     * @author Christopher Villagra
     * @return void
     */
    public function __toString() {
        return '<pre>' . print_r($this->pQuery(), true) . '</pre>';
    }

    /**
     * Reseta a instância.
     *
     * @author Christopher Villagra
     * @return void
     */
    private function Fechar() {
        @self::pDB(null);
    }

    /**
     * Destrói o objeto encerrando a instância de banco 
     * de dados presente nele.
     * 
     * @author Christopher Villagra
     * @return void
     */
    public function __destruct() {
        $this->Fechar();
    }

    public function queryLog($resultado, $binds) {

        /**
         * @todo armazenar todas as querys numa variável estática e fazer 
         * um foreach registrando-as no banco de dados no __destruct
         */
        /*
          ob_start();

          $binds = ob_get_clean();

          $query = "INSERT INTO tb_query_log(statement, binds, resultado, ip, usuario) VALUES (:statement, :binds, :resultado, :ip, :usuario)";

          self::$log = false;

          if(empty($binds));
          $binds = 'Não declarado.';

          $id = 0;

          if(isset($_SESSION['_devem_']['id_usuario']))
          $id = $_SESSION['_devem_']['id_usuario'];

          self::db()->pQuery($query)->ExecutaQuery(array(
          ':ip' => $_SERVER['SERVER_ADDR'],
          ':binds' => $binds,
          ':usuario' => $id,
          ':resultado' => $resultado,
          ':statement' => $this->DB_query
          ));
         */
    }

}
