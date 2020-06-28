<?php
/**
 * @author: Edwin Torres -> Nuevos pedidos
 */
?>
<div class="row">
	<div class="col-lg-12">
        <div id="oculto" style="width: 100vw !important; height: 100vh !important; background-color: black; display: none; position:relative; z-index: 1000000 !important;">
            <center><h3 style="color: #8ebf4e !important;">Por favor espere</h3></center>
        </div>
		<section class="panel panel-primary">
			<header class="panel-heading">
				Detalle Envio
			</header>
			<div class="panel-body">
				<div class="row">
					<input id="usuario" name="usuario" type="hidden" value="<?= $usuario->usu_id; ?>"/>
					<div class="col-md-4">
						<label for="punto">Punto de Venta</label>
						<input type="text" id="punto" class="form-control" value="<?= $envio->local; ?>" readonly/>
					</div>
					<div class="col-md-4">
						<label for="hoy">Fecha de Envio</label>
						<input type="text" id="hoy" name="hoy" class="form-control" value="<?= $envio->fecha ?>"
							   readonly/>
					</div>
					<div class="col-md-4">
						<label for="hoy">Creado por</label>
						<input type="text" id="hoy" name="hoy" class="form-control" value="<?= $envio->persona; ?>"
							   readonly/>
					</div>
					<div class="col-md-4">
						<label for="hoy">Estado Envio</label>
						<input type="text" class="form-control" value="<?= $envio->estado_envio; ?>" readonly/>
					</div>
				</div>
			</div>
		</section>
		<section class="panel panel-primary">
			<header class="panel-heading">
				Productos Incluidos
				<?php if ($envio->idEstadoEnvio == 1 && $usuario->usu_perfil != 2) { ?>
					<a href="#" class="pull-right badge bg-success" data-target="#modalAgregarItems" data-toggle="modal"
					   data-id="<?= $envio->idEnvio; ?>" style="color: black;">
						<i class="fa fa-plus"></i>&nbsp;Añadir OP / Items
					</a>
				<?php } ?>
			</header>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<table id="itemsEnPedido" class="table table-responsive table-bordered table-condensed"
							   style="width: 100%">
							<thead>
							<tr>
								<th>OP</th>
								<th>Fecha de Pedido</th>
								<th>Ticket</th>
								<th>Producto</th>
								<th>Paciente</th>
								<?php if ($envio->idEstadoEnvio == 1  && $usuario->usu_perfil != 2) { ?>
									<th>Eliminar de Envio</th>
								<?php } ?>
							</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-md-offset-9 pull-right">
						<?php if ($envio->idEstadoEnvio == 1 && $usuario->usu_perfil != 2) { ?>
							<button class="btn btn-flat btn-success" data-toggle='modal'
									data-target='#modalProcesarEnvio' data-id='<?= $envio->idEnvio ?>'>Procesar Envio
							</button>
						<?php } ?>
						<?php if ($envio->idEstadoEnvio == 2 && $usuario->usu_perfil != 2) { ?>
							<button class="btn btn-flat btn-success" data-toggle='modal'
									data-target='#modalAdjuntarDocumento' data-id='<?= $envio->idEnvio ?>'>Adjuntar
								Documento
							</button>
						<?php } ?>
					</div>
				</div>
			</div>
		</section>
	</div>
	<!-- seccion de modales -->
	<div class="modal inmodal fade" id="modalAgregarItems" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content animated">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Cerrar</span>
					</button>
					<h5>Agregar Items a Envio</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-3">
							<label for="pedidos">Elegir OP</label>
							<select id="pedidos">
								<option value="">Elija OP</option>
							</select>
						</div>
					</div>
					<div class="row" id="filaItemSinPedir" style="display: none;">
						<div class="col-md-12">
							<table class="table table-bordered table-responsive">
								<thead>
								<td>OP</td>
								<td>Ticket</td>
								<td>Producto</td>
								<td>
									<span class="badge bg-info">
										<input type="checkbox" id="marcarTodo"/>
											<label>Elegir Todo</label>
									</span>
								</td>
								</thead>
								<tbody id="detallesPedir">
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="btn-group">
						<input type="button" class="btn btn-danger" data-dismiss="modal" onclick="limpiar();"
							   title="Cerrar" value="Cerrar"/>
						<a class="btn btn-success" onclick="agregarItemsAEnvio();">Agregar a Envio</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- modal eliminar -->
	<div class="modal inmodal fade" id="modalEliminarItem" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content animated">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Cerrar</span>
					</button>
					<h5>Eliminar Item de Envio</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<p class="text-center">Desea eliminar el item <b id="itemTicket"></b> del envio?</p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="btn-group">
						<input type="button" class="btn btn-danger" data-dismiss="modal" title="Cerrar" value="Cerrar"/>
						<a class="btn btn-success" onclick="eliminarItemEnvio();">Confirmar</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- modal eliminar -->
	<div class="modal inmodal fade" id="modalProcesarEnvio" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content animated">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Cerrar</span>
					</button>
					<h5>Procesar Envio</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<p class="text-center">Desea procesar el envio <b><?= $envio->fecha; ?>
									- <?= $envio->local; ?></b>?</p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="btn-group">
						<input type="button" class="btn btn-danger" data-dismiss="modal" title="Cerrar" value="Cerrar"/>
						<a class="btn btn-success" onclick="procesarEnvio();">Confirmar</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- modal eliminar -->
	<div class="modal inmodal fade" id="modalAdjuntarDocumento" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content animated">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Cerrar</span>
					</button>
					<h5>Adjuntar Documento</h5>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<p class="text-center">Adjuntar documento para el envio <b><?= $envio->fecha; ?>
									- <?= $envio->local; ?></b>?</p>
						</div>
						<div class="col-md-3">
							<label for="comprobante_x">Dcumento N°</label>
							<input type="text" id="comprobante_x" name="comprobante_x" class="form-control" value="<?= $envio->local; ?>-<?= $envio->fecha; ?>"
								   maxlength="20" placeholder="Numero del Comprobante"/>
						</div>
						<div class="col-md-9">
							<label>Archivo</label>
							<input type="file" id="archivo" name="archivo" accept="image/*" onchange="preview_image(event)">
						</div>
						<div class="col-md-12 text-center">
							<img id="previsualizar_imagen" style="max-width:300px;"/>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="btn-group">
						<input type="button" class="btn btn-danger" data-dismiss="modal" title="Cerrar" value="Cerrar"/>
						<a class="btn btn-success" onclick="adjuntarDocumento();">Confirmar</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- fin de modales -->
