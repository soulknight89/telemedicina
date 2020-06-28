<div class="row">
	<div class="col-lg-12">
		<?php echo form_open(null, ["class" => "", "id" => "frm_usu", "name" => "frm_usu"]); ?>
		<section class="panel">
			<header class="panel-heading">
				Cambiar Clave
			</header>
			<div class="panel-body">
				<div class="row">
					<input id="usuario" name="usuario" type="hidden" value="<?= $usuario->usu_id; ?>" readonly/>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<label for="email">Correo</label>
						<input id="email" name="email" type="email" class="form-control"
							   value="<?= $usuario->usu_email; ?>"
							   readonly/>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<label for="email">Clave Nueva</label>
						<input id="clave" maxlength="30" name="clave" type="password" class="form-control"/>
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<label for="email">Repetir Clave Nueva</label>
						<input id="clave2" maxlength="30" name="clave2" type="password" class="form-control"/>
					</div>
				</div>
			</div>
			<div class="panel-footer pull-right">
				<a href="<?= base_url('/') ?>" type="button" class="btn btn-warning">Volver</a>
				<button class="btn btn-success">Actualizar Clave</button>
			</div>
		</section>
		<?php echo form_close(); ?>
	</div>
</div>
<script>
	$(document).ready(function () {
	});
</script>
