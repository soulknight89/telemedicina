<?php
/**
 * @author: Edwin Torres -> Nuevos pedidos;
 * @var mixed $doctor , $usuario
 *
 */
?>
<div class="row">
	<div class="col-lg-12">
		<section class="panel panel-primary">
			<header class="panel-heading">
				Actualizar Doctor
			</header>
			<?php echo form_open(null, ["class" => "", "id" => "frm_doc_upd", "name" => "frm_doc_upd"]); ?>
			<div class="panel-body">
				<div class="row">
					<input id="usuario" name="usuario" type="hidden" value="<?= $usuario->usu_id; ?>"/>
					<div class="col-md-3">
						<label for="punto">Punto de Venta</label>
						<select name="punto" id="punto" class="form-control">
							<option value="">Seleccione</option>
							<?php
							foreach ($puntos as $punto) {
								$activo = '';
								if ($doctor->idPunto == $punto->id) {
									$activo = 'selected';
								}
								echo "<option value='$punto->id' $activo>$punto->nombre</option>";
							}
							?>
						</select>
					</div>
					<div class="col-md-3">
						<label for="nombres">Nombres</label>
						<input type="text" name="nombres" id="nombres" maxlength="50" value="<?= $doctor->nombres; ?>"
							   class="form-control"/>
					</div>
					<div class="col-md-3">
						<label for="apellidos">Apellidos</label>
						<input type="text" name="apellidos" id="apellidos" maxlength="50"
							   value="<?= $doctor->apellidos; ?>"
							   class="form-control"/>
					</div>
					<div class="col-md-3">
						<label for="colegiatura">Colegiatura</label>
						<input type="text" name="colegiatura" id="colegiatura" maxlength="9"
							   value="<?= $doctor->documento; ?>"
							   class="form-control"/>
					</div>
				</div>
			</div>
			<div class="panel-footer pull-right">
				<input type="button" class="btn btn-warning" value="Volver"
					   onclick="location.href = base_url+'mantenimiento/doctores';"/>
				<button class="btn btn-success">Actualizar Doctor</button>
			</div>
			<?php echo form_close(); ?>
		</section>
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

		$('#colegiatura').on('keyup', function () {
			this.value = onlyAlphaNumericNonSpace(this.value);
		});
	});
</script>
