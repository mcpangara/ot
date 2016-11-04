<form class="" action="<?= site_url('recurso/exporExcel') ?>" method="post">
  <textarea name="html" style="display:none"><?= $html ?></textarea>
  <button type="submit" class="btn mini-btn">Exportar</button>
</form>

<?php echo $html; ?>
