<?php

class mod_factura extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_factura($where = array()) {
        $this->db->where($where);
        $consulta = $this->db->get("vfactura");
        return $consulta->result();
    }

}
