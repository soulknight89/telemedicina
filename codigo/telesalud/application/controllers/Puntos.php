<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Puntos extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Puntos_model');
	}

	public function index()
	{
		$this->db->trans_commit();
		$data['usuario'] = (object) $this->session->userdata("ses");
		$data['puntos']  = $this->listarPuntos();
		$this->layout->view("index", $data);
	}

	public function nuevo()
	{
		$this->db->trans_commit();
		$data['usuario']       = (object) $this->session->userdata("ses");
		$data['departamentos'] = $this->Puntos_model->lista_departamentos();
		if (!$this->input->post()) {
			if ($this->db->trans_status() == false) {
				header("Location: " . base_url("mantenimiento/puntos"));
				$this->session->set_flashdata("danger", "No se pudo cargar la vista de nuevo punto de venta");
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
				$this->layout->view("nuevo", $data);
			}
		} else {
			$this->form_validation->set_rules(
				"nombre", "Nombre", "trim|required|min_length[4]|alpha_numeric_spaces", [
							'required'             => 'Debe ingresar los %s.',
							'min_length'           => '%s. debe tener al menos 4 caracteres',
							'alpha_numeric_spaces' => '%s solo acepta numeros y letras',
						]
			);
			$this->form_validation->set_rules(
				"codigo", "Codigo", "trim|required|min_length[3]|max_length[4]|alpha_numeric", [
							'required'      => 'Debe ingresar los %s.',
							'min_length'    => '%s. debe tener al menos 3 caracteres',
							'alpha_numeric' => '%s solo acepta numeros y letras',
						]
			);
			$this->form_validation->set_rules(
				"departamento", "Departamento", "trim|required", ['required' => 'Debe elegir el %s.']
			);
			$this->form_validation->set_rules(
				"provincia", "Provincia", "trim|required", ['required' => 'Debe elegir la %s.']
			);
			$this->form_validation->set_rules(
				"distrito", "Distrito", "required", ['required' => 'Debe elegir el %s.']
			);
			if ($this->form_validation->run() == false) {
				$this->session->set_flashdata("danger", validation_errors());
				$this->layout->view("nuevo", $data);
			} else {
				$codigo = $this->input->post('codigo');
				//validar_codigo_unico
				if ($this->validarCodigo($codigo)) {
					$d["nombre"]          = $this->input->post("nombre", true);
					$d["id_departamento"] = $this->input->post("departamento", true);
					$d["id_provincia"]    = $this->input->post("provincia");
					$d["id_distrito"]     = $this->input->post("distrito");
					$d["codigo"]          = $codigo;
					$puntoCreado          = $d["nombre"];
					$this->Puntos_model->create_punto($d);
					if ($this->db->trans_status() == false) {
						$this->session->set_flashdata(
							"danger", "No se pudo registrar el punto de venta, codigo existe en registro"
						);
						$this->db->trans_rollback();
					} else {
						$this->db->trans_commit();
						header("Location: " . base_url("mantenimiento/puntos"));
						$this->session->set_flashdata("success", "Punto de venta: $puntoCreado , creado correctamente");
					}
				} else {
					$this->session->set_flashdata("danger", "Codigo $codigo ya existe, ingrese un nuevo codigo");
					$this->layout->view("nuevo", $data);
				}
				$this->layout->view("nuevo", $data);
			}
		}
	}

	public function editar($id)
	{
		$this->db->trans_commit();
		$data['usuario']       = (object) $this->session->userdata("ses");
		$data['departamentos'] = $this->Puntos_model->lista_departamentos();
		$data['punto']         = $this->Puntos_model->buscar_punto($id);
		if (!$this->input->post()) {
			if ($this->db->trans_status() == false) {
				header("Location: " . base_url("mantenimiento/puntos"));
				$this->session->set_flashdata("danger", "No se pudo cargar la vista de editar punto de venta");
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
				$this->layout->view("editar", $data);
			}
		} else {
			$this->form_validation->set_rules(
				"nombre", "Nombre", "trim|required|min_length[4]|alpha_numeric_spaces", [
							'required'             => 'Debe ingresar los %s.',
							'min_length'           => '%s. debe tener al menos 4 caracteres',
							'alpha_numeric_spaces' => '%s solo acepta numeros y letras',
						]
			);
			$this->form_validation->set_rules(
				"departamento", "Departamento", "trim|required", ['required' => 'Debe elegir el %s.']
			);
			$this->form_validation->set_rules(
				"provincia", "Provincia", "trim|required", ['required' => 'Debe elegir la %s.']
			);
			$this->form_validation->set_rules(
				"distrito", "Distrito", "required", ['required' => 'Debe elegir el %s.']
			);
			if ($this->form_validation->run() == false) {
				$this->session->set_flashdata("danger", validation_errors());
				$this->layout->view("nuevo", $data);
			} else {
				$codigo = $this->input->post('codigo');
				//validar_codigo_unico
				$d["nombre"]          = $this->input->post("nombre", true);
				$d["id_departamento"] = $this->input->post("departamento", true);
				$d["id_provincia"]    = $this->input->post("provincia");
				$d["id_distrito"]     = $this->input->post("distrito");
				$d["activo"]          = $this->input->post("activo");
				$puntoCreado          = $d["nombre"];
				$this->Puntos_model->update_punto($id, $d);
				if ($this->db->trans_status() == false) {
					$this->session->set_flashdata(
						"danger", "No se pudo actualizar el punto de venta"
					);
					$this->db->trans_rollback();
				} else {
					$this->db->trans_commit();
					header("Location: " . base_url("mantenimiento/puntos"));
					$this->session->set_flashdata("success", "Punto de venta: $puntoCreado , modificado correctamente");
				}
			}
		}
	}

	/**
	 * Listar todos los puntos de venta registrados hasta el momento
	 *
	 * @param null $punto
	 *
	 * @return array
	 */
	public function listarPuntos($punto = null)
	{
		$data  = [];
		$datos = $this->Puntos_model->listar_puntos($punto);
		foreach ($datos as $doctor) {
			$id     = $doctor->idPunto;
			$url    = base_url('Puntos/editar/' . $id);
			$boton  = "<a class=\"btn btn-xs btn-primary\" href='$url' data-id=\"$id\" title='Editar Punto de Venta'><i class='fa fa-edit'></i></a>";
			$fila   = (object) [
				'nombre'       => $doctor->nombre,
				'departamento' => $doctor->departamento,
				'provincia'    => $doctor->provincia,
				'distrito'     => $doctor->distrito,
				'codigo'       => $doctor->codigo,
				'boton'        => $boton,
			];
			$data[] = $fila;
		}

		return $data;
	}

	/**
	 * funcion para listar las provincias como json
	 *
	 * @param $departamento
	 */
	public function buscarProvincias($departamento)
	{
		$this->db->trans_commit();
		$res = $this->Puntos_model->lista_provincias($departamento);
		header('Content-type: application/json; charset=UTF-8');
		echo json_encode($res);

	}

	/**
	 * funcion para listas los distritos como json
	 *
	 * @param $provincia
	 */
	public function buscarDistritos($provincia)
	{
		$this->db->trans_commit();
		$res = $this->Puntos_model->lista_distritos($provincia);
		header('Content-type: application/json; charset=UTF-8');
		echo json_encode($res);

	}

	/**
	 * funcion para validar si el codigo es usable
	 *
	 * @param $codigo
	 *
	 * @return bool
	 */
	public function validarCodigo($codigo)
	{
		$res = $this->Puntos_model->codigo_existe($codigo);
		if ($res && count($res) > 0) {
			//si el codigo existe el codigo es no valido entonces falso
			return false;
		} else {
			return true;
		}
	}
}
