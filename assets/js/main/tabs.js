var app = angular.module("myapp", ['ui.tinymce']);
app.controller("test", function($scope, $sce, $compile, $http, $templateCache, $timeout){
  $scope.estructura = [];
  $scope.myform = '';
  $scope.countertab = 0;
  $scope.tabs = [{ id:$scope.countertab, linkto:"options", titulo:$sce.trustAsHtml("Menu general"), content: '', include:task.url, class: 'active', active: true}];
  $scope.bigHtml = '',
  $scope.estructuras = [];
  $scope.uploader = undefined;
  $scope.showSlideState = true;
  //============================================================================
  //Funcion que carga una vista de pestaña desde un boton de enlace en la vista de inicio
  $scope.clickeableLink = function(myurl, evt, titulo){
    console.log(myurl);
    evt.preventDefault();
    $scope.countertab++;
    $scope.addNewTab($sce.trustAsHtml(titulo+' <small class="grey-text">'+$scope.countertab+'</small>'), myurl, "");
  }
  //funcion (child) que agrega una pestaña al arreglo
  $scope.addNewTab = function(title, link, myContent){
    $scope.tabs.push({ id:$scope.countertab, linkto:"tab"+$scope.countertab, titulo:title, content: '', include:link, class: 'active', active: true});
        angular.forEach($scope.tabs, function($value, $key){
          $timeout(function(){
            if( $value.id != $scope.countertab ) {
              $value.class = '';
              $value.active = false;
            }
          });
        });
  }
  //============================================================================
  //Al dar click sobre una pestaña esta funcion la pone como pestaña activa
  $scope.clickedTab = function(e, tab){
    e.preventDefault();
    angular.forEach($scope.tabs, function($value, $key){
      $value.class = '';
      $value.active = false;
    });
    tab.class = "active";
    tab.active = true;
  }
  //al sar click sobre el boton cerrar pestaña
  $scope.closeTab = function(tab, e){
    e.preventDefault();
    var i = $scope.tabs.indexOf(tab);
    angular.forEach($scope.tabs, function(val, key){
      if(val == tab){
        if($scope.tabs.length <= 1){
          $scope.tabs[0].class="active";
          $scope.tabs[0].active=true;
        }else if($scope.tabs[i].class){
          $scope.tabs[i-1].class="active";
          $scope.tabs[i-1].active=true;
        }
        $scope.tabs.splice(i,1);
        $timeout(function () {
          $templateCache.removeAll();
        });
      }
    });
  }

  //Refrecar las pestañas
  $scope.refreshTabs = function(){
    angular.forEach($scope.tabs,
      function(value, key){
        var link = value.include;
        $scope.$apply(function(){
          if (value.active) {
            value.include = "";
            $templateCache.removeAll();
          }
        });
        value.include = link;
      }
    );
  }

  //============================================================================
  //carga una archivo JSON desde un init para que se genere una vista
  $scope.loadViewJSON = function(route, idtab){
    $.ajax({
      url: route,
      method:"get",
      dataType:'html',
      success: function(data){
        $timeout(function(){
          $scope.estructuraActual = JSON.parse(data);
          console.log($scope.estructuraActual);
        });
      },
      error: function(xhr, data){
        console.log("Error: "+JSON.stringify(data));
      }
    });
  }
  $scope.estActualContent = function(i){
    angular.forEach($scope.estructuraActual, function(v,k){
      v.class=''
    });
    i.class = 'active';
    $scope.estructuraActualContent = i;
  }

  //============================================================================
  // EFECTOS VISUALES DE LA VISTA
  $scope.getFromMenu = function(target, slide){
    $('.opciones-area > div').hide();
    $(target).show(100);
    $scope.slideOtp(slide);
  }
  $scope.slideOtp = function(id){
    $(id).toggle("fast");
    $scope.changeSlideState();
  }
  $scope.changeSlideState = function(){
    if($scope.showSlideState){
      $scope.showSlideState = false;
    }else{
      $scope.showSlideState = true;
    }
  }
  $scope.imprimir = function(text){console.log(text);}
  //============================================================================
  // VENTANA EMERGENTE PARA AGREGAR
  $scope.getAjaxWindow = function(mylink, e, par1) {
    e.preventDefault();
    $scope.form = mylink;
    console.log(mylink);
    $("#VentanaContainer").removeClass("nodisplay");
    $("#WindowOculta").removeClass('WindowOculta');
  }
  $scope.getAjaxWindow2 = function(mylink, e, data) {
    e.preventDefault();
    $scope.form = mylink;
    console.log(mylink);
    $("#VentanaContainer").removeClass("nodisplay");
    $("#WindowOculta").removeClass('WindowOculta');
  }

  $scope.cerrarWindow = function(){
    $scope.form = '';
    //$("#VentanaContainer").empty();
    $scope.estructuraActual = [];
    $scope.estructuraActualContent =[];
    $("#VentanaContainer").addClass('nodisplay');
  }

  $scope.toggleWindow = function(){
    $("#VentanaContainer").toggleClass('nodisplay');
    $("#WindowOculta").toggleClass('WindowOculta');
  }
  $scope.setTextarea = function(tag, content){
    $(tag).html(content);
  }
});

app.controller('OT', function($scope, $http, $timeout){ OT($scope, $http, $timeout); });
app.controller('agregarOT', function($scope, $http, $timeout){
  agregarOT($scope, $http, $timeout);
});
app.controller('listaOT', function($scope, $http, $timeout){
  listaOT($scope, $http, $timeout);
});
app.controller('editarOT', function($scope, $http, $timeout){
  editarOT($scope, $http, $timeout);
});
app.controller('reportes', function($scope, $http, $timeout){
  reportes($scope, $http, $timeout);
});
app.controller('calendar', function($scope, $http, $timeout){
  calendar($scope, $http, $timeout);
});
app.controller('listOTReportes', function($scope, $http, $timeout){
  listOTReportes($scope, $http, $timeout);
});
app.controller('addReporte', function($scope, $http, $timeout){
  addReporte($scope, $http, $timeout);
});
app.controller('personalUp', function($scope, $http, $timeout){
  personalUp($scope, $http, $timeout);
});
app.controller('lista_personal', function($scope, $http, $timeout){
  lista_personal($scope, $http, $timeout);
});
app.controller('lista_equipos', function($scope, $http, $timeout){
  lista_equipos($scope, $http, $timeout);
});
app.controller('equipoUP', function($scope, $http, $timeout){
  equipoUP($scope, $http, $timeout);
});
