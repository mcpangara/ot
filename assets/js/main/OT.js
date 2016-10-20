var OT = function($scope, $http, $timeout){

	$scope.getDataITems = function(url, ambito){
		$http.get(url).then(
			function(response) {
				ambito.bases = JSON.parse(response.data.bases);
				ambito.items = JSON.parse(response.data.items);
			},
			function (response) {
				alert("Algo ha salido mal al cargar esta interfaz, cierra la vista e intenta de nuevo, si el problema persiste comunicate a el area TIC.");
			}
		);
	}
	$scope.getData = function(url, ambito, edit){
		$http.post(url, {}).then(
				function(response){
					ambito.ot = response.data;
					if(edit){
						ambito.recorrerTareas();
					}
				},
				function(response){		alert('Algo ha salido mal al cargar informacion de la OT');		}
			);
	}
	$scope.selectTarea = function(ot, ambito, indice){
		ambito.tr = ot.tareas[indice];
	}
	$scope.unset_item = function(lista, item){
		lista.splice(lista.indexOf(item),1);
	}
	$scope.consola = function(tr){console.log(tr)}
	$scope.addTarea = function(ambito){
		var idot = (ambito.ot.idOT != undefined)?ambito.ot.idOT:"";
		ambito.ot.tareas.push(
				{
					"idtarea_ot": "",
					"nombre_tarea": "TAREA "+(ambito.ot.tareas.length+1),
					"valor_recursos": "0",
					"valor_tarea_ot": "0",
					"json_indirectos": {
						"administracion": 0,
						"imprevistos": 0,
						"utilidad":0
					},
					"json_recursos": {},
					"json_viaticos": {
						"json_viaticos": [],
						"valor_viaticos": 0,
						"administracion": 0
					},
					"json_horas_extra": {
						"json_horas_extra": [],
						"valor_horas_extra": 0,
						"raciones_cantidad": 0,
						"raciones_valor_und": 0,
						"administracion": 0
					},
					"json_reembolsables": {
						"json_reembolsables": [],
						"valor_reembolsables": 0,
						"administracion": 0
					},
					"json_raciones": null,
					"estado_tarea_ot": "",
					"OT_idOT": idot,
					"actividades": [],
					"personal": [],
					"equipos": []
				}
			);
		console.log(ambito.ot.tareas);
	}
	//==============================================================================
	// Gestion de items de OT
	//Muestra items por agregar de un tipo en la ventana. Debe llamarse desde un controller hijo.
	$scope.selectItemsType =  function(type, ambito){
		if(type == 1){
			ambito.myItems = angular.copy(ambito.items['actividad']);
		}else if(type == 2){
			ambito.myItems = angular.copy(ambito.items['personal']);
		}else if(type == 3){
			ambito.myItems = angular.copy(ambito.items['equipo']);
		}
	}
	//Muestra la ventana para add items. Debe llamarse desde un controller hijo.
	$scope.VwITems = function(tipo, ambito){
		$scope.selectItemsType(tipo, ambito);
		$("#ventana_add_items").removeClass('nodisplay');
	}
	$scope.setSelecteState = function(add){
		if(!add){
			add = true;
		}else{
			add = false;
		}
	}
	$scope.addSelectedItems = function(ambito,tr){
		var size = ambito.myItems.length;
		var i = 0;
		ambito.filtro = [];
		angular.forEach(ambito.myItems, function(v,k){
			i++;
			ambito.indexer++;
			if (v.add == true) {
				//console.log(v);
				v.id = ambito.indexer;
				v.fecha_agregado = '';
				v.cantidad = v.cantidad==undefined?1:v.cantidad;
				v.duracion = v.duracion==undefined?1:v.duracion;
				if (v.tipo_item == 1){
					tr.actividades.push(v);
				}else if(v.tipo_item == 2) {
					tr.personal.push(v);
					//generar listado de items de personal para calc. gastos de viaje.
					tr.json_viaticos.json_viaticos = angular.copy(tr.personal);
					tr.json_horas_extra.json_horas_extra = angular.copy(tr.personal);
				}else if(v.tipo_item == 3){
					tr.equipos.push(v);
				}
			};
			if (i == size){
				ambito.myItems = null;
			}
		});
		$scope.calcularSubtotales(ambito, ambito.tr);
		$("#ventana_add_items").addClass('nodisplay');
	}
	$scope.changeFilterSelect = function(fil){
		if(fil.add == undefined){
			fil.add = true;
		}else if (fil.add == true) {
			fil.add = undefined;
		};
	}
	$scope.calcularSubtotales = function(ambito, tr){
		tr.actsubtotal = ambito.recorrerSubtotales(tr.actividades);
		tr.persubtotal = ambito.recorrerSubtotales(tr.personal);
		tr.eqsubtotal = ambito.recorrerSubtotales(tr.equipos);
		//Redondeado de totales
		tr.valor_recursos = Math.round(tr.actsubtotal+tr.persubtotal+tr.eqsubtotal);
		tr.json_indirectos.administracion = Math.round(tr.valor_recursos * 0.18);
		tr.json_indirectos.imprevistos = Math.round(tr.valor_recursos * 0.01);
		tr.json_indirectos.utilidad = Math.round(tr.valor_recursos * 0.04);
	}
	$scope.setTareaAdministracion = function(value, tr){
		if(tr == undefined){ return 0;}
		tr.json_indirectos.administracion = value;
		return value;
	}
	$scope.setTareaImprevistos = function(value, tr){
		if(tr == undefined){ return 0;}
		tr.json_indirectos.imprevistos = value;
		return value;
	}
	$scope.setTareaUtilidad = function(value, tr){
		if(tr == undefined){ return 0;}
		tr.json_indirectos.utilidad = value;
		return value;
	}
	$scope.recorrerSubtotales = function(obj){
		var valor = 0;
		for (var i = 0; i < obj.length; i++) {
			valor += obj[i].tarifa * (obj[i].cantidad * obj[i].duracion);
		};
		return valor;
	}
		//====================================================================================
	// Viaticos
	$scope.setViaticos = function(tag, tr, ambito){
		$(tag).removeClass("nodisplay");
		ambito.itemsViaticos = tr.json_viaticos.json_viaticos;
	}
	$scope.applyViatico = function(itv, url){
		$http.get(url+"/"+itv.destino)
			.then(
				function(response){
					datos = response.data;
					itv.cantidad_gv = 1;
					itv.duracion_gv = 1;
					itv.alojamiento = parseInt(datos.alojamiento);
					itv.transporte = parseInt(datos.transporte);
					itv.alimentacion = parseInt(datos.alimentacion);
					itv.miscelanios = parseInt(datos.miscelanios);
				},
				function(response){
					alert(JSON.stringify(response.data))
				}
			);
	}
	$scope.calcularViaticos =  function(tr, ambito){
		ambito.viaticos = 0;
		angular.forEach(tr.json_viaticos.json_viaticos, function(v,k){
			if (v.destino == '' ||  v.destino == undefined || v.destino == null || v.destino == 'undefined'){ 
				ambito.viaticos += 0; 
			}
			else {
				ambito.viaticos += (v.alojamiento + v.transporte + v.alimentacion + v.miscelanios) * (v.cantidad_gv * v.duracion_gv) ;
			}
		});
		if ( tr.json_viaticos.json_viaticos == undefined || tr.json_viaticos.json_viaticos.length == 0 ) {
			ambito.viaticos = 0;
		}
		tr.json_viaticos.valor_viaticos = ambito.viaticos;
		tr.json_viaticos.valor_viaticos = Math.round( tr.json_viaticos.valor_viaticos );
		tr.json_viaticos.administracion = ( tr.json_viaticos.valor_viaticos* ( 4.58 /100) );
		tr.json_viaticos.administracion = Math.round( tr.json_viaticos.administracion );
		$("#addViaticosOT").addClass('nodisplay');
	}
	//===================================================================================================================
	// Reembolsables
	$scope.setReembolsables = function(tag, tr){
		$(tag).toggleClass('nodisplay');
	}
	$scope.calcularReembolsables = function(tr, ambito){
		tr.json_reembolsables.valor_reembolsables = 0;
		tr.json_reembolsables.administracion = 0;
		angular.forEach(ambito.reembs, function(v, k){
			tr.json_reembolsables.valor_reembolsables +=(v.cantidad * v.valor_und);
			tr.json_reembolsables.valor_reembolsables = Math.round(tr.json_reembolsables.valor_reembolsables);
			tr.json_reembolsables.administracion += tr.json_reembolsables.valor_reembolsables * 0.01;
			tr.json_reembolsables.administracion = Math.round( tr.json_reembolsables.administracion );
		});
	}
	$scope.endReembolsables = function(tag, tr, ambito){
		$(tag).toggleClass('nodisplay');
		$scope.calcularReembolsables(tr, ambito);
		tr.json_reembolsables.json_reembolsables = ambito.reembs;
	}
	$scope.addReemb = function(ambito){
		ambito.reembs.push(
			{
				descripcion:ambito.reemb.descripcion,
				unidad: ambito.reemb.unidad,
				cantidad: ambito.reemb.cantidad,
				valor_und: ambito.reemb.valor_und
			}
		);
		ambito.reemb.descripcion='';
		ambito.reemb.unidad ='';
		ambito.reemb.cantidad = 0;
		ambito.reemb.valor_und = 0;
	}
	//===================================================================================================================
	// horas extra
	$scope.setHorasExtra = function(tag , tr, ambito){
		//console.log(tr.horas_extra);
		ambito.horas_extra = tr.json_horas_extra.json_horas_extra;
		$(tag).toggleClass('nodisplay');
	}
	$scope.calcularTotalItem = function(item) {
		item.total = (item.total_hed);
		item.total += (item.total_hen);
		item.total += (item.total_hefd);
		item.total += (item.total_hefn);
		item.total += (item.total_hfr);
		item.total = Math.round( (item.total * 1.6196) * item.cantidad_he );
	}
	$scope.subtotal_he = function(item, base, porcentaje, cantidad, tipo){
		if (tipo == 'hed') {
			item.total_hed = (base*porcentaje)*cantidad;
		}else if (tipo=='hen') {
			item.total_hen = (base*porcentaje)*cantidad;
		}else if (tipo=='hefd') {
			item.total_hefd = (base*porcentaje)*cantidad;
		}else if (tipo == 'hefn') {
			item.total_hefn = (base*porcentaje)*cantidad;
		}else if(tipo == 'hfr'){
			item.total_hfr = (base*porcentaje)*cantidad;
		}
		$scope.calcularTotalItem(item);
	}
	$scope.calcularHorasExtra = function(tr, ambito){
		val = 0;
		angular.forEach(tr.json_horas_extra.json_horas_extra, function(v,k){
			val += v.total;
			tr.json_horas_extra.valor_horas_extra = Math.round(val);
			tr.json_horas_extra.administracion = Math.round( (tr.json_horas_extra.valor_horas_extra + (tr.json_horas_extra.raciones_cantidad * tr.json_horas_extra.raciones_valor_und)) * 0.01 );
		});
	}
	$scope.endHorasExtra = function(tag, tr, ambito){
		$scope.calcularHorasExtra(tr, ambito);
		$(tag).toggleClass('nodisplay');
	}
	//Calculos de OT
	$scope.calcularValorOT = function(ambito){
		ambito.ot.valor_ot = 0;
		angular.forEach(ambito.ot.tareas, function(tarea, key){
			$scope.calcularSubtotales(ambito, tarea);

			$scope.calcularHorasExtra(tarea, ambito);
			$scope.calcularReembolsables(tarea, ambito);
			$scope.calcularViaticos(tarea, ambito);

			var he = tarea.json_horas_extra.valor_horas_extra + tarea.json_horas_extra.administracion;
			var rm = tarea.json_reembolsables.administracion + tarea.json_reembolsables.administracion;
			var gv = tarea.json_viaticos.valor_viaticos + tarea.json_viaticos.administracion;
			var id = tarea.json_indirectos.administracion + tarea.json_indirectos.utilidad + tarea.json_indirectos.imprevistos;
			var tar = tarea.valor_recursos;
			tarea.valor_tarea_ot = (he + rm + gv + id + tar);
			ambito.ot.valor_ot += tarea.valor_tarea_ot;
			console.log('>> Valor OT: '+ambito.ot.valor_ot);
		});
		console.log(ambito.ot.tareas);
	}
	//Vendors
	$scope.tinyMCE = function(){
		tinymce.init({
  			selector: "textarea"
  		});
	}
	$scope.strtonum = function(model)
	{
		return parseFloat(model);
	}
	//--------------------------------------------------------------------------------------
	// Municipios y locaciones
	$scope.obtenerMunicipios = function(depart,url,ambito){
		ambito.poblado = '';
		$http.post(url, {departamento: depart}).then(
				function(response){ ambito.munis= response.data;	},
				function(response){ alert("Falló comunicación con server");	}
			);
	}

	$scope.obtenerVeredas = function(municip,url, ambito){
		$http.post(url, {municipio: municip}).then(
				function(response){
					ambito.poblados= response.data;
					ambito.poblado = ambito.poblados[0].idpoblado;
					$scope.getMapa(ambito);
				},
				function(response){	alert("Falló comunicación con server");	}
			);
	}

	$scope.getMapa = function(sc){
		if(sc.ot.idpoblado != ''){
			$.ajax({
				url: baseUrl+"/miscelanio/getMaps/"+sc.ot.idpoblado,
				success: function(data){
					$("#mapa").html(data);
				},
				error: function(){
					alert("error");
				}
			});
		}
	}
	$scope.toggleContent = function(tag, clase, section){
		if(section != undefined){
			if ($(tag).hasClass(clase)) { 
				$(section).addClass(clase);
			}else{
				$(section).addClass(clase);				
				$(tag).removeClass(clase);
			}
		}		
		$(tag).toggleClass(clase);
	}
}

