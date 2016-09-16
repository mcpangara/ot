<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tarifa extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        date_default_timezone_set("America/Bogota");
	}

	public function index()
	{

	}

	#===================================================================
	#form subir documento de tarifas
	public function form_upload($value='')
	{
		$direccion_act = array(
			"<a href='".site_url('')."'>App ot</a>",
			"tarifas: ",
			"<a href='".current_url()."'>Agregar tarifas</a>"
		);
		$this->mview("tarifa/carga",NULL,$direccion_act);
	}

	# Subir documentos Via AJAX
	public function upload_doc($value='')
	{
		$config['upload_path'] = './uploads/tarifa/';
		$config['allowed_types'] = 'xlsx|xls|pdf';
		$config['file_name'] = 'tarifas';
		$this->load->library("upload",$config);

		if($this->upload->do_upload("file")){
			$info = $this->upload->data();
			$status = $this->addFileConfig( $config['upload_path'], $info['file_name']);
			if($status){
				echo "success";
			}else{
				echo "Error escritura de nueva de configuracion";
			}
		}else{
			echo "error al subir";
		}
	}

	#===========================================================================
	# Aplicar configuracion
	public function precarga()
	{
		$conf = $this->leerConfig();
		$rutas = $conf['archivos'];
		$datasheet = $this->getDatasheet( $rutas[count($rutas)-1]["file"] );
		$fields = $this->getFields($datasheet[1]);
		if($fields[0]=="codigo" && $fields[1]=="descripcion" && $fields[2]=="unidad" && $fields[3]=="tarifa" && $fields[4]=="inicio"){
			unset($datasheet[1]);
			$data = $this->matchItems($datasheet);
			if($data==FALSE){
				echo "error en la integridad de datos, puede que haya campos vacio.";
			}else{
				#print_r($data);
				echo json_encode($data);
			}
		}else{
			echo "error";
		}
	}

	#===========================================================================
	# comprobar valides
	private function matchItems($datasheet)
	{
		try {
			$data = array();
			foreach ($datasheet as $row){
				if(!isset($row["A"]) || !isset($row["B"]) || !isset($row["C"]) || !isset($row["D"]) || !isset($row["E"]) ){
					return FALSE;
				}
				array_push(
						$data,
						array(
								"codigo"=>$row["A"],
								"descripcion"=>$row["B"],
								"unidad"=>$row["C"],
								"tarifa"=>$row["D"],
								"fecha_inicio"=>date_format( date_create( str_replace("-","/",$row["E"]) ),  "d-m-Y" )
							)
					);
				}
			return $data;
		} catch (Exception $e) {
			return FALSE;
		}
	}

	#==========================================================================
	# aplicar tarifas nuevas
	public function aplicar($value='')
	{
		$post = file_get_contents('php://input');
		$pdata = json_decode($post,TRUE);
		$tarifas = $pdata["tarifas"];
		$this->load->model("item_db");
		$ids = array();
		$this->item_db->desactivar();
		foreach ($tarifas as $item) {
			$this->load->model("item_db");
			$items = $this->item_db->getBy(NULL, $item["codigo"], TRUE);
			$id = NULL;
			if($items->num_rows() == 0){
				$id = $this->item_db->add($item["codigo"], $item["descripcion"], $item["unidad"]);
			}else{
				$row =$items->row();
				$id = $row->iditem;
			}
			$idtf = $this->item_db->addTarifa($item["tarifa"], $item["fecha_inicio"], $id);
			array_push($ids, $idtf);
		}
		echo "success";
	}

	#===========================================================================
	# Test
	public function test2($value='')
	{
		$this->load->database();
		$this->db->insert("per",array("1"=>1));
		# print_r($this->db->error()); debe dehabilitarse en database.php el debug ($config["db_debug"]=FALSE)
	}

	#===========================================================================
	#privados
	#===========================================================================

	# Agregar una nueva tarifaa item
	private function add($cod, $tarifa, $fecha, $id)
	{
		$this->load->model('item_db');
		$id = $this->item_db->addTarifa($tarifa,$fecha);
		return TRUE;
	}

	# Agregar una nueva tarifaa item
	private function getFields($row)
	{
		$fields = array();
		foreach ($row as $cell) {
			array_push($fields, $cell);
		}
		return $fields;
	}

	#agregar datos de la configuracion
	private function addFileConfig($ruta="./uploads/config/", $file="config.json")
	{
		try {
			$this->load->helper("file");
			$foo = $this->leerConfig();
			$arr = array(
					"id"=>count($foo["archivos"])+1,
					"file"=>$ruta.$file,
					"fecha"=>date('d-m-Y')
				);
			array_push($foo["archivos"], $arr);
			write_file("./uploads/config/config.json", json_encode($foo), 'w+');
			return TRUE;
		}catch(Exception $e){
			return FALSE;
		}
	}
	private function makeConfig($ruta, $file)
	{
		try {
			$this->load->helper("file");
			$foo = $this->leerConfig();
			$arr = array(
					"id"=>count($foo["config_actual"])+1,
					"file"=>$ruta.$file,
					"fecha"=>date('d-m-Y')
				);
			array_push($foo["config_actual"], $arr);
			write_file("./uploads/config/config.json", json_encode($foo), 'w+');
			return TRUE;
		} catch (Exception $e) {
			return FALSE;
		}
	}
	#
	#obtiene la informacion del fichero de configuracion
	public  function leerConfig()
	{
		$file = file_get_contents("./uploads/config/config.json");
		return json_decode($file,TRUE);
	}
	#Obtiene informacion de la hoja de calculo
	private function getDatasheet($ruta)
	{
		$this->load->library('excel');
		$datos = $this->excel->getData($ruta);
		#print_r($datos);
		return $datos;
	}

	#=======================================
	#VIEW
	private function mview($vista, $data=NULL, $direccion_act, $opt="utilidades_visuales/vista_panel"){
		$view = $this->load->view($vista,$data,TRUE);
		$html = $this->load->view($opt, array("vista_pr"=>$view, "direccion_act"=>$direccion_act), TRUE);
		$this->load->view("home",array("vista"=>$html));
	}
}

/* End of file  */
/* Location: ./application/controllers/ */
