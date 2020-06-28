<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pedidos_model');
    }

    public function index()
    {
        $this->db->trans_commit();
        $user            = (object) $this->session->userdata("ses");
        $punto           = $user->usu_punto;
        $perfil          = $user->usu_perfil;
        $data['usuario'] = $user;
        $data['pedidos'] = $this->listarPedidos($perfil, $punto);
        $this->layout->view("index", $data);
    }

    public function nuevo()
    {
        $this->db->trans_commit();
        $data                   = [];
        $data['timestamp']      = time();
        $data['usuario']        = (object) $this->session->userdata("ses");
        $data['categorias']     = $this->Pedidos_model->leer_categoria();
        $data['tipos_paciente'] = $this->Pedidos_model->tipo_pacientes();
        $this->layout->view("nuevo", $data);
    }

    public function detalle($id)
    {
        $this->db->trans_commit();
        $data                  = [];
        $data['usuario']       = (object) $this->session->userdata("ses");
        $data['pedido']        = $this->Pedidos_model->leer_pedido($id);
        $data['observaciones'] = $this->Pedidos_model->leer_observaciones($id);
        $data['detalles']      = $this->Pedidos_model->leer_detalles_pedido($id);
        $data['tickets']       = $this->Pedidos_model->tabla_tickets($id);
        $data['motivosA']      = $this->Pedidos_model->listar_motivos();
        $this->layout->view("detalle", $data);
    }

    public function listarPedidos($perfil, $punto = null)
    {
        $data    = [];
        $pedidos = $this->Pedidos_model->listar_pedidos($punto);
        foreach ($pedidos as $pedido) {
            $id      = $pedido->idPedido;
            $urlEdit = base_url('Pedidos/editar/' . $id);
            $urlVer  = base_url('Pedidos/detalle/' . $id);
            $boton   = "<a class=\"btn btn-xs btn-primary\" href='$urlVer' data-id=\"$id\" title='Ver Detalle'><i class='fa fa-check-square-o'></i></a>";
//			if ($perfil == 1) {
//				$boton .= "&nbsp;&nbsp;<a class=\"btn btn-xs btn-warning\" href='#' data-id=\"$id\" title='Editar' '><i class='fa fa-edit'></i></a>";
//			}
            if ($pedido->idEstado == 3) {
                $pedido->estado = "<a href='#' class='btn btn-xs btn-warning'>" . $pedido->estado . "</a>";
            }
            $fila   = (object) [
                'responsable'  => $pedido->responsable,
                'codigo'       => $pedido->codigo,
                'paciente'     => $pedido->paciente,
                'fecha_pedido' => $pedido->fecha_pedido,
                'items'        => $pedido->items,
                'pagado'       => $pedido->pagado,
                'total'        => $pedido->total,
                'estado'       => $pedido->estado,
                'punto_venta'  => $pedido->punto_venta,
                'boton'        => $boton,
            ];
            $data[] = $fila;
        }

        return $data;
    }

    public function nuevoProductoTemporal()
    {
        $this->db->trans_commit();
        $data['timestamp']  = $this->input->post('tiempo');
        $data['idUsuario']  = $this->input->post('usuario');
        $data['idProducto'] = $this->input->post('producto');
        $data['cantidad']   = $this->input->post('cantidad');
        $data['precio']     = $this->input->post('precio');
        $data['detalle']    = $this->input->post('detalle', true);
        echo $this->Pedidos_model->create_detalle_temporal($data);
    }

    public function buscarTablaTemporal()
    {
        $this->db->trans_commit();
        $data    = [];
        $tiempo  = $this->input->post('tiempo');
        $usuario = $this->input->post('usuario');
        $datos   = $this->Pedidos_model->leer_tabla_temporal($tiempo, $usuario);
        foreach ($datos as $dato) {
            $id       = $dato->id;
            $boton    = "<button class=\"btn btn-xs btn-primary\" onclick='borrarRegistroTemp($id)' data-id=\"$id\" title='Borrar Registro'><i class='fa fa-times'></i></button>";
            $producto = ($dato->idProducto == 3) ? $dato->detalle : $dato->nombre;
            $data[]   = [
                $producto, $dato->cantidad, $dato->precio, ($dato->precio * $dato->cantidad), $boton,
            ];
        }
        header('Content-type: application/json; charset=UTF-8');
        echo json_encode(['data' => $data]);
    }

    public function calcularTotalTemp()
    {
        $total   = 0;
        $tiempo  = $this->input->post('tiempo');
        $usuario = $this->input->post('usuario');
        $datos   = $this->Pedidos_model->leer_tabla_temporal($tiempo, $usuario);
        foreach ($datos as $dato) {
            $total += ($dato->precio * $dato->cantidad);
        }
        echo $total;
    }

    public function contarItemsTemp($tiempo, $usuario)
    {
        $datos = $this->Pedidos_model->leer_tabla_temporal($tiempo, $usuario);
        echo count($datos);
    }

    public function borrarItemTemp($id)
    {
        $this->Pedidos_model->borrar_item_temporal($id);
    }

    public function agregarOrdenPedido()
    {
        $tiempo              = $this->input->post('tiempo');
        $usuario             = $this->input->post('usuario');
        $idDoctor            = $this->input->post('doctor');
        $fecha               = $this->input->post('fecha', true);
        $objetoFecha         = $this->objetoFechaHora($fecha);
        $data['idPunto']     = $this->Pedidos_model->leer_punto_doctor($idDoctor)->idPunto;
        $data['idUsuario']   = $usuario;
        $data['idDoctor']    = $idDoctor;
        $data['idCliente']   = $this->input->post('paciente');
        $data['codigoOrden'] = $this->input->post('orden', true);
        $data['fechaOrden']  = $objetoFecha->fechaES;
        $data['adicionales'] = $this->input->post('adicionales', true);
        $data['telefono']    = $this->input->post('telefono', true);
        $data['pagado']      = $this->input->post('cuenta', true);
        $data['total']       = $this->input->post('total', true);
        $orden               = $this->buscarOrden($data['codigoOrden']);
        if (!$orden) {
            $idPedido = $this->Pedidos_model->crear_pedido($data);
            $this->Pedidos_model->insertar_log(['idPedido' => $idPedido, 'idEstado' => 1, 'idUsuario' => $usuario]);
            if ($idPedido) {
                $datos = $this->Pedidos_model->leer_tabla_temporal($tiempo, $usuario);
                foreach ($datos as $dato) {
                    $item['idPedido']       = $idPedido;
                    $item['idProducto']     = $dato->idProducto;
                    $item['detalle']        = $dato->detalle;
                    $item['cantidad']       = $dato->cantidad;
                    $item['precioUnitario'] = $dato->precio;
                    $this->Pedidos_model->crear_detalle_pedido($item);
                    $this->borrarItemTemp($dato->id);
                }
                echo "1";
            } else {
                echo "problema desconocido";
            }
        } else {
            echo "Orden de Pedido ya existe";
        }
    }

    public function buscarOrden($orden)
    {
        return $this->Pedidos_model->buscar_orden($orden);
    }

    public function listarProductos($tipo = null)
    {
        header('Content-type: application/json; charset=UTF-8');
        echo json_encode($this->Pedidos_model->leer_productos($tipo));
    }

    public function listarDoctores($punto = null)
    {
        $doctor = $this->input->post('doctor');
        header('Content-type: application/json; charset=UTF-8');
        echo json_encode($this->Pedidos_model->listar_doctores($punto, $doctor));
    }

    public function observarPedido($id)
    {
        $usuario    = (object) $this->session->userdata("ses");
        $idUsuario  = $usuario->usu_id;
        $comentario = $this->input->post('comentario');
        if ($comentario) {
            $obs = $this->Pedidos_model->nueva_observacion($id, $idUsuario, $comentario);
            if ($obs) {
                $d['observado'] = '1';
                $d['idEstado']  = '3';
                $this->Pedidos_model->update_pedido($id, $d);
                $this->Pedidos_model->insertar_log(['idPedido' => $id, 'idEstado' => 3, 'idUsuario' => $idUsuario]);
                echo 1;
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    }

    function levantarObservacion($id)
    {
        $usuario   = (object) $this->session->userdata("ses");
        $idUsuario = $usuario->usu_id;
        $solucion  = trim($this->input->post('solucion'));
        if ($solucion) {
            $data['solucion']           = $solucion;
            $data['usuarioAtiende']     = $idUsuario;
            $data['fechahora_atencion'] = date('Y-m-d H:i:s');
            $this->Pedidos_model->finalizar_observacion($data, $id);
            $d['idEstado'] = '1';
            $this->Pedidos_model->update_pedido($id, $d);
            $this->Pedidos_model->insertar_log(['idPedido' => $id, 'idEstado' => 1, 'idUsuario' => $idUsuario]);
            echo "1";
        } else {
            echo "0";
        }
    }

    function anular($id)
    {
        $usuario           = (object) $this->session->userdata("ses");
        $idUsuario         = $usuario->usu_id;
        $d['idEstado']     = '10';
        $data['idUsuario'] = $idUsuario;
        $data['idPedido']  = $id;
        $data['idMotivo']  = $this->input->post('motivo');
        $this->Pedidos_model->update_pedido($id, $d);
        $this->Pedidos_model->create_anulacion($data);
        $this->Pedidos_model->insertar_log(['idPedido' => $id, 'idEstado' => 10, 'idUsuario' => $idUsuario]);
        header("Location: " . base_url("Pedidos/detalle/" . $id));
    }

    function completarPedido($id)
    {
        $usuario           = (object) $this->session->userdata("ses");
        $idUsuario         = $usuario->usu_id;
        $d['idEstado']     = '9';
        $d['fecha_entrega']     = date('Y-m-d');
        $this->Pedidos_model->update_pedido($id, $d);
        $this->Pedidos_model->insertar_log(['idPedido' => $id, 'idEstado' => 9, 'idUsuario' => $idUsuario]);
        header("Location: " . base_url("Pedidos/detalle/" . $id));
    }

    function procesarTotal($id)
    {
        echo $id;
        $usuario   = (object) $this->session->userdata("ses");
        $idUsuario = $usuario->usu_id;
        $cantidad  = $this->Pedidos_model->tickets_generados($id);
        $inicial   = ($cantidad && $cantidad > 0) ? $cantidad + 1 : 1;
        $op        = $this->input->post('codigo');
        $punto     = $this->input->post('punto');
        $codigo    = $this->Pedidos_model->codigo_punto($punto);
        $codigo    = $codigo->codigo;
        $detalles  = $this->Pedidos_model->leer_detalles_pedido($id);
        foreach ($detalles as $itemX) {
            $idItem  = $itemX->idDetalle;
            $detalle = $this->Pedidos_model->leer_detalle($idItem);
            $total   = $detalle->cantidad;
            for ($i = 1; $i <= $total; $i++) {
                $ticket          = $codigo . $op . '-' . $inicial;
                $d['idPedido']   = $id;
                $d['idDetalle']  = $idItem;
                $d['numeroItem'] = $inicial;
                $d['codigoItem'] = $ticket;
                $this->Pedidos_model->insertar_ticket($d);
                $inicial++;
            }
        }
        $this->Pedidos_model->update_pedido($id, ['idEstado' => 2]);
        $this->Pedidos_model->insertar_log(['idPedido' => $id, 'idEstado' => 2, 'idUsuario' => $idUsuario]);
        echo "1";
    }

    function procesarParcial($id)
    {
        $usuario   = (object) $this->session->userdata("ses");
        $idUsuario = $usuario->usu_id;
        $cantidad  = $this->Pedidos_model->tickets_generados($id);
        $inicial   = ($cantidad && $cantidad > 0) ? $cantidad + 1 : 1;
        $op        = $this->input->post('codigo');
        $punto     = $this->input->post('punto');
        $lista     = $this->input->post('lista');
        $motivo    = $this->input->post('motivo');
        $codigo    = $this->Pedidos_model->codigo_punto($punto);
        $codigo    = $codigo->codigo;
        if ($lista) {
            $this->Pedidos_model->excluir_ticket($id, $lista, $motivo);
            $lista = explode(',', $lista);
            foreach ($lista as $idItem) {
                $detalle = $this->Pedidos_model->leer_detalle($idItem);
                $total   = $detalle->cantidad;
                for ($i = 1; $i <= $total; $i++) {
                    $ticket          = $codigo . $op . '-' . $inicial;
                    $d['idPedido']   = $id;
                    $d['idDetalle']  = $idItem;
                    $d['numeroItem'] = $inicial;
                    $d['codigoItem'] = $ticket;
                    $this->Pedidos_model->insertar_ticket($d);
                    $inicial++;
                }
            }
            $this->Pedidos_model->update_pedido($id, ['idEstado' => 2]);
            $this->Pedidos_model->insertar_log(['idPedido' => $id, 'idEstado' => 2, 'idUsuario' => $idUsuario]);
            echo 1;
        } else {
            echo '2';
        }
    }
}