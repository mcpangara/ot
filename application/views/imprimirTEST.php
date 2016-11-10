<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <style media="screen">
      table{border-collapse: collapse;}
      td, th{
        border: 1px solid #333;
      }
    </style>

    <h1>test de impresion de tablas</h1>

    <table>
        <tr>
          <th>Test</th>
          <th>Test</th>
          <th>Test</th>
          <th>Test</th>
        </tr>
        <?php
        for ($i=0; $i < 20; $i++) {
        ?>
        <tr>
          <td>TEST<?= $i ?></td>
          <td>TEST<?= $i ?></td>
          <td>TEST<?= $i ?></td>
          <td>TEST<?= $i ?></td>
        </tr>
        <?php
        }
        ?>
    </table>

  </body>
</html>
