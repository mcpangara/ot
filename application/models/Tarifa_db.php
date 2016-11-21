<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarifa_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function getTarifasByItemc($itemc)
  {
    $this->load->database('ot');
    $this->db->from('itemf');
    $this->db->join('tarifa', 'itemf.codigo = tarifa.itemf_codigo');
    $this->db->where('itemf.itemc_item', $itemc);
    $this->db->where('tarifa.estado',TRUE);
    return $this->db->get();
  }

  public function updateSalario($id, $salario, $estado_salario)
  {
    $this->load->database('ot');
    $data = array('salario' =>$salario, 'estado_salario'=>$estado_salario );
    $this->db->update('tarifa', $data, 'itemf_iditemf = '.$id);
  }

}
