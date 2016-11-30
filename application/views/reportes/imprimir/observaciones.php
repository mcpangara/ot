<table class="font7">
  <thead style="background:#EEE">
    <tr>
      <th>Observaciones del Contratista</th>
      <th>Observaciones del Cliente</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($observaciones as $key => $v): ?>
      <tr>
        <td><?= $v->msj ?></td>
        <td></td>
      </tr>
    <?php endforeach; ?>
    <?php
    for ($i=0; $i <= (1 -  sizeof($observaciones) ); $i++) {
    ?>
    <tr>
      <td> </td>
      <td> &nbsp;</td>
    </tr>
    <?php
    }
    ?>
  </tbody>
</table>
<table class="font9">
  <thead style="background:#EEE">
    <tr>
      <th> Elaborado por </th>
      <th> Representante del contratista</th>
      <th> Representante del cliente</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Nombre: <?= isset($json_r->elaborador_nombre)?$json_r->elaborador_nombre:''; ?></td>
      <td>Nombre: <?= isset($json_r->contratista_nombre)?$json_r->contratista_nombre:''; ?></td>
      <td>Nombre: <?= isset($json_r->ecopetrol_nombre)?$json_r->ecopetrol_nombre:''; ?></td>
    </tr>
    <tr>
      <td> <br> Firma: </td>
      <td> <br> Firma: </td>
      <td> <br> Firma: </td>
    </tr>
    <tr>
      <td>Cargo: <?= isset($json_r->elaborador_cargo)?$json_r->elaborador_cargo:''; ?></td>
      <td>Cargo: <?= isset($json_r->contratista_cargo)?$json_r->contratista_cargo:''; ?></td>
      <td>Cargo: <?= isset($json_r->ecopetrol_cargo)?$json_r->ecopetrol_cargo:''; ?></td>
    </tr>
  </tbody>
</table>
