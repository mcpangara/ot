<table>
  <thead>
    <tr class="ligth-green">
      <th>5</th>
      <th>GASTOS DE VIAJE</th>
      <th colspan="6"></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="width:5%"></td>
      <td style="width:58%">Gastos de viaje</td>
      <td style="width:6%"></td>
      <td style="width:5%"></td>
      <td style="width:5%"></td>
      <td style="width:5%"></td>
      <td style="width:8%"></td>
      <td class="textright" style="width:8%">$ <?= number_format( round($viaticos->valor_viaticos), 0) ?></td>
    </tr>
    <tr>
      <td></td>
      <td>Administacion</td>
      <td>%</td>
      <td></td>
      <td></td>
      <td>4.58%</td>
      <td></td>
      <td class="textright">$ <?= number_format( round($viaticos->administracion), 0) ?> </td>
    </tr>
    <tr class="ligth-yellow">
      <td colspan="7" class="textcenter">TOTAL GASTOS DE VIAJE</td>
      <td class="textright">$ <?= number_format( round($viaticos->valor_viaticos)+round($viaticos->administracion), 0)  ?> </td>
    </tr>
  </tbody>
</table>
