
<div class="" ng-controller="lista_equipos">
  <h4>Listado de equipos cargadas a la aplicación</h4>

  <button type="button" class="btn" ng-click="getAjaxWindow('<?= site_url('equipo/formUpload') ?>', $event, 'Equipos')" data-icon="&#xe030;"> Cargas de equipos</button>
  <div ng-if="cargandoConsulta">
    Cargando...
    <img src="<?= base_url('assets/img/loader.gif') ?>" width="100px" />
  </div>

  <table class="mytabla font12" ng-init="cargaListaEquipos('<?= site_url('equipo/getAll') ?>')">
    <thead>
      <tr>
         <th>No.</th>
         <th>Codigo siesa</th>
         <th>Referencia</th>
         <th>Descripción</th>
         <th>C. Costo</th>
         <th>Unidad de negocio</th>
         <th>Opciones</th>
      </tr>
    </thead>
    <tbody>
      <tr class="noMaterialStyles">
        <td></td>
        <td><input type="text" ng-model="filtro_lp.serial" placeholder="busca aqui"></td>
        <td><input type="text" ng-model="filtro_lp.referencia" placeholder="busca aqui"></td>
        <td><input type="text" ng-model="filtro_lp.descripcion" placeholder="busca aqui"></td>
        <td></td>
        <td> (Estos botones no esta aun funcionales) </td>
      </tr>
      <tr ng-repeat="q in equs | filter: filtro_lp track by $index ">
         <td ng-bind="$index+1"></td>
         <td ng-bind="q.codigo_siesa"></td>
         <td ng-bind="q.referencia"></td>
         <td ng-bind="q.descripcion"></td>
         <td ng-bind="q.ccosto"></td>
         <td ng-bind="q.desc_un"></td>
         <td>
           <button type="button" class="btn mini-btn">Historial de RDP</button>
           <button type="button" class="btn mini-btn">Sus OT´s</button>
           <button type="button" class="btn orange mini-btn">Editar</button>
         </td>
      </tr>
    </tbody>
  </table>
</div>
