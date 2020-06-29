<?php

	class Pacientes_model extends CI_Model
	{
		/**
		 * Registrar un paciente
		 * @param mixed $data
		 * @return mixed
		 */
		public function nuevoPaciente($data)
		{
			$this->db->insert("usr_paciente", $data);

			return $this->db->insert_id();
		}

		/**
		 * Leer si existen datos de paciente creados por el usuario
		 * @param $id
		 * @return mixed
		 */
		public function leerDatosPaciente($id)
		{
			$this->db->select("*");
			$this->db->from('usr_paciente');
			$this->db->where('usucrea', $id);

			return $this->db->get()->result();
		}

		/**
		 * Leer si existen datos de paciente que coincidan con el documento y el tipo de documento
		 * @param $tipodoc
		 * @param $numdoc
		 * @return mixed
		 */
		public function buscarPacienteDocumento($tipodoc, $numdoc)
		{
			$this->db->select("*");
			$this->db->from('usr_paciente');
			$this->db->where('tipodoc', $tipodoc);
			$this->db->where('numdoc', $numdoc);

			return $this->db->get()->result();
		}


		/**
		 * Leer los pacientes registrados
		 *
		 * @param mixed $tipo
		 * @param mixed $filtro
		 *
		 * @return array
		 */
		public function listar_pacientes($tipo = null, $filtro = null)
		{
			$this->db->select("idCliente id, concat(nombres,' ',apellidos) as text", false);
			$this->db->from('or_clientes');
			if ($tipo) {
				$this->db->where('idTipoCliente', $tipo);
			}
			if ($filtro) {
				$this->db->where("concat(nombres,' ',apellidos) like '%" . $filtro . "%'");
			}

			return $this->db->get()->result();
		}

		/**
		 * Leer los pacientes registrados
		 *
		 * @return array
		 */
		public function leer_pacientes()
		{
			$this->db->select("idCliente, nombres, apellidos, telefono", false);
			$this->db->from('or_clientes');
			$this->db->where('idTipoCliente != 1');

			return $this->db->get()->result();
		}

		/**
		 * Leer paciente segun el id indicado
		 *
		 * @param int $id
		 *
		 * @return array
		 */
		public function leer_paciente($id)
		{
			$this->db->select("idCliente, nombres, apellidos, telefono", false);
			$this->db->from('or_clientes');
			$this->db->where('idCliente', $id);

			return $this->db->get()->row();
		}


		/**
		 * Function: Actualizar Paciente
		 * Description: Realiza la actualizacion de datos del paciente del id $id
		 *
		 * @param $id
		 * @param $data
		 *
		 * @return bool
		 */
		public function update_paciente($id, $data)
		{
			$this->db->where("idCliente", $id);

			return $this->db->update("or_clientes", $data);
		}
	}
