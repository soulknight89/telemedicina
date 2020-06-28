<?php

class Pedidos_model extends CI_Model
{

	/**
	 * Leer las categorias registradas
	 * @return array
	 */
	public function leer_categoria()
	{
		$this->db->select("idCategoria id, nombre, descripcion", false);
		$this->db->from('or_productos_categoria');

		return $this->db->get()->result();
	}

	/**
	 * Leer los productos registrados
	 *
	 * @param mixed $tipo
	 *
	 * @return array
	 */
	public function leer_productos($tipo = null)
	{
		$this->db->select("idProducto id, nombre", false);
		$this->db->from('or_productos');
		if ($tipo) {
			$this->db->where('idCategoria', $tipo);
		}

		return $this->db->get()->result();
	}

	/**
	 * Retorna una lista de los tipos de pacientes
	 * @return array
	 */
	public function tipo_pacientes()
	{
		$this->db->select("idTipoCliente id, nombre, descripcion", false);
		$this->db->from('or_tipo_cliente');

		return $this->db->get()->result();
	}

	/**
	 * Retorna la lista de doctores que coincide con los parametros ingresados
	 *
	 * @param null $punto
	 * @param null $doctor
	 *
	 * @return array
	 */
	public function listar_doctores($punto = null, $doctor = null)
	{
		$this->db->select("idDoctor id, concat(nombres,' ',apellidos) as text", false);
		$this->db->from('or_doctor');
		if ($punto) {
			$this->db->where('idPunto', $punto);
		}
		if ($doctor) {
			$this->db->where("concat(nombres,' ',apellidos) like '%" . $doctor . "%'");
		}

		return $this->db->get()->result();
	}

	/**
	 * Crea el detalle del pedido en una tabla temporal hasta que se termine de registrar el pedido.
	 *
	 * @param $data
	 *
	 * @return string
	 */
	public function create_detalle_temporal($data)
	{
		$this->db->insert("temp_detalle", $data);

		return $this->db->insert_id();
	}

	/**
	 * Borra los registros temporales que se crearon para registrar el pedido
	 *
	 * @param $id
	 */
	public function borrar_item_temporal($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('temp_detalle');
	}

	public function leer_tabla_temporal($tiempo, $usuario)
	{
		$this->db->select("temp.*,prod.nombre", false);
		$this->db->from('temp_detalle temp');
		$this->db->join("or_productos prod", "temp.idProducto=prod.idProducto", "LEFT");
		$this->db->where('timestamp', $tiempo);
		$this->db->where('idUsuario', $usuario);

		return $this->db->get()->result();
	}

	public function leer_punto_doctor($id)
	{
		$this->db->select("idPunto", false);
		$this->db->from('or_doctor');
		$this->db->where('idDoctor', $id);

		return $this->db->get()->row();
	}

	public function crear_pedido($data)
	{
		$this->db->insert("or_pedidos", $data);

		return $this->db->insert_id();
	}

	public function crear_detalle_pedido($data)
	{
		$this->db->insert("or_detalle_pedido", $data);

		return $this->db->insert_id();
	}

	public function buscar_orden($orden)
	{
		$this->db->select("*", false);
		$this->db->from('or_pedidos');
		$this->db->where('codigoOrden', $orden);

		return $this->db->get()->result();
	}

	public function listar_pedidos($punto = null)
	{
		$this->db->select(
			"
			PED.idPedido,
            PED.idPunto,
            PED.codigoOrden AS codigo,
            date_format(PED.fechaOrden,'%d-%m-%Y') AS fecha_pedido, 
            concat(PAC.nombres,' ',PAC.apellidos) AS paciente,
            PUN.nombre AS punto_venta,
            PED.total,
            DET.items, 
            concat(USU.nombres,' ',USU.apellidos) AS responsable,
            PED.idEstado,
            EST.nombre as estado,
            PED.pagado, 
            PED.idUsuario", false
		);
		$this->db->from("or_pedidos PED");
		$this->db->join("or_usuarios USU", "PED.idUsuario = USU.idUsuario", "LEFT");
		$this->db->join("or_puntos_venta PUN", "PED.idPunto = PUN.idPunto", "LEFT");
		$this->db->join('or_pedidos_estado EST', 'PED.idEstado = EST.idEstado', 'LEFT');
		$this->db->join('or_clientes PAC', 'PED.idCliente = PAC.idCliente', 'LEFT');
		$this->db->join(
			"(SELECT count(*) as items, idPedido FROM or_detalle_pedido GROUP BY idPedido) AS DET",
			"PED.idPedido = DET.idPedido", "LEFT"
		);
		if ($punto != null) {
			$this->db->where("PED.idPunto", $punto);
		}

		return $this->db->get()->result();
	}

