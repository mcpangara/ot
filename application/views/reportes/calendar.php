<div id="calendario">
  <h6>Agregar reporte nuevo:</h6>

  <style media="screen">
    #calendario tr > td{
      color:red;
    }
  </style>
  <table>
    <thead>
      <tr>
        <th class="textcenter" colspan="7" style="width:auto; height: auto; padding:5px;">
          <button type="button" class="btn mini-btn" ng-click="changeYear('back')"> << </button>
          {{ year }}
          <button type="button" class="btn mini-btn" ng-click="changeYear('next')"> >> </button>
        </th>
      </tr>
      <tr>
        <th colspan="7">
          <button type="button" class="btn mini-btn" ng-click="changeMonth('back')"> << </button>
          {{ month }}
          <button type="button" class="btn mini-btn" ng-click="changeMonth('next')"> >> </button>
        </th>
      </tr>
      <tr>
        <th>Do</th>
        <th>Lu</th>
        <th>Ma</th>
        <th>Mie</th>
        <th>Ju</th>
        <th>Vi</th>
        <th>Sa</th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="week in semanas">
        <td ng-repeat="d in week" class="{{d.clase +' '+ d.activo + ' '+ d.clase2}}">
          <a ng-if="d.clase == 'dia' || d.clase == 'dia activo'" href="#"
            ng-click="seleccionarFecha(d, d.mes+1, year, '<?= site_url('reporte/add') ?>', $event)">
            {{d.dia}}
          </a>
        </td>
      </tr>
    </tbody>
  </table>
</div>
