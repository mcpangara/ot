var OT = function($scope, $http, $timeout){

	$scope.getDataITems = function(url, ambito){
		$http.get(url).then(
			function(response) {
				ambito.bases = JSON.parse(response.data.bases);
				ambito.items = JSON.parse(response.data.items);
				$scope.tinyMCE();
			},
			function (response) {
				alert("Algo ha salido mal al cargar esta interfaz, cierra la vista e intenta de nuevo, si el problema persiste comunicate a el area TIC.");
			}
		);
	}

	$scope.getData = function(url, ambito){
		$http.post(url, {}).then(
				function(response){
					ambito.ot = response.data;
					$scope.tinyMCE();
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

	$scope.addTarea = function(ambito){
		ambito.ot.tareas.push(
			{
				nombre_tarea:'TAREA '+(ambito.ot.tareas.length+1),
				fecha_inicio:'',
				fecha_fin:'',
				json_indirectos:{},
				json_recursos:{},
				json_horas_extra:{},
				json_reembolsables:{},
				json_viaticos:{},
				actividades:[],
				personal:[],
				equipos:[],

			});
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
		console.log(ambito.myItems);
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

	$scope.addSelectedItems = function(ambito){
		var size = ambito.myItems.length;
		var i = 0;
		ambito.filtro = [];
		angular.forEach(ambito.myItems, function(v,k){
			i++;
			ambito.indexer++;
			if (v.add == true) {
				v.id = ambito.indexer;
				v.fecha_agregado = '';
				v.cantidad = 1;
				v.duracion = 1;
				if (v.tipo_item == 1){
					ambito.ot.items[0].actividades.push(v);
				}else if(v.tipo_item == 2) {
					ambito.ot.items[0].personal.push(v);
					//generar listado de items de personal para calc. gastos de viaje.
					ambito.ot.items[0].viaticos.json_viaticos = angular.copy(ambito.ot.items[0].personal);
					ambito.ot.items[0].horas_extra.json_horas_extra = angular.copy(ambito.ot.items[0].personal);
				}else if(v.tipo_item == 3){
					ambito.ot.items[0].equipos.push(v);
				}
			};
			if (i == size){
				ambito.myItems = null;
			}
		});
		ambito.calcularSubtotales(ambito);
		$("#ventana_add_items").addClass('nodisplay');
	}

	$scope.changeFilterSelect = function(fil){
		if(fil.add == undefined){
			fil.add = true;
		}else if (fil.add == true) {
			fil.add = undefined;
		};
	}

	$scope.calcularSubtotales = function(ambito){
		angular.forEach(ambito.ot.items, function(value, key){
			ambito.actsubtotal = ambito.recorrerSubtotales(value.actividades);
			ambito.persubtotal = ambito.recorrerSubtotales(value.personal);
			ambito.eqsubtotal = ambito.recorrerSubtotales(value.equipos);
			value.valor_recursos.equipos = ambito.eqsubtotal;
			value.valor_recursos.personal = ambito.persubtotal;
			value.valor_recursos.apu = ambito.actsubtotal;
			value.valor_recursos.total_recursos = ambito.actsubtotal+$scope.persubtotal+$scope.eqsubtotal;
		});
	}

	$scope.setTareaAdministracion = function(value, tr){
		tr.indirectos.administracion = value;
		return value;
	}
	$scope.setTareaImprevistos = function(value, tr){
		tr.indirectos.imprevistos = value;
		return value;
	}
	$scope.setTareaUtilidad = function(value, tr){
		tr.indirectos.utilidad = value;
		return value;
	}

	$scope.recorrerSubtotales = function(obj){
		var valor = 0;
		for (var i = 0; i < obj.length; i++) {
			valor += obj[i].tarifa * (obj[i].cantidad * obj[i].duracion);
		};
		return valor;
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
	$scope.obtenerMunicipios = function(depart,url){
		$scope.poblado = '';
		$http.post(url, {departamento: depart}).then(
				function(response){	$scope.munis= response.data;	},
				function(response){ alert("Falló comunicación con server");	}
			);
	}

	$scope.obtenerVeredas = function(municip,url){
		$http.post(url, {municipio: municip}).then(
				function(response){
					$scope.poblados= response.data;
					$scope.poblado = $scope.poblados[0].idpoblado;
					$scope.getMapa();
				},
				function(response){	alert("Falló comunicación con server");	}
			);
	}
}

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

var addOT = function($scope, $http, $timeout) {
	$scope.filtro = {};

	$scope.persubtotal = 0;
	$scope.actsubtotal = 0;
	$scope.eqsubtotal = 0;
	$scope.indexer = 0;

	$scope.reembolsables = 0;
	$scope.viaticos = 0;
	$scope.valor_horas_extra = 0;
	$scope.raciones = 0;
	$scope.reemb = [];

	$scope.ot = {
		nombre_ot: {
			data:'',label:'ORDEN DE TRABAJO:', type: 'text'
		},
		sap:{
			data:'',label:'No. SAP :'
		},
		zona: {
			data:'',label:'Zona:', type: 'text'
		},
		fecha_creacion:{
			data:'',label:'Fecha creacion:', type: 'date'
		},
		actividad:{
			data:'',label:'Actividad:', type: 'date'
		},
		justificacion:{
			data:'',label:'Justificacion:', type: 'date'
		},
		locacion:{
			data:'',label:'Locación', type: 'text'
		},
		abscisa:{
			data:'',label:'Abscisa', type: 'text'
		},
		municipio:{
			data:'',label:'Municipio', type: 'text'
		},
		vereda:{
			data:'',label:'Vereda', type: 'text'
		},
		especialidad:{
			data:'',label:'Especialidad', type: 'text'
		},
		tipo_ot:{
			data:'',label:'Tipo O.T.: ', type: 'text'
		},
		items:[
			{
				fecha_fin:{
					data:'',label:'Fecha fin:', type: 'date'
				},
				fecha_inicio:{
					data:'',label:'Fecha inicio:', type: 'date'
				},
				actividades: [],
				personal: [],
				equipos: [],
				valor_recursos:{
					equipos: 0,
					personal: 0,
					apu:0
				},
				indirectos: {
					administracion:0,
					imprevistos:0,
					utilidad:0
				},
				reembolsables:{
					json_reembolsables:{},
					valor_reembolsables: 0,
					administracion: 0
				},
				viaticos: {
					json_viaticos: {},
					valor_viaticos:0,
					administracion: 0
				},
				horas_extra:{
					json_horas_extra: {},
					valor_horas_extra: 0,
					raciones_cantidad:0,
					raciones_valor_und:0,
					administracion: 0
				},
				editable: true,
				cerrada: false
			}
		]
	};
	$scope.reembs = [];
	$scope.mapUrl = '';
	$scope.viaticos = 0;

	// ============================

	$scope.getDataForm = function(url){
		$scope.tinyMCE();
		$http.get(url).then(
			function(response) {
				$scope.bases = JSON.parse(response.data.bases);
				$scope.items = JSON.parse(response.data.items);
				//$('select#bases').val('168');
			},
			function (response) {
				alert("Algo ha salido mal");
			}
		);
	}

	$scope.datepicker_init =  function(){
		$( ".datepicker" ).datepicker({
			"dateFormat":'yy-mm-dd'
		});
	}
	$scope.tinyMCE = function(){
		tinymce.init({
  			selector: "textarea"
  		});
	}

	$scope.openSection = function (arg, e) {
		$(arg).toggleClass('nodisplay');

		$(e+" span").toggleClass('displayinline');
		$(e+" span").toggleClass('nodisplay');
	}


	//==============================================================================
	// Gestion de items de OT
	$scope.selectItemsType =  function(type){
		if(type == 1){
			$scope.myItems = angular.copy($scope.items['actividad']);
		}else if(type == 2){
			$scope.myItems = angular.copy($scope.items['personal']);
		}else if(type == 3){
			$scope.myItems = angular.copy($scope.items['equipo']);
		}
	}

	$scope.VwITems = function(tipo){
		$scope.selectItemsType(tipo);
		$("#ventana_add_items").removeClass('nodisplay');
	}

	$scope.setSelecteState = function(add){
		if(!add){
			add = true;
		}else{
			add = false;
		}
	}

	$scope.addSelectedItems = function(){
		var size = $scope.myItems.length;
		var i = 0;
		$scope.filtro = [];
		angular.forEach($scope.myItems, function(v,k){
			i++;
			$scope.indexer++;
			if (v.add == true) {
				v.id = $scope.indexer;
				v.fecha_agregado = '';
				v.cantidad = 1;
				v.duracion = 1;
				if (v.tipo_item == 1){
					$scope.ot.items[0].actividades.push(v);
				}else if(v.tipo_item == 2) {
					$scope.ot.items[0].personal.push(v);
					//generar listado de items de personal para calc. gastos de viaje.
					$scope.ot.items[0].viaticos.json_viaticos = angular.copy($scope.ot.items[0].personal);
					$scope.ot.items[0].horas_extra.json_horas_extra = angular.copy($scope.ot.items[0].personal);
				}else if(v.tipo_item == 3){
					$scope.ot.items[0].equipos.push(v);
				}
			};
			if (i == size){
				$scope.myItems = null;
			}
		});
		$scope.calcularSubtotales();
		$("#ventana_add_items").addClass('nodisplay');
	}

	$scope.changeFilterSelect = function(fil){
		if(fil.add == undefined){
			fil.add = true;
		}else if (fil.add == true) {
			fil.add = undefined;
		};
	}

	$scope.unSelectItem = function(it){
		if (it.tipo_item == 1) {
			$scope.ot.items[0].actividades.splice($scope.ot.items[0].actividades.indexOf(it),1);
		} else if(it.tipo_item == 2){
			$scope.ot.items[0].personal.splice($scope.ot.items[0].personal.indexOf(it),1);
			//generar listado de items de personal para calc. gastos de viaje.
			$scope.ot.items[0].viaticos.json_viaticos = angular.copy($scope.ot.items[0].personal);
			$scope.ot.items[0].horas_extra.json_horas_extra = angular.copy($scope.ot.items[0].personal);
		}else if(it.tipo_item == 3){
			$scope.ot.items[0].equipos.splice($scope.ot.items[0].equipos.indexOf(it),1);
		};
		$scope.calcularSubtotales();
	}

	$scope.showSection = function(id, clss){
		$("."+clss).addClass('nodisplay');
		$("#"+id).removeClass('nodisplay');
	}

	$scope.calcularSubtotales = function(){
		angular.forEach($scope.ot.items, function(value, key){
			$scope.actsubtotal = $scope.recorrerSubtotales(value.actividades);
			$scope.persubtotal = $scope.recorrerSubtotales(value.personal);
			$scope.eqsubtotal = $scope.recorrerSubtotales(value.equipos);
			value.valor_recursos.equipos = $scope.eqsubtotal;
			value.valor_recursos.personal = $scope.persubtotal;
			value.valor_recursos.apu = $scope.actsubtotal;
			value.valor_recursos.total_recursos = $scope.actsubtotal+$scope.persubtotal+$scope.eqsubtotal;
		});
	}

	$scope.setTareaAdministracion = function(value, tr){
		tr.indirectos.administracion = value;
		return value;
	}
	$scope.setTareaImprevistos = function(value, tr){
		tr.indirectos.imprevistos = value;
		return value;
	}
	$scope.setTareaUtilidad = function(value, tr){
		tr.indirectos.utilidad = value;
		return value;
	}

	$scope.recorrerSubtotales = function(obj){
		var valor = 0;
		for (var i = 0; i < obj.length; i++) {
			valor += obj[i].tarifa * (obj[i].cantidad * obj[i].duracion);
		};
		return valor;
	}

	//--------------------------------------------------------------------------------------
	// Municipios y locaciones
	$scope.obtenerMunicipios = function(depart,url){
		$scope.poblado = '';
		$http.post(url, {departamento: depart})
			.then(
				function(response){
					$scope.munis= response.data;
					//$scope.munic = $scope.munis[0].municipio;
					// $("#depart")
					// $("#munic")
				}
				,
				function(response){
					alert("Falló comunicación con server");
				}
			);
	}

	$scope.obtenerVeredas = function(municip,url){
		$http.post(url, {municipio: municip})
			.then(
				function(response){
					$scope.poblados= response.data;
					$scope.poblado = $scope.poblados[0].idpoblado;
					//$("#poblado")
					$scope.getMapa();
				}
				,
				function(response){
					alert("Falló comunicación con server");
				}
			);
	}

	$scope.getMapa = function(){
		if($scope.poblado != ''){
			$.ajax({
				url: baseUrl+"/miscelanio/getMaps/"+$scope.poblado,
				success: function(data){
					$("#mapa").html(data);
				},
				error: function(){
					alert("error");
				}
			});
		}
	}

	//====================================================================================
	// Viaticos
	$scope.setViaticos = function(tag, tr){
		$(tag).removeClass("nodisplay");
		$scope.itemsViaticos = tr.viaticos.json_viaticos;
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

	$scope.calcularViaticos =  function(tr){
		$scope.viaticos = 0;
		angular.forEach($scope.itemsViaticos, function(v,k){
			if (v.destino == '' ||  v.destino == undefined || v.destino == null || v.destino == 'undefined'){}
			else {
				$scope.viaticos += (v.alojamiento + v.transporte + v.alimentacion + v.miscelanios) * (v.cantidad_gv * v.duracion_gv);
				//console.log($scope.viaticos + " - "+ v.destino);
			}
		});
		if ($scope.itemsViaticos == undefined || $scope.itemsViaticos.length == 0) {
			$scope.viaticos = 0;
		}
		tr.viaticos.valor_viaticos = $scope.viaticos;
		tr.viaticos.administracion = ( tr.viaticos.valor_viaticos* ( 4.58 /100) );
		$("#addViaticosOT").addClass('nodisplay');
	}

	//===================================================================================================================
	// Reembolsables
	$scope.setReembolsables = function(tag, tr){
		$(tag).toggleClass('nodisplay');
	}
	$scope.calcularReembolsables = function(tr){
		angular.forEach($scope.reembs, function(v, k){
			//console.log(v.cantidad * v.valor_und);
			$scope.reembolsables +=  (v.cantidad * v.valor_und);
			tr.reembolsables.valor_reembolsables = $scope.reembolsables;
			tr.reembolsables.administracion = $scope.reembolsables * 0.01;
		});
	}
	$scope.endReembolsables = function(tag, tr){
		$(tag).toggleClass('nodisplay');
		$scope.calcularReembolsables(tr);
		tr.reembolsables.json_reembolsables = $scope.reembs;
	}
	$scope.addReemb = function(){
		$scope.reembs.push(
			{
				descripcion:$scope.reemb.descripcion,
				unidad: $scope.reemb.unidad,
				cantidad: $scope.reemb.cantidad,
				valor_und: $scope.reemb.valor_und
			}
		);
		$scope.reemb.descripcion='';
		$scope.reemb.unidad ='';
		$scope.reemb.cantidad = 0;
		$scope.reemb.valor_und = 0;
	}
	//===================================================================================================================
	// horas extra
	$scope.setHorasExtra = function(tag , tr){
		//console.log(tr.horas_extra);
		$scope.horas_extra = tr.horas_extra.json_horas_extra;
		$(tag).toggleClass('nodisplay');
	}
	$scope.calcularTotalItem = function(item) {
		item.total = (item.total_hed);
		item.total += (item.total_hen);
		item.total += (item.total_hefd);
		item.total += (item.total_hefn);
		item.total += (item.total_hfr);
		item.total = (item.total * 1.6196) * item.cantidad_he;
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
	$scope.calcularHorasExtra = function(tr){
		$scope.valor_horas_extra = 0;
		angular.forEach($scope.horas_extra, function(v,k){
			$scope.valor_horas_extra += v.total;
			tr.horas_extra.valor_horas_extra = $scope.valor_horas_extra;
		});
	}

	$scope.endHorasExtra = function(tag, tr){
		$scope.calcularHorasExtra(tr);
		$(tag).toggleClass('nodisplay');
	}
	//===================================================================================================================
	$scope.guardarOT = function(url){
		tinyMCE.triggerSave();
		$scope.ot.justificacion.data = $('#justificacion').val();
		$scope.ot.actividad.data = $('#actividad').val();
		$scope.ot.idpoblado = $scope.poblado;
		console.log($scope.ot);
		$http.post(
			url,
			{
				ot: $scope.ot
			}
		).then(
			function(response) {
				if(response.data == 'Orden de trabajo guardada correctamente'){
					alert('Orden de trabajo guardada correctamente');
					$timeout(function(){
						$scope.$parent.cerrarWindow();
						$scope.$parent.refreshTabs();
					});
				}else{
					alert('Algo ha salido mal!');
				}
				//console.log(response.data);
			},
			function(response) {
				console.log(response.data)
			}
		);
	}
	$scope.validateFields = function(){
	}
}

// FUNCIONES PROPIAS DE EDICION DE OT
var editarOT = function($scope, $htttp, $timeout) {
	$scope.ot = {};
	$scope.myItems;
	$scope.items = {};
	$scope.itemsEliminados = [];

	$scope.getItemsBy = function(url){
		$scope.$parent.getDataITems(url, $scope);
	}
	$scope.getData = function(url){ 
		$scope.$parent.getData(url, $scope);
	}
	$scope.selectTarea = function(ot, indice){
		$timeout(function(){
			$scope.$parent.selectTarea(ot, $scope, indice);
		});
	}
	$scope.addTarea = function(){$scope.$parent.addTarea($scope);}
	$scope.unset_item = function(lista, item){
		$scope.$parent.unset_item(lista, item);
		$scope.itemsEliminados.push(item);
	}
	// procesos para items added a la OT
	$scope.selectItemsType =  function(type){ $scope.$parent.selectItemsType($scope); }
	$scope.VwITems = function(tipo){ $scope.$parent.VwITems($scope);}
	$scope.addSelectedItems = function(){ $scope.addSelectedItems($scope);	}
	$scope.calcularSubtotales = function(){	$scope.calcularSubtotales($scope);	}
	//
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
