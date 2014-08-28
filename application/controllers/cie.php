<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class cie extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_cie', 'mod_clinica'));
        $this->load->library('session');
    }

    public function index() {
        if (!$this->logged()) {
            header('location: ' . base_url('login'));
        } else {
            if (!$this->admin()) {
                header('location: ' . base_url('login'));
            } else {
                $cie["form"] = array('role' => 'form', "id" => "form_enf");
                $cie["form_editar"] = array('role' => 'form', "id" => "form_enf_edit");
                $cie["form_a"] = array('role' => 'form', "style" => "display: inline-block;");
                $cie["codigo"] = array('id' => 'codi_cie', 'name' => 'codigo', 'class' => "form-control", 'placeholder' => "Código", "maxlength" => "6", 'required' => 'true');
                $cie["titulo"] = array('id' => 'titu_cie', 'name' => 'titulo', 'class' => "form-control", 'placeholder' => "Título", "maxlength" => "1", 'required' => 'true');
                $cie["descripcion"] = array('id' => 'desc_cie', 'name' => 'descripcion', 'class' => "form-control", 'placeholder' => "Descripción", "maxlength" => "200", 'required' => 'true');
                $cie["codigo_e"] = array('id' => 'codi_cie_e', 'name' => 'codigo', 'class' => "form-control", 'placeholder' => "Código", "maxlength" => "6", 'required' => 'true');
                $cie["titulo_e"] = array('id' => 'titu_cie_e', 'name' => 'titulo', 'class' => "form-control", 'placeholder' => "Título", "maxlength" => "1", 'required' => 'true');
                $cie["descripcion_e"] = array('id' => 'desc_cie_e', 'name' => 'descripcion', 'class' => "form-control", 'placeholder' => "Descripción", "maxlength" => "200", 'required' => 'true');
                $cie["registrar"] = array('name' => 'registrar', 'class' => "btn btn-primary", 'value' => "Registrar");
                $cie["editar"] = array('name' => 'editar', 'class' => "btn btn-primary", 'value' => "Editar");
                $cie["enfermedades"] = $this->mod_cie->get_cie();

                if ($this->input->post('registrar')) {
                    $codi_cie = $this->input->post('codigo');
                    $titu_cie = $this->input->post('titulo');
                    $desc_cie = $this->input->post('descripcion');

                    $data = array(
                        'codi_enf' => $codi_cie,
                        'titu_enf' => $titu_cie,
                        'desc_enf' => $desc_cie
                    );
                    $this->mod_cie->insert_cie($data);
                    $this->session->set_userdata('mensaje_cie', 'La enfermedad ' . $desc_cie . ' ha sido registrado existosamente');
                } else if ($this->input->post('editar')) {
                    $codi_cie = $this->input->post('codigo');
                    $titu_cie = $this->input->post('titulo');
                    $desc_cie = $this->input->post('descripcion');

                    $data = array(
                        'titu_enf' => $titu_cie,
                        'desc_enf' => $desc_cie
                    );
                    $this->mod_cie->update_cie($codi_cie, $data);
                    $this->session->set_userdata('mensaje_cie', 'La enfermedad ' . $desc_cie . ' ha sido actualizada existosamente');
                } else if ($this->input->post('activar')) {
                    $codi_cie = $this->input->post('codigo');
                    $desc_cie = $this->input->post('descripcion');
                    $this->mod_cie->update_cie($codi_cie, array("esta_enf" => "A"));
                    $this->session->set_userdata('mensaje_cie', 'La enfermedad ' . $desc_cie . ' ha sido habilitada existosamente');
                } else if ($this->input->post('desactivar')) {
                    $codi_cie = $this->input->post('codigo');
                    $desc_cie = $this->input->post('descripcion');
                    $this->mod_cie->update_cie($codi_cie, array("esta_enf" => "D"));
                    $this->session->set_userdata('mensaje_cie', 'La enfermedad ' . $desc_cie . ' ha sido deshabilitada existosamente');
                }

                $cie['enfermedades'] = $this->mod_cie->get_cie();
                $data['container'] = $this->load->view('cie/index', $cie, true);
                $data['clinica'] = $this->mod_clinica->get_clinica();
                $this->load->view('home/body', $data);
            }
        }
    }

    public function logged() {
        return $this->session->userdata('logged');
    }

    public function admin() {
        if ($this->session->userdata('codi_rol') == '1') {
            return true;
        } else {
            return false;
        }
    }

}
