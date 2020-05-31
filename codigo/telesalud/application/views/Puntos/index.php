<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Modulo Puntos de Venta
			</header>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12 adv-table editable-table">
						<div class="row">
							<div class="col-md-3">
								<a class="btn btn-primary" href="<?= base_url('Puntos/nuevo'); ?>">
									Nuevo Punto de Venta <i class="fa fa-plus"></i>
								</a>
								<br/>
								<br/>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<input type="text" placeholder="Nombre" id="nombre" class="form-control">
							</div>
							<div class="col-md-2">
								<input type="text" placeholder="Codigo" id="codigo" class="form-control">
							</div>
							<div class="col-md-2">
								<input type="text" placeholder="Departamento" id="departamento" class="form-control">
							</div>
							<div class="col-md-3">
								<input type="text" placeholder="Provincia" id="provincia" class="form-control">
							</div>
							<div class="col-md-3">
								<input type="text" placeholder="Distrito" id="distrito" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<br/>
								<table id="pacientes" class="table table-striped table-hover table-bordered">
									<thead>
									<tr>
										<th>Nombre</th>
										<th>Codigo</th>
										<th>Departamento</th>
										<th>Provincia</th>
										<th>Distrito</th>
										<th>Acciones</th>
									</tr>
									</thead>
									<tbody>
									<?php
									foreach ($puntos as $punto) {
										echo "<tr>";
										echo "<td>" . $punto->nombre . "</td>";
										echo "<td>" . $punto->codigo . "</td>";
										echo "<td>" . $punto->departamento . "</td>";
										echo "<td>" . $punto->provincia . "</td>";
										echo "<td>" . $punto->distrito . "</td>";
										echo "<td>" . $punto->boton . "</td>";
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

		$('#nombre').keyup(function () {
			oPendi
				.columns(0)
				.search('"' + $(this).val() + '"')
				.draw();
		});

		$('#codigo').keyup(function () {
			var buscar = '"' + $(this).val() + '"';
			oPendi
				.columns(1)
				.search(buscar)
				.draw();
		});

		$('#departamento').keyup(function () {
			var buscar = '"' + $(this).val() + '"';
			oPendi
				.columns(2)
				.search(buscar)
				.draw();
		});

		$('#provincia').keyup(function () {
			var buscar = '"' + $(this).val() + '"';
			oPendi
				.columns(3)
				.search(buscar)
				.draw();
		});

		$('#distrito').keyup(function () {
			var buscar = '"' + $(this).val() + '"';
			oPendi
				.columns(4)
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
