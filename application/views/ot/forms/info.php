  <div class="col l6 s12 row">
    <label class="col m2 right-align" ><b>Numero SAP:</b></label>
    <input class="col m7" type="text" ng-model="ot.numero_sap" placeholder="No. SAP" />
  </div>

  <br class="clear-left">
  <hr style="border:1px solid #33c633">
  <br>

  <div class="col l12 row">
    <div class="col l12 row">
      <div class="col s12 l6">
        <input type="checkbox" id="p1" ng-model="ot.json.p1" />
        <label for="p1">PERMISO DE PREDIO</label>
      </div>

      <div class="col s12 l6">
        <input type="checkbox" id="p2" ng-model="ot.json.p2" />
        <label for="p2">PERMISO DE OCUPACION DE CAUSE</label>
      </div>

      <div class="col s12 l6">
        <input type="checkbox" id="p3" ng-model="ot.json.p3" />
        <label for="p3">CURSO F.T.S</label>
      </div>

      <div class="col s12 l6">
        <input type="checkbox" id="p4" ng-model="ot.json.p4" />
        <label for="p4">PERMISO APROVECHAMIENTO FORESTAL</label>
      </div>

      <div class="col s12 l6">
        <input type="checkbox" id="p5" ng-model="ot.json.p5" />
        <label for="p5">DIVULGACION A COMUNIDAD</label>
      </div>
  </div>

  <div class="col l12 s12 row">
    <label for=""><b>Actividad:</b></label>
    <textarea  id="actividad" ng-model="ot.actividad" ng-init="setTextarea('#actividad', ot.actividad)"></textarea>
  </div>

  <div class="col l12 s12 row">
    <label for=""><b>Justificación:</b></label>
    <textarea id="justificacion"  ng-model="ot.justificacion" ng-init="setTextarea('#justificacion', ot.justificacion)"></textarea>
  </div>

  </div>



  <br class="clear-left">
  <hr style="border:1px solid #33c633">
  <br>

  <div class="col l3 row">
    <label class="col m3" ><b>Locacion:</b></label>
    <input class="col m7" type="text" ng-model="ot.locacion" />
  </div>
  <div class="col l3 row">
    <label class="col m3" ><b>Abscisa:</b></label>
    <input class="col m7" type="text" ng-model="ot.abscisa" />
  </div>

  <div class="col l12">
    <br>
  </div>

  <div class="col l12 s12 row">
    <label><b>Departamento:</b></label>
    <span ng-bind="ot.departamento" ng-init="obtenerMunicipios(ot.departamento, '<?= site_url('miscelanio/getMunicipios') ?>')"></span>
    <select id="depart" ng-model="ot.departamento" data-getmunis="<?= site_url('miscelanio/getMunicipios') ?>"
        ng-change="obtenerMunicipios(ot.departamento, '<?= site_url('miscelanio/getMunicipios') ?>')">
      <option value="">Seleccione nuevo departamento del país</option>
      <?php foreach ($depars->result() as $depar) {
      ?>
      <option value="<?= $depar->departamento ?>"><?= $depar->departamento ?></option>
      <?php
      } ?>
    </select>
  </div>
  <div class="col l6 s12 row">
    <label><b>Municipio:</b></label>
    <span ng-bind="ot.municipio"></span>
    <select id="munic" ng-model="ot.municipio">
      <option value="">seleccione nuevo municipio</option>
      <option ng-repeat="m in munis track by $index" value="{{ m.municipio }}">{{ m.municipio }}</option>
    </select>
  </div>
  <div class="col l6 s12 row">
    <label><b> Poblado/Vereda </b></label>
    <input type="text" ng-model="ot.vereda">
  </div>

  <br class="clear-left">
  <hr style="border:1px solid #33c633">
  <br>
