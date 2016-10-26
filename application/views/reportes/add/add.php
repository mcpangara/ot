<div id="add-reporte" class="windowCentered2 row" ng-controller="reporte">
  <section class="area reportes">
    <div class="btnWindow">
      <img class="logo" src="<?= base_url("assets/img/termotecnica.png") ?>" width="100px" />
      <button type="button" class="waves-effect waves-light btn red" ng-click="cerrarWindow()">Salir</button>
    </div>
  </section>
  <h5 class="center-align blue white-text"> Nuevo Reporte Diario (producción): <?= $ot->nombre_ot ?> </h5>

  <section class="area reportes" ng-controller="addReporte">
  </section>
</div>
