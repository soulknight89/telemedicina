<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Atencion extends MY_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('Doctores_model');
			$this->load->model('Atencion_model');
		}

		public function index()
		{
			$idUser = $this->usu_id;
			/*$data['usuario']        = $this->usu_id;
			$data['citasHoy']       = $this->Doctores_model->totalCitasDoctorHoy($idUser)[0]->total;
			$data['citasMes']       = $this->Doctores_model->totalCitasDoctorMes($idUser)[0]->total;
			$data['validarDoctor']  = $this->Doctores_model->buscarDoctor($idUser);       //citas como doctor
			$data['citasDoctor']    = $this->Doctores_model->leerCitasHoy($idUser);       //citas como doctor
			$data['especialidades'] = $this->Doctores_model->leerEspecialidades($idUser); //citas como doctor
			$data['citasPaciente']  = $this->Doctores_model->leerCitasHoyPac($idUser);    //citas como doctor
			$this->db->trans_commit();
			$this->layout->view("index", $data);*/
		}

		public function call($pac, $cita)
		{
			$data             = [];
			$data['idUser']   = $pac;
			$data['idCita']   = $cita;
			$data['paciente'] = $this->Atencion_model->buscar_paciente($pac)->paciente;
			$this->db->trans_commit();
			$this->layout->view("call", $data);
		}

		public function registrar_historia()
		{
			$data['idUser']          = $this->input->post('idUser');
			$data['idCita']          = $this->input->post('idCita');
			$data['anamnesis']       = $this->input->post('anamnesis');
			$data['diagnostico']     = $this->input->post('diagnostico');
			$data['tratamiento']     = $this->input->post('tratamiento');
			$data['procedimiento']   = $this->input->post('procedimiento');
			$data['recomendaciones'] = $this->input->post('recomendaciones');
			$res = $this->Atencion_model->leerHistoria($data['idCita']);
			if($res) {
				var_dump($res);
				$this->Atencion_model->actualizarHistoria($res->id, $data);
				//actualizar
			} else {
				$this->Atencion_model->registrarHistoria($data);
			}
			echo "1";
		}
	}
