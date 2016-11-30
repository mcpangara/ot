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
      'json_r'=>json_encode($repo)
    );
    $this->db->insert('reporte_diario', $data);
    return $this->db->insert_id();
  }

  # Actualizar|
  public function update($repo)
  {
    $data = array(
      'fecha_reporte' => $repo->fecha,
      'estado'=> TRUE,
      'valido'=> FALSE,
      'festivo'=>$repo->info->festivo,
      'OT_idOT'=>$repo->info->idOT,
      'json_r'=>json_encode($repo->info)
    );
    $this->db->update('reporte_diario', $data, 'idreporte_diario = '.$repo->idreporte_diario);
  }

  # Insertar un recurso a un reporte con unas cantidades
   public function addRecursoRepo($recurso, $idrepo)
   {
     $data = array(
       'idreporte_diario' => $idrepo,
       'cantidad'=> isset($recurso->cantidad)? $recurso->cantidad: '0',
       'planeado'=> isset($recurso->planeado)?$recurso->planeado:'',
       'facturable'=> isset($recurso->facturable)?$recurso->facturable:TRUE,
       'hora_inicio'=> isset($recurso->hora_inicio)? $recurso->hora_inicio: '',
       'hora_fin'=> isset($recurso->hora_fin)? $recurso->hora_fin: '',
       'horas_extra_dia'=> isset($recurso->horas_extra_dia)? $recurso->horas_extra_dia: '',
       'horas_extra_noc'=> isset($recurso->horas_extra_noc)? $recurso->horas_extra_noc: '',
       'horas_recargo'=> isset($recurso->horas_recargo)? $recurso->horas_recargo: '',
       'racion'=> isset($recurso->racion)? $recurso->racion: '',
       'hr_almuerzo'=> isset($recurso->hr_almuerzo)? $recurso->hr_almuerzo: '',
       'nombre_operador'=> isset($recurso->nombre_operador)? $recurso->nombre_operador: '',
       'horas_operacion'=> isset($recurso->horas_operacion)? $recurso->horas_operacion: '',
       'horas_disponible'=> isset($recurso->horas_disponible)? $recurso->horas_disponible: '',
       'varado'=> isset($recurso->varado)? $recurso->varado: '',
       'horometro_ini'=> isset($recurso->horometro_ini)? $recurso->horometro_ini: '',
       'horometro_fin'=> isset($recurso->horometro_fin)? $recurso->horometro_fin: '',
       'idrecurso_ot'=>  isset($recurso->idrecurso_ot)?$recurso->idrecurso_ot:NULL,
       'itemf_iditemf'=> isset($recurso->itemf_iditemf)?$recurso->itemf_iditemf:NULL,
       'itemf_codigo'=> isset($recurso->itemf_codigo)?$recurso->itemf_codigo:NULL,
       'gasto_viaje'=> isset($recurso->gasto_viaje)?$recurso->gasto_viaje:NULL
     );
     $this->db->insert('recurso_reporte_diario', $data);
   }
  #Actualiar un recurso reporte
  public function editRecursoRepo($recurso, $idrepo)
  {
    $data = array(
      'idreporte_diario' => $idrepo,
      'cantidad'=> isset($recurso->cantidad)?$recurso->cantidad: '0',
      'planeado'=> isset($recurso->planeado)?$recurso->planeado:'',
      'facturable'=> isset($recurso->facturable)?$recurso->facturable:TRUE,
      'hora_inicio'=> isset($recurso->hora_inicio)? $recurso->hora_inicio: '',
      'hora_fin'=> isset($recurso->hora_fin)? $recurso->hora_fin: '',
      'horas_extra_dia'=> isset($recurso->horas_extra_dia)? $recurso->horas_extra_dia: '',
      'horas_extra_noc'=> isset($recurso->horas_extra_noc)? $recurso->horas_extra_noc: '',
      'horas_recargo'=> isset($recurso->horas_recargo)? $recurso->horas_recargo: '',
      'racion'=> isset($recurso->racion)? $recurso->racion: '',
      'hr_almuerzo'=> isset($recurso->hr_almuerzo)? $recurso->hr_almuerzo: '',
      'nombre_operador'=> isset($recurso->nombre_operador)? $recurso->nombre_operador: '',
      'horas_operacion'=> isset($recurso->horas_operacion)? $recurso->horas_operacion: '',
      'horas_disponible'=> isset($recurso->horas_disponible)? $recurso->horas_disponible: '',
      'varado'=> isset($recurso->varado)? $recurso->varado: '',
      'horometro_ini'=> isset($recurso->horometro_ini)? $recurso->horometro_ini: '',
      'horometro_fin'=> isset($recurso->horometro_fin)? $recurso->horometro_fin: '',
      'idrecurso_ot'=>  isset($recurso->idrecurso_ot)?$recurso->idrecurso_ot:NULL,
      'itemf_iditemf'=> isset($recurso->itemf_iditemf)?$recurso->itemf_iditemf:NULL,
      'itemf_codigo'=> isset($recurso->itemf_codigo)?$recurso->itemf_codigo:NULL,
      'gasto_viaje'=> isset($recurso->gasto_viaje)?$recurso->gasto_viaje:NULL
    );
    $this->db->update('recurso_reporte_diario', $data, 'idrecurso_reporte_diario = '.$recurso->idrecurso_reporte_diario);
  }
  public function recursoRepoFecha($idRecOt, $fecha)
  {
    $this->load->database('ot');
    return $this->db->from('recurso_reporte_diario AS rrd')
        ->join('reporte_diario AS rd', 'rd.idreporte_diario = rrd.idreporte_diario')->where('rrd.idrecurso_ot',$idRecOt)->where('rd.fecha_reporte',$fecha)->get();
  }
  public function recursoRepoFechaID($id, $fecha)
  {
    $this->load->database('ot');
    return $this->db->from('recurso_reporte_diario AS rrd')->join('reporte_diario AS rd', 'rd.idreporte_diario = rrd.idreporte_diario')
        ->where('rrd.idrecurso_reporte_diario',$id)->where('rd.fecha_reporte',$fecha)->get();
  }

  # =============================================================================================
  # CONSULTAS
  # =============================================================================================

  # Consultar Reporte por fecha y OT
  public function getBy($idOT, $fecha, $idrepo)
  {
    $this->load->database('ot');
    $this->db->from('reporte_diario AS rd');
    $this->db->join('OT', 'OT.idOT = rd.OT_idOT');
    $this->db->join('base','base.idbase = OT.base_idbase');
    $this->db->join('especialidad AS esp','esp.idespecialidad = OT.especialidad_idespecialidad');
    $this->db->where('OT.idOT', $idOT);
    if(isset($fecha)){
      $this->db->where('rd.fecha_reporte',$fecha);
    }elseif(isset($idrepo)) {
      $this->db->where('rd.idreporte_diario',$idrepo);
    }
    return $this->db->get();
  }
  # Consultar Reporte por id
  public function get($idrepo)
  {
    $this->load->database('ot');
    //return $this->db->get_where('reporte_diario', array('idreporte_diario'=>$idrepo));
    return $this->db->select('*')->from('reporte_diario AS rd')->join('OT','OT.idOT = rd.OT_idOT')->where('rd.idreporte_diario',$idrepo)->get();
  }

  public function getRecursos($idrepo, $tipo){
    $this->load->database('ot');
    $this->db->select('rrd.*, itf.itemc_item, itf.codigo, itf.descripcion, itf.unidad');
    //$this->db->join('item_tarea_ot AS itr', 'itr.iditem_tarea_ot = rrd.iditem_tarea_ot', 'LEFT');
    $this->db->from('recurso_reporte_diario AS rrd');
    $this->db->join('itemf AS itf', 'rrd.itemf_iditemf = itf.iditemf', 'LEFT');
    $this->db->join('itemc AS itc', 'itf.itemc_iditemc = itc.iditemc', 'LEFT');
    $this->db->join('recurso_ot AS rot', 'rot.idrecurso_ot = rrd.idrecurso_ot', 'LEFT');
    $this->db->join('recurso AS r', 'r.idrecurso = rot.recurso_idrecurso', 'LEFT');
    if ($tipo == 'personal') {
      $this->db->select('p.*, r.idrecurso, r.centro_costo, r.unidad_negocio, r.fecha_ingreso, rot.*, titc.BO, titc.CL');
      $this->db->join('tipo_itemc AS titc', 'itc.idtipo_itemc = titc.idtipo_itemc');
      $this->db->join('persona AS p', 'p.identificacion = r.persona_identificacion','LEFT');
      $this->db->where('rot.tipo', 'persona');
    }
    elseif ($tipo == "equipos") {
      $this->db->select('e.codigo_siesa, e.referencia, e.descripcion AS descripcion_equipo, e.ccosto, e.ccosto, desc_un, r.idrecurso, r.centro_costo, r.unidad_negocio, r.fecha_ingreso, rot.*, titc.BO, titc.CL');
      $this->db->join('tipo_itemc AS titc', 'itc.idtipo_itemc = titc.idtipo_itemc');
      $this->db->join('equipo AS e', 'e.idequipo = r.equipo_idequipo','LEFT');
      $this->db->where('rot.tipo', 'equipo');
    }elseif ($tipo == 'actividades') {
      $this->db->where('rrd.idrecurso_ot', NULL);
    }
    $this->db->where('rrd.idreporte_diario', $idrepo);
    return $this->db->get();
  }

  public function listaBy($idOT)
  {
    $this->load->database('ot');
    return $this->db->select('*')->from('reporte_diario AS rd')->join('OT', 'OT.idOT = rd.OT_idOT')->where('rd.OT_idOT', $idOT)->order_by('fecha_reporte','ASC')->get();
  }
  # =====================================================================================
  # Obtener historial de la OT
  public function getHistoryBy($idOT=NULL)
  {
    $this->load->database('ot');
    $this->db->select(
      '
      OT.nombre_ot AS No_OT,
      rd.fecha_reporte,
      rd.festivo,
      itf.codigo,
      rot.tipo,
      itf.itemc_item AS item,
      itf.descripcion,
      rrd.facturable,
      rrd.cantidad,
      rrd.hora_inicio,
      rrd.hora_fin,
      rrd.horas_extra_dia,
      rrd.horas_extra_noc,
      rrd.horas_recargo,
      rrd.hr_almuerzo,
      rrd.racion,
      rrd.nombre_operador,
      rrd.horas_operacion,
      rrd.horas_disponible,
      rrd.horometro_ini,
      rrd.horometro_fin,
      rrd.varado,
      p.identificacion,
      p.nombre_completo,
      e.codigo_siesa,
      e.referencia,
      e.descripcion AS equipo
      '
    );
      $this->db->from('reporte_diario AS rd');
      $this->db->join('recurso_reporte_diario AS rrd', 'rrd.idreporte_diario = rd.idreporte_diario');
      $this->db->join('recurso_ot AS rot', 'rot.idrecurso_ot = rrd.idrecurso_ot','LEFT');
      $this->db->join('recurso AS r','r.idrecurso = rot.recurso_idrecurso','LEFT');
      $this->db->join('persona AS p', 'p.identificacion = r.persona_identificacion','LEFT');
      $this->db->join('equipo AS e', 'e.idequipo = r.equipo_idequipo','LEFT');
      $this->db->join('OT', 'OT.idOT = rd.OT_idOT');
      $this->db->join('itemf AS itf', 'itf.iditemf = rrd.itemf_iditemf');
      if (isset($idOT)) {
        $this->db->where('rd.OT_idOT', $idOT);
      }
      $this->db->order_by('rd.fecha_reporte','ASC');
      $this->db->order_by('rd.idreporte_diario','ASC');
      $this->db->get();
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
