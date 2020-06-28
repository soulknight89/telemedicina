<?php
	/**
	 * Variables dias: representa los dias disponibles 1-7, horarios es un arreglo con horarios registrados
	 * @var $idCita array
	 * @var $idUser array
	 * @var $paciente array
	 */

?>
<style>
	#peerVid{
		position: relative;
		top: 35vh;
		left: 20vw;
		/*max-width: 50vw;
		min-height: 100%;*/
		width: 40vw;
		height: 70vh;
		-ms-transform: translateX(-50%) translateY(-50%);
		-moz-transform: translateX(-50%) translateY(-50%);
		-webkit-transform: translateX(-50%) translateY(-50%);
		transform: translateX(-50%) translateY(-50%);
		background-color: black;
		background-size: contain;
	}

	#myVid{
		position: relative;
		top: 17vh;
		left: 20vw;
		width: 40vw;
		height: 35vh;
		-ms-transform: translateX(-50%) translateY(-50%);
		-moz-transform: translateX(-50%) translateY(-50%);
		-webkit-transform: translateX(-50%) translateY(-50%);
		transform: translateX(-50%) translateY(-50%);
		background-color: black;
		background-size: contain;
	}
</style>
<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Videollamada</h3>
			</div>
			<div class="card-body" style="height: 80vh; width: 50vw;">
				<div class="row">
					<div class="col-md-12">
						<h4 class="title">Paciente: <?= $paciente?></h4>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<video id="peerVid" poster="https://call.doctoraunclick.com/img/vidbg.png" playsinline autoplay></video>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-lg-6">
		<div class="row">
			<div class="col-md-12">
				<button id="botonGuardar" class="btn btn-info pull-right" onclick="guardarCampos()">Guardar Historia</button>
			</div>
		</div>
		<div class="nav-tabs-top nav-responsive-lg" style="max-width: 100%">
			<ul class="nav nav-tabs">
				<li class="nav-item">
					<a class="nav-link active" data-toggle="tab" href="#navs-anamnesis">Anamnesis</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#navs-diagnostico">Diagnostico</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#navs-tratamiento">Tratamiento</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#navs-procedimiento">Procedimiento</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#navs-recomendaciones">Recomendaciones</a>
				</li>
			</ul>
			<div class="tab-content">
				<input type="hidden" id="idCita" name="idCita" value="<?= $idCita;?>">
				<input type="hidden" id="idUser" name="idUser" value="<?= $idUser;?>">
				<div class="tab-pane fade active show" id="navs-anamnesis">
					<div class="card-body" style="background-color: lightblue">
						<label for="anamnesis">Anamnesis</label>
						<p><textarea id="anamnesis" name="anamnesis" class="form-control" rows="5" cols="95" style="resize: none;"></textarea></p>
					</div>
				</div>
				<div class="tab-pane fade" id="navs-diagnostico">
					<div class="card-body" style="background-color: lightblue">
						<label for="diagnostico">Diagnostico</label>
						<p><textarea id="diagnostico" name="diagnostico" class="form-control" rows="5" cols="95" style="resize: none;"></textarea></p>
					</div>
				</div>
				<div class="tab-pane fade" id="navs-tratamiento">
					<div class="card-body" style="background-color: lightblue">
						<label for="tratamiento">Tratamiento</label>
						<p><textarea id="tratamiento" name="tratamiento" class="form-control" rows="5" cols="95" style="resize: none;"></textarea></p>
					</div>
				</div>
				<div class="tab-pane fade" id="navs-procedimiento">
					<div class="card-body" style="background-color: lightblue">
						<label for="procedimiento">Procedimiento</label>
						<p><textarea id="procedimiento" name="procedimiento" class="form-control" rows="5" cols="95" style="resize: none;"></textarea></p>
					</div>
				</div>
				<div class="tab-pane fade" id="navs-recomendaciones">
					<div class="card-body" style="background-color: lightblue">
						<label for="recomendaciones">Recomendaciones</label>
						<p><textarea id="recomendaciones" name="recomendaciones" class="form-control" rows="5" cols="95" style="resize: none;"></textarea></p>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<br>
		</div>
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Doctor</h3>
			</div>
			<div class="card-body" style="height: 52.5vh; width: 50vw;">
				<div class="row">
					<div class="col-sm-12 text-center" id="callBtns">
						<button class="btn btn-success btn-sm initCall" id="initAudio" title='Start audio call'><i class="fa fa-phone"></i></button>
						<button class="btn btn-info btn-sm initCall" id="initVideo" title="Start video call"><i class="fa fa-video"></i></button>
						<button class="btn btn-danger btn-sm" id="terminateCall" disabled title="End call"><i class="fa fa-phone-square"></i></button>
						<button class="btn btn-sm" id='record' disabled title="Record"><i class="fa fa-dot-circle"></i></button>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<h4 class="title">En consulta</h4>
						<!--Snackbar notificaciones -->
						<div id="snackbar"></div>
						<!-- Snackbar -->
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<video id="myVid" poster="https://call.doctoraunclick.com/img/vidbg.png" playsinline autoplay></video>
					</div>
				</div>
				<div class="row">
					<div class="col-12">

					</div>
				</div>
				<!-- CHAT PANEL-->
				<div class="container-fluid chat-pane" style="display:none;">
					<div class="row chat-window col-xs-12 col-md-4">
						<div class="">
							<div class="panel panel-default chat-pane-panel">
								<div class="panel-heading chat-pane-top-bar">
									<div class="col-xs-10" style="margin-left:-20px">
										<i class="fa fa-comment" id="remoteStatus"></i> Remote
										<b id="remoteStatusTxt">(Offline)</b>
									</div>
									<div class="col-xs-2 pull-right">
										<span id="minim_chat_window" class="panel-collapsed fa fa-plus icon_minim pointer"></span>
									</div>
								</div>

								<div class="panel-body msg_container_base" id="chats"></div>

								<div class="panel-footer">
									<span id="typingInfo"></span>
									<div class="input-group">
										<textarea id='chatInput' class="form-control chat-input" placeholder="Type message here..."></textarea>
										<span class="input-group-btn">
                                    <button class="btn btn-primary btn-sm" id="chatSendBtn">Send</button>
                                </span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- CHAT PANEL -->
			</div>
		</div>
	</div>
