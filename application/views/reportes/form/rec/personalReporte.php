<div class="noMaterialStyles">
  <table class="mytabla">
    <thead>
      <tr style="background: #EEE">
        <th></th>
        <th></th>
        <th>Item</th>
        <th>identificacion</th>
        <th>Nombre Completo</th>
        <th>Cargo</th>

        <th>Fact.</th>
        <th style="max-width: 9ex">Hr. Ini.</th>
        <th style="max-width: 9ex">Hr. fin</th>
        <th style="max-width: 9ex">Día</th>
        <th style="max-width: 9ex">Recargo N.</th>
        <th style="max-width: 9ex">H.E.D.</th>
        <th style="max-width: 9ex">H.E.N.</th>
        <th>Racion</th>
        <th>Hr. <br> Almuer.</th>
      </tr>
    </thead>
    <tbody>
      <tr style="background: #EEE">
        <td></td>
        <td>No.</td>
        <!-- <td>
          <input type="text"
              ng-model="personalFilter.indice"
              ng-change="verificadorNumericoFilter(personalFilter, 'indice',1)"
              style="width:2em">
        </td> -->

        <td> <input ng-model="personalFilter.itemc_item" style="width:8ex;"> </td>
        <td><input type="text" ng-model="personalFilter.identificacion"></td>
        <td><input type="text" ng-model="personalFilter.nombre_completo"></td>
        <td><input type="text" ng-model="personalFilter.descripcion"></td>
        <td class="noMaterialStyles">
          <input type="checkbox"
              ng-click="changeFilterSelect2(personalFilter, 'facturable')" ng-init="personalFilter.facturable = undefined">
        </td>

        <td class="red lighten-3 inputsSmall"><input type="number" ng-model="defaultH.hora_inicio" ng-change="changeHora(defaultH,'hora_inicio')"></td>
        <td class="red lighten-3 inputsSmall"><input type="number" ng-model="defaultH.hora_fin" ng-change="changeHora(defaltH,'hora_fin')"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr ng-repeat="pr in rd.recursos.personal | filter: personalFilter | orderBy: 'itemc_item' track by $index" ng-class='pr.clase'>
        <td>
          <button type="button" class="btn mini-btn2 red" ng-click="quitarRegistroLista( rd.recursos.personal, pr, '', '')"> x </button>
        </td>
        <td>
            <span ng-bind="$index+1"></span>
        </td>
        <!-- <td ng-click="cambiarValorObjeto(pr,'clase','green lighten-5')" ng-bind="pr.indice" ng-init="pr.indice = ($index + 1)"></td> -->

        <td>
          <div class="valign-wrapper">
            <span ng-if="pr.valid != undefined && !pr.valid" class="valign red-text text-darken-2" style="font-size:3ex" data-icon="f"></span>
            <a href="#" ng-bind="pr.itemc_item" class="valign text-" ng-click="mensaje( pr.idrecurso_ot+' '+pr.descripcion)"></a>
          </div>
        </td>

        <td ng-click="cambiarValorObjeto(pr,'clase','green lighten-5')"> <b ng-bind="pr.identificacion"></b> </td>
        <td ng-click="cambiarValorObjeto(pr,'clase','green lighten-5')"> <b ng-bind="pr.nombre_completo"></b> </td>
        <td> <span ng-bind="pr.descripcion"></span> </td>
        <td class="noMaterialStyles">
          <input type="checkbox" ng-model="pr.facturable" ng-init="pr.facturable = true" >
        </td>

        <td class="inputsSmall"> <input ng-model="pr.hora_inicio" type="text" style="width:5ex" required  /> Hrs. </td>
        <td class="inputsSmall"> <input ng-model="pr.hora_fin" type="text" style="width:5ex" required  />  Hrs.</td>
        <td class="inputsSmall">
          <div class="">
            <input type="number" style="border: green 1px solid; width:5ex;" ng-model="pr.cantidad">
          </div>
        </td>
        <td class="inputsSmall"> <input type="number" style="border: green 1px solid; " ng-model="pr.horas_rn"> </td>
        <td class="inputsSmall"> <input type="number" style="border: green 1px solid; " ng-model="pr.horas_hed"> </td>
        <td class="inputsSmall"> <input type="number" style="border: green 1px solid; " ng-model="pr.horas_hen"> </td>
        <td> <input type="checkbox" ng-model="pr.racion" ng-init="false"> </td>
        <td> <input type="checkbox" ng-model="pr.hr_almuerzo" ng-init="false"> </td>
      </tr>
    </tbody>
  </table>
</div>

<br>
