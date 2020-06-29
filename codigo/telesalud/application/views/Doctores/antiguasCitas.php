<?php
	/**
	 * Variables dias: representa los dias disponibles 1-7, horarios es un arreglo con horarios registrados
	 * @var $citas array
	 */
?>
<h4 class="font-weight-bold py-3 mb-4">
	<span class="text-muted font-weight-light">Doctores /</span> Citas Pasadas
</h4>
<div class="card">
	<div class="card-datatable table-responsive">
		<table class="table table-striped table-bordered">
			<thead>
			<tr>
				<td>Dia</td>
				<td>Hora</td>
				<td>Paciente</td>
			</tr>
			</thead>
			<tbody>
			<?php
				if($citas && count($citas)>0) {
					foreach ($citas as $dia) {
						?>
						<tr>
							<td><?= $dia->dia; ?></td>
							<td><?= $dia->hora; ?></td>
							<td><?= $dia->paciente; ?></td>
						</tr>
						<?php
					}
				}
			?>
			</tbody>
		</table>
	</div>
</div>
