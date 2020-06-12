<?php

class Doctores_model extends CI_Model
{
	/**
	 * Crear Doctor
	 *
	 * @param $data
	 *
	 * @return string
	 */
	public function create_doctor($data)
	{
		$this->db->insert("usr_doctor", $data);
		if ($this->db->insert_id()) {
			return $this->db->insert_id();
		} else {
			return 'error';
		}
	}

	/**
	 * Function: Buscar datos
	 * Description: Busca datos del doctor identificado con el documento $doc
	 *
	 * @param $doc
	 *
	 * @return object
	 */
	public function buscar_documento($doc)
	{
		$this->db->select("*", false);
		$this->db->from("usr_doctor");
		$this->db->where("colegiatura", $doc);

		return $this->db->get()->row();
	}

	public function create_especialidad($data)
	{
		$this->db->insert("usr_doctor_especialidad", $data);
		if ($this->db->insert_id()) {
			return $this->db->insert_id();
		} else {
			return 'error';
		}
	}

	/**
	 * Function: Buscar datos
	 * Description: Busca datos del doctor identificado con el id $id
	 *
	 * @param $id
	 *
	 * @return object
	 */
	public function buscar_doctor($id)
	{
		$this->db->select("*", false);
		$this->db->from("or_doctor");
		$this->db->where("idDoctor", $id);

		return $this->db->get()->row();
	}

	/**
	 * Function: Actualizar Doctor
	 * Description: Realiza la actualizacion de datos del Doctor del id $id
	 *
	 * @param $id
	 * @param $data
	 *
	 * @return bool
	 */
	public function update_doctor($id, $data)
	{
		$this->db->where("idDoctor", $id);

		return $this->db->update("or_doctor", $data);
	}

	public function listar_doctores($punto = null)
	{
		$this->db->select("DOC.*, PUN.nombre AS punto_venta", false);
		$this->db->from("or_doctor DOC");
		$this->db->join('or_puntos_venta PUN', 'DOC.idPunto = PUN.idPunto', 'LEFT');
		if ($punto) {
			$this->db->where("DOC.idPunto", $punto);
		}

		return $this->db->get()->result();
	}
}
