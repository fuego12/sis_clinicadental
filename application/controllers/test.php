<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class test extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
    
    public function ancho_completo(){
        
        $data['container'] = $this->load->view('test/full-width', null, true);
        
        $this->load->view('home/body', $data);
    }
    
    public function sidebar(){
        
        $data['container'] = $this->load->view('test/sidebar', null, true);
        
        $this->load->view('home/body', $data);
    }
}
