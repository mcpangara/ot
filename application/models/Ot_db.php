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
	// Registrar una nueva OT.
	public function add( $nombre_ot, $ccosto, $base, $zona, $fecha_creacion, $especialidad, $tipo_ot, $actividad, $justificacion, $locacion, $abscisa, $idpoblado, $cc_ecp, $json, $sap) {
		$this->load->database('ot');
		$data = array(
			"nombre_ot"=>$nombre_ot,
			'ccosto'=>$ccosto,
			'base_idbase'=>$base,
			"zona"=>$zona,
			"fecha_creacion"=>$fecha_creacion,
			"especialidad_idespecialidad"=>$especialidad,
			"tipo_ot_idtipo_ot"=>$tipo_ot,
			"actividad"=>$actividad,
			"justificacion"=>$justificacion,
			"locacion"=>$locacion,
			"abscisa"=>$abscisa,
			"municipio_idpoblado"=>$idpoblado,
			"cc_ecp"=>$cc_ecp,
			'json'=>$json,
			'numero_sap'=>$sap
		);
		$this->db->insert('OT', $data);
		return $this->db->insert_id();
	}
	//Editar daos info de una OT.
	public function update( $idot, $nombre_ot, $ccosto, $base, $zona, $fecha_creacion, $especialidad, $tipo_ot, $actividad, $justificacion, $locacion, $abscisa, $idpoblado, $json, $sap) {
		$this->load->database('ot');
		$data = array(
			"nombre_ot"=>$nombre_ot,
			'ccosto'=>$ccosto,
			'base_idbase'=>$base,
			"zona"=>$zona,
			"fecha_creacion"=>$fecha_creacion,
			"especialidad_idespecialidad"=>$especialidad,
			"tipo_ot_idtipo_ot"=>$tipo_ot,
			"actividad"=>$actividad,
			"justificacion"=>$justificacion,
			"locacion"=>$locacion,
			"abscisa"=>$abscisa,
			"municipio_idpoblado"=>$idpoblado,
			'json'=>$json,
			'numero_sap'=>$sap
		);
		return $this->db->update('OT', $data, "idOT =".$idot);
	}
  	// obetener información de una OT
	public function getData($idot){
		$this->load->database('ot');
		$this->db->from('OT');
		$this->db->join('especialidad AS esp', 'OT.especialidad_idespecialidad = esp.idespecialidad');
		$this->db->join('base AS b', 'OT.base_idbase = b.idbase');
		$this->db->join('municipio AS mun', 'OT.municipio_idpoblado = mun.idpoblado');
		$this->db->join('tipo_ot AS tp', 'OT.tipo_ot_idtipo_ot = tp.idtipo_ot');
		$this->db->where('OT.idOT', $idot);
		return $this->db->get();

	}
	//Obtener un listado de todas las OT
	public function getAllOTs($base = NULL){
		$this->load->database('ot');
		$this->db->from('OT');
		$this->db->join('especialidad AS esp', 'OT.especialidad_idespecialidad = esp.idespecialidad');
		$this->db->join('base AS b', 'OT.base_idbase = b.idbase');
		$this->db->join('municipio AS mun', 'mun.idpoblado = OT.municipio_idpoblado');
		$this->db->join('tipo_ot AS tp', 'tp.idtipo_ot = OT.tipo_ot_idtipo_ot');
		if (isset($base)) {
			$this->db->where('b.idbase', $base);
		}
		return $this->db->get();
	}

	#Obtiene una tarea de una OT
	public function getTarea($idOt, $idTarea)
	{
		$this->load->database('ot');
		$this->db->from('tarea_ot');
		$this->db->where('OT_idOT', $idOt);
		$this->db->where('idtarea_ot', $idTarea);
		return $this->db->get();
	}

	public function getTarea1($idOT)
	{
		$this->load->database('ot');
		$this->db->select('MIN(idtarea_ot) AS idtarea_ot');
		$this->db->from('tarea_ot');
		$this->db->where('OT_idOT', $idOT);
		return $this->db->get();
	}
	# Obtiene un listado de taras
	public function getTareas($id)
	{
		$this->load->database('ot');
		$this->db->select('*');
		$this->db->from('tarea_ot');
		$this->db->where('OT_idOT', $id);
		return $this->db->get();
	}

	#=============================================================================

	# Obetener una Ot por un campo especificado por parametro
	public function getOtBy($campo, $valorbuscado)
	{
		$this->load->database('ot');
		return $this->db->get_where('OT',array($campo=>$valorbuscado));
	}

	# ===========================================================================
	# Consulta de items de OT
	# ===========================================================================

	# Obetner items por tipo de un OT
	public function getItemByTipeOT($idOT, $tipo)	{
		$this->load->database('ot');
		$this->db->select(
				'
				itt.iditem_tarea_ot,
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

	//

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
/* End of file Ot_db.php */
/* Location: ./application/models/Ot_db.php */
