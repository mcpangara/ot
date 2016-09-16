<div class="windowCentered2 row">
	<section class="area" ng-controller="addOT">

		<h4 class="center-align light-green darken-3 white-text">Formulario para agregar una Orden de trabajo</h4>

		<div ng-init="getDataForm('<?= site_url('Ot/getDataNewForm') ?>')" class="col s12 row" style="padding:1ex; box-sizing:border-box ; border: 1px solid #aaa">
				<div class="col l4 row">
					<label class="col m4 right-align" ><b>{{ ot.nombre_ot.label }}</b></label>
					<input class="col m7" type="text" ng-model="ot.nombre_ot.data" placeholder="Nombre de la orden de trabajo" />
				</div>
				<div class="col l4 row">
					<label class="col Mm4right-align" ><b>Base:</b></label>
					<select class="col m7" ng-model="ot.base" id="bases">
						<option value=""> Seleccione una base </option>
						<option ng-repeat="base in bases" value="{{ base.idbase }}">{{base.idbase + " - "+ base.nombre_base}}</option>
					</select>
					{{ ot.base }}
				</div>

				<br class="clear-left">
				<hr style="border:1px solid #33c633">
				<br>

				<p style="background: #EFEFEF" class="col s12">
					<big>Formulario de Información general:</big>
					<button id="btn_ot_data" class="btn mini-btn" type="button" ng-click="openSection('#ot_data', '#btn_ot_data')">
						<span class="displayinline" data-icon='&#xe029;'></span>
						<span class="nodisplay" data-icon='&#xe026;'></span>
					</button>
				</p>

				<div id="ot_data" style="margin-top:2px; border:1px solid #EFEFEF; padding:1ex;" class="nodisplay col s12 row">
					<?php $this->load->view('ot/add/info_addOT') ?>
				</div>

				<p style="background: #EFEFEF" class="col s12">
					<big>Items de la OT:</big>
					<button id="btn_tarea_ot" class="btn mini-btn" type="button" ng-click="openSection('#tarea_ot', '#btn_tarea_ot')">
						<span class="displayinline" data-icon='&#xe029;'></span>
						<span class="nodisplay" data-icon='&#xe026;'></span>
					</button>
				</p>

				<div id="tarea_ot" style="margin-top:2px; border:1px solid #EFEFEF" class="nodisplay col s12 row">
					<?php $this->load->view('ot/add/tarea_addOT', array("tarifagv"=>$tarifagv)) ?>
				</div>
		</div>

		<div class="btnWindow">
			<button type="button" class="waves-effect waves-light btn" ng-click="guardarOT('<?= site_url('ot/saveOT') ?>')">Guardar</button>
			<button type="button" class="waves-effect waves-light btn red" ng-click="cerrarWindow()">Cerrar</button>
			<button type="button" class="waves-effect waves-light btn grey" ng-click="toggleWindow()">Ocultar</button>
	  </div>

	</section>
</div>
