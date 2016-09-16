<div class="controles">

	<div class="opciones-menu" style="position:absolute;">
		<div class="opcion-tab row" style="margin-bottom:0">
			<button class="waves-effect waves-light blue btn"  ng-click="slideOtp('#slideOpciones')">
				<small data-icon="o"> Opciones</small>

				<small class="slide-state" data-icon="&#xe026;" ng-show="showSlideState"></small>
				<small class="slide-state" data-icon="&#xe029;" ng-show="!showSlideState"></small>
			</button>
		</div>

		<div class="row" id="slideOpciones" style="padding:3px; background: #FFF; border-radius:5px; border:1px solid #aaa;">
			<ul>
				<li>
					<a href="#" ng-click="getFromMenu('#MenuOT','#slideOpciones')" data-icon="&#xe009;">
						Planear O.T.
					</a>
				</li>
				<li>
					<a href="#" ng-click="getFromMenu('#MenuReportes','#slideOpciones')" data-icon="3">
						Reportes diarios.
					</a>
				</li>
				<hr>

				<li>
					<a href="#" ng-click="getFromMenu('#MenuMaestros','#slideOpciones')" data-icon="&#xe050;">
					  Maestros (Disabled)
					</a>
				</li>
		    </ul>
		</div>
	</div>

	<div class="opciones-area">
		<br><br>
		<?php $this->load->view("inicio/init_content") ?>
  </div>
</div>
<br>


</div>
