<section class="area" >

  <div class="">
    <h4>Listado de Ordenes de trabajo</h4>
  </div>

  <hr>

  <div class="">
    <div class="row">
      <!--
      <div class="col m6">
        <label class="">Base</label>
        <select class="" name="">
          <option value="168">168</option>
          <option value="169">169</option>
          <option value="170">170</option>
          <option value="171">171</option>
          <option value="172">172</option>
          <option value="173">173</option>
          <option value="174">174</option>
          <option value="175">175</option>
          <option value="176">176</option>
        </select>
        <button type="button" class="btn mini-btn" name="button" data-icon=","></button>
      </div>
      -->
    </div>
    Agregar una OT:
    <a href="#" ng-click="getAjaxWindow('<?= site_url('ot/addNew') ?>', $event, 'Gestion de OTs');" class="btn mini-btn">
      <big class="center-align" data-icon="&#xe052;"></big>
    </a>
     <br>
     <br>
  </div>

  <table id="tableListOT" class="cell-border compact">
    <thead>
      <tr>
        <th>Base</th>
        <th>Nombre</th>
        <th>fecha de creacion</th>
        <th>Estado</th>
        <th>Opciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($ots->result() as $ot): ?>
        <tr>
          <td><?= $ot->base_idbase ?></td>
          <td><?= $ot->nombre_ot ?></td>
          <td><?= $ot->fecha_creacion ?></td>
          <td>Por aprobar</td>
          <td>
            <button type="button" class="btn mini-btn" name="button" data-icon="&#xe03e;" ng-click="clickeableLink( '#', $event, 'test')"></button>
            <a href="<?= site_url('ot/imprimirOT/'.$ot->idOT) ?>" class="btn mini-btn orange black-text" data-icon=";"></a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</section>


<script>
  $(document).ready(function(){
    $("#tableListOT").DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"
        }
    });
  });
</script>
