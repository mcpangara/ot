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

  $scope.parseNumb = function(i){
    return parseFloat(i);
  }

  $scope.parseBool = function(i){
    return (i==1)? true: false;
  }
}

// ============================================================================================
// Reportes
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
    $http.post(url+"/"+$scope.consulta.base, {indicio_nombre_ot: $scope.consulta.indicio_nombre_ot})
    .then(
      function(response){
        $scope.myOts = response.data;
        console.log(response.data);
        if(response.data.length == 0 || response.data[0] == undefined){alert('No hay OT activas para esta base')}
        else{
          $scope.consulta.ot = response.data[0];
          $scope.consulta.idOT  = response.data[0].idOT;
          $scope.consulta.nombre_ot = response.data.nombre_ot;
          $scope.myOts = response.data;
          $("#seleccionar-ot").toggleClass('nodisplay');
        }
      },
      function(){}
    );
  }
  $scope.seleccionarOT = function(ot){
    $scope.consulta.ot = ot;
    $scope.consulta.idOT = ot.idOT;
    $scope.consulta.nombre_ot = ot.nombre_ot;
    $("#seleccionar-ot").toggleClass('nodisplay');
  }

  $scope.getReportesView = function(site_url){
    $scope.ocultarCalendario('');
    var fecha = new Date();
    $scope.rd.fecha = fecha;
    $scope.rd.fecha_selected = fecha.getFullYear()+"-"+(fecha.getMonth()+1)+"-"+fecha.getDate();
    $scope.verCalendario(site_url+'/reporte/calendar'+"/"+$scope.consulta.idOT);
    $scope.ot.selected = true;
    $http.post(
        site_url+'/reporte/getReportesByOT',
        {
          idOT: $scope.consulta.idOT
        }
      ).then(
        function(response) {
          $scope.listaReportes = undefined;
          $scope.listaReportes = response.data;
          console.log(response.data)
        },
        function(response) {
          alert(response.data)
        }
      );
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
    $http.get(url+'valid/'+$scope.consulta.idOT+'/'+$scope.rd.fecha_selected)
    .then(
      function(response) {
        if (response.data == "invalid") {
          alert('El reporte de esta fecha para esta OT ya existe');
        }else if(response.data == "valid") {
          var link = url+'/'+$scope.consulta.idOT+'/'+$scope.rd.fecha_selected;
          $scope.$parent.getAjaxWindow(link, $e, null);
        }
      },
      function(response) {
      }
    );
  }

  $scope.getReporte = function(link, id, $e){
    $scope.$parent.getAjaxWindow(link+'/'+id, $e, null);
  }
}
//==================================================================================================================================
//==================================================================================================================================
// controlador de agregar reporte
//==================================================================================================================================
var addReporte = function($scope, $http, $timeout) {
  // estructuras JSON y array
  $scope.rd = {
    info:{
      observaciones:[]
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
  $scope.addObervacion = function(){$scope.rd.info.observaciones.push({msj:''})}

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
//==================================================================================================================================
//==================================================================================================================================
// Edit
//==================================================================================================================================
var editReporte = function($scope, $http, $timeout){
  // estructuras JSON y array
  $scope.rd = {
    info:{
      observaciones:[]
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
  $scope.fecha_duplicar = '';
  $scope.tipoGuardado = 0;

  $scope.getDataInfo = function(link){
    $http.post(link, {})
      .then(
        function(response){
          console.log(response.data);
          $scope.rd.idreporte_diario = response.data.idreporte_diario;
          $scope.rd.info = response.data.info;
          $scope.rd.recursos.personal = response.data.personal;
          $scope.rd.recursos.equipos = response.data.equipos;
          $scope.rd.recursos.actividades = response.data.actividades;
        },
        function(response){
        }
      )
  }

  $scope.formDuplicar = function(){
    $('#duplicar').toggleClass('nodisplay');
  }
  // Realiza la actividad de duplicar reporte
  $scope.duplicar = function(url, $e){
      if ($scope.fecha_duplicar == undefined ||  $scope.fecha_duplicar == '') {
        alert('No hay fecha selecionada');
      }else{
        $http.get(url+'/'+$scope.rd.info.idOT+'/'+$scope.fecha_duplicar).then(
          function (response) {
            console.log(response.data+" "+$scope.rd.info.idOT);
            if(response.data == 'invalid'){
              alert('Ya hay un reporte para esa fecha');
            }else if(response.data == 'valid'){
              $scope.tipoGuardado = 1;
              $scope.rd.info.fecha_reporte = $scope.fecha_duplicar;
              alert('Reporte duplicado listo para guardar en fecha '+$scope.fecha_duplicar);
              $('#duplicar').toggleClass('nodisplay');
            }else{
              alert('Proceso en revisión, intenta más tarde'+response.data)
            }
          },
          function (response) {
            alert('Falla: '+response.data)
          }
        );
      }
  }

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
        val.horas_recargo = 0;
        val.horas_extra_dia = 0;
        val.horas_extra_noc = 0;
        $scope.rd.recursos.personal.push(val);
      }
    });
  }
  // Agregar equipos seleccionados al reporte
  $scope.agregarEquipos = function(){
    angular.forEach($scope.equiposOT, function(val, key){
      if(!$scope.existeRegistro($scope.rd.recursos.equipos, 'codigo_siesa', val.codigo_siesa) && val.add ){
        val.horas_operacion = 0;
        val.horas_disponible = 0;
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
    if(url!='' && prop!='' && ( items.idrecurso_reporte_diario != undefined || items.idrecurso_reporte_diario != '' ) ){
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
  $scope.addObervacion = function(){$scope.rd.info.observaciones.push({msj:''})}

  // Guardar reporte
  $scope.guardarRD = function(link, link2) {
    var data = {
      fecha: $scope.rd.info.fecha_reporte,
      recursos: $scope.rd.recursos,
      info: $scope.rd.info
    };

    if ($scope.tipoGuardado == 1) {
      $scope.guardarReporte(link, data);
    }else{
      data.idreporte_diario = $scope.rd.idreporte_diario;
      console.log(data);
      $scope.guardarReporte(link2, data);
    }
  }

  $scope.guardarReporte = function(url, data){
    if($scope.rd.recursos.personal.length == 0 && $scope.rd.recursos.equipos.length == 0 && $scope.rd.recursos.actividades.length == 0){
      alert('No hay recurso agregados');
    }else{
        $http.post(
          url,
          data
        ).then(
          function(response){
            console.log(response.data);
            if(response.data.success == 'success'){
              alert("reporte guardado correctamente");
            }
          },
          function(response) {
            console.log(response.data);
          }
        );
    }
  }
}
