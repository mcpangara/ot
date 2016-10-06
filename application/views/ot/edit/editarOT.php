<div class="windowCentered2 row" ng-controller="OT">
	<section class="area" ng-controller="editarOT">

		<div class="btnWindow">
		    <h5 ng-init="getData('<?= site_url('ot/getData/'.$idot) ?>')">
				<img class="logo" src="<?= base_url("assets/img/termotecnica.png") ?>" width="80px" />
				<?= $titulo_gestion ?>
			</h5>
	    </div>

		<!-- Información de la básica OT -->
		<table class="mytabla" ng-init="getItemsBy('<?= site_url('Ot/getDataNewForm') ?>')">
			<thead>
				<tr style="background: #3A4B52; color: #FFF">
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
					<td ng-bind="ot.nombre_ot"></td>
					<td ng-bind="ot.base_idbase"></td>
					<td ng-bind="ot.zona"></td>
					<td ng-bind="ot.nombre_especialidad"></td>
					<td ng-bind="ot.nombre_tipo_ot"></td>
					<td> pendiente </td>
				</tr>
			</tbody>
		</table>
		<!-- Panel de opciones -->
		<style type="text/css">
			.inset{
				box-shadow: inset 0px 0px 5px #AAA;
			}
			.mypanel{
				border: 1px solid #AAA;
				padding: 3px;
				margin-bottom: 5px;
				max-height: 450px;
				overflow: auto;
			}
			.mybtn{
				background: #346EB2;
				color: #FFF;
				border:1px solid #999;
			}
		</style>

		<div class="row mypanel">
			<!-- seleccion de tarea -->
			<div class="noMaterialStyles">
				<label>Tarea:</label>
				<select>
					<option>Tarea1</option>
				</select>
			</div>

			<br>
			<button class="btn blue mini-btn" ng-click="toggleContent('#descripcion', 'nodisplay', undefined)">Descripción</button>
			<button class="btn blue darken-4 mini-btn" ng-click="toggleContent()">Planeación</button>
			<button class="btn blue darken-4 mini-btn" ng-click="toggleContent()">Gastos de viaje</button>
			<button class="btn blue darken-4 mini-btn" ng-click="toggleContent()">horas extra</button>
			<button class="btn blue darken-4 mini-btn" ng-click="toggleContent()">Reembolsables</button>
			<button class="btn blue darken-4 orange mini-btn" ng-click="toggleContent()">resumen</button>
		</div>

		<!-- panel de contenidos -->
		<div class="mypanel inset">

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
			<button type="button" class="waves-effect waves-light btn red" ng-click="cerrarWindow()">Cerrar</button>
			<button type="button" class="waves-effect waves-light btn grey" ng-click="toggleWindow()">Ocultar</button>
	  	</div>

	</section>
</div>
