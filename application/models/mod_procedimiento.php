<?php

class mod_procedimiento extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function get_historial_proc($codi_cit) {
        $this->db->where('codi_cit', $codi_cit);
        $consulta = $this->db->get('vhistorial_proc');
        return $consulta->result();
    }

    function get_categoria() {

        $consulta = $this->db->get("categoria");
        return $consulta->result();
    }

    function get_procedimiento() {

        $consulta = $this->db->get("procedimiento");
        return $consulta->result();
    }

    function get_procedimientos() {

        $consulta = $this->db->get("procedimiento");
        return $consulta->result();
    }

    function get_tarifa() {
        $consulta = $this->db->get("vtarifa");
        return $consulta->result();
    }
    
    function get_tbl_tarifa() {
        $consulta = $this->db->get("tarifa_proc");
        return $consulta->result();
    }

    function get_tarifa_2($where) {
        $this->db->where($where);
        $consulta = $this->db->get("tarifa_proc");
        return $consulta->row();
    }

    function insert_tar($data) {
        $this->db->insert('tarifa_proc', $data);
    }

    function insert_pro($data) {
        $this->db->insert('procedimiento', $data);
    }

    function agregar_pro($data) {
        $this->db->insert('procedimiento', $data);
    }

    function agregar_cat($data) {
        $this->db->insert('categoria', $data);
    }

    function update_pro($id, $data) {
        $this->db->where('codi_tar', $id);
        $this->db->update('tarifa_proc', $data);
    }
    function update_costo($pro, $cat, $costo) {
        $this->db->where(array('codi_pro' => $pro, 'codi_cat' => $cat));
        $this->db->update('tarifa_proc', array('cost_tar' => $costo));
    }
    function data_tarifa($codigo) {

        $this->db->where($codigo);
        $consulta = $this->db->get("vtarifa");
        return $consulta->result();
    }

}
