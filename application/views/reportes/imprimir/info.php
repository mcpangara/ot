<table>
  <thead>
    <tr class="font10">
      <th colspan="1 "> <img src="<?= base_url('assets/img/termotecnica.jpg') ?>" style="max-width: 70px" alt=""> </th>
      <th colspan="6">REPORTE DIARIO DE TIEMPO TRABAJADO Y ACTIVIDADES DE OBRA EJECUTADA</th>
    </tr>
  </thead>
  <tbody class="font8">
    <tr>
      <td>CONTRATO: MA-0032887</td>
      <td  colspan="2">
        EJECUCIÓN DE OBRAS Y TRABAJOS DE MANTENIMIENTO DE SISTEMAS DE TRANSPORTE DE HIDROCARBUROS
      </td>
      <td colspan="3" style="padding:0">
            <table style="">
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
                    <td><?= date('m', strtotime($r->fecha_reporte)) ?></td>
                    <td><?= date('Y', strtotime($r->fecha_reporte)) ?></td>
                  </tr>
                </tbody>
            </table>
      </td>
      <td>Día: Lunes</td>
    </tr>

    <tr class="noBorder-bottom font8">
      <td colspan="1">
        O.T. No.:
        <div class="">
          <?= $r->nombre_ot ?>
        </div>
      </td>
      <td colspan="3"><?= $r->actividad ?></td>
      <td colspan="3">
        Festivo: <?= $r->festivo?'SI':'NO'; ?>
      </td>
    </tr>

    <tr class="noBorder-top font8">
      <td>
        Planta/Estación:
      </td>
      <td>base: <?= $r->nombre_base ?></td>
      <td>C.O.: <?= $r->base_idbase ?></td>
      <td>K.P.: <?= isset($json_r->pk)?$json_r->pk:''; ?></td>
      <td colspan="2">Abscisa: <?= $r->abscisa ?></td>
      <td>Vereda: <?= isset($r->vereda)?$r->vereda:''; ?></td>
    </tr>
    <tr>
      <td>Municipio: <?= isset($r->municipio)?$r->municipio:''; ?></td>
      <td colspan="1">Coordenadas GPS: <?= isset($json_r->coordenadas)?$json_r->coordenadas:''; ?></td>
      <td colspan="3">Linea: <?= $r->nombre_especialidad ?></td>
      <td colspan="2">Centro Costo ECP: <?= $r->cc_ecp ?></td>
    </tr>
  </tbody>
</table>

<table class="font8">
  <thead>
    <tr style="background: #EEE">
      <th>Condiciones climaticas</th>
      <th>Terreno</th>
      <th>Seguridad Ambiental</th>
      <th>Actividades</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="padding:0">
          <table class="inner">
            <thead>
              <tr>
                <th rowspan="2"> </th>
                <th>Hora inicio</th>
                <th>Hora final</th>
                <th>Total horas</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td> <?= isset($json_r->hr_inicio_lluvia )?$json_r->hr_inicio_lluvia :' - '; ?> </td>
                <td> <?= isset($json_r->hr_fin_lluvia)?$json_r->hr_fin_lluvia:' - '; ?></td>
                <td> <?= isset($json_r->total_hr_clima)?$json_r->total_hr_clima:' - '; ?></td>
              </tr>
              <tr>
                <td colspan="4"><?= isset($json_r->noche_anterior)?$json_r->noche_anterior:''; ?></td>
              </tr>
            </tbody>
          </table>
      </td>
      <td><?= isset($json_r->terreno)?$json_r->terreno:''; ?></td>
      <td><?= isset($json_r->seguridad_ambiental)?$json_r->seguridad_ambiental:''; ?></td>
      <td style="padding:0">

          <table>
            <thead>
              <tr>
                <th colspan="4">ILICITAS:</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Extensión: <?= isset( $json_r->actividad->extension)? $json_r->actividad->extension:''; ?></td>
                <td>Diametro: <?= isset($json_r->actividad->diametro)?$json_r->actividad->diametro:''; ?> </td>
                <td>Longitud: <?= isset($json_r->actividad->longitud)?$json_r->actividad->longitud:''; ?> </td>
                <td>Material: <?= isset($json_r->actividad->material)?$json_r->actividad->material:''; ?> </td>
              </tr>
            </tbody>
          </table>

          <table>
            <thead>
              <tr>
                <th colspan="3">REPARACIÓN</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Inst. capuchon: <?= isset($json_r->actividad->capuchon)?$json_r->actividad->capuchon:''; ?></td>
                <td>Inst. cascota: <?= isset($json_r->actividad->cascota)?$json_r->actividad->cascota:''; ?></td>
                <td>Cambio tramo: <?= isset($json->actividad->tramo)?$json->actividad->tramo:''; ?></td>
              </tr>
              <tr>
                <td>Inst. de camisa: <?= isset($json_r->actividad->camisa)?$json_r->actividad->camisa:''; ?> </td>
                <td>Inst. grapa: <?= isset($json_r->actividad->grapa)?$json_r->actividad->grapa:''; ?></td>
                <td>Anillo circurferencial: <?= isset($json_r->actividad->anillo_circunferencial)?$json_r->actividad->anillo_circunferencial:''; ?></td>
              </tr>
              <tr>
                <td colspan="3">Otros: <?= isset($json_r->actividad->otros)?$json_r->actividad->otros:''; ?></td>
              </tr>
            </tbody>
          </table>

      </td>
    </tr>
  </tbody>
</table>
