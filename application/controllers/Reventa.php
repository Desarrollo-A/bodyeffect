<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Reventa extends CI_Controller
{
	public function __construct(){
        parent::__construct();
            $this->load->model(array('Reventa_model'));
		$this->validateSession();
	}

	public function index(){}

	public function nueva_reventa($id_cliente){
		$data_cliente['data_cliente'] = $this->Reventa_model->getDataByClient($id_cliente);
		$data_cliente['data_cobros'] = $this->Reventa_model->getDataByCobro($id_cliente);
		//echo json_encode($data_cliente);
		//exit;
		$this->load->view('v_Reventa', $data_cliente);
	}

	public function get_clientes_activos(){
		$data = $this->Reventa_model->get_clientes_activos();
		if($data != null) echo json_encode($data);
		else echo json_encode(array());
	}

	public function getDataByCliente($id_cliente){
		$data = $this->Reventa_model->getDataByClient($id_cliente);

		if($data != null) echo json_encode($data);
		else echo json_encode(array());
	}
	
	public function validateSession()
    {
        if ($this->session->userdata("inicio_sesion")['id'] == "") {
            redirect(base_url());
        }
    }

}
