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

class Email
{

	public function send($obj_dados){
	
		$obj_config = $this->GetParametros();	
				
		$mail = new PHPMailer();
	
		$mail->isSMTP();
	
		$mail->SMTPDebug = 0;
	
		$mail->CharSet = 'UTF-8';
	
		$mail->Debugoutput = 'html';
	
		$mail->Host = $obj_config['email_host'];
	
		$mail->Port = $obj_config['email_porta'];
	
		$mail->SMTPAuth = true;
	
		$mail->SMTPSecure = $obj_config['email_secure'];
	
		$mail->Username = $obj_config['email_usuario'];
	
		$mail->Password = $obj_config['email_senha'];
	
		$mail->setFrom($obj_config['email_rementente_email'], $obj_config['nome_rementente_email']);
	
		$mail->addReplyTo($obj_config['email_rementente_email'], $obj_config['nome_rementente_email']);
	
		$mail->addAddress($obj_dados['email_destino'], $obj_dados['nome_destino']);
	
		$mail->Subject = $obj_dados['assunto'];
	
		$mail->msgHTML($obj_dados['html']);
		
		if(isset($obj_dados['alt_body']))
			$mail->AltBody = $obj_dados['alt_body'];
	
		if (!$mail->send()) {
			return false;
		} else {
			return true;
		}
	
	}
	
	private function GetParametros($prefixo = ''){
		
		$arrayReturn = array("email_host" => Configuracoes::Valor('mail_host'),
				"email_porta" => Configuracoes::Valor('mail_porta'),
				"email_senha" => Configuracoes::Valor($prefixo . 'mail_senha'),
				"email_usuario" => Configuracoes::Valor($prefixo . 'mail_usuario'),
				"email_secure" => Configuracoes::Valor($prefixo . 'mail_secure'),
				"email_rementente_nome" => Configuracoes::Valor($prefixo . 'mail_rementente_nome'),
				"email_rementente_email" => Configuracoes::Valor($prefixo . 'mail_rementente_email')
		);
		
		return $arrayReturn;
	}
}
?>