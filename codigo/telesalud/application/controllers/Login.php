<?php

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Usuario_model');
    }

    public function index()
    {
        $this->layout->setLayout("login");
        if ($this->input->post()) {
            $u   = $this->input->post("usuario", true);
            $p   = $this->input->post("clave", true);
            $this->form_validation->set_rules(
                "usuario", "Correo", "trim|required|valid_email", ['required' => 'Debe ingresar el %s','valid_email' => 'Debe ser un Correo Electronico valido']
            );
            $this->form_validation->set_rules(
                "clave", "Clave", "trim|required", ['required' => 'Debe ingresar la %s.']
            );
            if ($this->form_validation->run() == false) {
                $this->session->set_flashdata("danger", validation_errors());
            } else {
                $row = $this->Usuario_model->loginHash($u);
                if ($row) {
                    $hashed = $row->passfrase;
                    if (password_verify($p, $hashed)) {
                        $sess_array = [
                            "usu_id"        => $row->idUsuario,
                            "usu_email"     => $row->email,
                            "usu_nombres"   => $row->nombres,
                            "usu_apellidos" => $row->apellidos,
                            "usu_telefono"  => $row->telefono,
                            "usu_perfil"    => $row->idPerfil,
                            "per_nombre"    => $row->perfil,
                        ];
                        $this->session->set_userdata("ses", $sess_array);
                        $this->session->userdata("ses");
                    } else {
                        $this->session->set_flashdata("danger", "Clave incorrecta");
                    }
                } else {
                    $this->session->set_flashdata("danger", "Correo no registrado");
                }
            }
        }
        $this->layout->view("index");
    }

    public function logout()
    {
        $array_items = ['id', 'per_id', 'nombre'];
        $this->session->unset_userdata($array_items);
        $this->session->sess_destroy();
        redirect(base_url("/"), 301);
    }
}
