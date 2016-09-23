<div class="" ng-controller="listOTReportes">

  <div class="row">
    <h4 class="center-align">Manejo de reportes diarios:</h4>
    <fieldset>
      <br>
      <div class="col l6">

          <div class="noMaterialStyles row">
            <b class="col s5">Centro de operacion:</b>
            <select ng-model="consulta.base" class="col s5" ng-init="consulta.base=168" style="height:4ex;" ng-change="getOTs('<?= site_url('ot/getByBase/') ?>')">
              <?php foreach ($bases->result() as $b): ?>
                <option value="<?= $b->idbase ?>"><?= $b->idbase." - ".$b->nombre_base ?></option>
              <?php endforeach; ?>
            </select>
            <div class="col s2"> </div>
            <br>
            <br>
          </div>

          <div class="noMaterialStyles row">
            <b class="col s5">Ordenes de trabajo:</b>
            <select class="col s5" ng-model="consulta.ot" ng-change="findOT()">
              <option ng-repeat="ot in myOts" value="{{ot.idOT}}">{{ot.nombre_ot}}</option>
            </select>
            <div class="col s2">
              <button type="button" class="btn mini-btn" data-icon="," style="margin:0px;" ng-click="getOTs('<?= site_url('') ?>')"></button>
            </div>
            <br>
          </div>

      </div>

      <div class="col l6">

        <div class="row">
          <button type="button" class="btn blue lighten-1 mini-btn">Ver listados de reportes por OT</button>
          <br>
        </div>
        <div class="row">
          <button type="button" class="btn green lighten-2 mini-btn">Exportar listados de reportes</button>
          <br>
        </div>

      </div>
    </fieldset>
  </div>

  <div class="row">


    <div class="row col l5" ng-show="ot.selected" ng-init="ot.seleted = false">
        <div class="col l12">
          <div class="card">
            <div class="card-image">
              <img src="<?= base_url('assets/img/fondo-ot2.png') ?>">
              <span class="card-title">
                <b style="text-shadow: 0px 0px 6px #222">Reportes Diarios</b>
                <br>
                <b style="text-shadow: 0px 0px 6px #222"> {{ot.nombre_ot}} - {{rd.fecha_selected}}</b>
              </span>
            </div>
            <div class="card-content">
              <p>Por favor elije una de las siguientes opciones:</p>
            </div>
            <div class="card-action">
              <button type="button" class="btn mini-btn">Add.</button>
              <button type="button" class="btn mini-btn">Edit.</button>
              <button type="button" class="btn mini-btn">Imprimir</button>
            </div>
          </div>
        </div>
      </div>

      <div class="row col l4" ng-init="initCharts()">
          <canvas id="myChart"></canvas>
      </div>

  </div>

</div>
