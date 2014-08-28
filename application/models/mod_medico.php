<?php

class mod_medico extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_medico($where = "") {
        if ($where == "") {
            $this->db->where('esta_med', 'A');
        } else {
            $this->db->where($where);
        }
        $consulta = $this->db->get("medico");
        return $consulta->result();
    }

    function insert_med($data) {
        $this->db->insert('medico', $data);
    }

    function update_med($id, $data) {
        $this->db->where('codi_med', $id);
        $this->db->update('medico', $data);
    }

}
