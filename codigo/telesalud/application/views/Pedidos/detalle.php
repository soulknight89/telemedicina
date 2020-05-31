<?php
/**
 * @author: Edwin Torres -> Detalle del pedido
 * @var $observaciones
 * @var $detalles
 * @var $tickets
 * @var $pedido
 * @var $usuario
 * @var $motivosA
 */
?>
<div class="row">
	<div class="col-lg-12">
		<section class="panel panel-primary">
			<header class="panel-heading">
				Datos - Orden de Pedido <b><?= $pedido->codigo ?></b>
				<?php
				if (in_array($usuario->usu_perfil, [1, 3]) && in_array($pedido->idEstado, [1])) {
					?>
					<a href="#" class="badge bg-danger pull-right" data-toggle="modal"
					   data-target="#modalRechazar" data-id="<?= $pedido->idPedido ?>"
					   style="color:black; font-weight: bolder;">Rechazar Pedido</a>
					<?php
				}
				if (in_array($usuario->usu_perfil, [1, 3]) && in_array($pedido->idEstado, [1])) {
					?>
					<a href="#" class="badge bg-warning pull-right" data-toggle="modal"
					   data-target="#modalObservar" data-id="<?= $pedido->idPedido ?>"
					   style="color:black; font-weight: bolder;">Observar Pedido</a>
					<?php
				}
				if (in_array($usuario->usu_perfil, [1, 3]) && in_array($pedido->idEstado, [1])) {
					?>
					<a href="#" class="badge bg-success pull-right" data-toggle="modal"
					   data-target="#modalAtender" data-id="<?= $pedido->idPedido ?>"
					   style="color:black; font-weight: bolder;">Atender Pedido</a> &nbsp;&nbsp;
					<?php
				}
				if (in_array($usuario->usu_perfil, [1, 2, 3]) && in_array($pedido->idEstado, [3])) {
					?>
					<a href="#" class="badge bg-success pull-right" data-toggle="modal"
					   data-target="#modalReanudar" data-id="<?= $pedido->idPedido ?>"
					   style="color:black; font-weight: bolder;">Levantar Observacion</a>
					<?php
				}
                if (in_array($usuario->usu_perfil, [1, 2, 3]) && in_array($pedido->idEstado, [5])) {
                    ?>
                    <a href="#" class="badge bg-success pull-right" data-toggle="modal"
                       data-target="#modalCompletar" data-id="<?= $pedido->idPedido ?>"
                       style="color:black; font-weight: bolder;">Entregar Pedido</a>
                    <?php
                }
				?>
			</header>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-4">
						<label>Punto de Venta</label><br/>
						<p><?= $pedido->punto_venta ?></p>
					</div>
					<div class="col-md-4">
						<label>Registrado Por</label><br/>
						<p><?= $pedido->responsable ?></p>
					</div>
					<div class="col-md-2">
						<label>#Orden de Pedido</label><br/>
						<p><?= $pedido->codigo ?></p>
					</div>
					<div class="col-md-2">
						<label>Fecha de Pedido</label><br/>
						<p><?= $pedido->fecha_pedido ?></p>
					</div>
					<div class="col-md-4">
						<label>Doctor</label><br/>
						<p><?= $pedido->doctor ?></p>
					</div>
					<div class="col-md-4">
						<label>Paciente</label><br/>
						<p><?= $pedido->paciente; ?></p>
					</div>
					<div class="col-md-2">
						<label>Telefono Paciente</label><br/>
						<p><?= $pedido->telefono; ?></p>
					</div>
					<div class="col-md-2">
						<label>Estado del Pedido</label><br/>
						<p class="btn btn-xs <?php if ($pedido->idEstado == 3) echo 'btn-warning' ?>"><?= $pedido->estado; ?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label for="adicionales">Detalles Adicionales</label>
						<p><?= $pedido->adicionales; ?></p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						<label for="total">Total a Pagar: <?= $pedido->total; ?></label>
					</div>
					<div class="col-md-2">
						<label for="cuenta">A Cuenta: <?= $pedido->pagado; ?></label>
					</div>
					<div class="col-md-2">
						<label for="saldo">Saldo: <?= ($pedido->total - $pedido->pagado); ?></label>
					</div>
                    <?php
                    if($pedido->fecha_envio) {
                        ?>
                        <div class="col-md-4">
                            <label for="saldo">Fecha de envio: <?= $pedido->fecha_envio; ?></label>
                        </div>
                    <?php
                    }
                    ?>
				</div>
			</div>
		</section>
		<section class="panel panel-info">
			<header class="panel-heading">
				Detalle Orden de Pedido
                <span class="pull-right">
                    <button  data-toggle="modal" data-target="#modalVerObservaciones" data-id="<?= $pedido->idPedido ?>">
                        Detalle Observaciones
                    </button>
                </span>
			</header>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<table id="items" class="table table-responsive table-bordered" style="width: 100% !important;">
							<thead>
                            <tr>
							<td>Producto/Formula</td>
							<td>Cantidad</td>
							<td>Precio Unid.</td>
							<td>Total</td>
                            </tr>
							</thead>
							<tbody>
							<?php
							foreach ($detalles as $detalle) {
								$producto = ($detalle->idProducto == 3) ? $detalle->detalle : $detalle->producto;
								echo "<tr>";
								echo "<td>" . $producto . "</td>";
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
		<?php if (in_array($usuario->usu_perfil, [1, 3]) && in_array($pedido->idEstado, [2, 4, 5, 6, 9])) { ?>
			<section class="panel panel-info">
				<header class="panel-heading">
					Tickets del Pedido
				</header>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12">
							<table id="tickets" class="table table-responsive table-bordered"
								   style="width: 100% !important;">
								<thead>
                                <tr>
								<td>Producto</td>
								<td>Ticket</td>
								<td>Enviado</td>
                                </tr>
								</thead>
								<tbody>
								<?php
								foreach ($tickets as $ticket) {
									$productoTicket = ($ticket->producto !='Formula Magistral') ? $ticket->producto : $ticket->detalle;
									$enviado        = ($ticket->enviado) ? 'si' : 'no';
									echo "<tr>";
									echo "<td>" . $productoTicket . "</td>";
									echo "<td>" . $ticket->ticket . "</td>";
									echo "<td>" . $enviado . "</td>";
									echo "</tr>";
								}
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</section>
		<?php } ?>
	</div>
	<!-- seccion de modales -->
	<div class="modal inmodal fade" id="modalObservar" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content animated">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Cerrar</span>
					</button>
					<h5 class="modal-title">
						Observar Pedido
					</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<input id="motivo" name="motivo" type="text" class="form-control"
								   placeholder="Ingrese el detalle de la observacion"/>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="btn-group">
						<input type="button" class="btn btn-danger" data-dismiss="modal" title="Cerrar" value="Cerrar"/>
						<input type="button" class="btn btn-success" onclick="observar_pedido();"
							   title="Observar Pedido" value="Observar Pedido"/>
					</div>
				</div>
			</div>
		</div>
	</div>
    <div class="modal inmodal fade" id="modalVerObservaciones" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-responsive table-bordered">
                                <thead>
                                <tr>
                                    <th>Usuario Observa</th>
                                    <th>Observacion</th>
                                    <th>Fecha Observacion</th>
                                    <th>Usuario Solucion</th>
                                    <th>Solucion</th>
                                    <th>Fecha Solucion</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($observaciones as $observacion) {
                                    echo "<tr>";
                                    echo "<td>$observacion->usuario_registra</td>";
                                    echo "<td>$observacion->observacion</td>";
                                    echo "<td>$observacion->fecha_observado</td>";
                                    echo "<td>$observacion->usuario_atiende</td>";
                                    echo "<td>$observacion->solucion</td>";
                                    echo "<td>$observacion->fecha_atencion</td>";
                                    echo "</tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <input type="button" class="btn btn-danger" data-dismiss="modal" title="cerrar" value="Cerrar"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="modal inmodal fade" id="modalReanudar" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content animated">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Cerrar</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
                            <h3 class="text-center">Observacion <?= $observaciones[-1]->observacion; ?></h3>
                            <br/>
							<h3 class="text-center">Desea levantar la observacion del pedido?</h3>
                            <br/>
                            <input class="form-control" placeholder="Escriba el detalle" id="solucion" name="solucion" />
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="btn-group">
						<input type="button" class="btn btn-danger" data-dismiss="modal" title="No" value="No"/>
                        <input type="button" class="btn btn-success" onclick="levantar_observacion();" title="Si" value="Si"/>
					</div>
				</div>
			</div>
		</div>
	</div>
    <div class="modal inmodal fade" id="modalCompletar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Cerrar</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-center">Confirma que el pedido <?= $pedido->codigo ?> esta pagado en su totalidad?</h3>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <input type="button" class="btn btn-danger" data-dismiss="modal" title="No" value="No"/>
                        <a type="button" class="btn btn-success" href="<?= base_url('Pedidos/completarPedido/'.$pedido->idPedido)?>" title="Si">Si</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="modal inmodal fade" id="modalRechazar" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content animated">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Cerrar</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<h3 class="text-center">Desea rechazar el pedido?</h3>
						</div>
						<div class="col-md-12">
							<label for="motivoAnular">Motivo de Rechazo</label>
							<select class="form-control" id="motivoAnular">
								<option value="">Seleccione</option>
								<?php
								foreach ($motivosA as $motivoA) {
									echo "<option value='$motivoA->id'>$motivoA->motivo</option>";
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="btn-group">
						<input type="button" class="btn btn-danger" data-dismiss="modal" title="No" value="No"/>
						<a class="btn btn-success" onclick="anularPedido()">Si</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal inmodal fade" id="modalAtender" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content animated">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Cerrar</span>
					</button>
					<h5>Atender Pedido</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-12">
								<p>El pedido se atendera parcial o total? &nbsp;&nbsp;<input id="parcialP" type="radio"
																							 name="tipo_atencion"
																							 value="parcial"><label
										for="parcialP">&nbsp;Parcial</label>&nbsp;
									<input id="totalP" type="radio" name="tipo_atencion" value="total" checked><label
										for="totalP">&nbsp;Total</label></p>
							</div>
						</div>
						<div class="col-md-12" id="atencion_parcial" style="display: none;">
							<div class="col-md-12">
								<input type="text" id="detalle_parcial"
									   placeholder="Ingrese el motivo de la atencion parcial" class="form-control"/>
							</div>
							<div class="col-md-12">
								<table id="itemsAtencion" class="table table-responsive table-bordered"
									   style="width: 100% !important;">
									<thead>
                                    <tr>
									<td>Producto/Formula</td>
									<td>Cantidad</td>
									<td>Atender</td>
                                    </tr>
									</thead>
									<tbody>
									<?php
									foreach ($detalles as $detalle) {
										$producto = ($detalle->idProducto == 3) ? $detalle->detalle : $detalle->producto;
										echo "<tr>";
										echo "<td>" . $producto . "</td>";
										echo "<td>" . $detalle->cantidad . "</td>";
										echo "<td><input type='checkbox' onclick='agregar_lista($detalle->idDetalle)'></td>";
										echo "</tr>";
									}
									?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="btn-group">
						<input type="button" class="btn btn-danger" data-dismiss="modal" title="Cerrar" value="Cerrar"/>
						<a href="#" class="btn btn-success" onclick="procesar_pedido()">Procesar Pedido</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- fin de modales -->
</div>
<script>
	var oPendi;
	var lista = [];

	$(document).ready(function () {
		loadTable();

		$('input[name=\'tipo_atencion\']').change(function () {
			let valorAtencion = $('input[name=\'tipo_atencion\']:checked').val();
			if (valorAtencion == 'parcial') {
				$('#atencion_parcial').css('display', 'block');
			} else {
				$('#atencion_parcial').css('display', 'none');
			}
		});
	});

	function agregar_lista ($id) {
		if (!lista.includes($id)) {
			lista.push($id);
		} else {
			let index = lista.indexOf($id);
			if (index > -1) {
				lista.splice(index, 1);
			}
		}
	}

	function procesar_pedido () {
		let form_data = new FormData;
		let url = '';
		let procesar = 0;
		let valorAtencion = $('input[name=\'tipo_atencion\']:checked').val();
		if (valorAtencion == 'total') {
			url = base_url + 'Pedidos/procesarTotal/<?= $pedido->idPedido ?>';
			procesar = 1;
		} else {
			url = base_url + 'Pedidos/procesarParcial/<?= $pedido->idPedido ?>';
			let motivo = $('#detalle_parcial').val();
			if (lista.length > 0 && motivo && $.trim(motivo) != '') {
				form_data.append('lista', lista.toString());
				form_data.append('motivo', motivo);
				procesar = 1;
			} else {
				procesar = 0;
				alert('Debe elegir los items asimismo ingresar el motivo de la atencion parcial');
			}
		}
		if (procesar === 1) {
			form_data.append('codigo', '<?=$pedido->codigo?>');
			form_data.append('punto', '<?=$pedido->idPunto?>');
			$.ajax({
				url:         url,
				type:        'POST',
				cache:       false,
				contentType: false,
				processData: false,
				data:        form_data,
				success:     function (data) {
					if (data == '1') {
						location.reload(true);
					} else {
						alert('Debe seleccionar los items del pedido');
					}
				},
				error:       function () {
					console.log('Error');
				}
			});
		}

		console.log('pedido');
	}

	function observar_pedido () {
		let comentario = $('#motivo').val();
		if (comentario && $.trim(comentario) != '') {
			var form_data = new FormData;
			form_data.append('comentario', comentario);
			$.ajax({
				url:         base_url + 'Pedidos/observarPedido/<?= $pedido->idPedido ?>',
				type:        'POST',
				cache:       false,
				contentType: false,
				processData: false,
				data:        form_data,
				success:     function (data) {
					if (data == '1') {
						location.reload(true);
					} else {
						alert('Debe ingresar el detalle de la observacion');
					}
				},
				error:       function () {
					console.log('Error');
				}
			});
		} else {
			alert('Debe ingresar el detalle de la observacion');
		}
	}

    function levantar_observacion() {
        let solucion = $('#solucion').val();
        if (solucion && $.trim(solucion) != '') {
            var form_data = new FormData;
            form_data.append('solucion', solucion);
            $.ajax({
                url:         base_url + 'Pedidos/levantarObservacion/<?= $pedido->idPedido ?>',
                type:        'POST',
                cache:       false,
                contentType: false,
                processData: false,
                data:        form_data,
                success:     function (data) {
                    if (data == '1') {
                        location.reload(true);
                    } else {
                        alert('Debe ingresar el detalle del levantamiento de la observacion');
                    }
                },
                error:       function () {
                    console.log('Error');
                }
            });
        } else {
            alert('Debe ingresar el detalle del levantamiento de la observacion');
        }
    }

	function anularPedido () {
		let motivo = $('#motivoAnular').val();
		if (motivo) {
			var form_data = new FormData;
			form_data.append('motivo', motivo);
			$.ajax({
				url:         base_url + 'Pedidos/anular/<?= $pedido->idPedido ?>',
				type:        'POST',
				cache:       false,
				contentType: false,
				processData: false,
				data:        form_data,
				success:     function (data) {
					alert('Pedido Rechazado');
					location.reload(true);
				},
				error:       function () {
					console.log('Error');
				}
			});
		} else {
			alert('Debe ingresar el detalle del rechazo');
		}
	}

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
