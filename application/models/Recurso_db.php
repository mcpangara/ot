<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recurso_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  public function add($fecha_ingreso, $fecha_registro, $nombre_ot, $centro_costo, $unidad_negocio, $idelemento, $tipo)
  {
    $data = array(
      'fecha_ingreso'=>$fecha_ingreso,
      'fecha_registro'=>$fecha_registro,
      'nombre_ot'=>$nombre_ot,
      'centro_costo'=>$centro_costo,
      'unidad_negocio'=>$unidad_negocio
    );
    if ($tipo == 'persona') {
      $data['persona_identificacion'] = $idelemento;
    }elseif ($tipo == 'equipo') {
      $data['equipo_idequipo'] = $idelemento;
    }
    $this->db->insert('recurso', $data);
    return $this->db->insert_id();
  }

  public function addRecursoOT($idrecurso, $ot, $itemf, $estado, $validado, $tipo)
  {
    $data = array(
      'recurso_idrecurso' => $idrecurso,
      'Ot_idOT' => $ot->idOT,
      'itemf_iditemf' => $itemf->iditemf,
      'itemf_codigo' => $itemf->codigo,
      'estado' => $estado,
      'validado' => $validado,
      'tipo' => $tipo
    );
    $this->db->insert('recurso_ot', $data);
    return $this->db->insert_id();
  }

  # Obtener los recursos de personal y equipos de un OT en especifico

  public function getPersonalOtBy($idOT, $tipo)
  {
    $this->load->database('ot');
    return $this->db->select('
        rot.idrecurso_ot, rot.tipo, rot.itemf_iditemf, rot.recurso_idrecurso, r.nombre_ot, r.centro_costo, r.unidad_negocio,
        p.*, itf.iditemf, itf.descripcion, itf.codigo, itf.itemc_iditemc, itf.itemc_item'
      )->from('recurso_ot AS rot')
      ->join('recurso AS r', 'rot.recurso_idrecurso = r.idrecurso')
      ->join('itemf AS itf', 'rot.itemf_iditemf = itf.iditemf')
      ->join('persona AS p', 'r.persona_identificacion = p.identificacion')
      ->where('rot.OT_idOT',$idOT)
      ->where('rot.tipo', $tipo)
      ->where('rot.estado',TRUE)
      ->get();
  }

  public function getEquiposOtBy($idOT, $tipo)
  {
    $this->load->database('ot');
    return $this->db->select('
        rot.idrecurso_ot, rot.tipo, rot.itemf_iditemf, rot.recurso_idrecurso, r.nombre_ot, r.centro_costo, r.unidad_negocio,
        e.*, itf.iditemf, itf.descripcion, itf.codigo, itf.itemc_iditemc, itf.itemc_item'
      )->from('recurso_ot AS rot')
      ->join('recurso AS r', 'rot.recurso_idrecurso = r.idrecurso')
      ->join('itemf AS itf', 'rot.itemf_iditemf = itf.iditemf')
      ->join('equipo AS e', 'r.equipo_idequipo = e.idequipo')
      ->where('rot.OT_idOT',$idOT)
      ->where('rot.tipo', $tipo)
      ->where('rot.estado',TRUE)
      ->get();
  }

}
