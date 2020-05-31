<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Pacientes
			</header>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12 adv-table editable-table">
						<div class="row">
							<div class="col-md-3">
								<a class="btn btn-primary" href="<?= base_url('Pacientes/nuevo'); ?>">
									Nuevo Paciente <i class="fa fa-plus"></i>
								</a>
								<br/>
								<br/>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<input type="text" placeholder="Nombres" id="nombres" class="form-control">
							</div>
							<div class="col-md-3">
								<input type="text" placeholder="Apellidos" id="apellidos" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<br/>
								<table id="pacientes" class="table table-striped table-hover table-bordered">
									<thead>
									<tr>
										<th>Nombres</th>
										<th>Apellidos</th>
										<th>Telefono</th>
										<th>Acciones</th>
									</tr>
									</thead>
									<tbody>
									<?php
									foreach ($pacientes as $paciente) {
										echo "<tr>";
										echo "<td>" . $paciente->nombres . "</td>";
										echo "<td>" . $paciente->apellidos . "</td>";
										echo "<td>" . $paciente->telefono . "</td>";
										echo "<td>" . $paciente->boton . "</td>";
										echo "</tr>";
									}
									?>
									</tbody>
								</table>
							</div>
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

		loadTable();

		$('#nombres').keyup(function () {
			oPendi
				.columns(0)
				.search('"' + $(this).val() + '"')
				.draw();
		});

		$('#apellidos').keyup(function () {
			var buscar = '"' + $(this).val() + '"';
			oPendi
				.columns(1)
				.search(buscar)
				.draw();
		});
	});

	function loadTable () {
		oPendi = $('#pacientes').DataTable({
			responsive:      true,
			'order':         [[0, 'desc']],
			'aLengthMenu':   [[10, 50, -1], [10, 50, 'Todo']],
			'bLengthChange': false,
			'oLanguage':     {
				'sProcessing':     'Procesando...',
				'sLengthMenu':     'Mostrar _MENU_ registros',
				'sZeroRecords':    'No se encontraron resultados',
				'sEmptyTable':     'Ningún dato disponible en esta tabla',
				'sInfo':           'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
				'sInfoEmpty':      'Mostrando registros del 0 al 0 de un total de 0 registros',
				'sInfoFiltered':   '(filtrado de un total de _MAX_ registros)',
				'sInfoPostFix':    '',
				//'sSearch':         'Buscar',
				'sUrl':            '',
				'sInfoThousands':  ',',
				'sLoadingRecords': 'Cargando...',
				'oPaginate':       {
					sFirst:    'Primero',
					sLast:     'Último',
					sNext:     'Siguiente',
					sPrevious: 'Anterior'
				}
			}
		});
		$('#pacientes_filter').hide();
	};
</script>
