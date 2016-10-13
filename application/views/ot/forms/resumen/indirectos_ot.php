<div class="row col s12" style="padding:0">

	<div id="" class="col l3 s12" style="padding:2px; box-sizing: border-box;" >
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
						<td> {{ setTareaAdministracion( (mytr.eqsubtotal+mytr.actsubtotal+mytr.persubtotal) * 0.18, tr) | currency:'$':0 }} </td>
					</tr>
					<tr>
						<td> Imprevistos (1%): </td>
						<td> {{ setTareaImprevistos( (mytr.eqsubtotal+mytr.actsubtotal+mytr.persubtotal) * 0.01, tr ) | currency:'$':0 }} </td>
					</tr>
					<tr>
						<td> Utilidad (4%): </td>
						<td>{{ setTareaUtilidad( (mytr.eqsubtotal+mytr.actsubtotal+mytr.persubtotal) * 0.04, tr ) | currency:'$':0 }} </td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="col l3 s12" style="padding:2px; box-sizing: border-box;" >
		<table class="mytabla">
			<thead>
				<tr>
					<td colspan="2">
						<b>Viaticos:</b>
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Viaticos:</td>
					<td> {{ mytr.json_viaticos.valor_viaticos | currency:'$':0 }} </td>
				</tr>
				<tr>
					<td>Administración (4.58%):</td>
					<td> {{ mytr.json_viaticos.administracion | currency:'$':0 }} </td>
				</tr>
			</tbody>
		</table>
	</div>

	<div id="" class="col l3 s12" style="padding:2px; box-sizing: border-box;" >

		<table class="mytabla">
			<thead>
				<tr>
					<td colspan="2">
						<b>Reembolsables:</b>
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td> Gastos Reembolsables:</td>
					<td> {{ mytr.json_reembolsables.valor_reembolsables | currency:'$':0 }} </td>
				</tr>
				<tr>
					<td>Administración (1%):</td>
					<td> {{ mytr.json_reembolsables.valor_reembolsables * 0.01 | currency:'$':0 }} </td>
				</tr>
			</tbody>
		</table>
	</div>

	<div id="" class="col l3 s12" style="padding:2px; box-sizing: border-box;" >

		<table class="mytabla">
			<thead>
				<tr>
					<td colspan="2">
						<b>Horas extra y raciones:</b>
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td> Horas Extra:</td>
					<td> {{ mytr.json_horas_extra.valor_horas_extra | currency:'$':0 }} </td>
				</tr>
				<tr>
					<td> Raciones:</td>
					<td>
						<div class="">
							cant: <input type="text" ng-model="mytr.json_horas_extra.raciones_cantidad"> <small> {{ mytr.json_horas_extra.raciones_cantidad | currency :'$':0 }} </small>
						</div>
						<div class="">
							 Valor Und: <input type="text" ng-model="mytr.json_horas_extra.raciones_valor_und" value=""> <small> {{ mytr.json_horas_extra.raciones_valor_und | currency:'$':0 }} </small>
						</div>
						<b>Total raciones: {{ (mytr.json_horas_extra.raciones_cantidad * mytr.json_horas_extra.raciones_valor_und) | currency:'$':0 }}</b>
					</td>
				</tr>
				<tr>
					<td>Administración (1%):</td>
					<td> {{ (mytr.json_horas_extra.valor_horas_extra + (mytr.json_horas_extra.raciones_cantidad * mytr.json_horas_extra.raciones_valor_und)) * 0.01 | currency:'$':0 }} </td>
				</tr>
			</tbody>
		</table>
	</div>
	<h4>{{ mytr.valor_tarea_ot}}</h4>
</div>
