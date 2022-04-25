<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Caja extends CI_Controller
{

	public function __construct(){
        parent::__construct();
            $this->load->model(array('Clientes_model'));
			$this->validateSession();
	}
  
	public function index(){
		$total_v = 0;
		//Definimos zonas horaria para corregir desfases de tiempo
        date_default_timezone_set("America/Mexico_City");
		$datos=array();

		$begin_date = date("Y-m-d");
		$end_date = date("Y-m-d");

		/*TDC*/
		$datos['total_tdc'] = $this->Clientes_model->getTotalTdc($begin_date, $end_date)->result();
		$datos['total_tdcPQ'] = $this->Clientes_model->getTotalTdcPQ($begin_date, $end_date)->result();

		/*TDD*/
		$datos['total_tdd'] = $this->Clientes_model->getTotalTdd($begin_date, $end_date)->result();
		$datos['total_tddPQ'] = $this->Clientes_model->getTotalTddPQ($begin_date, $end_date)->result();

		/*TCASH*/
		$datos['total_cash'] = $this->Clientes_model->getTotalCash($begin_date, $end_date)->result();
		$datos['total_cashPQ'] = $this->Clientes_model->getTotalCashPQ($begin_date, $end_date)->result();

		/*TB*/
		$datos['total_tb'] = $this->Clientes_model->getTotalTB($begin_date, $end_date)->result();
		$datos['total_tbPQ'] = $this->Clientes_model->getTotalTBPQ($begin_date, $end_date)->result();

		/* Total Venta */
		$data_totales = $this->Clientes_model->getTotalVenta($begin_date, $end_date)->result();

		for($i = 0; $i<count($data_totales); $i++){
			$total_v = $total_v + $data_totales[$i]->cantidad;
		}
		/* END total venta */
		$datos['total_venta'] = $total_v;
		/*06/01/2020 NOV CAJA*/
		$this->load->view('v_Caja', $datos);
	}

	public function caja_test(){
		//Definimos zonas horaria para corregir desfases de tiempo
        date_default_timezone_set("America/Mexico_City");
		$datos=array();

		$begin_date = date("Y-m-d");
		$end_date = date("Y-m-d");

		/*TDC*/
		$datos['total_tdc'] = $this->Clientes_model->getTotalTdc($begin_date, $end_date)->result();
		$datos['total_tdcPQ'] = $this->Clientes_model->getTotalTdcPQ($begin_date, $end_date)->result();

		/*TDD*/
		$datos['total_tdd'] = $this->Clientes_model->getTotalTdd($begin_date, $end_date)->result();
		$datos['total_tddPQ'] = $this->Clientes_model->getTotalTddPQ($begin_date, $end_date)->result();

		/*TCASH*/
		$datos['total_cash'] = $this->Clientes_model->getTotalCash($begin_date, $end_date)->result();
		$datos['total_cashPQ'] = $this->Clientes_model->getTotalCashPQ($begin_date, $end_date)->result();

		$this->load->view('v_caja_resp', $datos);
	}
	
	public function validateSession()
    {
        if ($this->session->userdata("inicio_sesion")['id'] == "") {
            redirect(base_url());
        }
    }

}