<table class="font9">
  <thead style="background:#EEE">
    <tr>
      <th>Codigo</th>
      <th>Actividad</th>
      <th>Unidad</th>
      <th>canditad día</th>
      <th>Cantidad Acumulada</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($recursos->actividades as $key => $v): ?>
    <tr>
      <td> <?= $v->itemc_item ?> </td>
      <td> <?= $v->descripcion ?> </td>
      <td> <?= $v->unidad ?> </td>
      <td> <?= $v->cantidad ?> </td>
      <td> <?= $v->planeado ?> </td>
    </tr>
    <?php endforeach; ?>
    <?php for ($i=0; $i <= (10 - sizeof($recursos->actividades) ); $i++) { ?>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td> - </td>
    </tr>
    <?php } ?>
  </tbody>
</table>
