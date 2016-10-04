<div class="windowCentered2 row" ng-controller="OT">
	<section class="area" ng-controller="editarOT">

		<div class="btnWindow">
	      <img class="logo" src="<?= base_url("assets/img/termotecnica.png") ?>" width="100px" />
	      <button type="button" class="waves-effect waves-light btn red" ng-click="cerrarWindow()">Salir</button>
	    </div>

		<h4 class="center-align" ng-init="getOTData('<?= site_url('ot/') ?>')"><?= $titulo_gestion ?></h4>

		<!-- Información de la básica OT -->
		<table class="mytabla" ng-init="getItemsBy('<?= site_url('Ot/getDataNewForm') ?>')">
			<thead>
				<tr>
					<th>Nombre de OT</th>
					<th>Base</th>
					<th>Zona</th>
					<th>Especialidad</th>
					<th>Tipo OT</th>
					<th>Estado</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td></td>
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
				padding: 3px;
			}
			.mybtn{
				background: #346EB2;
				color: #FFF;
				border:1px solid #999;
			}
		</style>

		<div class="row mypanel">
			<div>
				Selecciona una de las siguientes opciones:
			</div>
			<button class="btn mini-btn">Descripción</button>
			<button class="btn blue darken-4 mini-btn">Planeación (items)</button>
			<button class="btn blue darken-4 mini-btn">Gastos de viaje</button>
			<button class="btn blue darken-4 mini-btn">horas extra</button>
			<button class="btn blue darken-4 mini-btn">Reembolsables</button>
			<button class="btn orange mini-btn">resumen</button>
		</div>

		<!-- panel de contenidos -->
		<div class="mypanel">

			<div id="descripcion" class="font11 nodisplay">
				<?php $this->load->view('ot/forms/info'); ?>
			</div>

			<div class="planeacion">

			</div>

		</div>

		<br>

		<!-- opciones -->
		<div class="btnWindow">
			<button type="button" class="waves-effect waves-light btn" ng-click="guardarOT('<?= site_url('ot/saveOT') ?>')">Guardar</button>
			<button type="button" class="waves-effect waves-light btn grey" ng-click="toggleWindow()">Ocultar</button>
	  	</div>

	</section>
</div>
