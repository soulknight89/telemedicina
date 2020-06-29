<?php
	/**
	 * @author: Edwin Torres -> Nuevo paciente
	 * @var $idUsu int
	 * @var $pacientes mixed
	 * @var $especialidades
	 */
	$fecha = date('Y-m-d');
	$hoy   = DateTime::createFromFormat('Y-m-d', $fecha);
	$hoy->modify('+1 day');
	$mañana = $hoy->format('Y-m-d');
?>
<h4 class="font-weight-bold py-3 mb-4">
	<span class="text-muted font-weight-light">Pacientes /</span> Reservar Cita
</h4>
<div class="row">
	<div class="col-md-4">
		<div class="card">
			<h5 class="card-header py-4 px-5">Elija los datos para la cita</h5>
			<div class="card-body px-5">
				<div class="row py-2">
					<div class="col">
						<label class="font-weight-bold">Elija el paciente</label>
						<select name="paciente" id="paciente" class="form-control">
							<option value="">Elija un paciente</option>
							<?php
								if ($pacientes) {
									foreach ($pacientes as $paciente) {
										?>
										<option value="<?= $paciente->idPaciente; ?>"><?= trim($paciente->nombres . ' ' . $paciente->apellidos); ?></option>
										<?php
									}
								}
							?>
						</select>
					</div>
				</div>
				<div class="row py-2">
					<div class="col">
						<label class="font-weight-bold" for="especialidad">Elija la especialidad</label>
						<select id="especialidad" name="especialidad" class="form-control">
							<option value="1" selected>MEDICINA GENERAL</option>
							<?php
								if ($especialidades) {
									foreach ($especialidades as $especialidad) {
										?>
										<option value="<?= $especialidad->nombre; ?>"><?= trim($especialidad->nombre); ?></option>
										<?php
									}
								}
							?>
						</select>
					</div>
				</div>
				<div class="row py-2">
					<div class="col">
						<label class="font-weight-bold" for="fecha">Elija la fecha</label>
						<input type="date" name="fecha" id="fecha" class="form-control" placeholder="Elija una fecha"
							   pattern="dd/mm/yyyy" min="<?= $mañana; ?>"/>
					</div>
				</div>
			</div>
			<div class="card-footer px-5">
				<button id="buscar" class="btn btn-block btn-outline-success">Buscar</button>
			</div>
		</div>
		<div class="card" id="eligio-cita" style="display: none; margin-top: 25px;">
			<input type="hidden" id="idUser" value="<?= $idUsu; ?>">
			<h5 class="card-header py-4 px-5">Cita Elegida</h5>
			<div class="card-body px-5">
				<div class="row py-2">
					<div class="col">
						Paciente: <b id="paciente-elegido"></b>
					</div>
				</div>
				<div class="row py-2">
					<div class="col">
						Doctor: <b id="doctor-elegido"></b>
					</div>
				</div>
				<div class="row py-2">
					<div class="col">
						Fecha: <b id="fecha-elegida"></b>
					</div>
				</div>
				<div class="row py-2">
					<div class="col">
						Hora: <b id="hora-elegida"></b>
					</div>
				</div>
				<input type="hidden" id="idDoctor" value="">
				<input type="hidden" id="horaCita" value="">
				<input type="hidden" id="diaCita" value="">
				<input type="hidden" id="idPaciente" value="">
			</div>
			<div class="card-footer px-5">
				<button id="reservar" class="btn btn-block btn-outline-primary">Agendar Cita</button>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="card">
			<h5 class="card-header py-4 px-5">Resultados de la busqueda</h5>
			<div class="card-body px-5">
				<div id="resultados-busqueda">

				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		$('#buscar').on('click', function () {
			buscarDoctores();
		});

		$('#reservar').on('click', function () {
			reservarCita();
		});
	});

	function buscarDoctores() {
		let dia          = $('#fecha').val();
		let especialidad = $('#especialidad').val();
		if (dia && especialidad) {
			let form_a = new FormData;
			form_a.append('dia', dia);
			form_a.append('especialidad', especialidad);
			$.ajax({
				url: base_url + '/Atencion/buscar_citas',
				type: "POST",
				cache: false,
				contentType: false,
				processData: false,
				data: form_a,
				beforeSend: function () {
				},
				success: function (data) {
					$('#resultados-busqueda').html('');
					if (data.error == "0") {
						data['data'].forEach(function (entry) {
							let doct           = entry['id'];
							let fila           = document.createElement('div');
							fila.id            = 'fila-' + doct;
							fila.className     = 'row';
							let columna        = document.createElement('div');
							columna.className  = 'col-md-12';
							let titulo         = document.createElement('h5');
							titulo.className   = 'font-weight-bold';
							titulo.innerText   = entry.doctor;
							let titulo2        = document.createElement('h6');
							titulo2.className  = 'font-weight-bold';
							titulo2.innerText  = 'Horarios';
							let divHoras       = document.createElement('div');
							divHoras.className = 'demo-inline-spacing text-center align-content-center';
							entry['horarios'].forEach(function (horario) {
								//console.log(horario);
								let hora = document.createElement("button");
								hora.setAttribute('data-hora', horario['hora']);
								hora.setAttribute('data-doc', doct);
								hora.setAttribute('data-nom', entry.doctor);
								hora.className = 'btn rounded-pill btn-primary citahora';
								hora.innerText = horario['hora'];
								hora.disabled  = (horario['disponible'] !== 1);
								divHoras.append(hora);
							});
							let espacio       = document.createElement('hr');
							espacio.className = 'container-m-nx border-light my-4';
							columna.append(titulo);
							columna.append(titulo2);
							columna.append(divHoras);
							columna.append(espacio);
							fila.append(columna);
							document.getElementById('resultados-busqueda').append(fila);
						});
						$('.citahora').on('click', function () {
							let hora       = $(this).data('hora');
							let doctor     = $(this).data('doc');
							let nombre     = $(this).data('nom');
							let pacienteid = $("#paciente").val();
							let paciente   = $("#paciente option:selected").text();
							if (pacienteid && pacienteid != '') {
								$('#hora-elegida').text(hora);
								$('#doctor-elegido').text(nombre);
								$('#paciente-elegido').text(paciente);
								$('#fecha-elegida').text(dia);
								$('#idDoctor').val(doctor);
								$('#idPaciente').val(pacienteid);
								$('#diaCita').val(dia);
								$('#horaCita').val(hora);
								$('#eligio-cita').css('display', '');
							} else {
								$('#idDoctor').val('');
								$('#idPaciente').val('');
								$('#diaCita').val('');
								$('#horaCita').val('');
								alert('Debe elegir un paciente');
								$('#eligio-cita').css('display', 'none');
							}
						})
					} else {
						$('#idDoctor').val('');
						$('#idPaciente').val('');
						$('#diaCita').val('');
						$('#horaCita').val('');
						$('#resultados-busqueda').html(data.msj);
						$('#eligio-cita').css('display', 'none');
					}
				},
				error: function (xhr, status, error) {
					alert("Ocurrió un error de conexión, presione enviar nuevamente o inténtelo más tarde");
				},
				complete: function () {
				},
			});
		} else {
			alert('Debe elegir la fecha y especialidad para buscar la disponibilidad');
		}
	}

	function reservarCita() {
		let idUser     = $('#idUser').val();
		let idDoctor   = $('#idDoctor').val();
		let idPaciente = $('#idPaciente').val();
		let fechaCita  = $('#diaCita').val();
		let horaInicio = $('#horaCita').val();
		if (idDoctor && idPaciente && fechaCita && horaInicio && idUser) {
			let r = confirm("Esta seguro que desea agendar esta cita?");
			if (r == true) {
				let form_a = new FormData;
				form_a.append('idUser', idUser);
				form_a.append('idDoctor', idDoctor);
				form_a.append('idPaciente', idPaciente);
				form_a.append('fechaCita', fechaCita);
				form_a.append('horaInicio', horaInicio);
				$.ajax({
					url: base_url + '/Atencion/agendar_cita',
					type: "POST",
					cache: false,
					contentType: false,
					processData: false,
					data: form_a,
					beforeSend: function () {
					},
					success: function (data) {
						if (data == "0") {
							alert('Cita agendada con exito!');
							location.href = base_url + 'Principal'
						} else {
							alert('No se pudo agendar la cita o la cita ya fue tomada, por favor refresque la pagina');
						}
					},
					error: function (xhr, status, error) {
						alert("Ocurrió un error de conexión, presione enviar nuevamente o inténtelo más tarde");
					},
					complete: function () {
						$("#btnEnviar").attr("disabled", false);
					},
				});
			} else {
				alert("No se agendo ninguna cita!, acción cancelada");
			}
		}
	}
</script>
