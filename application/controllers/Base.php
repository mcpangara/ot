<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

	}

	public function getAll($value='') #Retorna un JSON con los datos de la tabla base
	{
		$this->load->database();
		$bases = $this->db->get("base");
		echo json_encode($bases->result());
	}

}

/* End of file Base.php */
/* Location: ./application/controllers/Base.php */
