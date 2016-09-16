    <table id="logo">
      <tr>
        <td>
          <img src="<?= base_url('assets/reporter/ecp.png') ?>" style="width: 320px" />
        </td>
        <td>
          <img src="<?= base_url('assets/reporter/termo.jpg') ?>" style="max-width: 160px" />
        </td>
      </tr>
    </table>

    <table id="nom_contrato">
      <tr>
        <td style="text-align: center">
          CONTRATO No. MA-0032887
          <br>
          Ejecución obras y trabajos de mantenimiento del sistema de trasporte de hidrocarburos. Zona <?= str_replace('_', ' ', $ot->zona) ?>
        </td>
      </tr>
    </table>

    <table>
      <tr>
        <td style="width:25%"></td>
        <td style="width:25%"></td>
        <td style="text-align: right">Orden  de trabajo No.</td>
        <td> <?= $ot->nombre_ot ?></td>
      </tr>
      <tr>
        <td style="text-align: right">ZONA </td>
        <td> <?= $ot->zona ?></td>
        <td style="text-align: right">BASE </td>
        <td> <?= $ot->nombre_base ?></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td style="text-align: right"> ESPECIALIDAD </td>
        <td> <?= $ot->nombre_especialidad ?></td>
      </tr>
    </table>

    <table>
      <thead>
        <tr>
          <th style="text-align: center; width:60%">ACTIVIDAD</th>
          <th style="text-align: center" colspan="4">REQUERIEMIENTOS</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?= $ot->actividad ?></td>
          <td colspan="4">
            PERMISO DE PREDIO
            &nbsp;
            PERMISO OCUPACION CAUSE
            &nbsp;
            CURSO F.T.S
            &nbsp;
            DIVULGACION DE COMUNIDAD
            &nbsp;
            PERMISO DE APROVECHAMIENTO FORESTAL
          </td>
        </tr>
      </tbody>

      <thead>
        <tr>
          <th style="width:60%">JUSTIFICACION</th>
          <th>FECHA CREACION OT</th>
          <th>FECHA INICIO</th>
          <th>FECHA FIN</th>
          <th>PLAZO PLANEADO</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?= $ot->justificacion ?></td>
          <td><?= date('Y-m-d', strtotime($ot->fecha_creacion)) ?></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>

      <thead>
        <tr>
          <th colspan="2">LOCACION</th>
          <th colspan="2">ABSCISA</th>
          <th>TIPO</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="2"><?= $ot->locacion ?></td>
          <td colspan="2"><?= $ot->abscisa ?></td>
          <td><?= $ot->nombre_tipo_ot ?></td>
        </tr>
      </tbody>

      <thead>
        <tr>
          <th colspan="2">VEREDA</th>
          <th>MUNICIPIO</th>
          <th colspan="2">DEPARTAMENTO</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="2"><?= $ot->centropoblado ?></td>
          <td><?= $ot->municipio ?></td>
          <td colspan="2"><?= $ot->departamento ?></td>
        </tr>
      </tbody>
    </table>
