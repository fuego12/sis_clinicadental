<?php

class mod_paciente extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_paciente($where = "") {
        if ($where == "") {
            $this->db->where('esta_pac', 'A');
        } else {
            $this->db->where($where);
        }
        $consulta = $this->db->get("paciente");
        return $consulta->result();
    }

    function get_paciente_historial($where = array()) {
        $this->db->where($where);
        $consulta = $this->db->get("vpacientes_historial");
        return $consulta->result();
    }
    
    function get_pacientes() {
        $consulta = $this->db->get("paciente");
        return $consulta->result();
    }

    function get_paciente_row($where = "") {
        $this->db->where($where);
        $this->db->where('esta_pac', 'A');
        $consulta = $this->db->get('paciente');
        return $consulta->row();
    }

    function insert_pac($data) {
        $this->db->insert('paciente', $data);
    }

    function update_pac($id, $data) {
        $this->db->where('codi_pac', $id);
        $this->db->update('paciente', $data);
    }

}
