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
					<th>C.C. ECP</th>
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
					<td ng-bind="ot.cc_ecp">
					</td>
					<td> pendiente </td>
				</tr>
				<tr>
					<td>
						Centro Costo termotecnica:
					</td>
					<td>
						<input type="text" ng-model="ot.ccosto">
					</td>
					</td>
					<td colspan="5">

					</td>
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
				overflow: auto;
			}
			.mybtn{
				background: #FFF;
				color: #111;
				border:1px solid #555;
			}
		</style>

		<div class="row">
			<br>
			<!-- seleccion de tarea -->
			<div class="noMaterialStyles">
				<label>Selecciona una Tarea:</label>
				<select id="selected_tarea" ng-model="selected_tarea" ng-init="selected_tarea = '0'" ng-change="selectTarea(ot, selected_tarea)">
					<option ng-repeat="tar in ot.tareas track by $index" value="{{$index}}" ng-init="selectTarea(ot, 0)">{{tar.nombre_tarea}}</option>
				</select>
				<button class="btn mini-btn" style="margin-top: 0" data-icon="&#xe052;" ng-click="addTarea()"></button>
				&nbsp;
				<a href="<?= site_url('ot/imprimirOT') ?>/{{ot.idOT +'/'+ tr.idtarea_ot}}" class="btn mini-btn orange black-text"  style="margin-top: 0" data-icon=";"></a>
			</div>

			<button class="btn blue mini-btn" ng-click="toggleContent('#descripcion', 'nodisplay', '.mypanel > div')">Descripción</button>
			<button class="btn blue darken-4 mini-btn" ng-click="toggleContent('#planeacion', 'nodisplay', '.mypanel > div')">Planeación</button>
			<button class="btn blue darken-4 mini-btn" ng-click="toggleContent('#indirectos_ot', 'nodisplay', '.mypanel > div')">G.V. / H.E / Otros</button>
			<button class="btn blue darken-4 mini-btn" ng-click="toggleContent('#general', 'nodisplay', '.mypanel > div')">General</button>
			<button class="btn blue darken-4 orange mini-btn" ng-click="toggleContent('#resumen', 'nodisplay', '.mypanel > div')">resumen</button>
		</div>

		<!-- panel de contenidos -->
		<div class="mypanel inset">

			<div id="descripcion" class="font12 nodisplay">
				<?php $this->load->view('ot/forms/info'); ?>
			</div>

			<div id="planeacion" class="font12 nodisplay">
				<?php $this->load->view('ot/forms/planeacion') ?>
			</div>

			<div id="indirectos_ot" class="font12 nodisplay">
				<?php $this->load->view('ot/forms/indirectos_ot') ?>
			</div>

			<div id="general" class="font12 nodisplay">
				<?php $this->load->view('ot/forms/resumen') ?>
			</div>

		</div>
		<br>

		<!-- opciones -->
		<div class="btnWindow">
			<button type="button" class="waves-effect waves-light btn" ng-click="guardarOT('<?= site_url('ot/update') ?>')">Guardar</button>
			<button type="button" class="waves-effect waves-light btn red" ng-click="cerrarWindow()">Cerrar</button>
			<button type="button" class="waves-effect waves-light btn grey" ng-click="toggleWindow()">Ocultar</button>
	  </div>

	</section>
</div>
