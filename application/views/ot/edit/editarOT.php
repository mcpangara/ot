<div class="windowCentered2 row">
	<section class="area" ng-controller="editarOT">

		<div class="btnWindow">
	      <img class="logo" src="<?= base_url("assets/img/termotecnica.png") ?>" width="100px" />
	      <button type="button" class="waves-effect waves-light btn red" ng-click="cerrarWindow()">Salir</button>
	    </div>

		<h4 class="center-align"><?= $titulo_gestion ?></h4>

		<!-- Información de la básica OT -->
		<table class="mytabla">
			<thead>
				<tr>
					<th>Nombre de OT</th>
					<th>Base</th>
					<th>Departamento</th>
					<th>Municipio</th>
					<th>Vereda</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
		<br>
		<!-- seleccion de tarea -->
		<div>
			<label>Seleccione una tarea:</label>
			<select>
				<option>Tarea1</option>
			</select>
		</div>
		
		<br>

		<!-- Panel de opciones -->
		<style type="text/css">
			.mypanel{
				border: 1px solid #999;
			}
			.divbtn{
				border-right:1px solid #999;
				margin:1px;
				border-radius: 5px;
				padding: 5px;				
				float: left;
			}
		</style>

		<div class="row mypanel">
			<div class="divbtn">Descripción</div>
			<div class="divbtn">Planeación (items)</div>
			<div class="divbtn">Indirectos</div>
			<div class="divbtn">Gastos de viaje</div>
			<div class="divbtn">Reembolsables</div>
			<div class="divbtn">horas extra</div>
			<div class="divbtn">resumen</div>
		</div>

		<!-- panel de contenidos -->
		<div class="panel">
			
		</div>

		<br>

		<!-- opciones -->
		<div class="btnWindow">
			<button type="button" class="waves-effect waves-light btn" ng-click="guardarOT('<?= site_url('ot/saveOT') ?>')">Guardar</button>
			<button type="button" class="waves-effect waves-light btn red" ng-click="cerrarWindow()">Cerrar</button>
			<button type="button" class="waves-effect waves-light btn grey" ng-click="toggleWindow()">Ocultar</button>
	  	</div>

	</section>
</div>