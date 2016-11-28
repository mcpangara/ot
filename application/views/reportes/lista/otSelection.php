<section id="seleccionar-ot" class="nodisplay" style="position: absolute;  padding: 2ex; box-shadow: 0px 0px 5px #333; z-index:3; background:#FEFEFE">
  <h5>Seleciona la OT buscada</h5>
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
