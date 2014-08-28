<?php

class odontograma2 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_odontograma', 'mod_paciente', 'mod_cita', 'mod_procedimiento', 'mod_clinica'));
        $this->load->library('session');
    }

    public function index() {
        if (!$this->logged()) {
            header('location: ' . base_url('login'));
        } else {
            $odo['pacientes'] = $this->mod_paciente->get_paciente_historial();
            $data['container'] = $this->load->view('odontograma/odontograma_search_view2', $odo, true);
            $data['clinica'] = $this->mod_clinica->get_clinica();
            $this->load->view('home/body', $data);
        }
    }

    public function odontograma_view($paciente = "", $cita = "") {
        if (!$this->logged()) {
            header('location: ' . base_url('login'));
        } else {

            if ($this->input->post('codi_cit') && $this->input->post('codi_pac')) {
                $paciente = $this->input->post('codi_pac');
                $cita = $this->input->post('codi_cit');
            }

            $this->session->set_userdata('codi_cit', $cita);
            $data['citas'] = $this->mod_cita->get_cita_paciente($paciente);
            $data['cita'] = $this->mod_cita->get_cita_detalle($cita);
//        $data['odontograma'] = $this->mod_odontograma->get_odontograma($cita, $view);
            $data['odontograma'] = $this->mod_odontograma->get_historial_cita($cita);
            $data['estado_diente'] = $this->mod_odontograma->get_estado();
            $data['enfermedad'] = $this->mod_odontograma->get_enfermedad();
            $data['dientes'] = array('18', '17', '16', '15', '14', '13', '12', '11', '21', '22', '23', '24', '25', '26', '27', '28', '48', '47', '46', '45', '44', '43', '42', '41', '31', '32', '33', '34', '35', '36', '37', '38');
            $data['paciente'] = $this->mod_paciente->get_paciente_row(array('codi_pac' => $paciente));
            $data['codi_cit'] = $cita;

            $odontograma = $this->mod_odontograma->get_odontograma_r(array('codi_cit' => $cita));
            $estados = array();
            foreach ($odontograma as $row) {
                $part_die = $row->part_die;
                $zona_die = '';

                $pos = strpos($part_die, '0');

                if ($pos === false) {
                    $zona_die = 'Pieza completa';
                } else {
                    for ($i = 0; $i < 5; $i++) {
                        $zona = substr($part_die, $i, 1);
                        if ($zona == 'M') {
                            $zona_die .= 'M ';
                        } else if ($zona == 'D') {
                            $zona_die .= 'D ';
                        } else if ($zona == 'V') {
                            $zona_die .= 'V ';
                        } else if ($zona == 'P') {
                            $zona_die .= 'P ';
                        } else if ($zona == 'L') {
                            $zona_die .= 'L ';
                        } else if ($zona == 'O') {
                            $zona_die .= 'O ';
                        } else if ($zona == 'I') {
                            $zona_die .= 'I ';
                        }
                    }
                }

                $fila['num_die'] =  $row->num_die;
                $fila['nomb_edi'] = $row->nomb_edi;
                $fila['part_die'] = $zona_die;
                $fila['enf_die'] = $row->desc_enf;
                $estados[] = $fila;
            }

            $data['estados'] = $estados;
            $data['proc_detalle'] = $this->mod_procedimiento->get_historial_proc($cita);
            $data['container'] = $this->load->view('odontograma/odontograma_view3', $data, true);
            $data['clinica'] = $this->mod_clinica->get_clinica();
            $this->load->view('home/body', $data);
        }
    }

    public function show_pdf($codi_cit) {
//        $codi_cit = $this->session->userdata('codi_cit');
//        $this->session->unset_userdata('codi_cit');
//        $codi_cit = 53;

        $cita_medica = $this->mod_cita->get_cita("", array('codi_cit' => $codi_cit));
        $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
        $meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
        $timestamp = strtotime($cita_medica[0]->fech_cit);
        $fecha = $dias[date('w', $timestamp)] . ', ' . date('j', $timestamp) . ' de ' . $meses[date('n', $timestamp) - 1] . ' del ' . date('Y', $timestamp) . ' - ' . date('h:i A', $timestamp);

        $clinica = $this->mod_clinica->get_clinica();
        
        $this->load->library('fpdf');
        $this->fpdf->AddPage();
        $this->fpdf->SetLeftMargin(35);

        $this->fpdf->Image('http://sisodontologia.hol.es/resources/images/clinica/logo.png', 35, 10, 0, 40);
        $this->fpdf->SetFont('Times', 'B', 24);
        $this->fpdf->Cell(160, 25, utf8_decode($clinica['nomb_clin']), 0, 0, 'C');
        $this->fpdf->SetFont('Times', "", 10);
        $this->fpdf->Ln(8);
        $this->fpdf->Cell(160, 25, utf8_decode('Dirección: '.$clinica['direc_clin']), 0, 0, 'C');
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(160, 25, utf8_decode('Teléfono: '.$clinica['telf_clin']), 0, 0, 'C');
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(160, 25, utf8_decode('R.U.C.: '.$clinica['ruc_clin']), 0, 0, 'C');
        $this->fpdf->Ln(5);
        $this->fpdf->Cell(160, 25, utf8_decode('E-mail: '.$clinica['email_clin']), 0, 0, 'C');
        $this->fpdf->SetLeftMargin(10);
        $this->fpdf->Ln(20);

        $this->fpdf->SetFont('Times', "", 12);
        $this->fpdf->Ln(10);
        $this->fpdf->Cell(0, 0, utf8_decode($fecha), 0, 0, 'L');
        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', "B", 12);
        $this->fpdf->Cell(0, 0, utf8_decode('Médico: ' . $cita_medica[0]->nomb_med . ' ' . $cita_medica[0]->apel_med), 0, 0, 'L');

        $this->fpdf->Ln(6);
        $this->fpdf->Cell(95, 0, utf8_decode('Paciente: ' . $cita_medica[0]->nomb_pac . ' ' . $cita_medica[0]->apel_pac), 0, 0, 'L');

        $this->fpdf->Ln(12);
        $this->fpdf->Cell(0, 0, utf8_decode('REPORTE DE CITA MÉDICA'), 0, 0, 'C');
        $this->fpdf->Ln(20);
        
        $historial = $this->mod_odontograma->get_historial_cita($codi_cit);
        $num_die_1 = array('18', '17', '16', '15', '14', '13', '12', '11', '21', '22', '23', '24', '25', '26', '27', '28');
        $y = 25;
        for ($j = 0; $j < count($num_die_1); $j++) {
            $sw = true;
            for ($i = 0; $i < count($historial); $i++) {
                if ($historial[$i]->num_die == $num_die_1[$j]) {
                    $diente = $historial[$i]->num_die;
                    $codi_edi = $historial[$i]->codi_edi;
                    if (getimagesize(base_url() . 'resources/images/odontograma/' . $diente . '/' . $diente . '_' . $codi_edi . '.jpg')) {
                        $this->fpdf->Image(base_url() . 'resources/images/odontograma/' . $diente . '/' . $diente . '_' . $codi_edi . '.jpg', $y, 100, 0, 17);
                    } else {
                        $this->fpdf->Image(base_url() . 'resources/images/odontograma/' . $historial[$i]->num_die . '/' . $historial[$i]->num_die . '.jpg', $y, 100, 0, 17);
                    }
                    $sw = false;
                }
            }
            if ($sw) {
                $this->fpdf->Image(base_url() . 'resources/images/odontograma/' . $num_die_1[$j] . '/' . $num_die_1[$j] . '.jpg', $y, 100, 0, 17);
            }
            $y += 10;
        }
        $this->fpdf->Ln(13);

        $this->fpdf->SetFont('Times', '', 11);
        $this->fpdf->SetLeftMargin(25);
        $this->fpdf->Cell(5, 0, '18', 0, 1, 'C');
        $this->fpdf->Cell(25, 0, '17', 0, 1, 'C');
        $this->fpdf->Cell(45, 0, '16', 0, 1, 'C');
        $this->fpdf->Cell(65, 0, '15', 0, 1, 'C');
        $this->fpdf->Cell(85, 0, '14', 0, 1, 'C');
        $this->fpdf->Cell(105, 0, '13', 0, 1, 'C');
        $this->fpdf->Cell(125, 0, '12', 0, 1, 'C');
        $this->fpdf->Cell(145, 0, '11', 0, 1, 'C');
        $this->fpdf->Cell(165, 0, '21', 0, 1, 'C');
        $this->fpdf->Cell(185, 0, '22', 0, 1, 'C');
        $this->fpdf->Cell(205, 0, '23', 0, 1, 'C');
        $this->fpdf->Cell(225, 0, '24', 0, 1, 'C');
        $this->fpdf->Cell(245, 0, '25', 0, 1, 'C');
        $this->fpdf->Cell(265, 0, '26', 0, 1, 'C');
        $this->fpdf->Cell(285, 0, '27', 0, 1, 'C');
        $this->fpdf->Cell(305, 0, '28', 0, 1, 'C');
        $this->fpdf->Ln(10);
        $this->fpdf->Cell(5, 0, '48', 0, 1, 'C');
        $this->fpdf->Cell(25, 0, '47', 0, 1, 'C');
        $this->fpdf->Cell(45, 0, '46', 0, 1, 'C');
        $this->fpdf->Cell(65, 0, '45', 0, 1, 'C');
        $this->fpdf->Cell(85, 0, '44', 0, 1, 'C');
        $this->fpdf->Cell(105, 0, '43', 0, 1, 'C');
        $this->fpdf->Cell(125, 0, '42', 0, 1, 'C');
        $this->fpdf->Cell(145, 0, '41', 0, 1, 'C');
        $this->fpdf->Cell(165, 0, '31', 0, 1, 'C');
        $this->fpdf->Cell(185, 0, '32', 0, 1, 'C');
        $this->fpdf->Cell(205, 0, '33', 0, 1, 'C');
        $this->fpdf->Cell(225, 0, '34', 0, 1, 'C');
        $this->fpdf->Cell(245, 0, '35', 0, 1, 'C');
        $this->fpdf->Cell(265, 0, '36', 0, 1, 'C');
        $this->fpdf->Cell(285, 0, '37', 0, 1, 'C');
        $this->fpdf->Cell(305, 0, '38', 0, 1, 'C');
        $this->fpdf->SetLeftMargin(10);
        $this->fpdf->Ln(10);
        
        $num_die_2 = array('48', '47', '46', '45', '44', '43', '42', '41', '31', '32', '33', '34', '35', '36', '37', '38');
        $y2 = 25;
        for ($j = 0; $j < count($num_die_2); $j++) {
            $sw = true;
            for ($i = 0; $i < count($historial); $i++) {
                if ($historial[$i]->num_die == $num_die_2[$j]) {
                    $diente = $historial[$i]->num_die;
                    $codi_edi = $historial[$i]->codi_edi;
                    if (getimagesize(base_url() . 'resources/images/odontograma/' . $diente . '/' . $diente . '_' . $codi_edi . '.jpg')) {
                        $this->fpdf->Image(base_url() . 'resources/images/odontograma/' . $diente . '/' . $diente . '_' . $codi_edi . '.jpg', $y2, 137, 0, 17);
                    } else {
                        $this->fpdf->Image(base_url() . 'resources/images/odontograma/' . $historial[$i]->num_die . '/' . $historial[$i]->num_die . '.jpg', $y2, 137, 0, 17);
                    }
                    $sw = false;
                }
            }
            if ($sw) {
                $this->fpdf->Image(base_url() . 'resources/images/odontograma/' . $num_die_2[$j] . '/' . $num_die_2[$j] . '.jpg', $y2, 137, 0, 17);
            }
            $y2 += 10;
        }
        
        $this->fpdf->SetDrawColor(190);
        $this->fpdf->Rect(23, 99, 10, 28);
        $this->fpdf->Rect(33, 99, 10, 28);
        $this->fpdf->Rect(43, 99, 10, 28);
        $this->fpdf->Rect(53, 99, 10, 28);
        $this->fpdf->Rect(63, 99, 10, 28);
        $this->fpdf->Rect(73, 99, 10, 28);
        $this->fpdf->Rect(83, 99, 10, 28);
        $this->fpdf->Rect(93, 99, 10, 28);
        $this->fpdf->Rect(103, 99, 10, 28);
        $this->fpdf->Rect(113, 99, 10, 28);
        $this->fpdf->Rect(123, 99, 10, 28);
        $this->fpdf->Rect(133, 99, 10, 28);
        $this->fpdf->Rect(143, 99, 10, 28);
        $this->fpdf->Rect(153, 99, 10, 28);
        $this->fpdf->Rect(163, 99, 10, 28);
        $this->fpdf->Rect(173, 99, 10, 28);
        
        $this->fpdf->Rect(23, 127, 10, 28);
        $this->fpdf->Rect(33, 127, 10, 28);
        $this->fpdf->Rect(43, 127, 10, 28);
        $this->fpdf->Rect(53, 127, 10, 28);
        $this->fpdf->Rect(63, 127, 10, 28);
        $this->fpdf->Rect(73, 127, 10, 28);
        $this->fpdf->Rect(83, 127, 10, 28);
        $this->fpdf->Rect(93, 127, 10, 28);
        $this->fpdf->Rect(103, 127, 10, 28);
        $this->fpdf->Rect(113, 127, 10, 28);
        $this->fpdf->Rect(123, 127, 10, 28);
        $this->fpdf->Rect(133, 127, 10, 28);
        $this->fpdf->Rect(143, 127, 10, 28);
        $this->fpdf->Rect(153, 127, 10, 28);
        $this->fpdf->Rect(163, 127, 10, 28);
        $this->fpdf->Rect(173, 127, 10, 28);
        $this->fpdf->SetDrawColor(0);
        
        $this->fpdf->SetLeftMargin(10);
        $this->fpdf->Ln(20);
        $this->fpdf->Cell(0, 8, utf8_decode('Diagnóstico'), 'B', 0, 'L');
        $this->fpdf->Ln(12);

        $this->fpdf->SetFont('Times', 'B', 11);
        $this->fpdf->Cell(20, 10, utf8_decode("N°"), 1, 0, 'C');
        $this->fpdf->Cell(40, 10, utf8_decode("Estado"), 1, 0, 'C');
        $this->fpdf->Cell(65, 10, utf8_decode("Zonas"), 1, 0, 'C');
        $this->fpdf->Cell(65, 10, utf8_decode("Enfermedad"), 1, 0, 'C');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', '', 11);

        $odontograma = $this->mod_odontograma->get_odontograma_r(array('codi_cit' => $codi_cit));

        foreach ($odontograma as $row) {

            $part_die = $row->part_die;
            $zona_die = '';

            $pos = strpos($part_die, '0');

            if ($pos === false) {
                $zona_die = 'Pieza completa';
            } else {
                for ($i = 0; $i < 5; $i++) {
                    $zona = substr($part_die, $i, 1);
                    if ($zona == 'M') {
                        $zona_die .= 'M ';
                    } else if ($zona == 'D') {
                        $zona_die .= 'D ';
                    } else if ($zona == 'V') {
                        $zona_die .= 'V ';
                    } else if ($zona == 'P') {
                        $zona_die .= 'P ';
                    } else if ($zona == 'L') {
                        $zona_die .= 'L ';
                    } else if ($zona == 'O') {
                        $zona_die .= 'O ';
                    } else if ($zona == 'I') {
                        $zona_die .= 'I ';
                    }
                }
            }

            $this->fpdf->Cell(20, 10, utf8_decode($row->num_die), 1, 0, 'C');
            $this->fpdf->Cell(40, 10, utf8_decode($row->nomb_edi), 1, 0, 'C');
            $this->fpdf->Cell(65, 10, utf8_decode($zona_die), 1, 0, 'C');
            $this->fpdf->Cell(65, 10, utf8_decode($row->desc_enf), 1, 0, 'C');
            $this->fpdf->Ln(10);
        }

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', 'B', 12);
        $this->fpdf->Cell(0, 8, utf8_decode('Procedimientos'), 'B', 0, 'L');
        $this->fpdf->Ln(12);

        $this->fpdf->SetFont('Times', 'B', 11);
        $this->fpdf->Cell(20, 10, utf8_decode("N°"), 1, 0, 'C');
        $this->fpdf->Cell(60, 10, utf8_decode("Procedimiento"), 1, 0, 'C');
        $this->fpdf->Cell(50, 10, utf8_decode("Categoría"), 1, 0, 'C');
        $this->fpdf->Cell(30, 10, utf8_decode("Costo"), 1, 0, 'C');
        $this->fpdf->Cell(30, 10, utf8_decode("Aseg."), 1, 0, 'C');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', '', 11);

        $procedimientos = $this->mod_procedimiento->get_historial_proc($codi_cit);

        foreach ($procedimientos as $row) {
            $this->fpdf->Cell(20, 10, utf8_decode($row->num_die), 1, 0, 'C');
            $this->fpdf->Cell(60, 10, utf8_decode($row->desc_pro), 1, 0, 'C');
            $this->fpdf->Cell(50, 10, utf8_decode($row->nomb_cat), 1, 0, 'C');
            $this->fpdf->Cell(30, 10, utf8_decode($row->cost_tar), 1, 0, 'C');
            $this->fpdf->Cell(30, 10, utf8_decode($row->aseg_dpr), 1, 0, 'C');
            $this->fpdf->Ln(10);
        }
        $this->fpdf->Output();
    }

    public function validarImgEstado() {
        $diente = $this->input->post('diente');
        $estado = $this->input->post('estado');

        $estados = $this->mod_cita->get_edi(array('nomb_edi' => $estado));
        if (getimagesize(base_url() . 'resources/images/odontograma/' . $diente . '/' . $diente . '_' . $estados->codi_edi . '.jpg')) {
            echo base_url() . 'resources/images/odontograma/' . $diente . '/' . $diente . '_' . $estados->codi_edi . '.jpg';
        }
    }

    public function logged() {
        return $this->session->userdata('logged');
    }

}
