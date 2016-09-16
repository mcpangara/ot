<section class="area" >

  <div class="">
    <h5>Listado de Ordenes de trabajo para reportes diarios</h5>
  </div>

  <hr>

  <div class="">
  <table id="tableListOT2" class="cell-border compact">
    <thead>
      <tr>
        <th>Base</th>
        <th>Nombre</th>
        <th>fecha de creacion</th>
        <th>Opciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($ots->result() as $ot): ?>
        <tr>
          <td><?= $ot->base_idbase ?></td>
          <td><?= $ot->nombre_ot ?></td>
          <td><?= $ot->fecha_creacion ?></td>
          <td>
            <button type="button" class="btn mini-btn" name="button" ng-click="verCalendario( '<?= site_url('ot/testCalendar/'.$ot->idOT) ?>', '#tarj2')">Reportes de esta OT</button>
            <a href="<?= site_url('ot/imprimirOT/'.$ot->idOT) ?>" class="btn mini-btn orange black-text" data-icon=";"></a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</section>


<script>
  $(document).ready(function(){
    $("#tableListOT2").DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"
        }
    });
  });
</script>
