<?php

class Cron {
	

	/**
	 * Construtor padrão de Controllers
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