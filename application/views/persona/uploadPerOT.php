<div class="windowCentered2 row">
	<section class="area" ng-controller="personalUp">
    <h4>Carga de personal por OT</h4>

    <div class="" ng-init="initAdjunto('<?= site_url("persona/uploadFile") ?>')">
      <div id="fileuploader">Archivo</div>
    </div>

		<br><br>
		Campos invalidos:
		<table class="mytabla">
			<thead>
				<tr>
					<th>identificacion</th>
					<th>Nombre</th>
					<th>Problema</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>

    <br>
    <div class="btnWindow">
			<button type="button" class="waves-effect waves-light btn" ng-click="IniciarUploadAdjunto()">Realizar carga</button>
			<button type="button" class="waves-effect waves-light btn red" ng-click="cerrarWindow()">Cerrar</button>
			<button type="button" class="waves-effect waves-light btn grey" ng-click="toggleWindow()">Ocultar</button>
	  </div>
  </section>
</div>
