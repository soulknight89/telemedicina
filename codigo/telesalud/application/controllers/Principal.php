<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Principal extends MY_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('Doctores_model');
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
			$this->db->trans_commit();
			$this->layout->view("index", $data);
		}
	}
