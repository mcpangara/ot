<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recurso extends CI_Controller{

  public function __construct(){
    parent::__construct();
    date_default_timezone_set("America/bogota");
  }

  function index(){

  }


  # =============================================================================
  # PROCESAMIENTO DE MAESTROS PERSONAL Y EQUIPOS
  # =============================================================================

  # =============================================================================
  # Subir seleccionar tipo de proceso a realizar
  public function uploadMaestro($tipo)// tipo describe si es equipo o persona
  {
    if ($tipo=="personal"){
      $this->uploadFile("personal");
    }elseif ($tipo=="equipo"){
      $this->uploadFile("equipo");
    }
  }

  # Upload y encaminamiento del proceso
  public function uploadFile($subcarpeta)
  {
    $dir = "./uploads/".$subcarpeta."/".date("dmY")."/";
    $this->crear_directorio($dir);
    //config:
    $config['upload_path']    = $dir;
    $config['allowed_types']  = 'xls|xlsx|xlsm';
    $this->load->library('upload', $config);
    if ($this->upload->do_upload('myfile')) {
      $dataup = $this->upload->data();
      $this->recorrerFilasMaestro($subcarpeta, $dir.$dataup['file_name']);
    }else{
      echo  $this->upload->display_errors();
    }
  }

  # Recorrer excel
  public function recorrerFilasMaestro($process, $ruta='./uploads/equipos.xlsx')
  {
    $rows = $this->leerExcel($ruta, TRUE);
    $this->load->helper("excel");
    $this->load->model('ot_db', 'ot');
    $this->load->model('item_db', 'item');
    $this->load->model('equipo_db', 'equ');
    $this->ot->init_transact();

    $noValid = array();
    foreach ($rows as $key => $cell) {
      if ($process == 'personal') {
        if($cell['B'] != 'Id C.O.' || $cell['C'] != 'Empleado'){
          $ots = $this->ot->getOtBy( 'nombre_ot', $cell['F'] );
          $items = $this->item->getItemfBy( 'codigo', $cell['G'], 'itemf' );
          # echo "No.OT:".$ots->num_rows()." | No.Items:".$items->num_rows()."<br>";
          if ($ots->num_rows() > 0 && $items->num_rows() > 0) {
            $orden = $ots->row();
            $myitemf = $items->row();
            $cell = $this->registrarPersona($cell, $orden, $myitemf, $noValid);
          }else{
            if($ots->num_rows() < 1){
              $cell["A"] .= ">> OT no encontrada ";
            }
            if($items->num_rows() < 1) {
              $cell["A"] .= ">> Itemf no encontrado";
            }
          }
        }else{
          $cell["A"] = "Comentario App";
        }
      }else if($process ==  'equipos'){
        $cell = $this->registrarEquipo($cell, $noValid);
      }
      array_push($noValid, $cell);
    }

    if($this->ot->end_transact()){
      $html = $this->load->view('miscelanios/reporteCargaXLS',array("filas"=>$noValid),TRUE);
      $this->load->view('miscelanios/resultadoUpdateMAestro', array("html"=>$html));
    }else{
      echo "Fallo al insertar registros";
    }
  }
  # ------------------------------------------------------------------
  # AUXILIARES:

  # crear un subdirectorio
  public function crear_directorio($carpeta)
  {
    if (!file_exists($carpeta)) { mkdir($carpeta, 0777, true);  }
  }

  # Llama al helper para leer un xlsx y devuelve una coleccion PHP
  public function leerExcel($ruta='./uploads/equipos2.xlsx')
  {
    $this->load->library('excel');
    return $this->excel->getData($ruta);
    //print_r($this->excel->getData($ruta));
  }
  # Proceso que realiza el registro de datos por persona
  public function registrarPersona($row, $ot, $itemf, $noValid)
  {
    $this->load->model('persona_db', 'per');
    $personas  = $this->per->getBy("identificacion", $row['C'], "persona");
    if($personas->num_rows() < 1){
      $obj = new stdClass();
      $obj->identificacion = $row['C'];
      $obj->nombre_completo = $row['D'];
      $obj->fecha_registro = date('Y-m-d');
      $this->per->addObj($obj);
      $row['A'] = 'Agregado persona - ';
    }
    if( $this->per->existePersona( $row['C'] ) ){
      $recursos = $this->per->getRecursoOT($row["C"], $ot->idOT, $itemf->iditemf);
      if ($recursos->num_rows() < 1) { //si no existe el recurso add
        $this->load->model('recurso_db','recurso');
        $id = $this->recurso->add($row['H'], date('Y-m-d'), $row["F"], $row['E'], $row['I'], $row['C'], 'persona');
        $this->recurso->addRecursoOT($id, $ot, $itemf, TRUE, TRUE, 'persona');
        $row['A'] = $row['A'].'Agregado Recurso';
      }else{
        $row['A'] = 'Registro ya existente';
      }
    }
    return $row;
  }

  public function registrarEquipo($row, $noValid)
  {
    $this->load->model('equipo_db', 'equ');
    $equipos  = $this->equ->getBy("codigo_siesa", $row['B'], "equipo");
    if( $row['B'] == 'Activo fijo' || $row['B'] == 'referencia' ){

    }
    if($equipos->num_rows() < 1){
      $obj = array();
      $obj["codigo_siesa"] = $row['B'];
      $obj["referencia"] = $row['C'];
      $obj["descripcion"] = $row['D'];
      $obj["desc_abreviada"] = $row['E'];
      $obj["nit_responsable"] = $row['F'];
      $obj["responsable"] = $row['G'];
      $obj["ccosto"] = $row['I'];
      $obj["un"] = $row['K'];
      $obj["desc_un"] = $row['L'];
      $id =$this->equ->addArray($obj);
      $row['A'] = 'Agregado Equipo - ID: '.$id;
    }else{
      $row['A'] = 'Equipo ya existente';
    }
    return $row;
  }


  # Exportar html aexcel
  public function exporExcel($value='')
  {
    $html = $this->input->post('html');
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Informe.xls");
    echo $html;
  }
}
