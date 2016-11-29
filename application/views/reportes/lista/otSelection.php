<section id="seleccionar-ot" class="nodisplay col s12 m12 l12" style="background:#F5F5F5; max-heigth: 230px; overflow: auto">
  <h5>Seleciona la OT buscada</h5>
  <hr>
  <div class="">
    <table class="mytabla" style="background:#FFF; width: auto;">
      <thead>
        <tr>
          <th>Seleccionar</th>
          <th>Base</th>
          <th>Nombre de OT</th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="ot in myOts">
          <td>
            <button type="button" class="btn mini-btn2" ng-click="seleccionarOT(ot)" data-icon="w"> Sel.</button>
          </td>
          <td ng-bind="ot.base_idbase"></td>
          <td ng-bind="ot.nombre_ot">
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</section>
