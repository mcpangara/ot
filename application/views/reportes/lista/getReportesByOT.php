<div class="" ng-controller="listOTReportes">

  <div class="row">
    <h5 class="center-align">Manejo de reportes diarios:</h5>
    <fieldset style="padding:1ex;">
      <div class="col l12">

        <div class="noMaterialStyles row col l4" style="border:1px solid #999; padding:4px">
          <b class="col s4 l4">Buscar OT por No.:</b>
          <input class="col s6 l6" type="text" ng-model="consulta.indicio_nombre_ot" style="padding: 5px;" placeholder="Ej: 350-16">
          <div class="col s1 l1">
            <button type="button" class="btn blue mini-btn" style="margin:0" ng-click="getOTs('<?= site_url('ot/getByName/') ?>')" data-icon="," ></button>
          </div>
        </div>

        <div class="noMaterialStyles row col l8" style="border:1px solid #999; padding:4px">
          <b class="col s4 l4">OT por base:</b>
          <select ng-model="consulta.base" class="col s6 l6" ng-init="consulta.base='169'" ng-change="setDefaultFilter()" style="height:4ex;">
            <?php foreach ($bases->result() as $b): ?>
              <option value="<?= $b->idbase ?>"><?= $b->idbase." - ".$b->nombre_base ?></option>
            <?php endforeach; ?>
          </select>
          <div class="col s1 l1">
            <button type="button" class="btn blue mini-btn" style="margin:0" ng-click="getOTs('<?= site_url('ot/getByBase/') ?>')" data-icon="," ></button>
          </div>
          <br>
          <br>
        </div>

        <br>
        <hr>

        <?php $this->load->view('reportes/lista/otSelection'); ?>

        <div class="noMaterialStyles row col l12">
          <b class="col s3 l3">Orden de trabajo:</b>
          <div class="col s3 l3">
            <span ng-bind="consulta.nombre_ot"></span>
            <input type="hidden" ng-model="consulta.ot">
          </div>
          <!-- <select class="col s5 l5" ng-model="consulta.ot" style="height:4ex;">
            <option ng-repeat="ot in myOts" value="{{ot.idOT}}">{{ot.nombre_ot}}</option>
          </select> -->
          <div class="col s3 l3 row">
            <button type="button" class="btn mini-btn" data-icon="," style="margin:0px;" ng-click="getReportesView('<?= site_url() ?>')"> ver reportes</button>
            <a id="historialByOT" target="_blank" ng-href="<?= site_url('export/historyRepoByOT') ?>/{{consulta.idOT}}/{{consulta.nombre_ot}}" class="nodisplay btn mini-btn" style="margin:0px;">historial</a>
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
