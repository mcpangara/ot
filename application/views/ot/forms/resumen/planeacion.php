<section class="">
	<div class="col s12 overflowAuto" style="padding:0px">
		<table class="mytabla largWidth">
			<thead>
				<tr>
					<th>Codigo</th>
					<th>Descripción</th>
					<th>Unidad</th>
					<th>Cantidad</th>
					<th>Duración</th>
					<th>Valor Und.</th>
					<th>Valor calc.</th>
					<th>Agregado</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th colspan="8" rowspan="" style="background:#ddedd0">ACTIVIDADES DE MTTO.</th>
				</tr>
				<tr ng-repeat="act in mytr.actividades">
					<td>{{ act.itemc_item }}</td>
					<td>{{ act.descripcion }}</td>
					<td>{{ act.unidad }}</td>
					<td ng-bind="act.cantidad" ng-init="act.cantidad = strtonum(act.cantidad)" > </td>
					<td ng-bind="act.duracion" ng-init="act.duracion = strtonum(act.duracion)" > </td>
					<td style="text-align: right">{{ act.tarifa | currency:'$':0}}</td>
					<td style="text-align: right">
						{{ (act.cantidad * act.duracion)*act.tarifa | currency:'$':0  }}
					<td>{{ act.fecha_agregado }}</td>
				</tr>
				<tr>
					<th colspan="8" rowspan="" style="background:#ddedd0">PERSONAL</th>
				</tr>
				<tr ng-repeat="per in mytr.personal">
					<td>{{ per.itemc_item }}</td>
					<td>{{ per.descripcion }}</td>
					<td>{{ per.unidad }}</td>
					<td ng-model="per.cantidad" ng-init="per.cantidad = strtonum(per.cantidad)"> </td>
					<td ng-model="per.duracion" ng-init="per.duracion = strtonum(per.duracion)"> </td>
					<td style="text-align: right">{{ per.tarifa | currency:'$':0 }}</td>
					<td style="text-align: right">
						{{ (per.cantidad * per.duracion)*per.tarifa | currency:'$':0  }}
					</td>
					<td>{{ per.fecha_agregado }}</td>
				</tr>
				<tr>
					<th colspan="8" rowspan="" style="background:#ddedd0">EQUIPOS</th>
				</tr>
				<tr ng-repeat="eq in mytr.equipos">
					<td>{{ eq.itemc_item }}</td>
					<td>{{ eq.descripcion }}</td>
					<td>{{ eq.unidad }}</td>
					<td ng-bind="eq.cantidad" ng-init="eq.cantidad = strtonum(eq.cantidad)" > </td>
					<td ng-bind="eq.duracion" ng-init="eq.duracion = strtonum(eq.duracion)" > </td>
					<td style="text-align: right">{{ eq.tarifa | currency:'$':0 }}</td>
					<td style="text-align: right">
						{{ (eq.cantidad * eq.duracion)*eq.tarifa | currency:'$':0 }}
					<td>{{ eq.fecha_agregado }}</td>
				</tr>
				<tr>
					<td colspan="6" rowspan="" style="text-align: right">Sutotal de recursos: </td>
					<td colspan="2" rowspan="" headers=""><big><b>{{ (mytr.eqsubtotal+mytr.actsubtotal+mytr.persubtotal) | currency:'$':0 }}</b></big></td>
				</tr>
			</tbody>
		</table>
	</div>

</section>
