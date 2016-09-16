  <section id="reembolsablesOT" class="ventanaItems nodisplay">
    <div class="row">
      <big>Agregar reembolsables:</big>
      <button type="button" class="btn" ng-click="endReembolsables('#reembolsablesOT', tr)"> Finalizar </button>
      <hr>
    </div>

    <form class="row" action="#" method="">
      <div class="col l3 s12 row">
        <label class="col l3 s5" for="descripcion">Descripción: </label>
        <input type="text" class="col l9 s7" ng-model="reemb.descripcion" placeholder="Descripción" name="descripcion" value="">
      </div>

      <div class="col l3 s12 row">
        <label class="col l3 s5" for="unidad">Unidad: </label>
        <input type="text" class="col l9 s7" ng-model="reemb.unidad" placeholder="UND" name="unidad" value="">
      </div>

      <div class="col l3 s12 row">
        <label class="col l3 s5" for="cantidad">Cantidad: </label>
        <input type="text" class="col l9 s7" ng-model="reemb.cantidad" placeholder="EJ: 10" name="cantidad" value="">
      </div>

      <div class="col l3 s12 row">
        <label class="col l3 s5" for="valor_und">Valor unitario: </label>
        <input type="text" class="col l9 s7" ng-model="reemb.valor_und" placeholder="EJ 20000" name="valor_und" value="">
        <small>{{ reemb.valor_und | currency}}</small>
      </div>

      <button type="button" name="button" ng-click="addReemb()" class="btn orange mini-btn">Add. reembolsable</button>
    </form>

    <div class="row" style="overflow:auto; min-height: 90%">
      <table class="mytabla">
        <thead>
          <tr>
            <th>No.</th>
            <th>Descripción</th>
            <th>Unidad</th>
            <th>Cantidad</th>
            <th>Valor unitario</th>
            <th>Valor total</th>
          </tr>
        </thead>
        <tbody>
          <tr class="" ng-repeat="r in reembs track by $index  ">
            <td>{{ (1+$index)  }}</td>
            <td>{{r.descripcion}}</td>
            <td>{{r.unidad}}</td>
            <td>{{r.cantidad}}</td>
            <td>{{r.valor_und}}</td>
            <td>{{ (r.cantidad * r.valor_und) | currency }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
