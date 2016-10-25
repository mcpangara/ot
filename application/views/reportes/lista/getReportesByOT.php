<div class="" ng-controller="listOTReportes">

  <div class="row">
    <h5 class="center-align">Manejo de reportes diarios:</h5>
    <fieldset style="padding:1ex;">
      <div class="col l12">

          <div class="noMaterialStyles row col l12">
            <b class="col s3 l3">Centro de operacion:</b>
            <select ng-model="consulta.base" class="col s5 l5" ng-init="consulta.base='169'" ng-change="setDefaultFilter()" style="height:4ex;">
              <?php foreach ($bases->result() as $b): ?>
                <option value="<?= $b->idbase ?>"><?= $b->idbase." - ".$b->nombre_base ?></option>
              <?php endforeach; ?>
            </select>
            <div class="col s2 l2">
              <button type="button" class="btn blue mini-btn" style="margin:0" ng-click="getOTs('<?= site_url('ot/getByBase/') ?>')" data-icon="," > Listar ordenes</button>
            </div>
            <br>
            <br>
          </div>

          <div class="noMaterialStyles row col l12">
            <b class="col s3 l3">Ordenes de trabajo:</b>
            <select class="col s5 l5" ng-model="consulta.ot" style="height:4ex;">
              <option ng-repeat="ot in myOts" value="{{ot.idOT}}">{{ot.nombre_ot}}</option>
            </select>
            <div class="col s2 l2">
              <button type="button" class="btn mini-btn" data-icon="," style="margin:0px;" ng-click="getReportesView('<?= site_url('reporte/calendar') ?>')"> ver reportes</button>
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

      <div class="col l12" style="margin:0px;padding:0px;">

          <div class="col l9">
            <?php $this->load->view('reportes/lista/list'); ?>
          </div>

          <div class="col l3" ng-include="calendarLink" ng-controller="calendar"> </div>
        </div>
      </div>

    </div>
  </div>

</div>
