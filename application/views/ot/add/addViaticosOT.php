
	<section id="addViaticosOT" class="ventanaItems nodisplay">
		<div class="">
			<big>CALCULO DE VIATICOS: </big>
			<button type="button" class="btn mini-btn2" ng-click="calcularViaticos(tr)" name="button"> Finalizar </button>
		</div>
		<br>
		<div style="height:90%; overflow: auto;">
			<table class="mytabla" style="width:100%; border-right:1px solid #999;">
				<thead>
					<tr>
						<th>Item</th>
						<th>Descripción</th>
						<th>Destino</th>
						<th>cant.</th>
						<th>Dias</th>
						<th>Alojamiento</th>
						<th>Alimientación</th>
						<th>Transporte</th>
						<th>Miscelanios</th>
						<th> total </th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="itv in itemsViaticos">
						<td>{{itv.itemc_item}}</td>
						<td>{{itv.descripcion}}</td>
						<td>
							<select name="itv" ng-model="itv.destino" ng-change="applyViatico(itv, '<?= site_url('miscelanio/getTarifaGV') ?>')">
								<?php foreach ($tarifagv->result() as $tarf): ?>
									<option value="<?= $tarf->idtarifa_gv ?>"><?= $tarf->destino ?></option>
								<?php endforeach; ?>
							</select>
						</td>
						<td> <input type="number" ng-model="itv.cantidad_gv" style="width:7ex" name="name" value=""> </td>
						<td> <input type="number" ng-model="itv.duracion_gv" style="width:7ex" name="name" value=""> </td>
						<td> <input type="number" ng-model="itv.alojamiento" value=""> {{ itv.alojamiento | currency:'$':0 }}</td>
						<td> <input type="number" ng-model="itv.alimentacion" value="">{{ itv.alimentacion | currency:'$':0 }}</td>
						<td> <input type="number" ng-model="itv.transporte" value="">{{ itv.transporte | currency:'$':0 }}</td>
						<td> <input type="number" ng-model="itv.miscelanios" value=""> {{ itv.miscelanios | currency:'$':0 }}</td>
						<td>{{ ( (itv.alojamiento + itv.transporte + itv.alimentacion + itv.miscelanios) * (itv.cantidad_gv * itv.duracion_gv) * 1.6196) | currency:'$':0 }}</td>
					</tr>
					<tr>
						<td colspan="10">
							Total G.V.: {{ viaticos | currency:'$':0 }}
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</section>
