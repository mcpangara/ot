<section id="equipoOT" class="ventanaItems nodisplay">
  <div class="">
    <div class="">
      <h5 class="center-align blue white-text">Equipo agregado a esta OT: <?= $ot->nombre_ot ?></h5>
      <button type="button" ng-click="closeRecursoReporte('#equipoOT',2)" class="btn green mini-btn2" name="button">Finalizar</button>
    </div>

    <div class="row">
      <br>
      <button type="button" class="btn blue" ng-click="showContent('#AddEquiposReporteSection', 'div.sectionsEquiposRD')">Equipos para reportar</button>
      <button type="button" class="btn blue-grey darken-1" ng-click="showContent('#AddEquiposOtSection', 'div.sectionsEquiposRD')">Buscar equipos no relacionados</button>
      <br>
    </div>

    <div id="AddEquiposOtSection" class="sectionsEquiposRD nodisplay noMaterialStyles" style="border:2px solid #999; padding:2ex;">
      <fieldset class="row">
        <h4>Busca y relaciona equipos a esta OT para poder reportarlos</h4>
        <div class="col s6 m6 row">
          <label class="col s3 m4">Cod. siesa: </label>
          <input class="col s4 m4" type="text" ng-model="consultaEquiposOT.codigo_siesa">
        </div>

        <div class="col s6 m6 row">
          <label class="col s3 m4">Referencia: </label>
          <input class="col s4 m4" type="text" ng-model="consultaEquiposOT.referencia">
        </div>

        <div class="col s6 m6 row">
          <label class="col s3 m4">Descripcion: </label>
          <input class="col s4 m4" type="text" ng-model="consultaEquiposOT.descripcion">
        </div>

        <div class="col s6 m6 row">
          <label class="col s4 m4">Unidad de negocio: </label>
          <select class="col s4 m4" ng-model="consultaEquiposOT.un">
            <option value="">Sin seleccion</option>
            <?php foreach ($un_equipos->result() as $value): ?>
              <option value="<?= $value->un ?>"> <?= $value->desc_un ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col s6 m6 row">
          <button type="button" class="btn mini-btn" ng-click="buscarEquiposBy('<?= site_url('equipo/findBy') ?>')">Buscar</button>
        </div>
      </fieldset>


      <table class="mytabla">
        <thead>
          <tr>
            <th>Cod. Siesa</th>
            <th>Referencia</th>
            <th>Descripción</th>
            <th></th>
            <th>Unidad negocio</th>
            <th>Opcion</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td> <input type="text" ng-model="filterResultEquiposBusqueda.codigo_siesa" value=""> </td>
            <td> <input type="text" ng-model="filterResultEquiposBusqueda.referencia" value=""> </td>
            <td> <input type="text" ng-model="filterResultEquiposBusqueda.descripcion" value=""> </td>
            <td> <input type="text" ng-model="filterResultEquiposBusqueda.desc_un" value=""> </td>
            <td></td>
          </tr>
          <tr ng-repeat="it in resultEquiposBusqueda | filter: filterResultEquiposBusqueda">
            <td ng-bind="it.codigo_siesa"></td>
            <td ng-bind="it.referencia"></td>
            <td ng-bind="it.descripcion"></td>
            <td>
                <select ng-model="it.item" name="">
                  <?php foreach ($item_equipos as $ite): ?>
                    <option value="<?= $ite->iditemf ?>"><?= $ite->itemc_item." - ".$ite->descripcion ?></value>
                  <?php endforeach; ?>
                </select>
            </td>
            <td ng-bind="it.desc_un"></td>
            <td><button type="button" ng-click="relacionarEquipoAOt(it, '<?= site_url('equipo/relacionarEquipo') ?>')"> Add. </button></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div id="AddEquiposReporteSection" class="sectionsEquiposRD " style="overflow:auto">
      <h4>Equipos por agregar al reporte</h4>
      <table class="mytabla">
        <thead>
          <tr>
            <th>No. </th>
            <th>Cod. Siesa</th>
            <th>Referencia</th>
            <th>Descripción</th>
            <th>item</th>
            <th>Unidad negocio</th>
          </tr>
          <tr>
            <th class="noMaterialStyles">
              Todos <input type="checkbox" ng-click="selectionAll(equiposOT, 'add');">
            </th>
            <th colspan="5">

            </th>
          </tr>
        </thead>
        <tbody>
          <tr class="noMaterialStyles">
            <td>
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
          <tr ng-repeat="e in equiposOT | filter: fil_eOT">
            <td class="noMaterialStyles"> <input type="checkbox" ng-model="e.add" ng-init="e.add=false"> </td>
            <td ng-bind="e.codigo_siesa"></td>
            <td ng-bind="e.referencia"></td>
            <td ng-bind="e.descripcion"></td>
            <td ng-bind="e.itemc_item"></td>
            <td ng-bind="e.unidad_negocio"></td>
          </tr>
        </tbody>
      </table>
    </div>
    <b>Este formulario puede estar sujeto a cambios menores en pro de la mejora de velocidad y facíl uso.</b>
  </div>
</section>
