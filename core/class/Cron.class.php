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


class Cron {
	

	/**
	 * Construtor da classe
	 *
	 * @author  Christopher Villagra
	 * @return  resource
	 */
	public function __construct() 
	{

	}

	private static function ultimaCron($cron){

		$model = new CronModel;

		$model->pNome($cron);

		return $model->ultimaCron();

	}

	private static function iniciaCron($cron){

		$model = new CronModel;

		$model->pNome($cron);

		return $model->registraCron();

	}

	private static function finalizaCron($id_cron){

		$model = new CronModel;

		$model->pId($cron);

		return $model->finalizaCron();

	}

	public static function executaCronbyXML($customer) {


		date_default_timezone_set("America/Sao_Paulo");

		$config = simplexml_load_file('core/xml/cron.xml');

		//# Verifica todas as crons que tem configurada
		foreach ($config->config as $cron) {

			//# Busca ultima execução para controle
			$dadosLog = Cron::ultimaCron($cron->cron);

			//# Compara a ultima execução com os dados da cron

			//# verifica semana
				$semana = false;

				foreach ($cron->semana->execucao as $semanas) {

					if(($semanas->inicio <= date('w')) && ($semanas->fim >= date('w'))){

						$semana = true;
						break;

					}

				}

			//# verifica hora
				$hora = false;

				foreach ($cron->hora->execucao as $horas) {

					if(($horas->inicio <= date('H:i')) && ($horas->fim >= date('H:i'))){

						$hora = true;
						break;

					}

				}

			//# verifica periodo
				$periodo = false;

				switch ($cron->periodo->tipo) {
					case 's':
						$periodo = (date('H:i:s', strtotime("-".$cron->periodo->passo." seconds")) > $dadosLog['hora'] ? true : false);
						break;
					case 'i':
						$periodo = (date('H:i:s', strtotime("-".$cron->periodo->passo." minutes")) > $dadosLog['hora'] ? true : false);
						break;
					case 'h':
						$periodo = (date('H:i:s', strtotime("-".$cron->periodo->passo." hours")) > $dadosLog['hora'] ? true : false);
						break;
					case 'd':
						$periodo = (date('Y-m-d', strtotime("-".$cron->periodo->passo." days")) > $dadosLog['data'] ? true : false);
						break;
					case 'w':
						$periodo = (date('Y-m-d', strtotime("-".$cron->periodo->passo." week")) > $dadosLog['data'] ? true : false);
						break;
					case 'm':
						$periodo = (date('m') > $dadosLog['mes'] ? true : false);
						break;
				}

			//# Executa se estiver dentro das periodo
			if($semana && $hora && $periodo){

				$id_cron = Cron::iniciaCron($cron->cron);

				//# Executa métodos dentro da cron
				foreach ($cron->metodos->execucao as $execucao) {

					$class = strval($execucao->class);

					$controller = new $class();

					$metodo = strval($execucao->metodo);

					$controller->$metodo();

				}

				//# Registra execução da cron
				Cron::finalizaCron($id_cron);

			}

		}
		
	}

}