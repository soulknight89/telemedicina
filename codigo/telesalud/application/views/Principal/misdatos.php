<?php
	/**
	 * @author: Edwin Torres -> Perfil
	 * @var $idUsu int
	 * @var $datosUsuario mixed
	 */
	$vacio = 'imagen/perfil.png';
	$foto  = ($datosUsuario->fotoperfil) ? 'pacfls/fotos/' . $idUsu . '/' . $datosUsuario->fotoperfil : $vacio;
?>
<h4 class="font-weight-bold py-3 mb-4">
	<span class="text-muted font-weight-light">Principal /</span> Mis Datos
</h4>
<div class="row">
	<div class="col-md-4">
		<div class="card">
			<div class="card-body px-5">
				<h5 class="font-weight-bold">Foto</h5>
				<center>
					<img id="foto-perfil" src="<?= base_url() . $foto ?>" title="Foto de perfil" alt="Foto de perfil"
						 style="max-width: 300px; max-height: 600px;"/>
				</center>
			</div>
			<div class="card-footer px-5">
				<form action="<?= base_url('Principal/actualizarfoto'); ?>" method="post" enctype="multipart/form-data">
					<div class="row">
						<div class="col-12">
							<label class="font-weight-bold">Cambiar foto</label><br>
							<input type="file" id="fotoperfil" name="fotoperfil" accept="image/jpeg, image/png">
						</div>
						<div class="col-12">
							<button type="submit" class="btn btn-outline-success pull-right">Actualizar Foto</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="card">
			<form action="<?= base_url('Principal/actualizardatos'); ?>" method="post" enctype="multipart/form-data">
				<div class="card-header py-3 px-5">
					<h4 class="card-title" style="margin-top: 10px;">Mis datos</h4>
				</div>
				<div class="card-body px-5">
					<div class="row py-2">
						<div class="col-12">
							<label for="email" class="font-weight-bold">Correo Electronico</label>
							<input type="text" value="<?= $datosUsuario->email; ?>" id="email" class="form-control"
								   readonly>
						</div>
					</div>
					<div class="row py-2">
						<div class="col-6">
							<label for="nombre_primer" class="font-weight-bold">Primer Nombre</label>
							<input type="text" value="<?= $datosUsuario->nombre_primer; ?>" id="nombre_primer"
								   name="nombre_primer" class="form-control" readonly>
						</div>
						<div class="col-6">
							<label for="nombre_segundo" class="font-weight-bold">Otros Nombres</label>
							<input type="text" value="<?= $datosUsuario->nombre_segundo; ?>" id="nombre_segundo"
								   name="nombre_segundo" class="form-control" autocomplete="off">
						</div>
					</div>
					<div class="row py-2">
						<div class="col-6">
							<label for="apellido_primer" class="font-weight-bold">Primer Apellido</label>
							<input type="text" value="<?= $datosUsuario->apellido_primer; ?>" id="apellido_primer"
								   name="apellido_primer" class="form-control" readonly>
						</div>
						<div class="col-6">
							<label for="apellido_segundo" class="font-weight-bold">Otros Apellidos</label>
							<input type="text" value="<?= $datosUsuario->apellido_segundo; ?>" id="apellido_segundo"
								   name="apellido_segundo" class="form-control" autocomplete="off">
						</div>
					</div>
					<div class="row py-2">
						<div class="col-6">
							<label for="telefono">Telefono</label>
							<input type="tel" id="telefono" name="telefono" class="form-control"
								   value="<?= $datosUsuario->telefono; ?>" autocomplete="off"/>
						</div>
					</div>
				</div>
				<div class="card-footer px-5">
					<button type="submit" class="btn btn-outline-success pull-right">Actualizar Datos</button>
				</div>
			</form>
		</div>
	</div>
</div>
