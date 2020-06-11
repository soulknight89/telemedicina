<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctores extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Doctores_model');
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
		//$data['puntos']  = $this->Puntos_model->puntos_venta();
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
				"nombres", "Nombres", "trim|required", ['required' => 'Debe ingresar los %s.']
			);
			$this->form_validation->set_rules(
				"apellidos", "Apellidos", "trim|required", ['required' => 'Debe ingresar los %s.']
			);
			$this->form_validation->set_rules(
				"colegiatura", "Colegiatura", "trim|required", ['required' => 'Debe ingresar la %s.']
			);
			if ($this->form_validation->run() == false) {
				$this->session->set_flashdata("danger", validation_errors());
				$this->layout->view("nuevo", $data);
			} else {
				$d["nombres"]     = $this->input->post("nombres", true);
				$d["apellidos"]   = $this->input->post("apellidos", true);
				$d["idDocumento"] = 1;
				$d["documento"]   = $this->input->post("colegiatura", true);
				$doctor           = $this->Doctores_model->buscar_documento($d["documento"]);
				if ($doctor) {
					header("Location: " . base_url("Doctores/nuevo"));
					$this->session->set_flashdata(
						"danger", "No se pudo registrar el doctor, Colegiatura existe en registro"
					);
					$this->layout->view("nuevo", $data);
				} else {
					$this->Doctores_model->create_doctor($d);
					if ($this->db->trans_status() == false) {
						$this->session->set_flashdata(
							"danger", "No se pudo registrar el doctor, Colegiatura existe en registro"
						);
						$this->db->trans_rollback();
					} else {
						$this->db->trans_commit();
						header("Location: " . base_url("mantenimiento/doctores"));
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
}
