<div class="">
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
      <tr ng-repeat="act in actividadesReporte track by $index">
        <td>
          <button type="button" class="btn mini-btn2 red" ng-click="delActividadReporte(act)"> x </button>
        </td>
        <td ng-bind="act.itemc_item"></td>
        <td ng-bind="act.descripcion"></td>
        <td ng-bind="act.unidad"></td>
        <td> <input type="number" ng-model="cantidad_dia"> </td>
        <td ng-bind="act.planeado"></td>
    </tbody>
  </table>
</div>

<br>