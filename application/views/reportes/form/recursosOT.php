<section style="padding:1ex">
  <div class="ventanasAdd" ng-init="getRecursosByOT('<?= site_url('reporte/getRecursosByOT/'.$ot->idOT) ?>')">
    <?php $this->load->view('reportes/form/rec/personaOT', array('ot'=>$ot) ); ?>
    <?php $this->load->view('reportes/form/rec/equipoOT', array('ot'=>$ot, 'un_equipos'=>$un_equipos, 'item_equipos'=>$item_equipos) ); ?>
    <?php $this->load->view('reportes/form/rec/actividadesOT', array('ot'=>$ot) ); ?>
  </div>
  <h5>Listados de recursos, cantidades y tiempos: </h5>

  <div class="">
    <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="showRecursosReporte('.ventanasAdd > div', '#personalOT')">Personal</button>
    <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="showRecursosReporte('.ventanasAdd > div', '#equipoOT')">Equipos</button>
    <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="showRecursosReporte('.ventanasAdd > div', '#actividadOT')">Actividades</button>
    <button type="button" class="btn indigo lighten-1 mini-btn">A cargo TC</button>
  </div>
  <div class="">
    <h5>Personal:</h5>
    <?php $this->load->view('reportes/form/rec/personalReporte', array('ot'=>$ot) ); ?>
    <hr>

    <h5>Equipo:</h5>
    <?php $this->load->view('reportes/form/rec/equipoReporte', array('ot'=>$ot) ); ?>

    <hr>
    <h5>Actividad:</h5>
    <?php $this->load->view('reportes/form/rec/actividadesReporte', array('ot'=>$ot) ); ?>
  </div>
</section>
