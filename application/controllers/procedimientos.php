<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class procedimientos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_procedimiento', 'mod_clinica'));
        $this->load->library('session');
    }

    public function procedimiento() {
        if (!$this->logged()) {
            header('location: ' . base_url('login'));
        } else {
            if (!$this->admin()) {
                header('location: ' . base_url('login'));
            } else {

                $this->form_validation->set_rules('costo', 'Costo', 'required');
                $categorias = $this->mod_procedimiento->get_categoria();
                $proced = $this->mod_procedimiento->get_procedimiento();
                $options_1 = array();
                $options_2 = array();
                
                if (count($categorias) > 0 && count($proced) > 0) {
                    $no = false;
                } else {
                    $no = true;
                }
                
                if ($this->form_validation->run() == FALSE) {
                    $procedimiento["form"] = array('role' => 'form', "id" => "form_pro");
                    $procedimiento["grupo"] = array('id' => 'nomb_grup', 'name' => 'grupo', 'class' => "form-control", 'placeholder' => "Grupo", "maxlength" => "30", 'required' => 'true');
                    $procedimiento["costo"] = array('id' => 'costo_pro', 'name' => 'costo', 'class' => "form-control", 'placeholder' => "Costo", "maxlength" => "15", 'required' => 'true');
                    $procedimiento["procedimiento"] = array('id' => 'nomb_pro', 'name' => 'procedimiento', 'class' => "form-control", 'placeholder' => "Procedimiento", "maxlength" => "15", 'required' => 'true');
                    $procedimiento["cate"] = array('id' => 'nomb_cate', 'name' => 'nomb_cate', 'class' => "form-control", 'placeholder' => "Categorias", "maxlength" => "15", 'required' => 'true');

                    foreach ($categorias as $value) {
                        $options_1[$value->codi_cat] = $value->nomb_cat;
                    }

                    foreach ($proced as $value) {
                        $options_2[$value->codi_pro] = $value->desc_pro;
                    }
                    $procedimiento["tarifas"] = $this->mod_procedimiento->get_tbl_tarifa();
                    $procedimiento["categorias"] = $options_1;
                    $procedimiento["nomb_pro"] = $options_2;
                    $procedimiento["editar_pro"] = array('name' => 'editar_pro', 'class' => "btn btn-lg btn-primary btn-block", 'value' => "Editar", "style" => "display: none;");
                    $procedimiento["cancelar_pro"] = array('name' => 'cancelar_pro', 'class' => "btn btn-lg btn-default btn-block", 'value' => "true", "style" => "display: none;", "content" => "Cancelar");
                    $procedimiento["registrar_pro"] = array('name' => 'registar_pro', 'class' => "btn btn-lg btn-info btn-block", 'value' => "Registrar");
                    $procedimiento["buscar_pro"] = array('name' => 'buscar_pro', 'class' => "btn btn-lg btn-default btn-block", 'value' => "true", "content" => "Buscar", "data-toggle" => "modal", "data-target" => "#ModalMedico");
                    if ($no) {
                        $procedimiento["registrar_pro"]['disabled'] = 'true';
                        $procedimiento["buscar_pro"]['disabled'] = 'true';
                    }
                    $procedimiento["limpiar_pro"] = array('name' => 'limpiar_pro', 'class' => "btn btn-lg btn-default btn-block", 'value' => "Limpiar");
                    $procedimiento["agregar_pro"] = array('name' => 'agregar_pro', 'class' => "btn btn-lg btn-info btn-block", 'value' => "Registrar");
                    $procedimiento["agregar_cat"] = array('name' => 'agregar_cat', 'class' => "btn btn-lg btn-info btn-block", 'value' => "Registrar");
                    $procedimiento["no"] = $no;

                    $data['container'] = $this->load->view('proc/procedimiento', $procedimiento, true);
                    $data['clinica'] = $this->mod_clinica->get_clinica();
                    $this->load->view('home/body', $data);
                } else {
                    $codi_cat = $this->input->post('categoria');
                    $codi_pro = $this->input->post('procedimiento');
                    $cost_tar = $this->input->post('costo');

                    $lista_pro = $this->mod_procedimiento->get_procedimientos();
                    foreach ($lista_pro as $row) {
                        if ($codi_pro == ($row->codi_pro)) {
                            $nomb_pro = $row->desc_pro;
                            break;
                        }
                    }
                    $lista_cat = $this->mod_procedimiento->get_categoria();
                    foreach ($lista_cat as $row) {
                        if ($codi_cat == ($row->codi_cat)) {
                            $nomb_cat = $row->nomb_cat;
                            break;
                        }
                    }

                    $data_tar = array(
                        'codi_pro' => $codi_pro,
                        'codi_cat' => $codi_cat,
                        'cost_tar' => $cost_tar
                    );
                    $registrar_proc = $this->input->post('registar_pro');
                    $editar_proc = $this->input->post('editar_pro');
                    $agregar_proc = $this->input->post('agregar_pro');

                    if ($registrar_proc) {
                        $accion = $this->input->post('accion');
                        if ($accion == "registrar") {
                            $this->mod_procedimiento->insert_tar($data_tar);
                            $this->session->set_userdata('error_procedimiento_1', 'El procedimiento ' . $nomb_pro . ' ha sido registrado existosamente');
                        } else if ($accion == "actualizar") {
                            $this->mod_procedimiento->update_costo($codi_pro, $codi_cat, $cost_tar);
                            $this->session->set_userdata('error_procedimiento_1', 'El costo del procedimiento <strong>' . $nomb_pro . '</strong> de la categoría <strong>' . $nomb_cat . '</strong>  ha sido actualizado existosamente');
                        }
                    } else {
                        if ($editar_proc) {
                            $codigo = $this->input->post('codigo');
                            $this->mod_procedimiento->update_pro($codigo, $data_tar);
                            $this->session->set_userdata('error_procedimiento_1', 'El procedimiento ' . $nomb_pro . ' ha sido actualizado existosamente');
                        }
                    }
                    header('Location: ' . base_url('procedimiento'));
                }
            }
        }
    }

    public function search_procedimiento() {
        $data["resultado"] = $this->mod_procedimiento->get_tarifa();
        $this->load->view('proc/procedimiento_search', $data);
    }

    public function get_procedimientos() {
        $codigo = $this->input->post('codi_med');
        echo json_encode($this->mod_medico->get_medico(array('esta_med' => 'A', 'codi_med' => $codigo)));
    }

    public function get_data_tarifa() {
        $codigo = $this->input->post('codigo');
        $tarifa = $this->mod_procedimiento->data_tarifa(array("codi_tar" => $codigo));
        echo json_encode($tarifa[0]);
    }

    public function deshabilitar_tarifa() {
        $this->mod_procedimiento->update_pro($this->input->post('codigo'), array("esta_tar" => "D"));
        $this->session->set_userdata('error_procedimiento_1', 'El procedimiento con código ' . $this->input->post('codigo') . ' ha sido deshabilitado existosamente');
    }

    public function agregar_proc() {
        $this->form_validation->set_rules('procedimiento', 'Procedimiento', 'required');
        $this->form_validation->set_rules('grupo', 'Grupo', 'required');

        if ($this->form_validation->run() == TRUE) {
            $nombpro = $this->input->post('procedimiento');
            $nombgru = $this->input->post('grupo');

            $data = array(
                'desc_pro' => $nombpro,
                'grup_pro' => $nombgru,
                'esta_pro' => 'A'
            );

            $this->mod_procedimiento->agregar_pro($data);
            $this->session->set_userdata('sw_proc', 'El procedimiento ' . $this->input->post('procedimiento') . ' del grupo ' . $this->input->post('grupo') . ' ha sido registrado existosamente');
            $this->session->set_userdata('sw_proc_bck', 'success');
        } else {
            $this->session->set_userdata('sw_proc', 'Formulario no válido');
            $this->session->set_userdata('sw_proc_bck', 'danger');
        }
        header('Location: ' . base_url() . 'procedimiento');
    }

    public function agregar_cate() {
        $this->form_validation->set_rules('nomb_cate', 'Categoria', 'required');
        if ($this->form_validation->run() == TRUE) {
            $nombcat = $this->input->post('nomb_cate');

            $data = array(
                'nomb_cat' => $nombcat,
                'esta_cat' => 'A'
            );

            $this->mod_procedimiento->agregar_cat($data);
            $this->session->set_userdata('sw_cat', 'La categoria ' . $this->input->post('nomb_cate') . ' ha sido registrado existosamente');
            $this->session->set_userdata('sw_cat_bck', 'success');
        } else {
            $this->session->set_userdata('sw_cat', 'Formulario no válido');
            $this->session->set_userdata('sw_cat_bck', 'danger');
        }
        header('Location: ' . base_url() . 'procedimiento');
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
