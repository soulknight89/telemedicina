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

	/**
	 * Function: Listar dias
	 * Description: Realiza la actualizacion de datos del Doctor del id $id
	 *
	 * @return mixed
	 */
	public function leerDias() {
		$this->db->select("idDia as id, nombre", false);
		$this->db->from("gen_dias");

		return $this->db->get()->result();
	}

	/**
	 * Function: Listar dias
	 * Description: Realiza la actualizacion de datos del Doctor del id $id
	 * @param $idDoctor int
	 *
	 * @return mixed
	 */
	public function horariosDoctor($idDoctor) {
		$this->db->select("HOR.idHorario, HOR.idDia, DIA.nombre as dia, HOR.horaInicio, HOR.horaFin, HOR.activo", false);
		$this->db->from("doc_horarios HOR");
		$this->db->join('gen_dias DIA', 'HOR.idDia = DIA.idDia', 'LEFT');
		$this->db->where("HOR.idDoctor", $idDoctor);
		$this->db->order_by("HOR.idDia ASC");

		return $this->db->get()->result();
	}

	public function buscarExisteHorario($idDoctor, $idDia) {
		$this->db->select("HOR.idHorario", false);
		$this->db->from("doc_horarios HOR");
		$this->db->where("idDoctor", $idDoctor);
		$this->db->where("idDia", $idDia);

		return $this->db->get()->result();
	}

	public function registrarHorarioDoctor($data) {
		$this->db->insert("doc_horarios", $data);
		if ($this->db->insert_id()) {
			return $this->db->insert_id();
		} else {
			return 'error';
		}
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
	public function actualizarHorarioDoctor($id, $data)
	{
		$this->db->where("idHorario", $id);

		return $this->db->update("doc_horarios", $data);
	}

	public function leerCitasFuturas($idDoctor) {
		$this->db->select("CIT.idCita, concat(PAC.nombre_primer,' ',PAC.apellido_primer) as paciente, 
		CIT.fechaCita as dia, CIT.horaInicio as hora, CIT.enlaceAtencion as enlace ", false);
		$this->db->from("pac_citas CIT");
		$this->db->join('usr_usuarios PAC', 'CIT.idPaciente = PAC.idUser', 'LEFT');
		$this->db->where("CIT.idDoctor", $idDoctor);
		$this->db->where("CIT.atendido", 0);
		$this->db->where("CIT.fechaCita >= CURDATE()");

		return $this->db->get()->result();
	}

	public function leerCitasAntiguas($idDoctor) {
		$this->db->select("CIT.idCita, concat(PAC.nombre_primer,' ',PAC.apellido_primer) as paciente, 
		CIT.fechaCita as dia, CIT.horaInicio as hora, CIT.enlaceAtencion as enlace ", false);
		$this->db->from("pac_citas CIT");
		$this->db->join('usr_usuarios PAC', 'CIT.idPaciente = PAC.idUser', 'LEFT');
		$this->db->where("CIT.idDoctor", $idDoctor);
		$this->db->where("CIT.atendido", 0);
		$this->db->where("CIT.fechaCita < CURDATE()");

		return $this->db->get()->result();
	}

	public function leerEspecialidades($idDoctor) {
		$this->db->select("ESP.*, PAC.nombre as nombreEspecialidad", false);
		$this->db->from("usr_doctor_especialidad ESP");
		$this->db->join('doc_tipo_especialidad PAC', 'ESP.idTipoEspecialidad = PAC.idTipoEspecialidad', 'LEFT');
		$this->db->where("ESP.idDoctor", $idDoctor);

		return $this->db->get()->result();
	}

	public function leerCitasHoy($idDoctor) {
		$this->db->select("CIT.idCita, concat(PAC.nombre_primer,' ',PAC.apellido_primer) as paciente, PAC.idUser as idPaciente,
		CIT.fechaCita as dia, CIT.horaInicio as hora, CIT.enlaceAtencion as enlace, if(CIT.atendido=0 AND CIT.horaInicio <= CURRENT_TIME(), 1, 0) as valido", false);
		$this->db->from("pac_citas CIT");
		$this->db->join('usr_usuarios PAC', 'CIT.idPaciente = PAC.idUser', 'LEFT');
		$this->db->where("CIT.idDoctor", $idDoctor);
		$this->db->where("CIT.atendido", 0);
		$this->db->where("CIT.fechaCita = CURDATE()");

		return $this->db->get()->result();
	}

	public function leerCitasHoyPac($idPac) {
		$this->db->select("CIT.idCita, concat(PAC.nombre_primer,' ',PAC.apellido_primer) as paciente, PAC.idUser as idUsuario,
		CIT.fechaCita as dia, CIT.horaInicio as hora, CIT.enlaceAtencion as enlace, if(CIT.atendido=0 AND CIT.horaInicio <= CURRENT_TIME(), 1, 0) as valido", false);
		$this->db->from("pac_citas CIT");
		$this->db->join('usr_usuarios PAC', 'CIT.idDoctor = PAC.idUser', 'LEFT');
		$this->db->where("CIT.idPaciente", $idPac);
		$this->db->where("CIT.atendido", 0);
		$this->db->where("CIT.fechaCita = CURDATE()");

		return $this->db->get()->result();
	}

	public function buscarDoctor($idDoctor) {
		$this->db->select("*", false);
		$this->db->from("usr_doctor DOC");
		$this->db->where("DOC.idDoctor", $idDoctor);

		return $this->db->get()->result();
	}

	public function totalCitasDoctorHoy($idDoctor) {
		$this->db->select("count(*) as total", false);
		$this->db->from("pac_citas CIT");
		$this->db->where("CIT.idDoctor", $idDoctor);
		$this->db->where("CIT.fechaCita = CURDATE()");

		return $this->db->get()->result();
	}

	public function totalCitasDoctorMes($idDoctor) {
		$this->db->select("count(*) as total", false);
		$this->db->from("pac_citas CIT");
		$this->db->where("CIT.idDoctor", $idDoctor);
		$this->db->where("month(CIT.fechaCita) = month(CURDATE())");
		$this->db->where("year(CIT.fechaCita) = year(CURDATE())");

		return $this->db->get()->result();
	}
}
