<?php
/**
 * Created by PhpStorm.
 * User: Edwin
 * Date: 5/10/2018
 * Time: 20:59
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Envios extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Envios_model');
		$this->load->model('Puntos_model');
	}

	public function index()
	{
		$user            = (object) $this->session->userdata("ses");
		$punto           = $user->usu_punto;
		$data['usuario'] = $user;
		$data['envios']  = $this->listarEnvios($punto);
		$this->layout->view("index", $data);
	}

	public function nuevo()
	{
		$this->db->trans_commit();
		$data              = [];
		$data['timestamp'] = time();
		$data['puntos']    = $this->Puntos_model->puntos_venta();
		$data['usuario']   = (object) $this->session->userdata("ses");
		if (!$this->input->post()) {
			$this->layout->view("nuevo", $data);
		} else {
			$this->form_validation->set_rules(
				"punto", "Punto de Venta", "required", ['required' => 'Debe elegir el %s.']
			);
			if ($this->form_validation->run() == false) {
				$this->session->set_flashdata("danger", validation_errors());
				$this->layout->view("nuevo", $data);
			} else {
				$d["idUsuario"]         = $this->input->post("usuario", true);
				$d["fecha_envio"]       = date('Y-m-d');
				$d["idPunto"]           = $this->input->post("punto");
				$idEnvio                = $this->Envios_model->create_envio($d);
				$datos['fechahora']     = date('Y-m-d H:i:s');
				$datos['idEnvio']       = $idEnvio;
				$datos['idEstadoEnvio'] = 1;
				$datos['idUsuario']     = $d["idUsuario"];
				$this->Envios_model->nuevo_log($datos); //registra log
				if ($this->db->trans_status() == false) {
					$this->session->set_flashdata(
						"danger", "No se pudo registrar el envio"
					);
					$this->db->trans_rollback();
				} else {
					$this->db->trans_commit();
					header("Location: " . base_url("Envios/detalle/$idEnvio"));
					$this->session->set_flashdata("success", "Envio registrado correctamente");
				}
			}
		}
	}

	public function agregarItemEnvio($idEnvio)
	{
		$lista = $this->input->post('lista');
		if ($lista) {
			$items = explode(',', $lista);
			foreach ($items as $item) {
				$bus = $this->Envios_model->existe_item($item);
				if (!$bus) {
					$data['idItem']  = $item;
					$data['idEnvio'] = $idEnvio;
					echo $this->Envios_model->agregar_items($data);
				} else {
					echo 'item en otra orden de envio';
				}
			}
		} else {
			echo 'no existen items';
		}
	}

	public function detalle($id)
	{
		$this->db->trans_commit();
		$data              = [];
		$data['timestamp'] = time();
		$data['envio']     = $this->Envios_model->detalle_envio($id);
		$data['usuario']   = (object) $this->session->userdata("ses");
		$this->layout->view("detalle", $data);
	}

	public function ItemsSinAtender($punto)
	{
		$this->db->trans_commit();
		$res = $this->Envios_model->detalle_items_pedido($punto);
		header('Content-type: application/json; charset=UTF-8');
		echo json_encode($res);
	}

	public function ItemsSinAtenderPedido($pedido)
	{
		$this->db->trans_commit();
		$res = $this->Envios_model->items_pedido($pedido);
		header('Content-type: application/json; charset=UTF-8');
		echo json_encode($res);
	}

	public function ItemsEnEnvio($idEnvio)
	{
		$datosEnvio  = $this->Envios_model->detalle_envio($idEnvio);
		$estadoEnvio = $datosEnvio->idEstadoEnvio;
		$usuario     = (object) $this->session->userdata("ses");
		$data        = [];
		$this->db->trans_commit();
		$res = $this->Envios_model->items_pedido_envio($idEnvio);
		foreach ($res as $item) {
			if ($estadoEnvio == 1 || $usuario->usu_perfil!=2) {
				$boton  = "<a href='#' data-toggle='modal' data-target='#modalEliminarItem' class='btn btn-danger' data-target='eliminar_item' data-id='$item->idEnvioDetalle' data-ticket='$item->ticket'><i class='fa fa-times'></i></a>";
				$data[] = [
					$item->orden, $item->fechaPedido, $item->ticket, $item->producto, $item->paciente, $boton,
				];
			} else {
				$data[] = [
					$item->orden, $item->fechaPedido, $item->ticket, $item->producto, $item->paciente,
				];
			}
		}
		echo json_encode(['data' => $data]);
	}

	public function listarEnvios($punto = null)
	{
		$data = [];
		$this->db->trans_commit();
		$res = $this->Envios_model->envios_registrados($punto);
		foreach ($res as $envio) {
			$boton = "&nbsp;&nbsp;<a class=\"btn btn-xs btn-warning\" href='" . base_url(
					'Envios/detalle/' . $envio->idEnvio
				) . "' title='Detalle de envio'><i class='fa fa-edit'></i></a>";
			if ($envio->idEstadoEnvio >= 3) {
				$boton .= "&nbsp;&nbsp;<a class=\"btn btn-xs btn-info\" target='_blank' href='" . base_url(
						'archivos/envios/' . $envio->idEnvio . '/' . $envio->archivo
					) . "' title='Comprobante Envio'><i class='fa fa-picture-o'></i></a>";
			}
			$fila   = (object) [
				'idEnvio'         => $envio->idEnvio,
				'local'           => $envio->local,
				'fecha'           => $envio->fecha,
				'fecha_procesado' => $envio->fecha_procesado,
				'estado_envio'    => $envio->estado_envio,
				'boton'           => $boton,
			];
			$data[] = $fila;
		}

		return $data;
	}

	public function eliminarItemEnvio($item)
	{
		$this->Envios_model->eliminar_item($item);
	}

	public function procesarEnvio($idEnvio)
	{
		$user   = (object) $this->session->userdata("ses");
		$usu_id = $user->usu_id;
		$this->Envios_model->procesar_envio($idEnvio, $usu_id);
		echo "1";
	}

	public function adjuntarDocumento($idEnvio)
	{
		$user      = (object) $this->session->userdata("ses");
		$usu_id    = $user->usu_id;
		$archivo   = $this->input->post('nombreArchivo');
		$documento = $this->input->post('documento');
		$targetDir = "archivos/envios/" . $idEnvio . "/";
		/*Crear Folder*/
		if (!file_exists($targetDir)) {
			mkdir($targetDir, 0777, true);
		}
		/*guardar el archivo de contrata*/
		if (!file_exists($_FILES['archivo']['tmp_name']) || !is_uploaded_file($_FILES['archivo']['tmp_name'])) {
			$respuesta = 3;
			$mensaje   = 'No adjunta archivo!';
		} else {
			$file = $_FILES['archivo']['tmp_name'];
			$name = explode('.', $_FILES["archivo"]["name"]);
			$ext  = mb_strtolower(end($name));
			if ($ext == 'jpg' || $ext == 'jpeg') {
                move_uploaded_file($file, $targetDir . $archivo);
                $respuesta              = 1;
                $mensaje                = "envio actualizado";
                $data['archivo']        = $archivo;
                $data['documento']      = $documento;
                $data['idEstadoEnvio']  = 3;
                $datos['fechahora']     = date('Y-m-d H:i:s');
                $datos['idEnvio']       = $idEnvio;
                $datos['idEstadoEnvio'] = 3;
                $datos['idUsuario']     = $usu_id;
                $this->Envios_model->update_envio($idEnvio, $data);
                $this->Envios_model->nuevo_log($datos); //registra log
                //Actualizar el estado de los envios en el pedido
                $datosPedido = $this->Envios_model->leer_pedidos_envio();
                if (count($datosPedido) > 0) {
                    foreach ($datosPedido as $dataPedido) {
                        if ($dataPedido->idEstadoEnvio == 3 && $dataPedido->total == $dataPedido->totalEnvios) {
                            $idPedido             = $dataPedido->idPedido;
                            $fechaEnvio           = $dataPedido->fecha_envio;
                            $envio['fecha_envio'] = $fechaEnvio;
                            $envio['idEstado']    = 5;
                            $this->Envios_model->actualiza_pedido_envio($envio, $idPedido);
                        }
                    }
                }
			} else {
				$respuesta = 3;
				$mensaje   = "archivo no admitido";
			}
		}
        header('Content-type: application/json; charset=UTF-8');
		$respuesta = json_encode(['respuesta' => $respuesta, 'mensaje' => $mensaje]);
		echo $respuesta;
	}
}
