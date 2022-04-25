<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class ListaClientes extends CI_Controller
{

	public function __construct(){
		parent::__construct();
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Headers: Content-Type');
		$this->validateSession();
		$this->load->model("ListaClientes_model");
	}

	public function index(){
		$this->load->view('v_ListaClientes');
	}

	public function clientes_activos(){
		$beginDate = $this->input->post("beginDate");
        $endDate = $this->input->post("endDate");
	    $data = $this->ListaClientes_model->get_clientes_activos($beginDate, $endDate)->result_array();
	    echo json_encode( array( "data" => $data ));
	}
	
	public function ver_cliente($id_contrato){
		$data_contrato = $this->ListaClientes_model->get_data_cliente($id_contrato)->result_array();		
		if($data_contrato != null){
			echo json_encode($data_contrato);
		} 
		else{
			echo json_encode(array());
		};
	}

	function getDetallePaqueteByClient($id_cliente, $id_contrato){
		$data_cliente= $this->ListaClientes_model->getDetallePaqueteByClient($id_cliente, $id_contrato)->row() ;

		if($data_cliente != null){
			echo json_encode($data_cliente);
		} 
		else{
			echo json_encode(array());
		}
	}
	
	function getClientNoTitular($id_cliente, $id_contrato, $id_paquete){
		$data_cliente= $this->ListaClientes_model->getClientNoTitular($id_cliente, $id_contrato, $id_paquete)->row() ;
		if($data_cliente != null){
			echo json_encode($data_cliente);
		} 
		else{
			echo json_encode(array());
		}
	}

	function getnumeropaquetes($id_contrato){
		$data_cliente =$this->ListaClientes_model->getPaquetesAdByContrato($id_contrato)->result() ;
		if($data_cliente != null) {
			echo json_encode($data_cliente);
		} 
		else{
			echo json_encode(array());
		}
	}

	public function ver_valoracion_cliente($valor){
		$this->load->model("ListaClientes_model");
	echo json_encode($this->ListaClientes_model->get_valoracion_cliente($valor)->result_array() );
	}
 

	  public function bloquear_cliente($valor){
	  	$json['resultado'] = FALSE;
	  	if($valor){
	  		$this->load->model("ListaClientes_model");
	  		$this->db->query("UPDATE clientes SET estatus = 2 WHERE id_cliente = ".$valor."");
	  		$json['resultado'] = TRUE;
	  	}
	  	echo json_encode( $json );
    }


    public function desbloquear_cliente($valor){
	  	$json['resultado'] = FALSE;
	  	if($valor){
	  		$this->load->model("ListaClientes_model");
	  		$this->db->query("UPDATE clientes SET estatus = 1 WHERE id_cliente = ".$valor."");
	  		$json['resultado'] = TRUE;
	  	}
	  	echo json_encode( $json );
    }

	public function areas_solicitadas($cliente){
		echo json_encode($this->ListaClientes_model->get_seleccion_areas($valor)->result_array() );
	}

	public function cliente_adicional($id_paquete){
		$data_cliente= $this->ListaClientes_model->get_cliente_adicional($id_paquete)->row() ;
		if($data_cliente != null){
			echo json_encode($data_cliente);
		} 
		else{
			echo json_encode(array());
		}
	}

	public function get_clientes(){
		$data = array();
		$data_cliente = $this->ListaClientes_model->get_clientes();

		for($i = 0 ; $i < count($data_cliente); $i++){
			$data_contrato = $this->ListaClientes_model->get_contratosbyClient($data_cliente[$i]->id_cliente);
			$data[$i]['id_cliente'] = $data_cliente[$i]->id_cliente;
			$data[$i]['nombre'] = $data_cliente[$i]->nombre;
			$data[$i]['fecha_contrato'] = $data_contrato[0]->fecha_contrato;
			$data[$i]['correo'] = $data_cliente[$i]->correo;
			$data[$i]['telefono'] = $data_cliente[$i]->telefono;
		}

		if($data != null) echo json_encode(array( "data" => $data ));
		else echo json_encode(array());
	}


		/*new 09122020*/
	public function get_expediente_by_client($id_cliente, $id_contrato)
	{
		$data_expediente =  $this->ListaClientes_model->get_expediente_by_client($id_cliente, $id_contrato);

		if($data_expediente != null) {
			echo json_encode($data_expediente);
		}
		else
		{
			echo json_encode(array());
		}
	}
	public function deleteByTipoExp()
	{
		$id_expediente = $this->input->post('id_expediente');
		$tipo_expediente = $this->input->post('tipo_expediente');
		$data_update = array();
		switch ($tipo_expediente)
		{
			case 'IFE':
				$data_update = array(
					'ife' => ''
				);
				break;
			case 'CONTRATO':
				$data_update = array(
					'contrato' => ''
				);
				break;
			case 'PROSA':
				$data_update = array(
					'carta' => ''
				);
				break;
			case 'TARJETA':
				$data_update = array(
					'tarjeta' => ''
				);
				break;
			case 'RECIBO':
				$data_update = array(
					'recibo' => ''
				);
				break;
		}

		$data_exec = $this->ListaClientes_model->update_expediente($id_expediente, $data_update);
		if ($data_exec > 0){
			$data['message'] = 'Se eliminó correctamente';
			$data['status_action'] = 1;
			echo json_encode($data);

		}else{
			$data['message'] = 'ERROR';
			$data['status_action'] = 0;
			echo json_encode($data);
		}
		/*print_r($id_expediente);
		echo '<br>';
		print_r($data_update);*/
	}


	/*submit del form*/
	function enviarExpedientes()
	{
		if(!empty($_FILES['ife_insert']['name']))
		{
			$nuevo_ife =  str_replace(' ', '', $_FILES['ife_insert']['name']);
			$location = FCPATH."assets/expediente/INE/".$nuevo_ife;
			$imageFileType = pathinfo($location,PATHINFO_EXTENSION);
			$imageFileType = strtolower($imageFileType);

			//Valid extensions
			$valid_extensions = array("jpg","jpeg","png","pdf");

			$response = 0;
			//Check file extension
			if(in_array(strtolower($imageFileType), $valid_extensions)) {
				//Upload file
				if(move_uploaded_file($_FILES['ife_insert']['tmp_name'],$location)){
					$response = $location;

				}
			}
			else
			{
				$data['message'] = 'El tipo de archivo cargado para INE/IFE es inválido, ingrese un tipo de archivo válido.';
				$data['status_action'] = 0;
				$data['data_server'] = 0;
				echo json_encode($data);
				exit;
			}
		}
		else{
			$nuevo_ife = '';
		}
		if(!empty($_FILES['contrato_insert']['name']))
		{
			$nuevo_contrato = str_replace(' ', '', $_FILES['contrato_insert']['name']);
			$location = FCPATH."assets/expediente/CONTRATO/".$nuevo_contrato;
			$imageFileType = pathinfo($location,PATHINFO_EXTENSION);
			$imageFileType = strtolower($imageFileType);

			//Valid extensions
			$valid_extensions = array("jpg","jpeg","png","pdf");

			$response = 0;
			//Check file extension
			if(in_array(strtolower($imageFileType), $valid_extensions)) {
				//Upload file
				if(move_uploaded_file($_FILES['contrato_insert']['tmp_name'],$location)){
					$response = $location;
				}
			}
			else
			{
				$data['message'] = 'El tipo de archivo cargado para CONTRATO es inválido, ingrese un tipo de archivo válido.';
				$data['status_action'] = 0;
				$data['data_server'] = 0;
				echo json_encode($data);
				exit;
			}
		}
		else{
			$nuevo_contrato = '';
		}
		if(!empty($_FILES['carta_insert']['name']))
		{
			$nueva_carta = str_replace(' ', '', $_FILES['carta_insert']['name']);
			$location = FCPATH."assets/expediente/CPROSA/".$nueva_carta;
			$imageFileType = pathinfo($location,PATHINFO_EXTENSION);
			$imageFileType = strtolower($imageFileType);

			//Valid extensions
			$valid_extensions = array("jpg","jpeg","png","pdf");

			$response = 0;
			//Check file extension
			if(in_array(strtolower($imageFileType), $valid_extensions)) {
				//Upload file
				if(move_uploaded_file($_FILES['carta_insert']['tmp_name'],$location)){
					$response = $location;
				}
			}
			else
			{
				$data['message'] = 'El tipo de archivo cargado para CARTA es inválido, ingrese un tipo de archivo válido.';
				$data['status_action'] = 0;
				$data['data_server'] = 0;
				echo json_encode($data);
				exit;
			}
		}
		else{
			$nueva_carta = '';
		}
		if(!empty($_FILES['tarjeta_insert']['name']))
		{
			$nueva_tarjeta = str_replace(' ', '', $_FILES['tarjeta_insert']['name']);
			$location = FCPATH."assets/expediente/TARJETA/".$nueva_tarjeta;
			$imageFileType = pathinfo($location,PATHINFO_EXTENSION);
			$imageFileType = strtolower($imageFileType);

			//Valid extensions
			$valid_extensions = array("jpg","jpeg","png","pdf");

			$response = 0; //Check file extension
			if(in_array(strtolower($imageFileType), $valid_extensions)) 
			{ //Upload file
				if(move_uploaded_file($_FILES['tarjeta_insert']['tmp_name'],$location))
				{
					$response = $location; 
				} 
			} 
			else { 
				$data['message'] = 'El tipo de archivo cargado para TARJETA es inválido, ingrese un tipo de archivo válido.';
			    $data['status_action'] = 0; $data['data_server'] = 0; 
			    echo json_encode($data);
				exit; 
			} 
		} 
		else{ $nueva_tarjeta = ''; }

		if(!empty($_FILES['recibo_insert']['name'])) 
			{ 
				$nuevo_recibo= str_replace(' ', '', $_FILES['recibo_insert']['name']); 
				$location = FCPATH."assets/expediente/RECIBO/".$nuevo_recibo; $imageFileType =
				pathinfo($location,PATHINFO_EXTENSION); 
				$imageFileType = strtolower($imageFileType);

				//Valid extensions
				$valid_extensions = array("jpg","jpeg","png","pdf");

				$response = 0;
				//Check file extension
				if(in_array(strtolower($imageFileType), $valid_extensions)) {
					//Upload file
					if(move_uploaded_file($_FILES['recibo_insert']['tmp_name'],$location)){
					$response = $location;
					}
				}
				else
				{
					$data['message'] = 'El tipo de archivo cargado para RECIBO es inválido, ingrese un tipo de archivo válido.';
					$data['status_action'] = 0;
					$data['data_server'] = 0;
					echo json_encode($data);
					exit;
				}
		}
		else{
			$nuevo_recibo = '';
		}

		$id_expediente = $this->input->post('id_expediente') ;
		$id_cliente = $this->input->post('id_cliente');
		$id_contrato = $this->input->post('id_contrato');
		$ife = ($this->input->post('actualiza_ife') != '') ? $this->input->post('actualiza_ife') : $nuevo_ife;
		$contrato = ($this->input->post('actualiza_contrato') != '') ? $this->input->post('actualiza_contrato') : $nuevo_contrato;
		$carta = ($this->input->post('actualiza_carta') != '') ? $this->input->post('actualiza_carta') : $nueva_carta;
		$tarjeta = ($this->input->post('actualiza_tarjeta') != '') ? $this->input->post('actualiza_tarjeta') : $nueva_tarjeta;
		$recibo = ($this->input->post('actualiza_recibo') != '') ? $this->input->post('actualiza_recibo') : $nuevo_recibo;



		/**/
		if($id_expediente != 0 || $id_expediente != '0' )
		{
			$data_update = array (
				"ife" => $ife,
				"contrato" => $contrato,
				"carta" => $carta,
				"tarjeta" => $tarjeta,
				"recibo" => $recibo
			);
		}
		else
		{
			$data_update = array (
				"ife" => $ife,
				"fecha_ife" => date('Y-m-d H:i:s'),
				"contrato" => $contrato,
				"fecha_contrato" => date('Y-m-d H:i:s'),
				"carta" => $carta,
				"fecha_carta" => date('Y-m-d H:i:s'),
				"tarjeta" => $tarjeta,
				"fecha_tarjeta" => date('Y-m-d H:i:s'),
				"recibo" => $recibo,
				"fecha_recibo" => date('Y-m-d H:i:s'),
				"creado_por" => $this->session->userdata("inicio_sesion")['id'],
				"fecha_creacion" => date('Y-m-d H:i:s'),
				"id_cliente" => $id_cliente,
				"id_contrato" => $id_contrato
			);
		}
		/*print_r($this->ListaClientes_model->new_expediente($data_update));
		exit;*/

		$update_exec = ($id_expediente != 0 || $id_expediente != '0') ? $this->ListaClientes_model->update_expediente($id_expediente, $data_update) : $this->ListaClientes_model->new_expediente($data_update);

		if ($update_exec > 0){
			$data['message'] = 'Se actualizó correctamente';
			$data['status_action'] = 1;
			$data['data_server'] = $update_exec;
			echo json_encode($data);
		}else{
			$data['message'] = 'ERROR';
			$data['status_action'] = 0;
			$data['data_server'] = $update_exec;
			echo json_encode($data);
		}
	}


	/*submit cancela contrato*/
	function cancelaContrato()
	{
		$id_contrato = $this->input->post('id_contrato');
		$id_cliente = $this->input->post('id_cliente');

		$id_cobro = $this->ListaClientes_model->getCobroByContrato($id_contrato);
		$id_paquete = $this->ListaClientes_model->getPaqByContrato($id_contrato);
		//


		//actualizar paquetes
		for($e=0; $e < count($id_paquete); $e++)
		{
			//actualizar clientes_x_area
			$cls_x_area_data[$e] = $this->ListaClientes_model->getclsxareasByClPaq($id_cliente, $id_paquete[$e]['id_paquete']);
		}

		$quincenas = array();
		//Cambiar de estatus quincenas y cobros
		for($i=0; $i < count($id_cobro); $i++)
		{
			$data_update_cobro = array(
				"estatus" => 3
			);
			$id_update_cobro = array(
				"id_cobro" => $id_cobro[$i]['id_cobro']
			);
			$table_cobros = 'cobros';
			$this->ListaClientes_model->updateTableGen($table_cobros, $id_update_cobro, $data_update_cobro);
			$quincenas_data[$i] = $this->ListaClientes_model->getQuincenaByCobCon($id_cobro[$i]['id_cobro'], $id_contrato);
			if(count($quincenas_data[$i]) > 0)
			{
				$data_update_quincenas = array(
					"estatus" => 0
				);
				$id_update_quincenas = array(
					"id_quincena" => $quincenas_data[$i][0]['id_quincena']
				);
				$table_quincenas = 'quincenas';
				$this->ListaClientes_model->updateTableGen($table_quincenas, $id_update_quincenas, $data_update_quincenas);
				//$quincenas[$i]['id_quincena'] = $quincenas_data[$i][0]['id_quincena'];
			}
		}
		//$id_cliente
		$data_update_cliente = array(
			"estatus" => 0
		);
		$id_update_cliente = array(
			"id_cliente" => $id_cliente
		);
		$table_clientes = 'clientes';
		$this->ListaClientes_model->updateTableGen($table_clientes, $id_update_cliente, $data_update_cliente);


		$data_update_contrato = array(
			"estatus" => 5
		);
		$id_update_contrato = array(
			"id_contrato" => $id_contrato
		);
		$table_contratos = 'contratos';
		$this->ListaClientes_model->updateTableGen($table_contratos, $id_update_contrato, $data_update_contrato);
		$data_update_pagquincenas = array(
			"estatus" => 3
		);
		$id_update_pagquincenas = array(
			"id_contrato" => $id_contrato
		);
		$table_cpagquincenas = 'pago_quincenas';
		$data_submit = array(
			'success' => 1,
			'message' => 'Contrato cancelado correctamente'
		);


		print_r(json_encode($data_submit));
		exit;
	}

	function observations()
	{
		if (isset($_POST) && !empty($_POST)) {
			$data = array(
				"observaciones" => $this->input->post("observaciones"),
			);
			$response = $this->ListaClientes_model->observations($data, $this->input->post("id_contrato_obs"));
			echo json_encode($response);
		} else {
			json_encode(0);
		}
	}
	
	public function validateSession()
    {
        if ($this->session->userdata("inicio_sesion")['id'] == "") {
            redirect(base_url());
        }
    }

}
