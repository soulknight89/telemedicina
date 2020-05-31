<?php

class Envios_model extends CI_Model
{
    /**
     * Registrar un envio
     *
     * @param mixed $data
     *
     * @return mixed
     */
    public function create_envio($data)
    {
        $this->db->insert("or_envios", $data);

        return $this->db->insert_id();
    }

    /**
     * Actualizar un envio
     *
     * @param mixed $data
     * @param int   $id
     *
     * @return mixed
     */
    public function update_envio($id, $data)
    {
        $this->db->where('idEnvio', $id);
        $this->db->update("or_envios", $data);

        return $this->db->insert_id();
    }

    /**
     * Retorna el detalle de un envio
     *
     * @param $id
     *
     * @return array
     */
    public function detalle_envio($id)
    {
        $this->db->select(
            "ENVI.*, concat(USU.nombres,' ',USU.apellidos) as persona, PUN.nombre as local, date_format(ENVI.fecha_envio,'%d-%m-%Y') as fecha, EST.nombre as estado_envio"
        );
        $this->db->from('or_envios ENVI');
        $this->db->join("or_envios_estado EST", "ENVI.idEstadoEnvio = EST.idEstadoEnvio", "LEFT");
        $this->db->join("or_usuarios USU", "ENVI.idUsuario = USU.idUsuario", "LEFT");
        $this->db->join("or_puntos_venta PUN", "ENVI.idPunto = PUN.idPunto", "LEFT");
        $this->db->where('ENVI.idEnvio', $id);
        $this->db->limit(1);

        return $this->db->get()->row();
    }

    /**
     * Retorna el detalle de un envio
     *
     * @param $id
     *
     * @return array
     */
    public function detalle_items_pedido($id)
    {
        $this->db->select(
            "IT.*, PED.codigoOrden as orden, ENVI.idItem as itemEnvio"
        );
        $this->db->from('or_detalle_items IT');
        $this->db->join("or_pedidos PED", "IT.idPedido = PED.idPedido", "LEFT");
        $this->db->join("or_puntos_venta PUN", "PED.idPunto = PUN.idPunto", "LEFT");
        $this->db->join("or_envios_detalle ENVI", "IT.idItem = ENVI.idItem", "LEFT");
        $this->db->where('PED.idPunto', $id);
        $this->db->where('ENVI.idItem is NULL');
        $this->db->group_by('PED.codigoOrden');

        return $this->db->get()->result();
    }

    /**
     * Retorna el detalle de los items de un pedido que aun no cuentan con un grupo de envio
     *
     * @param $id
     *
     * @return array
     */
    public function items_pedido($id)
    {
        $this->db->select(
            "IT.*, 
			PED.codigoOrden as orden, 
			if(DETA.idProducto=3,DETA.detalle,PROD.nombre) as producto, 
			ENVI.idItem as itemEnvio"
        );
        $this->db->from('or_detalle_items IT');
        $this->db->join("or_pedidos PED", "IT.idPedido = PED.idPedido", "LEFT");
        $this->db->join("or_puntos_venta PUN", "PED.idPunto = PUN.idPunto", "LEFT");
        $this->db->join("or_detalle_pedido DETA", "IT.idDetalle = DETA.idDetalle", "LEFT");
        $this->db->join("or_productos PROD", "DETA.idProducto = PROD.idProducto", "LEFT");
        $this->db->join("or_envios_detalle ENVI", "IT.idItem = ENVI.idItem", "LEFT");
        $this->db->where('PED.idPedido', $id);
        $this->db->where('ENVI.idItem is NULL');

        return $this->db->get()->result();
    }

    /**
     * Verificar si existe el item en el detalle de envios
     *
     * @param $item
     *
     * @return mixed
     */
    public function existe_item($item)
    {
        $this->db->select("idEnvioDetalle", false);
        $this->db->from("or_envios_detalle");
        $this->db->where("idItem", $item);
        $this->db->limit(1);

        return $this->db->get()->row();
    }

    /**
     * Agregar Items al envio
     *
     * @param $data
     *
     * @return string
     */
    public function agregar_items($data)
    {
        $this->db->insert("or_envios_detalle", $data);

        return $this->db->insert_id();
    }

    /**
     * Items que existen en el envio de id $id
     *
     * @param $id
     *
     * @return array
     */
    public function items_pedido_envio($id)
    {
        $this->db->select(
            "DETE.*, PED.codigoOrden as orden, 
			IT.codigoItem as ticket,
			date_format(PED.fechaOrden,'%d-%m-%Y') as fechaPedido, 
			if(DETP.idProducto=3,DETP.detalle,PROD.nombre) as producto, 
			concat(CLI.nombres,' ',CLI.apellidos) as paciente"
        );
        $this->db->from('or_envios_detalle  DETE');
        $this->db->join("or_detalle_items IT", "DETE.idItem = IT.idItem", "LEFT");
        $this->db->join("or_pedidos PED", "IT.idPedido = PED.idPedido", "LEFT");
        $this->db->join("or_clientes CLI", "PED.idCliente = CLI.idCliente", "LEFT");
        $this->db->join("or_detalle_pedido DETP", "IT.idDetalle = DETP.idDetalle", "LEFT");
        $this->db->join("or_productos PROD", "DETP.idProducto = PROD.idProducto", "LEFT");
        $this->db->where('DETE.idEnvio', $id);

        return $this->db->get()->result();
    }

    /**
     * Retorna todos los pedidos registrados por un punto en caso sea diferente de null, sino lista todo
     *
     * @param $idPunto
     *
     * @return array
     */
    public function envios_registrados($idPunto)
    {
        $this->db->select(
            "ENV.*,
			date_format(fecha_envio,'%d-%m-%Y') as fecha,
			date_format(fecha_procesado,'%d-%m-%Y') as fecha_procesado,
			EST.nombre as estado_envio,
			PUN.nombre as local"
        );
        $this->db->from('or_envios ENV');
        $this->db->join("or_envios_estado EST", "ENV.idEstadoEnvio = EST.idEstadoEnvio", "LEFT");
        $this->db->join("or_puntos_venta PUN", "ENV.idPunto = PUN.idPunto", "LEFT");
        if ($idPunto) {
            $this->db->where('ENV.idPunto', $idPunto);
        }

        return $this->db->get()->result();
    }

    public function eliminar_item($item)
    {
        $this->db->where('idEnvioDetalle', $item);
        $this->db->delete('or_envios_detalle');
    }

    public function procesar_envio($id, $usuario)
    {
        $this->update_envio($id, ['fecha_procesado' => date('Y-m-d'), 'idEstadoEnvio' => 2]);
        $datos['fechahora']     = date('Y-m-d H:i:s');
        $datos['idEnvio']       = $id;
        $datos['idEstadoEnvio'] = 2;
        $datos['idUsuario']     = $usuario;
        $this->nuevo_log($datos);
    }

    public function leer_pedidos_envio()
    {
        $this->db->select("idPedido, count(idItem) as total, count(idEnvio) as totalEnvios, MAX(idEnvio) as envio, MAX(fecha_envio) as fecha_envio, MAX(fecha_procesado) as fecha_procesado, MIN(idEstadoEnvio) idEstadoEnvio");
        $this->db->from("relacion_pedidos_envios");
        $this->db->group_by("idPedido");
        return $this->db->get()->result();
    }

    public function actualiza_pedido_envio($data, $id)
    {
        $this->db->where('idPedido', $id);

        return $this->db->update("or_pedidos", $data);
    }

    public function nuevo_log($data)
    {
        $this->db->insert("or_log_envios", $data);

        return $this->db->insert_id();
    }
}
