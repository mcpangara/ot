<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    date_default_timezone_set('America/Bogota');
  }

  function index(){ }
  #===========================================================================================================
  #
  public function add($idOT, $fecha){
    $this->load->model('Ot_db', 'otdb');
    $ot = $this->otdb->getData($idOT);
    $this->load->model('tarea_db', 'tarea');
    $allitems = $this->tarea->getTareasItemsResumenBy($idOT);
    $this->load->view('reportes/add/add', array('ot'=>$ot->row(), 'fecha'=>$fecha, 'itemList'=>$allitems->result()));
  }

  public function insert(){
    $post = json_decode( file_get_contents("php://input") );
    
  }

  #=============================================================================================================
  # LISTADO DE REPORTES POR ORDEN
  public function listado($value='')
  {
    $this->load->model('Ot_db');
    $data = array(
      "bases" => $this->Ot_db->getBases()
    );
    $this->load->view('reportes/lista/getReportesByOT', $data);
  }


  #=============================================================================================================
  # Obtener el reporte siguiente por fecha de la OT
  public function getNext($idOT, $idReporte, $date)
  {
    
  }
  
  # Obtener el reporte anterior por fecha de una OT
  public function getPrevious($idOT, $idReporte, $date)
  {
    # code...
  }
  # ============================================================================================================
  # Datos de relleno para pruebas
  public function getByOT($value='')
  {
    $reportes = array();
		for ($i=15; $i <= 31 ; $i++) {
			$fecha = date('Y-m-d', strtotime('2016-08-'.$i));
			$report = array(
				'idreporte'=>$i,
				'OT_idOT' => '27',
				'nombre_ot'=>'VITPCLLTEST',
				'fecha_reporte'=>$fecha,
				'dia'=> date('d', strtotime($fecha)),
				'mes'=> date('m', strtotime($fecha)),
				'valido'=> ( ($i%2==0)?true: false)
			);
			array_push($reportes, $report);
		}
		echo json_encode($reportes);
  }
  #===============================================================================================================
  # Obtener recursos preparados para agregar a la O.T.
  public function getRecursoOtByType(){
      $this->load->model();
  }

  //calendario js+angular
  public function calendar($ot='')
	{
		$this->load->model('ot_db', 'myot');
		$ot = $this->myot->getData($ot);
		$this->load->view('reportes/calendar', array('ot'=>$ot->row()));
	}



}
