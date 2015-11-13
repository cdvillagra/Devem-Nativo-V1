<?php


require_once 'modulo/Excel/PHPExcel/PHPExcel/IOFactory.php';

class Excel
{

	private $__caminhoarquivo;
	private $__colunas;

	 /**
    * @desc      Método que cria propriedade para ID de mensagem
    *
	* @access    public 
    * @author    Christopher Dencker Villagra
    * @param     int
    * @return    int
    */
	
	public function pCaminhoArquivo($val="")
	{
		if($val == "") return $this->__caminhoarquivo;
		else $this->__caminhoarquivo = $val;
	}
	 /**
    * @desc      Método que cria propriedade para ID de mensagem
    *
	* @access    public 
    * @author    Christopher Dencker Villagra
    * @param     int
    * @return    int
    */
	
	public function pColunas($val="")
	{
		if($val == "") return $this->__colunas;
		else $this->__colunas = $val;
	}


	public function ChecaColunas(){

		$objReader = new PHPExcel_Reader_Excel5();
		$objReader->setReadDataOnly(true);

		$objPHPExcel = PHPExcel_IOFactory::load($this->pCaminhoArquivo());
		$objPHPExcel->setActiveSheetIndex(0);

		if(!is_array($this->pColunas())) $this->pColunas(array($this->pColunas()));

		$arrColunas = $this->pColunas();
		$totalColunas = PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestColumn());

		$colunas = 0;
		$colunaNome = array();

		for($coluna=0; $coluna < $totalColunas; $coluna++) $colunaNome[] = utf8_decode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getValue());

		$arrResult = array_intersect($arrColunas, $colunaNome);

		return ($arrColunas == $arrResult);
	
	}


	public function ObtemColunas(){

		$objReader = new PHPExcel_Reader_Excel5();
		$objReader->setReadDataOnly(true);

		$objPHPExcel = PHPExcel_IOFactory::load($this->pCaminhoArquivo());
		$objPHPExcel->setActiveSheetIndex(0);

		$totalColunas = PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestColumn());

		$colunas = 0;
		$colunaNome = array();

		for($coluna=0; $coluna < $totalColunas; $coluna++) $colunaNome[] = utf8_decode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getValue());


		return $colunaNome;
	
	}

	public function ObtemConteudo(){

		$objReader = new PHPExcel_Reader_Excel5();
		$objReader->setReadDataOnly(true);

		$objPHPExcel = PHPExcel_IOFactory::load($this->pCaminhoArquivo());
		$objPHPExcel->setActiveSheetIndex(0);

		if(!is_array($this->pColunas())) $this->pColunas(array($this->pColunas()));

		$arrColunas = $this->pColunas();

		$arrReturn = array();

		$totalRows = $objPHPExcel->getActiveSheet()->getHighestRow();
		$totalRows++;

		$totalColunas = PHPExcel_Cell::columnIndexFromString($objPHPExcel->getActiveSheet()->getHighestColumn());

		for($linha=2; $linha < $totalRows; $linha++){

			unset($arrTemp);
			$arrTemp = array();

			for($coluna=0; $coluna < $totalColunas; $coluna++){

				$titulo_coluna = utf8_decode($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, 1)->getValue());

				if($titulo_coluna != ''){

					if(in_array($titulo_coluna, $arrColunas)){

						$arrTemp[$titulo_coluna] = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($coluna, $linha)->getValue();

					}

				}else{

					break;

				}

			}

			$arrReturn[] = $arrTemp;

		}

		return $arrReturn;
	
	}

}
?>