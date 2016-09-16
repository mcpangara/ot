<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Miscelanio extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('America/Bogota');
	}

	public function index()
	{

	}

	public function getMunicipios()
	{
		$post = json_decode(file_get_contents("php://input"));
		$this->load->model('miscelanio_db');
		$res = $this->miscelanio_db->getMunicipios($post->departamento);
		echo json_encode($res->result());
	}

	public function getVeredas()
	{
		$post = json_decode(file_get_contents("php://input"));
		$this->load->model('miscelanio_db');
		$res = $this->miscelanio_db->getVeredas($post->municipio);
		echo json_encode($res->result());
	}

	public function getMaps($id)
	{
		$this->load->database('ot');
		$res = $this->db->get_where('municipio',array('idpoblado'=>$id));
		$m = $res->row();
		echo '<a href="https://www.google.com.co/maps/@'.$m->latitud.','.$m->longitud.',12z" target="_blank"><small>Ver en Google Maps</small></a>';
		echo '<br>';
		// echo '<iframe
		// 	src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d63111.20898165592!2d'.$m->longitud.'!3d'.$m->latitud.'!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses-419!2sco!4v1470260094840"
		// 	width="300" height="200"
		// 	frameborder="0"
		// 	style="border:0"
		// 	allowfullscreen>
		// </iframe>';
	}

	public function getTarifaGV($id)
	{
		$this->load->model('miscelanio_db','misc');
		$row = $this->misc->getTarifaGV_by($id)->row();
		echo json_encode($row);
	}

	public function cargarExcel()
	{
		$this->load->helper('excel');
		$data = readExcel('salarios_item2016.xlsx')->toArray(null,true,true,true);
		$this->load->model('tarifa_db');
		$header = array_shift($data);
		foreach ($data as $key=>$row){
			$tarifasItem = $this->tarifa_db->getTarifasByItemc($row['A']);
			foreach ($tarifasItem->result() as $fila) {
				$this->tarifa_db->updateSalario($fila->iditemf, $row['B'], $row['C']);
			}
		}
	}


	public function test()
	{
		/*
		$fstr = '19-03-2016';
		$dt = new DateTime( str_replace("/", "-",$fstr) );
		$date = $dt->format('d/m/Y');
		echo $date;*/
		echo date( 'Ymd', strtotime( '-1 day', strtotime('01-03-2016') ) );
	}

}

/* End of file Miscelanio.php */
/* Location: ./application/controllers/Miscelanio.php */
