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
				"titulo_gestion"=>"Agregar una nueva Orden de Trabajo:",
				'isEdit'=>FALSE
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
	public function saveOTValid()
	{
		if( $this->existeOT() ){
			echo "La Orden de trabajo ya existe";
		}
	}
	public function saveOT()
	{
		$post = file_get_contents('php://input');
		$ots = json_decode($post);
		$ot = $ots->ot;
		#Crear la OT
		$orden = $ots->ot;
		if( $this->existeOT($orden->nombre_ot) ){
			echo "La Orden de trabajo ya existe";
		}else{
			$this->load->model('Ot_db','ot');
			$orden->fecha_creacion = date('Y-m-d H:i:s');
			try {
				$this->ot->init_transact();
				# --------------------
				#crear la OT
				$idot = $this->ot->add(
						$orden->nombre_ot,
						isset($orden->ccosto)?$orden->ccosto:NULL,
						$orden->base_idbase,
						$orden->zona,
						$orden->fecha_creacion,
						$orden->especialidad,
						$orden->tipo_ot,
						$orden->actividad,
						$orden->justificacion,
						isset($orden->locacion)?$orden->locacion:NULL,
						isset($orden->abscisa)?$orden->abscisa:NULL,
						isset($orden->idpoblado)?$orden->idpoblado:NULL,
						isset($orden->cc_ecp)?$orden->cc_ecp:NULL,
						isset($orden->json)?json_encode($orden->json):NULL,
						isset($orden->numero_sap)?$orden->numero_sap:NULL
					);
				#-----------------------
				#Adicionar tarea nueva
				$this->load->model('Tarea_db','tarea');
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
				$status = $this->ot->end_transact();
				if($status){echo "Orden de trabajo guardada correctamente";}else { echo "No se ha guardado";	}
			} catch (Exception $e) {
				echo "Error al insertar la OT: ".$e->getMessege();
			}
		}
	}

	private function crearTareaOT($tar, $idot, $nombre_tarea)
	{
		return $this->tarea->add(
				$nombre_tarea,
				date('Y-m-d', strtotime($tar->fecha_inicio)),
				date('Y-m-d', strtotime($tar->fecha_fin)),
				$tar->valor_recursos,
				$tar->valor_tarea_ot,
				json_encode($tar->json_indirectos),
				json_encode($tar->json_viaticos),
				json_encode($tar->json_horas_extra),
				json_encode($tar->json_reembolsables),
				'',
				json_encode($tar->json_recursos),
				$idot
			);
	}

	private function insetarITemsTarea($idTr, $items)
	{
		foreach ($items as $item) {
			$this->addNewItemTarea($idTr, $item);
		}
	}
	public function addNewItemTarea($idTr, $item)
	{
		$this->load->model('Item_db', 'it');
		$this->it->setItemTarea(
				$item->cantidad,
				$item->duracion,
				$item->unidad,
				$item->tarifa,
				($item->tarifa * ($item->cantidad * $item->duracion)),
				date('Y-m-d H:i:s'),
				$item->iditemf,
				$item->codigo,
				$idTr
			);
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
	public function imprimirOT($id, $idtr)
	{

		$this->load->helper('pdf');
		$this->load->helper('file');
		$this->load->helper('download');
		$this->load->model(array('ot_db', 'item_db'));
		$ot = $this->ot_db->getData($id)->row();
		$tr = $this->ot_db->getTarea($id, $idtr)->row();

		$indirectos = json_decode($tr->json_indirectos);
		$viaticos = json_decode($tr->json_viaticos);
		$reembolsables = json_decode($tr->json_reembolsables);
		$horas_extra = json_decode($tr->json_horas_extra);

		$acts = $this->item_db->getItemsByTarea($idtr, 1);
		$sub_acts = $this->subtotales($acts);
		$pers = $this->item_db->getItemsByTarea($idtr, 2);
		$sub_pers = $this->subtotales($pers);
		$equs = $this->item_db->getItemsByTarea($idtr, 3);
		$sub_equs = $this->subtotales($equs);
		$data = array(
			'ot' => $ot,
			'pers'=>$pers,
			'equs'=>$equs,
			'acts'=>$acts,
			'sub_acts'=>$sub_acts,
			'sub_pers'=>$sub_pers,
			'sub_equs'=>$sub_equs,
			'indirectos'=>$indirectos,
			'viaticos'=>$viaticos,
			'reembolsables'=>$reembolsables,
			'horas_extra'=>$horas_extra,
			'tr'=>$tr
		);
		$html = $this->load->view('ot/imprimir/formatoOT',$data,TRUE);
		doPDF($html, $ot->nombre_ot, './uploads/ordenes/');

		//write_file('./uploads/ordenes/'.$titulo.'.pdf', $pdf);
	  //force_download('./uploads/ordenes/'.$titulo.'.pdf', NULL);
	}

	public function pruebaImprimir()
	{
		$this->load->helper('pdf');
		$this->load->helper('file');
		$this->load->helper('download');
		$html =$this->load->view('imprimirTEST','',TRUE);
		doPDF($html, 'prueba', './uploads/');
	}

	public function getMyReportes($value='')
	{
		$reportes = array();
		for ($i=11; $i <= 28 ; $i++) {
			$fecha = date('Y-m-d', strtotime('2016-09-'.$i));
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

	public function subtotales($items)
	{
		$valor = 0;
		foreach ($items->result() as $value) {
			$valor += $value->valor_plan;
		}
		return $valor;
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

	public function update($idOT=NULL){
		$ots = json_decode(file_get_contents('php://input'));
		$ot = $ots->ot;
		$orden = $ots->ot;
		$this->load->model(array('ot_db'=>'ot_db', 'tarea_db'=>'tarea', 'item_db'=>'item' ));
		# inicio de seguimiento de transacciones
		$this->ot_db->init_transact();

		$this->ot_db->update(
				$orden->idOT,
				$orden->nombre_ot,
				$orden->ccosto,
				$orden->base_idbase,
				$orden->zona,
				$orden->fecha_creacion,
				$orden->especialidad_idespecialidad,
				$orden->tipo_ot_idtipo_ot,
				$orden->actividad,
				$orden->justificacion,
				$orden->locacion,
				$orden->abscisa,
				$orden->idpoblado,
				json_encode($orden->json),
				isset($orden->numero_sap)?$orden->numero_sap:NULL
			);
		foreach($orden->tareas as $tr){
			if(isset($tr->idtarea_ot) &&  $tr->idtarea_ot != 0 ){
				$valid = $this->update_tarea($tr);
				$this->recorrerItems($tr->actividades, $tr->idtarea_ot);
				$this->recorrerItems($tr->personal, $tr->idtarea_ot);
				$this->recorrerItems($tr->equipos, $tr->idtarea_ot);
			}else{
				$idTr = $this->crearTareaOT($tr, $orden->idOT, $tr->nombre_tarea);
				$this->insetarITemsTarea($idTr, $tr->personal);
				$this->insetarITemsTarea($idTr, $tr->actividades);
				$this->insetarITemsTarea($idTr, $tr->equipos);
			}
		}
		# fin de seguimiento de transacciones concapacidad de RollBack
		$status = $this->ot_db->end_transact();
		if($status != FALSE){
			$succ = new stdClass();
			$succ->success = 'Orden de trabajo guardada correctamente';
			$succ->ot = $this->get($orden->idOT);
			echo json_encode($succ);
			//echo "Orden de trabajo guardada correctamente";
		}else{
			echo 'ha sucedido un error inesperado, estamos trabajando para mejorar.';
		}
	}

	# Proceso para actualizar una tarea de una OT
	public function update_tarea($tr){
		return $this->tarea->update(
				$tr->idtarea_ot,
				$tr->nombre_tarea,
				$tr->fecha_inicio,
				$tr->fecha_fin,
				$tr->valor_recursos,
				$tr->valor_tarea_ot,
				json_encode($tr->json_indirectos),
				json_encode($tr->json_viaticos),
				json_encode($tr->json_horas_extra),
				json_encode($tr->json_reembolsables),
				json_encode($tr->json_raciones),
				json_encode($tr->json_recursos),
				$tr->OT_idOT
			);
	}
	# proceso que recorre los items de las tareas e inserta o actualiza los cambios
	public function recorrerItems($items, $idTr){
		foreach($items as $it){
			if(isset($it->iditem_tarea_ot)){
				$this->update_item_tarea($it);
			}else{
				$this->addNewItemTarea($idTr, $it);
			}
		}
	}
	# Proceso que actualiza los items de las tareas
	public function update_item_tarea($it){
		return $this->item->updateItemTarea(
				$it->iditem_tarea_ot,
				$it->cantidad,
				$it->duracion,
				$it->unidad,
				$it->tarifa,
				($it->tarifa * ($it->cantidad * $it->duracion)),
				date('Y-m-d H:i:s'),
				$it->itemf_iditemf,
				$it->itemf_codigo,
				$it->tarea_ot_idtarea_ot
			);
	}

	#=================================================================================
	# Consultas
	#=================================================================================
	# Obtener datos de una OT
	public function get($id)
	{
		$this->load->model('ot_db');
		$ot = $this->ot_db->getData($id)->row();
		$ot->json = json_decode($ot->json);
		$trs = $this->getTareasByOT($id);
		$ot->tareas = $trs;
		return $ot;
	}
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
	public function existeOT($nombre_ot = NULL)
	{
		if(!isset($nombre_ot)){
			$post = json_decode(file_get_contents('php://input'));
			$nombre_ot = $post->nombre_ot;
		}

		$this->load->database('ot');
		$this->db->from('OT');
		$this->db->where('nombre_ot', $nombre_ot);
		$rows = $this->db->get();

		if($rows->num_rows() > 0){
			return true;
		}
		return false;
	}

	# ===============================================================================
	// BORRADOS
	public function delete_tarea($id)
	{
		$this->load->database('ot');
		$this->db->delete('item_tarea_ot')->where('tarea_ot_idtarea_ot',$id);
		$this->db->delete('tarea_ot')->where('idtarea_ot',$id);
		echo 'success';
	}
	public function del_item_tarea($id)
	{
		$this->load->database('ot');
		$this->db->delete('item_tarea_ot', array('iditem_tarea_ot'=>$id));
		echo 'success';
	}
}
/* End of file Ot.php */
/* Location: ./application/controllers/Ot.php */
