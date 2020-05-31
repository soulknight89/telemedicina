<?php

class Puntos_model extends CI_Model
{
	/**
	 * Crear Punto de Venta
	 *
	 * @param $data
	 *
	 * @return string
	 */
	public function create_punto($data)
	{
		$this->db->insert("or_puntos_venta", $data);
		if ($this->db->insert_id()) {
			return $this->db->insert_id();
		} else {
			return 'error';
		}
	}

	/**
	 * Function: Actualizar Punto de venta
	 * Description: Realiza la actualizacion de datos del punto de venta del id $id
	 *
	 * @param $id
	 * @param $data
	 *
	 * @return bool
	 */
	public function update_punto($id, $data)
	{
		$this->db->where("idPunto", $id);

		return $this->db->update("or_puntos_venta", $data);
	}


	/**
	 * Devuelve la lista de puntos de venta
	 * @return array
	 */
	public function puntos_venta()
	{
		$this->db->select("idPunto as id, nombre", false);
		$this->db->from("or_puntos_venta");
		$this->db->where('activo', 1);

		return $this->db->get()->result();
	}

	/**
	 * Listar puntos asociados a combos de distrito / provincia/ departamento
	 * @return array
	 */
	public function listar_puntos()
	{
		$this->db->select("PUN.*, DEP.nombre as departamento, PROV.nombre as provincia, DIS.nombre as distrito", false);
		$this->db->from("or_puntos_venta PUN");
		$this->db->join("or_departamentos DEP", "PUN.id_departamento = DEP.id_departamento", 'left');
		$this->db->join("or_provincias PROV", "PUN.id_provincia = PROV.id_provincia", 'left');
		$this->db->join("or_distritos DIS", "PUN.id_distrito = DIS.id_distrito", 'left');
		$this->db->where('activo', 1);

		return $this->db->get()->result();
	}

	/**
	 * Retorna una lista de departamentos
	 * @return array
	 */
	public function lista_departamentos()
	{
		$this->db->select("id_departamento as id, nombre", false);
		$this->db->from("or_departamentos");

		return $this->db->get()->result();
	}

	/**
	 * Retorna una lista de provincias en base al departamento
	 *
	 * @param $departamento
	 *
	 * @return array
	 */
	public function lista_provincias($departamento)
	{
		$this->db->select("id_provincia as id, nombre", false);
		$this->db->from("or_provincias");
		$this->db->where('id_departamento', $departamento);

		return $this->db->get()->result();
	}

	/**
	 * retorna una lista de distritos en base a la provincia
	 *
	 * @param $provincia
	 *
	 * @return array
	 */
	public function lista_distritos($provincia)
	{
		$this->db->select("id_distrito as id, nombre", false);
		$this->db->from("or_distritos");
		$this->db->where('id_provincia', $provincia);

		return $this->db->get()->result();
	}

	/**
	 * Verifica si ya existe un codigo de punto de venta
	 *
	 * @param $codigo
	 *
	 * @return array
	 */
	public function codigo_existe($codigo)
	{
		$this->db->select("*", false);
		$this->db->from("or_puntos_venta");
		$this->db->where('codigo', $codigo);

		return $this->db->get()->result();
	}

	/**
	 * Busca los datos especificos de un punto de venta
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function buscar_punto($id)
	{
		$this->db->select("*", false);
		$this->db->from("or_puntos_venta");
		$this->db->where('idPunto', $id);
		$this->db->limit(1);

		return $this->db->get()->row();
	}
}
