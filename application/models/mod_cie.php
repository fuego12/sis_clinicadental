<?php

class mod_cie extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_cie($where = array()) {
        $this->db->where($where);
        $consulta = $this->db->get("enfermedad");
        return $consulta->result();
    }

    function insert_cie($data) {
        $this->db->insert('enfermedad', $data);
    }

    function update_cie($id, $data) {
        $this->db->where('codi_enf', $id);
        $this->db->update('enfermedad', $data);
    }

}