</div>
<!--Modal to show that we are calling-->
<div id="callModal" class="modal">
	<div class="modal-content text-center">
		<div class="modal-header" id="callerInfo"></div>
		<div class="modal-body">
			<button type="button" class="btn btn-danger btn-sm" id='endCall'>
				<i class="fa fa-times-circle"></i> End Call
			</button>
		</div>
	</div>
</div>
<!--Modal end-->


<!--Modal to give options to receive call-->
<div id="rcivModal" class="modal">
	<div class="modal-content">
		<div class="modal-header" id="calleeInfo"></div>

		<div class="modal-body text-center">
			<button type="button" class="btn btn-success btn-sm answerCall" id='startAudio'>
				<i class="fa fa-phone"></i> Audio Call
			</button>
			<button type="button" class="btn btn-success btn-sm answerCall" id='startVideo'>
				<i class="fa fa-video-camera"></i> Video Call
			</button>
			<button type="button" class="btn btn-danger btn-sm" id='rejectCall'>
				<i class="fa fa-times-circle"></i> Reject Call
			</button>
		</div>
	</div>
</div>
<!--Modal end-->
<!-- custom js -->
<script src="https://call.doctoraunclick.com/js/config.js"></script>
<script src="https://call.doctoraunclick.com/js/adapter.js"></script>
<script src="https://call.doctoraunclick.com/js/comm.js"></script>
<audio id="callerTone" src="https://call.doctoraunclick.com/media/callertone.mp3" loop preload="auto"></audio>
<audio id="msgTone" src="https://call.doctoraunclick.com/media/msgtone.mp3" preload="auto"></audio>
<script>
	//guardar
	function guardarCampos() {
		let anamnesis = $('#anamnesis').val();
		let diagnostico = $('#diagnostico').val();
		let tratamiento = $('#tratamiento').val();
		let procedimiento = $('#procedimiento').val();
		let recomendaciones = $('#recomendaciones').val();
		let idUser = $('#idUser').val();
		let idCita = $('#idCita').val();
		let form_a = new FormData;
		form_a.append('anamnesis',anamnesis);
		form_a.append('diagnostico',diagnostico);
		form_a.append('tratamiento',tratamiento);
		form_a.append('procedimiento',procedimiento);
		form_a.append('recomendaciones',recomendaciones);
		form_a.append('idUser',idUser);
		form_a.append('idCita',idCita);
		$.ajax({
			url : base_url + '/Atencion/registrar_historia',
			type: "POST",
			cache: false,
			contentType: false,
			processData: false,
			data:  form_a,
			beforeSend: function(){
			},
			success : function(data){
				console.log(data);
				if(data == "0"){
					alert('Error no se pudo actualizar');
				}else{
					alert('Se guardo correctamente');
				}
			},
			error: function(xhr, status, error){
				alert("Ocurrió un error de conexión, presione enviar nuevamente o inténtelo más tarde");
			},
			complete : function(){
			},
		});
	}
</script>
