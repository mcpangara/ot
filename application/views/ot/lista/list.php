
	<div>
	<br>
		<table class="noMaterialStyles mytabla font12">
		    <thead>
		      <tr style="background: #3A4B52; color: #FFF">
		        <th>Base</th>
		        <th>Nombre</th>
		        <th>fecha de creacion</th>
		        <th># Tareas</th>
		        <th>Estado</th>
		        <th>Opciones</th>
		      </tr>
		    </thead>
		    <tbody>
		    	<tr>
		    		<td></td>
		    		<td><input type="text" placeholder="Filtro " =""></td>
		    		<td></td>
		    		<td></td>
		    		<td></td>
		    		<td></td>
		    	</tr>

		        <tr ng-repeat="ot in ots">
		          <td>{{ ot.base_idbase }}</td>
		          <td>{{ ot.nombre_ot }}</td>
		          <td>{{ ot.fecha_creacion }}</td>
		          <td>{{ 1 }}</td>
		          <td>{{ '' }}</td>
		          <td>
		            <button type="button" class="btn mini-btn" name="button" data-icon="&#xe03e;" ng-click="clickeableLink( '#', $event, 'test')"></button>
		            <a href="<?= site_url('ot/imprimirOT') ?>/{{ot.idOT}}" class="btn mini-btn orange black-text" data-icon=";"></a>
		          </td>
		        </tr>
		    </tbody>
		 </table>

	</div>