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

    $data = array(
      'fecha_reporte' => $repo->fecha_reporte,
      'estado'=> TRUE,
      'valido'=> FALSE,
      'festivo'=>$repo->festivo,
      'OT_idOT'=>$repo->idOT,
      'json'=>json_encode($repo)
    );
    $this->db->insert('reporte_diario', $data);
    return $this->db->insert_id();
  }

  # Insertar un recurso a un reporte con unas cantidades
   public function addRecursoRepo($recurso, $idrepo)
   {
     $data = array(
       'idreporte_diario' => $idrepo,
       'cantidad'=> isset($recurso->cantidad)? $recurso->cantidad: '0',
       'facturable'=> isset($recurso->facturable)?$recurso->facturable:TRUE,
       'hora_inicio'=> isset($recurso->hora_inicio)? $recurso->hora_inicio: '',
       'hora_fin'=> isset($recurso->hora_fin)? $recurso->hora_fin: '',
       'horas_extra_dia'=> isset($recurso->horas_hed)? $recurso->horas_hed: '',
       'horas_extra_noc'=> isset($recurso->horas_hen)? $recurso->horas_hen: '',
       'horas_recargo'=> isset($recurso->horas_rn)? $recurso->horas_rn: '',
       'racion'=> isset($recurso->racion)? $recurso->racion: '',
       'hr_almuerzo'=> isset($recurso->hr_almuerzo)? $recurso->hr_almuerzo: '',
       'nombre_operador'=> isset($recurso->nombre_operador)? $recurso->nombre_operador: '',
       'horas_operacion'=> isset($recurso->horas_oper)? $recurso->horas_oper: '',
       'horas_disponible'=> isset($recurso->horas_disp)? $recurso->horas_disp: '',
       'varado'=> isset($recurso->varado)? $recurso->varado: '',
       'horometro_ini'=> isset($recurso->horo_inicio)? $recurso->horo_inicio: '',
       'horometro_fin'=> isset($recurso->horo_fin)? $recurso->horo_fin: '',
       'idrecurso_ot'=>  isset($recurso->idrecurso_ot)?$recurso->idrecurso_ot:NULL,
     );
     $this->db->insert('recurso_reporte_diario', $data);
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

  # =============================================================================================
  # CONSULTAS
  # =============================================================================================

  # Consultar Reporte por fecha y OT
  public function getBy($idOT, $fecha)
  {
    $this->load->database('ot');
    return $this->db->from('reporte_diario AS rd')
            ->join('ot', 'ot.idOT = rd.OT_idOT')
            ->get();
  }
  # Consultar Reporte por id
  public function get($idRepo)
  {
    $this->load->database('ot');
    return $this->db->from('reporte_diario AS rd')
            ->join('ot', 'ot.idOT = rd.OT_idOT')
            ->where('rd.idreporte',$idRepo)
            ->get();
  }

  public function getRecursosReporte($idrepo, $tipo)
  {

  }

  public function listaBy($idOT)
  {
    $this->load->database('ot');
    return $this->db->select('*')->from('reporte_diario AS rd')->join('ot', 'ot.idOT = rd.OT_idOT')->where('rd.OT_idOT', $idOT)->order_by('fecha_reporte','ASC')->get();
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
