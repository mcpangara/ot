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
  public function recorrerFilasMaestro($process, $ruta='./uploads/personal/04112016/prueba.xlsx')
  {
    $rows = $this->leerExcel($ruta, TRUE);
    $this->load->helper("excel");
    $this->load->model('ot_db', 'ot');
    $this->load->model('item_db', 'item');
    $this->load->model('equipo_db', 'equ');

    $noValid = array();
    foreach ($rows as $key => $cell) {
      if($cell['B'] != 'Id C.O.' || $cell['C'] != 'Empleado'){
        $ots = $this->ot->getOtBy( 'nombre_ot', $cell['F'] );
        $items = $this->item->getItemfBy( 'codigo', $cell['G'], 'itemf' );
        # echo "No.OT:".$ots->num_rows()." | No.Items:".$items->num_rows()."<br>";
        if ($ots->num_rows() > 0 && $items->num_rows() > 0) {
          $orden = $ots->row();
          $myitemf = $items->row();
          if ($process == 'personal') {
            $cell = $this->registrarPersona($cell, $orden, $myitemf, $noValid);
          }else if($process ==  'equipo'){
            $this->registrarEquipo($cell, $orden, $myitemf, $noValid);
          }
        }else{
          $cell["A"] = "OT y/o id CCosto no encontrados";
        }
      }else{
        $cell["A"] = "Comentario App";
      }
      array_push($noValid, $cell);
    }
    $html = $this->load->view('miscelanios/reporteCargaXLS',array("filas"=>$noValid),TRUE);
    $this->load->view('miscelanios/resultadoUpdateMAestro', array("html"=>$html));
  }
  # ------------------------------------------------------------------
  # AUXILIARES:

  # crear un subdirectorio
  public function crear_directorio($carpeta)
  {
    if (!file_exists($carpeta)) { mkdir($carpeta, 0777, true);  }
  }

  # Llama al helper para leer un xlsx y devuelve una coleccion PHP
  public function leerExcel($ruta)
  {
    $this->load->library('excel');
    return $this->excel->getData($ruta);
  }
  # Comprueba si existe la persona previamente
  public function existePersona($value='')
  {
    # code...
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

  public function existeEquipo($value='')
  {
    # code...
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
