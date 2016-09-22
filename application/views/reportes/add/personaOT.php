<section id="personalOT" class="ventanaItems nodisplay">
  <div class="">
    <div class="">
      <h5 class="center-align blue white-text">Personal agregado a esta OT: <?= $ot->nombre_ot ?></h5>
      <button type="button" ng-click="endPersonalOT('#personalOT')" class="btn green mini-btn2" name="button">Finalizar</button>

      <p class="padding1ex">
        Hola, aqui puedes elejir el personal que deseas agreagar al reporte diario que estas desarrollando. Recuerda, una vez hecho esto podras duplicar el reporte para agilizar este proceso
      </p>

    </div>

    <div class="" style="overflow:auto" ng-init="getPersonaOT('<?= site_url('persona/personalByOT/'.$ot->idOT) ?>')">
      <table class="mytabla">
        <thead>
          <tr>
            <th>#</th>
            <th>Identificacion</th>
            <th>Nombre de empleados</th>
            <th>OT</th>
            <th>Item del cargo</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="noMaterialStyles">
              <button type="button" class="btn mini-btn" ng-click="changeFilterSelect(fil_pOT)" ng-init="fil_pOT.add = undefined" style="font-size: 1.3em">
                <big ng-if="fil_pOT.add == undefined" data-icon="&#xe04b;"></big>
                <big ng-if="fil_pOT.add == true" data-icon="&#xe04c;"></big>
              </button>
            </td>
            <td><input type="text" ng-click="fil_pOT.identificacion" placeholder="filtrar"></td>
            <td><input type="text" ng-click="fil_pOT.nombre_completo" placeholder="filtrar"></td>
            <td><input type="text" ng-click="fil_pOT.nombre_ot" placeholder="filtrar"></td>
            <td><input type="text" ng-click="fil_pOT.descripcion" placeholder="filtrar"></td>
          </tr>
          <tr ng-repeat="p in persOT | filter: fil_pOT | orderBy: 'descripcion'">
            <td class="noMaterialStyles"> <input type="checkbox" ng-model="p.add" ng-init="p.add=true"> </td>
            <td ng-bind="p.identificacion"></td>
            <td ng-bind="p.nombre_completo"></td>
            <td ng-bind="p.nombre_ot"></td>
            <td ng-bind="p.descripcion"></td>
          </tr>
        </tbody>
      </table>
    </div>
    <b>Este formulario puede estar sujeto a cambios menores en pro de la mejora de velocidad y facíl uso.</b>
  </div>
</section>
