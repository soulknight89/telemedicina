<?php
/**
 * @author: Edwin Torres -> Nuevos pedidos
 */
?>
<div class="row">
	<div class="col-lg-12">
        <section class="panel panel-primary">
            <header class="panel-heading">
                Finalizar la Orden de Pedido
            </header>
            <div class="panel-body">
                <div class="row">
                    <input id="timestamp" name="timestamp" type="hidden" value="<?= $timestamp; ?>"/>
                    <input id="usuario" name="usuario" type="hidden" value="<?= $usuario->usu_id; ?>"/>
                    <div class="col-md-2">
                        <label>#Orden de Pedido</label><br/>
                        <input id="orden" name="orden" type="text" value="" placeholder="Orden de Pedido"
                               class="form-control"/>
                    </div>
                    <div class="col-md-5" id="div_paciente">
                        <label>Paciente</label><br/>
                        <select id="paciente" name="paciente" style="width: 100%;height: 100%"
                                class="form-control"></select>
                    </div>
                    <div class="col-md-5" id="div_doctor">
                        <label>Doctor</label><br/>
                        <select id="doctor" name="doctor" style="width: 100%" class="form-control"></select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="adicionales">Detalles Adicionales</label>
                        <textarea id="adicionales" class="form-control" style="width: 100%; resize: none;"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="telefono">Telefono</label>
                        <input type="text" id="telefono" name="telefono" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="fecha">Fecha Orden de Pedido</label>
                        <input type="text" id="fecha" name="fecha" class="form-control" value="<?= date('d-m-Y') ?>"/>
                    </div>
                    <div class="col-md-2">
                        <label for="total">Total a Pagar</label>
                        <input type="text" class="form-control" id="total" value="0" readonly/>
                    </div>
                    <div class="col-md-2">
                        <label for="cuenta">A Cuenta</label>
                        <input type="number" class="form-control" value="0" id="cuenta" onkeyup="calcularSaldo()"
                               onchange="calcularSaldo()"/>
                    </div>
                    <div class="col-md-2">
                        <label for="saldo">Saldo</label>
                        <input type="text" class="form-control" value="0" id="saldo" readonly/>
                    </div>
                </div>
            </div>
        </section>
		<section class="panel panel-success">
			<header class="panel-heading">
				Añadir Producto / Formula a la Orden de Pedido
			</header>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-2">
						<label for="tipo">Tipo Preparado</label>
						<select name="tipo" id="tipo" class="form-control" onchange="elegirTipo()">
							<option value="">Seleccione</option>
							<?php
							foreach ($categorias as $categoria) {
								echo "<option value='$categoria->id'>$categoria->nombre</option>";
							}
							?>
						</select>
					</div>
					<div class="col-md-4" id="div_mensaje">
						<h3>Elija el tipo de preparado</h3>
					</div>
					<div class="col-md-4" id="div_producto">
					</div>
					<div class="col-md-4" id="div_detalle">
					</div>
					<div class="col-md-2">
						<label for="cantidad">Cantidad</label>
						<input type="number" name="cantidad" id="cantidad" value="1" class="form-control"
							   onchange="calcularItemTotal()" onkeyup="calcularItemTotal()"/>
					</div>
					<div class="col-md-2">
						<label for="precio">Precio Unitario</label>
						<input type="number" name="precio" id="precio" class="form-control"
							   onkeyup="calcularItemTotal()" onchange="calcularItemTotal()"/>
					</div>
					<div class="col-md-2">
						<label for="precioTotal">Precio Total</label>
						<input type="number" name="precioTotal" id="precioTotal" class="form-control"
							   onchange="calcularItemUnitario()" onkeyup="calcularItemUnitario()"/>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<div class="col-md-offset-9">
					<button class="btn btn-info btn-block" onclick="agregarItemPedido()">Añadir a Orden</button>
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
							<td>Eliminar</td>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</section>
		<section class="panel panel-primary">
			<div class="panel-footer">
				<div class="col-md-offset-9">
					<button class="btn btn-success btn-block" onclick="finalizarOrden();">Finalizar Orden de Pedido
					</button>
				</div>
			</div>
		</section>
	</div>
