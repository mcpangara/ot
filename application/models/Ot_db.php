<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ot_db extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();

	}

	public function getBases($value='')
	{
		$this->load->database('ot');
		return $this->db->get('base');
	}

	public function addOT($ot){
		$this->load->database('ot');
		$data = array(
			'nombre_ot' => $ot->nombre_ot->data,
			'base_idbase'=> $ot->idbase,
			'tipo_ot_idtipo_ot'=>$ot->tipo_ot->data,
			'especialidad_idespecialidad'=>$ot->especialidad->data,
			'municipio_idpoblado'=>$ot->idpoblado,
			'json' => json_encode($ot)
		);
		return $this->db->insert('OT', $data);
	}

  public function add( $nombre_ot, $base, $zona, $fecha_creacion, $especialidad, $tipo_ot, $actividad, $justificacion, $locacion, $abscisa, $idpoblado) {
    $this->load->database('ot');
    $data = array(
      "nombre_ot"=>$nombre_ot,
      'base_idbase'=>$base,
      "zona"=>$zona,
      "fecha_creacion"=>$fecha_creacion,
      "especialidad_idespecialidad"=>$especialidad,
      "tipo_ot_idtipo_ot"=>$tipo_ot,
      "actividad"=>$actividad,
      "justificacion"=>$justificacion,
      "locacion"=>$locacion,
      "abscisa"=>$abscisa,
      "municipio_idpoblado"=>$idpoblado
    );
    $this->db->insert('ot', $data);
		return $this->db->insert_id();
  }

	public function getData($idot){
		$this->load->database('ot');
		$this->db->from('OT');
		$this->db->join('especialidad AS esp', 'OT.especialidad_idespecialidad = esp.idespecialidad');
		$this->db->join('base AS b', 'OT.base_idbase = b.idbase');
		$this->db->join('municipio AS mun', 'mun.idpoblado = OT.municipio_idpoblado');
		$this->db->join('tipo_ot AS tp', 'tp.idtipo_ot = OT.tipo_ot_idtipo_ot');
		$this->db->where('OT.idOT', $idot);
		return $this->db->get();
	}

	public function getAllOTs($base = NULL){
		$this->load->database('ot');
		$this->db->from('OT');
		$this->db->join('especialidad AS esp', 'OT.especialidad_idespecialidad = esp.idespecialidad');
		$this->db->join('base AS b', 'OT.base_idbase = b.idbase');
		$this->db->join('municipio AS mun', 'mun.idpoblado = OT.municipio_idpoblado');
		$this->db->join('tipo_ot AS tp', 'tp.idtipo_ot = OT.tipo_ot_idtipo_ot');
		if (isset($base)) {
			$this->db->where('base.idebase', $base);
		}
		return $this->db->get();
	}

	public function getTarea($idOt, $idTarea)
	{
		$this->load->database('ot');
		$this->db->from('tarea_ot');
		$this->db->where('OT_idOT', $idOT);
		$this->db->where_in('idtarea_ot', $idTarea);
	}
	public function getTarea1($idOT)
	{
		$this->load->database('ot');
		$this->db->select('MIN(idtarea_ot) AS idtarea_ot');
		$this->db->from('tarea_ot');
		$this->db->where('OT_idOT', $idOT);
		return $this->db->get();
	}


	# ===========================================================================
	# Consulta de items de OT
	# ===========================================================================

	# Obetner items por tipo de un OT
	public function getItemByTipeOT($idOT, $tipo)	{
		$this->load->database('ot');
		$this->db->select(
				'
				itf.iditemf,
				itf.itemc_iditemc,
				itf.itemc_item,
				itf.codigo,
				itf.descripcion,
				OT.nombre_ot,
				tot.nombre_tarea,
				itc.unidad,
				SUM(itt.cantidad) AS planeado
				'
			);
		$this->db->from('item_tarea_ot AS itt');
		$this->db->join('itemf AS itf', 'itt.itemf_iditemf = itf.iditemf');
		$this->db->join('itemc AS itc', 'itf.itemc_iditemc = itc.iditemc');
		$this->db->join('tarea_ot AS tot', 'itt.tarea_ot_idtarea_ot = tot.idtarea_ot');
		$this->db->join('OT', 'OT.idOT = tot.OT_idOT');
		$this->db->where('OT.idOT', $idOT);
		$this->db->where('itf.tipo', $tipo);
		$this->db->group_by('itf.iditemf');
		return $this->db->get();
	}
	# Obtener listado de items por OT
	public function getItemsBy($idOT)
	{
		$this->load->database('ot');
		$this->db->select('*');
		$this->db->from('item_tarea_ot AS itt');
	}
}
/* End of file Ot_db.php */
/* Location: ./application/models/Ot_db.php */
