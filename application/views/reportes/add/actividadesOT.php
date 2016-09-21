<section id="actividadOT" class="ventanaItems nodisplay">
  <div class="">
    <div class="">
      <h5 class="center-align blue white-text">Actividades planeadas en esta OT: <?= $ot->nombre_ot ?></h5>
      <button type="button" ng-click="endActividadOT('#actividadOT')" class="btn green mini-btn2" name="button">Finalizar</button>

      <p class="padding1ex">
        Selecciona las actividades que deseas reportar hoy.
      </p>

    </div>

    <div class="" style="overflow:auto" ng-init="getActividadesOT('<?= site_url('OT/getItemByTipeOT/'.$ot->idOT.'/1') ?>')">
      <table class="mytabla">
        <thead>
          <tr>
            <th>#</th>
            <th>Item</th>
            <th>Codigo Fact.</th>
            <th>Descripcion</th>
            <th>Planeado</th>
            <th>Nombre de OT</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="noMaterialStyles">
              <button type="button" class="btn mini-btn" ng-click="changeFilterSelect(fil_acOT)" ng-init="fil_acOT.add = undefined" style="font-size: 1.3em">
                <big ng-if="fil_acOT.add == undefined" data-icon="&#xe04b;"></big>
                <big ng-if="fil_acOT.add == true" data-icon="&#xe04c;"></big>
              </button>
            </td>
            <td><input type="text" ng-click="fil_acOT.itemc_item" placeholder="filtrar"></td>
            <td><input type="text" ng-click="fil_acOT.codigo" placeholder="filtrar"></td>
            <td><input type="text" ng-click="fil_acOT.descripcion" placeholder="filtrar"></td>
            <td><input type="text" ng-click="fil_acOT.planeado" placeholder="filtrar"></td>
            <td><input type="text" ng-click="fil_acOT.nombre_ot" placeholder="filtrar"></td>
          </tr>
          <tr ng-repeat="ac in actOT | filter: fil_pOT">
            <td class="noMaterialStyles"> <input type="checkbox" ng-model="ac.add" ng-init="ac.add=false"> </td>
            <td class="noMaterialStyles"> <span ng-bind="ac.itemc_item"></span> </td>
            <td class="noMaterialStyles"> <span ng-bind="ac.codigo"></span> </td>
            <td class="noMaterialStyles"> <span ng-bind="ac.descripcion"></span> </td>
            <td class="noMaterialStyles"> <span ng-bind="ac.planeado"></span> </td>
            <td class="noMaterialStyles"> <span ng-bind="ac.nombre_ot"></span> </td>
          </tr>
        </tbody>
      </table>
    </div>
    <b>Este formulario puede estar sujeto a cambios menores en pro de la mejora de velocidad y facíl uso.</b>
  </div>
</section>
