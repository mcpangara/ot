<table>
  <thead class="ligth-green">
    <tr>
      <th>4</th>
      <th>COSTOS INDIRECTOS</th>
      <th colspan="6"></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="width:5%"></td>
      <td style="width:58%">ADMINISTRACION</td>
      <td style="width:6%">%</td>
      <td style="width:5%"></td>
      <td style="width:5%"></td>
      <td style="width:5%">19%</td>
      <td style="width:8%"></td>
      <td style="width:8%" class="textright">$ <?= number_format(round($indirectos->administracion),0) ?></td>
    </tr>
    <tr>
      <td></td>
      <td>IMPREVISTOS</td>
      <td>%</td>
      <td></td>
      <td></td>
      <td>1%</td>
      <td></td>
      <td class="textright">$ <?= number_format(round($indirectos->imprevistos),0) ?></td>
    </tr>
    <tr>
      <td></td>
      <td>UTILIDAD</td>
      <td>%</td>
      <td></td>
      <td></td>
      <td>4%</td>
      <td></td>
      <td class="textright">$ <?= number_format(round($indirectos->utilidad),0) ?></td>
    </tr>
    <tr class="ligth-yellow">
      <td colspan="7" class="textcenter">TOTAL COSTOS INDIRECTOS</td>
      <td class="textright">$ <?= number_format( round($indirectos->utilidad)+round($indirectos->imprevistos)+round($indirectos->administracion ) , 0) ?></td>
    </tr>
  </tbody>
</table>
