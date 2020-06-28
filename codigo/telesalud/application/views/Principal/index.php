<?php
	/**
	 * Variables dias: representa los dias disponibles 1-7, horarios es un arreglo con horarios registrados
	 * @var $citasDoctor array
	 * @var $citasPaciente array
	 * @var $especialidades array
	 * @var $validarDoctor array
	 * @var $citasHoy integer
	 * @var $citasMes integer
	 * @var $usuario integer
	 */

?>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
				Menu Principal
				<!--				<span class="tools pull-right">-->
				<!--					<a href="javascript:;" class="fa fa-chevron-down"></a>-->
				<!--					<a href="javascript:;" class="fa fa-cog"></a>-->
				<!--					<a href="javascript:;" class="fa fa-times"></a>-->
				<!--            	</span>-->
			</header>
			<div class="panel-body">
				<div class="row" style="margin-top: 25px;">
					<?php if(count($validarDoctor) == 0) {?>
					<div class="col-4">
						<button type="button" class="btn btn-block btn-info" onclick="location.href = base_url + 'Doctores/nuevo'">Registrarme como Doctor</button>
					</div>
					<?php } ?>
					<div class="col-4" style="display: none;">
						<button type="button" class="btn btn-block btn-info" onclick="location.href = base_url + 'Pacientes/nuevo'">Registrarme como Paciente</button>
					</div>
				</div>
				<div class="row" style="margin-top: 25px;">
					<div class="col-sm-6 col-xl-3">
						<div class="card mb-4">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="lnr lnr-calendar-full display-4 text-success"></div>
									<div class="ml-3">
										<div class="text-muted small">Citas del dia</div>
										<div class="text-large"><?= $citasHoy;?></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-xl-3">
						<div class="card mb-4">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="lnr lnr-earth display-4 text-info"></div>
									<div class="ml-3">
										<div class="text-muted small">Citas del mes</div>
										<div class="text-large"><?= $citasMes;?></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php if($especialidades && count($especialidades) > 0) { ?>
				<div class="row card" style="margin-top: 25px;">
					<div class="col-12">
						<div class="card-title" style="margin-top: 25px">
							<h4 class="card-title">Especialidades registradas</h4>
						</div>
						<div class="card-body">
							<table class="table table-hover table-bordered">
								<thead>
									<th>Especialidad</th>
									<th>Codigo</th>
									<th>Tipo Especialidad</th>
								</thead>
								<tbody>
								<?php
										foreach ($especialidades as $espec) {
								?>
									<tr>
										<td><?= $espec->nombre?></td>
										<td><?= $espec->codigo?></td>
										<td><?= $espec->nombreEspecialidad?></td>
									</tr>
								<?php
										}
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?php } ?>
				<!-- citas como doctor -->
				<?php if($citasDoctor && count($citasDoctor) > 0) { ?>
				<div class="row card" style="margin-top: 25px;">
					<div class="col-12">
						<div class="card-title" style="margin-top: 25px">
							<h4 class="card-title">Citas del dia (Como Doctor)</h4>
						</div>
						<div class="card-body">
							<table class="table table-hover table-bordered">
								<thead>
								<th>Paciente</th>
								<th>Dia</th>
								<th>Hora</th>
								<th>Enlace</th>
								</thead>
								<tbody>
								<?php
									if($citasDoctor && count($citasDoctor) > 0) {
										foreach ($citasDoctor as $citasd) {
											$idPac  = $citasd->idPaciente;
											$idCita = $citasd->idCita;
											?>
											<tr>
												<td><?= $citasd->paciente?></td>
												<td><?= $citasd->dia?></td>
												<td><?= $citasd->hora?></td>
												<td><?= ($citasd->valido == 1) ? "<a target='_blank' href='".base_url('Atencion/call')."/$idPac/$idCita/doctor.html?room=".md5($usuario)."' class='btn btn-success'>Acceder</a>" : 'Enlace no activo' ;?></td>
											</tr>
											<?php
										}
									}
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<?php } ?>
				<!-- citas como paciente -->
				<?php if($citasPaciente && count($citasPaciente) > 0) { ?>
				<div class="row card" style="margin-top: 25px;">
					<div class="col-12">
						<div class="card-title" style="margin-top: 25px">
							<h4 class="card-title">Citas del dia (Como Paciente)</h4>
						</div>
						<div class="card-body">
							<table class="table table-hover table-bordered">
								<thead>
								<th>Doctor</th>
								<th>Dia</th>
								<th>Hora</th>
								<th>Enlace</th>
								</thead>
								<tbody>
								<?php
									foreach ($citasPaciente as $citasd) {
										?>
										<tr>
											<td><?= $citasd->paciente?></td>
											<td><?= $citasd->dia?></td>
											<td><?= $citasd->hora?></td>
											<td><?= ($citasd->valido == 1) ? "<a target='_blank' href='https://call.doctoraunclick.com/comm.html?room=".md5($citasd->idUsuario)."' class='btn btn-success'>Acceder</a>" : 'Enlace no activo' ;?></td>
										</tr>
										<?php
									}
								?>
								</tbody>
							</table>
						</div>
					</div>
					<?php } ?>
					<!-- fin citas como paciente -->
				</div>
			</div>
		</section>
	</div>
</div>
<script>
</script>
