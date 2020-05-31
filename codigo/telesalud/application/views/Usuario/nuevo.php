<div class="row">
	<div class="col-lg-12">
		<?php echo form_open(null, ["class" => "", "id" => "frm_usu", "name" => "frm_usu"]); ?>
		<section class="panel">
			<header class="panel-heading">
				Agregar Usuario
			</header>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-4 col-sm-6 col-xs-12">
						<label for="email">Correo</label>
						<input id="email" name="email" type="email" class="form-control"/>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<label for="nombres">Nombres</label>
						<input id="nombres" name="nombres" type="text" maxlength="50" class="form-control"/>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<label for="apellidos">Apellidos</label>
						<input id="apellidos" name="apellidos" type="text" maxlength="50" class="form-control"/>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<label for="telefono">Telefono</label>
						<input id="telefono" name="telefono" type="text" maxlength="9" class="form-control"/>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<label for="perfil">Perfil</label>
						<select id="perfil" name="perfil" class="form-control">
							<option value="">Seleccione</option>
							<?php
							foreach ($perfiles as $perfil) {
								echo "<option value='$perfil->id'>$perfil->nombre</option>";
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
								echo "<option value='$punto->id'>$punto->nombre</option>";
							}
							?>
						</select>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12" style="display: none;">
						<label for="supervisor">Supervisor</label>
						<div class="form-group">
							<input tabindex="1" type="radio" name="supervisor" value="0" checked>
							<label>No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
							<input tabindex="2" type="radio" name="supervisor" value="1">
							<label>Si &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						</div>
					</div>
				</div>
			</div>
			<div class="panel-footer pull-right">
				<input type="button" class="btn btn-warning" value="Volver"
					   onclick="location.href = base_url+'mantenimiento/usuarios';"/>
				<button class="btn btn-success">Crear Usuario</button>
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
