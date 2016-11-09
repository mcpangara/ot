<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//reference the Dompdf namespace
require_once('dompdf/autoload.inc.php');
use Dompdf\Dompdf;
use Dompdf\Options;

function doPDF($html = '', $titulo='name'){
  $options = new Options();
  $options->setIsRemoteEnabled(true);
  // instantiate and use the dompdf class
  $dompdf = new Dompdf($options);
  $dompdf->loadHtml($html);
  $dompdf->setPaper('letter', 'portrait');
  // Render the HTML as PDF
  $dompdf->render();
  // Output the generated PDF to Browser
  $pdf = $dompdf->output();
  write_file('./uploads/ordenes/'.$titulo.'.pdf', $pdf);
  force_download('./uploads/ordenes/'.$titulo.'.pdf', NULL);
}
