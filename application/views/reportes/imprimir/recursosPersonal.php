<table class="font9">
  <thead style="background:#EEE">
    <tr>
      <th rowspan="2" class="">identificacion</th>
      <th rowspan="2" class="w20">Nombre Completo</th>
      <th rowspan="2" class="">Item</th>
      <th rowspan="2" class="w25">Cargo</th>
      <th rowspan="2" class="">C/L</th>
      <th rowspan="2" class="">B/O/N</th>
      <th rowspan="2" class="">Und.</th>
      <th colspan="2" class="">Horario</th>
      <th colspan="4" class="">Horas trabajadas</th>
      <th rowspan="2" class="">Alm</th>
      <th rowspan="2" class="">Rac</th>
      <th rowspan="2" class="">G. viaje</th>
    </tr>
    <tr>
      <th class="">Hr. Ini</th>
      <th class="">Hr. fin</th>
      <th class="">Día/ H.O.</th>
      <th class="">HED</th>
      <th class="">HEN</th>
      <th class="">HRN</th>
    </tr>
  </thead>
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
          <td><?= (isset($v->hr_almuerzo) && $v->hr_almuerzo)?'SI':''; ?></td>
          <td><?= (isset($v->racion) && $v->racion)?'SI':''; ?></td>
          <td><?= (isset($v->gasto_viaje) && $v->gasto_viaje)?'SI':''; ?></td>
        </tr>
      <?php endforeach; ?>
        <tr>
          <td colspan="8">
            Convenciones para novedadesd del personal: B: Basico/ O: Opcional / N: No Facturable/ D: Descanso compensario/ A: Ausente sin permiso/ I: Incapacidad por accidente de trabajo/
            IC: incapacidad por emfermedad común/ S: Sancionado/ ACSP: Ausente con permiso sin pago/ ACCP: Ausente con permiso con pago/ V: Vacaciones/ P: Pernoctó/ R: Retornó
          </td>
          <td>TOTAL:</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
  </tbody>
</table>
