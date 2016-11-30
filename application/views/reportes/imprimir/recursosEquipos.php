  <table class="font9">
    <thead style="background:#EEE">
      <tr>
        <th rowspan="2">Item</th>
        <th rowspan="2">Codigo</th>
        <th rowspan="2">Ref./AF</th>
        <th rowspan="2">Equipo</th>
        <th rowspan="2">Operador / Conductor</th>
        <th rowspan="2">Cant.</th>
        <th rowspan="2">UND</th>
        <th colspan="2">Horometro</th>
        <th colspan="3">Reporte horas</th>
      </tr>
      <tr>
        <th>Inicial</th>
        <th>Final</th>

        <th>OPER.</th>
        <th>DISP.</th>
        <th>VAR.</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($recursos->equipos as $key => $v): ?>
        <tr>
          <td><?= $v->itemc_item ?></td>
          <td><?= $v->codigo ?></td>
          <td><?= $v->referencia ?></td>
          <td><?= $v->descripcion_equipo ?></td>
          <td><?= $v->nombre_operador ?></td>
          <td><?= $v->cantidad ?></td>
          <td><?= $v->unidad ?></td>
          <td><?= $v->horometro_ini ?></td>
          <td><?= $v->horometro_fin ?></td>
          <td><?= $v->horas_operacion ?></td>
          <td><?= $v->horas_disponible ?></td>
          <td><?= (isset($v->varado) && $v->varado )?'SI':''; ?></td>
        </tr>
      <?php endforeach; ?>
      <?php for ($i=0; $i <= (10 - sizeof($recursos->equipos) ); $i++) { ?>
      <tr>
        <td> - </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
