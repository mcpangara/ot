<div class="" ng-controller="lista_personal">
  <h5 class="center-align">Manejo de personal por Orden de Trabajo</h5>

  <button type="button" class="btn green mini-btn" ng-click="getAjaxWindow('<?= site_url('persona/formUpload'); ?>',$event, '')" data-icon="&#xe030;"> Carga de personal x OT</button>
  <br><br>

  <div ng-if="cargandoConsulta">
    Cargando...
    <img src="<?= base_url('assets/img/loader.gif') ?>" width="100px" />
  </div>


  <form>
    <fieldset>
      <div class="noMaterialStyles row">
        <label clasS="col s3 m3">Consulta por base (C.O.): </label>
        <select ng-model="consulta.base" class="col s4 m4" ng-init="consulta.base = '169'" style="height:4ex;">
          <?php foreach ($bases->result() as $b): ?>
            <option value="<?= $b->idbase ?>"><?= $b->idbase." - ".$b->nombre_base ?></option>
          <?php endforeach; ?>
        </select>
        <div class="col s1 m1">
          <button class="btn mini-btn" style="margin-top: 0" data-icon="," ng-click="getPersonalByOtBase('<?= site_url('persona/getPersonasOtByBase') ?>')"></button>
        </div>
      </div>
    </fieldset>
  </form>
  <table class="mytabla font12">
    <thead>
      <tr>
         <th>No.</th>
         <th>Base</th>
         <th>Indetificación</th>
         <th>Nombre del empleado</th>
         <th>OT</th>
         <th>Cargo</th>
         <th>Opciones del registro</th>
      </tr>
    </thead>
    <tbody>
      <tr class="noMaterialStyles">
        <td></td>
        <td></td>
        <td><input type="text" ng-model="filtro_lp.identificacion" placeholder="busca aqui"></td>
        <td><input type="text" ng-model="filtro_lp.nombre_completo" placeholder="busca aqui"></td>
        <td><input type="text" ng-model="filtro_lp.nombre_ot" placeholder="busca aqui"></td>
        <td><input type="text" ng-model="filtro_lp.descripcion" placeholder="busca aqui"></td>
        <td></td>
      </tr>
      <tr ng-repeat="p in pers | filter: filtro_lp track by $index ">
         <td ng-bind="$index+1"></td>
         <td ng-bind="p.base_idbase"></td>
         <td ng-bind="p.identificacion"></td>
         <td ng-bind="p.nombre_completo"></td>
         <td ng-bind="p.nombre_ot"></td>
         <td ng-bind="p.descripcion"></td>
         <td></td>
      </tr>
    </tbody>
  </table>

</div>
