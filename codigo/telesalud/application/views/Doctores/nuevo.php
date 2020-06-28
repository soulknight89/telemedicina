<?php
/**
 * @author: Edwin Torres -> Nuevos pedidos
 */
$datos = (object) $_SESSION['ses'];
?>
<h4 class="font-weight-bold py-3 mb-4">
	Registrar datos: Doctor <span class="font-weight-light text-danger"> - Los nombres y apellidos deben coincidir con el CMP</span>
</h4>
<div class="row">
	<div class="col-lg-12">
		<section class="panel panel-primary">
			<header class="panel-heading">
			</header>
			<?php echo form_open(null, ["class" => "", "id" => "frm_doc", "name" => "frm_doc"]); ?>
			<div class="panel-body">
				<div class="row">
					<input id="usuario" name="usuario" type="hidden" value="<?= $datos->usu_id; ?>"/>
					<div class="col-md-3">
						<label for="primer_nombre">Primer Nombre</label>
						<input type="text" name="primer_nombre" id="primer_nombre" value="<?= $datos->usu_nombre_primer?>" autocomplete="off" maxlength="100" class="form-control"/>
					</div>
					<div class="col-md-3">
						<label for="segundo_nombre">Segundo Nombre</label>
						<input type="text" name="segundo_nombre" id="segundo_nombre" value="<?= $datos->usu_nombre_segundo?>" autocomplete="off" maxlength="100" class="form-control"/>
					</div>
					<div class="col-md-3">
						<label for="apellido_paterno">Apellido Paterno</label>
						<input type="text" name="apellido_paterno" id="apellido_paterno" value="<?= $datos->usu_apellido_primer?>" autocomplete="off" maxlength="50" class="form-control"/>
					</div>
					<div class="col-md-3">
						<label for="apellido_paterno">Apellido Materno</label>
						<input type="text" name="apellido_materno" id="apellido_materno" value="<?= $datos->usu_apellido_segundo?>" autocomplete="off" maxlength="50" class="form-control"/>
					</div>
					<div class="col-md-3">
						<label for="tipo_documento">Tipo de documento</label>
						<select name="tipo_documento" id="tipo_documento" autocomplete="off" class="form-control" required>
							<option value="">Seleccione</option>
							<option value="1">DNI</option>
							<option value="2">CE</option>
							<option value="3">Pasaporte</option>
						</select>
					</div>
					<div class="col-md-3">
						<label for="nro_documento">Nro. de Documento</label>
						<input type="text" name="nro_documento" id="nro_documento" autocomplete="off" maxlength="15" class="form-control" required/>
					</div>
					<div class="col-md-3">
						<label for="colegiatura">Colegiatura</label>
						<input type="text" name="colegiatura" id="colegiatura" autocomplete="off" maxlength="9" class="form-control" required/>
					</div>
					<div class="col-md-3">
						<button type="button" style="margin-top: 25px;" class="btn btn-small btn-info" onclick="validarCMP()">Validar CMP</button>
						<input type="hidden" id="especialidades" name="especialidades"/>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<h4 class="font-weight-bold py-3 mb-4">Especialidades</h4>
				</div>
				<div class="col-md-12">
					<table class="table table-bordered table-hover">
						<thead>
						<th>Especialidad</th>
						<th>Codigo</th>
						<th>Tipo</th>
						</thead>
						<tbody id="listEspecialidades">
						</tbody>
					</table>
				</div>
			</div>
			<div class="panel-footer pull-right">
<!--					<input type="button" class="btn btn-warning" value="Volver" onclick="location.href = base_url+'mantenimiento/doctores';"/>-->
					<button type="submit" id="grabarDoctor" class="btn btn-success" disabled>Completar Registro</button>
			</div>
			<?php echo form_close(); ?>
		</section>
	</div>
</div>

<script>
	let colegiatura = $('#colegiatura');
	let primerNombreTxt = $('#primer_nombre');
	let segundoNombreTxt = $('#segundo_nombre');
	let primerApellidoTxt = $('#apellido_paterno');
	let segundoApellidoTxt = $('#apellido_materno');

	$(document).ready(function () {
		primerNombreTxt.on('keyup', function () {
			this.value = onlyAlphabet(this.value);
		});
		segundoNombreTxt.on('keyup', function () {
			this.value = onlyAlphabet(this.value);
		});
		primerApellidoTxt.on('keyup', function () {
			this.value = onlyAlphabet(this.value);
		});
		segundoApellidoTxt.on('keyup', function () {
			this.value = onlyAlphabet(this.value);
		});

		colegiatura.on('keyup', function () {
			this.value = onlyAlphaNumericNonSpace(this.value);
		});
	});

	function validarCMP() {
		$('#grabarDoctor').attr('disabled','true');
		let cmp = colegiatura.val();
		if (cmp) {
			$.ajax({
				url:         base_url + 'Doctores/validarCMP/' + cmp,
				type:        'POST',
				cache:       false,
				contentType: 'json',
				processData: false,
				success:     function (data) {
					if(data.error == 0 || data.error == '0') {
						let nombres = (segundoNombreTxt.val() && segundoNombreTxt.val().trim() != '') ? primerNombreTxt.val() + ' ' + segundoNombreTxt.val() : primerNombreTxt.val();
						let apellidos = (segundoApellidoTxt.val() && segundoApellidoTxt.val().trim() != '') ? primerApellidoTxt.val() +' ' + segundoApellidoTxt.val() : primerApellidoTxt.val();
						let valN = false;
						if(data.nombres.toLowerCase() == nombres.toLowerCase()) {
							valN =  true;
						}
						let valA = false;
						if(data.apellidos.toLowerCase() == apellidos.toLowerCase()) {
							valA =  true;
						}
						if(valA && valN) {
							$('#grabarDoctor').removeAttr('disabled');
							alert('Validacion completa puede continuar con el registro');
							primerNombreTxt.attr('readonly','true');
							segundoNombreTxt.attr('readonly','true');
							primerApellidoTxt.attr('readonly','true');
							segundoApellidoTxt.attr('readonly','true');
							colegiatura.attr('readonly','true');
							if(data.especialidades && data['especialidades'].length > 0) {
								$('#especialidades').val(JSON.stringify(data['especialidades']));
								$('#listEspecialidades').html('');
								data['especialidades'].forEach(function(especialidad) {
									let fila = '<tr><td>' + especialidad.nombre + '</td><td>' + especialidad.codigo + '</td><td>' + especialidad['tipo_especialidad'] + '</td></tr>'
									$('#listEspecialidades').append(fila);
								});
							}
						} else {
							alert('Sus nombres y apellidos no coinciden con los registrados en el CMP');
						}
					} else {
						alert(data.mensaje);
					}
				},
				error:       function () {
					alert('CMP no valido');
				}
			});
		} else {
			alert('Debe ingresar el número de colegiatura');
		}
	}
</script>
