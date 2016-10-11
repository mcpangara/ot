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

	public function getByBase($base)
	{
		$this->load->model('ot_db', 'otdb');
		$ots = $this->otdb->getAllOTs($base);
		echo json_encode($ots->result());
	}

	#=============================================================================
	# GUARDAR UNA ORDEN DE TRABAJO
	public function addNew($value='')
	{
		$this->load->model('miscelanio_db');
		$depars = $this->miscelanio_db->getDepartamentos();
		$tipos_ot = $this->miscelanio_db->getTiposOT();
		$especialidades = $this->miscelanio_db->getEspecialidadesOT();
		$tarifagv = $this->miscelanio_db->getTarifasGV();
		$this->load->view('ot/add/agregarOT', array(
				"depars"=>$depars, 
				"tipos_ot"=>$tipos_ot, 
				"especialidades"=>$especialidades, 
				"tarifagv"=>$tarifagv,
				"titulo_gestion"=>"Agregar una nueva Orden de Trabajo:"
			)
		);
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

	public function saveOT()
	{
		$ots = json_decode(file_get_contents('php://input'));
		$ot = $ots->ot;
		#Crear la OT
		$orden = $ots->ot;
		$this->load->model('Ot_db','ot');
		$orden->fecha_creacion = date('Y-m-d H:i:s');
		echo "TEST";

		try {
			# --------------------
			#crear la OT
			$idot = $this->ot->add(
					$orden->nombre_ot,
					$orden->base,
					$orden->zona,
					$orden->fecha_creacion,
					$orden->especialidad,
					$orden->tipo_ot,
					$orden->actividad,
					$orden->justificacion,
					$orden->locacion,
					$orden->abscisa,
					$orden->idpoblado
				);
			#-----------------------
			#Adicionar tarea nueva
			$this->load->model('Tarea_db','tr');
			$i = 0;
			foreach ($ot->tareas as $tar){
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
				date('Y-m-d', strtotime($tar->fecha_inicio)),
				date('Y-m-d', strtotime($tar->fecha_fin)),
				$tar->valor_recursos->total_recursos,
				0,
				json_encode($tar->json_indirectos),
				json_encode($tar->json_viaticos),
				json_encode($tar->json_horas_extra),
				json_encode($tar->json_reembolsables),
				'',
				json_encode($tar->json_valor_recursos),
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
		$bases = $this->db->get('base');
		$this->load->view('ot/lista/listOT', array('bases'=>$bases));
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
	# Editar/Ver
	# ============================================================================

	public function edit($id)
	{
		$this->load->model('miscelanio_db');
		$depars = $this->miscelanio_db->getDepartamentos();
		$tipos_ot = $this->miscelanio_db->getTiposOT();
		$especialidades = $this->miscelanio_db->getEspecialidadesOT();
		$tarifagv = $this->miscelanio_db->getTarifasGV();

		$data = array(
			'idot'=>$id,
			'titulo_gestion' => ' Edición de Orden de Trabajo:',
			'depars'=>$depars,
			'tipos_ot'=>$tipos_ot,
			'especialidades'=>$especialidades,
			'tarifagv'=>$tarifagv,
			'isEdit'=>TRUE
		);
		$this->load->view('ot/edit/editarOT', $data);
	}

	#=================================================================================
	# Consultas
	#=================================================================================

	# Obtener datos de una OT en JSON
	public function getData($id)
	{
		$this->load->model('ot_db');
		$ot = $this->ot_db->getData($id)->row();
		$ot->json = json_decode($ot->json);
		$trs = $this->getTareasByOT($id);
		$ot->tareas = $trs;
		echo json_encode($ot);
		#echo '<pre>'.json_encode($ot).'</pre>';
	}
	# Obtener un listado de tareas de una OT
	public function getTareasByOT($id)
	{
		$this->load->model('ot_db');
		$trs = $this->ot_db->getTareas($id);
		foreach ($trs->result() as $t) {
			$t->json_indirectos = json_decode($t->json_indirectos);
			$t->json_viaticos = json_decode($t->json_viaticos);
			$t->json_horas_extra = json_decode($t->json_horas_extra);
			$t->json_raciones = json_decode($t->json_raciones);
			$t->json_recursos = json_decode($t->json_recursos);
			$t->json_reembolsables = json_decode($t->json_reembolsables);
			$t->actividades = $this->getItemsByTipo($t->idtarea_ot, 1);
			$t->personal = $this->getItemsByTipo($t->idtarea_ot, 2);
			$t->equipos = $this->getItemsByTipo($t->idtarea_ot, 3);
		}
		return $trs->result();
	}

	# Obetener un listado de items por tarea de ot
	public function getItemsByTipo($id, $tipo)
	{
		$this->load->model('tarea_db');
		$items = $this->tarea_db->getItemsByTipo($id, $tipo);
		return $items->result();
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

	# Existe orden de trabajo
	public function existeOT($nombre_ot)
	{
		# code...
	}
}
/* End of file Ot.php */
/* Location: ./application/controllers/Ot.php */
