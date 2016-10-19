<table>
  <thead>
    <tr class="ligth-green">
      <th>7</th>
      <th>GASTOS REEMBOLSABLES</th>
      <th colspan="6"></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="width:5%" ></td>
      <td style="width:58%" >Reembolsables</td>
      <td style="width:6%" ></td>
      <td style="width:5%" ></td>
      <td style="width:5%" ></td>
      <td style="width:5%" ></td>
      <td style="width:8%" ></td>
      <td class="textright" style="width:8%" >$ <?= number_format(round( $reembolsables->valor_reembolsables), 0) ?></td>
    </tr>
    <tr>
      <td></td>
      <td>Administración</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td class="textright">$ <?= number_format(round($reembolsables->administracion), 0) ?></td>
    </tr>
    <tr class="ligth-yellow">
      <td colspan="7" class="textcenter">TOTAL GASTOS REEMBOLSABLES</td>
      <td class="textright">$ <?= number_format(round( $reembolsables->administracion )+round($reembolsables->valor_reembolsables ), 0) ?></td>
    </tr>
  </tbody>
</table>
