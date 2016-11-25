<section>
  <div class="">
    <label for="">Add. Obervación</label>
    <button type="button" class="btn" ng-click="addObervacion()"> Add. </button>
  </div>
  <div class="" ng-repeat="obs in rd.info.observaciones">
    <hr>
    Observación:
    <textarea ng-model="obs.msj"></textarea>
  </div>
</section>
