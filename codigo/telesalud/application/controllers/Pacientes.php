<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pacientes extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pacientes_model');
	}

	public function index()
	{
		$this->db->trans_commit();
		$data['pacientes'] = $this->tabla_pacientes();
		$this->layout->view("index", $data);
	}

	public function nuevo()
	{
		$this->db->trans_commit();
		$data['usuario'] = (object) $this->session->userdata("ses");
		if (!$this->input->post()) {
			if ($this->db->trans_status() == false) {
				header("Location: " . base_url("mantenimiento/pacientes"));
				$this->session->set_flashdata("danger", "No se pudo cargar la vista de nuevo paciente");
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
			if ($this->form_validation->run() == false) {
				$this->session->set_flashdata("danger", validation_errors());
				$this->layout->view("nuevo", $data);
			} else {
				$d["nombres"]       = $this->input->post("nombres", true);
				$d["apellidos"]     = $this->input->post("apellidos", true);
				$d["telefono"]      = $this->input->post("telefono", true);
				$d["idTipoCliente"] = 2; //solo debe existir un cliente stock
				$this->Pacientes_model->create_paciente($d);
				if ($this->db->trans_status() == false) {
					$this->session->set_flashdata("danger", "No se pudo registrar el Paciente");
					$this->db->trans_rollback();
				} else {
					$this->db->trans_commit();
					header("Location: " . base_url("mantenimiento/pacientes"));
					$this->session->set_flashdata("success", "Paciente registrado correctamente");
				}
			}
		}
	}

	public function editar($id)
	{
		$this->db->trans_commit();
		$data['usuario']  = (object) $this->session->userdata("ses");
		$data['paciente'] = $this->Pacientes_model->leer_paciente($id);
		if (!$this->input->post()) {
			if ($this->db->trans_status() == false) {
				header("Location: " . base_url("mantenimiento/pacientes"));
				$this->session->set_flashdata("danger", "No se pudo cargar la vista de nuevo paciente");
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
			if ($this->form_validation->run() == false) {
				$this->session->set_flashdata("danger", validation_errors());
				$this->layout->view("editar", $data);
			} else {
				$d["nombres"]   = $this->input->post("nombres", true);
				$d["apellidos"] = $this->input->post("apellidos", true);
				$d["telefono"]  = $this->input->post("telefono", true);
				$this->Pacientes_model->update_paciente($id, $d);
				if ($this->db->trans_status() == false) {
					$this->session->set_flashdata("danger", "No se pudo registrar el Paciente");
					$this->db->trans_rollback();
				} else {
					$this->db->trans_commit();
					header("Location: " . base_url("mantenimiento/pacientes"));
					$this->session->set_flashdata("success", "Paciente registrado correctamente");
				}
			}
		}
	}

	public function tabla_pacientes()
	{
		$data  = [];
		$datos = $this->Pacientes_model->leer_pacientes();
		foreach ($datos as $paciente) {
			$id     = $paciente->idCliente;
			$url    = base_url('Pacientes/editar/' . $id);
			$boton  = "<a class=\"btn btn-xs btn-primary\" href='$url' data-id=\"$id\"><i class='fa fa-edit'></i></a>";
			$fila   = (object) [
				'nombres'   => $paciente->nombres,
				'apellidos' => $paciente->apellidos,
				'telefono'  => $paciente->telefono,
				'boton'     => $boton,
			];
			$data[] = $fila;
		}

		return $data;
	}

	public function listarPacientes($tipo = null)
	{
		$paciente = $this->input->post('paciente');
		header('Content-type: application/json; charset=UTF-8');
		echo json_encode($this->Pacientes_model->listar_pacientes($tipo, $paciente));
	}
}
