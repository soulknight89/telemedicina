<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Principal extends MY_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('Doctores_model');
			$this->load->model('Pacientes_model');
			$this->load->model('Usuario_model');
		}

		public function index()
		{
			$idUser                 = $this->usu_id;
			$data['usuario']        = $this->usu_id;
			$data['citasHoy']       = $this->Doctores_model->totalCitasDoctorHoy($idUser)[0]->total;
			$data['citasMes']       = $this->Doctores_model->totalCitasDoctorMes($idUser)[0]->total;
			$data['validarDoctor']  = $this->Doctores_model->buscarDoctor($idUser);       //citas como doctor
			$data['citasDoctor']    = $this->Doctores_model->leerCitasHoy($idUser);       //citas como doctor
			$data['especialidades'] = $this->Doctores_model->leerEspecialidades($idUser); //citas como doctor
			$data['citasPaciente']  = $this->Doctores_model->leerCitasHoyPac($idUser);    //citas como doctor
			$data['datosPaciente']  = $this->Pacientes_model->leerDatosPaciente($idUser);
			$this->db->trans_commit();
			$this->layout->view("index", $data);
		}

		public function misdatos()
		{
			$data['idUsu']        = $this->usu_id;
			$data['usuario']      = $this->usu_id;
			$data['datosUsuario'] = $this->Usuario_model->buscar_usuario($this->usu_id);
			$this->db->trans_commit();
			$this->layout->view("misdatos", $data);
		}

		public function actualizarfoto()
		{
			$data['usuario']      = $this->usu_id;
			$data['idUsu']        = $this->usu_id;
			$data['datosUsuario'] = $this->Usuario_model->buscar_usuario($this->usu_id);
			if ($_FILES && count($_FILES) > 0) {
				$insert = [];
				if (!file_exists($_FILES['fotoperfil']['tmp_name']) || !is_uploaded_file($_FILES['fotoperfil']['tmp_name'])) {
					echo "no existe";
					$this->session->set_flashdata("danger", 'No se adjunta archivo');
				} else {
					echo "entro";
					$filename             = $_FILES['fotoperfil']['name'];
					$file                 = $_FILES['fotoperfil']['tmp_name'];
					$insert['fotoperfil'] = $filename;
					$existe               = $this->Usuario_model->update_usuario($this->usu_id, $insert);
					if ($existe) {
						$targetDir = './pacfls/fotos/' . $this->usu_id . '/';
						if (!file_exists($targetDir)) {
							mkdir($targetDir, 0777, true);
						}
						move_uploaded_file($file, $targetDir . $filename);
					} else {
						$this->session->set_flashdata("danger", 'No se pudo actualizar la foto');
					}
				}
			}
			header("Location: " . base_url("Principal/misdatos"));
		}

		public function actualizardatos()
		{
			$data['usuario']      = $this->usu_id;
			$data['idUsu']        = $this->usu_id;
			$data['datosUsuario'] = $this->Usuario_model->buscar_usuario($this->usu_id);
			$insert               = $this->input->post();
			$this->Usuario_model->update_usuario($this->usu_id, $insert);
			header("Location: " . base_url("Principal/misdatos"));
		}
	}
