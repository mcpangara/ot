<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarea_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function setTarea($idOT, $tarea)
  {
    $this->load->database('ot');
  }

  public function setItems($idOT, $tarea)
  {
    $this->load->database('ot');
  }

  #===========================================================================
  # Agregar tarea
  public function add(
    $nombre_tarea_ot,
    $fecha_inicio,
    $fecha_fin,
    $valor_recursos,
    $valor_tarea_ot,
    $json_indirectos, $json_viaticos, $json_horas_extra,
    $json_reembolsables, $json_racion, $json_recursos,
    $OT_idOT)
  {
    $data = array(
      'nombre_tarea'=>$nombre_tarea_ot,
      'fecha_inicio'=>$fecha_inicio,
      'fecha_fin'=>$fecha_fin,
      'valor_recursos'=>$valor_recursos,
      'valor_tarea_ot'=>$valor_tarea_ot,
      'json_indirectos'=>$json_indirectos,
      'json_viaticos'=>$json_viaticos,
      'json_horas_extra'=>$json_horas_extra,
      'json_reembolsables'=>$json_reembolsables,
      'json_raciones'=>$json_racion,
      'json_recursos'=>$json_recursos,
      'OT_idOT'=>$OT_idOT
    );
    $this->db->insert('tarea_ot', $data);
    return $this->db->insert_id();
  }

  //Actualiza una tarea de una Ot
  public function update($idtarea_ot, $nombre_tarea_ot, $fecha_inicio, $fecha_fin, $valor_recursos, $valor_tarea_ot,
      $json_indirectos, $json_viaticos, $json_horas_extra, $json_reembolsables, $json_racion, $json_recursos, $OT_idOT)
  {
    $data = array(
      'nombre_tarea'=>$nombre_tarea_ot,
      'fecha_inicio'=>$fecha_inicio,
      'fecha_fin'=>$fecha_fin,
      'valor_recursos'=>$valor_recursos,
      'valor_tarea_ot'=>$valor_tarea_ot,
      'json_indirectos'=>$json_indirectos,
      'json_viaticos'=>$json_viaticos,
      'json_horas_extra'=>$json_horas_extra,
      'json_reembolsables'=>$json_reembolsables,
      'json_raciones'=>$json_racion,
      'json_recursos'=>$json_recursos,
      'OT_idOT'=>$OT_idOT
    );
    return $this->db->update('tarea_ot', $data, 'idtarea_ot = '.$idtarea_ot);
  }

  #====================================================================================================
  # Consultas
  #====================================================================================================

  # Obtener los items de una tarea por tipo
  public function getItemsByTipo($idtarea, $tipo)
  {
    $this->load->database('ot');
    $this->db->select('
        itt.iditem_tarea_ot,
        itt.cantidad,
        itt.duracion,
        itt.unidad,
        itt.fecha_agregado,
        itt.valor_plan,
        itt.itemf_iditemf,
        itt.itemf_codigo,
        itt.tarea_ot_idtarea_ot,
        itf.descripcion,
        itf.itemc_item,
        itf.iditemf,
        tar.OT_idOT AS idot,
        tarif.tarifa,
        tarif.salario
        ');
    $this->db->from('item_tarea_ot AS itt');
    $this->db->join('itemf AS itf', 'itt.itemf_iditemf = itf.iditemf');
    $this->db->join('tarifa AS tarif','tarif.itemf_iditemf = itf.iditemf');
    $this->db->join('tarea_ot AS tar', 'tar.idtarea_ot = itt.tarea_ot_idtarea_ot');
    $this->db->where('tarif.estado_tarifa', TRUE);
    $this->db->where('itf.tipo',$tipo);
    $this->db->where('itt.tarea_ot_idtarea_ot',$idtarea);
    return $this->db->get();
  }

  # Obtener todos los items de una tarea
  public function getTareasItemsResumenBy($idot, $tipo=NULL)
  {
    $this->load->database('ot');
    $this->db->select('
      itf.codigo,
      itf.descripcion,
      itf.itemc_item,
      itf.iditemf,
      tar.OT_idOT AS idot,
      tarif.tarifa,
      itt.iditem_tarea_ot'
      );
		$this->db->from('item_tarea_ot AS itt');
		$this->db->join('itemf AS itf', 'itt.itemf_iditemf = itf.iditemf');
    $this->db->join('tarifa AS tarif','tarif.itemf_iditemf = itf.iditemf');
		$this->db->join('tarea_ot AS tar', 'tar.idtarea_ot = itt.tarea_ot_idtarea_ot');
    $this->db->where('tar.OT_idOT', $idot);
    $this->db->where('tarif.estado_tarifa', TRUE);
    if (isset($tipo)) {
      $this->db->where('itf.tipo',$tipo);
    }
    $this->db->group_by('itf.codigo');
    return $this->db->get();
  }

}
