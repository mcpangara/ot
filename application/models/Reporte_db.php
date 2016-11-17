<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function add($value='')
  {
    # code...
  }

  public function getBy($value='')
  {
    # code...
  }

  public function recursoRepoFecha($idRecOt, $fecha)
  {
    $this->load->database('ot');
    return $this->db->from('recurso_reporte_diario AS rrd')
        ->join('reporte_diario AS rd', 'rd.idreporte_diario = rrd.idreporte_diario')
        ->where('rrd.idrecurso_ot',$idRecOt)
        ->where('rd.fecha_reporte',$fecha)
        ->get();
  }
}
