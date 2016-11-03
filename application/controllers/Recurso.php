<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recurso extends CI_Controller{

  public function __construct(){ parent::__construct(); }

  function index(){ }


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
      $this->procesaCarga($subcarpeta, $dir.$dataup['file_name']);
    }else{
      echo  $this->upload->display_errors();
    }
  }

  # Recorrer excel
  public function recorrerFilasMaestro($process, $ruta)
  {
    print_r($this->leerExcel($ruta));
    /*foreach ($this->leerExcel($ruta, TRUE) as $key => $value) {
      foreach ($value as $k => $v) {
        echo $v." - ";
      }
      echo "<br>";
    }*/
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
    return $this->excel->getData('./uploads/'.$ruta);
  }

  # Comprueba que la O.T. este registrada para agregar el personal a la O.T.
  public function existeOtBy($field, $elemento)
  {
    # code...
  }

  # Comprueba si existe la persona previamente
  public function existePersona($value='')
  {
    # code...
  }

  public function existeEquipo($value='')
  {
    # code...
  }

  public function recorrer($value='')
  {
    # code...
  }
}
