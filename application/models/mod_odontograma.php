<?php

class mod_odontograma extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_historial_cita($codi_cit) {
        $this->db->where('codi_cit', $codi_cit);
        $consulta = $this->db->get('vhistorial');
        return $consulta->result();
    }
    
    function get_odontograma_r($where = array()) {
        $this->db->where($where);
        $consulta = $this->db->get('vodontograma_reporte');
        return $consulta->result();
    }
    function get_vodontograma($where = array()) {
        $this->db->where($where);
        $consulta = $this->db->get('vodontograma');
        return $consulta->result();
    }
    
    function get_odontograma($codi_cit, $view) {
        $this->db->where('codi_cit', $codi_cit);
        $this->db->order_by('id_die', 'asc');
        $consulta = $this->db->get($view);
        return $consulta->result();
    }

    function abrir_cita($paciente, $nueva_cita) {
        $this->db->where('codi_pac', $paciente);
        return $this->db->update('diente', array('codi_cit' => $nueva_cita));
    }

    function cerrar_cita($paciente, $cita) {
        $this->db->where('codi_cit', $cita);
        $this->db->order_by('id_die', 'asc');
        $consulta = $this->db->get("vodontograma");
        $odontograma = $consulta->result();
        foreach ($odontograma as $o) {
            $data['codi_pac'] = $o->codi_pac;
            $data['codi_cit'] = $o->codi_cit;
            $data['codi_die'] = $o->codi_die;
            $data['id_die'] = $o->id_die;
            $data['num_die'] = $o->num_die;
            $data['codi_edi'] = $o->codi_edi;
            $data['part_die'] = $o->part_die;
            $data['fech_his'] = $o->fech_cit;
            $this->insert_diente($data, 'historial_paciente');
        }
    }

    function get_estado() {
        $consulta = $this->db->get("estado_diente");
        return $consulta->result();
    }

    function get_enfermedad() {
        $consulta = $this->db->get("enfermedad");
        return $consulta->result();
    }

    function get_diente_enfermedad($codi_die) {
        $this->db->where('codi_die', $codi_die);
        $consulta = $this->db->get("vdiente_enfermedad");
        return $consulta->result();
    }
    
    function get_diente_enfermedad_2($paciente) {
        $this->db->where('codi_pac', $paciente);
        $consulta = $this->db->get("vdiente_enfermedad_2");
        return $consulta->result();
    }
    
    function get_detalle_procedimiento($paciente) {
        $this->db->where('codi_pac', $paciente);
        $consulta = $this->db->get("vdetalle_procedimiento");
        return $consulta->result();
    }

    function get_diente($where) {
        $this->db->where($where);
        $consulta = $this->db->get('diente');
        return $consulta->row();
    }

    function insert_diente($data, $tabla) {
        return $this->db->insert($tabla, $data);
    }

    function update_diente($where, $data, $tabla) {
        $this->db->where($where);
        return $this->db->update($tabla, $data);
    }
    
    public function insert_procedimiento($data){
        return $this->db->insert('detalle_proc', $data);
    }

}
