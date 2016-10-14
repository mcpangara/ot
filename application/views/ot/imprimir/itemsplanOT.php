<thead>
  <tr style="font-size: 1.5ex">
    <th>Item</th>
    <th class="td50">Descripción</th>
    <th>Unidad de Medida</th>
    <th>Cant.</th>
    <th>Duración <br> (Días) </th>
    <th>Total <br> Solicitado</th>
    <th>Valor Unitario</th>
    <th>Valor Planeado</th>
  </tr>
  <tr>
    <th style="background:#bbf29d"><?= $no_gestion ?></th>
    <th style="background:#bbf29d"><?= $gestion ?></th>
    <th colspan="6" style="background:#FFF"></th>
  </tr>
</thead>
<tbody>
  <?php $valor_gestion = 0; ?>
  <?php foreach ($items->result() as $it): ?>
    <tr>
      <td> <?= $it->item ?></td>
      <td class="td50" style="background: #EEF2EA"> <?= $it->descripcion ?> </td>
      <td class="textcenter"> <?= $it->unidad ?> </td>
      <td class="textcenter" style="background: #EEF2EA"> <?= $it->cantidad ?> </td>
      <td class="textcenter" style="background: #EEF2EA"> <?= $it->duracion ?></td>
      <td class="textright"> <?= number_format( ($it->cantidad * $it->duracion), 2 ) ?> </td>
      <td class="textright">$ <?= number_format($it->tarifa) ?></td>
      <td class="textright">$ <?= number_format($it->valor_plan) ?> </td>
      <?php $valor_gestion += $it->valor_plan; ?>
    </tr>
  <?php endforeach; ?>
  <tr>
    <td colspan="7" class="textcenter">
      SUB-TOTAL: <?= $gestion ?>
    </td>
    <td class="textright">
      $ <?= number_format($valor_gestion, 0) ?>
    </td>
  </tr>
</tbody>
