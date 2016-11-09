<section id="equipoOT" class="ventanaItems nodisplay">
  <div class="">
    <div class="">
      <h5 class="center-align blue white-text">Equipo agregado a esta OT: <?= $ot->nombre_ot ?></h5>
      <button type="button" ng-click="closeRecursoReporte('#equipoOT',1)" class="btn green mini-btn2" name="button">Finalizar</button>
    </div>

    <div class="">
      <button type="button" class="btn mini-btn" ng-click="toggleContent('#')"></button>
      <button type="button" class="btn mini-btn" ng-click="toggleContent('#')"></button>
    </div>

    <div id="AddEquiposOtSection">
      <fieldset class="row">
        <div class="col s6 m6 row">
          <label for="col s4 m4">Cod. siesa: </label>
          <input type="text" ng-model="consultaEquiposOT.codigo_siesa">
        </div>

        <div class="col s6 m6 row">
          <label for="col s4 m4">Referencia: </label>
          <input type="text" ng-model="consultaEquiposOT.referencia">
        </div>

        <div class="">
          <label for="col s4 m4">descripcion: </label>
          <input type="text" ng-model="consultaEquiposOT.descripcion">
        </div>

        <div class="">
          <label for="col s4 m4">Unidad de negocio: </label>
          <select ng-model="consultaEquiposOT.descripcion">
            <?php foreach ($un_equipos as $value): ?>
              <option value="<?= $value->un ?>"> <?= $value->desc_un ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </fieldset>
    </div>

    <div id="AddEquiposReporteSection" style="overflow:auto">
      <table class="mytabla">
        <thead>
          <tr>
            <th>No.</th>
            <th>Serial/Placa</th>
            <th>Descripcion</th>
            <th>Codigo Siesa</th>
            <th>item</th>
            <th>Item del cargo</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="noMaterialStyles">
              <button type="button" class="btn mini-btn" ng-click="changeFilterSelect(fil_eOT)" ng-init="fil_eOT.add = undefined" style="font-size: 1.3em">
                <big ng-if="fil_eOT.add == undefined" data-icon="&#xe04b;"></big>
                <big ng-if="fil_eOT.add == true" data-icon="&#xe04c;"></big>
              </button>
            </tdequipoByOT>
            <td><input type="text" ng-click="fil_eOT.serial" placeholder="filtrar"></td>
            <td><input type="text" ng-click="fil_eOT.decripcipn" placeholder="filtrar"></td>
            <td><input type="text" ng-click="fil_eOT.codigo_siesa" placeholder="filtrar"></td>
            <td><input type="text" ng-click="fil_eOT.item" placeholder="filtrar"></td>
            <td><input type="text" ng-click="fil_eOT.item_descripcion" placeholder="filtrar"></td>
          </tr>
          <tr ng-repeat="e in equipoOT | filter: fil_eOT">
            <td class="noMaterialStyles"> <input type="checkbox" ng-model="e.add" ng-init="e.add=false"> </td>
            <td ng-bind="e.serial"></td>
            <td ng-bind="e.descripcion"></td>
            <td ng-bind="e.codigo_siesa"></td>
            <td ng-bind="e.itemc_item"></td>
            <td ng-bind="e.item_descripcion"></td>
          </tr>
        </tbody>
      </table>
    </div>
    <b>Este formulario puede estar sujeto a cambios menores en pro de la mejora de velocidad y facíl uso.</b>
  </div>
</section>
