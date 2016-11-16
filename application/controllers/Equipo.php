<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Equipo extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
    date_default_timezone_set('America/Bogota');
  }

  function index()
  {

  }

  public function listado($value='')
  {
    $this->load->view('equipo/listEquipos');
  }
  public function getAll()
  {
    $this->load->model('equipo_db', 'equ');
    $equs = $this->equ->getAll();
    echo json_encode($equs->result());
  }

  public function findBy()
  {
    $post = json_decode( file_get_contents("php://input") );
    $this->load->model('equipo_db', 'equ');
    $equs = $this->equ->searchBy(
      (isset($post->codigo_siesa)?$post->codigo_siesa:NULL),
      (isset($post->referencia)?$post->referencia:NULL),
      (isset($post->descripcion)?$post->descripcion:NULL),
      (isset($post->un)?$post->un:NULL)
    );
    echo json_encode( $equs->result() );
  }

  #===============================================================================================
  # Procesos para reporte
  #===============================================================================================
  public function relacionarEquipo($value='')
  {
    $post = json_decode( file_get_contents("php://input") );
    $this->load->model('equipo_db', 'equipo');
    $this->load->model('item_db', 'item');
    $rows = $this->item->getField('iditemf = '.$post->itemf_iditemf, 'codigo, iditemf', 'itemf');
    if($rows->num_rows() > 0){
      $myitemf = $rows->row();
      $post->itemf_codigo = $myitemf->codigo;
      $id = $this->equipo->setEquipoRecurso($post);
      $this->equipo->setEquipoOT($post, $id);
      $this->load->model('recurso_db', 'recdb');
      $list_eq = $this->recdb->getEquiposOtBy($post->OT_idOT, 'equipo');
      echo json_encode($list_eq->result());
    }else{
      show_404();
    }
  }


  #===============================================================================================
  # consultas
  #===============================================================================================

  #Equipos de una OT
  public function equiposByOT($idot)
  {
    $this->load->model('equipo_db', 'equ');
    $equipos = $this->equ->getByOT($idot);
    echo json_encode( $equipos->result() );
  }


  #===============================================================================================
  #===============================================================================================
  #==================== PROCESO DE CARGA DE PERSONAL X OT DESDE UN ARCHIVO =======================
  #===============================================================================================
  public function formUpload()
  {
    $this->load->view('equipo/uploadEquOT');
  }

  public function uploadFile($value='')
  {
    $dir = "./uploads/equipos/".date("dmY")."/";
    $this->crear_directorio($dir);
    //config:
    $config['upload_path']    = $dir;
    $config['allowed_types']  = 'xls|xlsx|xlsm';
    $this->load->library('upload', $config);
    if ($this->upload->do_upload('myfile')) {
      $dataup = $this->upload->data();
      $this->cargarEquipos( $this->getDataEquipo( $dir.$dataup['file_name'] ) ); //
    }else{
      echo  $this->upload->display_errors();
    }
  }
  public function crear_directorio($carpeta)
  {
    if (!file_exists($carpeta)) {
      mkdir($carpeta, 0777, true);
    }
  }
  #Prueba
  public function testCargar($value='')
  {
      $this->cargarEquipos( $this->getDataEquipo('./uploads/equipos/09092016/equipos.xlsx') ); //
  }

  #  EN ESTA FUNCION REALIZAMOS EL PROCESO DE RECORRIDO DEL ARRAY DESPUES DE LEER LA HOJA DE CALCULO E INSERTAMOS LOS REGISTROS
  public function cargarEquipos($activeSheet)
  {
        $this->load->model(array('equipo_db'=>'equ'));
        $myrow = $activeSheet[1];
        $i=1;
        $headers = array();
        foreach ($myrow as $k => $r) {
          if(strtolower($r) == 'serial' || strtolower($r) == 'descripcion' || strtolower($r) == 'codigo siesa' || strtolower($r) == 'nombre ot'
              || strtolower($r) == 'item' || strtolower($r) == 'referencia')
          {
            $headers[$k] = strtolower($r);
          }
        }

        unset($activeSheet[1]);

        $num_insert = 0;
        $this->equ->init_transact();
        foreach ($activeSheet as $row){
          $equipo = new stdClass();
          foreach ($headers as $key => $content) {
            $equipo = $this->ajustadorDeFila($content, 'serial', $equipo, 'serial', $row[$key]);
            $equipo = $this->ajustadorDeFila($content, 'descripcion', $equipo, 'descripcion', $row[$key]);
            $equipo = $this->ajustadorDeFila($content, 'codigo siesa', $equipo, 'codigo_siesa', $row[$key]);
            $equipo = $this->ajustadorDeFila($content, 'item', $equipo, 'item', $row[$key]);
            $equipo = $this->ajustadorDeFila($content, 'nombre ot', $equipo, 'nombre_ot', $row[$key]);
            $equipo = $this->ajustadorDeFila($content, 'referencia', $equipo, 'referencia', $row[$key]);
          }
          if(!$this->equ->existeEquipo($equipo->serial)){
            $equipo->idequipo = $this->equ->addObj($equipo);
            $num_insert++;
          }else{
            $equipo->idequipo = $this->equ->getField('serial = "'.$equipo->serial.'"', 'idequipo', 'equipo');
          }
          if (isset($equipo->nombre_ot) ) {
            $row = $this->equ->getField('nombre_ot LIKE "%'.$equipo->nombre_ot.'%"', 'idOT', 'OT')->row();
            $equipo->OT_idOT = $row->idOT;
            $it = $this->equ->getField('itemc_item LIKE "%'.$equipo->item.'%"', 'iditemf, codigo', 'itemf')->row();
            $equipo->itemf_codigo = $it->codigo;
            $equipo->itemf_iditemf = $it->iditemf;
            if (!$this->equ->existeRecursoOT($equipo) ) {
              $this->equ->setOT($equipo);
            }
          }
        }

        $returned = $this->equ->end_transact();
        if ($returned){
          echo 'Carga completada sin problemas, Filas insertadas: '.$num_insert;
        }else{
          echo 'La carga no ha sido exitosa';
        }
  }
  # El ajustador permite comparar cabecera actual con contenido esperado e identificado
  public function ajustadorDeFila($contenido, $comparador, $obj, $propiedadObj, $valorGuardar)
  {
    if ($contenido ==  $comparador) {
      $obj->$propiedadObj = $valorGuardar;
    }
    return $obj;
  }
  # Esta funcion nos permite hacer uso de la Libreria PHPExcel para leer archivos de hojas de calculo
  public function getDataEquipo($ruta='./uploads/equposot/09092016/equipos.xlsx')
  {
    $this->load->library('excel');
    $datos = $this->excel->getData($ruta);
    return $datos;
  }

}
