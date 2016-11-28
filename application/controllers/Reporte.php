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
  # add
  public function addvalid($idOT, $fecha)
  {
    $post = json_decode( file_get_contents("php://input") );
    $this->load->model('reporte_db', 'repo');
    $rows = $this->repo->getBy($idOT, $fecha);
    if($rows->num_rows() > 0){
      echo 'invalid';
    }else{
      echo 'valid';
    }
  }
  # form add reporte
  public function add($idOT, $fecha){
    $this->load->model('Ot_db', 'otdb');
    $ot = $this->otdb->getData($idOT);
    $this->load->model('tarea_db', 'tarea');
    $item_equipos = $this->tarea->getTareasItemsResumenBy($idOT,3);

    //obtener unidades de negocio
    $this->load->model('equipo_db', 'equ');
    $un_equipos = $this->equ->getResumenUN();
    $this->load->view('reportes/add/add', array('ot'=>$ot->row(), 'fecha'=>$fecha, 'item_equipos'=>$item_equipos->result(), 'un_equipos'=>$un_equipos));
  }
  # insetar el reporte
  public function insert(){
    $post = json_decode( file_get_contents("php://input") );
    $info = $post->info;

    if($this->addvalid($post->info->idOT, $post->info->fecha_reporte) == 'valid'){
      $recusos = $post->recursos;
      $this->load->model('reporte_db', 'repo');
      $this->repo->init_transact();
      // Insertamos el reporte y devolvemos el ID
      $idrepo = $this->repo->add($post->info);
      //Recorremos los arregos de recursos
      $this->insertarRecursoRep($post->recursos->actividades, $idrepo);
      $this->insertarRecursoRep($post->recursos->personal, $idrepo);
      $this->insertarRecursoRep($post->recursos->equipos, $idrepo);
      $validProcc = $this->repo->end_transact();
      if($validProcc != FALSE){
        $response = new stdClass();
        $response->success = 'success';
        $response->idreporte_diario = $idrepo;
        echo json_encode($response);
      }else{
        show_404();
      }
    }
  }
  public function insertarRecursoRep($list, $idr){
    foreach ($list as $key => $value) {
      $this->repo->addRecursoRepo($value, $idr);
    }
  }
  #===========================================================================================================
  # Validaciones para guardar el reporte

  # valida si un Recurso ya esta registrado en una fecha dada, TRUE si se puede insertar y FALSE si ya existe en esa fecha
  public function validarRecurso($idrecurso_ot, $fecha)
  {
    $rows = $this->repo->recursoRepoFecha($idrecurso_ot, $fecha);
    if($rows->num_rows() > 0){
      return FALSE;
    }
    return TRUE;
  }
  public function validarRecursoUpdate($idrecurso_reporte_diario, $fecha)
  {
    $rows = $this->repo->recursoRepoFechaID($idrecurso_ot, $fecha);
    if($rows->num_rows() > 0){
      return FALSE;
    }
    return TRUE;
  }
  # Valida un conjunto de recursos en una fecha a reportar
  public function validarRecursos()
  {
    $this->load->model('reporte_db', 'repo');
    $post = json_decode( file_get_contents("php://input") );
    $post->succ = TRUE;
    foreach ($post->recursos as $k => $v) {
      if($k!='actividades'){
        foreach ($v as $key => $value) {
          $value->msj = '';
          $value->valid =  $this->validarRecurso(
            $value->idrecurso_ot,
            $post->fecha
          );
          $value->valid_item = $this->validarItemByOT($post->idOT, $value->codigo);
          $value->query = $this->db->last_query();
          if(!$value->valid){
            $value->msj .= 'Ya esta reportado en un reporte de esta fecha.';
          }
          if(!$value->valid_item){
            $value->msj .= ' El item no existe en la planificación OT';
            $value->valid = FALSE;
          }
        }
      }
    }
    echo json_encode($post);
  }

  # Valida la existencia de un items en la OT
  public function validarItemByOT($idOT, $codigo)
  {
    $this->load->model('tarea_db', 'tar');
    $rows = $this->tar->getItemOTSUM($idOT,$codigo);
    if($rows->num_rows() > 0){
      return TRUE;
    }
    return FALSE;
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

  public function getReportesByOT()
  {
    $post = json_decode(file_get_contents('php://input'));
    $this->load->model('reporte_db', 'rd');
    $rows = $this->rd->listaBy($post->idOT);
    echo json_encode($rows->result());
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
  public function get($idReporte)
  {
    $this->load->model('reporte_db','repo');
    $r = $this->repo->get($idReporte)->row();
    $this->load->model('Ot_db', 'otdb');
    $ot = $this->otdb->getData($r->OT_idOT);
    $this->load->model('tarea_db', 'tarea');
    $item_equipos = $this->tarea->getTareasItemsResumenBy($r->OT_idOT,3);
    //obtener unidades de negocio
    $this->load->model('equipo_db', 'equ');
    $un_equipos = $this->equ->getResumenUN();

    //$recursos = new stdClass();
    //$recursos->personal = $this->repo->getRecursoReporte();
    $this->load->view('reportes/edit/edit', array( 'r'=>$r, 'item_equipos'=>$item_equipos->result(), 'un_equipos'=>$un_equipos));
  }

  public function getInfo($idReporte)
  {
    $this->load->model('reporte_db','repo');
    $r = $this->repo->get($idReporte)->row();
    return $r->json_r;
  }
  public function getRecursos($idReporte)
  {
    $this->load->model('reporte_db', 'repo');
    $acts = $this->repo->getRecursos($idReporte, 'actividades');
    $pers = $this->repo->getRecursos($idReporte, 'personal');
    $equs = $this->repo->getRecursos($idReporte, 'equipos');

    $recursos = new stdClass();
    $recursos->idreporte_diario = $idReporte;
    $recursos->info = json_decode( $this->getInfo($idReporte) );
    $recursos->personal = $pers->result();
    $recursos->equipos = $equs->result();
    $recursos->actividades = $acts->result();

    echo json_encode($recursos);
  }
  # ===========================================================================================================
  public function update($value='')
  {
    $post = json_decode( file_get_contents("php://input") );
    $info = $post->info;
    $this->load->model('reporte_db', 'repo');
    $this->repo->init_transact();
    $this->repo->update($post);

    $this->actualizarRecursos($post->recursos->actividades, $post->idreporte_diario, $post->fecha);
    $this->actualizarRecursos($post->recursos->personal, $post->idreporte_diario, $post->fecha);
    $this->actualizarRecursos($post->recursos->equipos, $post->idreporte_diario, $post->fecha);

    if($this->repo->end_transact() != FALSE){
      $response = new stdClass();
      $response->success = 'success';
      $response->recursos = $post;
      echo json_encode($response);
    }else{
      echo "Falló la inserción";
    }
  }

  public function actualizarRecursos($recursos, $idr, $fecha_reporte)
  {
    foreach ($recursos as $key => $rec) {
      if( !isset($rec->idrecurso_reporte_diario) ){
        // insertar
        $this->repo->addRecursoRepo($rec, $idr);
      }else{
        //actualizar
        $this->repo->editRecursoRepo($rec, $idr);
      }
    }
  }

  # ===========================================================================================================
  public function exiteReporte()
  {
    $this->load->model('reporte_db','repo');
    $r = $this->repo->get($idReporte);
    if ($r->num_rows() < 0) {
      echo 0;
    }else{
      echo 1;
    }
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
  public function getRecursosByOT($idOT){
      $this->load->model('recurso_db', 'recdb');
      $this->load->model('tarea_db','tarea');
      $pers = $this->recdb->getPersonalOtBy($idOT, 'persona');
      $equs = $this->recdb->getEquiposOtBy($idOT, 'equipo');
      $acts = $this->tarea->getResumenCantItems($idOT,1);
      $data = array(
          'personal' => $pers->result(),
          'equipo' => $equs->result(),
          'actividad'=> $acts->result()
        );
      echo json_encode($data);
  }

  //calendario js+angular
  public function calendar($ot='')
	{
		$this->load->model('ot_db', 'myot');
		$ot = $this->myot->getData($ot);
		$this->load->view('reportes/calendar', array('ot'=>$ot->row()));
	}

}
