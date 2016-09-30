var calendar = function($scope, $http, $timeout) {
  var nomMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'junio', 'julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
  $scope.semanas = [];
  $scope.reportes = [];
  var fecha = new Date();
  $scope.year = fecha.getFullYear();
  $scope.mes = fecha.getMonth();
  $scope.month = nomMeses[$scope.mes];


  // reportes
  $scope.validarReportes = function(reportes, semanas){
    angular.forEach(semanas, function(valor, llave){
      angular.forEach(valor, function(v, k){
        if($scope.buscarReportes(v, reportes)){
          v.preview = '/reportes/vistaPrevia/'+v.idreporte;
          v.enlace = '/ot/foo';
          console.log(v);
        }
      });
    });
  }
  $scope.buscarReportes = function(fecha, reportes) {
    for (var i = 0; i < reportes.length; i++) {
      if (reportes[i].dia == fecha.dia && reportes[i].mes-1 == fecha.mes){
        fecha.idreporte = reportes[i].idreporte;
        fecha.OT_idOT = reportes[i].OT_idOT;
        fecha.clase = 'dia activo';
        fecha.clase2 = '';
        fecha.activo = reportes[i].valido;
        return true;
      }
    }
    return false;
  }

  $scope.getMyReportes = function(url){
    $http.post(url, {}).then(
      function(response) {
        $scope.reportes = response.data;
        $scope.validarReportes($scope.reportes, $scope.semanas);
        setTimeout(function () {
          $('#tarj-cont').parent('div').css({
            'height': $('#tarj2').height()+'px'
          })
        }, 200);
      },
      function(response) {
        console.log(response.data)
      }
    );
  }

  //Calendario
  $scope.getDays = function(year, month){
    var consecutivo = 0;
    for (var i = 0; i < 6 ; i++) {
      var semana = [];
      consecutivo = $scope.llenarSemana(year, month, semana, consecutivo);
      $scope.validarReportes($scope.reportes, $scope.semanas);
    }
  }

  $scope.llenarSemana = function(year, mes,semana, consecutivo) {
    if(consecutivo == 0){
      var y = 0;
      var f = new Date(year, mes, 1);
      while (y < f.getDay() ){
        semana.push({dia:'', clase:''});
        y++;
      }
    }
    do {
      consecutivo++;
      var myfec = new Date(year, mes, consecutivo);
      var myfec2 = new Date(year, mes, consecutivo+1);//comparador siguiente
      if (myfec.getMonth() == mes) {
        semana.push({dia:myfec.getDate(), mes:myfec.getMonth(), clase:'dia'});
      }
    } while (myfec.getDay() < 6 );
    $scope.semanas.push(semana);
    return consecutivo;
  }

  $scope.getDays($scope.year, $scope.mes);

  $scope.changeMonth = function(direction){
    $scope.semanas = [];
    if (direction == 'back') {
      if ($scope.mes == 0) {
        $scope.mes = 11;
        $scope.year = $scope.year-1;
      }else{
        $scope.mes = $scope.mes-1;
      }
      $scope.month = nomMeses[$scope.mes];
    }else if(direction == 'next') {
      if ($scope.mes == 11) {
        $scope.mes = 0;
        $scope.year = $scope.year+1;
      }else{
        $scope.mes = $scope.mes+1;
      }
      $scope.month = nomMeses[$scope.mes];
    }
    $scope.getDays($scope.year, $scope.mes);
  }

  $scope.changeYear = function(direction){
    $scope.semanas = [];
    if (direction == 'back') {
      $scope.year = $scope.year-1;
    }else if (direction == 'next') {
      $scope.year = $scope.year+1;
    }
    $scope.getDays($scope.year, $scope.mes);
  }
  //procesoas externos
  $scope.enlazarFecha = function(url, $e, dia, mes, year){
    console.log(url+'/'+year+'-'+mes+'-'+dia);
    $scope.$parent.getAjaxWindow(url+'/'+year+'-'+mes+'-'+dia, $e, null)
  }
  $scope.seleccionarFecha = function(fecha, mes, year, url, $e){
    angular.forEach($scope.semanas, function(valor, llave){
      angular.forEach(valor, function(val, keys){
        if(val.dia != fecha.dia){ val.clase2 = ''; }
      });
    });
    $scope.$parent.seleccionarFecha(fecha, mes, year, url, $e);
  }
}
