var listInformeType = function($scope, $http, $timeout) {
  $scope.InfoTypes = [];
  $scope.getInformeTypes = function(url) {
    $http.get(url).then(
      function(response){
        $scope.InfoTypes = response.data;
      },
      function(response){
        alert("Fallo al cargar datos " + response.status);
      }
    );
  }

  $scope.viewJSON = function(i) {
    alert("funcion no habilitada")
  }
}

var editTypeInforme = function($scope, $http, $timeout) {
  $scope.infoType =[];
  $scope.infoTypeElements = [];
  $scope.nombre_tipo ="";
  $scope.margenes = "3cm 3cm 3cm 4cm;"
  $scope.chageTypeInforme = function(url){
    $http.get(url)
      .then(
        function(response){
          $scope.infoType = response.data[0];
          $scope.nombre_tipo = response.data[0].nombre_tipo_informe;
          $scope.infoTypeElements = JSON.parse(response.data[0].json);
        },
        function(response){
          alert("algo salio mal");
        }
      );
  }

  $scope.saveEditedType = function(url){
    var dt = {
      margene: $scope.margenes,
      json: JSON.stringify($scope.infoTypeElements)
    };
    $http.post(url, dt)
        .then(
          function(response){
            alert(response.data);
            $timeout(function(){
              $scope.$parent.cerrarWindow();
              $scope.$parent.refreshTabs();
            });
          },
          function(response){
            alert("Ha ocurrido un error inesperado "+response.data);
          }
        );
  }
}

var addNewTypeInforme = function($scope, $http, $timeout){
  $scope.infoTypeElements = [];
  $scope.nombre_tipo =""
  $scope.margenes = "3cm 3cm 3cm 4cm;"
  $scope.addSectionInfoType = function(elemento){
    elemento.push({
      "titulo":"",
      "tipo":"",
      "content": "",
      "pagina_unica":false,
      "tipo":"texto",
      "margenes":"1,0,0,1",
      "subitems":[]
    });
  }

  $scope.deleteNodeSection = function(item, node){
    node.splice(node.indexOf(item),1);
  }

  $scope.sendNewTypeInforme = function(url){
    var dt = {
      nombre_informe:$scope.nombre_tipo,
      margenes: $scope.margenes,
      json: JSON.stringify($scope.infoTypeElements)
    };
    $http.post(url, dt)
        .then(
          function(response){
            alert(response.data);
            $timeout(function(){
              $scope.$parent.cerrarWindow();
              $scope.$parent.refreshTabs();
            });
          },
          function(response){
            alert("Ha ocurrido un error inesperado "+response.data);
          }
        );
  }
}
