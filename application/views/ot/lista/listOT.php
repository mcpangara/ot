<section class="list" ng-controller="listaOT">
  <h4>Gestion de ordenes de trabajo:</h4>

  <div class="row botonera">
    Add. OT: <button type="button" class="btn mini-btn" data-icon="&#xe052;" ng-click="getAjaxWindow('<?= site_url('ot/addNew') ?>', $event, 'Gestion de OTs');"></button>
  </div>

  <div class="row" style="margin:2px; padding:2px; border:1px solid #999;border-radius:7px;">

    <div class="col m7 row noMaterialStyles">
      <label style="color: #332" class="col m5">Consulta centro de operación (base):</label>
      <select ng-model="consulta.base" class="col m5" ng-init="consulta.base = '169'" style="height:4ex;">
        <?php foreach ($bases->result() as $b): ?>
          <option value="<?= $b->idbase ?>"><?= $b->idbase." - ".$b->nombre_base ?></option>
        <?php endforeach; ?>
      </select>
      <div class="col m1">
        <button type="button" class="btn mini-btn" data-icon="," style="margin-top:0;"
          ng-click="findOTsByBase('<?= site_url('ot/getByBase') ?>')"></button>
      </div>
    </div>

  </div>

  <div class="row">
    <?php $this->load->view('ot/lista/list') ?>
  </div>
</section>
