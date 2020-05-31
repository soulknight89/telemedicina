<?php
/**
 * @author: Edwin Torres -> Nuevos pedidos
 */
?>
<div class="row">
	<div class="col-lg-12">
		<section class="panel panel-primary">
			<header class="panel-heading">
				Editar Punto de Venta
			</header>
			<?php echo form_open(null, ["class" => "", "id" => "frm_doc", "name" => "frm_doc"]); ?>
			<div class="panel-body">
				<div class="row">
					<input id="usuario" name="usuario" type="hidden" value="<?= $usuario->usu_id; ?>"/>
					<input id="idPunto" name="idPunto" type="hidden" value="<?= $punto->idPunto; ?>"/>
					<div class="col-md-4">
						<label for="nombre">Nombre</label>
						<input type="text" name="nombre" id="nombre" class="form-control" maxlength="150"
							   value="<?= $punto->nombre; ?>"/>
					</div>
					<div class="col-md-2">
						<label for="codigo">Codigo</label>
						<input type="text" class="form-control" maxlength="4" value="<?= $punto->codigo; ?>" readonly/>
					</div>
					<div class="col-md-3">
						<label for="departamento">Departamento</label>
						<select name="departamento" id="departamento" class="form-control"
								onchange="buscar_provincia()">
							<?php
							echo "<option value=''>Departamentos</option>";
							foreach ($departamentos as $departamento) {
								$selected = ($departamento->id == $punto->id_departamento) ? 'selected' : '';
								echo "<option value='$departamento->id' $selected>$departamento->nombre</option>";
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
					<div class="col-md-4 col-sm-6 col-xs-12" style="display: none;">
						<label for="activo">Activo</label>
						<div class="form-group">
							<input tabindex="1" type="radio" name="activo" value="0" <?php if($punto->activo == 0) echo 'checked';?>>
							<label>No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
							<input tabindex="2" type="radio" name="activo" value="1" <?php if($punto->activo == 1) echo 'checked';?>>
							<label>Si &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						</div>
					</div>
				</div>
			</div>
			<div class="panel-footer pull-right">
				<a href="<?= base_url('mantenimiento/puntos') ?>" class="btn btn-warning">Volver</a>
				<button class="btn btn-success">Actualizar Punto</button>
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

		buscar_provincia('<?= $punto->id_departamento;?>');
		setTimeout(setear_provincia, 500);
		setTimeout(setear_distrito, 1200);

	});

	function setear_provincia () {
		div_provincia.val('<?= $punto->id_provincia;?>');
		setTimeout(buscar_distrito('<?= $punto->id_provincia;?>'), 500);
	}

	function setear_distrito () {
		div_distrito.val('<?= $punto->id_distrito;?>');
	}

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
