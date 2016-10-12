<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_db extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();

	}

	public function getAll($value='')
	{
		$this->load->database('ot');
		$this->db->select('
			itemf.iditemf,
			itemf.codigo,
			itemc.unidad AS unidad,
			itemc_item,
			itemf.iditemf,
			itemf.codigo,
			itemf.descripcion AS descripcion,
			itemf.itemc_item,
			itemf.tipo AS tipo_item,
			tarifa.salario,
			tarifa.estado_salario,
			tarifa.tarifa,
			0 AS add');
		$this->db->from('itemf');
		$this->db->join('itemc','itemf.itemc_iditemc = itemc.iditemc');
		$this->db->join('tarifa','tarifa.itemf_iditemf = itemf.iditemf');
		$this->db->where('tarifa.periodo_id = ( SELECT MAX(tarifa.periodo_id) as periodo FROM tarifa)', NULL, FALSE);
		return $this->db->get();
	}
	public function getByTipo($value='')
	{
		$this->load->database('ot');
		$this->db->select('
			itemf.iditemf,
			itemf.codigo,
			itemc.unidad AS unidad,
			itemc_item,
			itemf.iditemf,
			itemf.codigo,
			itemf.descripcion AS descripcion,
			itemf.itemc_item,
			itemf.tipo AS tipo_item,
			tarifa.salario,
			tarifa.estado_salario,
			tarifa.tarifa,
			0 AS add');
		$this->db->from('itemf');
		$this->db->join('itemc','itemf.itemc_iditemc = itemc.iditemc');
		$this->db->join('tarifa','tarifa.itemf_iditemf = itemf.iditemf');
		$this->db->where('itemf.tipo', $value);
		$this->db->where('tarifa.periodo_id = ( SELECT MAX(tarifa.periodo_id) as periodo FROM tarifa)', NULL, FALSE);
		$this->db->order_by('itemf.itemc_iditemc', 'asc');
		return $this->db->get();
	}
	# Guarda la un item planeado de una tarea de OT
	public function setItemTarea(
		$cantidad,	
		$duracion, 
		$unidad, 
		$tarifa, 
		$valor_plan, 
		$fecha_creacion, 
		$itemf_iditemf, 
		$itemf_codigo, 
		$idTr,
		$debug
		){
		$data = array(
			'cantidad'=>$cantidad,
			'duracion'=>$duracion,
			'unidad'=>$unidad,
			'tarifa'=>$tarifa,
			'valor_plan'=>$valor_plan,
			'fecha_agregado'=>$fecha_creacion,
			'itemf_iditemf'=>$itemf_iditemf,
			'itemf_codigo'=>$itemf_codigo,
			'tarea_ot_idtarea_ot'=>$idTr,
			"debug"=>$debug
		);
		$this->db->insert('item_tarea_ot', $data);
	}
	#Actuliza un items de una tarea perteneciente a una Orden de Trabajo
	public function updateItemTarea(
		$iditem_tarea_ot, 
		$cantidad, 
		$duracion, 
		$unidad, 
		$tarifa, 
		$valor_plan, 
		$fecha_creacion, 
		$itemf_iditemf, 
		$itemf_codigo, 
		$idTr
		){
		$data = array(
			'cantidad'=>$cantidad,
			'duracion'=>$duracion,
			'unidad'=>$unidad,
			'tarifa'=>$tarifa,
			'valor_plan'=>$valor_plan,
			'fecha_agregado'=>$fecha_creacion,
			'itemf_iditemf'=>$itemf_iditemf,
			'itemf_codigo'=>$itemf_codigo,
			'tarea_ot_idtarea_ot'=>$idTr
		);
		$this->db->update('item_tarea_ot', $data, 'iditem_tarea_ot = '.$iditem_tarea_ot);
	}

	# ================================================================================================
	# Consultas
	# ================================================================================================

	# Obtener items de una tarea especifica por tipo
	public function getItemsByTarea($idTarea, $idTipo_item)
	{
		$this->load->database('ot');
		$this->db->from('item_tarea_ot AS itt');
		$this->db->join('itemf AS itf', 'itt.itemf_iditemf = itf.iditemf');
		$this->db->join('itemc AS itc', 'itf.itemc_iditemc = itc.iditemc');
		$this->db->where('itt.tarea_ot_idtarea_ot', $idTarea);
		$this->db->where('itf.tipo', $idTipo_item);
		return $this->db->get();
	}

	public function getField($where, $select, $table)
	{
		$this->load->database('ot');
		$this->db->select($select)->from($table)->where($where);
		return $this->db->get();
	}


}

/* End of file Item_db.php */
/* Location: ./application/models/Item_db.php */
