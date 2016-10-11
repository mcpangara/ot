<section class="">
	<?php $this->load->view('ot/add/windowItems') ?>

	<p >
		<button type="button" ng-click="VwITems(1)" class="btn green mini-btn" data-icon="&#xe052;"> Actividades</button>
		<button type="button" ng-click="VwITems(2)" class="btn green mini-btn" data-icon="&#xe052;"> Personal</button>
		<button type="button" ng-click="VwITems(3)" class="btn green mini-btn" data-icon="&#xe052;"> Equipo</button>
	</p>

	<div>
		<label class="col m1 right-align"><b>{{tr.fecha_inicio.label}}</b></label>
		<input type="text" class="datepicker" ng-init="datepicker_init()" ng-model="tr.fecha_inicio" placeholder=" fecha" style="cursor: pointer" readonly/>
	</div>
	<div>
		<label class="col m1 right-align"><b>{{tr.fecha_fin.label}}</b></label>
		<input type="text" class="datepicker" ng-init="datepicker_init()" ng-model="tr.fecha_fin" placeholder=" fecha" style="cursor: pointer"  readonly/>
	</div>

	<div class="col s12 overflowAuto">
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
				<tr ng-repeat="act in tr.actividades">
					<td>{{ act.itemc_item }}</td>
					<td>{{ act.descripcion }}</td>
					<td>{{ act.unidad }}</td>
					<td> <input type="number" ng-model="act.cantidad" ng-init="act.cantidad = strtonum(act.cantidad)" style="width:7ex" ng-change="calcularSubtotales()"> </td>
					<td> <input type="number" ng-model="act.duracion" ng-init="act.duracion = strtonum(act.duracion)" style="width:10ex" ng-change="calcularSubtotales()"> </td>
					<td style="text-align: right">{{ act.tarifa | currency:'$':0}}</td>
					<td style="text-align: right">
						{{ (act.cantidad * act.duracion)*act.tarifa | currency:'$':0  }}
						<button type="button" ng-click="unset_item(tr.actividades, act)" class="btn red mini-btn2"> x </button></td>
					<td>{{ act.fecha_agregado }}</td>
				</tr>
				<tr>
					<th colspan="8" rowspan="" style="background:#ddedd0">PERSONAL</th>
				</tr>
				<tr ng-repeat="per in tr.personal">
					<td>{{ per.itemc_item }}</td>
					<td>{{ per.descripcion }}</td>
					<td>{{ per.unidad }}</td>
					<td><input type="number" ng-model="per.cantidad" ng-init="per.cantidad = strtonum(per.cantidad)" style="width:7ex" ng-change="calcularSubtotales()"> </td>
					<td><input type="number" ng-model="per.duracion" ng-init="per.duracion = strtonum(per.duracion)" style="width:10ex" ng-change="calcularSubtotales()"> </td>
					<td style="text-align: right">{{ per.tarifa | currency:'$':0 }}</td>
					<td style="text-align: right">
						{{ (per.cantidad * per.duracion)*per.tarifa | currency:'$':0  }}
						<button type="button" ng-click="unset_item(tr.personal, per)" class="btn red mini-btn2"> x </button>
					</td>
					<td>{{ per.fecha_agregado }}</td>
				</tr>
				<tr>
					<th colspan="8" rowspan="" style="background:#ddedd0">EQUIPOS</th>
				</tr>
				<tr ng-repeat="eq in tr.equipos">
					<td>{{ eq.itemc_item }}</td>
					<td>{{ eq.descripcion }}</td>
					<td>{{ eq.unidad }}</td>
					<td> <input type="number" ng-model="eq.cantidad" ng-init="eq.cantidad = strtonum(eq.cantidad)" style="width:7ex" ng-change="calcularSubtotales()"> </td>
					<td> <input type="number" ng-model="eq.duracion" ng-init="eq.duracion = strtonum(eq.duracion)" style="width:10ex" ng-change="calcularSubtotales()"> </td>
					<td style="text-align: right">{{ eq.tarifa | currency:'$':0 }}</td>
					<td style="text-align: right">
						{{ (eq.cantidad * eq.duracion)*eq.tarifa | currency:'$':0 }} 
						<button type="button" ng-click="unset_item(tr.equipos, eq)" class="btn red mini-btn2"> x </button></td>
					<td>{{ eq.fecha_agregado }}</td>
				</tr>
				<tr>
					<td colspan="6" rowspan="" style="text-align: right">Sutotal de recursos: </td>
					<td colspan="2" rowspan="" headers=""><b>{{ (tr.eqsubtotal+tr.actsubtotal+tr.persubtotal) | currency:'$':0 }}</b></td>
				</tr>
			</tbody>
		</table>
	</div>

</section>