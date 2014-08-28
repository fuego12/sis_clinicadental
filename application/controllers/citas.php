<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class citas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_cita', 'mod_medico', 'mod_paciente', 'mod_odontograma', 'mod_procedimiento', 'mod_clinica'));
        $this->load->library('session');
    }

    public function index() {
        if (!$this->logged()) {
            header('location: ' . base_url('login'));
        } else {
            date_default_timezone_set('America/Lima');

            $citas['fecha_actual'] = date("Y-m-d");
            $citas["nueva_cita"] = array('name' => 'nueva_cita', 'class' => "btn btn-lg btn-primary", 'value' => "true", "content" => "Nueva cita", "data-toggle" => "modal", "data-target" => "#ModalNuevaCita", "style" => "position: relative; top: 20px; float: right;");
            $citas["fecha"] = array('id' => 'fecha_cit', 'name' => 'fecha', 'class' => "form-control span2", "size" => "16", "value" => $citas['fecha_actual'], "style" => "background: white;", "readonly" => "true");
            $citas["citas"] = $this->mod_cita->get_cita($citas['fecha_actual']);

            $medicos = $this->mod_medico->get_medico();
            $pacientes = $this->mod_paciente->get_paciente();

            if (count($medicos) > 0) {
                if (count($pacientes) > 0) {
                    foreach ($medicos as $value) {
                        $options[$value->codi_med] = $value->nomb_med . ' ' . $value->apel_med;
                    }
                    $citas["medicos"] = $options;
                    $citas['estado_diente'] = $this->mod_odontograma->get_estado();
                    $citas['enfermedad'] = $this->mod_odontograma->get_enfermedad();
                    $citas['dientes'] = array('18', '17', '16', '15', '14', '13', '12', '11', '21', '22', '23', '24', '25', '26', '27', '28', '48', '47', '46', '45', '44', '43', '42', '41', '31', '32', '33', '34', '35', '36', '37', '38');
                    $citas['procedimiento'] = $this->mod_procedimiento->get_tarifa();
                    $citas["editar_cita"] = array("id" => "editar_cita", 'name' => 'editar_cita', 'class' => "btn btn-lg btn-primary btn-block", 'value' => "true", "content" => "Actualizar");
                    $citas["comenzar_cita"] = array("id" => "comenzar_cita", 'name' => 'comenzar_cita', 'class' => "btn btn-lg btn-info btn-block", 'value' => "true", "content" => "Comenzar");
                    $citas["deshabilitar_cita"] = array('name' => 'deshabilitar_cita', 'class' => "btn btn-lg btn-danger btn-block", 'value' => "true", "content" => "Deshabilitar");
                    $citas["cancelar_cita"] = array('name' => 'cancelar_cita', 'class' => "btn btn-lg btn-default btn-block", 'value' => "true", "content" => "Cancelar", "data-dismiss" => "modal");
                    $citas["citas_his"] = $this->mod_cita->get_cita();

                    $citas['last_estados'] = array();
                    $cont = 0;
                    foreach ($citas['dientes'] as $diente) {

                        $dir = "resources/images/odontograma/" . $diente;
                        $dr = @opendir($dir);
                        if (!$dr) {
                            
                        } else {
                            while (($archivo = readdir($dr)) !== false) {
                                if ($archivo != $diente . '.jpg' && $archivo != "." && $archivo != "..") {
                                    $citas['img_estados'][$cont] = $archivo;
                                    $cont++;
                                }
                            }
                            closedir($dr);
                        }
                    }

                    $cont = 0;

                    foreach ($pacientes as $row) {

                        $last_cita = $this->mod_cita->get_ultima_cita_terminada($row->codi_pac);
                        if (count($last_cita) > 0) {
                            $odontograma = $this->mod_odontograma->get_vodontograma(array('codi_cit' => $last_cita[0]->codi_cit));
                            $paciente = $last_cita[0]->apel_pac . ', ' . $last_cita[0]->nomb_pac;
                            foreach ($odontograma as $odo) {
                                $fila = array(
                                    'codi_cit' => $odo->codi_cit,
                                    'num_die' => $odo->num_die,
                                    'part_die' => $odo->part_die,
                                    'paciente' => $paciente,
                                    'codi_edi' => $odo->codi_edi,
                                    'nomb_edi' => $odo->nomb_edi
                                );
                                $citas['last_estados'][$cont] = $fila;
                                $cont++;
                            }
                        }
                    }
                    $citas['admin'] = $this->admin();
                    $data['container'] = $this->load->view('citas/index', $citas, true);
                } else {
                    $data['p'] = true;
                    $data['container'] = $this->load->view('citas/message', $data, true);
                }
            } else {
                $data['m'] = true;
                $data['container'] = $this->load->view('citas/message', $data, true);
            }


            $data['clinica'] = $this->mod_clinica->get_clinica();
            $this->load->view('home/body', $data);
        }
    }

    public function search() {
        $fecha = $this->input->post('fecha');
        $citas["citas"] = $this->mod_cita->get_cita($fecha);
        $this->load->view('citas/search', $citas);
    }

    public function mostrar_formulario_nuevo() {
        date_default_timezone_set('America/Lima');
        $citas['fecha_actual'] = date("Y-m-d");
        $citas['hora_actual'] = date("H:i");
        $citas["form"] = array('role' => 'form', "id" => "form_nueva_cita");

        $medicos = $this->mod_medico->get_medico();
        foreach ($medicos as $value) {
            $options[$value->codi_med] = $value->nomb_med . ' ' . $value->apel_med;
        }

        $citas["medicos"] = $options;
        $citas["paciente"] = array('id' => 'paciente_cit', 'name' => 'paciente', 'class' => "form-control ui-autocomplete-input", 'placeholder' => "Paciente", "maxlength" => "50", 'required' => 'true', "autocomplete" => "off");
        $citas["observacion"] = array('id' => 'observa_cit', 'name' => 'observacion', 'class' => "form-control", "maxlength" => "125", "autocomplete" => "off", "rows" => "3");
        $citas["cancelar_nueva_cita"] = array('name' => 'cancelar_nueva_cita', 'class' => "btn btn-lg btn-default", 'value' => "true", "content" => "Cancelar", "data-dismiss" => "modal");
        $citas["registrar_nueva_cita"] = array("id" => "registrar_cita", 'name' => 'registar_nueva_cita', 'class' => "btn btn-lg btn-primary", 'value' => "Registrar");
        $this->load->view('citas/frm_nueva_cita', $citas);
    }

    public function verificar_hora_cita() {
        $fecha = $this->input->post('fecha');
        $hora = $this->input->post('hora');
        $citas = $this->mod_cita->get_cita();

        $sw = false;
        foreach ($citas as $row) {
            $date = new DateTime($row->fech_cit);
            $fecha_cit = date('Y-m-d', $date->getTimestamp());
            $hora_cit = date('H:i', $date->getTimestamp());

            if ($fecha_cit == $fecha && $hora == $hora_cit) {
                $sw = true;
                break;
            }
        }
        if ($sw) {
            echo "error";
        }
    }

    public function nuevo() {
        $fecha = $this->input->post('fecha');
        $hora = $this->input->post('hora');
        $codi_med = $this->input->post('medico');
        $nombre_pac = $this->input->post('paciente');
        $observacion = $this->input->post('observacion');
        $citas = $this->mod_cita->get_cita();

        $sw_central = true;
        $sw = false;
        foreach ($citas as $row) {
            $date = new DateTime($row->fech_cit);
            $fecha_cit = date('Y-m-d', $date->getTimestamp());
            $hora_cit = date('H:i', $date->getTimestamp());

            if ($fecha_cit == $fecha && $hora == $hora_cit) {
                $sw = true;
                break;
            }
        }

        if ($sw) {
            $sw_central = false;
            $this->session->set_userdata('error_nueva_cita', 'A');
            header('Location: ' . base_url() . 'citas');
        }

        $pacientes = $this->mod_paciente->get_paciente();
        $sw_pac = false;
        foreach ($pacientes as $row) {
            if (mb_strtoupper(utf8_decode($nombre_pac)) == mb_strtoupper(utf8_decode($row->nomb_pac . ' ' . $row->apel_pac))) {
                $sw_pac = true;
                break;
            }
        }
        if (!$sw_pac) {
            $sw_central = false;
            $this->session->set_userdata('error_nueva_cita', 'B');
            header('Location: ' . base_url() . 'citas');
        }

        if ($sw_central) {
            $codi_pac = -1;
            foreach ($pacientes as $row) {
                if (mb_strtoupper(utf8_decode($nombre_pac)) == mb_strtoupper(utf8_decode($row->nomb_pac . ' ' . $row->apel_pac))) {
                    $codi_pac = $row->codi_pac;
                    break;
                }
            }

            $data = array(
                'codi_pac' => $codi_pac,
                'codi_med' => $codi_med,
                'fech_cit' => $fecha . ' ' . $hora
            );

            if ($observacion) {
                $data['obsv_cit'] = $observacion;
            }

            $this->mod_cita->insert_cit($data);
            $this->session->set_userdata('mensaje_cita', 'La nueva cita médica ha sido registrado exitosamente');
            header('Location: ' . base_url('citas'));
        }
    }

    public function get_data_cita_edit() {
        $codigo = $this->input->post('codigo');
        $cita_medica = $this->mod_cita->get_cita("", array("codi_cit" => $codigo));
        echo json_encode($cita_medica[0]);
    }

    public function editar() {
        $codigo = $this->input->post('codigo');
        $fecha_ori = $this->input->post('fecha_ori');
        $hora_ori = $this->input->post('hora_ori');
        $fecha = $this->input->post('fecha');
        $hora = $this->input->post('hora');
        $codi_med = $this->input->post('medico_edit');
        $nombre_pac = $this->input->post('paciente');
        $observacion = $this->input->post('observacion');
        $pacientes = $this->mod_paciente->get_paciente();
        $citas = $this->mod_cita->get_cita();

        $sw = false;
        if (($fecha . ' ' . $hora) != ($fecha_ori . ' ' . $hora_ori)) {
            foreach ($citas as $row) {
                $date = new DateTime($row->fech_cit);
                $fecha_cit = date('Y-m-d', $date->getTimestamp());
                $hora_cit = date('H:i', $date->getTimestamp());
                if ($fecha_cit == $fecha && $hora == $hora_cit) {
                    $sw = true;
                    break;
                }
            }
        }
        if ($sw) {
            $this->session->set_userdata('error_editar_cita', 'A');
            $this->session->set_userdata('error_editar_cita_codigo', $codigo);
            header('Location: ' . base_url() . 'citas');
        } else {
            $codi_pac = -1;
            foreach ($pacientes as $row) {
                if ($nombre_pac == ($row->nomb_pac . ' ' . $row->apel_pac)) {
                    $codi_pac = $row->codi_pac;
                    break;
                }
            }

            $data = array(
                'codi_pac' => $codi_pac,
                'codi_med' => $codi_med,
                'fech_cit' => $fecha . ' ' . $hora
            );

            if ($observacion) {
                $data['obsv_cit'] = $observacion;
            }

            $this->mod_cita->update_cit($codigo, $data);
            $this->session->set_userdata('mensaje_cita', 'Una cita médica ha sido actualizada exitosamente');
            header('Location: ' . base_url('citas'));
        }
    }

    public function deshabilitar() {
        $codigo = $this->input->post('codigo');
        $this->mod_cita->update_cit($codigo, array("esta_cit" => "D"));
        $this->session->set_userdata('mensaje_cita', 'Una cita médica ha sido deshabilitada exitosamente');
    }

    public function finalizar_cita() {
        $codi_cit = $this->input->post('cita');
        $dientes = json_decode($this->input->post('tbl_diente'));
        $enfermedad = json_decode($this->input->post('tbl_enfermedad'));
        $procedimiento = json_decode($this->input->post('tbl_procedimiento'));
        $total = $this->input->post('total');
        $cita_medica = $this->mod_cita->get_cita("", array("codi_cit" => $codi_cit));

        date_default_timezone_set('America/Lima');
        $fecha = date("Y-m-d H:i:s");
        $fecha_his = date("Y-m-d");
        $factura = array(
            'fech_fac' => $fecha,
            'sesi_fac' => "1",
            'tota_fac' => $total
        );

        $codi_fac = $this->mod_cita->insert_fac($factura);
        $odontogramas = $this->mod_odontograma->get_vodontograma();
        for ($i = 0; $i < count($dientes); $i++) {
            for ($j = 0; $j < count($enfermedad); $j++) {
                if ($enfermedad[$j][0] == $dientes[$i][0]) {
                    $codi_enf = $enfermedad[$j][1];

                    $data_hie = array(
                        'codi_cit' => $codi_cit,
                        'codi_enf' => $codi_enf,
                        'num_die' => $dientes[$i][0]
                    );

                    $codi_hie = $this->mod_cita->insert_hie($data_hie);
                }
            }

            $estado = $this->mod_cita->get_edi(array('nomb_edi' => $dientes[$i][1]));
            $sw_odo = true;
            foreach ($odontogramas as $row) {
                if ($row->codi_pac == $cita_medica[0]->codi_pac && $row->num_die == $dientes[$i][0]) {
                    $codi_odo = $row->codi_odo;
                    $data_die = array(
                        'codi_cit' => $codi_cit,
                        'codi_edi' => $estado->codi_edi,
                        'part_die' => $dientes[$i][2]
                    );

                    $this->mod_cita->update_die($row->codi_die, $data_die);
//                    $data_odo = array(
//                        'part_die' => '000000'
//                    );
//                    $this->mod_cita->update_odo($codi_odo, $data_odo);
                    $data_his = array(
                        'codi_pac' => $row->codi_pac,
                        'codi_cit' => $codi_cit,
                        'codi_die' => $row->codi_die,
                        'id_die' => $row->id_die,
                        'num_die' => $row->num_die,
                        'codi_edi' => $estado->codi_edi,
                        'part_die' => $dientes[$i][2],
                        'fech_his' => $fecha_his
                    );

                    $this->mod_cita->insert_his($data_his);
                    $sw_odo = false;
                    break;
                }
            }

            if ($sw_odo) {
                $id_die = 1;
                $dientes_r = array('18', '17', '16', '15', '14', '13', '12', '11', '21', '22', '23', '24', '25', '26', '27', '28', '48', '47', '46', '45', '44', '43', '42', '41', '31', '32', '33', '34', '35', '36', '37', '38');
                for ($j = 0; $j < count($dientes_r); $j++) {
                    if ($dientes_r[$j] == $dientes[$i][0]) {
                        $id_die = $j + 1;
                    } else {
                        $id_die = 1;
                    }
                }

                $data = array(
                    'codi_pac' => $cita_medica[0]->codi_pac,
                    'codi_cit' => $codi_cit,
                    'id_die' => $id_die,
                    'num_die' => $dientes[$i][0],
                    'codi_edi' => $estado->codi_edi,
                    'part_die' => $dientes[$i][2]
                );

                $codi_die = $this->mod_cita->insert_die($data);
                $data_odo = array(
                    'part_die' => '000000',
                    'codi_die' => $codi_die
                );

                $codi_odo = $this->mod_cita->insert_odo($data_odo);
                $data_his = array(
                    'codi_pac' => $cita_medica[0]->codi_pac,
                    'codi_cit' => $codi_cit,
                    'codi_die' => $codi_die,
                    'id_die' => $id_die,
                    'num_die' => $dientes[$i][0],
                    'codi_edi' => $estado->codi_edi,
                    'part_die' => $dientes[$i][2],
                    'fech_his' => $fecha_his
                );
                $this->mod_cita->insert_his($data_his);
            }

            for ($j = 0; $j < count($procedimiento); $j++) {
                if ($procedimiento[$j][0] == $dientes[$i][0]) {
                    $codi_tar = $procedimiento[$j][1];
                    $aseg_pro = $procedimiento[$j][2];
                    $precio = $procedimiento[$j][4];

                    $data_dpr = array(
                        'codi_odo' => $codi_odo,
                        'codi_tar' => $codi_tar,
                        'aseg_dpr' => $aseg_pro
                    );

                    $codi_dpr = $this->mod_cita->insert_dpr($data_dpr);
                    $data_hip = array(
                        'codi_cit' => $codi_cit,
                        'codi_dpr' => $codi_dpr
                    );

                    $codi_hip = $this->mod_cita->insert_hip($data_hip);

                    $dfa = array(
                        'codi_dpr' => $codi_dpr,
                        'codi_fac' => $codi_fac,
                        'precio' => $precio
                    );
                    $codi_dfa = $this->mod_cita->insert_dfa($dfa);
                }
            }
        }

        $this->mod_cita->update_cit($codi_cit, array("esta_cit" => "T"));
        $this->session->set_userdata('mensaje_cita', 'La cita médica ha sido finalizada con éxito');
        $this->session->set_userdata('codi_fac', $codi_fac);
        $this->session->set_userdata('tbl_diente', $this->input->post('tbl_diente'));
        $this->session->set_userdata('codi_cit', $codi_cit);
        header('Location: ' . base_url('citas'));
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