	public function leer_pedido($id)
	{
		$this->db->select(
			"
			PED.*,
            PED.codigoOrden AS codigo,
            date_format(PED.fechaOrden,'%d-%m-%Y') AS fecha_pedido,
            concat(USU.nombres,' ',USU.apellidos) AS responsable,
            concat(DOC.nombres,' ',DOC.apellidos) AS doctor,
            concat(PAC.nombres,' ',PAC.apellidos) AS paciente,  
            PUN.nombre AS punto_venta,
            DET.items,
            EST.nombre as estado", false
		);
		$this->db->from("or_pedidos PED");
		$this->db->join("or_usuarios USU", "PED.idUsuario = USU.idUsuario", "LEFT");
		$this->db->join("or_doctor DOC", "PED.idDoctor = DOC.idDoctor", "LEFT");
		$this->db->join("or_clientes PAC", "PED.idCliente = PAC.idCliente", "LEFT");
		$this->db->join("or_puntos_venta PUN", "PED.idPunto = PUN.idPunto", "LEFT");
		$this->db->join('or_pedidos_estado EST', 'PED.idEstado = EST.idEstado', 'LEFT');
		$this->db->join(
			"(SELECT count(*) as items, idPedido FROM or_detalle_pedido GROUP BY idPedido) AS DET",
			"PED.idPedido = DET.idPedido", "LEFT"
		);
		$this->db->where('PED.idPedido', $id);

		return $this->db->get()->row();
	}

	public function leer_detalles_pedido($id)
	{
		$this->db->select(
			"
			DET.*,
            PROD.nombre AS producto", false
		);
		$this->db->from("or_detalle_pedido DET");
		$this->db->join("or_productos PROD", "DET.idProducto = PROD.idProducto", "LEFT");
		$this->db->where('idPedido', $id);

		return $this->db->get()->result();
	}

    public function leer_observaciones($id)
    {
        $this->db->select(
            "
			concat(USU.nombres,' ',USU.apellidos) as usuario_registra,
			observacion,
			fechahora_observacion as fecha_observado,
			concat(USU2.nombres,' ',USU2.apellidos) as usuario_atiende,
			solucion,			
            fechahora_atencion as fecha_atencion", false
        );
        $this->db->from("or_pedidos_observaciones OBS");
        $this->db->join("or_usuarios USU", "OBS.idUsuario = USU.idUsuario", "LEFT");
        $this->db->join("or_usuarios USU2", "OBS.usuarioAtiende = USU2.idUsuario", "LEFT");
        $this->db->where('idPedido', $id);
        $this->db->group_by('idObservacion', $id);

        return $this->db->get()->result();
    }

	public function nueva_observacion($id, $usuario, $observacion)
	{
		$this->db->select('idObservacion', false);
		$this->db->from('or_pedidos_observaciones');
		$this->db->where('idPedido', $id);
		$this->db->where('fechahora_atencion is null');
		$res = $this->db->get()->result();
		if (count($res) > 0) {
			return null;
		} else {
			$data['idPedido']    = $id;
			$data['observacion'] = $observacion;
			$data['idUsuario']   = $usuario;
			$this->db->insert("or_pedidos_observaciones", $data);

			return $this->db->insert_id();
		}
	}

