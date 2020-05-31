<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

	public $usu_id;
	public $per_id;
	public $per_nom;

	public function __construct()
	{
		parent::__construct();
		$this->layout->setLayout("frontend");
		$ses           = $this->session->userdata("ses");
		$this->usu_id  = $ses["usu_id"];
		$this->per_id  = $ses["usu_perfil"];
		$this->per_nom = $ses["per_nombre"];
	}

	public function objetoFechaHora($date, $delimiter = '-')
	{
		$objeto = (object) [
			'dia'      => null,
			'mes'      => null,
			'anio'     => null,
			'fecha'    => null,
			'hora'     => null,
			'minuto'   => null,
			'segundo'  => null,
			'tiempo'   => null,
			'completo' => null,
			'fechaES'  => null,
		];
		if ($date != null && $date != '') {
			$objeto->completo = $date;
			$fh               = explode(' ', $date);
			if (count($fh) > 1) {
				$objeto->tiempo  = $fh[1];
				$objeto->fecha   = $fh[0];
				$fecha           = explode($delimiter, $objeto->fecha);
				$objeto->dia     = $fecha[2];
				$objeto->mes     = $fecha[1];
				$objeto->anio    = $fecha[0];
				$hora            = explode(':', $objeto->tiempo);
				$objeto->segundo = $hora[2];
				$objeto->minuto  = $hora[1];
				$objeto->hora    = $hora[0];
				$objeto->fechaES = $fecha[2] . $delimiter . $fecha[1] . $delimiter . $fecha[0];
			} elseif (count($fh) == 1) {
				$objeto->fecha   = $fh[0];
				$fecha           = explode($delimiter, $objeto->fecha);
				$objeto->dia     = $fecha[2];
				$objeto->mes     = $fecha[1];
				$objeto->anio    = $fecha[0];
				$objeto->fechaES = $fecha[2] . $delimiter . $fecha[1] . $delimiter . $fecha[0];
			}
		}

		return $objeto;
	}

	public function registro_cambio($estado, $pedido)
	{
		$this->db->insert('', ['idEstado' => $estado, 'idUsuario' => $this->usu_id, 'idPedido' => $pedido]);
	}
}
