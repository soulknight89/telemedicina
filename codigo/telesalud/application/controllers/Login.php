<?php

	class Login extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('Usuario_model');
		}

		public function index()
		{
			$this->layout->setLayout("login");
			if ($this->input->post()) {
				$u = $this->input->post("usuario", true);
				$p = $this->input->post("clave", true);
				$this->form_validation->set_rules(
					"usuario", "Correo", "trim|required|valid_email", ['required' => 'Debe ingresar el %s', 'valid_email' => 'Debe ser un Correo Electronico valido']
				);
				$this->form_validation->set_rules(
					"clave", "Clave", "trim|required", ['required' => 'Debe ingresar la %s.']
				);
				if ($this->form_validation->run() == false) {
					$this->session->set_flashdata("danger", validation_errors());
				} else {
					$row = $this->Usuario_model->loginHash($u);
					if ($row) {
						$hashed = $row->passfrase;
						if (password_verify($p, $hashed)) {
							$sess_array               = [
								"usu_id"               => $row->idUsuario,
								"usu_email"            => $row->email,
								"usu_mostrar"          => $row->nombre_mostrar,
								"usu_nombres"          => $row->nombres,
								"usu_nombre_primer"    => $row->nombre_primer,
								"usu_nombre_segundo"   => $row->nombre_segundo,
								"usu_apellidos"        => $row->apellidos,
								"usu_apellido_primer"  => $row->apellido_primer,
								"usu_apellido_segundo" => $row->apellido_segundo,
								"usu_telefono"         => $row->telefono,
								"usu_perfil"           => $row->idPerfil,
								"usu_foto"             => $row->fotoperfil,
								"per_nombre"           => $row->perfil,
							];
							$res                      = $this->Usuario_model->buscar_usuario_doctor($sess_array['usu_id']);
							$sess_array['usu_doctor'] = ($res) ? '1' : '0';
							$this->session->set_userdata("ses", $sess_array);
							$this->session->userdata("ses");
							redirect(base_url("Principal"));
						} else {
							$this->session->set_flashdata("danger", "Clave incorrecta");
						}
					} else {
						$this->session->set_flashdata("danger", "Correo no registrado");
					}
				}
			}
			$this->layout->view("index");
		}

		public function register()
		{
			$this->layout->setLayout("login");
			if ($this->input->post()) {
				$this->form_validation->set_rules(
					"email", "Correo", "trim|required|valid_email",
					[
						'required'    => 'Debe ingresar el %s',
						'valid_email' => 'Debe ser un Correo Electronico valido'
					]
				);
				$this->form_validation->set_rules(
					"primer_nombre", "Primer Nombre", "trim|required", ['required' => 'Debe ingresar su %s.']
				);
				$this->form_validation->set_rules(
					"apellido_paterno", "Apellido Paterno", "trim|required", ['required' => 'Debe ingresar su %s.']
				);
				$this->form_validation->set_rules(
					"newPwd", "Clave", "trim|required", ['required' => 'Debe llenar el campo %s.']
				);
				$this->form_validation->set_rules(
					"repeatPwd", "Repetir Clave", "trim|required", ['required' => 'Debe llenar el campo %s.']
				);
				$this->form_validation->set_rules('repeatPwd', 'Repetir Clave', 'required|matches[newPwd]', ['required' => 'Debe llenar el campo %s.', 'matches' => 'Reperir Clave no coincide con Clave']);
				if ($this->form_validation->run() == false) {
					$this->session->set_flashdata("danger", validation_errors());
					$this->layout->view("index");
				} else {
					$data['nombre_primer']    = $this->input->post("primer_nombre", true);
					$data['nombre_segundo']   = $this->input->post("segundo_nombre", true);
					$data['apellido_primer']  = $this->input->post("apellido_paterno", true);
					$data['apellido_segundo'] = $this->input->post("apellido_materno", true);
					$data['email']            = $this->input->post("email", true);
					$data['password']         = $this->input->post("newPwd", true);
					$password0                = $data['password'];
					$data['password']         = $this->encript($data['password']);
					$uid                      = $this->Usuario_model->create_usuario($data);
					if ($uid && $uid > 0) {
						$row = $this->Usuario_model->loginHash($data['email']);
						if ($row) {
							$hashed = $row->passfrase;
							if (password_verify($password0, $hashed)) {
								$sess_array               = [
									"usu_id"               => $row->idUsuario,
									"usu_email"            => $row->email,
									"usu_mostrar"          => $row->nombre_mostrar,
									"usu_nombres"          => $row->nombres,
									"usu_nombre_primer"    => $row->nombre_primer,
									"usu_nombre_segundo"   => $row->nombre_segundo,
									"usu_apellidos"        => $row->apellidos,
									"usu_apellido_primer"  => $row->apellido_primer,
									"usu_apellido_segundo" => $row->apellido_segundo,
									"usu_telefono"         => $row->telefono,
									"usu_perfil"           => $row->idPerfil,
									"usu_foto"             => $row->fotoperfil,
									"per_nombre"           => $row->perfil,
								];
								$res                      = $this->Usuario_model->buscar_usuario_doctor($sess_array['usu_id']);
								$sess_array['usu_doctor'] = ($res) ? '1' : '0';
								$this->session->set_userdata("ses", $sess_array);
								$this->session->userdata("ses");
								redirect(base_url("Principal"));
							} else {
								$this->session->set_flashdata("danger", "Clave incorrecta");
							}
						}
					} else {
						$this->session->set_flashdata("danger", "Correo no registrado");
					}
				}
			} else {
				$this->layout->view("index");
			}
		}

		public function logout()
		{
			$array_items = ['id', 'per_id', 'nombre'];
			$this->session->unset_userdata($array_items);
			$this->session->sess_destroy();
			redirect(base_url("/"), 301);
		}

		/**
		 * Encripta el password usando el metodo de seguridad mas reciente, defecto bcrypt
		 * @param $passfrase
		 *
		 * @return bool|mixed|string
		 */
		public function encript($passfrase)
		{
			$opciones = [
				'cost' => 12,
			];
			return password_hash($passfrase, PASSWORD_DEFAULT, $opciones);
		}

		/**
		 * valida si el correo ya se encuentra registrado en el sistema
		 * @param $correo
		 *
		 * @return bool
		 */
		public function validarCorreo($correo)
		{
			$res = $this->Usuario_model->correo_existe($correo);
			if ($res && count($res) > 0) {
				//si el codigo existe el codigo es no valido entonces falso
				return false;
			} else {
				return true;
			}
		}
	}
