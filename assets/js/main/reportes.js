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

  $scope.changeFilterSelect = function(fil,propiedad){
    console.log(propiedad);
		if(fil[propiedad] == undefined){
			fil[propiedad] = true;
		}else if (fil[propiedad] == true) {
			fil[propiedad] = undefined;
		};
	}

  // Relacionar un equipo a una OT
  $scope.relacionarEquipoAOt = function(it, url,ambito){
      if(it.item == undefined || it.item == ''){
        alert('Escoje el item a facturar para continuar con: '+it.codigo_siesa);
      }else{
        $http.post(
          url,
          {
            equipo_idequipo: it.idequipo,
            OT_idOT: ambito.rd.info.idOT,
            centro_costo: ambito.rd.info.ccosto,
            nombre_ot: ambito.rd.info.nombre_ot,
            fecha_registro: ambito.rd.info.fecha_reporte,
            itemf_iditemf: it.item,
            codigo_siesa: it.codigo_siesa,
            unidad_negocio: it.desc_un
          }
        ).then(
          function(response){
            ambito.equiposOT = response.data;
            console.log(ambito.equiposOT);
          },
          function(response){
            alert(response.data)
          }
        );
    }
  }

  $scope.selectionAll = function(listObj, prop){
    angular.forEach(listObj, function(val, key){
      val[prop] = val[prop]==undefined?true:undefined;
    });
  }

  $scope.mensaje = function(text){alert(text);}
}

var listOTReportes = function($scope, $http, $timeout){
  $scope.ot = {};
  $scope.rd = {};
  $scope.consulta = {};
  $scope.myOts = [];
  $scope.listaReportes = [];

  $scope.initBase = function(url ,base){
    $scope.consulta.base = base;
    $scope.getOTs(url);
  }

  $scope.setDefaultFilter = function(){
    $scope.consulta.ot = '';
    $scope.myOts = [];
  }

  $scope.getOTs= function(url){
    console.log(url+"/"+$scope.consulta.base);
    $http.post(url+"/"+$scope.consulta.base, {})
    .then(
      function(response){
        $scope.myOts = response.data;
        if(response.data.length == 0 || response.data[0] == undefined){alert('No hay OT activas para esta base')}
        else{$scope.consulta.ot  = response.data[0].idOT;}
      },
      function(){}
    );
  }

  $scope.getReportesView = function(site_url){
    $scope.ocultarCalendario('');
    angular.forEach($scope.myOts, function(val, key){
        if(val.idOT == $scope.consulta.ot){
          var fecha = new Date();
          $scope.rd.fecha = fecha;
          $scope.rd.fecha_selected = fecha.getFullYear()+"-"+(fecha.getMonth()+1)+"-"+fecha.getDate();
          $scope.ot = val;
          $scope.verCalendario(site_url+'/reporte/calendar'+"/"+$scope.consulta.ot);
          $scope.ot.selected = true;
          $http.post(
              site_url+'/reporte/getReportesByOT',
              {
                idOT: val.idOT
              }
            ).then(
              function(response) {
                $scope.listaReportes = undefined;
                $scope.listaReportes = response.data;
                console.log(response.data)
              },
              function(response) {
              }
            );
        }
    });
  }
  //Calendario
  $scope.verCalendario = function(url){
    $timeout(function(){ $scope.calendarLink = url; });
  }
  $scope.ocultarCalendario = function(){
    $timeout(function(){ $scope.calendarLink = ''; });
  }

  $scope.seleccionarFecha = function(fecha, mes, year, url, $e){
    if( url != undefined ){
      var d = new Date(year, mes, fecha.dia);
      $scope.rd.fecha = d;
      $scope.rd.fecha_label = fecha.dia+'/'+mes+'/'+year
      $scope.rd.fecha_selected = year+'-'+mes+'-'+fecha.dia;
      fecha.clase2 = 'selected';
      $scope.enlazarClick(url, $e);
    }
  }

  $scope.enlazarClick = function(url, $e){
    $e.preventDefault();
    var link = url+'/'+$scope.consulta.ot+'/'+$scope.rd.fecha_selected;
    $scope.$parent.getAjaxWindow(link, $e, null)
  }
}

