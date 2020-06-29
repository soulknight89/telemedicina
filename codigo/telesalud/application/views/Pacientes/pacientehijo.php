<?php
	/**
	 * @author: Edwin Torres -> Nuevo paciente
	 * @var $idUsu int
	 * @var $datosUsuario mixed
	 */
	$hoy = date('Y-m-d');
?>
<h4 class="font-weight-bold py-3 mb-4">
	<span class="text-muted font-weight-light">Pacientes /</span> Nuevo Paciente
</h4>
<div class="card">
	<h6 class="card-header px-5">
		Por favor registre los datos del nuevo paciente que hara uso de nuestra plataforma
	</h6>
	<div class="card-body px-5">
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
		<form action="<?= base_url('Pacientes/agregarpaciente'); ?>" method="post" enctype="multipart/form-data">
			<div class="row">
				<div class="col-lg-6 col-xl-5 py-2">
					<label for="nombres" class="font-weight-bold">Nombres</label>
					<input type="text" name="nombres" id="nombres" class="form-control" placeholder="Nombres"
						   autocomplete="off"
						   value="" required/>
				</div>
				<div class="col-lg-6 col-xl-5 py-2">
					<label for="apellidos" class="font-weight-bold">Apellidos</label>
					<input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Apellidos"
						   autocomplete="off"
						   value="" required/>
				</div>
				<div class="col-lg-4 col-xl-2 py-2">
					<label for="sexo" class="font-weight-bold">Sexo</label>
					<select name="sexo" id="sexo" class="form-control" required>
						<option value="">Seleccione</option>
						<option value="F">Femenino</option>
						<option value="M">Masculino</option>
					</select>
				</div>
				<div class="col-lg-4 col-xl-3 py-2">
					<label for="tipodoc" class="font-weight-bold">Tipo Documento</label>
					<select name="tipodoc" id="tipodoc" class="form-control" required>
						<option value="">Seleccione</option>
						<option value="1">DNI</option>
						<option value="2">CE</option>
					</select>
				</div>
				<div class="col-lg-4 col-xl-3 py-2">
					<label for="numdoc" class="font-weight-bold">Nro. Documento</label>
					<input type="text" name="numdoc" id="numdoc" maxlength="12" class="form-control"
						   placeholder="Nro. Documento" autocomplete="off"
						   required/>
					<input type="hidden" name="email" id="email" class="form-control"
						   value="<?= $datosUsuario->email; ?>"/>
					<input type="hidden" name="usucrea" id="usucrea" class="form-control" value="<?= $idUsu; ?>"/>
				</div>
				<div class="col-lg-6 col-xl-3 py-2">
					<label for="telefono" class="font-weight-bold">Celular</label>
					<input type="text" name="telefono" autocomplete="off" maxlength="9" id="telefono"
						   class="form-control" placeholder="Telefono"
						   required/>
				</div>
				<div class="col-lg-6 col-xl-3 py-2">
					<label for="fecnac" class="font-weight-bold">Fecha de Nacimiento</label>
					<input type="date" pattern="dd/mm/yyyy" name="fecnac" id="fecnac" class="form-control"
						   autocomplete="off"
						   placeholder="Fecha de Nacimiento" max="<?= $hoy; ?>" min="1910-01-01" required/>
				</div>
				<!--div class="col-md-4">
					<label for="rutafirma" class="font-weight-bold">Firma </label><br>
					<input type="file" accept="image/png, image/jpeg" name="rutafirma" id="rutafirma" required/><br>
					<button type="button" style="margin-top: 15px;" class="btn btn-xs btn-warning" data-toggle="modal"
							data-target="#modal_0">(ejemplo)
					</button>
				</div>
				<div class="col-md-4">
					<label for="rutahuella" class="font-weight-bold">Huella Digital (imagen)</label><br>
					<input type="file" accept="image/png, image/jpeg" name="rutahuella" id="rutahuella" required/><br>
					<button type="button" style="margin-top: 15px;" class="btn btn-xs btn-warning" data-toggle="modal"
							data-target="#modal_1">(ejemplo)
					</button>
				</div-->
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<h5 class="font-weight-bold">
						<br>
						Al registrar mis datos y completar el registro estoy de acuerdo con los terminos de la
						plataforma y
						autorizo el uso de mis datos para el uso exclusivo de la mismadisposiciones de la plataforma
					</h5>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 text-center">
					<button type="submit" class="btn btn-small btn-info font-weight-bold">
						Aceptar y completar registro
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="modal fade m-auto" id="modal_0" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Ejemplo de firma digitalizada</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p id="modal_0_mensaje" class="text-justify">
					La firma digitalizada, debe ser clara y tratar de ocupar toda la imagen
					<br>
					<br>
					<b>Ejemplo:</b>
					<br>
				<center><img src="<?= base_url() ?>/imagen/firma.png" alt="ejemplo firma" title="ejemplo firma"
							 style="max-width: 500px; max-height: 200px !important;"></center>
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade m-auto" id="modal_1" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Ejemplo de huella digital escaneada</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p class="text-justify">
					La huella digital, debe ser del dedo indice derecho, debe ser clara y tratar de ocupar toda la
					imagen.
					<br>
					<br>
					<b>Ejemplo:</b>
					<br>
				<center><img src="<?= base_url() ?>/imagen/huella.jpg" alt="ejemplo huella" title="ejemplo huella"
							 style="max-width: 200px; max-height: 500px !important;"></center>
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
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

		$("#numdoc").keypress(function (evt) {
			let keycode = evt.charCode || evt.keyCode;
			return keycode > 47 && keycode < 58;
		}).bind('input paste', function (evt) {
			let largo  = 12;
			this.value = this.value.replace(".", "");
			this.value = this.value.replace("e", "");
			this.value = this.value.replace("-", "");
			this.value = this.value.substr(0, largo);
		});
	});
</script>
