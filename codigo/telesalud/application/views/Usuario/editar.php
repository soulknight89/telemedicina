<div class="row">
	<div class="col-lg-12">
		<?php echo form_open(null, ["class" => "", "id" => "frm_usu", "name" => "frm_usu"]); ?>
		<section class="panel">
			<header class="panel-heading">
				Editar Usuario
			</header>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-4 col-sm-6 col-xs-12">
						<label for="email">Correo</label>
						<input id="email" name="email" type="email" class="form-control" value="<?= $datos->email; ?>"
							   readonly/>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<label for="nombres">Nombres</label>
						<input id="nombres" name="nombres" type="text" class="form-control"
							   value="<?= $datos->nombres; ?>"/>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<label for="apellidos">Apellidos</label>
						<input id="apellidos" name="apellidos" type="text" class="form-control"
							   value="<?= $datos->apellidos; ?>"/>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<label for="telefono">Telefono</label>
						<input id="telefono" name="telefono" type="text" maxlength="9" class="form-control"
							   value="<?= $datos->telefono; ?>"/>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<label for="perfil">Perfil</label>
						<select id="perfil" name="perfil" class="form-control">
							<option value="">Seleccione</option>
							<?php
							foreach ($perfiles as $perfil) {
								$selected = '';
								if ($datos->idPerfil == $perfil->id) {
									$selected = 'selected';
								}
								echo "<option value='$perfil->id' $selected>$perfil->nombre</option>";
							}
							?>
						</select>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<label for="punto_venta">Punto de Venta</label>
						<select id="punto_venta" name="punto_venta" class="form-control">
							<option value="">Seleccione</option>
							<?php
							foreach ($puntos as $punto) {
								$selected2 = '';
								if ($datos->idPunto == $punto->id) {
									$selected2 = 'selected';
								}
								echo "<option value='$punto->id' $selected2>$punto->nombre</option>";
							}
							?>
						</select>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<label for="supervisor">Activo</label>
						<div class="form-group">
							<input tabindex="1" type="radio" name="activo"
								   value="0" <?php if ($datos->activo == 0) {
								echo 'checked';
							} ?>>
							<label>No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
							<input tabindex="2" type="radio" name="activo"
								   value="1" <?php if ($datos->activo == 1) {
								echo 'checked';
							} ?>>
							<label>Si &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						</div>
					</div>
				</div>
			</div>
			<div class="panel-footer pull-right">
				<a href="<?= base_url('mantenimiento/usuarios') ?>" type="button" class="btn btn-warning">Volver</a>
				<button class="btn btn-success">Guardar</button>
			</div>
		</section>
		<?php echo form_close(); ?>
	</div>
</div>
<script>
	$(document).ready(function () {
		$('#nombres').on('keyup', function () {
			this.value = onlyAlphabet(this.value);
		});

		$('#apellidos').on('keyup', function () {
			this.value = onlyAlphabet(this.value);
		});

		$('#telefono').on('keyup', function () {
			this.value = validarTelefono(this.value);
		});
	});
</script>
