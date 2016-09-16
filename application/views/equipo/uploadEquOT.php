<div class="windowCentered2 row">
	<section class="area" ng-controller="equipoUP">
    <h4>Carga de personal por OT</h4>

    <div class="" ng-init="initAdjunto('<?= site_url("equipo/uploadFile") ?>')">
      <div id="fileuploader">Archivo</div>
    </div>

		<br><br>

    <br>
    <div class="btnWindow">
			<button type="button" class="waves-effect waves-light btn" ng-click="IniciarUploadAdjunto()">Realizar carga</button>
			<button type="button" class="waves-effect waves-light btn red" ng-click="cerrarWindow()">Cerrar</button>
			<button type="button" class="waves-effect waves-light btn grey" ng-click="toggleWindow()">Ocultar</button>
	  </div>
  </section>
</div>
