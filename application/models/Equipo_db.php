<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Equipo_db extends CI_Model{

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

    public function addArray($data)
    {
      try {
        $this->load->database('ot');;
        $this->db->insert('equipo', $data);
        return $this->db->insert_id();
      } catch (Exception $e) {
        echo $e->getMessege().'   ';
      }

    }

    #===============================================================================================================
    # consultas
    #===============================================================================================================

    # Equipos por OT
    public function getAll($idOT=NULL)
    {
      $this->load->database('ot');
      return $this->db->get('equipo');
    }
    # consulta de equipos por OT
    public function getByOT($idOT)
    {
      $this->load->database('ot');
      $this->db->select(
          'rot.idrecurso_ot,
          eq.serial,
          eq.descripcion,
          rot.itemf_codigo,
          rot.itemf_iditemf,
          itf.itemc_item,
          eq.codigo_siesa,
          itf.descripcion AS item_descripcion,
          eq.referencia
          '
        );
      $this->db->from('equipo AS eq');
      $this->db->join('recurso_ot AS rot', 'eq.serial = rot.equipo_serial');
      $this->db->join('itemf AS itf', 'itf.iditemf = rot.itemf_iditemf');
      $this->db->where('rot.OT_idOT', $idOT);
      return $this->db->get();
    }
    # relacionar equipo con OT
    public function setOT($equipo)
    {
      $this->load->database('ot');
      $data = array(
        'equipo_idequipo'=>$equipo->idequipo,
        'equipo_serial'=>$equipo->serial,
        'itemf_codigo'=>$equipo->itemf_codigo,
        'itemf_iditemf'=>$equipo->itemf_iditemf,
        'nombre_ot'=>$equipo->nombre_ot,
        'OT_idOT'=>$equipo->OT_idOT,
        'tipo_recurso' => 'EQUIPO'
      );
      $this->db->insert('recurso_ot', $data);
    }
    # saber si existe ya el equipo relacionado con la OT
    public function existeRecursoOT($equipo)
    {
      $this->load->database('ot');
      $rows = $this->db->get_where('recurso_ot',
          array(
            'equipo_serial'=>$equipo->serial,
            'OT_idOT'=>$equipo->OT_idOT,
            'itemf_codigo'=>$equipo->itemf_codigo
          )
        );
      return $rows->num_rows() > 0?TRUE:FALSE;
    }
    #Consultar existencia en tabla
    public function existeEquipo($cc='')
    {
      $this->load->database('ot');
      $rows = $this->db->get_where('equipo', array('serial'=>$cc) );
      return $rows->num_rows() > 0?TRUE:FALSE;
    }

    // Obtener
    public function getResumenUN($value='')
    {
      $this->load->database('ot');
      return $this->db->select('un, desc_un')->from('equipo')->group_by('dec_un')->get();
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
