var lista_equipos = function($scope, $http, $timeout)
{
  $scope.equs = [];
  $scope.cargandoConsulta = false;
  $scope.filtro_lp = [];
  $scope.cargaListaEquipos = function(ruta, key=null){
    console.log(ruta)
    $scope.cargandoConsulta = true;
    $http.post(
      ruta,
      {
        llave : key
      }
    ).then(
      function(response) {
        $scope.equs=response.data;
        $scope.cargandoConsulta = false;
      },
      function(response) {
        alert('Algo ha salido mal, verifica tu conexion a intenet y ponte en contacto con tu departamento TIC. '+response.data);
        console.log(response);
        $scope.cargandoConsulta = false;
      }
    );
  }
}

var equipoUP = function($scope, $http, $timeout) {
  	// upload de archivos
    $scope.cargandoConsulta = false;
    $scope.initAdjunto = function(ruta) {
      $scope.adjunto = $("#fileuploader").uploadFile({
        url:ruta,
        autoSubmit: false,
        fileName:"myfile",
        dynamicFormData: function(){
          var data ={'test':'test'}
          return data;
        },
        onSuccess: function(file, data){
          alert(JSON.stringify(data));
          console.log(JSON.stringify(data));
          $scope.cerrarWindow();
          $scope.refreshTabs();
          $scope.cargandoConsulta = false;
        },
        onError: function(files,status,errMsg,pd){
          alert(JSON.stringify(errMsg));
          $scope.cargandoConsulta = false;
        }
      });
    }
    $scope.IniciarUploadAdjunto = function(){
      $scope.cargandoConsulta = true;
      $scope.adjunto.startUpload();
    }
}
