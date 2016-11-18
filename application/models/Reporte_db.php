<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function add($repo)
  {
    $this->load->database('ot');

    $datad = array(
      'fecha_reporte' => $repo->fecha_reporte,
      'estado'=> TRUE,
      'valido'=> FALSE,
      'fetivo'=>$repo->festivo,
      'OT_idOT'=>$repo->OT_idOT,
      'json'=>json_encode($repo);
    );
    $this->db->insert('reporte_diario', $data);
    return $this->db->insert_id();
  }

  # Insertar un recurso a un reporte con unas cantidades
   public function addRecursoReporte($recurso, $idrepo)
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

  // TRANSACTION

  public function init_transact()
	{
		$this->load->database('ot');
		$this->db->trans_begin();
	}

	public function end_transact()
	{
		$this->load->database('ot');
		$status = $this->db->trans_status();
		if ($status === FALSE){
		        $this->db->trans_rollback();
		}
		else{
		        $this->db->trans_commit();
		}
		return $status;
	}
}