	/**
	 * Finaliza la observacion de un pedido, actualizando la fecha de atencion
	 *
	 * @param $id
	 * @param $data
	 * @return bool
	 */
	public function finalizar_observacion($data, $id)
	{
		date_default_timezone_set("America/Lima");
		$this->db->where("idPedido", $id);
		$this->db->where('fechahora_atencion is null');

		return $this->db->update("or_pedidos_observaciones", $data);
	}

	/**
	 * Actualizar pedido, recibe el id del pedido y pasa los parametros del array data
	 *
	 * @param $id
	 * @param $data
	 *
	 * @return bool
	 */
	public function update_pedido($id, $data)
	{
		$this->db->where("idPedido", $id);

		return $this->db->update("or_pedidos", $data);
	}

	/**
	 * Registra el log del estados por los que paso el pedido
	 *
	 * @param $data
	 *
	 * @return string
	 */
	public function insertar_log($data)
	{
		$this->db->insert("or_log_status", $data);

		return $this->db->insert_id();
	}

	/**
	 * Retorna el registro del detalle del pedido identificado con el idPedido $id
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function leer_detalle($id)
	{
		$this->db->select('*', false);
		$this->db->from('or_detalle_pedido');
		$this->db->where('idDetalle', $id);
		$this->db->limit(1);

		return $this->db->get()->row();
	}

	/**
	 * Retorna el total de tickets creados para un pedido
	 *
	 * @param $id
	 *
	 * @return int
	 */
	public function tickets_generados($id)
	{
		$this->db->select('idItem', false);
		$this->db->from('or_detalle_items');
		$this->db->where('idPedido', $id);

		return $this->db->get()->num_rows();
	}

	/**
	 * Retorna el codigo del punto de venta
	 *
	 * @param $punto
	 *
	 * @return mixed
	 */
	public function codigo_punto($punto)
	{
		$this->db->select('codigo', false);
		$this->db->from('or_puntos_venta');
		$this->db->where('idPunto', $punto);

		return $this->db->get()->row();
	}

	/**
	 * Inserta un registro de ticket
	 *
	 * @param $data
	 *
	 * @return string
	 */
	public function insertar_ticket($data)
	{
		$this->db->insert("or_detalle_items", $data);

		return $this->db->insert_id();
	}

	/**
	 * Actualiza el detalle del pedido para identificar que items no entraran a atenderse
	 *
	 * @param $pedido
	 * @param $lista
	 * @param $motivo
	 *
	 * @return bool
	 */
	public function excluir_ticket($pedido, $lista, $motivo)
	{
		$data['rechazado']      = 1;
		$data['motivo_rechazo'] = $motivo;
		$this->db->where("idDetalle not in ($lista)");
		$this->db->where('idPedido', $pedido);

		return $this->db->update("or_detalle_pedido", $data);
	}

	/**
	 * Devuelve los tickets creados para una orden de pedido
	 *
	 * @param $id
	 *
	 * @return array
	 */
	public function tabla_tickets($id)
	{
		$this->db->select(
			'IT.idItem as id, PROD.nombre as producto, DET.detalle, IT.codigoItem as ticket, ENVIO.idEnvioDetalle as enviado'
		);
		$this->db->from('or_detalle_items IT');
		$this->db->join("or_detalle_pedido DET", "IT.idDetalle = DET.idDetalle", "LEFT");
		$this->db->join("or_productos PROD", "DET.idProducto = PROD.idProducto", "LEFT");
		$this->db->join("or_envios_detalle ENVIO", "IT.idItem = ENVIO.idItem", "LEFT");
		$this->db->where('IT.idPedido', $id);

		return $this->db->get()->result();
	}

	/**
	 * Crea el detalle de la anulacion del pedido.
	 *
	 * @param $data
	 *
	 * @return string
	 */
	public function create_anulacion($data)
	{
		$this->db->insert("or_pedidos_anulados", $data);

		return $this->db->insert_id();
	}

	/**
	 * Listar los motivos de los rechazos
	 * @return array
	 */
	public function listar_motivos()
	{
		$this->db->select('idMotivo as id, motivo', false);
		$this->db->from('or_motivos_anulacion');

		return $this->db->get()->result();
	}
}
