<?php

	class Atencion_model extends CI_Model
	{
		/**
		 * Function: Leer nombre paciente
		 * Description: Busca datos del paciente identificado con el id $usu
		 *
		 * @param $usu
		 *
		 * @return object
		 */
		public function buscar_paciente($usu)
		{
			$this->db->select("PAC.idPaciente, concat(PAC.nombres,' ', PAC.apellidos) as paciente", false);
			$this->db->from("pac_citas CIT");
			$this->db->join('usr_paciente PAC', 'CIT.idPaciente = PAC.idPaciente');
			$this->db->where("CIT.idCita", $usu);

			return $this->db->get()->row();
		}

		public function leerHistoria($cita)
		{
			$this->db->select("idDetalleCita as id", false);
			$this->db->from("cit_detalle");
			$this->db->where("idCita", $cita);

			return $this->db->get()->row();
		}

		public function registrarHistoria($data)
		{
			$this->db->insert("cit_detalle", $data);

			return $this->db->insert_id();
		}

		public function actualizarHistoria($cita, $data)
		{
			$this->db->where("idDetalleCita", $cita);

			return $this->db->update("cit_detalle", $data);
		}

		/**
		 * Leer especialidades registradas
		 * @return array|array[]|object|object[]
		 */
		public function leerEspecialidades()
		{
			$this->db->select('nombre');
			$this->db->from('usr_doctor_especialidad');
			$this->db->where('idTipoEspecialidad', 'RNE');
			return $this->db->get()->result();
		}

		/**
		 * Busca los doctores por dia y especialidad
		 * @param $dia
		 * @param $especialidad
		 * @return array|array[]|object|object[]
		 */
		public function leerDoctoresPorDia($dia, $especialidad)
		{
			$this->db->select('DOC.idDoctor, 
					DOC.colegiatura,
					USR.nombre_primer,
					USR.nombre_segundo,
					USR.apellido_primer,
					USR.apellido_segundo, 
					ESP.nombre AS especialidad,
					HOR.horaInicio,
					HOR.horaFin');
			$this->db->from('usr_doctor_especialidad ESP');
			$this->db->join('usr_doctor DOC', 'ESP.idDoctor = DOC.idDoctor', 'LEFT');
			$this->db->join('usr_usuarios USR', 'DOC.idDoctor = USR.idUser', 'LEFT');
			$this->db->join('doc_horarios HOR', 'DOC.idDoctor = HOR.idDoctor', 'LEFT');
			$this->db->where('idTipoEspecialidad', 'RNE');
			$this->db->where('ESP.nombre', $especialidad);
			$this->db->where('HOR.idDia', $dia);
			return $this->db->get()->result();
		}

		/**
		 * Buscar doctor solo como medico general
		 * @param $dia
		 * @return array|array[]|object|object[]
		 */
		public function leerDoctoresPorDiaSin($dia)
		{
			$this->db->select("DOC.idDoctor, 
					DOC.colegiatura,
					USR.nombre_primer,
					USR.nombre_segundo,
					USR.apellido_primer,
					USR.apellido_segundo, 
					'MEDICINA GENERAL' AS especialidad,
					HOR.horaInicio,
					HOR.horaFin");
			$this->db->from('usr_doctor DOC');
			$this->db->join('usr_usuarios USR', 'DOC.idDoctor = USR.idUser', 'LEFT');
			$this->db->join('doc_horarios HOR', 'DOC.idDoctor = HOR.idDoctor', 'LEFT');
			$this->db->where('HOR.idDia', $dia);
			return $this->db->get()->result();
		}

		/**
		 * Validar si una cita esta disponible o no
		 * @param $fecha
		 * @param $hora
		 * @param $doctor
		 * @return array|array[]|object|object[]
		 */
		function validarDisponibilidadHora($fecha, $hora, $doctor)
		{
			$this->db->select('*');
			$this->db->from('pac_citas');
			$this->db->where('fechaCita', $fecha);
			$this->db->where('horaInicio', $hora);
			$this->db->where('idDoctor', $doctor);
			return $this->db->get()->result();
		}

		/**
		 * Registra una nueva cita medica
		 * @param $data array
		 * @return int|string
		 */
		function registrarCitaMedica($data)
		{
			$this->db->insert("pac_citas", $data);

			return $this->db->insert_id();
		}

		/**
		 * Function: Crear usuario
		 * Description: Envia los parametros en el data para poder crear el usuario retorna el id creado
		 *
		 * @param $data
		 *
		 * @return mixed
		 */
		public function create_usuario($data)
		{
			$this->db->insert("usr_usuarios", $data);

			return $this->db->insert_id();
		}

		/**
		 * Function: Actualizar Usuario
		 * Description: Realiza la actualizacion de datos de usuario del id $usu
		 *
		 * @param $usu
		 * @param $data
		 *
		 * @return bool
		 */
		public function update_usuario($usu, $data)
		{
			$this->db->where("idUser", $usu);

			return $this->db->update("usr_usuarios", $data);
		}

		/**
		 * Function: Buscar datos
		 * Description: Busca datos del usuario identificado con el id $usu
		 *
		 * @param $usu
		 *
		 * @return object
		 */
		public function buscar_usuario($usu)
		{
			$this->db->select("*", false);
			$this->db->from("or_usuarios");
			$this->db->where("idUsuario", $usu);

			return $this->db->get()->row();
		}

		/**
		 * Function: login
		 * Description: Iniciar sesion
		 * @string $u
		 * @string $p
		 * return object
		 */
		public function login($u = null, $p = null)
		{
			$this->db->select(
				"
            USU.idUsuario, 
            USU.email, 
            USU.nombres,  
            USU.apellidos, 
            USU.telefono, 	
            USU.idPunto,
            USU.idPerfil,	
            PER.nombre AS perfil,
            PUN.nombre AS punto_venta", false
			);
			$this->db->from("or_usuarios USU");
			$this->db->join("or_usuarios_perfiles PER", "USU.idPerfil = PER.idPerfil", "LEFT");
			$this->db->join("or_puntos_venta PUN", "USU.idPunto = PUN.idPunto", "LEFT");
			$this->db->where("USU.estado", 1);
			$this->db->where("USU.email", $u);
			$this->db->where("USU.passfrase", $p);
			$this->db->limit(1);

			return $this->db->get()->row();
		}

		/**
		 * function loginHash
		 * @param $user
		 *
		 * @return object
		 */
		public function loginHash($user)
		{
			$this->db->select(
				"
            USU.idUser as idUsuario, 
            USU.email, 
            concat(USU.nombre_primer,' ', USU.nombre_segundo) as nombres,
            USU.nombre_primer,
            USU.nombre_segundo,            
            USU.password as passfrase,
            concat(USU.apellido_primer,' ', USU.apellido_segundo) as apellidos,
            USU.apellido_primer,
            USU.apellido_segundo,
            concat(USU.nombre_primer,' ', USU.apellido_primer) as nombre_mostrar,
            USU.telefono, 	
            USU.idPerfil,
            PER.nombre AS perfil", false
			);
			$this->db->from("usr_usuarios USU");
			$this->db->join("usr_perfiles PER", "USU.idPerfil = PER.idPerfil", "LEFT");
			$this->db->where("USU.estado", 1);
			$this->db->where("USU.email", $user);
			$this->db->limit(1);

			return $this->db->get()->row();
		}

		/**
		 * Function: Buscar Perfiles
		 * Description: Envia los parametros y obtiene una lista de los perfiles
		 *
		 * @param $data
		 *
		 * @return mixed
		 */
		public function listar_perfiles()
		{
			$this->db->select("idPerfil, nombre", false);
			$this->db->from("or_usuarios_perfiles");
			$this->db->where('estado', 1);

			return $this->db->get()->result();
		}

		/**
		 * Devuelve la lista de puntos de venta
		 * @return array
		 */
		public function puntos_venta()
		{
			$this->db->select("idPunto, nombre", false);
			$this->db->from("or_puntos_venta");
			$this->db->where('activo', 1);

			return $this->db->get()->result();
		}

		/**
		 * Devuelve la lista de usuarios
		 *
		 * @param mixed $p
		 *
		 * @return array
		 */
		public function listarUsuarios($p = null)
		{
			$this->db->select(
				"
            USU.idUsuario, 
            USU.email, 
            USU.nombres,  
            USU.apellidos, 
            USU.telefono, 	
            USU.idPunto,
            USU.idPerfil,
            USU.activo,	
            PER.nombre AS perfil,
            PUN.nombre AS punto_venta", false
			);
			$this->db->from("or_usuarios USU");
			$this->db->join("or_usuarios_perfiles PER", "USU.idPerfil = PER.idPerfil", "LEFT");
			$this->db->join("or_puntos_venta PUN", "USU.idPunto = PUN.idPunto", "LEFT");
			if ($p != null) {
				$this->db->where("USU.idPerfil", $p);
			}

			return $this->db->get()->result();
		}

		/**
		 * Verifica si ya existe un correo registrado
		 *
		 * @param $correo
		 *
		 * @return array
		 */
		public function correo_existe($correo)
		{
			$this->db->select("*", false);
			$this->db->from("usr_usuarios");
			$this->db->where('email', $correo);

			return $this->db->get()->result();
		}

	}
