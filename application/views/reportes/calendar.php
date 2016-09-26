<div id="calendario" ng-controller="calendar" >
  <style media="screen">
    #calendario tr > td{
      color:red;
    }
  </style>
  <table ng-init="getMyReportes('<?= site_url('ot/getMyReportes') ?>')">
    <thead>
      <tr>
        <th class="textcenter" colspan="7" style="width:auto; height: auto; padding:5px;">
          <button type="button" class="btn mini-btn" ng-click="changeYear('back')"> << </button>
          {{ year }}
          <button type="button" class="btn mini-btn" ng-click="changeYear('next')"> >> </button>
          &nbsp;
          <button type="button" class="btn mini-btn" ng-click="changeMonth('back')"> << </button>
          {{ month }}
          <button type="button" class="btn mini-btn" ng-click="changeMonth('next')"> >> </button>
        </th>
      </tr>
      <tr>
        <th>Domingo</th>
        <th>Lunes</th>
        <th>Martes</th>
        <th>Miercoles</th>
        <th>Jueves</th>
        <th>Viernes</th>
        <th>Sabado</th>
      </tr>
    </thead>
    <tbody>
      <tr ng-repeat="week in semanas">
        <td ng-repeat="d in week" class="{{d.clase +' '+ d.activo}}"> <a ng-if="d.clase == 'dia' || d.clase == 'dia activo'" href="#" ng-click="seleccionarFecha(d.dia, d.mes+1, year, undefined, $event)">{{d.dia}}</a> </td>
      </tr>
    </tbody>
  </table>
</div>
