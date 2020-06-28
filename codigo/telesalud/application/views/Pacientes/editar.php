<?php
/**
 * @author: Edwin Torres -> Nuevos pedidos
 */
?>
<div class="row">
	<div class="col-lg-12">
		<section class="panel panel-primary">
			<header class="panel-heading">
				Editar Paciente
			</header>
			<?php echo form_open(null, ["class" => "", "id" => "frm_doc", "name" => "frm_doc"]); ?>
			<div class="panel-body">
				<div class="row">
					<input id="usuario" name="usuario" type="hidden" value="<?= $usuario->usu_id; ?>"/>
					<div class="col-md-3">
						<label for="nombres">Nombres</label>
						<input type="text" name="nombres" id="nombres" maxlength="50" value="<?= $paciente->nombres; ?>"
							   class="form-control"/>
					</div>
					<div class="col-md-3">
						<label for="apellidos">Apellidos</label>
						<input type="text" name="apellidos" id="apellidos" maxlength="50" value="<?= $paciente->apellidos; ?>"
							   class="form-control"/>
					</div>
					<div class="col-md-3">
						<label for="telefono">Telefono</label>
						<input type="text" name="telefono" id="telefono" value="<?= $paciente->telefono; ?>"
							   maxlength="9" class="form-control"/>
					</div>
				</div>
			</div>
			<div class="panel-footer pull-right">
				<input type="button" class="btn btn-info" value="Volver"
					   onclick="location.href = base_url + 'mantenimiento/pacientes'"/>
				<button class="btn btn-success">Actualizar Paciente</button>
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

		$('#telefono').on('keyup', function () {
			this.value = validarTelefono(this.value);
		});
	});
</script>
