<?php

class mod_clinica extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_clinica() {
        $this->db->where('esta_clin', 'A');
        $consulta = $this->db->get('clinica');
        return $consulta->row_array();
    }

    function update_clinica($id, $data) {
        $this->db->where('id_clin', $id);
        $this->db->update('clinica', $data);
    }

}
