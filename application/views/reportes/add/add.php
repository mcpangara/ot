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

      <form class="hidden" action="#">
        <input type="hidden" ng-model="rd.info.idOT" ng-init="rd.info.idOT = '<?= $ot->idOT ?>'">
        <input type="hidden" ng-model="rd.info.ccosto" ng-init="rd.info.ccosto = '<?= $ot->ccosto ?>'">
      </form>

      <div class="font12">
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
              <td><b><?= $ot->nombre_ot ?></b> <input type="hidden" ng-model="rd.info.nombre_ot" ng-init="rd.info.nombre_ot = '<?= $ot->nombre_ot ?>'"> </td>
              <td> <b><?= date('Y/m/d',strtotime($fecha)) ?></b> <input type="hidden" ng-model="rd.info.fecha_reporte" ng-init="rd.info.fecha_reporte = '<?= $fecha ?>'"></td>
              <td>
                <button type="button" style="background:#1261C9" class="btn mini-btn" ng-click="toggleContent('#info', 'nodisplay', '.mypanel > div')" data-icon="&#xe021;"> Detalles Reporte</button>
                <button type="button" style="background:#1261C9" class="btn mini-btn" ng-click="toggleContent('#recursosOT', 'nodisplay', '.mypanel > div')" data-icon="+"> Tiempo/Recursos</button>
                <button type="button" style="background:#1261C9" class="btn mini-btn" ng-click="toggleContent('#firmas', 'nodisplay', '.mypanel > div')" data-icon="^">Firmas</button>
                <button type="button" style="background:#1261C9" class="btn mini-btn" ng-click="toggleContent('#observacion', 'nodisplay', '.mypanel > div')" data-icon="&#xe03d;"> Observaciones</button>
                <button type="button" class="btn mini-btn orange" ng-click="toggleContent('#validaciones', 'nodisplay', '.mypanel > div')">Validaciones</button>
              </td>
            </tr>
            <tr class="noMaterialStyles">
              <td>Festivo: <input type="checkbox" ng-model="rd.info.festivo" ng-init="rd.info.festivo = false"></td>
              <td colspan="2"></td>
            </tr>
          </tbody>
        </table>
      </div>
      <br>

      <div class="mypanel">
        <div id="info" class="font11"> <?php $this->load->view('reportes/form/info'); ?> </div>
        <div id="recursosOT" class="font11 nodisplay"> <?php $this->load->view('reportes/form/recursosOT', array('un_equipos'=>$un_equipos, 'item_equipos'=>$item_equipos)); ?> </div>
        <div id="firmas" class="font11 nodisplay"> <?php $this->load->view('reportes/form/firmas'); ?> </div>
        <div id="validaciones" class="font11 nodisplay"> <?php $this->load->view('reportes/form/validaciones'); ?> </div>
      </div>
      <br>

      <div class="btnWindow">
        <button type="button" class="waves-effect waves-light btn green mini-btn2" ng-click="validarRecursos('<?= site_url('reporte/validarRecursos') ?>')" data-icon="&#xe02d;">
           Validar reporte
        </button>
        <br>
        <br>

        <button type="button" class="waves-effect waves-light btn mini-btn2" ng-click="guardarRD('<?= site_url('reporte/insert') ?>')">
          <b data-icon="&#xe015;"></b> Guardar
        </button>
        <button type="button" class="waves-effect waves-light btn grey mini-btn2" ng-click="toggleWindow()" data-icon="&#xe036;"> Ocultar</button>
        <button type="button" class="waves-effect waves-light btn red mini-btn2" ng-click="cerrarWindow()" data-icon="n"> Cerrar</button>
      </div>
    </div>

  </divZ
