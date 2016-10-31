<div class="">
  <table class="mytabla centered">
    <thead>
      <tr class="noHoverColor">
        <th style="width:15%">Terreno</th>
        <th>Seguridad ambiental</th>
        <th>Noche Ant.</th>
        <th colspan="2">Condiciones Climaticas</th>
      </tr>
    </thead>
    <tbody>
      <tr class="noMaterialStyles left-align font10 noHoverColor">
        <td>
          <label for="">
            Terreno:
            <select ng-model="rdp.terreno">
              <option value="Seco">Seco</option>
              <option value="Humedo">Humedo</option>
              <option value="Estable">Estable</option>
              <option value="Inestable">Inestable</option>
            </select>
          </label>
        </td>
        <td>
          <div class="noMaterialStyles left-align font10">
            <label >
              Clima:
              <select class="" ng-model="rdp.seguridad_ambiental">
                <option value="Excelente">Excelente</option>
                <option value="Excelente">Normal</option>
                <option value="Excelente">Deficiente</option>
              </select>
            </label>
          </div>
        </td>
        <td>
          <input type="text" name="name" value="">
        </td>
        <td class="inputsSmall">
            Hr. inicio lluvia: <input type="number" name="name" value="" >
        </td>
        <td class="inputsSmall">
          Hr. fin lluvia: <input type="number" name="name" value="" >
        </td>
      </tr>
    </tbody>
  </table>

  <table class="mytabla inputsSmall">
    <thead>
      <tr class="noHoverColor">
        <th colspan="2"> ACTIVIDADES </th>
      </tr>
    </thead>
    <tbody>
      <tr class="noHoverColor">
        <td>
          <div class="font10 row">
              <big class="col s12 center-align"><b>ILICITAS</b></big>
              <label class="col m4 noMaterialStyles">
                EXTENSION:
                <select ng-model="rdp.actividades.ext" >
                  <option value="SI">SI</option>
                  <option value="NO">NO</option>
                </select>
              </label>

              <label class="col m4" for="">
                DIAMETRO: <input type="text">
              </label>
              <label class="col m4" for="">
                LONGITUD: <input type="text">
              </label>
              <label class="col m4" for="">
                METERIAL: <input type="text">
              </label>
          </div>
        </td>
        <td>
          <div class="row font10">
              <big class="col s12 center-align"><b>REPARACION</b></big>
              <label class="col m4" for="">
                INST. CAPUCHON: <input type="text">
              </label>
              <label class="col m4 " for="">
                INST. CASCOTA: <input type="text">
              </label>
              <label class="col m4 " for="">
                COMBIO TRAMO: <input type="text">
              </label>
              <label class="col m4 " for="">
                INST. DECAMISA: <input type="text">
              </label>
              <label class="col m4 " for="">
                RETIDO DE GRAPA: <input type="text">
              </label>
              <label class="col m4 " for="">
                ANILLO CIRCUNFERENCIAL: <input type="text">
              </label>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>
