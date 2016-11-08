<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Persona_db extends CI_Model{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

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

  public function addObj($persona)
  {
    try {
      $this->load->database('ot');
      $data = array('identificacion' => $persona->identificacion, 'nombre_completo'=>$persona->nombre_completo);
      $this->db->insert('persona', $data);
      return $this->db->insert_id();
    } catch (Exception $e) {
      echo $e->getMessege().'   ';
    }
  }

  #====================================================================================
  # Persona por OT
  public function addPersonaOT($persona)
  {

  }

  #===============================================================================================================
  # consultas
  #==============================================================================================================
  # obtiene el personal de una OT
  public function getByOT($idot = NULL)
  {
    $this->load->database('ot');
    $this->db->select('rot.idrecurso_ot, p.identificacion, p.nombre_completo, rot.nombre_ot, rot.itemf_codigo, itemf.descripcion');
    $this->db->from('persona AS p');
    $this->db->join('recurso_ot AS rot', 'p.identificacion = rot.persona_identificacion');
    $this->db->join('itemf', 'itemf.iditemf = rot.itemf_iditemf');
    $this->db->where('rot.tipo_recurso', 'PERSONA');
    if(isset($idot)){
      $this->db->where('rot.OT_idOT', $idot);
    }
    return $this->db->get();
  }
  # consulta todas las personas
  public function getAll($idOT=NULL)
  {
    $this->load->database('ot');
    return $this->db->get('persona');
  }
  #Consultar existencia
  public function existePersona($cc='')
  {
    $this->load->database('ot');
    $rows = $this->db->get_where('persona', array('identificacion'=>$cc) );
    return $rows->num_rows() > 0?TRUE:FALSE;
  }

  public function getRecursoOT($idPersona, $idOT, $idItemf)
  {
    $this->load->database('ot');
    $this->db->select('rot.*, r.fecha_ingreso, r.centro_costo, r.nombre_ot, r.unidad_negocio');
    $this->db->from('recurso_ot AS rot');
    $this->db->join('recurso AS r', 'rot.recurso_idrecurso = r.idrecurso');
    $this->db->where('r.persona_identificacion', $idPersona);
    $this->db->where('rot.OT_idOT', $idOT);
    $this->db->where('rot.itemf_iditemf', $idItemf);
    return $this->db->get();
  }
  public function setPersonaOT($persona)
  {
    $this->load->database('ot');
    $data = array(
      'persona_identificacion'=>$persona->identificacion,
      'itemf_codigo'=>$persona->itemf_codigo,
      'itemf_iditemf'=>$persona->itemf_iditemf,
      'nombre_ot'=>$persona->nombre_ot,
      'OT_idOT'=>$persona->OT_idOT,
      'tipo_recurso' => 'PERSONA'
    );
    $this->db->insert('recurso_ot', $data);
  }

  # Obtener personas de OT por base
  public function getPersonasOtByBase($where)
  {
    $this->load->database('ot');
    return $this->db->select('p.*, r.*, rot.*, OT.base_idbase, OT.ccosto, itf.*')
      ->from('persona AS p')
      ->join('recurso AS r', 'p.identificacion = r.persona_identificacion')
      ->join('recurso_ot AS rot', 'r.idrecurso = rot.recurso_idrecurso')
      ->join('itemf AS itf', 'rot.itemf_iditemf = itf.iditemf')
      ->join('OT', 'rot.OT_idOT = OT.idOT')
      ->where($where)
      ->get();
  }
  #===============================================================================================================
  #===============================================================================================================
  #fields

  public function getBy($campo, $valorbuscado, $tabla)
  {
    return $this->db->get_where($tabla, array($campo=>$valorbuscado));
  }
  public function getField($where, $select, $table)
	{
		$this->load->database('ot');
		$this->db->select($select)->from($table)->where($where);
		return $this->db->get();
	}

}
