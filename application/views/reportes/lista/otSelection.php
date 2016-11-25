<section>
  <h4>Seleciona la OT buscada</h4>
  <hr>
  <div class="">
    <table class="mytabla">
      <thead>
        <tr>
          <th>Seleccionar</th>
          <th>Nombre de OT</th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="ot in myOts">
          <td>
            <button type="button" class="btn" ng-click="seleccionarOT(ot)"></button>
          </td>
          <td ng-bind="ot.nombre_ot">
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</section>
