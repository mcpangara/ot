
	    <div class="" style="display:block">
	    	<h4>Aplicación web para Ordenes de Trabajo</h4>
	      	<img src="<?= base_url('assets/img/ot.png') ?>" alt="" style="max-width:500px" />
	    </div>

			<div id="MenuOT">
	      <?= $this->load->view('inicio/Menu/MenuOT', NULL, TRUE); ?>
	    </div>

			<div id="MenuReportes">
	      <?= $this->load->view('inicio/Menu/MenuReportes', NULL, TRUE); ?>
	    </div>

	    <div id="MenuMaestros">
	    	<?php $this->load->view('inicio/Menu/MenuMaestros') ?>
	    </div>
