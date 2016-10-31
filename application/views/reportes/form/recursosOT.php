<section>
  <div class="">
    <?php $this->load->view('reportes/form/rec/personaOT', array('ot'=>$ot) ); ?>
    <?php $this->load->view('reportes/form/rec/equipoOT', array('ot'=>$ot) ); ?>
    <?php $this->load->view('reportes/form/rec/actividadesOT', array('ot'=>$ot) ); ?>
  </div>
  <h5>Listados de recursos, cantidades y tiempos: </h5>

  <div class="">
    <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="setPersonalOT('#personalOT')">Personal</button>
    <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="setPersonalOT('#equipoOT')">Equipos</button>
    <button type="button" class="btn indigo lighten-1 mini-btn" ng-click="setActividadOT('#actividadOT')">Actividades</button>
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
