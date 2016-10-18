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
      <td style="width:8%" >$ <?= number_format(ceil( $reembolsables->valor_reembolsables), 0) ?></td>
    </tr>
    <tr>
      <td></td>
      <td>Administración</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td>$ <?= number_format(ceil($reembolsables->administracion), 0) ?></td>
    </tr>
    <tr class="ligth-yellow">
      <td colspan="7" class="textcenter">TOTAL GASTOS REEMBOLSABLES</td>
      <td>$ <?= number_format(ceil( $reembolsables->administracion + $reembolsables->valor_reembolsables ), 0) ?></td>
    </tr>
  </tbody>
</table>
