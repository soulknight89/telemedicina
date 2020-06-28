<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Nivel de Calidad de los Pedidos Generados
				<div class="pull-right">
					<label for="mes">Mes</label>
					<select id="mes" onchange="cambiarVista()">
						<option value="">Seleccione</option>
						<?php
						foreach ($meses as $mes) {
							$selectedM = ($mes->id == $mesActual) ? 'selected' : '';
							echo "<option value='$mes->id' $selectedM>$mes->nombre</option>";
						}
						?>
					</select>
					<label for="anio">Año</label>
					<select id="anio" onchange="cambiarVista()">
						<option value="">Seleccione</option>
						<?php
						$initYear = 2018;
						$curYear  = $anioActual;
						do {
							$selectedY = ($initYear == $curYear) ? 'selected' : '';
							echo "<option value='$initYear' $selectedY>$initYear</option>";
							$initYear++;
						} while ($initYear <= $curYear);
						?>
					</select>
				</div>
			</header>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12 pull-right">
						<a href="<?= base_url('Reportes/calidadPDF/' . $mesActual . '/' . $anioActual) ?>"
						   class="btn btn-warning">Exportar</a>
					</div>
					<div class="col-md-12">
						<div class="row text-center">
							<div class="col-md-3"></div>
							<div class="col-md-6">
								<table style="" class="table table-striped table-hover table-bordered">
									<thead>
									<tr>
										<th>Proceso Observador</th>
										<td>Gestion de Pedidos</td>
									</tr>
									<tr>
										<th>Indicador</th>
										<td>Nivel de Calidad de los Pedidos Generados</td>
									</tr>
									<tr>
										<th>Formula</th>
										<td>
											<b><u>Pedidos Generados Sin Incidencias</u> * 100</b><br/>
											<b><center>Total Pedidos Generados</center></b>
										</td>
									</tr>
									<tr>
										<th>Periodicidad</th>
										<td>Diario</td>
									</tr>
									</thead>
								</table>
							</div>
							<div class="col-md-3"></div>
						</div>
						<div class="row">
							<div class="col-md-3"></div>
							<div class="col-md-6">
								<br/>
								<table id="calidad" class="table table-striped table-hover table-bordered"
									   style="width: 100%">
									<thead>
									<tr>
										<th>Item</th>
										<th>Fecha</th>
                                        <th>Pedidos Generados <br/> sin Indicencias</th>
										<th>Total Pedidos Generados</th>
										<th>Nivel de Calidad de <br/> los Pedidos Generados</th>
									</tr>
									</thead>
									<tbody>
									<?php
									$item        = 0;
									$totales     = 0;
									$incidencias = 0;
									foreach ($indicadores as $indicador) {
										$item++;
										$valor = 0;
										if ($indicador->total > 0) {
											$valor = round(
												(($indicador->total - $indicador->incidencias) / $indicador->total) * 100,
												'2'
											);
										}
										$totales     += $indicador->total;
										$incidencias += $indicador->incidencias;
										echo "<tr>";
										echo "<td>" . $item . "</td>";
										echo "<td>" . $indicador->fecha . "</td>";
                                        echo "<td>" . ($indicador->total - $indicador->incidencias) . "</td>";
										echo "<td>" . $indicador->total . "</td>";
										echo "<td>" . $valor . "%" . "</td>";
										echo "</tr>";
									}
									?>
									</tbody>
									<tfoot>
									<?php
                                    $totalIndicador = 0;
                                    if($totales > 0) {
                                        $totalIndicador = round((($totales - $incidencias) / $totales) * 100, '2');
                                    }
									echo "<th colspan='2' class='text-center'>Total</th>";
									echo "<th>".($totales - $incidencias)."</th>";
									echo "<th>$totales</th>";
									echo "<th>" . $totalIndicador . "%</th>";
									?>
									</tfoot>
								</table>
							</div>
							<div class="col-md-3"></div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>
<script>
	var oPendi;

	$(document).ready(function () {

		//loadTable();

		// $('#nombre').keyup(function () {
		// 	oPendi
		// 		.columns(0)
		// 		.search('"' + $(this).val() + '"')
		// 		.draw();
		// });
		//
		// $('#descripcion').keyup(function () {
		// 	var buscar = '"' + $(this).val() + '"';
		// 	oPendi
		// 		.columns(1)
		// 		.search(buscar)
		// 		.draw();
		// });
		//
		// $('#precio').keyup(function () {
		// 	var buscar = '"' + $(this).val() + '"';
		// 	oPendi
		// 		.columns(2)
		// 		.search(buscar)
		// 		.draw();
		// });

	});

	function cambiarVista () {
		let mes = $('#mes').val();
		let anio = $('#anio').val();
		if (mes && anio) {
			location.href = base_url + 'Reportes/calidad/' + mes + '/' + anio;
		}
	}
</script>
