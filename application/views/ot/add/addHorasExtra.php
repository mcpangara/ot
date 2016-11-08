  <section id="addHorasExtra" class="ventanaItems nodisplay">
    <div class="">

      <div class="">
        <big>Gestion de Horas extra:</big>
        <button type="button" ng-click="endHorasExtra('#addHorasExtra', tr)" class="btn green mini-btn2" name="button">Finalizar</button>
      </div>

      <div class="" style="overflow:auto">
        <table class="mytabla">
          <thead>
            <tr>
              <th>item</th>
              <th>Descripción</th>
              <th>Cant. personal</th>
              <th> Valor día</th>
              <th>HED</th>
              <th>HEN</th>
              <th>HEFD</th>
              <th>HEFN</th>
              <th>HFR</th>
              <th>Valor total</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="it in tr.json_horas_extra.json_horas_extra" ng-init="validateValues(it)">
              <td>{{ it.itemc_item }}</td>
              <td>{{ it.descripcion }}</td>
              <td><input type="number" ng-model="it.cantidad_he" <?= $isEdit?'':'ng-init="it.cantidad_he = it.cantidad"'; ?> ng-change="calcularTotalItem(it)" style="width:4ex" value=""></td>
              <td>{{ it.salario | currency:'$':0 }}</td>
              <td <?= $isEdit?'ng-init="subtotal_he(it, (it.salario/8), 1.25, it.cantidad_hed, \'hed\')"':'ng-init="it.cantidad_hed = 0"'; ?> >
                <input type="number" ng-model="it.cantidad_hed" style="width:4ex" ng-change="subtotal_he(it, (it.salario/8), 1.25, it.cantidad_hed, 'hed')">
                <div <?= $isEdit?'':'ng-init="it.total_hed = 0"'; ?> >
                  {{ ( it.total_hed) | currency:'$':0 }}
                </div>
              </td>
              <td <?= $isEdit?'ng-init="subtotal_he(it, (it.salario/8), 1.75, it.cantidad_hen, \'hen\')"':'ng-init="it.cantidad_hen = 0"'; ?> >
                <input type="number" ng-model="it.cantidad_hen" style="width:4ex" ng-change="subtotal_he(it, (it.salario/8), 1.75, it.cantidad_hen, 'hen')">
                <div <?= $isEdit?'':'ng-init="it.total_hen = 0"'; ?> >
                  {{ ( ( (it.salario/8)*1.75 ) * it.cantidad_hen) | currency:'$':0 }}
                </div>
              </td>
              <td <?= $isEdit?'ng-init="subtotal_he(it, (it.salario/8), 1.75, it.cantidad_hefd, \'hefd\')"':'ng-init="it.cantidad_hefd = 0"'; ?> >
                <input type="number" ng-model="it.cantidad_hefd" style="width:4ex" ng-change="subtotal_he(it, (it.salario/8), 1.75, it.cantidad_hefd, 'hefd')">
                <div <?= $isEdit?'':'ng-init="it.total_hefd = 0"'; ?> >
                  {{ ( ( (it.salario/8)*1.75 ) * it.cantidad_hefd) | currency:'$':0 }}
                </div>
              </td>
              <td <?= $isEdit?'ng-init="subtotal_he(it, (it.salario/8), 2, it.cantidad_hefn, \'hefn\')"':'ng-init="it.cantidad_hefn = 0"'; ?> >
                <input type="number" ng-model="it.cantidad_hefn" style="width:4ex" ng-change="subtotal_he(it, (it.salario/8), 2, it.cantidad_hefn, 'hefn')">
                <div <?= $isEdit?'':'ng-init="it.total_hefn = 0"'; ?> >
                  {{ ( ( (it.salario/8)*2 ) * it.cantidad_hefn) | currency:'$':0 }}
                </div>
              </td>
              <td <?= $isEdit?'ng-init="subtotal_he(it, (it.salario/8), 2.5, it.cantidad_hed, \'hfr\')"':'ng-init="it.cantidad_hfr = 0"' ?> >
                <input type="number" ng-model="it.cantidad_hfr" style="width:4ex" ng-change="subtotal_he(it, (it.salario/8), 2.5, it.cantidad_hed, 'hfr')">
                <div <?= $isEdit?'':'ng-init="it.total_hfr = 0"'; ?> >
                  {{ ( ( (it.salario/8)*2.5 ) * it.cantidad_hfr) | currency:'$':0 }}
                </div>
              </td>
              <td <?= $isEdit?'ng-init="calcularHorasExtra(tr)"':'ng-init="it.total = 0"' ?>>
                {{ it.total | currency:'$':0 }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </section>
