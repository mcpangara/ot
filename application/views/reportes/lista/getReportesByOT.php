<div class="">

  <div class="row">
    <fieldset>
      <legend>Gestion de reportes diarios</legend>
      <div class="col l6">

          <div class="noMaterialStyles row">
            <b class="col s5">Centro de operacion:</b>
            <select ng-model="consulta.base" class="col s7" ng-init="consulta.base=168">
              <?php foreach ($bases->result() as $b): ?>
                <option value="<?= $b->idbase ?>"><?= $b->idbase." - ".$b->nombre_base ?></option>
              <?php endforeach; ?>
            </select>
            <br>
            <br>
          </div>

          <div class="noMaterialStyles row">
            <b class="col s5">Ordenes de trabajo activas:</b>
            <select class="col s7" name="">
              <option value=""> Selecciona una base </option>
            </select>
            <br>
          </div>

      </div>
    </fieldset>
  </div>

  <div class="row">


    <div class="row col l4">
        <div class="col l12">
          <div class="card">
            <div class="card-image">
              <img src="<?= base_url('assets/img/fondo-ot.png') ?>">
              <span class="card-title"><b style="text-shadow: 0px 0px 6px #222">VITPCLLTEST - 12/09/2016</b></span>
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

  </div>

</div>
