
<div class="" ng-controller="lista_personal">
  <h4>Listado de personas cargadas a la aplicación</h4>

  <div ng-if="cargandoConsulta">
    Cargando...
    <img src="<?= base_url('assets/img/loader.gif') ?>" width="100px" />
  </div>

  <table class="mytabla font12" ng-init="cargaListaPersona('<?= site_url('persona/getAll') ?>')">
    <thead>
      <tr>
         <th>No.</th>
         <th>Indetificación</th>
         <th>Nombre del empleado</th>
         <th>Opciones del registro</th>
      </tr>
    </thead>
    <tbody>
      <tr class="noMaterialStyles">
        <td></td>
        <td><input type="text" ng-model="filtro_lp.identificacion" placeholder="busca aqui"></td>
        <td><input type="text" ng-model="filtro_lp.nombre_completo" placeholder="busca aqui"></td>
        <td> (Estos botones no esta aun funcionales) </td>
      </tr>
      <tr ng-repeat="p in pers | filter: filtro_lp track by $index ">
         <td ng-bind="$index+1"></td>
         <td ng-bind="p.identificacion"></td>
         <td ng-bind="p.nombre_completo"></td>
         <td>
           <button type="button" class="btn mini-btn">Historial de RDP</button>
           <button type="button" class="btn green mini-btn">Sus OT´s</button>
           <button type="button" class="btn mini-btn">Cargos</button>
           <button type="button" class="btn red mini-btn">Editar</button>
         </td>
      </tr>
    </tbody>
  </table>
</div>
