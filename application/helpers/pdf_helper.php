<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//reference the Dompdf namespace
require_once('dompdf/autoload.inc.php');
use Dompdf\Dompdf;
use Dompdf\Options;

function doPDF($html = '', $titulo='name', $ruta = './uploads/ordenes/'){

  if (file_exists($ruta.$titulo.'.pdf')) {
    unlink($ruta.$titulo.'.pdf');
  }

  $options = new Options();
  $options->setIsRemoteEnabled(true);
  // instantiate and use the dompdf class
  $dompdf = new Dompdf($options);
  $dompdf->loadHtml($html);
  $dompdf->setPaper('letter', 'portrait');
  // Render the HTML as PDF
  $dompdf->render();
  // Output the generated PDF to Browser
  return $dompdf->stream($titulo);
  //$pdf = $dompdf->output();
  //write_file($ruta.$titulo.'.pdf', $pdf);
  //force_download($ruta.$titulo.'.pdf', NULL);
}

function dias_transcurridos($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);
	return $dias+1;
}
