<?php

class Usuario extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Usuario_model');
	}

	public function listar_perfiles()
	{
		return $this->Usuario_model->listar_perfiles();
	}

	public function puntos_venta()
	{
		return $this->Usuario_model->puntos_venta();
	}

	public function nuevo()
	{
		$data = [];
		$this->db->trans_begin();
		$perfiles = $this->listar_perfiles();
		$niveles  = [];
		foreach ($perfiles as $perfil) {
			$nivel     = (object) [
				'id'     => $perfil->idPerfil,
				'nombre' => $perfil->nombre,
			];
			$niveles[] = $nivel;
		}
		$data['perfiles'] = $niveles;
		$lugares          = $this->puntos_venta();
		$puntos           = [];
		foreach ($lugares as $punto) {
			$objeto   = (object) [
				'id'     => $punto->idPunto,
				'nombre' => $punto->nombre,
			];
			$puntos[] = $objeto;
		}
		$data['puntos'] = $puntos;
		if (!$this->input->post()) {
			if ($this->db->trans_status() == false) {
				header("Location: " . base_url("mantenimiento/usuarios"));
				$this->session->set_flashdata("danger", "No se pudo cargar la vista de nuevo usuario");
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
				$this->layout->view("nuevo", $data);
			}
		} else {
			$this->form_validation->set_rules(
				"nombres", "Nombres", "trim|required", ['required' => 'Debe ingresar los %s.']
			);
			$this->form_validation->set_rules(
				"apellidos", "Apellidos", "trim|required", ['required' => 'Debe ingresar los %s.']
			);
			$this->form_validation->set_rules(
				"telefono", "Telefono", "trim|required|min_length[5]",
				['required' => 'Debe ingresar el %s.', 'min_length' => 'El %s debe tener al menos 5 digitos']
			);
			$this->form_validation->set_rules(
				"email", "Correo", "trim|required|valid_email",
				['required' => 'Debe ingresar el %s.', 'valid_email' => 'El %s debe tener un formato valido']
			);
			$this->form_validation->set_rules("perfil", "Perfil", "required", ['required' => 'Debe elegir el %s.']);
			if ($this->form_validation->run() == false) {
				$this->session->set_flashdata("danger", validation_errors());
				$this->layout->view("nuevo", $data);
			} else {
				$correo         = $this->input->post("email", true);
				$d["nombres"]   = $this->input->post("nombres", true);
				$d["apellidos"] = $this->input->post("apellidos", true);
				$d["email"]     = $correo;
				$d["passfrase"] = $this->encript("pedidos2018");
				$d["telefono"]  = $this->input->post("telefono", true);
				$idPunto        = $this->input->post("punto_venta");
				$perfil         = $this->input->post("perfil");
				$d["idPunto"]   = ($idPunto) ? $idPunto : null;
				$d["idPerfil"]  = $perfil;
				if ($perfil == 2) {
					if ($idPunto) {
						if ($this->validarCorreo($correo)) {
							$this->Usuario_model->create_usuario($d);
							if ($this->db->trans_status() == false) {
								$this->session->set_flashdata("danger", "No se pudo registrar el usuario");
								$this->db->trans_rollback();
							} else {
								$this->db->trans_commit();
								header("Location: " . base_url("mantenimiento/usuarios"));
								$this->session->set_flashdata("success", "Usuario registrado correctamente");
							}
						} else {
							$this->session->set_flashdata("danger", "Correo $correo , registrado anteriormente");
							$this->layout->view("nuevo", $data);
						}
					} else {
						$this->session->set_flashdata(
							"danger", "Para el perfil Punto de Venta debe elegir un Punto de Venta"
						);
						$this->layout->view("nuevo", $data);
					}
				} else {
					if ($this->validarCorreo($correo)) {
						$this->Usuario_model->create_usuario($d);
						if ($this->db->trans_status() == false) {
							$this->session->set_flashdata("danger", "No se pudo registrar el usuario");
							$this->db->trans_rollback();
						} else {
							$this->db->trans_commit();
							header("Location: " . base_url("mantenimiento/usuarios"));
							$this->session->set_flashdata("success", "Usuario registrado correctamente");
						}
					} else {
						$this->session->set_flashdata("danger", "Correo $correo , registrado anteriormente");
						$this->layout->view("nuevo", $data);
					}
				}
			}
		}
	}

	/**
	 * Muestra la pantalla de lista de usuarios
	 */
	public function index()
	{
		$data['usuarios'] = $this->listarUsuarios();
		$this->db->trans_commit();
		$this->layout->view("index", $data);
	}

	public function claveNueva()
	{
		$data['usuario'] = (object) $this->session->userdata("ses");
		if (!$this->input->post()) {
			if ($this->db->trans_status() == false) {
				header("Location: " . base_url("/"));
				$this->session->set_flashdata("danger", "No se pudo cargar la vista de cambiar clave");
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
				$this->layout->view("cambiarClave", $data);
			}
		} else {
			$this->form_validation->set_rules(
				"clave", "Clave", "trim|required",
				['required' => 'Debe ingresar la %s.']
			);
			$this->form_validation->set_rules(
				"clave2", "Repetir Clave", "trim|required|matches[clave]",
				['required' => 'Debe %s.', 'matches' => '%s debe ser igual a la Clave ingresada']
			);
			if ($this->form_validation->run() == false) {
				$this->session->set_flashdata("danger", validation_errors());
				$this->layout->view("cambiarClave", $data);
			} else {
				$clave          = $this->input->post("clave", true);
				$d["passfrase"] = $this->encript($clave);
				$this->Usuario_model->update_usuario($data['usuario']->usu_id, $d);
				if ($this->db->trans_status() == false) {
					$this->session->set_flashdata("danger", "No se pudo actualizar la clave");
					$this->db->trans_rollback();
					$this->layout->view("cambiarClave", $data);
				} else {
					$this->db->trans_commit();
					header("Location: " . base_url("/"));
					$this->session->set_flashdata("success", "Clave actualizada correctamente");
				}
			}
		}
	}

	public function listarUsuarios($p = null)
	{
		$data     = [];
		$usuarios = $this->Usuario_model->listarUsuarios($p);
		foreach ($usuarios as $usuario) {
			$id     = $usuario->idUsuario;
			$url    = base_url('Usuario/editar/' . $id);
			$boton  = "<a class=\"btn btn-xs btn-primary\" href='$url' data-id=\"$id\"><i class='fa fa-edit'></i></a>";
			$fila   = (object) [
				'nombres'     => $usuario->nombres,
				'apellidos'   => $usuario->apellidos,
				'email'       => $usuario->email,
				'telefono'    => $usuario->telefono,
				'perfil'      => $usuario->perfil,
				'punto_venta' => $usuario->punto_venta,
				'estado'      => ($usuario->activo == 1) ? 'Activo' : 'Inactivo',
				'boton'       => $boton,
			];
			$data[] = $fila;
		}

		return $data;
	}

	public function crearAdmin()
	{
		$this->db->trans_begin();
		$d['nombre_primer']    = 'Administrador';
		$d['apellido_primer']  = 'Tele Salud';
		$d['email']      = 'administrador@telesalud.com';
		$d["password"]  = $this->encript("medicina20");
		$d["telefono"]   = '987518435';
		$d["idPerfil"]   = 1;
		$d["estado"]     = 1;
		$this->Usuario_model->create_usuario($d);
		if ($this->db->trans_status() == false) {
			$this->session->set_flashdata("danger", "No se pudo registrar el usuario");
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$this->session->set_flashdata("success", "Usuario registrado correctamente");
		}
	}


	public function editar($usu = null)
	{
		$this->db->trans_begin();
		$perfiles = $this->listar_perfiles();
		$niveles  = [];
		foreach ($perfiles as $perfil) {
			$nivel     = (object) [
				'id'     => $perfil->idPerfil,
				'nombre' => $perfil->nombre,
			];
			$niveles[] = $nivel;
		}
		$data['perfiles'] = $niveles;
		$lugares          = $this->puntos_venta();
		$puntos           = [];
		foreach ($lugares as $punto) {
			$objeto   = (object) [
				'id'     => $punto->idPunto,
				'nombre' => $punto->nombre,
			];
			$puntos[] = $objeto;
		}
		$data['puntos'] = $puntos;
		$data["datos"]  = $this->Usuario_model->buscar_usuario($usu);
		if (!$this->input->post()) {
			if ($this->db->trans_status() == false) {
				header("Location: " . base_url("mantenimiento/usuarios"));
				$this->session->set_flashdata("danger", "No se pudo cargar la vista de editar usuario");
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
				$this->layout->view("editar", $data);
			}
		} else {
			$this->form_validation->set_rules(
				"nombres", "Nombres", "trim|required", ['required' => 'Debe ingresar los %s.']
			);
			$this->form_validation->set_rules(
				"apellidos", "Apellidos", "trim|required", ['required' => 'Debe ingresar los %s.']
			);
			$this->form_validation->set_rules(
				"telefono", "Telefono", "trim|required|min_length[5]",
				['required' => 'Debe ingresar el %s.', 'min_length' => 'El %s debe tener al menos 5 digitos']
			);
			$this->form_validation->set_rules(
				"email", "Correo", "trim|required|valid_email",
				['required' => 'Debe ingresar el %s.', 'valid_email' => 'El %s debe tener un formato valido']
			);
			$this->form_validation->set_rules("perfil", "Perfil", "required", ['required' => 'Debe elegir el %s.']);
			if ($this->form_validation->run() == false) {
				$this->session->set_flashdata("danger", validation_errors());
				$data["datos"] = $this->Usuario_model->buscar_usuario($usu);
				$this->layout->view("editar", $data);
			} else {
				$d["nombres"]   = $this->input->post("nombres", true);
				$d["apellidos"] = $this->input->post("apellidos", true);
				$d["passfrase"] = $this->encript("pedidos2018");
				$d["telefono"]  = $this->input->post("telefono", true);
				$idPunto        = $this->input->post("punto_venta");
				$d["idPunto"]   = ($idPunto) ? $idPunto : null;
				$d["idPerfil"]  = $this->input->post("perfil");
				$d["activo"]    = $this->input->post("activo");
				if ($d["idPerfil"] == 2) {
					if ($d["idPunto"]) {
						$this->Usuario_model->update_usuario($usu, $d);
						if ($this->db->trans_status() == false) {
							$this->session->set_flashdata("danger", "No se pudo actualizar el usuario");
							$this->db->trans_rollback();
							$this->layout->view("editar", $data);
						} else {
							$this->db->trans_commit();
							header("Location: " . base_url("mantenimiento/usuarios"));
							$this->session->set_flashdata("success", "Usuario actualizado correctamente");
						}
					} else {
						$this->session->set_flashdata(
							"danger", "Para el perfil Punto de Venta debe elegir un punto de venta"
						);
						$this->db->trans_rollback();
						$this->layout->view("editar", $data);
					}
				} else {
					$this->Usuario_model->update_usuario($usu, $d);
					if ($this->db->trans_status() == false) {
						$this->session->set_flashdata("danger", "No se pudo actualizar el usuario");
						$this->db->trans_rollback();
					} else {
						$this->db->trans_commit();
						header("Location: " . base_url("mantenimiento/usuarios"));
						$this->session->set_flashdata("success", "Usuario actualizado correctamente");
					}
				}
			}
		}
	}

    /**
     * Encripta el password usando el metodo de seguridad mas reciente, defecto bcrypt
     * @param $passfrase
     *
     * @return bool|mixed|string
     */
	private function encript($passfrase)
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
