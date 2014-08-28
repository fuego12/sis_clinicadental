<?php

class clinica extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_clinica'));
        $this->load->library('session');
    }

    public function index() {

        $data['clinica'] = $this->mod_clinica->get_clinica();

        $this->form_validation->set_rules('nomb_clin', 'Nombre', 'required');
        $this->form_validation->set_rules('direc_clin', 'Dirección', 'required');
        $this->form_validation->set_rules('ruc_clin', 'RUC', 'required');
        $this->form_validation->set_rules('telf_clin', 'Telefono', 'required');

        if ($this->form_validation->run() == FALSE) {
            $paciente["form"] = array('role' => 'form', "id" => "form_cli");
            $paciente["nombre"] = array('id' => 'nomb_clin', 'name' => 'nomb_clin', 'class' => "form-control", 'placeholder' => "Nombre", "maxlength" => "50", 'required' => 'true', 'value' => $data['clinica']['nomb_clin']);
            $paciente["direccion"] = array('id' => 'direc_clin', 'name' => 'direc_clin', 'class' => "form-control", 'placeholder' => "Dirección", "maxlength" => "100", 'required' => 'true', 'value' => $data['clinica']['direc_clin']);
            $paciente["ruc"] = array('id' => 'ruc_clin', 'name' => 'ruc_clin', 'class' => "form-control", 'placeholder' => "RUC", "maxlength" => "15", 'required' => 'true', 'value' => $data['clinica']['ruc_clin']);
            $paciente["telefono"] = array('id' => 'telf_clin', 'name' => 'telf_clin', 'class' => "form-control", 'placeholder' => "Teléfono", "maxlength" => "15", 'required' => 'true', 'value' => $data['clinica']['telf_clin']);
            $paciente["email"] = array('id' => 'email_clin', 'name' => 'email_clin', 'class' => "form-control", 'placeholder' => "E-mail", "maxlength" => "100", 'value' => $data['clinica']['email_clin']);

            $paciente["editar_clinica"] = array('name' => 'editar_clinica', 'class' => "btn btn-lg btn-success btn-block", 'value' => "Editar");
            $paciente["limpiar_clinica"] = array('name' => 'limpiar_clinica', 'class' => "btn btn-lg btn-default btn-block", 'value' => "Limpiar");

            $data['container'] = $this->load->view('clinica/clinica_view', $paciente, true);
            $this->load->view('home/body', $data);
        } else {
            $config['upload_path'] = './resources/images/clinica/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '10000';
            $config['max_width'] = '1024';
            $config['max_height'] = '768';
            $config['file_name'] = 'logo.png';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            unlink('./resources/images/clinica/logo.png');
            
            if (!$this->upload->do_upload()) {
                
                $this->session->set_userdata('error_clinica_1', 'Error al cargar la imagen, seleccione el tipo correcto');
            } else {
                $nombre = $this->input->post('nomb_clin');
                $direccion = $this->input->post('direc_clin');
                $ruc = $this->input->post('ruc_clin');
                $telefono = $this->input->post('telf_clin');
                $email = $this->input->post('email_clin');

                $data = array(
                    'nomb_clin' => $nombre,
                    'direc_clin' => $direccion,
                    'ruc_clin' => $ruc,
                    'telf_clin' => $telefono,
                    'email_clin' => $email,
                    'esta_clin' => 'A'
                );
                $this->mod_clinica->update_clinica('1', $data);
                $this->session->set_userdata('error_clinica_1', 'Los datos de la clinica han sido actualizados existosamente');
            }
            header('Location: ' . base_url() . 'clinica');
        }
    }

}
