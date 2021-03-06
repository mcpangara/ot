<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
		header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
		header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
		header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE
		if (TRUE) {
			$this->load->view('inicio/indice',array("content"=>$this->load->view('inicio/pestanas','',TRUE)));
		}else{
			$this->load->view('login/login');
		}
	}

	public function loadOptions()
	{
		$this->load->view('inicio/init');
	}
}
