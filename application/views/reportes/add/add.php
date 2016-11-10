<div id="add-reporte" class="windowCentered2 row" ng-controller="reportes">

  <div class="" ng-controller="addReporte">
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
        .noHoverColor {
          background: #FFF;
        }
        .mypanel{
          border:3px solid #888;
          min-height: 30px;
          /*box-shadow: 0px 0px 10px #AAA inset;*/
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
                <button type="button" style="background:#1261C9" class="btn mini-btn" ng-click="toggleContent('#info', 'nodisplay', '.mypanel > div')">Detalles</button>
                <button type="button" style="background:#1261C9" class="btn mini-btn" ng-click="toggleContent('#recursosOT', 'nodisplay', '.mypanel > div')">Tiempos y Recursos</button>
                <button type="button" style="background:#1261C9" class="btn mini-btn" ng-click="toggleContent('#firmas', 'nodisplay', '.mypanel > div')">Firmas</button>
                <button type="button" style="background:#1261C9" class="btn mini-btn" ng-click="toggleContent('#validaciones', 'nodisplay', '.mypanel > div')">Validaciones</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <br>

      <div class="mypanel">
        <div id="info" class="font11"> <?php $this->load->view('reportes/form/info'); ?> </div>
        <div id="recursosOT" class="font11 nodisplay"> <?php $this->load->view('reportes/form/recursosOT', array('un_equipos'=>$un_equipos)); ?> </div>
        <div id="firmas" class="font11 nodisplay"> <?php $this->load->view('reportes/form/firmas'); ?> </div>
        <div id="validaciones" class="font11 nodisplay"> <?php $this->load->view('reportes/form/validaciones'); ?> </div>
      </div>
      <br>

      <div class="btnWindow">
        <button type="button" class="waves-effect waves-light btn mini-btn" ng-click="guardarReporte('<?= site_url('ot/saveOT') ?>')">Guardar</button>
        <button type="button" class="waves-effect waves-light btn green mini-btn" ng-click="generarVistaPrevia('<?= site_url('ot/saveOT') ?>')">Imprimir</button>
        <button type="button" class="waves-effect waves-light btn grey mini-btn" ng-click="toggleWindow()">Ocultar</button>
        <button type="button" class="waves-effect waves-light btn red mini-btn" ng-click="cerrarWindow()">Cerrar</button>
      </div>
    </div>

  </divZ
