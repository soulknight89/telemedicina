<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Ordenes de Pedido Registradas
			</header>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12 adv-table editable-table">
						<div class="row">
							<div class="col-md-3">
								<a class="btn btn-primary" href="<?= base_url('Pedidos/nuevo'); ?>">
									Nueva Orden de Pedido <i class="fa fa-plus"></i>
								</a>
								<br/>
								<br/>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<input type="text" placeholder="Orden de Pedido" id="orden" class="form-control">
							</div>
							<?php
							if ($usuario->usu_perfil != 2) {
								?>
								<div class="col-md-3">
									<input type="text" placeholder="Punto de Venta" id="punto" class="form-control">
								</div>
							<?php } ?>
							<div class="col-md-3">
								<input type="text" placeholder="Paciente" id="paciente" class="form-control">
							</div>
							<div class="col-md-2">
								<input type="text" placeholder="Estado" id="estado" class="form-control">
							</div>
							<div class="col-md-2" id="exportar">
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<br/>
								<table id="pedidos" class="table table-striped table-hover table-bordered">
									<thead>
									<tr>
										<th>Orden Pedido</th>
										<th>Fecha Pedido</th>
										<th>Paciente</th>
										<?php
										if ($usuario->usu_perfil != 2) {
											?>
											<th>Punto de Venta</th>
										<?php } ?>
										<th>Items</th>
										<th>A Cuenta</th>
										<th>Total</th>
										<th>Debe</th>
										<th>Estado</th>
										<th>Opciones</th>
									</tr>
									</thead>
									<tbody>
									<?php
									foreach ($pedidos as $pedido) {
										echo "<tr>";
										echo "<td>" . $pedido->codigo . "</td>";
										echo "<td>" . $pedido->fecha_pedido . "</td>";
										echo "<td>" . $pedido->paciente . "</td>";
										if ($usuario->usu_perfil != 2) {
											echo "<td>" . $pedido->punto_venta . "</td>";
										}
										echo "<td>" . $pedido->items . "</td>";
										echo "<td>" . $pedido->pagado . "</td>";
										echo "<td>" . $pedido->total . "</td>";
										echo "<td>" . ($pedido->total - $pedido->pagado) . "</td>";
										echo "<td>" . $pedido->estado . "</td>";
										echo "<td>" . $pedido->boton . "</td>";
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

		$('#orden').keyup(function () {
			oPendi
				.columns(0)
				.search('"' + $(this).val() + '"')
				.draw();
		});

		$('#paciente').keyup(function () {
			var buscar = '"' + $(this).val() + '"';
			oPendi
				.columns(2)
				.search(buscar)
				.draw();
		});

		$('#punto').keyup(function () {
			var buscar = '"' + $(this).val() + '"';
			oPendi
				.columns(3)
				.search(buscar)
				.draw();
		});

		$('#estado').keyup(function () {
			var buscar = '"' + $(this).val() + '"';
			oPendi
				<?php if ($usuario->usu_perfil != 2) { ?>
				.columns(8)
				<?php } else { ?>
				.columns(7)
				<?php } ?>
				.search(buscar)
				.draw();
		});
	});

	function loadTable () {
		oPendi = $('#pedidos').DataTable({
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
		$('#pedidos_filter').hide();
		var buttons = new $.fn.dataTable.Buttons(oPendi, {
			buttons: [
				{
					extend:        'excelHtml5',
					title:         'Pedidos Registrados',
					exportOptions: {
						<?php if ($usuario->usu_perfil != 2) { ?>
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
						<?php } else { ?>
						columns: [0, 1, 2, 3, 4, 5, 6, 7]
						<?php } ?>
					}
				},
				{
					extend:        'pdfHtml5',
					title:         'Envios Registrados',
					exportOptions: {
						columns: [0, 1, 2, 3]
					}
				}
				//,'pdfHtml5'
			]
		}).container().appendTo($('#exportar'));
	};
</script>
