<div class="" ng-controller="listOTReportes">

  <div class="row">
    <h4 class="center-align">Manejo de reportes diarios:</h4>
    <fieldset style="padding:1ex;">
      <div class="col l12">

          <div class="noMaterialStyles row col l6">
            <b class="col s5">Centro de operacion:</b>
            <select ng-model="consulta.base" class="col s5" ng-init="initBase('<?= site_url('ot/getByBase/') ?>', '169')" style="height:4ex;" ng-change="getOTs('<?= site_url('ot/getByBase/') ?>')">
              <?php foreach ($bases->result() as $b): ?>
                <option value="<?= $b->idbase ?>"><?= $b->idbase." - ".$b->nombre_base ?></option>
              <?php endforeach; ?>
            </select>
            <div class="col s2"> </div>
            <br>
            <br>
          </div>

          <div class="noMaterialStyles row col l6">
            <b class="col s5">Ordenes de trabajo:</b>
            <select class="col s5" ng-model="consulta.ot" style="height:4ex;">
              <option ng-repeat="ot in myOts" value="{{ot.idOT}}">{{ot.nombre_ot}}</option>
            </select>
            <div class="col s2">
              <button type="button" class="btn mini-btn" data-icon="," style="margin:0px;" ng-click="getReportesView('<?= site_url('reporte/calendar') ?>')"></button>
            </div>
          </div>

      </div>

      <div class="col l6">

        <!--<div class="row">
          <button type="button" class="btn blue lighten-1 mini-btn">Ver listados</button>
          <br>
        </div>
        <div class="row">
          <button type="button" class="btn green lighten-2 mini-btn">Exportar listados</button>
          <br>
        </div>-->

      </div>
    </fieldset>
  </div>

  <div class="row">


    <div class="row col l12" ng-show="ot.selected" ng-init="ot.selected = false">

      <div class="col l12" style="margin:0px;padding:">
        <div class="card row">
          <div class="col l8">
            
            <div class="card-image">
            </div>
            <div class="card-content">
              <h5  style="background: #3A4B52; color: #FFF;"> {{ot.nombre_ot}} - {{rd.fecha_label}}</h5>
              <p>Por favor elije una de las siguientes opciones:</p>
            </div>
            <div class="card-action">
              <button type="button" class="btn mini-btn" ng-click="enlazarClick('<?= site_url('reporte/add') ?>', $event)">Agregar</button>
              <button type="button" class="btn mini-btn">Editar</button>
              <button type="button" class="btn mini-btn">Imprimir</button>
            </div>

          </div>

          <div class="col l4" ng-include="calendarLink" ng-controller="calendar"> </div>
        </div>
      </div>      

    </div>

    <!--<div class="row">
      <div class="col l4" ng-init="initCharts()">
          <canvas id="myChart"></canvas>
      </div>
    </div>-->
  </div>

</div>
