  <!-- -->
  <form action="<?= site_url('ordentrabajo/delete') ?>" method="post" >
    <p>
      ¿Esta seguro que desea eliminar la OT: <?= $ot->nombre_ot ?>?
    </p>
    <input type="hidden" name="idot" value="<?= $ot->idot ?>" />
    <button type="submit" name="button" class="button alert">Confirmar borrado</button>
    <a href="<?= site_url('ordentrabajo/crud') ?>" class="button warning">Cancelar</a>
  </form>
