
		<div class="tarea" ng-repeat="tr in ot.items  track by $index" class="col s12 row">

			<?php $this->load->view('ot/add/windowItems') ?>
			<?php $this->load->view( 'ot/add/addViaticosOT', array("tarifagv"=>$tarifagv) ); ?>
			<?php $this->load->view( 'ot/add/addReembolsables'); ?>
			<?php $this->load->view( 'ot/add/addHorasExtra'); ?>

			<div class="col s12" style="text-align: left; padding: 1px">
				<span style="cursor:pointer; border:1px solid #999;border-radius:5px; padding:4px" ng-click="showSection('tarea'+$index, 'add_item_tarea')"> Tarea {{ $index+1 }}:</span>
				<br>
			</div>
			<div class="add_item_tarea col s12 row" id="tarea{{$index}}">

				<div>
					<label class="col m1 right-align"><b>{{tr.fecha_inicio.label}}</b></label>
					<input type="text" class="datepicker" ng-init="datepicker_init()" ng-model="tr.fecha_inicio.data" placeholder=" fecha" style="cursor: pointer" readonly/>
				</div>
				<div>
					<label class="col m1 right-align"><b>{{tr.fecha_fin.label}}</b></label>
					<input type="text" class="datepicker" ng-init="datepicker_init()" ng-model="tr.fecha_fin.data" placeholder=" fecha" style="cursor: pointer"  readonly/>
				</div>

				<p >
					<button type="button" ng-click="VwITems(1)" class="btn green mini-btn" data-icon="&#xe052;"> Actividades</button>
					<button type="button" ng-click="VwITems(2)" class="btn green mini-btn" data-icon="&#xe052;"> Personal</button>
					<button type="button" ng-click="VwITems(3)" class="btn green mini-btn" data-icon="&#xe052;"> Equipo</button>
				</p>

				<div class="col s12 overflowAuto">
					<table class="mytabla largWidth">
						<thead>
							<tr>
								<th>Codigo</th>
								<th>Descripción</th>
								<th>Unidad</th>
								<th>Cantidad</th>
								<th>Duración</th>
								<th>Valor Und.</th>
								<th>Valor calc.</th>
								<th>Add. fecha</th>

							</tr>
						</thead>
						<tbody>
							<tr>
								<th colspan="8" rowspan="" style="background:#ddedd0">ACTIVIDADES DE MTTO.</th>
							</tr>
							<tr ng-repeat="act in tr.actividades">
								<td>{{ act.item }}</td>
								<td>{{ act.descripcion_itemf }}</td>
								<td>{{ act.unidad_item }}</td>
								<td> <input type="number" ng-model="act.cantidad" style="width:7ex" ng-change="calcularSubtotales()"> </td>
								<td> <input type="number" ng-model="act.duracion" style="width:10ex" ng-change="calcularSubtotales()"> </td>
								<td style="text-align: right">{{ act.tarifa | currency:'$':0}}</td>
								<td style="text-align: right">
									{{ (act.cantidad * act.duracion)*act.tarifa | currency:'$':0  }}
									<button type="button" ng-click="unSelectItem(act)" class="btn red mini-btn2"> x </button></td>
								<td>{{ act.fecha_agregado }}</td>
							</tr>
							<tr>
								<th colspan="8" rowspan="" style="background:#ddedd0">PERSONAL</th>
							</tr>
							<tr ng-repeat="per in tr.personal">
								<td>{{ per.item }}</td>
								<td>{{ per.descripcion_itemf }}</td>
								<td>{{ per.unidad_item }}</td>
								<td><input type="number" ng-model="per.cantidad" style="width:7ex" ng-change="calcularSubtotales()"> </td>
								<td><input type="number" ng-model="per.duracion" style="width:10ex" ng-change="calcularSubtotales()"> </td>
								<td style="text-align: right">{{ per.tarifa | currency:'$':0 }}</td>
								<td style="text-align: right">
									{{ (per.cantidad * per.duracion)*per.tarifa | currency:'$':0  }}
									<button type="button" ng-click="unSelectItem(per)" class="btn red mini-btn2"> x </button>
								</td>
								<td>{{ per.fecha_agregado }}</td>
							</tr>
							<tr>
								<th colspan="8" rowspan="" style="background:#ddedd0">EQUIPOS</th>
							</tr>
							<tr ng-repeat="eq in tr.equipos">
								<td>{{ eq.item }}</td>
								<td>{{ eq.descripcion_itemf }}</td>
								<td>{{ eq.unidad_item }}</td>
								<td> <input type="number" ng-model="eq.cantidad" style="width:7ex" ng-change="calcularSubtotales()"> </td>
								<td> <input type="number" ng-model="eq.duracion" style="width:10ex" ng-change="calcularSubtotales()"> </td>
								<td style="text-align: right">{{ eq.tarifa | currency:'$':0 }}</td>
								<td style="text-align: right">{{ (eq.cantidad * eq.duracion)*eq.tarifa | currency:'$':0 }} <button type="button" ng-click="unSelectItem(eq)" class="btn red mini-btn2"> x </button></td>
								<td>{{ eq.fecha_agregado }}</td>
							</tr>
							<tr>
								<td colspan="6" rowspan="" style="text-align: right">Sutotal de recursos: </td>
								<td colspan="2" rowspan="" headers=""><b>{{ (eqsubtotal+actsubtotal+persubtotal) | currency:'$':0 }}</b></td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="col s12">
					<br>
					<br>
				</div>

				<div class="row col s12">

					<div id="" class="col l4 s12" style="padding:2px" >
						<div class="">
							<table class="mytabla">
								<thead>
									<tr>
										<td colspan="2"> <b>Indirectos:</b> </td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td> Administración (18%): </td>
										<td> {{ setTareaAdministracion( (eqsubtotal+actsubtotal+persubtotal) * 0.18, tr) | currency:'$':0 }} </td>
									</tr>
									<tr>
										<td> Imprevistos (1%): </td>
										<td> {{ setTareaImprevistos( (eqsubtotal+actsubtotal+persubtotal) * 0.01, tr ) | currency:'$':0 }} </td>
									</tr>
									<tr>
										<td> Utilidad (4%): </td>
										<td>{{ setTareaUtilidad( (eqsubtotal+actsubtotal+persubtotal) * 0.04, tr ) | currency:'$':0 }} </td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<div class="col l4 s12" style="padding:2px" >
						<table class="mytabla">
							<thead>
								<tr>
									<td colspan="2">
										<b>Viaticos:</b>
										<button type="button" ng-click="setViaticos('#addViaticosOT', tr)" class="btn brown lighten-1 mini-btn2" name="button">Calcular</button>
									</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Viaticos:</td>
									<td> {{ tr.viaticos.valor_viaticos | currency:'$':0 }} </td>
								</tr>
								<tr>
									<td>Administración (4.58%):</td>
									<td> {{ tr.viaticos.administracion | currency:'$':0 }} </td>
								</tr>
							</tbody>
						</table>
					</div>

					<div id="" class="col l4 s12" style="padding:2px" >

						<table class="mytabla">
							<thead>
								<tr>
									<td colspan="2">
										<b>Reembolsables:</b>
										<button type="button" ng-click="setReembolsables('#reembolsablesOT', tr)" class="btn brown lighten-1 mini-btn2" name="button">Calcular</button>
									</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td> Gastos Reembolsables:</td>
									<td> {{ tr.reembolsables.valor_reembolsables | currency:'$':0 }} </td>
								</tr>
								<tr>
									<td>Administración (1%):</td>
									<td> {{ reembolsables * 0.01 | currency:'$':0 }} </td>
								</tr>
							</tbody>
						</table>
					</div>

					<div class="clear-left"></div>

					<div id="" class="col l4 s12" style="padding:2px" >

						<table class="mytabla">
							<thead>
								<tr>
									<td colspan="2">
										<b>Horas extra y raciones:</b>
										<button type="button" ng-click="setHorasExtra('#addHorasExtra', tr)" class="btn brown lighten-1 mini-btn2" name="button">Calcular</button>
									</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td> Horas Extra:</td>
									<td> {{ tr.horas_extra.valor_horas_extra | currency:'$':0 }} </td>
								</tr>
								<tr>
									<td> Raciones:</td>
									<td>
										<div class="">
											cant: <input type="text" ng-model="tr.horas_extra.raciones_cantidad"> <small> {{ cantRaciones | currency:'$':0 }} </small>
										</div>
										<div class="">
											 Valor Und: <input type="text" ng-model="tr.horas_extra.raciones_valor_und" value=""> <small> {{ valorRacion | currency:'$':0 }} </small>
										</div>
										<b>Total raciones: {{ (tr.horas_extra.raciones_cantidad * tr.horas_extra.raciones_valor_und) | currency:'$':0 }}</b>
									</td>
								</tr>
								<tr>
									<td>Administración (1%):</td>
									<td> {{ (tr.horas_extra.valor_horas_extra + (tr.horas_extra.raciones_cantidad * tr.horas_extra.raciones_valor_und)) * 0.01 | currency:'$':0 }} </td>
								</tr>
							</tbody>
						</table>
					</div>

				</div>
			</div>

		</div>
