<section id="duplicar" class="nodisplay" style="background: rgba(42, 40, 51, 0.6); width:100%; height:100%; position: absolute; z-index: 5;padding:2em">
  <div class="noMaterialStyles row" style="position:relative; padding:2em; background:#FFF">
    <b class="col s5">Fecha a duplicar: </b>
    <input type="text" class="datepicker noMaterialStyles col s5" ng-model="fecha_duplicar" ng-init="datepicker_init()" >
    <button type="button" class="btn mini-btn" ng-click="duplicar('<?= site_url('reporte/duplicar') ?>', $event)">Duplicar</button>
    <button type="button" class="btn mini-btn red" ng-click="formDuplicar()">Cerrar</button>
  </div>
</section>
