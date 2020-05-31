<?php
/**
 * @author: Edwin Torres -> Nuevos pedidos
 */
?>
<div class="row">
	<div class="col-lg-12">
		<section class="panel panel-primary">
			<header class="panel-heading">
				Agregar Doctor
			</header>
			<?php echo form_open(null, ["class" => "", "id" => "frm_doc", "name" => "frm_doc"]); ?>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<h2 class="title">Registrar datos</h2>
					</div>
					<input id="usuario" name="usuario" type="hidden" value="<?= $usuario->usu_id; ?>"/>
					<div class="col-md-3">
						<label for="nombres">Primer Nombre</label>
						<input type="text" name="nombres" id="nombres" maxlength="50" class="form-control"/>
					</div>
					<div class="col-md-3">
						<label for="nombres">Segundo Nombre</label>
						<input type="text" name="nombres" id="nombres" maxlength="50" class="form-control"/>
					</div>
					<div class="col-md-3">
						<label for="apellidos">Apellido Paterno</label>
						<input type="text" name="apellidos" id="apellidos" maxlength="50" class="form-control"/>
					</div>
					<div class="col-md-3">
						<label for="apellidos">Apellido Materno</label>
						<input type="text" name="apellidos" id="apellidos" maxlength="50" class="form-control"/>
					</div>
					<div class="col-md-6">
						<label for="apellidos">Correo electronico</label>
						<input type="text" name="apellidos" id="apellidos" maxlength="50" class="form-control"/>
					</div>
					<div class="col-md-3">
						<label for="colegiatura">Tipo de documento</label>
						<input type="text" name="colegiatura" id="colegiatura" maxlength="9" class="form-control"/>
					</div>
					<div class="col-md-3">
						<label for="colegiatura">Nro. de Documento</label>
						<input type="text" name="colegiatura" id="colegiatura" maxlength="9" class="form-control"/>
					</div>
					<div class="col-md-3">
						<label for="colegiatura">Colegiatura</label>
						<input type="text" name="colegiatura" id="colegiatura" maxlength="9" class="form-control"/>
					</div>
					<div class="col-md-3">
						<label for="colegiatura">Hora Atencion Inicio</label>
						<input type="text" name="colegiatura" id="colegiatura" maxlength="9" class="form-control"/>
					</div>
					<div class="col-md-3">
						<label for="colegiatura">Hora Atencion Fin</label>
						<input type="text" name="colegiatura" id="colegiatura" maxlength="9" class="form-control"/>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<h2 class="title">Especialidades</h2>
					</div>
					<div class="col-md-4 pull-right" style="margin-top: 25px;">
						<button class="btn btn-small btn-info">Agregar especialidad</button>
					</div>
					<div class="col-md-12">
						<table class="table table-bordered table-hover">
							<thead>
								<th>Especialidad</th>
								<th>Codigo</th>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="panel-footer pull-right">
					<input type="button" class="btn btn-warning" value="Volver"
						   onclick="location.href = base_url+'mantenimiento/doctores';"/>
					<button class="btn btn-success">Agregar Doctor</button>
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
