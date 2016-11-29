<table>
  <thead>
    <tr>
      <th>identificacion</th>
      <th>Nombre Completo</th>
      <th>Item</th>
      <th>Cargo</th>
      <th>C/L</th>
      <th>B/O/N</th>
      <th>Hr. Ini.</th>
      <th>Hr. fin</th>
      <th>Unidad</th>
      <th>Día/H.O.</th>
      <th>HED</th>
      <th>HEN</th>
      <th>HRN</th>
      <th>Ración</th>
      <th><small>Hr. <br> Almuerzo</small></th>
      <th>G. viaje</th>
    </tr>
  </thead>
  <tbody>
    <tbody>
      <?php foreach ($recursos->personal as $k => $v): ?>
        <tr>
          <td><?= $v->identificacion ?></td>
          <td><?= $v->nombre_completo ?></td>
          <td><?= $v->itemc_item ?></td>
          <td><?= $v->descripcion ?></td>
          <td><?= $v->CL ?></td>
          <td><?= $v->BO ?></td>
          <td><?= $v->hora_inicio ?></td>
          <td><?= $v->hora_fin ?></td>
          <td><?= $v->unidad ?></td>
          <td><?= $v->cantidad ?></td>
          <td><?= $v->horas_extra_dia ?></td>
          <td><?= $v->horas_extra_noc ?></td>
          <td><?= $v->horas_recargo ?></td>
          <td><?= $v->reacion ?></td>
          <td><?= $v->hr_almuerzo ?></td>
          <td><?= $v->gasto_viaje ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </tbody>
</table>
