<section class="list">
  <h4>Gestion de ordenes de trabajo:</h4>
  <div class="row ">
    <div class="col m4 row noMaterialStyles">
      <label for="" class="col m4">Centro de operación:</label>
      <select ng-model="consulta.base" class="col m5" ng-init="initBase('<?= site_url('ot/getByBase/') ?>', '169')" style="height:4ex;" ng-change="getOTs('<?= site_url('ot/getByBase/') ?>')">
        <?php foreach ($bases->result() as $b): ?>
          <option value="<?= $b->idbase ?>"><?= $b->idbase." - ".$b->nombre_base ?></option>
        <?php endforeach; ?>
      </select>
      <div class="col m1">
        <button type="button" class="btn mini-btn" data-icon="," style="margin-top:0;"></button>
      </div>
    </div>
  </div>
  <div class="row botonera">
    <button type="button" class="btn mini-btn" data-icon="&#xe052;"></button>
  </div>

  <div class="row ">

  </div>
</section>
