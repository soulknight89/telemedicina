<?php

class Reportes_model extends CI_Model
{
	/**
	 * Leer indicador calidad de los pedidos generados
	 *
	 * @param  int $mes
	 *
	 * @return array
	 */
	public function calidad($mes, $anio)
	{
		$this->db->select(
			"date_format(fechaOrden,'%d-%m-%Y') as fecha, count(idPedido) as total, count(if(observado = 1,1,null)) as incidencias",
			false
		);
		$this->db->from('or_pedidos');
		$this->db->where('idEstado not in (10,7)');
		$this->db->where('month(generado)', $mes);
		$this->db->where('year(generado)', $anio);
		$this->db->group_by('fechaOrden');

		return $this->db->get()->result();
	}

    public function entregas($mes, $anio)
    {
        $this->db->select(
            "date(fecha_envio) as fecha_envio, count(fecha_envio)total, count(if(fecha_envio <= date_add(date(generado),interval 1 day ),1,null)) as cumple",
            false
        );
        $this->db->from('or_pedidos');
//        $this->db->where('idEstado not in (10,7)');
//        $this->db->where('fecha_envio is not null');
        $this->db->where('month(fecha_envio)', $mes);
        $this->db->where('year(fecha_envio)', $anio);
        $this->db->group_by('fecha_envio');
        $this->db->order_by("fecha_envio", "asc");

        return $this->db->get()->result();
    }
}
