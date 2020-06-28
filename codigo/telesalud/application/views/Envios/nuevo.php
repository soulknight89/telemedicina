<?php
/**
 * @author: Edwin Torres -> Nuevos pedidos
 */
?>
<div class="row">
	<div class="col-lg-12">
		<section class="panel panel-primary">
			<header class="panel-heading">
				Nuevo Envio
			</header>
			<?php echo form_open(null, ["class" => "", "id" => "frm_doc", "name" => "frm_doc"]); ?>
			<div class="panel-body">
				<div class="row">
					<input id="usuario" name="usuario" type="hidden" value="<?= $usuario->usu_id; ?>"/>
					<div class="col-md-4">
						<label for="atiende">Punto de Venta</label>
						<input type="text" id="atiende" name="atiende" class="form-control"
							   value="<?= $usuario->usu_nombres . ' ' . $usuario->usu_apellidos ?>" readonly/>
					</div>
					<div class="col-md-4">
						<label for="punto">Punto de Venta</label>
						<select name="punto" id="punto" class="form-control">
							<option value="">Elija Local</option>
							<?php
							foreach ($puntos as $sede) {
								echo "<option value='$sede->id'>$sede->nombre</option>";
							}
							?>
						</select>
					</div>
					<div class="col-md-4">
						<label for="hoy">Fecha de Envio</label>
						<input type="text" id="hoy" name="hoy" class="form-control" value="<?= date('d-m-Y') ?>"
							   readonly/>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<div class="col-md-offset-9">
					<button class="btn btn-success btn-block">Crear Envio</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</section>
	</div>
</div>
<script>
</script>
