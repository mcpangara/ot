
	<section id="addViaticosOT" class="ventanaItems nodisplay">
		<div class="">
			<big>CALCULO DE GASTOS DE VIAJE: </big>
			<button type="button" class="btn mini-btn2" ng-click="calcularViaticos(tr)" name="button"> Finalizar </button>

			<button type="button" class="btn mini-btn2 orange" ng-click="reiniciarViaticos(tr)" name="button"> Finalizar </button>
		</div>
		<br>
		<div style="height:90%; overflow: auto;">
			<table class="mytabla" style="width:100%; border-right:1px solid #999;">
				<thead>
					<tr>
						<th></th>
						<th>Item</th>
						<th>Descripción</th>
						<th>Destino</th>
						<th>cant.</th>
						<th>Dias</th>
						<th>Alojamiento</th>
						<th>Alimientación</th>
						<th>Transporte</th>
						<th>Miscelanios</th>
						<th> Incidencia </th>
						<th> total </th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="itv in tr.json_viaticos.json_viaticos">
						<td>
							<button type="button" class="btn red mini-btn2" ng-click="unset_elemt(tr.json_viaticos.json_viaticos, item)" >x</button>
						</td>
						<td>{{itv.itemc_item}}</td>
						<td>{{itv.descripcion}}</td>
						<td>
							<select name="itv" ng-model="itv.destino" ng-change="applyViatico(itv, '<?= site_url('miscelanio/getTarifaGV') ?>')">
								<?php foreach ($tarifagv->result() as $tarf): ?>
									<option value="<?= $tarf->idtarifa_gv ?>"><?= $tarf->destino ?></option>
								<?php endforeach; ?>
							</select>
						</td>
						<td> <input type="number" ng-model="itv.cantidad_gv" ng-change="itv.cantidad_gv = strtonum(itv.cantidad_gv)" style="width:7ex" name="name" value=""> </td>
						<td> <input type="number" ng-model="itv.duracion_gv" ng-change="itv.duracion_gv = strtonum(itv.duracion_gv)" style="width:7ex" name="name" value=""> </td>
						<td> <input type="number" ng-model="itv.alojamiento" ng-change="itv.alojamiento = strtonum(itv.alojamiento)" value=""> {{ itv.alojamiento | currency:'$':0 }}</td>
						<td> <input type="number" ng-model="itv.alimentacion" ng-change="itv.alimentacion = strtonum(itv.alimentacion)" value="">{{ itv.alimentacion | currency:'$':0 }}</td>
						<td> <input type="number" ng-model="itv.transporte" ng-change="itv.transporte = strtonum(itv.transporte)" value="">{{ itv.transporte | currency:'$':0 }}</td>
						<td> <input type="number" ng-model="itv.miscelanios" ng-change="itv.miscelanios = strtonum(itv.miscelanios)" value=""> {{ itv.miscelanios | currency:'$':0 }}</td>
						<td>
							<input type="text" style="width:7ex" ng-model="itv.incidencia" ng-init="itv.incidencia = getIncidencia(itv) "  disabled="">
						</td>
						<td> {{ ( (itv.alojamiento + itv.transporte + itv.alimentacion + itv.miscelanios) * (itv.cantidad_gv * itv.duracion_gv) * strtonum(itv.incidencia) ) | currency:'$':0 }}</td>
					</tr>
					<tr>
						<td colspan="11">
							Total G.V.: {{ tr.json_viaticos.valor_viaticos | currency:'$':0 }}
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</section>