// Listado de OTs
var listaOT = function($scope, $http, $timeout){
	$scope.linkLista = '';
	$scope.consulta = {};
	$scope.findOTsByBase = function(url){
		var mybase = $scope.consulta.base;
		$scope.linkLista = url+'/'+mybase;
		$http.post($scope.linkLista, {}).then(
				function(response) {
					$scope.ots = response.data;
				},
				function(response){}
			);
	}
}

// FUNCIONES PROPIAS DE AGREGAR UNA OT
var agregarOT = function($scope, $http, $timeout){
	$scope.ot = {};
	$scope.ot.tareas = [];
	$scope.ot.departamento = '';
	$scope.ot.municipio = '';
	$scope.ot.idpoblado = '';
	$scope.myItems;
	$scope.items = {};
	$scope.itemsEliminados = [];
	$scope.eqsubtotal=0;
	$scope.actsubtotal=0;
	$scope.persubtotal=0;
	$scope.reembs=[];
	$scope.viaticos = 0;
	////$scope.$parent.tinyMCE();

	$scope.getItemsBy = function(url){ $scope.$parent.getDataITems(url, $scope); }
	$scope.getData = function(url){ $scope.$parent.getData(url, $scope, false); }
	$scope.selectTarea = function(ot, indice){
		$timeout(function(){
			$scope.$parent.selectTarea(ot, $scope, indice);
			$scope.calcularSubtotales();
		});
	}
	$scope.addTarea = function(){$scope.$parent.addTarea($scope);}
	$scope.unset_item = function(lista, item){
		$scope.$parent.unset_item(lista, item);
		$scope.itemsEliminados.push(item);
		$scope.calcularSubtotales();
	}
	// procesos para items added a la OT
	//items planeación
	$scope.VwITems = function(tipo){
		if($scope.ot.tareas != undefined && $scope.ot.tareas.length > 0){ $scope.$parent.VwITems(tipo, $scope); } 
		else{ alert('No se han agregado tareas');}
	}
	$scope.addSelectedItems = function(){
		$scope.$parent.addSelectedItems($scope,$scope.tr); $scope.calcularSubtotales();
	}
	$scope.calcularSubtotales = function(){	
		$scope.$parent.calcularSubtotales($scope, $scope.tr); 
		$scope.$parent.calcularValorOT($scope);		
	}
	//viaticos
	$scope.setViaticos= function(tag, tr){ $scope.$parent.setViaticos(tag, tr, $scope); }
	$scope.calcularViaticos= function(tr){ $scope.$parent.calcularViaticos(tr, $scope); $scope.$parent.calcularValorOT($scope); }
	//reembolsables
	$scope.endReembolsables = function(tag, tr){ $scope.$parent.endReembolsables(tag, tr, $scope); $scope.$parent.calcularValorOT($scope); }
	$scope.addReemb = function(){ $scope.$parent.addReemb($scope); }
	//horas extra
	$scope.setHorasExtra = function(tag , tr){ $scope.$parent.setHorasExtra(tag , tr, $scope); }
	$scope.endHorasExtra = function(tag, tr){ $scope.$parent.endHorasExtra(tag, tr, $scope); $scope.$parent.calcularValorOT($scope); }
	//Utils
	$scope.obtenerMunicipios = function(depart,url){	$scope.$parent.obtenerMunicipios(depart,url,$scope);	}
	$scope.obtenerVeredas =function(municip,url){	$scope.$parent.obtenerVeredas(municip,url, $scope);	};
	$scope.getMapa = function(){$scope.$parent.getMapa($scope);}
	//===================================================================================================================
	$scope.guardarOT = function(url){
		//tinyMCE.triggerSave();
		$scope.calcularSubtotales();
		$scope.ot.justificacion = $('#justificacion').val();
		$scope.ot.actividad = $('#actividad').val();
		$scope.ot.idpoblado = $scope.poblado;
		console.log($scope.ot);
		$http.post(	  url, { ot: $scope.ot }   ).then(
			function(response) {
				if(response.data == 'Orden de trabajo guardada correctamente'){
					alert('Orden de trabajo guardada correctamente');
					$timeout(function(){
						$scope.$parent.cerrarWindow();
						$scope.$parent.refreshTabs();
					});
				}else{	alert('Algo ha salido mal!'); console.log(response.data)	}
			},
			function(response) {console.log(response.data)}
		);
	}
}
// FUNCIONES PROPIAS DE EDICION DE OT
var editarOT = function($scope, $http, $timeout) {
	$scope.ot = {};
	$scope.myItems;
	$scope.items = {};
	$scope.itemsEliminados = [];
	$scope.eqsubtotal=0;
	$scope.actsubtotal=0;
	$scope.persubtotal=0;
	$scope.reembs=[];
	$scope.viaticos = 0;

	$scope.recorrerTareas = function(){
		angular.forEach($scope.ot.tareas, function(val, key){
			$scope.$parent.calcularSubtotales($scope, val);
		});
	}
	
	$scope.getItemsBy = function(url){ $scope.$parent.getDataITems(url, $scope);}
	$scope.getData = function(url){ $scope.$parent.getData(url, $scope, true); }
	$scope.selectTarea = function(ot, indice){
		$timeout(function(){
			$scope.$parent.selectTarea(ot, $scope, indice);
			$scope.calcularSubtotales();
		});
	}
	$scope.addTarea = function(){$scope.$parent.addTarea($scope);}
	$scope.unset_item = function(lista, item){
		$scope.$parent.unset_item(lista, item);
		$scope.itemsEliminados.push(item);
		$scope.calcularSubtotales();
	}
	// procesos para items added a la OT
	//items planeación
	$scope.VwITems = function(tipo){ 
		if($scope.ot.tareas != undefined && $scope.ot.tareas.length > 0){ $scope.$parent.VwITems(tipo, $scope); } 
		else{ alert('No se han agregado tareas');}
	}
	$scope.addSelectedItems = function(){ $scope.$parent.addSelectedItems($scope,$scope.tr); $scope.calcularSubtotales(); }
	$scope.calcularSubtotales = function(){	$scope.$parent.calcularSubtotales($scope, $scope.tr); $scope.$parent.calcularValorOT($scope);}
	//viaticos
	$scope.setViaticos= function(tag, tr){ $scope.$parent.setViaticos(tag, tr, $scope); }
	$scope.calcularViaticos= function(tr){ $scope.$parent.calcularViaticos(tr, $scope); $scope.$parent.calcularValorOT($scope); }
	//reembolsables
	$scope.endReembolsables = function(tag, tr){ $scope.$parent.endReembolsables(tag, tr, $scope); $scope.$parent.calcularValorOT($scope); }
	$scope.addReemb = function(){ $scope.$parent.addReemb($scope); }
	//horas extra
	$scope.setHorasExtra = function(tag , tr){ $scope.$parent.setHorasExtra(tag , tr, $scope); }
	$scope.endHorasExtra = function(tag, tr){ $scope.$parent.endHorasExtra(tag, tr, $scope); $scope.$parent.calcularValorOT($scope); }
	//Utils
	$scope.obtenerMunicipios = function(depart,url){ $scope.$parent.obtenerMunicipios(depart,url,ambito); }
	$scope.obtenerVeredas =function(municip,url){ $scope.$parent.obtenerMunicipios(municip,url, $scope); }
	$scope.getMapa = function(){$scope.$parent.getMapa($scope);}
	$scope.guardarOT = function(url){
		//tinyMCE.triggerSave();
		$scope.calcularSubtotales();
		$scope.ot.justificacion = $('#justificacion').val();
		$scope.ot.actividad = $('#actividad').val();
		console.log($scope.ot);
		$http.post(	  url, { ot: $scope.ot }   ).then(
			function(response) {
				if(response.data == 'Orden de trabajo guardada correctamente'){
					alert('Orden de trabajo guardada correctamente');
					$timeout(function(){
						$scope.$parent.refreshTabs();
					});
				}else{	alert('Algo ha salido mal!'); console.log(response.data)	}
			},
			function(response) {console.log(response.data)}
		);
	}
}
