var addInforme = function($scope, $http, $timeout) {
	$scope.GuardarInforme = function(url, ot, idinf){
		$scope.nodes = $scope.$parent.estructuraActual;
		$scope.datos = {titulo: $scope.titulo, idot: ot, idtipo_informe: idinf, nodes: $scope.$parent.estructuraActual};
		$http.post(
				url,
				$scope.datos
			).then(
				function(response){
					alert(response.data);
					$timeout(function(){
						$scope.$parent.cerrarWindow();
						$scope.$parent.refreshTabs();
					});
				},
				function(response){
					alert("Error al intentar guardar "+response.data);
				}
			);
	}

	$scope.estActualContent2 = function(i){
		$timeout(function(){
			angular.forEach($scope.$parent.estructuraActual, function(v,k){
				v.class=''
			});
			i.class = 'active';
			$scope.$parent.estructuraActualContent = i;
		});
	}

	$scope.tinymceOptions2 = {
    inline: false,
    plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table contextmenu paste code'
    ],
    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | paste',
    paste_data_images: true
  };
}

var editInforme = function($scope, $http, $timeout) {
	$scope.loadInformeJSON = function(url1, url2) {
		$http.get(url1)
				.then(
					function(response) {
						$scope.$parent.estructuraActual = response.data;
					},
					function(response) {
						alert("Error al cargar los nodos de información: "+response.data+" - "+response.status );
					}
				);
		$http.get(url2)
				.then(
					function(response){ $scope.inf = response.data;},
					function(response){alert("Error al cargar la informacion de este reporte");}
				);
		console.log(url2);
	}

	$scope.estActualContent2 = function(i){
    $timeout(function(){
      angular.forEach($scope.$parent.estructuraActual, function(v,k){
        v.class=''
      });
      i.class = 'active';
      $scope.$parent.estructuraActualContent = i;
    });
  }

	$scope.tinymceOptions3 = {
    inline: false,
    plugins: [
    'advlist autolink lists link image charmap print preview anchor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table contextmenu paste code'
    ],
    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | paste',
    paste_data_images: true
  };
}

var adjuntarInf = function($scope, $http, $timeout) {
	// upload de archivos
  $scope.initAdjunto = function(ruta) {
    $scope.adjunto = $("#adjunto").uploadFile({
    	url:ruta,
      autoSubmit: false,
    	fileName:"myfile",
      dynamicFormData: function(){
      	var data ={
          nombre_adjunto: $("#nombre_adjunto").val(),
					ot: $("#idot").val()
        }
      	return data;
      },
      onSuccess: function(file, data){
				alert(JSON.stringify(data));
        $scope.cerrarWindow();
        $scope.refreshTabs();
      },
      onError: function(files,status,errMsg,pd){
        alert(JSON.stringify(errMsg));
      }
  	});
  }
	$scope.IniciarUploadAdjunto = function(){
    $scope.adjunto.startUpload();
  }
}
