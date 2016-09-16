<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set("America/bogota");
	}




	#======================================================================================
	#funciones crud
	#======================================================================================

	public function index()
	{
		$this->load->database();
		$this->load->library('grocery_CRUD');
		try{
			$crud = new grocery_CRUD();

			$crud->set_theme('flexigrid');
			$crud->set_table('item');
			$crud->set_subject('Items ECP');

			$output = $crud->render();
			$direccion_act = array(
					"<a href='".site_url('')."'>App. ot</a>"
				);

			$this->mview("utilidades_visuales/crud",$output, $direccion_act);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
	}
	
	#======================================================================================

	#======================================================================================
	#Cargar items desde un excel
	public function cargar_items($value='')
	{
		ini_set('memory_limit', '256M');
		ini_set('max_execution_time', 100);
		date_default_timezone_set("America/Bogota");

		$this->load->helper("excel");
		$excel = readExcel("items.xlsx");

		foreach ($excel AS $row) {
			$inser = array();
			foreach ($row as $value) {
				array_push($inser, $value);
			}
			$this->load->database();
			$this->db->insert('item',array("codigo"=>$inser[0], "descripcion"=>$inser[1], "unidad"=>$inser[2], "tarifa_actual"=>$inser[3], "fecha_agregado"=>date("Y-m-n")));
			echo "Insert 1<br>";
			$inser = NULL;
		}
	}

	#private
	private function mview($vista, $data=NULL, $direccion_act, $opt="utilidades_visuales/vista_panel"){
		$view = $this->load->view($vista,$data,TRUE);
		$html = $this->load->view($opt, array("vista_pr"=>$view, "direccion_act"=>$direccion_act), TRUE);
		$this->load->view("home",array("vista"=>$html));
	}

}

/* End of file Item.php */
/* Location: ./application/controllers/Item.php */