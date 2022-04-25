<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {
 

    public function __construct(){
        parent::__construct();
        if( !$this->session->userdata("inicio_sesion") )
          redirect("Login", "refresh");
        else
          $this->load->model('Login_model');
    }

    public function index(){
        $this->load->view("pagina_bienvenido");
    }
 

     public function close(){
        $this->session->sess_destroy();
        redirect(base_url());
    }



}