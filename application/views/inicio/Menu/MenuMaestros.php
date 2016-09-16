	<div class="row">
		<h3>Maestros de la aplicación</h3>

		<div class="col l2">
			<a href="#" ng-click="clickeableLink('<?= site_url('persona/listado') ?>', $event, 'Personal');" class="btn-panel" style="width:100%">
				<h3 class="center-align" data-icon="&#xe047;"></h3>
				<p class="center-align">Personal</p>
			</a>
		</div>

		<div class="col l2">
			<a href="#" ng-click="clickeableLink('<?= site_url('persona/byOT') ?>', $event, 'Personal por OT');" class="btn-panel" style="width:100%">
				<h3 class="center-align" data-icon="&#xe047;"></h3>
				<p class="center-align">Personal x OT</p>
			</a>
		</div>

		<div class="col l2">
			<a href="#" class="btn-panel" style="width:100%" ng-click="clickeableLink('<?= site_url('equipo/listado') ?>', $event, 'Equipos');">
				<h3 class="center-align" data-icon="&#xe042;"></h3>
				<p class="center-align">Equipos</p>
			</a>
		</div>

		<div class="col l2">
			<a href="#" class="btn-panel teal darken-3 white-text" style="width:100%">
				<h3 class="center-align" data-icon="*"></h3>
				<p class="center-align">ITEM contrato.</p>
			</a>
		</div>

		<div class="col l2">
			<a href="#" class="btn-panel teal darken-3 white-text" style="width:100%">
				<h3 class="center-align" data-icon="*"></h3>
				<p class="center-align">ITEM Fact.</p>
			</a>
		</div>

	</div>
