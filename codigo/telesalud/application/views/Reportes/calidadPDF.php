<head>
	<title>Reporte</title>
</head>
<body>
<style>
	table, thead, tbody, tr, th, td {
		border: 1px solid black !important;
		border-collapse: collapse !important;
	}
</style>
<h2 style="text-align: center">Indicador: Nivel de Calidad de los Pedidos Generados</h2>
<br>
<br>
<div class="row text-center">
	<div style="padding-left:10%;padding-right: 10%">
		<table style="max-width: 700px; text-align: center;"
			   class="table table-striped table-hover table-bordered">
			<thead style="border:1px solid black; ">
			<tr style="border:1px solid black; ">
				<th style="border:1px solid black; ">Proceso Observador</th>
				<td style="border:1px solid black; ">Gestion de Pedidos</td>
			</tr>
			<tr style="border:1px solid black; ">
				<th style="border:1px solid black; ">Indicador</th>
				<td style="border:1px solid black; ">Nivel de Calidad de los Pedidos Generados</td>
			</tr>
			<tr style="border:1px solid black; ">
				<th style="border:1px solid black; ">Formula</th>
				<td style="border:1px solid black; ">
					<b><u>Pedidos Generados Sin Incidencias</u> * 100</b><br/><b> / Total Pedidos Generados</b>
				</td>
			</tr>
			<tr style="border:1px solid black; ">
				<th style="border:1px solid black; ">Periodicidad</th>
				<td style="border:1px solid black; ">Diario</td>
			</tr>
			<tr style="border:1px solid black; ">
				<th style="border:1px solid black; ">Mes</th>
				<td style="border:1px solid black; "><?= $mesActual;?></td>
			</tr>
			<tr style="border:1px solid black; ">
				<th style="border:1px solid black; ">Año</th>
				<td style="border:1px solid black; "><?= $anioActual;?></td>
			</tr>
			</thead>
		</table>
	</div>
</div>
<div class="row">
	<br>
	<br>
	<div>
		<table id="calidad"
			   style="text-align: center;width: 100%">
			<thead style="border:1px solid black; ">
			<tr>
				<th style="border:1px solid black">Item</th>
				<th style="border:1px solid black">Fecha</th>
                <th style="border:1px solid black">Pedidos Generados <br/> sin Indicencias</th>
				<th style="border:1px solid black">Pedidos Generados</th>
				<th style="border:1px solid black">Nivel de Calidad de <br/> los Pedidos Generados</th>
			</tr>
			</thead>
			<tbody style="border:1px solid black; ">
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
				echo "<tr style=\"border:1px solid black; \">";
				echo "<td style=\"border:1px solid black; \">" . $item . "</td>";
				echo "<td style=\"border:1px solid black; \">" . $indicador->fecha . "</td>";
                echo "<td style=\"border:1px solid black; \">" .($indicador->total - $indicador->incidencias) . "</td>";
				echo "<td style=\"border:1px solid black; \">" . $indicador->total . "</td>";
				echo "<td style=\"border:1px solid black; \">" . $valor . "%" . "</td>";
				echo "</tr>";
			}
			?>
			</tbody>
			<tfoot style="border:1px solid black; ">
			<tr style="border:1px solid black; ">
				<?php
				$totalIndicador = ($totales > 0) ? round(
						(($totales - $incidencias) / $totales) * 100, '2'
					) . '%' : '0%';
				echo "<td> </td>";
				echo "<td style=\"border:1px solid black; \">Total</td>";
				echo "<td style='border:1px solid black;'>".($totales -$incidencias)."</td>";
				echo "<td style=\"border:1px solid black; \">$totales</td>";
				echo "<td style=\"border:1px solid black; \">$totalIndicador</td>";
				?>
			</tr>
			</tfoot>
		</table>
	</div>
</div>
</body>
