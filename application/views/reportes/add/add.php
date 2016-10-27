<div id="add-reporte" class="windowCentered2 row" ng-controller="reportes">
  <section class="area reportes">
    <div class="btnWindow">
      <img class="logo" src="<?= base_url("assets/img/termotecnica.png") ?>" width="100px" />
      <button type="button" class="waves-effect waves-light btn red" ng-click="cerrarWindow()">Salir</button>
    </div>
  </section>
  <h5 class="center-align" style="border:1px solid #2196F3;  padding:2px;"> Nuevo Reporte Diario (producción): <?= $ot->nombre_ot ?> </h5>

  <style>
    button.btn, button.mini-btn2{
      margin-top: 0;
    }
  </style>

  <div class="font10">
    <table class="mytabla centered">
      <thead>
        <tr style="background: #6FA5ED">
          <th>No. de O.T.:</th>
          <th>Fecha reporte (Y/m/d): </th>
          <th>Secciones: </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><b><?= $ot->nombre_ot ?></b></td>
          <td> <b><?= date('Y/m/d',strtotime($fecha)) ?></b> </td>
          <td>
            <button type="button" style="background:#1261C9" class="btn mini-btn">Detalles</button>
            <button type="button" style="background:#1261C9" class="btn mini-btn">Tiempos y Recursos</button>
            <button type="button" style="background:#1261C9" class="btn mini-btn">Firmas</button>
            <button type="button" style="background:#1261C9" class="btn mini-btn">Validaciones</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <br>

  <section class="area reportes" ng-controller="addReporte" style="border:1px solid #888; min-height: 20px; box-shadow: 0px 0px 5px #AAA inset;">

  </section>
  <br>

  <div class="btnWindow">
  	<button type="button" class="waves-effect waves-light btn mini-btn" ng-click="guardarReporte('<?= site_url('ot/saveOT') ?>')">Guardar</button>
    <button type="button" class="waves-effect waves-light btn green mini-btn" ng-click="generarVistaPrevia('<?= site_url('ot/saveOT') ?>')">Imprimir</button>
  	<button type="button" class="waves-effect waves-light btn grey mini-btn" ng-click="toggleWindow()">Ocultar</button>
    <button type="button" class="waves-effect waves-light btn red mini-btn" ng-click="cerrarWindow()">Cerrar</button>
  </div>
</div>
