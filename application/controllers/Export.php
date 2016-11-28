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

  public function historyRepoByOT()
  {
    $post = json_decode( file_get_contents('php://input') );
    $this->load->model('reporte_db', 'repo');
    $rows = $this->repo->getHistoryBy($post->idOT);

  }

}
