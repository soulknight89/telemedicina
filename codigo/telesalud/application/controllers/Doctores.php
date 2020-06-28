<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctores extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Doctores_model');
		$this->load->model('Usuario_model');
		//$this->load->model('Puntos_model');
	}

	public function index()
	{
		$this->db->trans_commit();
		$data['doctores'] = $this->listarDoctores();
		$this->layout->view("index", $data);
	}

	public function nuevo()
	{
		//$this->layout->setLayout("clear");
		$this->db->trans_commit();
		$data['usuario'] = (object) $this->session->userdata("ses");
		if (!$this->input->post()) {
			if ($this->db->trans_status() == false) {
				header("Location: " . base_url("mantenimiento/doctores"));
				$this->session->set_flashdata("danger", "No se pudo cargar la vista de nuevo doctor");
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
				$this->layout->view("nuevo", $data);
			}
		} else {
			$this->form_validation->set_rules(
				"primer_nombre", "Primer Nombre", "trim|required", ['required' => 'Debe ingresar el campo %s.']
			);
			$this->form_validation->set_rules(
				"apellido_paterno", "Apellido Paterno", "trim|required", ['required' => 'Debe ingresar el campo %s.']
			);
			$this->form_validation->set_rules(
				"tipo_documento", "Tipo de documento", "trim|required", ['required' => 'Debe ingresar el campo %s.']
			);
			$this->form_validation->set_rules(
				"nro_documento", "Nro. de documento", "trim|required", ['required' => 'Debe ingresar el campo %s.']
			);
			$this->form_validation->set_rules(
				"colegiatura", "Colegiatura", "trim|required", ['required' => 'Debe ingresar el campo %s.']
			);
			if ($this->form_validation->run() == false) {
				$this->session->set_flashdata("danger", validation_errors());
				$this->layout->view("nuevo", $data);
			} else {
				$d["nombre_primer"]    = $this->input->post("primer_nombre", true);
				$d["nombre_segundo"]   = $this->input->post("segundo_nombre", true);
				$d["apellido_primer"]  = $this->input->post("apellido_paterno", true);
				$d["apellido_segundo"] = $this->input->post("apellido_materno", true);
				$d["idTipoDocumento"]  = $this->input->post("tipo_documento", true);
				$d["numero_documento"] = $this->input->post("tipo_documento", true);
				$idUsuario             = $this->input->post("usuario", true);
				$doc["idDoctor"]       = $idUsuario;
				$doc["colegiatura"]    = $this->input->post("colegiatura", true);
				$doc["validado"]       = 1;
				$doctor                = $this->Doctores_model->buscar_documento($doc["colegiatura"]);
				if ($doctor) {
					header("Location: " . base_url("Doctores/nuevo"));
					$this->session->set_flashdata(
						"danger", "No se pudo registrar el doctor, Colegiatura existe en registro"
					);
					$this->layout->view("nuevo", $data);
				} else {
					$this->Usuario_model->update_usuario($idUsuario, $d);
					$this->Doctores_model->create_doctor($doc);
					$especialidades = $this->input->post("especialidades", true);
					if($especialidades) {
						$list = json_decode($especialidades);
						if($list && count($list) > 0) {
							foreach ($list as $esp) {
								$arr = ['idTipoEspecialidad' => $esp->tipo_especialidad,
								        'idDoctor' => $idUsuario,
								        'codigo' => $esp->codigo,
								        'nombre' => $esp->nombre,
								        'certificacion' => $esp->certificacion];
								$this->Doctores_model->create_especialidad($arr);
							}
						}
					}
					if ($this->db->trans_status() == false) {
						$this->session->set_flashdata(
							"danger", "No se pudo registrar el doctor, Colegiatura existe en registro"
						);
						$this->db->trans_rollback();
					} else {
						$this->db->trans_commit();
						header("Location: " . base_url("Principal"));
						$this->session->set_flashdata("success", "Doctor registrado correctamente");
					}
				}
			}
		}
	}

	public function editar($id)
	{
		$this->db->trans_commit();
		$data['usuario'] = (object) $this->session->userdata("ses");
		$data['puntos']  = $this->Puntos_model->puntos_venta();
		$data['doctor']  = $this->Doctores_model->buscar_doctor($id);
		if (!$this->input->post()) {
			if ($this->db->trans_status() == false) {
				header("Location: " . base_url("mantenimiento/doctores"));
				$this->session->set_flashdata("danger", "No se pudo cargar la vista de editar doctor");
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
				"colegiatura", "Colegiatura", "trim|required", ['required' => 'Debe ingresar la %s.']
			);
			$this->form_validation->set_rules(
				"punto", "Punto de Venta", "required", ['required' => 'Debe elegir el %s.']
			);
			if ($this->form_validation->run() == false) {
				$this->session->set_flashdata("danger", validation_errors());
				$this->layout->view("editar", $data);
			} else {
				$d["nombres"]     = $this->input->post("nombres", true);
				$d["apellidos"]   = $this->input->post("apellidos", true);
				$d["idPunto"]     = $this->input->post("punto");
				$d["idDocumento"] = 1;
				$d["documento"]   = $this->input->post("colegiatura", true);
				$doctor           = $this->Doctores_model->buscar_documento($d["documento"]);
				if ($doctor && $doctor->idDoctor != $id) {
					header("Location: " . base_url("Doctores/editar/$id"));
					$this->session->set_flashdata(
						"danger", "No se pudo cambiar la colegiatura, la colegiatura existe en registro"
					);
					$this->layout->view("editar", $data);
				} else {
					$this->Doctores_model->update_doctor($id, $d);
					if ($this->db->trans_status() == false) {
						$this->session->set_flashdata(
							"danger", "No se pudo registrar el doctor, Colegiatura existe en registro"
						);
						$this->db->trans_rollback();
					} else {
						$this->db->trans_commit();
						header("Location: " . base_url("mantenimiento/doctores"));
						$this->session->set_flashdata("success", "Doctor actualizado correctamente");
					}
				}
			}
		}
	}

	public function listarDoctores($punto = null)
	{
		$data  = [];
		$datos = $this->Doctores_model->listar_doctores($punto);
		foreach ($datos as $doctor) {
			$id     = $doctor->idDoctor;
			$url    = base_url('Doctores/editar/' . $id);
			$boton  = "<a class=\"btn btn-xs btn-primary\" href='$url' data-id=\"$id\"><i class='fa fa-edit'></i></a>";
			$fila   = (object) [
				'nombres'     => $doctor->nombres,
				'apellidos'   => $doctor->apellidos,
				'documento'   => $doctor->documento,
				'punto_venta' => $doctor->punto_venta,
				'boton'       => $boton,
			];
			$data[] = $fila;
		}

		return $data;
	}

	public function limpiarTextoCMP($texto) {
		$texto = preg_replace("/<br>|\n|\r/", "", $texto);
		$texto =  preg_replace("/<tr>/", "", $texto);
		$texto =  preg_replace("/<\/tr>/", "", $texto);
		$texto =  preg_replace("/<\/body>/", "", $texto);
		return trim(preg_replace("/<\/td>/", "", $texto));
	}

	public function validarCMP($cmp) {
		$url = "https://200.48.13.39/cmp/php/detallexmedico.php?id=" . $cmp; //direccion web - cisisego
		$ch  = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		$response = curl_exec($ch);
		curl_close($ch);
		preg_match('/<div id="wrapper">(.*?)<\/div>/s', $response, $match);
		//tabla 1: Datos de nombre
		preg_match('/<table id="simple-example-table1" cellspacing="0">(.*?)<\/table>/s', $match[1], $tabla1);
		preg_match('/<tr>(.*?)<\/tr>/s', $tabla1[1], $detalle1);
		$parts    = explode('<td>', trim($detalle1[1]));
		$apellido = str_replace("</td>", '', $parts[2]);
		$apellido = preg_replace("/<br>|\n|\r/", "", $apellido);
		$apellido = trim($apellido);
		$nombre   = str_replace("</td>", '', $parts[3]);
		$nombre   = preg_replace("/<br>|\n|\r/", "", $nombre);
		$nombre   = trim($nombre);
		preg_match('/<td>(.*?)<\/td>/s', $detalle1[1], $nombres1);
		//tabla 2: Datos de foto
		preg_match('/<table id="simple-example-table2" cellspacing="0">(.*?)<\/table>/s', $match[1], $tablaDatos2);
		//tabla 3: Datos de especialidades
		preg_match('/<table id="simple-example-table4" cellspacing="0">(.*?)<\/table>/s', $match[1], $tablaEspecialidad);
		header('Content-type: application/json; charset=UTF-8');
		if($nombre) {
			$listaEspecialidad = [];
			$especialidades    = explode('<td>', trim($tablaEspecialidad[1]));
			$eliminado         = array_shift($especialidades);
			if(count($especialidades) > 0) {
				$totalEsp = count($especialidades);
				$rondas = $totalEsp / 4;
				$n = 1;
				$grupos = [];
				$arr = [];
				for($i = 0; $i < $rondas; $i++) {
					$suma = ($n == 1) ? 0 : 4;
					$grupos[] = [
						'nombre' => $this->limpiarTextoCMP($especialidades[0 + $suma]),
						'tipo_especialidad' => $this->limpiarTextoCMP($especialidades[1 + $suma]),
						'codigo' => $this->limpiarTextoCMP($especialidades[2 + $suma]),
						'certificacion' => $this->limpiarTextoCMP($especialidades[3 + $suma])
						];
					$n++;
				}
				$listaEspecialidad = $grupos;
			}
			echo json_encode(['error' => 0, 'nombres' => $nombre, 'apellidos' => $apellido, 'foto' => 'https://200.48.13.39/cmp/php/fotos/' . $cmp . '.jpg', 'especialidades' => $listaEspecialidad]);
		} else {
			echo json_encode(['error' => 1,'mensaje'=> 'Codigo no valido']);
		}
	}

	public function horarios() {
		$data             = [];
		$idDoc            = $this->usu_id;
		$data['dias']     = $this->Doctores_model->leerDias();
		$data['horarios'] = $this->Doctores_model->horariosDoctor($idDoc);
		if ($this->input->post()) {
			$datos['horaInicio'] = $this->input->post('hora_inicio');
			$datos['horaFin']    = $this->input->post('hora_fin');
			$diasx               = $this->input->post('dias');
			if ($diasx && count($diasx) > 0) {
				//buscar dia y doctor si existe solo actualizar, si no existe crear
				if ($datos['horaInicio'] > $datos['horaFin']) {
					$this->session->set_flashdata("danger", "Debe elegir al menos un dia");
				} else {
					foreach ($diasx as $dias) {
						$res = $this->Doctores_model->buscarExisteHorario($idDoc, $dias);
						if ($res && count($res) == 1) {
							$registro         = $res[0]->idHorario;
							$actualizar       = $this->Doctores_model->actualizarHorarioDoctor($registro, $datos);
						} else {
							$datos['idDia']    = $dias;
							$datos['idDoctor'] = $idDoc;
							$insertado         = $this->Doctores_model->registrarHorarioDoctor($datos);
						}
					}
					$data['horarios'] = $this->Doctores_model->horariosDoctor($idDoc);
				}
			} else {
				$this->session->set_flashdata("danger", "Debe elegir al menos un dia");
			}
		}
		$this->layout->view("Horarios", $data);
	}

	public function nextcitas() {
		$data          = [];
		$idDoc         = $this->usu_id;
		$data['citas'] = $this->Doctores_model->leerCitasFuturas($idDoc);
		$this->layout->view("futurasCitas", $data);
	}

	public function pastcitas() {
		$data          = [];
		$idDoc         = $this->usu_id;
		$data['citas'] = $this->Doctores_model->leerCitasAntiguas($idDoc);
		$this->layout->view("antiguasCitas", $data);
	}
}
