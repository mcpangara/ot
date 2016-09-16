var listOT = function($scope, $http, $timeout, $compile, $sce, $templateCache){
  $scope.ots = [];

  $scope.getOTs = function(url){
    $http.get(url).then(
      function(response) {
        $scope.ots = response.data;
      },
      function(response) {
        alert(response.status);
      }
    );
  }
}

var addOT = function($scope, $http, $timeout){
  $scope.sendAddOT = function(url){
    var data = {
      nombre_ot: $('#nombre_ot').val(),
      fecha_inicio: $('#fecha_inicio').val(),
      base: $('#base').val()
    };
    if(data.nombre_ot == '' || data.fecha_inicio == '' || data.base == '' || data.nombre_ot == undefined || data.fecha_inicio == undefined || data.base == undefined){
      alert("Faltan datos por llenar!")
    }else{
      $http.post(url,data)
        .then(
          function(response){
            alert(JSON.stringify(response.data));
            $timeout(function(){
              $scope.$parent.cerrarWindow();
              $scope.$parent.refreshTabs();
            });
          },
          function(response){
            alert(JSON.stringify(response.data));
          }
        );
    }
  }
}

var listView = function($scope, $http, $timeout){
  $scope.estado = false;
  $scope.eliminarSabana = function(ruta, myid){
    $http.post(
      ruta,
      {id: myid}
    ).then(
      function(response){
        alert(response.data);
        $timeout(function(){
          $scope.$parent.refreshTabs();
        });
      },
      function(response) {
        console.log(response.status+" Error");
      }
    );
  }
}
