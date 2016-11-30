<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body>
  <style media="screen">
    @page { margin: 20px; }
    body { margin: 0px; }
    table{
      width: 100%;
      max-width: 100%;
      border-collapse: collapse;
    }
    table, td, th {
      border: 1px solid #777;
      vertical-align: top;
    }
    table.inner, table.inner td, table.inner th{
      vertical-align: top;
    }
    .font10 {
      font-size: 10px;
    }
    .font9, .font9 *{
      font-size: 9px;
    }
    .font8, .font8 *{
      font-size: 8px;
    }
    .font7, .font7 *{
      font-size: 8px;
    }
    .w5{
      width: 5em;
    }
    .w8{
      width: 18px
    }
    .w15{
      width: 15em;
    }
    .w20{
      width: 20em;
    }
    .w25{
      width: 25em;
    }
  </style>
    <?php $this->load->view('reportes/imprimir/info', array('r'=>$r, 'json_r'=>$json_r)); ?>
    <?php $this->load->view('reportes/imprimir/recursosPersonal', array('recursos'=>$recursos)); ?>
    <?php $this->load->view('reportes/imprimir/recursosEquipos', array('recursos'=>$recursos)); ?>
    <?php $this->load->view('reportes/imprimir/recursosActividades', array('recursos'=>$recursos)); ?>
    <?php $this->load->view('reportes/imprimir/observaciones', array('observaciones'=>$json_r->observaciones, 'json_r'=>$json_r)); ?>

  </body>
</html>
