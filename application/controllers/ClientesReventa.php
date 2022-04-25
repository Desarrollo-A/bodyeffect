<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class ClientesReventa extends CI_Controller
{
	public function __construct(){
        parent::__construct();
            $this->load->model(array('ClientesReventa_model'));
            $this->validateSession();
    }

	public function index($data){
		$array = array();
		$cxa = array();

		$array['clientes'] = $this->ClientesReventa_model->get_lista_clientes($data)->result();
		$array['tarjetas'] = $this->ClientesReventa_model->get_lista_tarjetas($data)->result();
		$array['cobros'] = $this->ClientesReventa_model->get_lista_cobros($data)->result();
		$array['expediente'] = $this->ClientesReventa_model->get_expediente($data)->result();
		$array['contratos'] = $this->ClientesReventa_model->get_contrato($data)->result();

		$this->load->view('v_ClienteReventa', $array);
	}

	public function lista_areas(){
		echo json_encode($this->ClientesReventa_model->get_areas_lista()->result_array());
	}

	public function lista_metodosPago(){
      echo json_encode($this->ClientesReventa_model->get_metodos_pago()->result_array());
	}

	public function lista_tiposCobro(){
      echo json_encode($this->ClientesReventa_model->get_tipos_cobro()->result_array());
	}

	public function sino(){
      echo json_encode($this->ClientesReventa_model->lista_sino()->result_array());
	}

	public function lista_tipos(){
      echo json_encode($this->ClientesReventa_model->get_tipo_tarjeta()->result_array());
	}

	public function lista_bancos(){
      echo json_encode($this->ClientesReventa_model->get_bancos()->result_array());
	}

	
	public function guardarDocumentos(){
		$json['resultado'] = FALSE;
		if($this->input->post("id_titular")){
			$id_titular = $_POST['id_titular'];
			$contrato = $_POST['contrato_nameFile'];
		  	$json['resultado'] = TRUE;
		}
		echo json_encode( $json );
	}

	public function guardar_clientes(){
		$json['resultado'] = FALSE;
		if($this->input->post("total")){
	   
			$con = 0;
			$all_clientes = array();
	
			$total = $_POST['total'];
			$descuento = $_POST['descuento'];
			$precioFinal = $_POST['precioFinal'];
			$metodoPago = $_POST['metodoPago'];
			$parcialidades = $_POST['parcialidades'];
			$pagoCon = $_POST['pagoCon'];
	
			$porcentaje = ($descuento * 100)/$total;

			$contrato = $_POST['contrato_nameFile'];
			$id_contrato_old = $_POST['id_contrato'];

			for( $i = 0; $i < count( $this->input->post("id_cliente") ); $i++ ){
				$id_cliente = $_POST['id_cliente'][$i];
				$check = $_POST['check'][$i];

				if($id_cliente != '' ){
				$fecha_actual = date("d-m-Y");
					if ($check == 1) {
						
						$this->db->insert("contratos", array("id_cliente" => $id_cliente , "tipo" => 2, "estatus" => 1));
						$id_contrato = $this->db->insert_id();

						$this->db->insert("cobros", array(
							"id_cliente" => $id_cliente, 
							"concepto" => 'Pago por reventa', 
							"cantidad" => $precioFinal, 
							"fecha_cobro" => date("Y-m-d H:i:s"), 
							"parcialidades" => $parcialidades,
							"descuento" => $porcentaje, 
							"fecha_vencimiento" => date("Y-m-d",strtotime($fecha_actual."+ $parcialidades month")), 
							"forma_pago" => $metodoPago, 
							"fecha_creacion" => date("Y-m-d H:i:s"),
							"creado_por" => $this->session->userdata("inicio_sesion")['id'], 
							"mensualidad" => ($precioFinal-$pagoCon)/$parcialidades, 
							"enganche" => $pagoCon,
							"total" => $total));
						$id_cobro = $this->db->insert_id();

						$this->db->insert("paquetes", array(
							"id_cliente" => $id_cliente, 
							"id_cobro" => $id_cobro, 
							"fecha_creacion" => date("Y-m-d H:i:s"), 
							"creado_por" => $this->session->userdata("inicio_sesion")['id']));
						$id_paquete = $this->db->insert_id();
	
					$this->db->insert("historial_pagos", array(
						"id_cliente" => $id_cliente, 
						"tipo_pago" => 3, 
						"descripcion" => 'Pago por reventa', 
						"fecha_creacion" => date("Y-m-d H:i:s"), 
						"creado_por" => $this->session->userdata("inicio_sesion")['id']));

				}
	
				// $all_clientes = array ($insert_id => $check);
	
				$arr = array();
				$arr['id'] = $id_cliente;
				$arr['check'] = $check;
	
				
				$all_clientes[$i] = $arr;
	
				$selectGeneral = count( $this->input->post("selectPicker"));
				
				if($con == 0){
					if(isset($_POST['corte1'])){
						for( $a = 0; $a < $_POST['corte1']; $a++ ){
							$corte1 = $this->input->post("selectPicker")[$a];
							// echo "<br> Esta es el área c1 | ".$corte1."<br>";
							$this->db->insert("clientes_x_areas", array("id_cliente" => $id_cliente, "id_area" => $corte1, "id_paquete" => $id_paquete));
						}
					}
				}
				if($con == 1){
					if(isset($_POST['corte2'])){
						$contador2 = $_POST['corte1'];
						for( $b = 1; $b <= $_POST['corte2']; $b++ ){
							$corte2 = $this->input->post("selectPicker")[$contador2];
							// echo "<br> Esta es el área c2 | ".$corte2."<br>";
							$this->db->insert("clientes_x_areas", array("id_cliente" => $id_cliente, "id_area" => $corte2, "id_paquete" => $id_paquete));
							$contador2 ++;	
						}
					}
				}
				if($con == 2){
					if(isset($_POST['corte3'])){
						$contador3 = $_POST['corte1'] + $_POST['corte2'];
						for( $c = 1; $c <= $_POST['corte3']; $c++ ){
							$corte3 = $this->input->post("selectPicker")[$contador3];
							// echo "<br> Esta es el área c3 | ".$corte3."<br>";
							$this->db->insert("clientes_x_areas", array("id_cliente" => $id_cliente, "id_area" => $corte3, "id_paquete" => $id_paquete));
							$contador3 ++;
						}
					}
				}
				if($con == 3){
					if(isset($_POST['corte4'])){
						$contador4 = $_POST['corte1'] + $_POST['corte2'] + $_POST['corte3'];
						for( $d = 1; $d <= $_POST['corte4']; $d++ ){
							$corte4 = $this->input->post("selectPicker")[$contador4];
							// echo "<br> Esta es el área c4 | ".$corte4."<br>";
							$this->db->insert("clientes_x_areas", array("id_cliente" => $id_cliente, "id_area" => $corte4, "id_paquete" => $id_paquete));
							$contador4 ++;
	
						}
					}
				}
				if($con == 4){
					if(isset($_POST['corte5'])){
						$contador5 = $_POST['corte1'] + $_POST['corte2'] + $_POST['corte3'] + $_POST['corte4'];
						for( $e = 1; $e <= $_POST['corte5']; $e++ ){
							$corte5 = $this->input->post("selectPicker")[$contador5];
							// echo "<br> Esta es el área c5 | ".$corte5."<br>";
							$this->db->insert("clientes_x_areas", array("id_cliente" => $id_cliente, "id_area" => $corte5, "id_paquete" => $id_paquete));
							$contador5 ++;
						}
					}
				}
			$con ++;
			}
		}

		// krsort($all_clientes);
		$object = json_decode(json_encode((object) $all_clientes), FALSE);

		foreach($object as $key){						;
			switch ($key->check){
				case 1:
					$id_titular = $key->id;
				break;
				case 0:
					$this->db->insert("clientes_contrato", array("id_contrato" => $id_contrato, "id_cliente" => $key->id));
				break;
			}
		}
		  $json['resultado'] = TRUE;
		  $json['id_titular'] = $id_titular;
		  $json['id_paquete'] = $id_paquete;
	
		}
	echo json_encode( $json );
	  }

	  public function validateSession()
	  {
		  if ($this->session->userdata("inicio_sesion")['id'] == "") {
			  redirect(base_url());
		  }
	  }

}
