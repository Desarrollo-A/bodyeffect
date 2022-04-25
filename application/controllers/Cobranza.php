<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class Cobranza extends CI_Controller {
    public function __construct(){
      parent::__construct();
      $this->load->model(array('Cobranza_model'));		
      $this->validateSession();
    }

    public function index(){
        $this->load->view("v_Cobranza");
    }

    public function plan_cliente($dato){     
      echo json_encode($this->Cobranza_model->get_clientes_plan($dato)->result_array());
    }


    public function plan_cliente_enganche($dato){     
      echo json_encode($this->Cobranza_model->get_clientes_abonos($dato)->result_array());
    }


    public function plan_pagar($dato){     
      echo json_encode($this->Cobranza_model->get_clientes_pagar($dato)->result_array());
    }

    public function lista_clientes_cobranza(){
      echo json_encode($this->Cobranza_model->lista_clientes_cobranza()->result_array());
  	}

    public function acepto_comisiones_user($sol){      
		$consulta_comisiones = $this->db->query("SELECT id_quincena FROM quincenas where id_quincena IN (".$sol.")");

		if( $consulta_comisiones->num_rows() > 0 ){
			$consulta_comisiones = $consulta_comisiones->result_array();
			for( $i = 0; $i < count($consulta_comisiones ); $i++){
			$this->Comisiones_model->update_acepta_solicitante($consulta_comisiones[$i]['id_pago_i']);
			}
		}
		else{
			$consulta_comisiones = array();
		}
    } 

    public function pago_una_exhibicion($dato){
      	echo json_encode($this->Cobranza_model->get_pago_una_exhibicion($dato)->result_array());      
    }
    
	public function guardar_pagos(){
		$stringMetodos = '';
		$infoMetodos = array();
		$referencias = '';
		$referencia = '';
    	$formas_pago = $this->input->post('formaPago');
    	$efectivo = $this->input->post('efectivo');
    	$creDeb = $this->input->post('tipoCreDeb');
		$montoT = $this->input->post('montoT');
		$ref =  $this->input->post('referencia');
		$id_contrato = $this->input->post('id_contrato');
		$id_cliente = $this->input->post('id_cliente');
		$id_usuario_log = $this->session->userdata("inicio_sesion")['id'];
		$id_quincena = $this->input->post('pago_quincena');	
		$valorT = $this->input->post('valor_acumulado');
		$fecha_quincena = $this->input->post('fecha_quincena');
		$importe_quincena = $this->input->post('importe_quincena');
		$string_cantidad = $this->input->post('string_cantidad');
		$clave_rastreo = $this->input->post('clave_rastreo_tb');
		$monto_tb = $this->input->post('monto_tb');

		$str_cliente = $this->Cobranza_model->get_cliente($id_cliente);
		$nombre_cliente = $str_cliente->nombre;

		$id_folio = $this->Cobranza_model->insert_historial_pago($id_cliente, $id_usuario_log, $id_contrato);


		$montoTC = ($montoT[0] != '' || $montoT[0] != null) ? $montoT[0] : 0;
		$montoTD = ($montoT[1] != '' || $montoT[1] != null) ? $montoT[1] : 0;

		$montoTC = ($montoT[0] == '0.00' || $montoT[0]==0.00) ? $montoT[1] : $montoT[0];
		$montoTD = ($montoT[1] == '0.00' || $montoT[1]==0.00) ? $montoT[0] : $montoT[1];
		if($monto_tb == '' || $monto_tb == 'undefined') $monto_tb = 0;
		$total_abonado = $efectivo + $montoT[0] + $montoT[1] + $monto_tb;

		for($k=0; $k<count($formas_pago);$k++){
			if($formas_pago[$k]==2){
				for($m=0; $m<count($montoT);$m++){
					if($montoT[$m] != 0){
						if ( $creDeb[$m] == 1 )
						{
							$stringMetodos .= 'Tarjeta crédito, ';
							$infoMetodos[0]['metodo'] = 'Tarjeta crédito';
							$infoMetodos[0]['cantidad'] = $montoTC;
						} 
						else
						{
							$stringMetodos .= 'Tarjeta débito,';
							$infoMetodos[1]['metodo'] = 'Tarjeta débito';
							$infoMetodos[1]['cantidad'] = $montoTD;
						}
						$referencias .= $ref[$m] . ',';
						$referencia .= $ref[$m];
						$tipoTarjeta = $creDeb[$m];
						$importe = $montoT[$m];
						$this->Cobranza_model->insert_pago_quincenas($id_contrato, $id_usuario_log, $tipoTarjeta, $referencia, $importe, $id_folio);
					}
				}
			}
			elseif ($formas_pago[$k]==6)
			{
				$stringMetodos .= 'Transferencia bancaria, ';
				$referencia = $clave_rastreo;
				$this->Cobranza_model->insert_pago_quincenas($id_contrato, $id_usuario_log, 6, $referencia, $monto_tb, $id_folio);
				$infoMetodos[2]['metodo'] = 'Transferencia bancaria';
				$infoMetodos[2]['cantidad'] = $monto_tb;
			}
			else{
				$stringMetodos .= 'Efectivo, ';
				$this->Cobranza_model->insert_pago_quincenas($id_contrato, $id_usuario_log, 3, $referencia, $efectivo, $id_folio);
				$infoMetodos[3]['metodo'] = 'Efectivo';
				$infoMetodos[3]['cantidad'] = $efectivo;
			}
		}

		$a = 0;
		if ($referencias == '') $referencias = '0';
		for($o=0; $o<count($id_quincena); $o++){				
			$this->Cobranza_model->update_quincenas_n($id_quincena[$o], $id_folio);	
			$data_desglose[] = $fecha_quincena[$o] ."    $". $importe_quincena[$o];
		}
		
		/*monto_pago, formas de pago, numero de ticket, pagos*/
		$array_request = array(
			"seethis" => $montoT,
			"metodos_usados" => array_values ($infoMetodos),
			"monto_pago" => $valorT,
			"forma_pago" => $stringMetodos,
			'numero_ticket' => $id_folio,
			'referencias' => $referencias,
			'string_cantidad' => $string_cantidad,
			'pagos' => $data_desglose,
			'nombre_cliente' => $nombre_cliente,
			'success' => 1
		);


		/*verificar si ya pago todas sus quincenas*/
		$verify = $this->Cobranza_model->checkIfIsFinished($id_contrato);
		if($verify->quincenas_restantes == 0)
		{
			$data_update = array(
				'estatus' => 3
			);
			$this->Cobranza_model->updateContrato($id_contrato, $data_update);
		}
		/**/


		if($array_request != null) {
            echo json_encode($array_request);
        } else {
            echo json_encode(array());
		}
	  }
	  
	public function guardar_pagos_2(){
		$stringMetodos = array();
		$infoMetodos = array();
		$referencias = '';
		$referencia = '';
		$formas_pago = $this->input->post('formaPago_2');
		$efectivo = ($this->input->post('efectivo_2') != 0 || $this->input->post('efectivo_2')!=null) ? $this->input->post('efectivo_2') : 0;
		$creDeb = $this->input->post('tipoCreDeb_2');
		$montoT = $this->input->post('montoT_2');
		$ref = $this->input->post('referencia_2');
		$id_contrato = $this->input->post('id_contrato_2');
		$id_cliente = $this->input->post('id_cliente_2');
		$id_usuario_log = $this->session->userdata("inicio_sesion")['id'];
		$valorT = $this->input->post('valor_acumulado_2');
		$string_cantidad = $this->input->post('string_cantidad_2');
		$clave_rastreo = $this->input->post('clave_rastreo_tb_2');
		$monto_tb = $this->input->post('monto_tb_2');
		
		$str_cliente = $this->Cobranza_model->get_cliente($id_cliente);
		$nombre_cliente = $str_cliente->nombre;
		
		// <<<<<<
		$valida_saldo_abono = $this->Cobranza_model->get_abono_by_quincena($id_contrato);
		$valida_saldo_plan = $this->Cobranza_model->get_saldo_plan($id_contrato);
		$last_quincena = $this->Cobranza_model->get_last_quincena($id_contrato);				

		if (empty($valida_saldo_abono)){
			$val_saldo_abonos = 0;
		} else {
			$val_saldo_abonos = ($last_quincena[0]['importe'] - $valida_saldo_abono[0]["pago"]);
		}
		
		if (empty($valida_saldo_plan)){
			$val_saldo_plan = 0;
		} else {
			$val_saldo_plan = ($valida_saldo_plan[0]["pago"]);
		}

		if($val_saldo_plan == 0 && $val_saldo_abonos > 0){
			$saldo = $val_saldo_abonos;
		} else if($val_saldo_plan == 0 && $val_saldo_abonos == 0){
			$saldo = 0;
		} else if($val_saldo_plan > 0 && $val_saldo_abonos > 0){
			$saldo = ($val_saldo_abonos + $val_saldo_plan );
		} else if($val_saldo_plan > 0 && $val_saldo_abonos == 0){
			$saldo = $val_saldo_plan;
		}
		$montoTC = ($montoT[0] != '' || $montoT[0] != null) ? $montoT[0] : 0;
		$montoTD = ($montoT[1] != '' || $montoT[1] != null) ? $montoT[1] : 0;

		$montoTC = ($montoT[0] == '0.00' || $montoT[0]==0.00) ? $montoT[1] : $montoT[0];
		$montoTD = ($montoT[1] == '0.00' || $montoT[1]==0.00) ? $montoT[0] : $montoT[1];

		if($monto_tb == '' || $monto_tb == 'undefined') $monto_tb = 0;
		$total_abonado = $efectivo + $montoT[0] + $montoT[1] + $monto_tb;
		
		// >>>>>>>		
		$total_abonado = sprintf("%.2f", $total_abonado);
		$saldo = sprintf("%.2f", $saldo);

		if ($total_abonado <= $saldo){
			$total_abonado = (float) $total_abonado;
			// >>>>>>>>>>> BEGIN <<<<<<<<<<		
			$id_folio = $this->Cobranza_model->insert_historial_pago($id_cliente, $id_usuario_log, $id_contrato);		
			for($k=0; $k<count($formas_pago);$k++){		
				if($formas_pago[$k]==2){
					for($m=0; $m<count($montoT);$m++){
						if($montoT[$m] != 0){
							if ( $creDeb[$m] == 1 )
							{
								$stringMetodos['metodo'][0] = 'Tarjeta crédito';
								$infoMetodos[0]['metodo'] = 'Tarjeta crédito';
								$infoMetodos[0]['cantidad'] = $montoTC;
								/*array_push($infoMetodos, 'metodo' => 'Tarjeta crédito');
								array_push($infoMetodos, 'cantidad' => $montoT[0]);*/
							} 
							else 
							{
								$stringMetodos['metodo'][1] = 'Tarjeta débito';
								/*array_push($infoMetodos, 'metodo' => 'Tarjeta débito');
								array_push($infoMetodos, 'cantidad' => $montoT[1]);*/
								$infoMetodos[1]['metodo'] = 'Tarjeta débito';
								$infoMetodos[1]['cantidad'] = $montoTD;
							}
							$referencias .= $ref[$m] . ',';
							$referencia = $ref[$m];
							$tipoTarjeta = $creDeb[$m];
							$importe = $montoT[$m];
							$this->Cobranza_model->insert_pago_quincenas($id_contrato, $id_usuario_log, $tipoTarjeta, $referencia, $importe, $id_folio);
							
						}
					}
				}
				elseif ($formas_pago[$k]==6){
					$stringMetodos['metodo'][2] = 'Transferencia bancaria';
					$referencia = $clave_rastreo;
					$this->Cobranza_model->insert_pago_quincenas($id_contrato, $id_usuario_log, 6, $referencia, $monto_tb, $id_folio);

					/*array_push($infoMetodos, 'metodo' => 'Transferencia bancaria');
					array_push($infoMetodos, 'cantidad' => $monto_tb);*/
					$infoMetodos[2]['metodo'] = 'Transferencia bancaria';
					$infoMetodos[2]['cantidad'] = $monto_tb;
				}
				else{
					$stringMetodos['metodo'][3] = 'Efectivo';
					$this->Cobranza_model->insert_pago_quincenas($id_contrato, $id_usuario_log, 3, $referencia, $efectivo, $id_folio);

					/*array_push($infoMetodos, 'metodo' => 'Efectivo');
					array_push($infoMetodos, 'cantidad' => $efectivo);*/
					$infoMetodos[3]['metodo'] = 'Efectivo';
					$infoMetodos[3]['cantidad'] = $efectivo;
				}
			}
		
			$a = 0;
			if ($referencias == '') $referencias = '0';
			$monto = $this->Cobranza_model->get_clientes_pagar($id_contrato)->result_array();
			$valida_abono = $this->Cobranza_model->get_abono_by_quincena($id_contrato);
		
			$pago_total = (count($valida_abono) > 0) ? ($valida_abono[0]["pago"] + $total_abonado) : $total_abonado;
			$data_desglose = array();
			
			if (count($monto) > 0){
				$monto_t = round( ((float) $monto[0]["importe"]), 2);		
				if ($pago_total >= $monto_t) {
					$pago_quincenas = 0;
					$quincenas_completadas = $pago_total / $monto_t;
					$quincenas_completadas_round = floor($quincenas_completadas);		
					for($m=0; $m<$quincenas_completadas_round; $m++){
						$monto_tt = round( ((float) $monto[$m]["importe"]), 2);
						$pago_quincenas += $monto_tt;						
						$id_quincena_abono = $monto[$m]["id_quincena"];
		
						$fecha_pago = $monto[$m]["fecha_pago"];
						
						$importe = (count($valida_abono) > 0) ?
							(($monto[$m]["id_quincena"] == $valida_abono[0]["id_quincena"]) ? ( $monto_tt - $valida_abono[0]["pago"]) : $monto_tt) :
							$monto_tt;
						
						$this->Cobranza_model->update_quincenas($id_quincena_abono);
						$this->Cobranza_model->insert_abono_quincenas($id_contrato,$id_quincena_abono,$importe,$id_folio,$id_usuario_log);
						$data_desglose[] = date('Y-m-d h:i:s', strtotime($fecha_pago)) ." $".number_format(round($importe, 2),2)." LIQUIDADO";
					}
		
					$restante = $pago_total - $pago_quincenas;
					$quincenas_restantes = $this->Cobranza_model->get_clientes_pagar($id_contrato)->result_array();
		
					if (count($quincenas_restantes) > 0 && $restante > 0) {
						$id_quincena_restante = $quincenas_restantes[0]["id_quincena"];
						
						$this->Cobranza_model->update_quincena_restante($id_quincena_restante, $id_folio);
						$this->Cobranza_model->insert_abono_quincenas($id_contrato,$id_quincena_restante,$restante,$id_folio,$id_usuario_log);
						$fecha_pago_restante = $quincenas_restantes[0]["fecha_pago"];
						$data_desglose_restante[] = date('Y-m-d h:i:s', strtotime($fecha_pago_restante))." $".number_format(round($restante, 2),2)." "."ABONADO A QUICENA";
						$data_desglose= array_merge($data_desglose,$data_desglose_restante);
					}		
				} 
				else {
					$monto_t = (float) $monto[0]["importe"];
					$monto_t = round( $monto_t, 2);	
					// SI EL MONTO ES MENOR AL QUE DEBE PAGAR EN LA MENSUALIDAD
			
					//$id_quincena_abono = $monto_t;
					$id_quincena_abono = $monto[0]["id_quincena"];
					$importe = $total_abonado;
					$fecha_pago = $monto[0]["fecha_pago"];
					$this->Cobranza_model->update_quincena_restante($id_quincena_abono, $id_folio);
					$this->Cobranza_model->insert_abono_quincenas($id_contrato,$id_quincena_abono,$importe,$id_folio,$id_usuario_log);
					$data_desglose[] = date('Y-m-d h:i:s', strtotime($fecha_pago)) ." $".number_format(round($importe, 2),2);
				}
			}
			/*monto_pago, formas de pago, numero de ticket, pagos*/
			$array_request = array(
			"seethis" => $montoT,
			"metodos_usados" => array_values ($infoMetodos),
			"monto_pago" => number_format(round($valorT, 2),2),
			"forma_pago" => array_values($stringMetodos['metodo']),
			'numero_ticket' => $id_folio,
			'referencias' => $referencias,
			'string_cantidad' => $string_cantidad,
			'pagos' => $data_desglose,
			'nombre_cliente' => $nombre_cliente,
			'success' => 1
			);
			// >>>>>>>>>>> END <<<<<<<<<<
		
		} 
		else {
			$array_request = array(
			'success' => 0
			);
		}
		
		if($array_request != null) {
			echo json_encode($array_request);
		} 
		else {
			echo json_encode(array());
		}
	}
		
	public function get_abonos($id_quincena){
		$abonos = $this->Cobranza_model->get_abonos($id_quincena);
		if (COUNT($abonos) > 0) { // MJ: PRIMERO BUSCA EN ABONOS Y SI ENCUENTRA UN REGISTRO ES PORQUE EL PAGO FUE POR ABONO
			echo json_encode($abonos);
		} else { // MJ. EL PAGO NO FUE POR ABONO
			$fullPayment = $this->Cobranza_model->getFullPayments($id_quincena);
			echo json_encode($fullPayment);
		}
	}				

	public function get_all_abonos($id_contrato){
		echo json_encode($this->Cobranza_model->get_all_abonos($id_contrato)->result_array());
	}
	
	public function validateSession()
    {
        if ($this->session->userdata("inicio_sesion")['id'] == "") {
            redirect(base_url());
        }
    }

    public function get_abonos2($id_contrato){
		$data = $this->Cobranza_model->getCompletePayment($id_contrato);
		echo json_encode($data);
	}
	
}