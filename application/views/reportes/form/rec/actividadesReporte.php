<div class="noMaterialStyles">
  <table class="mytabla">
    <thead>
      <tr style="background: #EEE">
        <th>#</th>
        <th>item</th>
        <th>Descripcion</th>
        <th>Unidad</th>
        <th>Cant. día</th>
        <th>Cant. planeada</th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="act in rd.recursos.actividades track by $index">
        <td>
          <button type="button" class="btn mini-btn2 red" ng-click="delActividadReporte(act)"> x </button>
        </td>
        <td ng-bind="act.itemc_item"></td>
        <td ng-bind="act.descripcion"></td>
        <td ng-bind="act.unidad"></td>
        <td class="inputsSmall"> <input type="number" ng-model="cantidad"> </td>
        <td ng-bind="act.planeado"></td>
    </tbody>
  </table>
</div>

<br>
