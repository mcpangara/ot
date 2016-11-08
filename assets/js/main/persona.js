var lista_personal = function($scope, $http, $timeout)
{
  $scope.pers = [];
  $scope.consulta = {};
  $scope.getPersonalByOtBase = function(ruta){
    $http.post(ruta, {base : $scope.consulta.base} )
    .then(
      function(response){
        console.log(response.data)
        $scope.pers = response.data;
      },
      function(response){
        console.log(response)
      }
    );
  }
  $scope.cargandoConsulta = false;
  $scope.filtro_lp = [];
  $scope.cargaListaPersona = function(ruta, key=null){
    $scope.cargandoConsulta = true;
    $http.post(
      ruta,
      {
        llave : key
      }
    ).then(
      function(response) {
        $scope.pers=response.data;
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


var personalUp = function($scope, $http, $timeout) {
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
          $("#resultado").html(data);
          $("#inputhtml").val(data)
          //console.log(JSON.stringify(data));
          //$scope.cerrarWindow();
          //$scope.refreshTabs();
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
