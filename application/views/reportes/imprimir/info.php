<table>
  <thead>
    <tr>
      <th colspan="3"> <img src="<?= base_url('assets/img/termotecnica.jpg') ?>" style="max-width: 150px" alt=""> </th>
      <th colspan="7">REPORTE DIARIO DE TIEMPO TRABAJADO Y ACTIVIDADES DE OBRA EJECUTADA</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>CONTRATO: MA-0032887</td>
      <td  colspan="2">
        EJECUCIÓN DE OBRAS Y TRABAJOS DE MANTENIMIENTO DE SISTEMAS DE TRANSPORTE DE HIDROCARBUROS
      </td>
      <td colspan="3">

        <table>
          <thead>
            <tr>
              <th>DD</th>
              <th>MM</th>
              <th>AA</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?= date('d', strtotime($r->fecha_reporte)) ?></td>
            </tr>
          </tbody>
        </table>

      </td>
    </tr>
  </tbody>
</table>
