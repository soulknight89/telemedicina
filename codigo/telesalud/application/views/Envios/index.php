<?php
/**
 *
 */
?>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Modulo Envios
			</header>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12 adv-table editable-table">
						<?php if ($usuario->usu_perfil != 2) { ?>
							<div class="row">
								<div class="col-md-3">
									<a class="btn btn-primary" href="<?= base_url('Envios/nuevo'); ?>">
										Generar Nuevo Envio <i class="fa fa-plus"></i>
									</a>
									<br/>
									<br/>
								</div>
							</div>
						<?php } ?>
						<div class="row">
							<div class="col-md-3">
								<input type="text" placeholder="Punto de Venta" id="punto" class="form-control">
							</div>
							<div class="col-md-3">
								<input type="text" placeholder="Fecha de Envio" id="fecha" class="form-control">
							</div>
                            <div class="col-md-3">
                                <select id="estado" class="form-control">
                                    <option value="">Filtrar estado</option>
                                    <option value="Creado">Creado</option>
                                    <option value="En Proceso">En Proceso</option>
                                    <option value="Enviado">Enviado</option>
                                </select>
                            </div>
							<div class="col-md-3" id="exportar">
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<br/>
								<table id="envios" class="table table-striped table-hover table-bordered">
									<thead>
									<tr>
										<th>Punto de Venta</th>
										<th>Fecha de Creacion</th>
										<th>Fecha Envio</th>
										<th>Estado</th>
										<th>Opciones</th>
									</tr>
									</thead>
									<tbody>
									<?php
									foreach ($envios as $envio) {
										echo "<tr>";
										echo "<td>" . $envio->local . "</td>";
										echo "<td>" . $envio->fecha . "</td>";
										echo "<td>" . $envio->fecha_procesado . "</td>";
										echo "<td>" . $envio->estado_envio . "</td>";
										echo "<td>" . $envio->boton . "</td>";
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
        $.fn.dataTable.moment('DD-MM-YYYY');
        $.fn.dataTable.moment('YYYY-MM-DD');
        $.fn.dataTable.moment('DD-MM-YYYY HH:mm:ss');
		loadTable();

		$('#punto').keyup(function () {
			oPendi
				.columns(0)
				.search('"' + $(this).val() + '"')
				.draw();
		});

		$('#fecha').keyup(function () {
			var buscar = '"' + $(this).val() + '"';
			oPendi
				.columns(1)
				.search(buscar)
				.draw();
		});

        $('#estado').change(function () {
            var buscar = '"' + $(this).val() + '"';
            oPendi
                .columns(3)
                .search(buscar)
                .draw();
        });
	});

	function loadTable () {
		oPendi = $('#envios').DataTable({
			responsive:      true,
			'order':         [[1, 'asc']],
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
		$('#envios_filter').hide();
		var buttons = new $.fn.dataTable.Buttons(oPendi, {
			buttons: [
				//'excelHtml5',
				{
					extend:        'excelHtml5',
					title:         'Envios Registrados',
					exportOptions: {
						columns: [0, 1, 2, 3]
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
