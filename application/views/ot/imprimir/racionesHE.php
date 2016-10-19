<table>
  <thead>
    <tr class="ligth-green">
      <th>6</th>
      <th>RACIONES Y HORAS EXTRA</th>
      <th colspan="6"></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="width:5%"></td>
      <td style="width:58%">Horas Extras</td>
      <td style="width:6%"></td>
      <td style="width:5%"></td>
      <td style="width:5%"></td>
      <td style="width:5%"></td>
      <td style="width:8%"></td>
      <td class="textright" style="width:8%">$ <?= number_format( round($horas_extra->valor_horas_extra), 0) ?></td>
    </tr>
    <tr>
      <td></td>
      <td>Raciones</td>
      <td></td>
      <td> <?= $horas_extra->raciones_cantidad ?></td>
      <td> <?= number_format( round($horas_extra->raciones_valor_und), 0) ?> </td>
      <td></td>
      <td></td>
      <td class="textright">$ <?= number_format( round($horas_extra->raciones_cantidad*$horas_extra->raciones_valor_und), 0) ?> </td>
    </tr>
    <tr>
      <td></td>
      <td>Administración</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td class="textright">$ <?= number_format( round($horas_extra->administracion), 0) ?>  </td>
    </tr>
    <tr class="ligth-yellow">
      <td colspan="7" class="textcenter">TOTAL RACIONES Y HORAS EXTRA</td>
      <td class="textright">$ <?= number_format( round($horas_extra->valor_horas_extra)+round($horas_extra->raciones_cantidad*$horas_extra->raciones_valor_und)+round($horas_extra->administracion), 0) ?> </td>
    </tr>
  </tbody>
</table>
