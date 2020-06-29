<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Atencion extends MY_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('Doctores_model');
			$this->load->model('Atencion_model');
			$this->load->model('Pacientes_model');
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
			$data['paciente'] = $this->Atencion_model->buscar_paciente($cita)->paciente;
			$this->db->trans_commit();
			$this->layout->view("call", $data);
		}

		public function nuevacita()
		{
			$data                   = [];
			$data['idUsu']          = $this->usu_id;
			$data['pacientes']      = $this->Pacientes_model->leerDatosPaciente($this->usu_id);
			$data['especialidades'] = $this->Atencion_model->leerEspecialidades();
			$this->db->trans_commit();
			$this->layout->view("nuevacita", $data);
		}

		public function buscar_citas()
		{
			$fecha        = $this->input->post('dia');
			$especialidad = $this->input->post('especialidad');
			$diasemana    = date('w', strtotime($fecha));
			if ($especialidad != 1) {
				$posibles = $this->Atencion_model->leerDoctoresPorDia($diasemana, $especialidad); //buscar que doctores atienden ese dia de la semana y luego buscar la especialidad
			} else {
				$posibles = $this->Atencion_model->leerDoctoresPorDiaSin($diasemana); //buscar que doctores atienden ese dia de la semana y luego buscar la especialidad
			}
			if ($posibles) {
				$listar   = [];
				$duracion = 20; // 20 minutos por consulta
				foreach ($posibles as $doctor) {
					$id         = $doctor->idDoctor;
					$codigo     = $doctor->colegiatura;
					$nombre     = trim($doctor->nombre_primer . ' ' . $doctor->nombre_segundo . ' ' . $doctor->apellido_primer . ' ' . $doctor->apellido_segundo);
					$nombre     = preg_replace('!\s+!', ' ', $nombre);
					$horaInicio = $doctor->horaInicio;
					$horaFin    = $doctor->horaFin;
					$timeInicio = DateTime::createFromFormat('H:i:s', $horaInicio);
					$timeFin    = DateTime::createFromFormat('H:i:s', $horaFin);
					$horas      = [];
					while ($timeInicio < $timeFin) {
						$actual         = [];
						$intervalo      = 'PT' . $duracion . 'M';
						$strtime        = $timeInicio;
						$objeto         = (object)[];
						$objeto->inicio = $strtime->format('H:i');
						$actual['hora'] = $objeto->inicio;
						$endtime        = $strtime->add(new DateInterval($intervalo));
						$objeto->fin    = $endtime->format('H:i');
						$valid          = $this->Atencion_model->validarDisponibilidadHora($fecha, $objeto->inicio, $id);
						if (!$valid) {
							$actual['disponible'] = 1;
						} else {
							$actual['disponible'] = 0;
						}
						$horas[] = $actual;
					}
					$listar[] = ['id' => $id, 'codigo' => $codigo, 'doctor' => $nombre, 'horarios' => $horas];
				}
				header('Content-type: application/json; charset=UTF-8');
				echo json_encode(['error' => 0, 'msj' => 'exito', 'data' => $listar]);
			} else {
				header('Content-type: application/json; charset=UTF-8');
				echo json_encode(['error' => 1, 'msj' => 'No se encontraron doctores disponibles para los datos ingresados']);
			}
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
			$res                     = $this->Atencion_model->leerHistoria($data['idCita']);
			if ($res) {
				$this->Atencion_model->actualizarHistoria($res->id, $data);
			} else {
				$this->Atencion_model->registrarHistoria($data);
			}
			echo "1";
		}

		public function agendar_cita()
		{
			$data = $this->input->post();
			$res  = $this->Atencion_model->validarDisponibilidadHora($data['fechaCita'], $data['horaInicio'], $data['idDoctor']);
			if ($res) {
				echo "1";
			} else {
				$data['enlaceAtencion'] = md5($data['idPaciente']);
				$this->Atencion_model->registrarCitaMedica($data);
				echo "0";
			}
		}
	}
