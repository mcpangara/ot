<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
require_once APPPATH."/third_party/PHPExcel_1.8/PHPExcel.php";
 
class Excel extends PHPExcel {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("America/Bogota");
    }

    function getData($ruta)
	{
		include APPPATH."/third_party/PHPExcel_1.8/PHPExcel/IOFactory.php";
		$objPHPExcel = PHPExcel_IOFactory::load($ruta);
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		return $sheetData;
	}
}