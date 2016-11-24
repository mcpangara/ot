
  <div id="ventana_add_items" class="nodisplay ventanaItems">
		<div style="position: relative">
			<button type="button" class="btn green" ng-click="addSelectedItems()" data-icon="">Ok</button>
		</div>

		<table class="mytabla filtered ">
			<thead>
				<tr style="border-top:1px solid #777">
					<th>Selecc.</th>
					<th style="width: 100px">Item</th>
					<th>Descripcion</th>
					<th>Unidad</th>
					<th>Tarifa (V. unid)</th>
          <th>Cant.</th>
          <th>Duración</th>
          <th>Basico/Opcional</th>
          <th>Conv./Legal</th>
				</tr>
			</thead>
			<tbody>
				<tr style="border:1px solid #999">
					<td class="noMaterialStyles">
						<button type="button" ng-click="changeFilterSelect(filtro)" class="btn mini-btn2"> <span data-icon="&#xe04c;"></span> </button>
					</td>
					<td style="width: 102px"> <input style="width: 100px" type="text" ng-model="filtro.itemc_item" placeholder="filtro"/> </td>
					<td> <input type="text" ng-model="filtro.descripcion" placeholder="filtro"/> </td>
					<td> <input type="text" ng-model="filtro.unidad" placeholder="filtro"/> </td>
					<td> </td>
          <td> </td>
          <td> </td>
          <td> </td>
          <td> </td>
				</tr>
				<tr ng-repeat="it in myItems | filter: filtro" >
					<td>
						<input type="checkbox" class="nomaterialstyle" id="add{{it.iditemf}}" ng-model="it.add" />
						<label for="add{{ it.iditemf }}"  ng-click="setSelecteState(it.add)"></label>
					</td>
					<td style="width: 100px" ng-bind="it.itemc_item" ></td>
					<td ng-bind="it.descripcion"></td>
					<td ng-bind="it.unidad"></td>
					<td style="text-align: right" ng-bind="it.tarifa | currency"></td>
          <td> <input type="number" ng-model="it.cantidad" ng-init="it.cantidad = 0" style="width:8ex"> </td>
          <td> <input type="number" ng-model="it.duracion" ng-init="it.duracion = 0" style="width:10ex"> </td>
          <td ng-bind="it.BO"> </td>
          <td ng-bind="it.CL"> </td>
				</tr>
			</tbody>
		</table>

	</div>


	<style type="text/css">
	.mytabla.filtered tr th, .mytabla.filtered tr td{
		height: auto;
		padding: 1px;
	}
	.mytabla.filtered tr td input{
		height: auto;
		line-height: 0;
	}
	</style>
