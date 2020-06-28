<?php
/**
 * Created by PhpStorm.
 * User: Edwin
 * Date: 15/09/2018
 * Time: 14:03
 */

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Hook_sesion
{

	private $ci;

	public function __construct()
	{
		$this->ci = &get_instance();
		!$this->ci->load->library('session') ? $this->ci->load->library('session') : false;
		!$this->ci->load->helper('url') ? $this->ci->load->helper('url') : false;
		//var_dump($this->ci->session->userdata("ses"));
	}

	public function check_login()
	{
		$activo = $this->ci->session->userdata("ses");
		$seg = $this->ci->uri->segment(1);
		if($activo) {
			if($seg) {
				//var_dump($seg);
				//var_dump($this->ci->session->userdata("ses"));
				switch ($seg) {
					case 'Login':
						redirect(base_url("Principal"));
				}
			} else {
				redirect(base_url("Principal"));
			}
		} else {
//			var_dump($seg);
			if($seg && $seg!='Login') {
				redirect(base_url());
			}
		}

		/*$seg = $this->ci->uri->segment(1);
		$ses = $this->ci->session->userdata("ses");*/
		/*if(!$ses) {
			if($seg != NULL && in_array($seg,['Login','ingresar'])) {
				redirect(base_url());
			}
		} else {
			if($seg == NULL || in_array($seg,['Login'])) {
				redirect(base_url("Principal"));
			}
		}*/
		/*if(!$ses) {
			redirect(base_url("ingresar"));
		} else {
			$per = $ses["usu_perfil"];
		}*/
	}

	public function save_log()
	{
		$ses = $this->ci->session->userdata("ses");
		if ($ses != false) {
			$seccion = $uri = uri_string();
			$partes  = explode('/', $seccion);
			if (!in_array($partes[0], ['js', 'css', 'img'])) {
				$ajax = explode('-', $seccion);
				if (!in_array($ajax[0], ['ajax'])) {
					$ip      = $_SERVER['REMOTE_ADDR'];
					$ses     = (object) $ses;
					$usuario = $ses->usu_id;
					$this->ci->db->query(
						"INSERT INTO registro_actividad VALUES (DEFAULT,'$usuario','$seccion','$ip',NOW())"
					);
				}
			}
		}
	}

}

/*
/end hooks/home.php
*/
