<?php
/**
 * @author: Edwin Torres -> Detalle del pedido
 */
?>
<div class="row">
	<div class="col-lg-12">
		<section class="panel panel-primary">
			<header class="panel-heading">
				Datos - Orden de Pedido <b><?= $pedido->codigo ?></b>
			</header>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-4">
						<label>Punto de Venta</label><br/>
						<input id="punto" type="text" value="<?= $pedido->punto_venta ?>" class="form-control"
							   readonly/>
					</div>
					<div class="col-md-4">
						<label>Registrado Por</label><br/>
						<input id="responsable" type="text" value="<?= $pedido->responsable ?>" class="form-control"
							   readonly/>
					</div>
					<div class="col-md-2">
						<label>#Orden de Pedido</label><br/>
						<input id="orden" type="text" value="<?= $pedido->codigo ?>" class="form-control" readonly/>
					</div>
					<div class="col-md-2">
						<label>Fecha de Pedido</label><br/>
						<input id="fecha" type="text" value="<?= $pedido->fecha_pedido ?>" class="form-control"
							   readonly/>
					</div>
					<div class="col-md-4">
						<label>Doctor</label><br/>
						<input id="responsable" type="text" value="<?= $pedido->doctor ?>" class="form-control"
							   readonly/>
					</div>
					<div class="col-md-4">
						<label>Paciente</label><br/>
						<input id="responsable" type="text" value="<?= $pedido->paciente ?>" class="form-control"
							   readonly/>
					</div>
					<div class="col-md-2">
						<label>Telefono Paciente</label><br/>
						<input id="telefono" type="text" value="<?= $pedido->telefono ?>" class="form-control"
							   readonly/>
					</div>
					<div class="col-md-2">
						<label>Estado del Pedido</label><br/>
						<input id="estado" type="text" value="<?= $pedido->estado ?>" class="form-control" readonly/>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label for="adicionales">Detalles Adicionales</label>
						<textarea id="adicionales" class="form-control" style="width: 100%; resize: none;"
								  readonly><?= $pedido->adicionales ?></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-offset-6 col-md-2">
						<label for="total">Total a Pagar</label>
						<input type="text" class="form-control" id="total" value="<?= $pedido->total ?>" disabled/>
					</div>
					<div class="col-md-2">
						<label for="cuenta">A Cuenta</label>
						<input type="text" class="form-control" value="<?= $pedido->pagado ?>" id="cuenta" readonly/>
					</div>
					<div class="col-md-2">
						<label for="saldo">Saldo</label>
						<input type="text" class="form-control" value="<?= ($pedido->total - $pedido->pagado) ?>"
							   id="saldo" readonly/>
					</div>
				</div>
			</div>
		</section>
		<section class="panel panel-info">
			<header class="panel-heading">
				Detalle Orden de Pedido
			</header>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<table id="items" class="table table-responsive table-bordered" style="width: 100% !important;">
							<thead>
							<td>Producto/Formula</td>
							<td>Cantidad</td>
							<td>Precio Unid.</td>
							<td>Total</td>
							</thead>
							<tbody>
							<?php
							foreach ($detalles as $detalle) {
								echo "<tr>";
								echo "<td>" . $detalle->producto . "</td>";
								echo "<td>" . $detalle->cantidad . "</td>";
								echo "<td>" . $detalle->precioUnitario . "</td>";
								echo "<td>" . ($detalle->cantidad * $detalle->precioUnitario) . "</td>";
								echo "</tr>";
							}
							?>
							</tbody>
						</table>
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
	});

	function loadTable () {
		oPendi = $('#items').DataTable({
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
				'sSearch':         'Buscar',
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
	};
</script>
