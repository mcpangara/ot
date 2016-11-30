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

  public function reportePDF($idOT, $idrepo)
  {
    $this->load->helper('pdf');
    $this->load->model('reporte_db', 'repo');

    $row = $this->repo->getBy($idOT, NULL,$idrepo)->row();
    $json_r = json_decode($row->json_r);
    $recursos = new stdClass();
    $rpers = $this->repo->getRecursos($idrepo,"personal");
    $requs = $this->repo->getRecursos($idrepo,"equipos");
    $recursos->personal = $rpers->result();
    $recursos->equipos = $requs->result();
    $html = $this->load->view('reportes/imprimir/reporte_diario', array('r'=>$row, 'json_r'=>$json_r, 'recursos'=>$recursos), TRUE);
    doPDF($html);
    //echo $html;
  }
}
