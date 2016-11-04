<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH."/third_party/PHPExcel_1.8/PHPExcel.php";

class Excel extends PHPExcel {
    public function __construct() {
        parent::__construct();
        date_default_timezone_set("America/Bogota");
    }

  function getData($ruta, $dataOnly=FALSE)
	{
    //include APPPATH."/third_party/PHPExcel_1.8/PHPExcel/Reader/Excel2003XML.php";
		include APPPATH."/third_party/PHPExcel_1.8/PHPExcel/IOFactory.php";
    $reader = PHPExcel_IOFactory::createReaderForFile($ruta);
    //$reader = PHPExcel_IOFactory::createReader('HTML');

  	$objPHPExcel = $reader->load($ruta);
		return $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	}

  function test($ruta)
  {
    echo "test";
    include APPPATH."/third_party/Excel/reader.php";
    $data = new Spreadsheet_Excel_Reader();
		$data->read($ruta);
    return $data->sheets[0];
  }

}
