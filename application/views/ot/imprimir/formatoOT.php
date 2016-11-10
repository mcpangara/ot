    <style media="screen">
      @page { margin-top: 370px; }
      #cabecera{
        position: fixed;
        background: #FFF;
        left: 0px;
        right: 0px;
        top: -330px;
      }
      table td, table th{
        margin: 0;
        padding: 2px;
        border: 1px solid #333;
        font-size: 9px;
        height: 4ex;
      }

      table{
        border-collapse: collapse;
        margin-bottom: 4px;
        width: 100%;
      }
      table th{
        background: #13D620;
        text-align: center;
      }
      .ligth-yellow th, .ligth-yellow td{
        background: #FFFACE;
      }
      .ligth-green th, .ligth-green td{
        background: #C9F9B1;
      }
      table tr .td50{
        width: auto;
      }
      table tr .textcenter{
        text-align: center;
      }
      table tr .textright{
        text-align: right;
      }
      table tr .textleft{
        text-align: left;
      }
    </style>

    <div id="cabecera">
      <?php $this->load->view('ot/imprimir/descripcionOT', array('ot'=>$ot)); ?>
    </div>
    <div class="spacer">

    </div>

    <table>
      <?php $this->load->view('ot/imprimir/itemsplanOT', array('items'=>$acts, 'no_gestion'=>1, 'gestion'=>'ACTIVIDADES', 'tr'=>$tr, 'subTotal'=>$sub_acts) ); ?>
      <?php $this->load->view('ot/imprimir/itemsplanOT', array('items'=>$pers, 'no_gestion'=>2, 'gestion'=>'PERSONAL', 'tr'=>$tr, 'subTotal'=>$sub_pers) ); ?>
      <?php $this->load->view('ot/imprimir/itemsplanOT', array('items'=>$equs, 'no_gestion'=>3, 'gestion'=>'EQUIPOS', 'tr'=>$tr, 'subTotal'=>$sub_equs) ); ?>
      <tbody>
        <tr style="background: #F2F989">
          <td colspan="7" class="textcenter">
            TOTAL COSTO DIRECTO
          </td>
          <td class="textright">
            <b>$ <?= number_format(($sub_acts+$sub_pers+$sub_equs), 0) ?></b>
          </td>
        </tr>
      </tbody>
    </table>

    <?php $this->load->view('ot/imprimir/costosIndOT', array()); ?>

    <?php $this->load->view('ot/imprimir/gastosViajeOT',array()); ?>

    <?php $this->load->view('ot/imprimir/racionesHE', array()); ?>

    <?php $this->load->view('ot/imprimir/reembolsablesOT',array()); ?>

    <table>
      <thead>
        <tr>
          <th style="background: #F2F989">VALOR TOTAL ORDEN DE TRABAJO No. <?= $ot->nombre_ot ?></th>
          <th style="background: #F2F989">$  <?= number_format($tr->valor_tarea_ot, 0); ?></th>
        </tr>
      </thead>
    </table>

    <table>
      <tbody>
        <tr>
          <td colspan="2" class="textcenter" style="background: #EEE">
            Observaciones
          </td>
        </tr>
        <tr>
          <td colspan="2" class="textcenter">
            El valor final del la orden de trabajo es el resultado de multiplicar
            las cantidades realmente ejecutadas por el valor de las tarifas pactadas en el contrato MA-0032887.
            <br><br>
            <br>
            <br>
          </td>
        </tr>
      </tbody>
    </table>

    <table>
      <thead>
        <tr>
          <th style="width: 5%; background: #EEE;">REGISTRO</th>
          <th style="width: 40%; background: #EEE;">NOMBRE</th>
          <th style="width: 20%; background: #EEE;">CARGO</th>
          <th style="width: 20%; background: #EEE;">ANEXOS</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td></td>
          <td></td>
          <td class="textcenter" style="vertical-align: bottom">FIRMA RESIDENTE EJECUTOR</td>
          <td rowspan="3">
            <img src="<?= base_url('assets/img/requisitos.png') ?>" style="width: 150px" />
          </td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td class="textcenter" style="vertical-align: bottom">FIRMA </td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td class="textcenter" style="vertical-align: bottom">FIRMA ECOPETROL</td>
        </tr>
      </tbody>
    </table>
