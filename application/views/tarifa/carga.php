
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/gestiones.css') ?>">
	<section class="gestion columns" ng-app="tarifa" ng-controller="new">
		<h2>Proceso de carga de tarifas</h2>
		<div class="panel-normal panel column medium-12" id="carga">
			<h4>Subir archivo de nuevas tarifas</h4>	<p>Recuerde, el archivo debe estar organizado de la siguiente manera por celdas: codigo, descripcion, unidad, tarifa y estado.</p>

			<?= date_format(date_create("2013-03-15"), "d-m-Y" ) ?>

			<table>
				<tr>
					<th>codigo</th>
					<th>descripcion</th>
					<th>unidad</th>
					<th>tarifa</th>
					<th>estado</th>
				</tr>
			</table>

		<div id="div-upload">
				<div id="uploader">Subir tarifas</div>
			</div>
			<br>
			<button id="btn-validar" ng-click="go('tarifa/precarga')" class="button round novo">Validar carga <b style="color:#809900" data-icon="k"></b></button>

			<p id="status">
			</p>
		</div>

		<div id="response" class="column medium-8" style="overflow:auto; max-height:1000px;" ng-hide="error">
			<table>
				<thead>
					<tr>
						<th data-icon="3"> Codigo</th>
						<th>Descripción</th>
						<th>Unidad</th>
						<th>tarifa</th>
						<th>fecha de operacion</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="it in data">
						<td>{{ it.codigo }}</td>
						<td>{{ it.descripcion }}</td>
						<td>{{ it.unidad }}</td>
						<td>{{ it.tarifa }}</td>
						<td>{{ it.fecha_inicio }}</td>
					</tr>
				</tbody>
			</table>
		</div>

		<p clasS="alert label" ng-show="error">
			ha ocurrido un error al cargar los datos cargados en el archivo de excel, es probable que los datos no cuenten con una integridad minima requerida.
		</p>

		<div id="confirmar" class="column medium-3">
				<textarea name="data" style="display:none">{{data |json}}</textarea>
				<button id="btn-confirmar" class="button round success" ng-click="submit()">
					Confirmar nuevas tarifas <b style="color:#FFF" data-icon="k"></b>
				</button>
		</div>

	</section>

	<style type="text/css">
		#response, #confirmar{
			display: none;
		}
		#btn-validar{
			display: none;
		}
	</style>

	<script type="text/javascript">
		function addArchivo(){
			$("#uploader").uploadFile({
				url:"<?= site_url('tarifa/upload_doc') ?>",
				fileName:"file",
				onSuccess:function(files,data,xhr,pd){
					console.log(data);
					if(data == "success"){
						$("#div-upload").hide();
						$("#btn-validar").show("slow");
						$("#response").show("slow");
					}else{
						alert(JSON.stringify(data));
					}
				},
				onError: function(files,status,errMsg,pd){
					alert(JSON.stringify(data));
				}
			});
		}

		$(document).ready(function(){
			addArchivo();
		});

		var app = angular.module("tarifa",[]);
		app.controller("new",function($scope, $http){
			$scope.data= [];
			$scope.error = false;

			$scope.go = function(link){
				//Inicio de la petición
				$http.get("<?= site_url(); ?>/"+link)
				.then(
					function(data){
						console.log(data);
						if(data.data == "error"){
							$scope.error = true;
							$("#div-upload").show("slow");
							$("#btn-validar").hide("slow");
							$("#confirmar").hide("slow");
						}else {
							$scope.data = data.data;
							$("#btn-validar").hide("slow");
							$("#confirmar").show("slow");
						}
					}
				).catch(
					function(err){
						console.log(JSON.stringify(err));
					}
				);
				//fin de petición
			}

			$scope.submit = function(){
				$http.post("<?=  site_url('tarifa/aplicar') ?>",{tarifas:$scope.data})
				.then(function(response){
					console.log(JSON.stringify(response.data));
					if(response.data == "success"){
						window.location = "<?= site_url(); ?>";
					}else{
						console.log(JSON.stringify(response.data)+ " no aplicó")
					}
				})
				.catch(function(err){
					alert(JSON.stringify(err));
				});
			}

		});
	</script>
