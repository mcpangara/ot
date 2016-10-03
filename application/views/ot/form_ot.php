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
				padding: 1px;
			}
			.mypanel .btn{
				margin: 0;
				font-size: 12px;
			}
		</style>

		<div class="row mypanel">
			<button class="btn mini-btn">Descripción</button>
			<button class="btn mini-btn light-green darken-4">Planeación (items)</button>
			<button class="btn mini-btn light-blue darken-3">Gastos de viaje</button>
			<button class="btn mini-btn light-blue darken-3">horas extra</button>
			<button class="btn mini-btn">Reembolsables</button>
			<button class="btn mini-btn">resumen</button>
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