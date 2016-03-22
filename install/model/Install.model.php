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
 * Model Install
 *
 * @package     app
 * @subpackage  model 
 * @author      Christopher Villagra <christopher@dvillagra.com.br> 
 * @copyright   (c) 2015 - Devem
**/

//# faz um require das configurações de banco e do PDO
require_once ('../../config/conn.php');
require_once ('../core/Repositorio.class.php');

final class InstallModel extends Repositorio
{
	
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
     * Método que cria as tabelas da base de dados que será utilizado pelo DEVEM
     *
     * @author  Christopher Villagra
    */
    
    public function installBanco(){

        //# Inserindo tabela de usuarios do admin
        $this->pQuery("DROP TABLE IF EXISTS dv_admusuario;");
        $this->ExecutaQuery();

        $this->pQuery("CREATE TABLE dv_admusuario (
                            idUsuario INT(11) NOT NULL AUTO_INCREMENT,
                            auNivel INT(1) NOT NULL DEFAULT '2',
                            auNome VARCHAR(90) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
                            auEmail VARCHAR(70) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
                            auLogin VARCHAR(30) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
                            auImagem VARCHAR(70) NULL DEFAULT 'avatar.jpg' COLLATE 'latin1_general_ci',
                            auSenha VARCHAR(32) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
                            auCodeRedefine VARCHAR(32) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
                            auCodeCookie VARCHAR(32) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
                            auCodeAuth VARCHAR(32) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
                            auStatus TINYINT(1) NULL DEFAULT '1',
                            auDataCadastro DATETIME NULL DEFAULT NULL,
                            auDataAtualizacao TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            PRIMARY KEY (idUsuario)
                        )
                        COMMENT='Tb Devem - Tabela que armazena os dados de acesso do admin'
                        COLLATE='latin1_general_ci'
                        ENGINE=InnoDB
                        ;");
        $this->ExecutaQuery();

        //# Inserindo tabela de parametros
        $this->pQuery("DROP TABLE IF EXISTS dv_parametros;");
        $this->ExecutaQuery();

        $this->pQuery("CREATE TABLE dv_parametros (
                            idParametro INT NOT NULL AUTO_INCREMENT,
                            pAlias VARCHAR(70) NULL,
                            pChave VARCHAR(50) NULL,
                            pValorDefault VARCHAR(120) NULL,
                            pValorAtual VARCHAR(120) NULL,
                            pDescricao TEXT NULL,
                            pStatus TINYINT(1) NULL DEFAULT '1',
                            pDataCadastro DATETIME NULL,
                            pDataAtualizacao TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                            PRIMARY KEY (idParametro)
                        )
                        COMMENT='Tb Devem - Tabela que os parametros do sistema'
                        COLLATE=latin1_general_ci
                        ENGINE=InnoDB
                        ;");
        $this->ExecutaQuery();
        
    }

    /**
     * Método que inseri todos os parametros na tabela de parametros para o DEVEM utilizar
     *
     * @author  Christopher Villagra
    */
    
    public function installParametros(){

        $this->pQuery(
                       "INSERT INTO
                            dv_parametros
                            (pAlias, pChave, pValorDefault, pValorAtual, pDataCadastro)
                            VALUES
                            (
                                'S3 - Secret',
                                's3_secret',
                                '".$_SESSION['_devem_install_']['s3_secret']."',
                                '".$_SESSION['_devem_install_']['s3_secret']."',
                                NOW()
                            ),
                            (
                                'S3 - Key',
                                's3_key',
                                '".$_SESSION['_devem_install_']['s3_key']."',
                                '".$_SESSION['_devem_install_']['s3_key']."',
                                NOW()
                            ),
                            (
                                'S3 - Bucket',
                                's3_bucket',
                                '".$_SESSION['_devem_install_']['s3_bucket']."',
                                '".$_SESSION['_devem_install_']['s3_bucket']."',
                                NOW()
                            ),
                            (
                                'S3 - Url',
                                's3_url',
                                '".$_SESSION['_devem_install_']['s3_url']."',
                                '".$_SESSION['_devem_install_']['s3_url']."',
                                NOW()
                            ),
                            (
                                'Mail - Host',
                                'mail_host',
                                '".$_SESSION['_devem_install_']['email_host']."',
                                '".$_SESSION['_devem_install_']['email_host']."',
                                NOW()
                            ),
                            (
                                'Mail - Secure',
                                'mail_secure',
                                '".$_SESSION['_devem_install_']['email_secure']."',
                                '".$_SESSION['_devem_install_']['email_secure']."',
                                NOW()
                            ),
                            (
                                'Mail - Porta',
                                'mail_porta',
                                '".$_SESSION['_devem_install_']['email_porta']."',
                                '".$_SESSION['_devem_install_']['email_porta']."',
                                NOW()
                            ),
                            (
                                'Mail - Usuario',
                                'mail_usuario',
                                '".$_SESSION['_devem_install_']['email_usuario']."',
                                '".$_SESSION['_devem_install_']['email_usuario']."',
                                NOW()
                            ),
                            (
                                'Mail - Senha',
                                'mail_senha',
                                '".$_SESSION['_devem_install_']['email_senha']."',
                                '".$_SESSION['_devem_install_']['email_senha']."',
                                NOW()
                            ),
                            (
                                'Mail - Nome Remetente',
                                'mail_rementente_nome',
                                '".$_SESSION['_devem_install_']['email_rementente_nome']."',
                                '".$_SESSION['_devem_install_']['email_rementente_nome']."',
                                NOW()
                            ),
                            (
                                'Mail - Email Remetente',
                                'mail_rementente_email',
                                '".$_SESSION['_devem_install_']['email_rementente_email']."',
                                '".$_SESSION['_devem_install_']['email_rementente_email']."',
                                NOW()
                            )
                        "
                        );

        $this->ExecutaQuery();

    }

    /**
     * Método que inseri os dados de acesso de usuários do admin
     *
     * @author  Christopher Villagra
    */
    
    public function installAdmin(){

        $this->pQuery(
                       "INSERT INTO
                            dv_admUsuario
                            (auNome, auNivel, auEmail, auLogin, auSenha, auDataCadastro)
                            VALUES
                            (
                                '".$_SESSION['_devem_install_']['adm_nome']."',
                                0,
                                '".$_SESSION['_devem_install_']['adm_email']."',
                                '".$_SESSION['_devem_install_']['adm_usuario']."',
                                MD5('".$_SESSION['_devem_install_']['adm_senha']."'),
                                NOW()
                            )
                        "
                        );

        $this->ExecutaQuery();

    }
	
}