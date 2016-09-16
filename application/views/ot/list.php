
	<div>
		<table id="myTable" class="table border" style="width:100%">
			<caption>GESTION DE ORDENES DE TRABAJO</caption>
			<thead>
				<tr>
					<th>ID</th>
					<th>NOMBRE</th>
					<th>KP</th>
					<th>BASE</th>
					<th>FECHA INICIO</th>
					<th>FECHA FIN</th>
					<th>VALOR</th>
					<th>DETALLE</th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach ($ots->result() as $ot) {
			?>
				<tr>
					<td><?= $ot->idot ?></td>
					<td><?= $ot->nombre_ot ?></td>
					<td><?= $ot->kp ?></td>
					<td><?= $ot->base_idbase ?></td>
					<td><?= $ot->fecha_inicio ?></td>
					<td><?= $ot->fecha_fin ?></td>
					<td><?= number_format($ot->valor_total) ?></td>
					<td>
						<a href="<?= site_url('ordentrabajo/ver/'.$ot->idot."/".$distraccion) ?>" class="button btn-small round info" data-icon="&#xe004" style="color:#111"></a>
						<button data-link="<?= site_url('ordentrabajo/form_del/'.$ot->idot."/AEFP000912SE") ?>" class="btn-small round alert" data-icon="&#xe012"></button>
					</td>
				</tr>
			<?php
			}
			?>
			</tbody>
		</table>
	</div>

	<style type="text/css">
		#myTable_length select{
			display: inline;
			margin: auto;
			width: auto;
		}
	</style>

	<script type="text/javascript">
		$(document).ready(function(){
		    $('#myTable').DataTable({
		    	responsive: true,
		    	"language": {
		    		"url": "<?= base_url('assets/js/datatables/spanish.json') ?>"
		    	}
		    });

				$("button").on("click",function() {
					var link = $(this).data("link");
					window.location.href = link;
				});
		});
	</script>
