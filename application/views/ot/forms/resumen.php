
	<section id="resumen">
		<div ng-repeat="mytr in ot.tareas">
			<h5> {{mytr.nombre_tarea}} </h5>
			<?php $this->load->view('ot/forms/resumen/planeacion'); ?>
			<?php $this->load->view('ot/forms/resumen/indirectos_ot'); ?>
			<br class="clear-left">
			<hr style="border:1px solid #33c633">
			<br>
		</div>
	</section>