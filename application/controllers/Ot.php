<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ot extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('America/Bogota');
	}

	public function index()
	{

	}

	public function addNew($value='')
	{
		$this->load->model('miscelanio_db');
		$depars = $this->miscelanio_db->getDepartamentos();
		$tipos_ot = $this->miscelanio_db->getTiposOT();
		$especialidades = $this->miscelanio_db->getEspecialidadesOT();
		$tarifagv = $this->miscelanio_db->getTarifasGV();
		$this->load->view('ot/add/addOT', array("depars"=>$depars, "tipos_ot"=>$tipos_ot, "especialidades"=>$especialidades, "tarifagv"=>$tarifagv));
	}

	public function getDataNewForm()
	{
		$this->load->model(array("Ot_db","item_db","miscelanio_db"));
		$bases = $this->Ot_db->getBases();
		$items['actividad']  = $this->item_db->getBytipo(1)->result();
		$items['personal']  = $this->item_db->getBytipo(2)->result();
		$items['equipo']  = $this->item_db->getBytipo(3)->result();
		$arr =array(
			"bases"=>json_encode($bases->result()),
			'items'=>json_encode($items)
			);
		echo json_encode($arr);
	}

	#=============================================================================
	# GUARDAR UNA ORDEN DE TRABAJO
	public function saveOT(){
		$ots = json_decode(file_get_contents('php://input'));
		$ot = $ots->ot;
		#Crear la OT
		$orden = $ots->ot;
		$this->load->model('Ot_db','ot');
		$orden->fecha_creacion = date('Y-m-d H:i:s');

		try {
			# --------------------
			#crear la OT
			$idot = $this->ot->add(
					$orden->nombre_ot->data,
					$orden->base,
					$orden->zona->data,
					$orden->fecha_creacion,
					$orden->especialidad->data,
					$orden->tipo_ot->data,
					$orden->actividad->data,
					$orden->justificacion->data,
					$orden->locacion->data,
					$orden->abscisa->data,
					$orden->idpoblado
				);
			#-----------------------
			#Adicionar tarea nueva
			$this->load->model('Tarea_db','tr');
			$i = 0;
			foreach ($ot->items as $tar){
				$i++;
				# creamos la tarea
				$idTr = $this->crearTareaOT($tar, $idot, 'TAREA '.$i);
				#insertamos los items planeados a la tarea
				$this->insetarITemsTarea($idTr, $tar->personal);
				$this->insetarITemsTarea($idTr, $tar->actividades);
				$this->insetarITemsTarea($idTr, $tar->equipos);
			}
			echo "Orden de trabajo guardada correctamente";
		} catch (Exception $e) {
			echo "Error al insertar la OT: ".$e->getMessege();
		}

	}

	private function crearTareaOT($tar, $idot, $nombre_tarea)
	{
		return $this->tr->add(
				$nombre_tarea,
				date('Y-m-d', strtotime($tar->fecha_inicio->data)),
				date('Y-m-d', strtotime($tar->fecha_fin->data)),
				$tar->valor_recursos->total_recursos,
				0,
				json_encode($tar->indirectos),
				json_encode($tar->viaticos),
				json_encode($tar->horas_extra),
				json_encode($tar->reembolsables),
				'',
				json_encode($tar->valor_recursos),
				$idot
			);
	}

	private function insetarITemsTarea($idTr, $items)
	{
		$this->load->model('Item_db', 'it');
		foreach ($items as $per) {
			$this->it->setItemTarea(
					$per->cantidad,
					$per->duracion,
					$per->unidad_item,
					$per->tarifa,
					($per->tarifa * ($per->cantidad * $per->duracion)),
					date('Y-m-d H:i:s'),
					$per->iditemf,
					$per->codigo,
					$idTr
				);
		}
	}
	#=============================================================================
	# LISTAR ORDENES
	public function listOT($value=''){
		$this->load->database('ot');
		$ots = $this->db->get('OT');
		$this->load->view('ot/listOT', array('ots'=>$ots));
	}
	#=============================================================================
	# Generar OT impresión
	public function imprimirOT($id)
	{
		$this->load->helper('pdf');
		$this->load->helper('file');
		$this->load->helper('download');
		$this->load->model(array('ot_db', 'item_db'));
		$ot = $this->ot_db->getData($id);
		$tr = $this->ot_db->getTarea1($id)->row();
		#$idTarea = 14;
		#$tarea = %$this->ot_db->getTarea($id, $idTarea);
		$acts = $this->item_db->getItemsByTarea($tr->idtarea_ot, 1);
		$pers = $this->item_db->getItemsByTarea($tr->idtarea_ot, 2);
		$equs = $this->item_db->getItemsByTarea($tr->idtarea_ot, 3);
		$data = array(
			'ot' => $ot->row(),
			'pers'=>$pers,
			'equs'=>$equs,
			'acts'=>$acts
		);
		$html = $this->load->view('ot/imprimir/formatoOT',$data,TRUE);
		doPDF($html);
	}

	public function testCalendar($ot='')
	{
		$this->load->model('ot_db', 'myot');
		$ot = $this->myot->getData($ot);
		$this->load->view('reportes/calendar', array('ot'=>$ot->row()));
	}
	public function getMyReportes($value='')
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

	# ============================================================================
	# Consltas de items
	# ============================================================================

	# Obtener items por tipo [AJAX]
	public function getItemByTipeOT($idOT, $tipo, $llave = NULL)
	{
		$this->load->model('OT_db', 'ot_db');
		$rows = $this->ot_db->getItemByTipeOT($idOT, $tipo);
		echo json_encode($rows->result());
	}

	# Obtener cantidades por item [AJAX]
	public function getCantidadByItemf($item)
	{
		# pendiente
	}

	# ============================================================================
	public function foo($value=''){ echo 'foo';}
}
/* End of file Ot.php */
/* Location: ./application/controllers/Ot.php */
