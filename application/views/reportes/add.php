<div id="add-reporte" class="windowCentered2 row">
  <section class="area reportes">
    <div class="btnWindow">
      <img class="logo" src="<?= base_url("assets/img/termotecnica.png") ?>" width="100px" />
      <button type="button" class="waves-effect waves-light btn red" ng-click="cerrarWindow()">Salir</button>
    </div>
  </section>

  <h5 class="center-align blue white-text"> Nuevo Reporte Diario (producción): <?= $ot->nombre_ot ?> </h5>
  <section class="area reportes" ng-controller="addReporte">
    <style media="screen">
      section.reportes div, section.reportes p, section.reportes label, section.reportes input, section.reportes button, section.reportes a{
        font-size: 12px;
      }
      .formRD .l4 label{
        text-align: right;
      }
      section.reportes .font10 label{
        font-size: 10px;
      }
    </style>

    <div class="">
      <table class="mytabla centered">
        <thead>
          <tr style="background: #97D664">
            <th>No. de O.T.:</th>
            <th>Fecha reporte (Y/m/d): </th>
            <th>Maestros: </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><b><?= $ot->nombre_ot ?></b></td>
            <td> <b><?= date('Y/m/d',strtotime($fecha)) ?></b> </td>
            <td>
              <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="setPersonalOT('#personalOT')">Personal</button>
              <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="setPersonalOT('#equipoOT')">Equipos</button>
              <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="setActividadOT('#actividadOT')">Actividades</button>
              <button type="button" class="btn indigo lighten-1 mini-btn">Reembolsables</button>
              <button type="button" class="btn indigo lighten-1 mini-btn">A cargo TC</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <br>

    <?php $this->load->view('reportes/add/addEstadoReporte'); ?>

    <br>

    <?php $this->load->view('reportes/add/personaOT', array('ot'=>$ot) ); ?>
    <?php $this->load->view('reportes/add/equipoOT', array('ot'=>$ot) ); ?>
    <?php $this->load->view('reportes/add/actividadesOT', array('ot'=>$ot) ); ?>

    <hr>
    <h5>Personal:</h5>
    <?php $this->load->view('reportes/add/personalReporte', array('ot'=>$ot) ); ?>
    <hr>

    <h5>Equipo:</h5>
    <?php $this->load->view('reportes/add/equipoReporte', array('ot'=>$ot) ); ?>

    <hr>
    <h5>Actividad:</h5>
    <?php $this->load->view('reportes/add/actividadesReporte', array('ot'=>$ot) ); ?>

    <p>
      <?php $this->load->view('reportes/add/observaciones'); ?>
    </p>
    <br>

		<div class="btnWindow">
			<button type="button" class="waves-effect waves-light btn" ng-click="guardarRD('<?= site_url('reporte/insert') ?>')">Guardar</button>
      <button type="button" class="waves-effect waves-light btn green" ng-click="generarVistaPrevia('<?= site_url('ot/saveOT') ?>')">Generar</button>
			<button type="button" class="waves-effect waves-light btn grey" ng-click="toggleWindow()">Ocultar</button>
      <button type="button" class="waves-effect waves-light btn red" ng-click="cerrarWindow()">Cerrar</button>
	  </div>

	</section>

</div>
