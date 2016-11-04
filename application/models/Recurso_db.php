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
      $data['equipos_idequipo'] = $idelemento;
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
      'tipo' => 'tipo'
    );
    $this->db->insert('recurso_ot', $data);
    return $this->db->insert_id();
  }

}
