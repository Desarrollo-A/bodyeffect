<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller{

	public function __construct(){
        parent::__construct();
            $this->load->model(array('Reportes_model'));
			$this->validateSession();
	}

	public function index(){
		$this->load->view('v_Reportes');
	}
 
 
		public function get_pagos_pen_hoy(){
	   $data = $this->Reportes_model->get_pagos_pen_hoy()->result_array();
	   echo json_encode( array( "data" => $data ));
	}

	public function get_pagos_pen_manana(){
	   $data = $this->Reportes_model->get_pagos_pen_manana()->result_array();
	   echo json_encode( array( "data" => $data ));
	}

	public function get_pagos_pen(){
		$data = $this->Reportes_model->get_pagos_pen()->result_array();
		echo json_encode( array( "data" => $data ));
	 }


	public function get_citas_hoy(){
	   $data = $this->Reportes_model->get_citas_hoy()->result_array();
	   echo json_encode( array( "data" => $data ));
	}

	public function detalleCobranza()
	{
			$this->load->view('v_reporteCobranza');
	}
	
	public function validateSession()
    {
        if ($this->session->userdata("inicio_sesion")['id'] == "") {
            redirect(base_url());
        }
    }

}