<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
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

  

}
