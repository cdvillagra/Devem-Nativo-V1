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

//# Define uma variavel de controle de instalação das dependencias do Devem
//#[DV_INSTALL]

//# Define se existe conexão com o banco de dados no sistema
define("DB_ATIVO", '[CONFIG_DB_ATIVO]');
//# Define se a autenticação na camada app será ignorada
define("IGNORE_AUTH", '[CONFIG_IGNORE_AUTH]');

//# Caminho de onde está a pasta API - podendo ser colocada em qualquer pasta interna ou host externo
define("G_API_URL", 'api/index.php');
//# Chave de conexão com a API
define("G_API_KEY", '[CONFIG_G_API_KEY]');

//# Define o key da variavel de sessão da camada app
define("SESSION_APP", '_app_[CONFIG_SESSION_APP]_');
//# Define o key da variavel de sessão do admin
define("SESSION_ADMIN", '_admin_[CONFIG_SESSION_ADMIN]_');

//# Chave de validação do admin
define("ADM_KEY", '[CONFIG_ADM_KEY]');
//# Define se a conexão com o admin será via banco
define("ADM_VIA_DB", '[CONFIG_ADM_VIA_DB]');

//# Define os dados de conexão com o admin caso não estiver utilizadno banco de dados
define("ADM_CONN_USUARIO", '[CONFIG_ADM_CONN_USUARIO]');
define("ADM_CONN_SENHA", '[CONFIG_ADM_CONN_SENHA]');

//# Define as informações necessaria para se comunicar com o S3
define("S3_SECRET", '[CONFIG_S3_SECRET]');
define("S3_KEY", '[CONFIG_S3_KEY]');
define("S3_BUCKET", '[CONFIG_S3_BUCKET]');
define("S3_URL", '[CONFIG_S3_URL]');

//# Define as informações de email
define("MAIL_HOST", '[CONFIG_MAIL_HOST]');
define("MAIL_SECU", '[CONFIG_MAIL_SECU]');
define("MAIL_USUARIO", '[CONFIG_MAIL_USUARIO]');
define("MAIL_SENHA", '[CONFIG_MAIL_SENHA]');
define("MAIL_PORTA", '[CONFIG_MAIL_PORTA]');
define("MAIL_REMETENTE_NOME", '[CONFIG_MAIL_REMETENTE_NOME]');
define("MAIL_REMETENTE_EMAIL", '[CONFIG_MAIL_REMETENTE_EMAIL]');
?>