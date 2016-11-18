<div style="border:1px solid #AAA; padding:1ex;">
  <h5>Listado de reportes de la orden de trabajo {{ ot.nombre_ot }} </h5>
  <table class="mytabla font12">
    <thead>
      <tr style="background:#EEE">
        <th>No.</th>
        <th>Fecha</th>
        <th>O.T.</th>
        <th>Estado</th>
        <th>Opciones</th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="rd in listaReportes  track by $index ">
        <td ng-bind="rd.no" ng-init="rd.no = $index+1"></td>
        <td ng-bind="rd.fecha_reporte"></td>
        <td ng-bind="rd.nombre_ot"></td>
        <td ng-bind="rd.estado"></td>
        <td> <button type="button" class="btn mini-btn2" data-icon=","> </button></td>
      </tr>
    </tbody>
  </table>
</div>