</div>
<script>
	const div_prod = $('#div_producto');
	const div_form = $('#div_detalle');
	const div_mensaje = $('#div_mensaje');
	const campo_paciente = $('#paciente');
	const campo_doctor = $('#doctor');
	const tiempo = $('#timestamp').val();
	const usuario = $('#usuario').val();
	let oPendi = '';
	let puntoVenta = <?= ($usuario->usu_punto) ? $usuario->usu_punto : '0'; ?>;

	$(document).ready(function () {
		div_prod.css('display', 'none');
		div_form.css('display', 'none');
		loadDetalle();
		campo_doctor.select2({
			language:    {
				noResults:       function () { return 'No se encontraron resultados'; },
				InputTooShort:   function (input, min) {
					var n = min - input.length;
					return 'Por favor adicione ' + n + ' caracter' + (n == 1 ? '' : 'es');
				},
				InputTooLong:    function (input, max) {
					var n = input.length - max;
					return 'Por favor elimine ' + n + ' caracter' + (n == 1 ? '' : 'es');
				},
				SelectionTooBig: function (limit) { return 'Solo puede seleccionar ' + limit + ' elemento' + (limit == 1 ? '' : 's'); },
				LoadMore:        function (pageNumber) { return 'Cargando más resultados...'; },
				searching:       function () { return 'Buscando...'; }
			},
			placeholder: 'Buscar Doctor',
			ajax:        {
				url:            base_url + 'Pedidos/listarDoctores/' + puntoVenta,
				type:           'POST',
				delay:          250,
				dataType:       'json',
				data:           function (params) {
					return {
						doctor: params.term // search term
					};
				},
				processResults: function (response) {
					return {
						results: response
					};
				}
			}
		});
		campo_paciente.val('');
		campo_paciente.select2({
			language:    {
				noResults:       function () { return 'No se encontraron resultados'; },
				InputTooShort:   function (input, min) {
					var n = min - input.length;
					return 'Por favor adicione ' + n + ' caracter' + (n == 1 ? '' : 'es');
				},
				InputTooLong:    function (input, max) {
					var n = input.length - max;
					return 'Por favor elimine ' + n + ' caracter' + (n == 1 ? '' : 'es');
				},
				SelectionTooBig: function (limit) { return 'Solo puede seleccionar ' + limit + ' elemento' + (limit == 1 ? '' : 's'); },
				LoadMore:        function (pageNumber) { return 'Cargando más resultados...'; },
				searching:       function () { return 'Buscando...'; }
			},
			placeholder: 'Buscar Paciente',
			ajax:        {
				url:            base_url + 'Pacientes/listarPacientes/',
				type:           'POST',
				delay:          250,
				dataType:       'json',
				data:           function (params) {
					return {
						paciente: params.term
					};
				},
				processResults: function (response) {
					return {
						results: response
					};
				}
			}
		});

		$('#fecha').datetimepicker({
			locale: 'es',
			format: 'DD-MM-YYYY',
            maxDate: new Date
		});

		$('#fecha').keyup(function(){
		    $('#fecha').val('<?= date('d-m-Y') ?>');
        })
	});

	function elegirTipo () {
		let tipo = $('#tipo').val();
		if (tipo !== '') {
			div_mensaje.css('display', 'none');
			if (tipo !== '2') {
				div_prod.css('display', 'block');
				jQuery.post(base_url + 'Pedidos/listarProductos/' + tipo, function (data) {
					div_prod.html('');
					let html = '<label>Producto</label>';
					html += '<select name="producto" id="producto" class="form-control">';
					html += '<option value="">Seleccione</option>';
					data.map(function (producto) {
						html += '<option value="' + producto.id + '">' + producto.nombre + '</option>';
					});
					html += '</select>';
					div_prod.html(html);
					div_form.html('');
					html = '<input type="hidden" name="detalle" id="detalle" value=""/>';
					div_form.html(html);
					div_form.css('display', 'none');
				});
			} else {
				div_prod.css('display', 'none');
				div_prod.html('<input type="hidden" name="producto" id="producto" value="3" />');
				div_form.html('');
				let html = '<label>Formula Magistral</label>';
				html += '<input type="text" name="detalle" id="detalle" value="" placeholder="Ingrese la formula" class="form-control"/>';
				div_form.html(html);
				div_form.css('display', 'block');
			}
		} else {
			div_prod.css('display', 'none');
			div_form.css('display', 'none');
			div_mensaje.css('display', 'block');
		}
	}

	function agregarItemPedido () {
		let producto = $('#producto').val();
		let detalle = $('#detalle').val();
		let cantidad = $('#cantidad').val();
		let precio = $('#precio').val();
		let form_data = new FormData;
		const url = base_url + 'Pedidos/nuevoProductoTemporal';
		if (producto && cantidad && precio) {
			form_data.append('producto', producto);
			form_data.append('tiempo', tiempo);
			form_data.append('usuario', usuario);
			form_data.append('cantidad', cantidad);
			form_data.append('precio', precio);
			if (producto === '3') {
				if (detalle) {
					form_data.append('detalle', detalle);
					$.ajax({
						url:         url,
						type:        'POST',
						cache:       false,
						contentType: false,
						processData: false,
						data:        form_data,
						success:     function (data) {
							recargarDetalle();
							calcularTotal();
						},
						error:       function () {
							console.log('Error');
						}
					});
				} else {
					alert('Debe ingresar la formula');
				}
			} else {
				form_data.append('detalle', '');
				$.ajax({
					url:         url,
					type:        'POST',
					cache:       false,
					contentType: false,
					processData: false,
					data:        form_data,
					success:     function (data) {
						recargarDetalle();
						calcularTotal();
					},
					error:       function () {
						console.log('Error');
					}
				});
			}
		} else {
			alert('Debe ingresar el producto, precio unitario y cantidad');
		}
	}

	function loadDetalle () {
		oPendi = $('#items').DataTable({
			responsive:      true,
			'ajax':          {
				'url':  base_url + 'Pedidos/buscarTablaTemporal',
				'type': 'POST',
				'data': function (d) {
					d.tiempo = tiempo;
					d.usuario = usuario;
				}
			},
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
		$('#usuarios_filter').hide();
	}

	function recargarDetalle () {
		$('#items').DataTable().ajax.reload();
	}

	function calcularItemTotal () {
		let precio = $('#precio').val();
		let cantidad = $('#cantidad').val();
		if (precio && precio > 0) {
			let total = precio * cantidad;
			$('#precioTotal').val(total);
		}
	}

	function calcularItemUnitario () {
		let precio = $('#precioTotal').val();
		let cantidad = $('#cantidad').val();
		if (precio && precio > 0) {
			let total = precio / cantidad;
			$('#precio').val(total);
		}
	}

	function calcularTotal () {
		let form_data = new FormData;
		form_data.append('tiempo', tiempo);
		form_data.append('usuario', usuario);
		$.ajax({
			url:         base_url + 'Pedidos/calcularTotalTemp',
			type:        'POST',
			cache:       false,
			contentType: false,
			processData: false,
			data:        form_data,
			success:     function (data) {
				$('#total').val(data);
				calcularSaldo();
			},
			error:       function () {
				console.log('Error');
			}
		});
	}

	function calcularSaldo () {
		let total = $('#total').val();
		let cuenta = $('#cuenta').val();
		let saldo = total - cuenta;
		$('#saldo').val(saldo);
	}

	function borrarRegistroTemp (idItem) {
		jQuery.post(base_url + 'Pedidos/borrarItemTemp/' + idItem, function (data) {
			console.log(data);
		});
		recargarDetalle();
	}

	function finalizarOrden () {
		let orden = $('#orden').val();
		let paciente = $('#paciente').val();
		let doctor = $('#doctor').val();
		let fecha = $('#fecha').val();
		let cuenta = $('#cuenta').val();
		if(!cuenta){
		    cuenta = 0;
        }
		let total = $('#total').val();
		let telefono = $('#telefono').val();
		let adicionales = $('#adicionales').val();
		let fechaObj = moment(fecha, 'DD-MM-YYYY');
		if (orden && paciente && doctor && fechaObj.isValid()) {
			let form_data = new FormData;
			form_data.append('tiempo', tiempo);
			form_data.append('usuario', usuario);
			form_data.append('orden', orden);
			form_data.append('paciente', paciente);
			form_data.append('doctor', doctor);
			form_data.append('fecha', fecha);
			form_data.append('cuenta', cuenta);
			form_data.append('total', total);
			form_data.append('punto', puntoVenta);
			form_data.append('adicionales', adicionales);
			form_data.append('telefono', telefono);
			jQuery.post(base_url + 'Pedidos/contarItemsTemp/' + tiempo + '/' + usuario, function (registros) {
				if (registros > 0) {
					$.ajax({
						url:         base_url + 'Pedidos/agregarOrdenPedido',
						type:        'POST',
						cache:       false,
						contentType: false,
						processData: false,
						data:        form_data,
						success:     function (data) {
							console.log(data);
							if (data === '1') {
								alert('Orden de Pedido agregada: ' + orden);
								location.href = base_url + 'Pedidos';
							} else {
								alert(data);
							}
						},
						error:       function () {
							console.log('Error');
						}
					});
				} else {
					alert('Debe añadir productos o formulas a su orden de pedido para poder registarla');
				}
			});
		} else {
			alert('Debe tener la de Orden de Pedido, el doctor y paciente');
		}
	}
</script>
