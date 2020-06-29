<?php
	/**
	 * Variables dias: representa los dias disponibles 1-7, horarios es un arreglo con horarios registrados
	 * @var $dias array
	 * @var $horarios array
	 */

?>
<h4 class="font-weight-bold py-3 mb-4">
	<span class="text-muted font-weight-light">Doctores /</span> Horarios
</h4>
<div class="card mb-4">
	<h6 class="card-header">
		Registrar nuevo dia para atención
	</h6>
	<div class="card-body">
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
		<form action="<?= base_url('Doctores/horarios');?>" method="post" >
			<div class="row">
				<div class="col-3">
					<div class="form-group">
						<label class="form-check">
							<input class="form-check-input" id="lunes" name="dias[]" value="1"  type="checkbox">
							<div class="form-check-label">
								Lunes
							</div>
						</label>
					</div>
					<div class="form-group">
						<label class="form-check">
							<input class="form-check-input" id="martes" name="dias[]" value="2" type="checkbox">
							<div class="form-check-label">
								Martes
							</div>
						</label>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="form-check">
							<input class="form-check-input" id="miercoles" name="dias[]" value="3" type="checkbox">
							<div class="form-check-label">
								Miercoles
							</div>
						</label>
					</div>
					<div class="form-group">
						<label class="form-check">
							<input class="form-check-input" id="jueves" name="dias[]" value="4" type="checkbox">
							<div class="form-check-label">
								Jueves
							</div>
						</label>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="form-check">
							<input class="form-check-input" id="viernes" name="dias[]" value="5" type="checkbox">
							<div class="form-check-label">
								Viernes
							</div>
						</label>
					</div>
					<div class="form-group">
						<label class="form-check">
							<input class="form-check-input" id="sabado" name="dias[]" value="6" type="checkbox">
							<div class="form-check-label">
								Sabado
							</div>
						</label>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="form-check">
							<input class="form-check-input" id="domingo" name="dias[]" value="7" type="checkbox">
							<div class="form-check-label">
								Domingo
							</div>
						</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label for="hora_inicio" class="form-label">Hora Inicio</label>
						<input type="time" id="hora_inicio" name="hora_inicio" class="form-control" placeholder="Hora Inicio" required>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label for="hora_fin" class="form-label">Password</label>
						<input type="time" id="hora_fin" name="hora_fin" class="form-control" placeholder="Hora Fin" required>
					</div>
				</div>
			</div>
			<button type="submit" id="enviar" class="btn btn-info pull-right">Guardar</button>
		</form>
	</div>
</div>
<div class="card">
	<h6 class="card-header">
		Horario de atención registrado
	</h6>
	<div class="card-datatable table-responsive">
		<table class="datatables-demo table table-striped table-bordered">
			<thead>
				<tr>
					<td>Dia</td>
					<td>Hora Inicio</td>
					<td>Hora Fin</td>
					<td>Activo</td>
					<td>Habilitar</td>
				</tr>
			</thead>
			<tbody>
				<?php
					if($horarios && count($horarios)>0) {
						foreach ($horarios as $dia) {
							?>
								<tr>
									<td><?= $dia->dia; ?></td>
									<td><?= $dia->horaInicio; ?></td>
									<td><?= $dia->horaFin; ?></td>
									<td><?= ($dia->activo == 1) ? 'SI' : 'NO'; ?></td>
									<td><?= $dia->idHorario; ?></td>
								</tr>
							<?php
						}
					}
				?>
			</tbody>
		</table>
	</div>
</div>
