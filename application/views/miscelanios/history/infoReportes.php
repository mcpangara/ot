<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="InformeReportes.xls"');
header('Cache-Control: max-age=0');
?>
<style media="screen">
  td, th{
    border: 1px solid #999;
  }
</style>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<table class="mytabla">
  <thead>
    <tr>
      <?php foreach ($rows->list_fields() as $val): ?>
        <th> <?= $val ?> </th>
      <?php endforeach; ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rows->result() as $key => $value): ?>
      <tr>
        <?php foreach ($value as $k => $v): ?>
          <td >
            <?= $v ?>
            <?= ($k=='tipo' && ($v == '' || $v == NULL) )? 'APU' :''; ?>
          </td>
        <?php endforeach; ?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
