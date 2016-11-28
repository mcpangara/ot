<section id="seleccionar-ot" class="nodisplay col s12 m12 l12" style="max-width:90%; position: relative; margin: 1ex; box-shadow: 0px 0px 5px #333; z-index:3; background: #F5F5F5; height:200px; overflow: auto">
  <h5>Seleciona la OT buscada</h5>
  <hr>
  <div class="">
    <table class="mytabla" style="background:#FFF">
      <thead>
        <tr>
          <th>Seleccionar</th>
          <th>Nombre de OT</th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="ot in myOts">
          <td>
            <button type="button" class="btn mini-btn2" ng-click="seleccionarOT(ot)">Seleccionar</button>
          </td>
          <td ng-bind="ot.nombre_ot">
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</section>