<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class factura extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('mod_factura', 'mod_odontograma', 'mod_paciente', 'mod_cita','mod_clinica'));
        $this->load->library('session');
    }

    public function show_pdf() {

        $codigo_factura = $this->session->userdata('codi_fac');
        $this->session->unset_userdata('codi_fac');

        $resultado = $this->mod_factura->get_factura(array("codi_fac" => $codigo_factura));
        $clinica = $this->mod_clinica->get_clinica();
        // *********************** CABECERA ******************************************* //

        $this->load->library('fpdf');

        $this->fpdf->AddPage('L', array(235, 210));
        // CABECERA
        // 
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
        $this->fpdf->Ln(35);
        $this->fpdf->SetFont('Times', "", 12);

        $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
        $meses = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");

        $timestamp = strtotime($resultado[0]->fech_fac);
        $fecha = $dias[date('w', $timestamp)] . ', ' . date('j', $timestamp) . ' de ' . $meses[date('n', $timestamp) - 1] . ' del ' . date('Y', $timestamp) . ' - ' . date('h:i A', $timestamp);

        $this->fpdf->Cell(0, 0, utf8_decode($fecha), 0, 0, 'L');

        $this->fpdf->SetFont('Times', "B", 12);
        $this->fpdf->Ln(10);
        $this->fpdf->Cell(0, 0, utf8_decode('Médico: ..............................................................................................'), 0, 0, 'L');
        $this->fpdf->Ln(6);
        $this->fpdf->Cell(95, 0, utf8_decode('Paciente: ' . $resultado[0]->nomb_pac . ' ' . $resultado[0]->apel_pac), 0, 0, 'L');
        $this->fpdf->SetFont('Times', "", 12);
//        $this->fpdf->Cell(0, 0, utf8_decode('Sección: ' . $resultado[0]->sesi_fac), 0, 0, 'L');
        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', "B", 12);
        $this->fpdf->SetDrawColor(48, 113, 169);
        $this->fpdf->Cell(90, 10, utf8_decode("Procedimiento"), 'TB', 0, 'C');
        $this->fpdf->Cell(50, 10, utf8_decode("Costo"), 'TB', 0, 'C');
        $this->fpdf->Cell(25, 10, utf8_decode("Dscto"), 'TB', 0, 'C');
        $this->fpdf->Cell(50, 10, utf8_decode("Total"), 'TB', 0, 'C');
        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Times', "", 12);

        // ******************************* FIN DE CABECERA *****************************//////

        foreach ($resultado as $row) {

            $this->fpdf->Cell(90, 10, utf8_decode($row->num_die . ': ' . $row->desc_pro . ' (' . $row->nomb_cat . ')'), 0, 0, 'L');
            $this->fpdf->Cell(50, 10, utf8_decode("S/. " . $row->cost_tar), 0, 0, 'C');
            $this->fpdf->Cell(30, 10, utf8_decode($row->aseg_dpr . '%'), 0, 0, 'C');
            $this->fpdf->Cell(50, 10, utf8_decode('S/. ' . $row->precio), 0, 0, 'C');
            $this->fpdf->Ln(10);

//            $pos = strpos($row->part_die, '0');
//
//            if ($pos === false) {
//                $piezas = "[Pieza completa] " . $row->num_die;
//            } else {
//                $piezas = "[Piezas] ";
//                for ($i = 0; $i < 5; $i++) {
//                    if ($i == 0 && $row->part_die[$i] == 'M') {
//                        $piezas .= $row->num_die . ':M ';
//                    } else if ($i == 1 && $row->part_die[$i] == 'D') {
//                        $piezas .= $row->num_die . ':D ';
//                    } else if ($i == 2 && $row->part_die[$i] == 'V') {
//                        $piezas .= $row->num_die . ':V ';
//                    } else if ($i == 3 && $row->part_die[$i] == 'L') {
//                        $piezas .= $row->num_die . ':L ';
//                    } else if ($i == 3 && $row->part_die[$i] == 'P') {
//                        $piezas .= $row->num_die . ':P ';
//                    } else if ($i == 4 && $row->part_die[$i] == 'O') {
//                        $piezas .= $row->num_die . ':O ';
//                    } else if ($i == 4 && $row->part_die[$i] == 'I') {
//                        $piezas .= $row->num_die . ':I ';
//                    }
//                }
//            }
//            $this->fpdf->SetLeftMargin(20);
//            $this->fpdf->SetFont('Times', "", 11);
//            $this->fpdf->Cell(90, 3, utf8_decode($piezas), 0, 0, 'L');
//            $this->fpdf->SetFont('Times', "", 12);
//            $this->fpdf->SetLeftMargin(10);
//            $this->fpdf->Ln(5);
        }
        $this->fpdf->SetLeftMargin(10);
        $this->fpdf->Cell(215, 3, utf8_decode(""), 'B', 0, 'L');
        $this->fpdf->SetLeftMargin(30);
        $this->fpdf->Ln(7);
        $this->fpdf->SetFont('Times', "B", 12);
        $this->fpdf->Cell(0, 0, utf8_decode("Total: S/. " . $row->tota_fac), 0, 0, 'R');

        $this->fpdf->SetFont('Times', "", 12);
        $this->fpdf->SetLeftMargin(10);
        $this->fpdf->Ln(30);
        $this->fpdf->SetDrawColor(0, 0, 0);
        $this->fpdf->Cell(80, 10, utf8_decode(""), "T", 0, 'C');
        $this->fpdf->SetLeftMargin(145);
        $this->fpdf->Cell(80, 10, utf8_decode($resultado[0]->nomb_pac . ' ' . $resultado[0]->apel_pac), "T", 0, 'C');

        /*         * ********************** REPORTE DE ODONTOGRAMA ************************************************ */

        $this->fpdf->SetLeftMargin(10);

        $codigo_cit = $this->session->userdata('codi_cit');
        $this->session->unset_userdata('codi_cit');

        $odontograma = $this->mod_odontograma->get_odontograma_r(array('codi_cit' => $codigo_cit));

        $this->fpdf->AddPage();
        // CABECERA
        // 
        $this->fpdf->SetLeftMargin(30);
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
        $this->fpdf->Ln(35);
        $this->fpdf->SetFont('Times', "", 12);

        $this->fpdf->Cell(0, 0, utf8_decode($fecha), 0, 0, 'L');

        $this->fpdf->SetFont('Times', "B", 12);
        $this->fpdf->Ln(10);
        $this->fpdf->Cell(0, 0, utf8_decode('Médico: ' . $odontograma[0]->nomb_med . ' ' . $odontograma[0]->apel_med), 0, 0, 'L');
        $this->fpdf->Ln(6);
//        $this->fpdf->Cell(95, 0, utf8_decode('Paciente: ' . $resultado[0]->nomb_pac . ' ' . $resultado[0]->apel_pac), 0, 0, 'L');
        $this->fpdf->Cell(95, 0, utf8_decode('Paciente: ' . $odontograma[0]->apel_pac . ', ' . $odontograma[0]->nomb_pac), 0, 0, 'L');
        $this->fpdf->SetFont('Times', "", 12);
        $this->fpdf->Ln(12);
        $this->fpdf->Cell(0, 0, utf8_decode('REPORTE GRÁFICO DE ODONTOGRAMA'), 0, 0, 'C');

        $tbl_diente = json_decode($this->session->userdata('tbl_diente'));
        $this->session->unset_userdata('tbl_diente');

        $this->fpdf->Ln(20);

        $num_die_1 = array('18', '17', '16', '15', '14', '13', '12', '11', '21', '22', '23', '24', '25', '26', '27', '28');


        $y = 25;
        for ($j = 0; $j < count($num_die_1); $j++) {
            $sw = true;
            for ($i = 0; $i < count($tbl_diente); $i++) {
                if ($tbl_diente[$i][0] == $num_die_1[$j]) {
                    $diente = $tbl_diente[$i][0];
                    $estado = $this->mod_cita->get_edi(array('nomb_edi' => $tbl_diente[$i][1]));
                    $codi_edi = $estado->codi_edi;
                    if (getimagesize(base_url() . 'resources/images/odontograma/' . $diente . '/' . $diente . '_' . $codi_edi . '.jpg')) {
                        $this->fpdf->Image(base_url() . 'resources/images/odontograma/' . $diente . '/' . $diente . '_' . $codi_edi . '.jpg', $y, 105, 0, 17);
                    } else {
                        $this->fpdf->Image(base_url() . 'resources/images/odontograma/' . $tbl_diente[$i][0] . '/' . $tbl_diente[$i][0] . '.jpg', $y, 105, 0, 17);
                    }
                    $sw = false;
                }
            }
            if ($sw) {
                $this->fpdf->Image(base_url() . 'resources/images/odontograma/' . $num_die_1[$j] . '/' . $num_die_1[$j] . '.jpg', $y, 105, 0, 17);
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
            for ($i = 0; $i < count($tbl_diente); $i++) {
                if ($tbl_diente[$i][0] == $num_die_2[$j]) {
                    $diente = $tbl_diente[$i][0];
                    $estado = $this->mod_cita->get_edi(array('nomb_edi' => $tbl_diente[$i][1]));
                    $codi_edi = $estado->codi_edi;
                    if (getimagesize(base_url() . 'resources/images/odontograma/' . $diente . '/' . $diente . '_' . $codi_edi . '.jpg')) {
                        $this->fpdf->Image(base_url() . 'resources/images/odontograma/' . $diente . '/' . $diente . '_' . $codi_edi . '.jpg', $y2, 142, 0, 17);
                    } else {
                        $this->fpdf->Image(base_url() . 'resources/images/odontograma/' . $tbl_diente[$i][0] . '/' . $tbl_diente[$i][0] . '.jpg', $y2, 142, 0, 17);
                    }
                    $sw = false;
                }
            }
            if ($sw) {
                $this->fpdf->Image(base_url() . 'resources/images/odontograma/' . $num_die_2[$j] . '/' . $num_die_2[$j] . '.jpg', $y2, 142, 0, 17);
            }
            $y2 += 10;
        }
        
        // BORDES
        $this->fpdf->SetDrawColor(190);
        $this->fpdf->Rect(23, 104, 10, 28);
        $this->fpdf->Rect(33, 104, 10, 28);
        $this->fpdf->Rect(43, 104, 10, 28);
        $this->fpdf->Rect(53, 104, 10, 28);
        $this->fpdf->Rect(63, 104, 10, 28);
        $this->fpdf->Rect(73, 104, 10, 28);
        $this->fpdf->Rect(83, 104, 10, 28);
        $this->fpdf->Rect(93, 104, 10, 28);
        $this->fpdf->Rect(103, 104, 10, 28);
        $this->fpdf->Rect(113, 104, 10, 28);
        $this->fpdf->Rect(123, 104, 10, 28);
        $this->fpdf->Rect(133, 104, 10, 28);
        $this->fpdf->Rect(143, 104, 10, 28);
        $this->fpdf->Rect(153, 104, 10, 28);
        $this->fpdf->Rect(163, 104, 10, 28);
        $this->fpdf->Rect(173, 104, 10, 28);

        $this->fpdf->Rect(23, 132, 10, 28);
        $this->fpdf->Rect(33, 132, 10, 28);
        $this->fpdf->Rect(43, 132, 10, 28);
        $this->fpdf->Rect(53, 132, 10, 28);
        $this->fpdf->Rect(63, 132, 10, 28);
        $this->fpdf->Rect(73, 132, 10, 28);
        $this->fpdf->Rect(83, 132, 10, 28);
        $this->fpdf->Rect(93, 132, 10, 28);
        $this->fpdf->Rect(103, 132, 10, 28);
        $this->fpdf->Rect(113, 132, 10, 28);
        $this->fpdf->Rect(123, 132, 10, 28);
        $this->fpdf->Rect(133, 132, 10, 28);
        $this->fpdf->Rect(143, 132, 10, 28);
        $this->fpdf->Rect(153, 132, 10, 28);
        $this->fpdf->Rect(163, 132, 10, 28);
        $this->fpdf->Rect(173, 132, 10, 28);
        $this->fpdf->SetDrawColor(0);

        $this->fpdf->Ln(30);
        $this->fpdf->SetFont('Times', 'B', 11);
        $this->fpdf->Cell(20, 10, utf8_decode("N°"), 1, 0, 'C');
        $this->fpdf->Cell(40, 10, utf8_decode("Estado"), 1, 0, 'C');
        $this->fpdf->Cell(65, 10, utf8_decode("Partes"), 1, 0, 'C');
        $this->fpdf->Cell(70, 10, utf8_decode("Enfermedad"), 1, 0, 'C');

        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Times', '', 11);

        foreach ($odontograma as $row) {

            $this->fpdf->Cell(20, 10, utf8_decode($row->num_die), 1, 0, 'C');
            $this->fpdf->Cell(40, 10, utf8_decode($row->nomb_edi), 1, 0, 'C');

            $partes_descripcion = "";

            $partes = $row->part_die;

            $pos = strpos($partes, '0');

            if ($pos === false) {
                $partes_descripcion = "Pieza completa";
            } else {
                if ($partes[0] == "M") {
                    $partes_descripcion .= ' M ';
                }
                if ($partes[1] == "D") {
                    $partes_descripcion .= ' D ';
                }
                if ($partes[2] == "V") {
                    $partes_descripcion .= ' V ';
                }
                if ($partes[3] == "L") {
                    $partes_descripcion .= ' L ';
                } else if ($partes[3] == "P") {
                    $partes_descripcion .= ' P ';
                }
                if ($partes[4] == "O") {
                    $partes_descripcion .= ' O ';
                } else if ($partes[4] == "I") {
                    $partes_descripcion .= ' I ';
                }
            }
            $this->fpdf->Cell(65, 10, utf8_decode($partes_descripcion), 1, 0, 'C');
            $this->fpdf->Cell(70, 10, utf8_decode($row->desc_enf), 1, 0, 'C');
            $this->fpdf->Ln(10);
        }


        $this->fpdf->Output();
    }

    public function show_odo() {

        $fecha = "2014";
        // *********************** CABECERA ******************************************* //

        $this->load->library('fpdf');

        $codigo_cit = 41;

//        $odontograma = $this->mod_odontograma->get_odontograma_r(array('codi_cit'=>$codigo_cit));

        $this->fpdf->AddPage();
        // CABECERA
        // 
        $this->fpdf->Image('http://www.dubaisouqsme.com/images/default_logo.png', 10, 10, 0, 40);
        $this->fpdf->SetFont('Times', 'B', 16);
        $this->fpdf->Cell(160, 25, utf8_decode('Sucursal 1'), 0, 0, 'C');
        $this->fpdf->SetFont('Times', "", 14);
        $this->fpdf->Ln(6);
        $this->fpdf->Cell(160, 25, utf8_decode('Dirección #'), 0, 0, 'C');
        $this->fpdf->Ln(6);
        $this->fpdf->Cell(160, 25, utf8_decode('Teléfono #'), 0, 0, 'C');
        $this->fpdf->Ln(35);
        $this->fpdf->SetFont('Times', "", 12);

        $this->fpdf->Cell(0, 0, utf8_decode($fecha), 0, 0, 'L');

        $this->fpdf->SetFont('Times', "B", 12);
        $this->fpdf->Ln(10);
        $this->fpdf->Cell(0, 0, utf8_decode('Médico: '), 0, 0, 'L');
//        $this->fpdf->Cell(0, 0, utf8_decode('Médico: '. $odontograma[0]->nomb_med . ' ' . $odontograma[0]->apel_med), 0, 0, 'L');
        $this->fpdf->Ln(6);
        $this->fpdf->Cell(95, 0, utf8_decode('Paciente: '), 0, 0, 'L');

        $this->fpdf->Ln(12);
        $this->fpdf->Cell(0, 0, utf8_decode('REPORTE GRÁFICO DE ODONTOGRAMA'), 0, 0, 'C');
//       $this->fpdf->Cell(95, 0, utf8_decode('Paciente: '. $odontograma[0]->apel_pac . ', '. $odontograma[0]->nomb_pac), 0, 0, 'L');
        $this->fpdf->SetFont('Times', "", 12);
        $this->fpdf->Ln(20);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/18/18_1.jpg', 25, 95, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/17/17_1.jpg', 35, 95, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/16/16_1.jpg', 45, 95, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/15/15_1.jpg', 55, 95, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/14/14_1.jpg', 65, 95, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/13/13_1.jpg', 75, 95, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/12/12_1.jpg', 85, 95, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/11/11_1.jpg', 95, 95, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/21/21_1.jpg', 105, 95, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/22/22_1.jpg', 115, 95, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/23/23_1.jpg', 125, 95, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/24/24_1.jpg', 135, 95, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/25/25_1.jpg', 145, 95, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/26/26_1.jpg', 155, 95, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/27/27_1.jpg', 165, 95, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/28/28_1.jpg', 175, 95, 0, 17);

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

        $this->fpdf->Image(base_url() . 'resources/images/odontograma/48/48_1.jpg', 25, 132, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/47/47_1.jpg', 35, 132, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/46/46_1.jpg', 45, 132, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/45/45_1.jpg', 55, 132, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/44/44_1.jpg', 65, 132, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/43/43_1.jpg', 75, 132, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/42/42_1.jpg', 85, 132, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/41/41_1.jpg', 95, 132, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/31/31_1.jpg', 105, 132, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/32/32_1.jpg', 115, 132, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/33/33_1.jpg', 125, 132, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/34/34_1.jpg', 135, 132, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/35/35_1.jpg', 145, 132, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/36/36_1.jpg', 155, 132, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/37/37_1.jpg', 165, 132, 0, 17);
        $this->fpdf->Image(base_url() . 'resources/images/odontograma/38/38_1.jpg', 175, 132, 0, 17);

        // BORDES
        $this->fpdf->SetDrawColor(190);
        $this->fpdf->Rect(23, 94, 10, 28);
        $this->fpdf->Rect(33, 94, 10, 28);
        $this->fpdf->Rect(43, 94, 10, 28);
        $this->fpdf->Rect(53, 94, 10, 28);
        $this->fpdf->Rect(63, 94, 10, 28);
        $this->fpdf->Rect(73, 94, 10, 28);
        $this->fpdf->Rect(83, 94, 10, 28);
        $this->fpdf->Rect(93, 94, 10, 28);
        $this->fpdf->Rect(103, 94, 10, 28);
        $this->fpdf->Rect(113, 94, 10, 28);
        $this->fpdf->Rect(123, 94, 10, 28);
        $this->fpdf->Rect(133, 94, 10, 28);
        $this->fpdf->Rect(143, 94, 10, 28);
        $this->fpdf->Rect(153, 94, 10, 28);
        $this->fpdf->Rect(163, 94, 10, 28);
        $this->fpdf->Rect(173, 94, 10, 28);

        $this->fpdf->Rect(23, 122, 10, 28);
        $this->fpdf->Rect(33, 122, 10, 28);
        $this->fpdf->Rect(43, 122, 10, 28);
        $this->fpdf->Rect(53, 122, 10, 28);
        $this->fpdf->Rect(63, 122, 10, 28);
        $this->fpdf->Rect(73, 122, 10, 28);
        $this->fpdf->Rect(83, 122, 10, 28);
        $this->fpdf->Rect(93, 122, 10, 28);
        $this->fpdf->Rect(103, 122, 10, 28);
        $this->fpdf->Rect(113, 122, 10, 28);
        $this->fpdf->Rect(123, 122, 10, 28);
        $this->fpdf->Rect(133, 122, 10, 28);
        $this->fpdf->Rect(143, 122, 10, 28);
        $this->fpdf->Rect(153, 122, 10, 28);
        $this->fpdf->Rect(163, 122, 10, 28);
        $this->fpdf->Rect(173, 122, 10, 28);
        $this->fpdf->SetDrawColor(0);

        $this->fpdf->Ln(30);
        $this->fpdf->SetFont('Times', 'B', 11);
        $this->fpdf->Cell(20, 10, utf8_decode("N°"), 1, 0, 'C');
        $this->fpdf->Cell(40, 10, utf8_decode("Estado"), 1, 0, 'C');
        $this->fpdf->Cell(65, 10, utf8_decode("Partes"), 1, 0, 'C');
        $this->fpdf->Cell(70, 10, utf8_decode("Enfermedad"), 1, 0, 'C');

        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Times', '', 11);

//        foreach ($odontograma as $row) {
//            
//            $this->fpdf->Cell(20, 10, utf8_decode($row->num_die), 1, 0, 'C');
//            $this->fpdf->Cell(40, 10, utf8_decode($row->nomb_edi), 1, 0, 'C');
//            
//            $partes_descripcion = "";
//            
//            $partes = $row->part_die;
//            if ($partes[0] == "1") {
//                $partes_descripcion .= '[M]';
//            }
//            if ($partes[1] == "1") {
//                $partes_descripcion .= '[D]';
//            }
//            if ($partes[2] == "1") {
//                $partes_descripcion .= '[O]';
//            }
//            if ($partes[3] == "1") {
//                $partes_descripcion .= '[P]';
//            }
//            if ($partes[4] == "1") {
//                $partes_descripcion .= '[L]';
//            }
//            if ($partes[5] == "1") {
//                $partes_descripcion .= '[V]';
//            }
//            $this->fpdf->Cell(65, 10, utf8_decode($partes_descripcion), 1, 0, 'C');
//            $this->fpdf->Cell(70, 10, utf8_decode($row->desc_enf), 1, 0, 'C');
//            $this->fpdf->Ln(10);
//        }


        $this->fpdf->Output();
    }

}
