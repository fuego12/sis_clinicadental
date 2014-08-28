<?php

class odontograma extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_odontograma', 'mod_paciente', 'mod_cita', 'mod_procedimiento', 'mod_clinica'));
        $this->load->library('session');
    }

    public function index() {
        if (!$this->logged()) {
            header('location: ' . base_url('login'));
        } else {
            if (!$this->admin()) {
                header('location: ' . base_url('login'));
            } else {
                $odo['pacientes'] = $this->mod_paciente->get_pacientes(false);
                //$odo['pacientes'] = $this->mod_paciente->get_pacientes_historial();
                $data['container'] = $this->load->view('odontograma/odontograma_search_view', $odo, true);
                $data['clinica'] = $this->mod_clinica->get_clinica();
                $this->load->view('home/body', $data);
            }
        }
    }

    public function odontograma_view2($paciente, $cita) {
        if (!$this->logged()) {
            header('location: ' . base_url('login'));
        } else {
            if (!$this->admin()) {
                header('location: ' . base_url('login'));
            } else {
                $data['citas'] = $this->mod_cita->get_cita_paciente($paciente);
                $view = 'vhistorial';
                if ($cita == 0) {
                    foreach ($data['citas'] as $c) {
                        $cita = $c->codi_cit;
                        $view = 'vodontograma';
                        break;
                    }
                } else {
                    $ultima_cita = 1;
                    foreach ($data['citas'] as $c) {
                        $ultima_cita = $c->codi_cit;
                        break;
                    }
                    if ($ultima_cita == $cita) {
                        $view = 'vodontograma';
                    }
                }

                $data['cita'] = $this->mod_cita->get_cita_detalle($cita);
                $data['odontograma'] = $this->mod_odontograma->get_odontograma($cita, $view);
                $data['estado_diente'] = $this->mod_odontograma->get_estado();
                $data['enfermedad'] = $this->mod_odontograma->get_enfermedad();
                $data['dientes'] = array('18', '17', '16', '15', '14', '13', '12', '11', '21', '22', '23', '24', '25', '26', '27', '28', '48', '47', '46', '45', '44', '43', '42', '41', '31', '32', '33', '34', '35', '36', '37', '38');
                $data['paciente'] = $this->mod_paciente->get_paciente_row(array('codi_pac' => $paciente));
                $data['codi_cit'] = $cita;

                $estados = array();
                foreach ($data['odontograma'] as $d) {
                    $row = array();
                    $row['num_die'] = $d->num_die;
                    $row['codi_edi'] = $d->codi_edi;
                    $row['nomb_edi'] = $d->nomb_edi;

                    $enf_die = '';
                    $enfermedad = $this->mod_odontograma->get_diente_enfermedad($d->codi_die);
                    foreach ($enfermedad as $ed) {
                        $enf_die .= $ed->desc_enf . '<br>';
                    }
                    $row['enf_die'] = $enf_die;

                    $part_die = $d->part_die;
                    $zonas = array('Mesial', 'Distal', 'Oclusal', 'Palatino', 'Lingual', 'Vestibular');
                    $zona_die = '';

                    if ($part_die == '111111') {
                        $zona_die = 'Pieza completa';
                    } else {
                        for ($i = 0; $i < 6; $i++) {
                            $zona = substr($part_die, $i, 1);
                            if ($zona == '1') {
                                $zona_die .= $zonas[$i] . ' ';
                            }
                        }
                    }
                    $row['part_die'] = $zona_die;
                    $estados[] = $row;
                }
                $data['estados'] = $estados;

                //PROCEDIMIENTOS
                $data['enf_detalle'] = $this->mod_odontograma->get_diente_enfermedad_2($paciente);
                $data['procedimiento'] = $this->mod_procedimiento->get_procedimiento();
                $data['categoria'] = $this->mod_procedimiento->get_categoria();
                $data['proc_detalle'] = $this->mod_odontograma->get_detalle_procedimiento($paciente);
                $data['container'] = $this->load->view('odontograma/odontograma_view_2', $data, true);
                $this->load->view('home/body', $data);
            }
        }
    }

    public function odontograma_view($paciente, $cita) {
        if (!$this->logged()) {
            header('location: ' . base_url('login'));
        } else {
            if (!$this->admin()) {
                header('location: ' . base_url('login'));
            } else {
                $data['citas'] = $this->mod_cita->get_cita_paciente($paciente);
                $view = 'vhistorial';
                if ($cita == 0) {
                    foreach ($data['citas'] as $c) {
                        $cita = $c->codi_cit;
                        $view = 'vodontograma';
                        break;
                    }
                } else {
                    $ultima_cita = 1;
                    foreach ($data['citas'] as $c) {
                        $ultima_cita = $c->codi_cit;
                        break;
                    }
                    if ($ultima_cita == $cita) {
                        $view = 'vodontograma';
                    }
                }

                $data['cita'] = $this->mod_cita->get_cita_detalle($cita);
                $data['odontograma'] = $this->mod_odontograma->get_odontograma($cita, $view);
                $data['estado_diente'] = $this->mod_odontograma->get_estado();
                $data['enfermedad'] = $this->mod_odontograma->get_enfermedad();
                $data['dientes'] = array('18', '17', '16', '15', '14', '13', '12', '11', '21', '22', '23', '24', '25', '26', '27', '28', '48', '47', '46', '45', '44', '43', '42', '41', '31', '32', '33', '34', '35', '36', '37', '38');
                $data['paciente'] = $this->mod_paciente->get_paciente_row(array('codi_pac' => $paciente));
                $data['codi_cit'] = $cita;

                $estados = array();
                foreach ($data['odontograma'] as $d) {
                    $row = array();
                    $row['num_die'] = $d->num_die;
                    $row['codi_edi'] = $d->codi_edi;
                    $row['nomb_edi'] = $d->nomb_edi;

                    $enf_die = '';
                    $enfermedad = $this->mod_odontograma->get_diente_enfermedad($d->codi_die);
                    foreach ($enfermedad as $ed) {
                        $enf_die .= $ed->desc_enf . '<br>';
                    }
                    $row['enf_die'] = $enf_die;

                    $part_die = $d->part_die;
                    $zonas = array('Mesial', 'Distal', 'Oclusal', 'Palatino', 'Lingual', 'Vestibular');
                    $zona_die = '';

                    if ($part_die == '111111') {
                        $zona_die = 'Pieza completa';
                    } else {
                        for ($i = 0; $i < 6; $i++) {
                            $zona = substr($part_die, $i, 1);
                            if ($zona == '1') {
                                $zona_die .= $zonas[$i] . ' ';
                            }
                        }
                    }
                    $row['part_die'] = $zona_die;
                    $estados[] = $row;
                }
                $data['estados'] = $estados;

                //PROCEDIMIENTOS
                $data['enf_detalle'] = $this->mod_odontograma->get_diente_enfermedad_2($paciente);
                $data['procedimiento'] = $this->mod_procedimiento->get_procedimiento();
                $data['categoria'] = $this->mod_procedimiento->get_categoria();
                $data['proc_detalle'] = $this->mod_odontograma->get_detalle_procedimiento($paciente);
                $data['container'] = $this->load->view('odontograma/odontograma_view', $data, true);
                $this->load->view('home/body', $data);
            }
        }
    }

    public function historia_paciente() {
        $paciente = $this->input->post('codi_pac');
        $cita = $this->input->post('codi_cit');
        $this->odontograma_view($paciente, $cita);
    }

    public function abrir_cita() {
        $paciente = $this->input->post('codi_pac');
        $cita = $this->input->post('codi_cit');
        $this->mod_odontograma->abrir_cita($paciente, $cita);
        $this->odontograma_view($paciente, $cita);
    }

    public function cerrar_cita() {
        $paciente = $this->input->post('codi_pac');
        $cita = $this->input->post('codi_cit');
        $this->mod_odontograma->cerrar_cita($paciente, $cita);
        $this->odontograma_view($paciente, $cita);
    }

    public function update_diente_estado() {
        $where['codi_pac'] = $this->input->post('codi_pac');
        $where['num_die'] = $this->input->post('num_die');
        $data['codi_cit'] = $this->input->post('codi_cit');
        $data['codi_edi'] = $this->input->post('codi_edi');
        $completo = $this->input->post('completo');
        $diente['mesial'] = $this->input->post('mesial');
        $diente['distal'] = $this->input->post('distal');
        $diente['oclusal'] = $this->input->post('oclusal');
        $diente['palatino'] = $this->input->post('palatino');
        $diente['lingual'] = $this->input->post('lingual');
        $diente['vestibular'] = $this->input->post('vestibular');

        $part_die = '';
        if ($completo) {
            $part_die = '111111';
        } else {
            foreach ($diente as $p) {
                if ($p) {
                    $part_die .= '1';
                } else {
                    $part_die .= '0';
                }
            }
        }
        $data['part_die'] = $part_die;

        if (count($this->mod_odontograma->get_diente($where)) > 0) {
            $this->mod_odontograma->update_diente($where, $data, 'diente');
        } else {
            $data['codi_pac'] = $where['codi_pac'];
            $data['num_die'] = $where['num_die'];

            $id_die = 1;
            $dientes = array('18', '17', '16', '15', '14', '13', '12', '11', '21', '22', '23', '24', '25', '26', '27', '28', '48', '47', '46', '45', '44', '43', '42', '41', '31', '32', '33', '34', '35', '36', '37', '38');
            for ($i = 0; $i < 32; $i++) {
                $id_die = $dientes[$i] == $data['num_die'] ? $i + 1 : $id_die;
            }
            $data['id_die'] = $id_die;
            $this->mod_odontograma->insert_diente($data, 'diente');
        }
        $this->odontograma_view($where['codi_pac'], $data['codi_cit']);
    }

    public function update_diente_enfermedad() {
        $codi_pac = $this->input->post('codi_pac');
        $part_die = '000000';
        $codi_cit = $this->input->post('codi_cit');
        $data['part_die'] = $part_die;
        $data['codi_die'] = $this->input->post('codi_die');
        $data['codi_enf'] = $this->input->post('codi_enf');
        $this->mod_odontograma->insert_diente($data, 'odontograma');
        $this->odontograma_view($codi_pac, $codi_cit);
    }

    public function insert_procedimiento() {
        $codi_pro = $this->input->post('codi_pro');
        $codi_cat = $this->input->post('codi_cat');
        $codi_pac = $this->input->post('codi_pac');
        $codi_cit = $this->input->post('codi_cit');
        $data['codi_odo'] = $this->input->post('codi_odo');
        $tarifa = $this->mod_procedimiento->get_tarifa_2(array('codi_pro' => $codi_pro, 'codi_cat' => $codi_cat));
        $data['codi_tar'] = $tarifa->codi_tar;
        $data['aseg_dpr'] = $this->input->post('aseg_dpr');
        $this->mod_odontograma->insert_procedimiento($data);
        $this->odontograma_view($codi_pac, $codi_cit);
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
