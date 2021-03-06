
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
						<button type="button" ng-click="changeFilterSelect(filtroItems)" class="btn mini-btn2"> <span data-icon="&#xe04c;"></span> </button>
					</td>
					<td style="width: 102px"> <input style="width: 100px" type="text" ng-model="filtroItems.itemc_item" placeholder="filtroItems"/> </td>
					<td> <input type="text" ng-model="filtroItems.descripcion" placeholder="filtroItems"/> </td>
					<td> <input type="text" ng-model="filtroItems.unidad" placeholder="filtroItems"/> </td>
					<td> </td>
          <td> </td>
          <td> </td>
          <td> </td>
          <td> </td>
				</tr>
				<tr ng-repeat="it in myItems | filter: filtroItems" >
					<td class="noMaterialStyles">
						<input type="checkbox" ng-model="it.add" ng-click="setSelecteState(it.add)" />
					</td>
					<td style="width: 100px" ng-bind="it.itemc_item" ></td>
					<td ng-bind="it.descripcion"></td>
					<td ng-bind="it.unidad"></td>
					<td style="text-align: right" ng-bind="it.tarifa | currency"></td>
          <td> <input type="number" style="border: 1px solid #E65100; width:8ex"  ng-model="it.cantidad" ng-init="it.cantidad = 0" min="0"> </td>
          <td> <input type="number" style="border: 1px solid #E65100; width:10ex"  ng-model="it.duracion" ng-init="it.duracion = 0" min="0"> </td>
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
		line-height: 0;
	}
	</style>
