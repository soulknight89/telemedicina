<?php
/**
 * @author: Edwin Torres -> Nuevos pedidos
 */
?>
<div class="row">
	<div class="col-lg-12">
		<section class="panel panel-primary">
			<header class="panel-heading">
				Nuevo Producto
			</header>
			<?php echo form_open(null, ["class" => "", "id" => "frm_doc", "name" => "frm_doc"]); ?>
			<div class="panel-body">
				<div class="row">
					<input id="usuario" name="usuario" type="hidden" value="<?= $usuario->usu_id; ?>"/>
					<div class="col-md-3">
						<label for="nombre">Nombre</label>
						<input type="text" name="nombre" id="nombre" value="<?= set_value('nombre'); ?>"
							   class="form-control"/>
					</div>
					<div class="col-md-6">
						<label for="descripcion">Descripcion</label>
						<input type="text" name="descripcion" id="descripcion" value="<?= set_value('descripcion'); ?>"
							   class="form-control"/>
					</div>
					<div class="col-md-3">
						<label for="precio">Precio</label>
						<input type="text" name="precio" id="precio" maxlength="6" value="<?= set_value('precio'); ?>"
							   class="form-control"/>
					</div>
				</div>
			</div>
			<div class="panel-footer pull-right">
				<input type="button" class="btn btn-warning" value="Volver"
					   onclick="location.href = base_url+'mantenimiento/productos';"/>
				<button class="btn btn-success">Agregar Producto</button>
			</div>
			<?php echo form_close(); ?>
		</section>
	</div>
</div>
<script>
	// $(document).ready(function () {
	// 	$('#precio').priceFormat({
	// 		prefix: '',
	// 		thousandsSeparator: '',
	// 		clearOnEmpty: true
	// 	});
	// });
	$(document).ready(function () {
		$('#precio').on('keyup', function () {
			this.value = validarDinero(this.value);
		});
	});
</script>
