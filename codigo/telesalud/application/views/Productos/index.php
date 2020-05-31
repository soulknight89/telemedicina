<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Productos
			</header>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12 adv-table editable-table">
						<div class="row">
							<div class="col-md-3">
								<a class="btn btn-primary" href="<?= base_url('Productos/nuevo'); ?>">
									Agregar Producto <i class="fa fa-plus"></i>
								</a>
								<br/>
								<br/>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<input type="text" placeholder="Nombre" id="nombre" class="form-control">
							</div>
							<div class="col-md-3">
								<input type="text" placeholder="Descripcion" id="descripcion" class="form-control">
							</div>
							<div class="col-md-3">
								<input type="text" placeholder="Precio" id="precio" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<br/>
								<table id="productos" class="table table-striped table-hover table-bordered" style="width: 100%">
									<thead>
									<tr>
										<th>Nombre</th>
										<th>Descripcion</th>
										<th>Precio</th>
										<th>Editar</th>
									</tr>
									</thead>
									<tbody>
									<?php
									foreach ($productos as $producto) {
										echo "<tr>";
										echo "<td>" . $producto->nombre . "</td>";
										echo "<td>" . $producto->descripcion . "</td>";
										echo "<td>" . $producto->precio . "</td>";
										echo "<td>" . $producto->boton . "</td>";
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

		$('#descripcion').keyup(function () {
			var buscar = '"' + $(this).val() + '"';
			oPendi
				.columns(1)
				.search(buscar)
				.draw();
		});

		$('#precio').keyup(function () {
			var buscar = '"' + $(this).val() + '"';
			oPendi
				.columns(2)
				.search(buscar)
				.draw();
		});

	});

	function loadTable () {
		oPendi = $('#productos').DataTable({
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
		$('#productos_filter').hide();
	};
</script>
