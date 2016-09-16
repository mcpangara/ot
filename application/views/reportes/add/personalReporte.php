<div class="">
  <table class="mytabla">
    <thead>
      <tr style="background: #EEE">
        <th></th>
        <th>identificacion</th>
        <th>Nombre Completo</th>
        <th style="max-width: 4ex">Hr. Ini.</th>
        <th style="max-width: 4ex">Hr. fin</th>
        <th style="max-width: 4ex">Horas dia</th>
        <th style="max-width: 4ex">Recargo Nc.</th>
        <th style="max-width: 4ex">H.E.D.</th>
        <th style="max-width: 4ex">H.E.N.</th>
        <th>Rango de horas</th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="pr in personalReporte track by $index">
        <td>
          <button type="button" class="btn mini-btn2 red" ng-click="delPersonaReporte(pr)"> x </button>
        </td>
        <td ng-bind="pr.identificacion"></td>
        <td ng-bind="pr.nombre_completo"></td>
        <td> <b ng-bind="pr.hora_inicio"></b> Hrs. </td>
        <td> <b ng-bind="pr.hora_fin"></b>  Hrs.</td>
        <td class="inputsSmall"> <input type="number" ng-model="pr.horas_dia"> </td>
        <td class="inputsSmall"> <input type="number" ng-model="pr.horas_rn"> </td>
        <td class="inputsSmall"> <input type="number" ng-model="pr.horas_hed"> </td>
        <td class="inputsSmall"> <input type="number" ng-model="pr.horas_hen"> </td>
        <td>
          <input type="text" id="test" class="testRango" ng-init="sliderRango('.testRango', pr)" />
        </td>
      </tr>
    </tbody>
  </table>
</div>

<br>
