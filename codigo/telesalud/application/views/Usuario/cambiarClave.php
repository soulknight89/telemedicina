<h4 class="font-weight-bold py-3 mb-4">
	<span class="text-muted font-weight-light">Principal /</span> Cambiar clave
</h4>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<?php echo form_open(null, ["class" => "", "id" => "frm_usu", "name" => "frm_usu"]); ?>
			<div class="card-header px-5">
				<h5 class="card-title">Cambiar Clave</h5>
				<div class="col-12">
					<?php if ($this->session->flashdata("success") != "") { ?>
						<div class="alert alert-success alert-dismissable">
							<button aria-hidden="true" data-dismiss="alert" class="close" type="button">
								×
							</button>
							<a class="alert-link" href="#">
								<?= $this->session->flashdata("success"); ?>
							</a>
						</div>
					<?php } ?>
					<div id="div_warning" class="alert alert-warning alert-dismissable" style="display:none;">
						<button id="b_warning" aria-hidden="true" class="close" type="button">
							×
						</button>
						<a id="a_warning" class="alert-link" href="#">
						</a>
					</div>
					<?php if ($this->session->flashdata("warning") != "") { ?>
						<div class="alert alert-warning alert-dismissable">
							<button aria-hidden="true" data-dismiss="alert" class="close" type="button">
								×
							</button>
							<a class="alert-link" href="#">
								<?= $this->session->flashdata("warning"); ?>
							</a>
						</div>
					<?php } ?>
					<div id="div_danger" class="alert alert-warning alert-dismissable" style="display:none;">
						<button id="b_danger" aria-hidden="true" class="close" type="button">
							×
						</button>
						<a id="a_danger" class="alert-link" href="#">
						</a>
					</div>
					<?php if ($this->session->flashdata("danger") != "") { ?>
						<div class="alert alert-danger alert-dismissable">
							<button aria-hidden="true" data-dismiss="alert" class="close" type="button">
								×
							</button>
							<a class="alert-link" href="#">
								<?= $this->session->flashdata("danger"); ?>
							</a>
						</div>
					<?php } ?>
					<div id="div_info" class="alert alert-warning alert-dismissable" style="display:none;">
						<button id="b_info" aria-hidden="true" class="close" type="button">
							×
						</button>
						<a id="a_info" class="alert-link" href="#">
						</a>
					</div>
					<?php if ($this->session->flashdata("info") != "") { ?>
						<div class="alert alert-info alert-dismissable">
							<button aria-hidden="true" data-dismiss="alert" class="close" type="button">
								×
							</button>
							<a class="alert-link" href="#">
								<?= $this->session->flashdata("info"); ?>
							</a>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="card-body px-5">
				<div class="row">
					<input id="usuario" name="usuario" type="hidden" value="<?= $usuario->usu_id; ?>" readonly/>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<label for="email">Correo</label>
						<input id="email" name="email" type="email" class="form-control"
							   value="<?= $usuario->usu_email; ?>" readonly/>
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
			<div class="card-footer px-5 py-2">
				<a href="<?= base_url('/') ?>" type="button" class="btn btn-warning pull-right">Volver</a>
				<button class="btn btn-success pull-right">Actualizar Clave</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
	});
</script>
