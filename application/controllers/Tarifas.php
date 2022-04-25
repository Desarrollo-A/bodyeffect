<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarifas extends CI_Controller
{

	public function __construct(){
		parent::__construct();
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Headers: Content-Type');
		$this->validateSession();
		$this->load->model("Tarifas_model");
	}

	public function index(){
		$this->load->view('v_Tarifas');
	}

    public function getAllAreas(){
        $data = $this->Tarifas_model->getAllAreas()->result_array();
		echo json_encode( array( "data" => $data ));
    }

	public function validateSession(){
        if ($this->session->userdata("inicio_sesion")['id'] == "") {
            redirect(base_url());
        }
    }

	public function updatePrice(){
        $area = $this->input->post("idArea");
        $costo = $this->input->post("costo");
		$duracion = $this->input->post("duracion");
		$data = $this->Tarifas_model->updatePrice($area, $costo, $duracion);

		echo json_encode($data);
	}

	public function changeStatus($status, $id_area){
		$data = $this->Tarifas_model->changeStatus($status, $id_area);
		echo json_encode($data);

	}
}
