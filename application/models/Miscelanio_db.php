<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Miscelanio_db extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();

	}

	public function getDepartamentos($value='')
	{
		$this->load->database('ot');
		$this->db->select('departamento');
		$this->db->from('municipio');
		$this->db->group_by('departamento');
		return $this->db->get();
	}

	public function getMunicipios($depart='')
	{
		$this->load->database('ot');
		$this->db->select('municipio');
		$this->db->from('municipio');
		$this->db->where('departamento',$depart);
		$this->db->group_by('municipio');
		return $this->db->get();
	}

	public function getVeredas($muni='')
	{
		$this->load->database('ot');
		$this->db->select('*');
		$this->db->from('municipio');
		$this->db->where('municipio',$muni);
		return $this->db->get();
	}

	public function getEspecialidadesOT()
	{
		$this->load->database('ot');
		return $this->db->get('especialidad');
	}
	public function getTiposOT()
	{
		$this->load->database('ot');
		return $this->db->get('tipo_ot');
	}

	public function getTarifasGV()
	{
		$this->load->database('ot');
		return $this->db->get_where('tarifas_gv', array('estado'=>TRUE));
	}

	public function getTarifaGV_by($id)
	{
		$this->load->database('ot');
		return $this->db->select('*')
				->from('tarifas_gv')
				->where('idtarifa_gv',$id)
				->where('estado',TRUE)
				->get();
	}
}

/* End of file Miscelanio_db.php */
/* Location: ./application/models/Miscelanio_db.php */
