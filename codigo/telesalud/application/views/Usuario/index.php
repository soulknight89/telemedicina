<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Usuarios
			</header>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12 adv-table editable-table">
						<div class="row">
							<div class="col-md-3">
								<a class="btn btn-primary" href="<?= base_url('Usuario/nuevo'); ?>">
									Nuevo Usuario <i class="fa fa-plus"></i>
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
							<div class="col-md-3">
								<input type="text" placeholder="Perfil" id="perfil" class="form-control">
							</div>
							<div class="col-md-3">
								<input type="text" placeholder="Punto de Venta" id="punto" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<br/>
								<table id="usuarios" class="table table-striped table-hover table-bordered">
									<thead>
									<tr>
										<th>Nombres</th>
										<th>Apellidos</th>
										<th>Correo</th>
										<th>Telefono</th>
										<th>Perfil</th>
										<th>Punto de Venta</th>
										<th>Estado</th>
										<th>Editar</th>
									</tr>
									</thead>
									<tbody>
									<?php
									foreach ($usuarios as $usuario) {
										echo "<tr>";
										echo "<td>" . $usuario->nombres . "</td>";
										echo "<td>" . $usuario->apellidos . "</td>";
										echo "<td>" . $usuario->email . "</td>";
										echo "<td>" . $usuario->telefono . "</td>";
										echo "<td>" . $usuario->perfil . "</td>";
										echo "<td>" . $usuario->punto_venta . "</td>";
										echo "<td>" . $usuario->estado . "</td>";
										echo "<td>" . $usuario->boton . "</td>";
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

		$('#perfil').keyup(function () {
			var buscar = '"' + $(this).val() + '"';
			oPendi
				.columns(4)
				.search(buscar)
				.draw();
		});

		$('#punto_venta').keyup(function () {
			var buscar = '"' + $(this).val() + '"';
			oPendi
				.columns(5)
				.search(buscar)
				.draw();
		});
	});

	function loadTable () {
		oPendi = $('#usuarios').DataTable({
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
		$('#usuarios_filter').hide();
	};
</script>
