<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sesion extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper("config");
	}

	public function index(){
		$this->ini();
	}

	public function ini(){
		try {
			$this->load->library("encrypt");
			$id = $this->input->post("d1");
			$user = $this->input->post("d4");
			$per = $this->input->post("d5");
			$data = $this->input->post("d3");
			if(!isset($id) && !isset($data)){
				echo "fallo de entrega de datos";
				return;
			}
			#$nid = $this->encrypt->decode($id);
			$sess= json_decode($data);
			$this->load->library("session");
			$this->session->set_userdata(array(
					"apps"=>$sess[2]->apps,
					"gestiones"=>$sess[1]->gestiones,
					"privilegios"=>$sess[0]->privilegios,
					"idpersona" =>$per,
					"idusuario" =>$user,
					"usuario" =>$id,
					"isess"=>TRUE)
				);
			echo $this->buscar_app($sess[2]->apps);
		} catch (Exception $e) {
			echo $e->getMessege();
		}
	}
	public function ini2(){
		$this->load->library("session");
		$this->session->set_userdata(array("usuario"=>"testing yeison"));
		print_r($this->session->all_userdata());
	}
	public function data(){
		$this->load->library("session");
		print_r($this->session->all_userdata());
	}

	public function buscar_app($data){
		foreach ($data as $key => $value) {
			if($value === "app.termo_gd")
				return true;
		}
		return "no encontrada";
	}


	#=====================================
	public function finalizar($redir=NULL){
		$this->session->sess_destroy();
		echo TRUE;
	}

}

/* End of file Sesion.ph´p */
/* Location: ./application/controllers/Sesion.ph´p */
