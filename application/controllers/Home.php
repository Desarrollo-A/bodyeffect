<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller{
	function __construct(){
		parent::__construct();

		$this->load->model("Ajustes_model");
		date_default_timezone_set('America/Mexico_city');
		$this->validateSession();
	}

	public function index(){
		$this->validar_sesion();
		$this->load->view('welcome_message');
	}

	public function validar_sesion(){
		$id_usuario =  $this->session->userdata("inicio_sesion")['id'];
		if ($id_usuario == '' || $id_usuario == null || $id_usuario == NULL){
			redirect (base_url()."index.php/Login");
		}
	}

	public function get_total_dia(){
		$hoy = date('Y-m-d');
		$manana = date('Y-m-d', strtotime('+1 day', strtotime($hoy)));
		$ayer = date('Y-m-d', strtotime('-1 day', strtotime($hoy)));

		$data = $this->Ajustes_model->getTotalCobrosToday($hoy);
		if($data != null){
            echo json_encode($data);
		}
		else{
			echo json_encode(array());
		}
	}

	public function get_total_semana(){		
		$monday = date( 'Y-m-d', strtotime( 'monday this week' ));
		$sunday = date( 'Y-m-d', strtotime( 'sunday this week' ));
	
		$data = $this->Ajustes_model->getTotalCobrosWeek($monday, $sunday);
		if($data != null){
			echo json_encode($data);			
		}
		else{
			echo json_encode(array());
		}
	}

	public function validateSession()
    {
        if ($this->session->userdata("inicio_sesion")['id'] == "") {
            redirect(base_url());
        }
    }

}
