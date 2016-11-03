<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function readExcel($archivo='')
{
	include '/PHPExcel/PHPExcel/IOFactory.php';
	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	#$objReader->setReadDataOnly(true);
	$objPHPExcel = $objReader->load('./uploads/'.$archivo);
	$sheetData = $objPHPExcel->getActiveSheet();
	#$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	#var_dump($sheetData);
	return $sheetData;
}

function readExcelAlltypes($archivo='', $dataOnly=FALSE)
{
	include '/PHPExcel/PHPExcel/IOFactory.php';
	$reader = PHPExcel_IOFactory::createReaderForFile('./uploads/'.$archivo);
	if($dataOnly){$reader->setReadDataOnly(true);}
	$objPHPExcel = $reader->load('./uploads/'.$archivo);
	return  $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	#$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	#var_dump($sheetData);
}