//=============================================================================
// controlador de agregar reporte
var addReporte = function($scope, $http, $timeout) {
  // estructuras JSON y array
  $scope.rd = {
    info:{
    },
    recursos:{
      personal:[],
      equipos:[],
      actividades:[]
    }
  }
  $scope.personalOT = [];
  $scope.equiposOT = [];
  $scope.actividadesOT = [];

  //Busque de equipos no relacionados
  $scope.consultaEquiposOT = {};
  $scope.resultEquiposBusqueda = [];

  $scope.buscarEquiposBy = function(link){
    console.log(link)
    $http.post(link, {
      codigo_siesa: $scope.consultaEquiposOT.codigo_siesa,
      referencia: $scope.consultaEquiposOT.referencia,
      descripcion: $scope.consultaEquiposOT.descripcion,
      un: $scope.consultaEquiposOT.un
    }).then(
      function(response){
        console.log(response.data)
        $scope.resultEquiposBusqueda = response.data;
      },
      function(response){
        alert('Falló la consulta');
      }
    );
  }

  // Utilidades
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
  $scope.showContent = function(tag, section){
    $(section).hide();
    $(tag).show();
  }
  //------------------------------------------------------------------
  // Recursos
  //------------------------------------------------------------------
  // Datos para agregar al reporte
  // Obtener datos para formularios
  $scope.getRecursosByOT = function(url){
    $http.post(url, {})
      .then(
        function(response){
          $scope.personalOT = response.data.personal;
          $scope.equiposOT = response.data.equipo;
          $scope.actividadesOT = response.data.actividad;
          console.log(response.data);
        },
        function(response){
          alert("Problemas a la cargar los datos de los formularios, por favor cierra la ventana y vuelve a ingresar.")
        }
      )
  }
  // mostrar una sección para agregar elementos al reporte
  $scope.showRecursosReporte = function(section, tag){
    $(section).hide(section);
    $(tag).show();
  }
  // seleccionar todo un listado
  $scope.seleccionarTodosLista = function(lista){
    angular.forEach(lista, function(val, key){
      val.add = true;
    });
  }
  // Ocultar una seccion de agregar recursos y ejecutar una funcion de inicio
  $scope.closeRecursoReporte = function(section, method){
    if(method == 1 ){
      $scope.agregarPersonal();
    }else if(method == 2){
      $scope.agregarEquipos();
    }else if(method == 3){
      $scope.agregarActividades();
    }
    $timeout(function(){
      $(section).hide(100);
    });
  }
  // Agregar el personal seleccionado al reporte
  $scope.agregarPersonal = function(){
    angular.forEach($scope.personalOT, function(val, key){
      if(!$scope.existeRegistro($scope.rd.recursos.personal, 'identificacion', val.identificacion) && val.add){
        val.hora_inicio = 6;
        val.hora_fin = 17;
        val.cantidad = 1;
        val.horas_rn = 0;
        val.horas_hed = 0;
        val.horas_hen = 0;
        $scope.rd.recursos.personal.push(val);
      }
    });
  }
  // Agregar equipos seleccionados al reporte
  $scope.agregarEquipos = function(){
    angular.forEach($scope.equiposOT, function(val, key){
      if(!$scope.existeRegistro($scope.rd.recursos.equipos, 'codigo_siesa', val.codigo_siesa) && val.add ){
        val.horas_oper = 0;
        val.horas_disp = 0;
        $scope.rd.recursos.equipos.push(val);
      }
    });
  }
  // Agregar actividades seleccionadas al reporte
  $scope.agregarActividades = function(){
    angular.forEach($scope.actividadesOT, function(val, key){
      if(val.add && !$scope.existeRegistro($scope.rd.recursos.actividades, 'itemc_iditemc', val.itemc_iditemc)){
        $scope.rd.recursos.actividades.push(val);
      }
    });
  }

  // Relacionar equipos desde esta vista
  $scope.relacionarEquipoAOt = function(it, url){
    console.log($scope.rd.info)
    $scope.$parent.relacionarEquipoAOt(it, url, $scope);
  }

  $scope.existeRegistro = function(list, prop, valor) {
    var bandera = false;
    angular.forEach(list, function(val, key){
      if(val[prop] == valor){
        bandera = true;
      }
    });
    return bandera;
  }

  $scope.quitarRegistroLista = function( lista, item, url, prop){
    if(url!='' && prop!=''){
      $http.post(url, { prop: item[prop], }
      ).then(
        function(response){
          console.log(response.data)
          lista.splice(lista.indexOf(item),1);
        },
        function(response) {
          alert('Algo ha salido mal');
        }
      );
    }else{
      lista.splice(lista.indexOf(item),1);
    }
  }

  $scope.validarRecursos = function(url){
    if($scope.rd.recursos.personal.length == 0 && $scope.rd.recursos.equipos.length == 0 && $scope.rd.recursos.actividades.length == 0){
      alert('No hay recurso agregados');
    }else{
        $http.post(
          url,
          {
            idOT: $scope.rd.info.idOT,
            fecha: $scope.rd.info.fecha_reporte,
            recursos: $scope.rd.recursos,
            info: $scope.rd.info
          }
        ).then(
          function(response){
            console.log(response.data);
            $scope.rd.recursos = response.data.recursos;
          },
          function(response) {
            console.log(response.data);
          }
        );
    }
  }

  // Guardar reporte
  $scope.guardarRD = function(url){
    if($scope.rd.recursos.personal.length == 0 && $scope.rd.recursos.equipos.length == 0 && $scope.rd.recursos.actividades.length == 0){
      alert('No hay recurso agregados');
    }else{
        $http.post(
          url,
          {
            fecha: $scope.rd.info.fecha_reporte,
            recursos: $scope.rd.recursos,
            info: $scope.rd.info
          }
        ).then(
          function(response){
            console.log(response.data);
            if(response.data.success == 'success'){
              alert("reporte guardado correctamente");
              timeout(function(){
                //$scope.$parent.cerrarWindow();
                $scope.$parent.refreshTabs();
              });
            }
          },
          function(response) {
            console.log(response.data);
          }
        );
    }
  }
}

//=============================================================================

var addReporteAnt =  function($scope, $http, $timeout) {
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
