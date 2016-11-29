<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    date_default_timezone_set('America/Bogota');
  }

  function index()
  {

  }

  public function historyRepoByOT($idOT, $nombre_ot)
  {
    $this->load->model('reporte_db', 'repo');
    $rows = $this->repo->getHistoryBy($idOT);
    $this->load->view('miscelanios/history/infoReportes', array('rows'=>$rows, 'nombre_ot'=>$nombre_ot) );
  }

  public function reportePDF($idOT, $fecha)
  {
    $this->load->helper('pdf');
    $this->load->model('reporte_db', 'repo');
    $row = $this->repo->getBy($idOT, $fecha)->row();
    $json_r = json_decode($row->json_r) ;
    $this->load->view('reportes/imprimir/info', array('r'=>$row, 'json_r'=>$json_r));
  }
}
