<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Productos_model');
	}

	public function index()
	{
		$this->db->trans_commit();
		$data['productos'] = $this->tabla_productos();
		$this->layout->view("index", $data);
	}

	public function nuevo()
	{
		$this->db->trans_commit();
		$data['usuario'] = (object) $this->session->userdata("ses");
		if (!$this->input->post()) {
			if ($this->db->trans_status() == false) {
				header("Location: " . base_url("Productos"));
				$this->session->set_flashdata("danger", "No se pudo cargar la vista de nuevo producto");
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
				$this->layout->js(
					[
						template_url("js/priceformat/jquery.priceformat.min.js"),
					]
				);
				$this->layout->view("nuevo", $data);
			}
		} else {
			$this->form_validation->set_rules(
				"nombre", "Nombre", "trim|required", ['required' => 'Debe ingresar el %s del producto']
			);
			$this->form_validation->set_rules(
				"descripcion", "Descripcion", "trim|required", ['required' => 'Debe ingresar la %s del producto']
			);
			$this->form_validation->set_rules(
				"precio", "Precio Sugerido", "trim|required|numeric", ['required' => 'Debe ingresar el %s.','numeric' =>'El %s debe ser un numero']
			);
			if ($this->form_validation->run() == false) {
				$this->layout->js(
					[
						template_url("js/priceformat/jquery.priceformat.min.js"),
					]
				);
				$this->session->set_flashdata("danger", validation_errors());
				$this->layout->view("nuevo", $data);
			} else {
				$d["nombre"]         = $this->input->post("nombre", true);
				$d["descripcion"]    = $this->input->post("descripcion", true);
				$d["precioUnitario"] = $this->input->post("precio", true);
				$d["idCategoria"]    = 1; //solo se pueden añadir productos a la categoria catalogo
				$this->Productos_model->create_producto($d);
				if ($this->db->trans_status() == false) {
					$this->session->set_flashdata("danger", "No se pudo registrar el Producto");
					$this->db->trans_rollback();
				} else {
					$this->db->trans_commit();
					header("Location: " . base_url("Productos"));
					$this->session->set_flashdata("success", "Producto registrado correctamente");
				}
			}
		}
	}

	public function editar($id)
	{
		$this->db->trans_commit();
		$data['usuario'] = (object) $this->session->userdata("ses");
		$data['producto'] = $this->Productos_model->leer_producto($id);
		if (!$this->input->post()) {
			if ($this->db->trans_status() == false) {
				header("Location: " . base_url("Productos"));
				$this->session->set_flashdata("danger", "No se pudo cargar la vista de actualizar producto");
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
				$this->layout->js(
					[
						template_url("js/priceformat/jquery.priceformat.min.js"),
					]
				);
				$this->layout->view("editar", $data);
			}
		} else {
			$this->form_validation->set_rules(
				"nombre", "Nombre", "trim|required", ['required' => 'Debe ingresar el %s del producto']
			);
			$this->form_validation->set_rules(
				"descripcion", "Descripcion", "trim|required", ['required' => 'Debe ingresar la %s del producto']
			);
			$this->form_validation->set_rules(
				"precio", "Precio Sugerido", "trim|required|numeric", ['required' => 'Debe ingresar el %s.','numeric' =>'El %s debe ser un numero']
			);
			if ($this->form_validation->run() == false) {
				$this->layout->js(
					[
						template_url("js/priceformat/jquery.priceformat.min.js"),
					]
				);
				$this->session->set_flashdata("danger", validation_errors());
				$this->layout->view("editar", $data);
			} else {
				$d["nombre"]         = $this->input->post("nombre", true);
				$d["descripcion"]    = $this->input->post("descripcion", true);
				$d["precioUnitario"] = $this->input->post("precio", true);
				$this->Productos_model->update_producto($id, $d);
				if ($this->db->trans_status() == false) {
					$this->session->set_flashdata("danger", "No se pudo actualizar el Producto");
					$this->db->trans_rollback();
				} else {
					$this->db->trans_commit();
					header("Location: " . base_url("Productos"));
					$this->session->set_flashdata("success", "Producto actualizado correctamente");
				}
			}
		}
	}

	public function tabla_productos()
	{
		$data  = [];
		$datos = $this->Productos_model->listar_productos();
		foreach ($datos as $producto) {
			$id     = $producto->idProducto;
			$url    = base_url('Productos/editar/' . $id);
			$boton  = "<a class=\"btn btn-xs btn-primary\" href='$url' data-id=\"$id\"><i class='fa fa-edit'></i></a>";
			$fila   = (object) [
				'nombre'      => $producto->nombre,
				'descripcion' => $producto->descripcion,
				'precio'      => $producto->precio,
				'boton'       => $boton,
			];
			$data[] = $fila;
		}

		return $data;
	}
}
