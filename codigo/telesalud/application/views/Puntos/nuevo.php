<?php
/**
 * @author: Edwin Torres -> Nuevos pedidos
 */
?>
<div class="row">
	<div class="col-lg-12">
		<section class="panel panel-primary">
			<header class="panel-heading">
				Nuevo Punto de Venta
			</header>
			<?php echo form_open(null, ["class" => "", "id" => "frm_doc", "name" => "frm_doc"]); ?>
			<div class="panel-body">
				<div class="row">
					<input id="usuario" name="usuario" type="hidden" value="<?= $usuario->usu_id; ?>"/>
					<div class="col-md-4">
						<label for="nombre">Nombre</label>
						<input type="text" name="nombre" id="nombre" class="form-control" maxlength="150"/>
					</div>
					<div class="col-md-2">
						<label for="codigo">Codigo</label>
						<input type="text" name="codigo" id="codigo" class="form-control" maxlength="4"/>
					</div>
					<div class="col-md-3">
						<label for="departamento">Departamento</label>
						<select name="departamento" id="departamento" class="form-control"
								onchange="buscar_provincia()">
							<?php
							echo "<option value=''>Departamentos</option>";
							foreach ($departamentos as $departamento) {
								echo "<option value='$departamento->id'>$departamento->nombre</option>";
							}
							?>
						</select>
					</div>
					<div class="col-md-3">
						<label for="provincia">Provincia</label>
						<select name="provincia" id="provincia" class="form-control" onchange="buscar_distrito()">
							<option value=''>Elija Departamento Primero</option>
						</select>
					</div>
					<div class="col-md-3">
						<label for="distrito">Distrito</label>
						<select name="distrito" id="distrito" class="form-control">
							<option value=''>Elija Provincia Primero</option>
						</select>
					</div>
				</div>
			</div>
			<div class="panel-footer pull-right">
				<a href="<?= base_url('mantenimiento/puntos') ?>" class="btn btn-warning">Volver</a>
				<button class="btn btn-success">Agregar Punto</button>
			</div>
			<?php echo form_close(); ?>
		</section>
	</div>
</div>
<script>
	let div_departamento = $('#departamento');
	let div_provincia = $('#provincia');
	let div_distrito = $('#distrito');

	$(document).ready(function () {
		$('#nombre').on('keyup', function () {
			this.value = onlyAlphaNumeric(this.value);
		});

		$('#codigo').on('keyup', function () {
			this.value = onlyAlphaNumericNonSpace(this.value);
		});
	});

	function buscar_provincia () {
		let departamento = div_departamento.val();
		if (departamento) {
			$.ajax({
				url:         base_url + 'Puntos/buscarProvincias/' + departamento,
				type:        'POST',
				cache:       false,
				contentType: 'json',
				processData: false,
				success:     function (data) {
					div_provincia.html('<option value="">Provincias</option>');
					data.map(function (arr) {
						div_provincia.append('<option value="' + arr.id + '">' + arr.nombre + '</option>');
					});
				},
				error:       function () {
					console.log('Error');
				}
			});
		} else {
			div_provincia.html('<option value="">Elija Departamento Primero</option>');
		}
		div_distrito.html('<option value="">Elija Provincia Primero</option>');
	}

	function buscar_distrito () {
		let provincia = div_provincia.val();
		if (provincia) {
			$.ajax({
				url:         base_url + 'Puntos/buscarDistritos/' + provincia,
				type:        'POST',
				cache:       false,
				contentType: 'json',
				processData: false,
				success:     function (data) {
					div_distrito.html('<option value="">Distritos</option>');
					data.map(function (arr) {
						div_distrito.append('<option value="' + arr.id + '">' + arr.nombre + '</option>');
					});
				},
				error:       function () {
					console.log('Error');
				}
			});
		} else {
			div_distrito.html('<option value="">Elija Provincia Primero</option>');
		}
	}
</script>
