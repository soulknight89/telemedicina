<div class="card">
	<div class="row no-gutters row-bordered">
		<!-- Login -->
		<div class="col-md-6">
			<h5 class="text-center text-muted font-weight-normal py-4 px-4 px-sm-5 m-0">Iniciar Sesión</h5>
			<hr class="border-light m-0">
			<div class="px-4 px-sm-5 pt-4 pb-5 pb-sm-5">
				<!-- Login form -->
				<form action="" method="post" class="form-signin">
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
					<div class="form-group">
						<label class="form-label">Correo Electronico</label>
						<input type="text" id="usuario" name="usuario" class="form-control" autocomplete="off" autofocus>
					</div>
					<div class="form-group">
						<label class="form-label d-flex justify-content-between align-items-end">
							<div>Clave</div>
							<a href="javascript:void(0)" class="d-block small">Olvidaste tu contraseña?</a>
						</label>
						<input type="password" id="clave" name="clave" class="form-control">
					</div>
					<div class="d-flex justify-content-between align-items-center m-0">
						<!--label class="custom-control custom-checkbox m-0">
							<input type="checkbox" class="custom-control-input">
							<span class="custom-control-label">Remember me</span>
						</label-->
						<button type="submit" class="btn btn-primary">Iniciar Sesión</button>
					</div>
				</form>
				<!-- / Login form -->
			</div>
		</div>
		<!-- / Login -->
		<!-- Register -->
		<div class="col-md-6">
			<h5 class="text-center text-muted font-weight-normal py-4 px-4 px-sm-5 m-0">Registrate</h5>
			<hr class="border-light m-0">
			<div class="px-4 px-sm-5 pt-4 pb-5 pb-sm-5">
				<!-- Register form -->
				<form>
					<div class="form-group">
						<label class="form-label">Nombres</label>
						<input type="text" class="form-control">
					</div>
					<div class="form-group">
						<label class="form-label">Apellido paterno</label>
						<input type="text" class="form-control">
					</div>
					<div class="form-group">
						<label class="form-label">Apellido materno</label>
						<input type="text" class="form-control">
					</div>
					<div class="form-group">
						<label class="form-label">Correo electronico</label>
						<input type="email" class="form-control">
					</div>
					<div class="form-group">
						<label class="form-label">Clave</label>
						<input type="password" id="newPwd" class="form-control">
					</div>
					<button type="button" class="btn btn-primary btn-block mt-4">Registrarse</button>
					<div class="text-light small mt-4 text-justify">
						Al hacer clic en "Registrarse", usted acepta
						<a href="javascript:void(0)">los terminos del servicio y politica de privacidad</a>. Nosotros ocasionalmente enviaremos a su cuenta correos si existen modificaciones en estos terminos.
					</div>
				</form>
				<!-- / Register form -->
			</div>
		</div>
		<!-- / Register -->
	</div>
</div>
