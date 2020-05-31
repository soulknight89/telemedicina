<?php

class Productos_model extends CI_Model
{
	/**
	 * Leer los productos registrados, se omite el producto formula magistral
	 *
	 * @return array
	 */
	public function listar_productos()
	{
		$this->db->select("idProducto, nombre, descripcion, precioUnitario as precio", false);
		$this->db->from('or_productos');
		$this->db->where('idCategoria', 1);

		return $this->db->get()->result();
	}

	/**
	 * Leer el producto identificado con id $id
	 *
	 * @param integer $id
	 *
	 * @return array
	 */
	public function leer_producto($id)
	{
		$this->db->select("idProducto, nombre, descripcion, precioUnitario as precio", false);
		$this->db->from('or_productos');
		$this->db->where('idProducto', $id);

		return $this->db->get()->row();
	}

	/**
	 * Registrar un producto
	 *
	 * @param mixed $data
	 *
	 * @return mixed
	 */
	public function create_producto($data)
	{
		$this->db->insert("or_productos", $data);

		return $this->db->insert_id();
	}

	/**
	 * Actualizar un producto
	 *
	 * @param mixed $data
	 * @param int   $prod
	 *
	 * @return mixed
	 */
	public function update_producto($prod, $data)
	{
		$this->db->where("idProducto", $prod);

		return $this->db->update("or_productos", $data);
	}
}
