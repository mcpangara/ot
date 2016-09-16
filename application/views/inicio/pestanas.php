<section id="tabs"  class="contenidos" ng-controller="test">
  <div class="tabs_aplier">

    <div class="tabContainer" id="tabContainer">

      <ul>

        <li ng-repeat="tab in tabs track by $index" class="pestana {{tab.class}}">
          <a class="clickeableTab" href="#" ng-click="clickedTab($event, tab)" data-tab="{{ tab.linkto }}" ng-bind-html="tab.titulo"></a>
          &nbsp;&nbsp;
          <a href="#" ng-if="tab.linkto != 'options' " ng-click="closeTab(tab, $event)" class="icon-red close-btn" data-icon="&#xe04d;"></a>
        </li>

      </ul>

    </div>

    <div class="tabContents" id="tabContents">

      <div ng-repeat="tab in tabs" id="{{tab.linkto}}" class="vistaPestana {{ tab.class }}" ng-include="tab.include"></div>

    </div>

  </div>

  <div id="VentanaContainer" class="nodisplay row">
    <div class="loader col s12" ng-include="form">

    </div>
  </div>
  <div id="WindowOculta">
    <button type="button" class="btn blue" ng-click="toggleWindow();" name="button">
      <small>Mostrar Ventana oculta</small>
    </button>
  </div>
</section>



<!-- la directiva ngInclude soluciono el problema de los eventos en inteerfaces asincronas -->
