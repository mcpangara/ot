var reportes = function($scope, $http, $timeout) {
  $scope.CalendarLink = '';
  $scope.slide  = function(tag){
    $(tag).toggleClass('slide');
    $(tag).removeClass('unslide');
  }
  $scope.unslide = function(tag){
    $(tag).toggleClass('slide');
    $(tag).addClass('unslide');
  }
  $scope.verCalendario = function(url, tag){
    console.log(url+" - "+tag);
    $timeout(function(){
      $scope.CalendarLink = url;
      $scope.slide(tag);
    });
  }
  $scope.ocultarCalendario = function(tag){
    $timeout(function(){
      $scope.unslide(tag);
      $scope.CalendarLink = '';
    });
  }
}

//------------------------------------------------------------------------------
// controlador de agregar reporte

var addReporte =  function($scope, $http, $timeout) {
  $scope.personalReporte = [];
  $scope.persOT = [];
  $scope.eqs =[];
  $scope.actOT =[];
  $scope.equipoReporte =[];
  $scope.actividadesReporte = [];
  $tiempoPersona = {};

  $scope.myTinyMCE = function(){
		tinymce.init({
  			selector: "textarea"
  		});
	}
  $scope.myTinyMCE();

  // ==== procesos de personal en los reportes ====
  $scope.setPersonalOT = function(tag){
    $(tag).toggleClass('nodisplay');
  }

  $scope.getPersonaOT = function(ruta){
    $http.post(  ruta,  {}
    ).then(
      function(response){ $scope.persOT = response.data; },
      function(response){}
    );
  }

  $scope.endPersonalOT = function(tag, rdp=null){
    $scope.addPersonalToReporte($scope.persOT);
    $scope.setPersonalOT(tag);
  }

  $scope.addPersonalToReporte = function(list) {
    angular.forEach(list, function(val, key){
      if(val.add && !$scope.existeListaReporte($scope.personalReporte, val.identificacion)){
        $scope.personalReporte.push(
          {
            idrecurso_ot: val.idrecurso_ot,
            identificacion: val.identificacion,
            nombre_completo: val.nombre_completo,
            facturable: true,
            nombre_ot: val.nombre_ot,
            itemf_codigo: val.itemf_codigo,
            descripcion: val.descripcion,
            hora_inicio: 7,
            hora_fin: 18,
            hr_almuerzo: true,
            ordinario: 1,
            horas_hed: 0,
            horas_hen: 0,
            horas_rn: 0,
            clase: ''
          }
        );
      }
    })
  }

  $scope.delPersonaReporte = function(elem) {
    $scope.personalReporte.splice($scope.personalReporte.indexOf(elem),1);
  }
  $scope.cambiarTiempo = function(per, inicio, fin){
    var index = $scope.personalReporte.indexOf(per);
    var persona = $scope.personalReporte[index];
    persona.hora_inicio = inicio;
    persona.hora_fin = fin;
  }
  $scope.calcularHoras = function(pr){
    pr.tiempo_dia = 0;
    pr.horas_rn = 0;
    pr.horas_hed = 0;
    pr.horas_hen = 0;
    pr.duracion = pr.hora_fin - pr.hora_inicio;
    pr.noche = 0;
    if (pr.hora_inicio < 6) {
      pr.tiempo_dia = 6 - pr.hora_inicio;
      pr.horas_rn = 6 - pr.hora_inicio;
    }
    if (pr.hora_fin > 22) {
      pr.noche = pr.hora_fin - 22;
    }
    var dia = pr.duracion - pr.tiempo_dia - pr.noche;
    var hed = dia - (8 - pr.tiempo_dia);
    pr.tiempo_dia = pr.tiempo_dia + ( pr.duracion - hed );
    pr.horas_hed = hed;
    if (pr.horas_hed > 0 && dia >= 8) {
      pr.horas_hen = pr.noche;
    }else if (dia < 8) {
      pr.horas_rn = pr.noche;
    }
  }
  // ==== Procesos de equipos en los reportes ====
  $scope.setEquipoOT = function(tag){
    $(tag).toggleClass('nodisplay');
  }

  $scope.getEquipoOT = function(ruta){
    $http.post( ruta, {}
    ).then(
      function(response){ $scope.equOT = response.data; },
      function(response){}
    );
  }

  $scope.endEquipoOT = function(tag, rdp=null){
    $scope.addEquipoToReporte($scope.equOT);
    $scope.setEquipoOT(tag);
  }

  $scope.addEquipoToReporte = function(list) {
    angular.forEach(list, function(val, key){
      console.log(val);
      if(val.add && !$scope.existeListaReporte($scope.equipoReporte, val.serial, 'serial')){
        $scope.equipoReporte.push(
          {
            idrecurso_ot: val.idrecurso_ot,
            serial: val.serial,
            descripcion: val.descripcion,
            codigo_siesa: val.codigo_siesa,
            item: val.item,
            itemf_codigo: val.itemf_codigo,
            itemf_iditemf: val.itemf_iditemf,
            itemc_item: val.itemc_item,
            item_descripcion: val.item_descripcion,
            unidad: 'día',
            cantidad: 1,
            horo_inicio: '00:00',
            horo_fin:'24:00',
            nombre_operador: 'TERMOTECNICA COINDUSTRIAL S.A.S.',
            tipo_equipo: ( val.itemf_codigo.substr(0,2)=='32'?'O':'B'),
            placa: val.referencia,
            horas_oper: 0,
            horas_disp: 8,
            varado: false
          }
        );
      }
    })
  }
  $scope.delEquipoReporte = function(elem) {
    $scope.equipoReporte.splice($scope.equipoReporte.indexOf(elem),1);
  }

  // ====================== Actividades =============================
  $scope.setActividadOT = function(tag) {
    $(tag).toggleClass('nodisplay');
  }

  $scope.getActividadesOT = function(ruta) {
    $http.post(ruta, {}).then(
      function(response){$scope.actOT = response.data; console.log($scope.actOT);},
      function(response){}
    );
  }

  $scope.addActividadToReporte = function(list) {
    angular.forEach(list, function(val, key){
      if(val.add && !$scope.existeListaReporte($scope.actividadesReporte, val.iditemf, 'iditemf')){
        console.log(val);
        $scope.actividadesReporte.push(
          {
            iditemf:val.iditemf,
    				itemc_iditemc:val.itemc_iditemc,
    				itemc_item:val.itemc_item,
    				codigo:val.codigoS,
    				descripcion:val.descripcion,
    				nombre_ot:val.nombre_ot,
    				nombre_tarea:val.nombre_ot,
    				unidad:val.unidad,
    				planeado:val.planeado,
            cantidad_dia: 0
          }
        );
      }
    })
  }

  $scope.endActividadOT = function(tag){
    $scope.addActividadToReporte($scope.actOT);
    $scope.setEquipoOT(tag);
  }

  $scope.delActividadReporte = function(elem){
    $scope.actividadesReporte.splice($scope.actividadesReporte.indexOf(elem),1);
  }
  // ==== Procesos genericos ====
  $scope.existeListaReporte = function(listado, comparador, propiedad = 'identificacion') {
    for (var i = 0; i < listado.length; i++) {
      if (listado[i][propiedad] == comparador) {return true;}
    }
    return false;
  }

  $scope.changeFilterSelect = function(fil){
		if(fil.add == undefined){
			fil.add = true;
		}else if (fil.add == true) {
			fil.add = undefined;
		};
	}
  $scope.changeFilterSelect2 = function(fil,propiedad){
		if(fil[propiedad] == undefined){
			fil[propiedad] = true;
		}else if (fil[propiedad] == true) {
			fil[propiedad] = undefined;
		};
	}

  $scope.sliderRango = function(tag, pr) {
    $(tag).ionRangeSlider({
      type: "double",
      min: 0,
      max: 24,
      from: 6,
      to: 18,
      hide_min_max: true,
      hide_from_to: false,
      grid: false,
      pr:pr,
      onStart: function(data){
        $scope.cambiarTiempo(pr, data.from, data.to);
      },
      onChange: function(data) {
        $scope.cambiarTiempo(pr, data.from, data.to);
        $scope.$apply();
      }
    });
  }
  $scope.verificadorNumericoFilter = function(filtro, propiedad,inferior, superior = undefined){
    if(filtro[propiedad] < inferior){ filtro[propiedad] = undefined; }
    if(filtro[propiedad] < inferior){ filtro[propiedad] = undefined; }
    if(filtro[propiedad] == ''){ filtro[propiedad] = undefined; }
  }
  $scope.cambiarValorObjeto = function(obj, prop, value){
    if (obj[prop] == value) { obj[prop] = ''; }else{ obj[prop] = value; }
  }
  $scope.FunSelectionAll = function(listObj, prop){
    angular.forEach(listObj, function(val, key){
      val[prop] = val[prop]==undefined?true:undefined;
    });
  }
}
