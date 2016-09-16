      <div id="calendario" ng-controller="calendar" >
        <table ng-init="getMyReportes('<?= site_url('ot/getMyReportes') ?>')">
          <thead>
            <tr>
              <th class="textcenter" colspan="7" style="width:auto; height: auto; padding:5px;">
                <div class="">
                TERMOTECNCIA COINDUSTRIAL S.A.S. - Calendario de reportes 
                </div>
                <button type="button" class="btn mini-btn" ng-click="changeYear('back')"> << </button>
                {{ year }}
                <button type="button" class="btn mini-btn" ng-click="changeYear('next')"> >> </button>
              </th>
            </tr>
            <tr>
              <th colspan="7" class="textcenter" style="width:auto; height: auto; padding:5px;">
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
              <td ng-repeat="d in week" class="{{d.clase +' '+ d.activo}}"> <a href="#" ng-click="clickeableLink('<?= site_url() ?>/'+d.enlace, $event, 'Reporte')">{{d.dia}}</a></td>
            </tr>
          </tbody>
        </table>
      </div>