</div>
<script>
	// var oPendi;
	var lista = [];
	let idTicket = null;
	let ticketEnvio = null;
	const idPunto = '<?= $envio->idPunto?>';
	const idEnvio = '<?= $envio->idEnvio?>';
	const rowSinPedir = $('#filaItemSinPedir');

	$(document).ready(function () {
		loadTable();
		//leerItemsEnEnvio();

		$('input[name=\'tipo_atencion\']').change(function () {
			let valorAtencion = $('input[name=\'tipo_atencion\']:checked').val();
			if (valorAtencion == 'parcial') {
				$('#atencion_parcial').css('display', 'block');
			} else {
				$('#atencion_parcial').css('display', 'none');
			}
		});

		$('#modalAgregarItems').on('show.bs.modal', function (event) {
			$('#filaItemSinPedir').css('display', 'none');
			var button = $(event.relatedTarget);
			buscarOP(idPunto);
		});

		$('#modalEliminarItem').on('show.bs.modal', function (event) {
			$('#itemTicket').html();
			let button = $(event.relatedTarget);
			idTicket = button.data('id');
			ticketEnvio = button.data('ticket');
			$('#itemTicket').html(ticketEnvio);
		});

		$('#modalAdjuntarDocumento').on('show.bs.modal', function (event) {
			let button = $(event.relatedTarget);
		});

		$('#pedidos').on('change', function () {
			let idPedido = $('#pedidos').val();
			rowSinPedir.css('display', 'none');
			$('#detallesPedir').html('');
			if (idPedido) {
				buscarItemsPedido(idPedido);
				rowSinPedir.css('display', 'block');
			}
		});

		$('#marcarTodo').on('change', function () {
			let inputs = document.getElementsByName('listaItems[]');
			let marcatodo = document.getElementById('marcarTodo');
			if (marcatodo.checked == true) {
				for (let i = 0; i < inputs.length; i++) {
					inputs[i].checked = true;
				}
			} else {
				lista = [];
				for (let i = 0; i < inputs.length; i++) {
					inputs[i].checked = false;
				}
			}
		});
	});

	function buscarOP (punto) {
		$('#pedidos').html('');
		$('#pedidos').append('<option value="">Elija OP</option>');
		let form_data = new FormData;
		form_data.append('idPunto', punto);
		$.ajax({
			url:         base_url + 'Envios/ItemsSinAtender/' + punto,
			type:        'POST',
			cache:       false,
			contentType: 'json',
			processData: false,
			success:     function (data) {
				data.map(function (arr) {
					$('#pedidos').append('<option value="' + arr.idPedido + '">' + arr.orden + '</option>');
				});
			},
			error:       function () {
				console.log('Error');
			}
		});
		limpiar();
	}

	function buscarItemsPedido (pedido) {
		limpiar();
		$('#detallesPedir').html('');
		$.ajax({
			url:         base_url + 'Envios/ItemsSinAtenderPedido/' + pedido,
			type:        'POST',
			cache:       false,
			contentType: 'json',
			processData: false,
			success:     function (data) {
				data.map(function (arr) {
					$('#detallesPedir').append('<tr><td>' + arr.orden + '</td><td>' + arr.codigoItem + '</td><td>' + arr.producto + '</td><td><input type="checkbox" onchange="marcarItem(' + arr.idItem + ');" name="listaItems[]" value="' + arr.idItem + '"></td></tr>');
				});
			},
			error:       function () {
				console.log('Error');
			}
		});
	}

	function marcarItem () {
		let inputs = document.getElementsByName('listaItems[]');
		for (let i = 0; i < inputs.length; i++) {
			let valor = parseInt(inputs[i].value);
			if (inputs[i].checked == true) {
				agregarItem(valor);
			} else {
				removerItem(valor);
			}
		}
	}

	function agregarItem (valor) {
		let existe = lista.indexOf(valor);
		if (!(existe > -1)) {
			lista.push(valor);
		}
	}

	function removerItem (valor) {
		let existe = lista.indexOf(valor);
		if (existe > -1) {
			lista.splice(existe, 1);
		}
	}

	function limpiar () {
		var marcatodo = document.getElementById('marcarTodo');
		marcatodo.checked = false;
		lista = [];
		reloadTable();
	}

	function agregarItemsAEnvio () {
		let aceptar = false;
		marcarItem();
		if (lista.length > 0) {
			aceptar = true;
		}
		if (aceptar == true) {
			let form_data = new FormData;
			form_data.append('lista', lista.toString());
			$.ajax({
				url:         base_url + 'Envios/agregarItemEnvio/' + idEnvio,
				type:        'POST',
				cache:       false,
				contentType: false,
				processData: false,
				data:        form_data,
				success:     function (data) {
                    reloadTable();
                    limpiar();
				},
				error:       function () {
					console.log('Error');
				}
			});
		}
		$('#modalAgregarItems').modal('hide');
		$('#detallesPedir').html('');
		limpiar();
	}

	function eliminarItemEnvio () {
		let form_data = new FormData;
		$.ajax({
			url:         base_url + 'Envios/eliminarItemEnvio/' + idTicket,
			type:        'POST',
			cache:       false,
			contentType: false,
			processData: false,
			data:        form_data,
			success:     function (data) {
				reloadTable();
				$('#modalEliminarItem').modal('hide');
			},
			error:       function () {
				console.log('Error');
			}
		});
	}

	function procesarEnvio() {
		let form_data = new FormData;
		$.ajax({
			url:         base_url + 'Envios/procesarEnvio/' + idEnvio,
			type:        'POST',
			cache:       false,
			contentType: false,
			processData: false,
			data:        form_data,
			success:     function (data) {
				location.href = base_url + '/Envios';
			},
			error:       function () {
				console.log('Error');
			}
		});
	}

	function adjuntarDocumento () {
		let form_data = new FormData;
		let documento = $('#comprobante_x').val();
		let imgVal = $('#archivo').val();
		if (documento && imgVal) {
		    $('#oculto').css('display','block');
			if (validateFormat(imgVal)) {
				imgVal = imgVal.split("\\").pop();
				form_data.append('documento', documento);
				form_data.append('nombreArchivo', imgVal);
				form_data.append('archivo', $('#archivo')[0].files[0]);
				$.ajax({
					url:         base_url + 'Envios/adjuntarDocumento/' + idEnvio,
					type:        'POST',
					cache:       false,
					contentType: false,
					processData: false,
					data:        form_data,
					success:     function (data) {
					    if(data.respuesta == 1) {
                            $('#oculto').css('display','none');
                            location.href = base_url + 'Envios';
                        }
					    else
					        alert(data.mensaje);
					},
					error:       function () {
						console.log('Error');
					}
				});
			} else {
                $('#oculto').css('display','none');
				alert('Los formatos de archivo aceptados son: jpg, jpeg');
			}
		} else {
			alert('Debe ingresar el N de documento y el archivo');
		}
	}

	function validateFormat (filename) {
		//get last 3 chars
		let extension = filename.split('.').pop();
		extension = extension.toLowerCase();
		if (extension == 'jpg' || extension == 'jpeg') {
			return true;
		} else {
			return false;
		}
	}

	function preview_image(event)
	{
		var reader = new FileReader();
		reader.onload = function()
		{
			var output = document.getElementById('previsualizar_imagen');
			output.src = reader.result;
		}
		reader.readAsDataURL(event.target.files[0]);
	}

	function loadTable () {
		oPendi = $('#itemsEnPedido').DataTable({
			responsive:      true,
			'ajax':          {
				'url':  base_url + 'Envios/ItemsEnEnvio/' + idEnvio,
				'type': 'POST'
			},
			'paging':        false,
			'scrollY':       300,
			'processing':    true,
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
	};

	function reloadTable () {
        oPendi.ajax.reload();
	}


</script>
