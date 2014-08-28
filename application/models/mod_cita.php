<?php

class mod_cita extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_cita($fecha = "", $where = array()) {
        if (count($where) > 0) {
            $this->db->where($where);
        }
        if ($fecha != "") {
            $this->db->like('fech_cit', $fecha, 'after');
            $this->db->order_by('fech_cit', 'desc');
        }
        $consulta = $this->db->get("vcitas_medicas");
        return $consulta->result();
    }
    function get_ultima_cita_terminada($codi_pac) {
        $this->db->where(array('codi_pac'=>$codi_pac,'esta_cit'=>'T'));
        $this->db->order_by('fech_cit', 'desc');
        $this->db->limit(1);
        $consulta = $this->db->get("vcitas_medicas");
        return $consulta->result();
    }

    function get_cita_paciente($paciente) {
        $this->db->where('codi_pac', $paciente);
        $this->db->order_by('fech_cit', 'desc');
        $consulta = $this->db->get("vcitas_medicas");
        return $consulta->result();
    }

    function get_cita_detalle($cita) {
        $this->db->where('codi_cit', $cita);
        $consulta = $this->db->get("vcitas_medicas");
        return $consulta->row();
    }

    function insert_cit($data) {
        $this->db->insert('cita_medica', $data);
    }

    function update_cit($id, $data) {
        $this->db->where('codi_cit', $id);
        $this->db->update('cita_medica', $data);
    }
    
    function insert_die($data) {
        $this->db->insert('diente', $data);
        return $this->db->insert_id();
    }
    
    function insert_his($data) {
        $this->db->insert('historial_paciente', $data);
        return $this->db->insert_id();
    }
    
    function insert_hip($data) {
        $this->db->insert('historial_proc', $data);
        return $this->db->insert_id();
    }
    
    function insert_hie($data) {
        $this->db->insert('historial_enf', $data);
        return $this->db->insert_id();
    }
    
    function insert_odo($data) {
        $this->db->insert('odontograma', $data);
        return $this->db->insert_id();
    }
    
    function update_odo($id, $data) {
        $this->db->where('codi_odo', $id);
        $this->db->update('odontograma', $data);
    }
    
    function update_die($id, $data) {
        $this->db->where('codi_die', $id);
        $this->db->update('diente', $data);
    }
    
    
    
    function insert_dpr($data) {
        $this->db->insert('detalle_proc', $data);
        return $this->db->insert_id();
    }
    
    function insert_fac($data) {
        $this->db->insert('factura', $data);
        return $this->db->insert_id();
    }
    
    function insert_dfa($data) {
        $this->db->insert('detalle_fac', $data);
        return $this->db->insert_id();
    }
    
    function get_edi($where = array()) {
        $this->db->where($where);
        $consulta = $this->db->get("estado_diente");
        return $consulta->row();
    }
    

}
