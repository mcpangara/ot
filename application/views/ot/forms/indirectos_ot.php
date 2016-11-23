<?php $this->load->view('ot/add/addViaticosOT') ?>
<?php $this->load->view('ot/add/addReembolsables') ?>
<?php $this->load->view('ot/add/addHorasExtra') ?>
<div class="row col s12">

	<div id="" class="col l4 s12" style="padding:2px" >
		<div class="">
			<table class="mytabla">
				<thead>
					<tr>
						<td colspan="2"> <b>Indirectos:</b> </td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td> Administración (18%): </td>
						<td> <span ng-bind="tr.json_indirectos.administracion | currency:'$':0 "></span></td>
					</tr>
					<tr>
						<td> Imprevistos (1%): </td>
						<td> <span ng-bind="tr.json_indirectos.imprevistos | currency:'$':0 "></span></td>
					</tr>
					<tr>
						<td> Utilidad (4%): </td>
						<td> <span ng-bind="tr.json_indirectos.utilidad | currency:'$':0 "></span> </td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="col l4 s12" style="padding:2px" >
		<table class="mytabla">
			<thead>
				<tr>
					<td colspan="2">
						<b>Viaticos:</b>
						<button type="button" ng-click="setViaticos('#addViaticosOT', tr)" class="btn brown lighten-1 mini-btn2" name="button">Calcular</button>
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Viaticos:</td>
					<td> {{ tr.json_viaticos.valor_viaticos | currency:'$':0 }} </td>
				</tr>
				<tr>
					<td>Administración (4.58%):</td>
					<td> {{ tr.json_viaticos.administracion | currency:'$':0 }} </td>
				</tr>
			</tbody>
		</table>
	</div>

	<div id="" class="col l4 s12" style="padding:2px" >

		<table class="mytabla">
			<thead>
				<tr>
					<td colspan="2">
						<b>Reembolsables:</b>
						<button type="button" ng-click="setReembolsables('#reembolsablesOT', tr)" class="btn brown lighten-1 mini-btn2" name="button">Calcular</button>
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td> Gastos Reembolsables:</td>
					<td> {{ tr.json_reembolsables.valor_reembolsables | currency:'$':0 }} </td>
				</tr>
				<tr>
					<td>Administración (4.58%):</td>
					<td> {{ tr.json_reembolsables.valor_reembolsables * 0.0458 | currency:'$':0 }} </td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="clear-left"></div>

	<div id="" class="col l4 s12" style="padding:2px" >

		<table class="mytabla">
			<thead>
				<tr>
					<td colspan="2">
						<b>Horas extra y raciones:</b>
						<button type="button" ng-click="setHorasExtra('#addHorasExtra', tr)" class="btn brown lighten-1 mini-btn2" name="button">Calcular</button>
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td> Horas Extra:</td>
					<td> {{ tr.json_horas_extra.valor_horas_extra | currency:'$':0 }} </td>
				</tr>
				<tr>
					<td> Raciones:</td>
					<td>
						<div class="">
							cant: <input type="text" ng-model="tr.json_horas_extra.raciones_cantidad"> <small> {{ tr.json_horas_extra.raciones_cantidad | currency :'$':0 }} </small>
						</div>
						<div class="">
							 Valor Und: <input type="text" ng-model="tr.json_horas_extra.raciones_valor_und" value=""> <small> {{ tr.json_horas_extra.raciones_valor_und | currency:'$':0 }} </small>
						</div>
						<b>Total raciones: {{ (tr.json_horas_extra.raciones_cantidad * tr.json_horas_extra.raciones_valor_und) | currency:'$':0 }}</b>
					</td>
				</tr>
				<tr>
					<td>Administración (1%):</td>
					<td> {{ tr.json_horas_extra.administracion | currency:'$':0 }} </td>
				</tr>
			</tbody>
		</table>
	</div>

	<div class="col s12 l12 m12">
		<h5>Valor tarea: {{ tr.valor_tarea_ot | currency:'$':0}}</h5>
	</div>
</div>
