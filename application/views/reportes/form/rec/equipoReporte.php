<div class="noMaterialStyles">
  <table class="mytabla">
    <thead style="background: #EEE">
      <tr>
        <th rowspan="2"></th>

        <th rowspan="2">Item</th>
        <th rowspan="2">Codigo</th>
        <th rowspan="2">Ref./AF</th>
        <th rowspan="2">Equipo</th>
        <th rowspan="2">Operador / Conductor</th>
        <th rowspan="2">Cant.</th>
        <th rowspan="2">B/O</th>
        <th rowspan="2">UND</th>
        <th colspan="2">Horometro</th>
        <th colspan="3">Reporte horas</th>
      </tr>
      <tr>
        <th>Inicial</th>
        <th>Final</th>

        <th>OPER.</th>
        <th>DISP.</th>
        <th>VAR.</th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="eq in rd.recursos.equipos track by $index">
        <td> <button type="button" class="btn mini-btn2 red" ng-click="delEquipoReporte(eq)"> x </button> </td>

        <td> <a ng-bind="eq.itemc_item" ng-click="mensaje(eq.descripcion)" href="#" /> </td>
        <td ng-bind="eq.codigo_siesa"></td>
        <td ng-bind="eq.referencia"></td>
        <td ng-bind="eq.descripcion_equipo"></td>
        <td> <input type="text" style="width:90%" ng-model="eq.nombre_operador"> </td>
        <td class="inputsSmall"> <input type="number" ng-model="eq.cantidad"> </td>
        <td class="inputsSmall noMaterialStyles">
          <select class="" ng-model="eq.tipo_equipo">
            <option value="B">B</option>
            <option value="O">O</option>
          </select>
        </td>
        <td class="inputsSmall"> <input type="text" ng-model="eq.unidad"> </td>

        <td class="inputsSmall"> <input type="text" ng-model="eq.horo_inicio"> </td>
        <td class="inputsSmall"> <input type="text" ng-model="eq.horo_fin"> </td>

        <td class="inputsSmall"> <input type="number" ng-model="eq.horas_oper"> </td>
        <td class="inputsSmall"> <input type="number" ng-model="eq.horas_disp"> </td>
        <td class="inputsSmall noMaterialStyles"> <input type="checkbox" ng-model="eq.varado"> </td>
      </tr>
    </tbody>
  </table>
</div>

<br>
