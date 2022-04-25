<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
// define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR. 
// 'expediente' .DIRECTORY_SEPARATOR. 'RECIBO' .DIRECTORY_SEPARATOR);

// define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR. 'expediente' .DIRECTORY_SEPARATOR);


define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR. 'expediente' .DIRECTORY_SEPARATOR);

class Clientes extends CI_Controller
{
	public function __construct(){
        parent::__construct();
			$this->load->model(array('Clientes_model'));
			//$this->validateSession();			
	}
	
	public function index(){
		$this->load->view('v_Cliente');
	}

	public function lista_estados(){
		echo json_encode($this->Clientes_model->get_estados()->result_array());
    }

    public function lista_municipios($data){
		echo json_encode($this->Clientes_model->get_municipios($data)->result_array());
    }

    public function lista_colonias($data, $data2){
		echo json_encode($this->Clientes_model->get_colonias($data, $data2)->result_array());
	}
	
	public function lista_areas($id_area){
      echo json_encode($this->Clientes_model->get_areas_lista($id_area)->result_array());
    }
 
	public function lista_metodosPago(){
      echo json_encode($this->Clientes_model->get_metodos_pago()->result_array());
	}

	public function lista_tiposCobro(){
      echo json_encode($this->Clientes_model->get_tipos_cobro()->result_array());
	}

	public function sino(){
      echo json_encode($this->Clientes_model->lista_sino()->result_array());
	}
	
	public function lista_tipos(){
      echo json_encode($this->Clientes_model->get_tipo_tarjeta()->result_array());
	}

	public function lista_bancos(){
      echo json_encode($this->Clientes_model->get_bancos()->result_array());
	}

	public function lista_clientes(){
      echo json_encode($this->Clientes_model->get_clientes_lista()->result_array());
	}

	public function lista_clientes_agenda(){
      echo json_encode($this->Clientes_model->get_clientes_lista_agenda()->result_array());
	}

	public function lista_clientes_pago(){
      echo json_encode($this->Clientes_model->get_clientes_lista_titular()->result_array());
	}

	public function lista_clientes_cobranza(){
      echo json_encode($this->Clientes_model->get_clientes_lista_cobranza()->result_array());
	}

	public function datos_clientes(){
		$dat =  $this->Clientes_model->get_datos_clientes()->result_array();
		echo json_encode( array( "data" => $dat ));
	}

	public function get_agenda_depilacion(){
		echo json_encode($this->Clientes_model->get_agenda_depilacion()->result_array());
	}

	public function getEnfermeras(){
        echo json_encode($this->Clientes_model->getEnfermeras()->result_array());
	}
	
	public function get_agenda_moldeo(){
		echo json_encode($this->Clientes_model->get_agenda_moldeo()->result_array());
	}
	
	public function guardarDocumentos(){
		date_default_timezone_set("America/Mexico_City");
		$json['resultado'] = FALSE;
		if($this->input->post("id_titular")){
			$this->load->model("Clientes_model");
			$id_titular = $_POST['id_titular'];
			$id_contrato = $_POST['id_contrato'];
			$identificacion = $_POST['ine_nameFile'];
			$tarjeta = $_POST['tarjeta_nameFile'];
			$contrato = $_POST['contrato_nameFile'];
			$cprosa = $_POST['cprosa_nameFile'];
			$recibo = $_POST['recibo_nameFile'];
			if ($id_titular != '' && $contrato != '' ) {
				$this->db->insert("expediente", array(
					"id_cliente" => $id_titular, 
					"ife" => $identificacion, 
					"fecha_ife" => date("Y-m-d H:i:s"), 
					"tarjeta" => $tarjeta, 
					"fecha_tarjeta" => date("Y-m-d H:i:s"),
					"contrato" => $contrato, 
					"fecha_contrato" => date("Y-m-d H:i:s"), 
					"recibo" => $recibo,
					"fecha_recibo" => date("Y-m-d H:i:s"),
					"carta" => $cprosa, 
					"fecha_carta" => date("Y-m-d H:i:s"), 
					"fecha_creacion" => date("Y-m-d H:i:s"), 
					"creado_por" => $this->session->userdata("inicio_sesion")['id'],
					"id_contrato" => $id_contrato));
			}
		  	$json['resultado'] = TRUE;
		}
		echo json_encode( $json );
	}

	// public function guardar_clientes_reventa(){
	// 	date_default_timezone_set("America/Mexico_City");
	// 	$json['resultado'] = FALSE;
	// 	if($this->input->post("total")){
	// 		$protegida = false;
	// 		$prosa = 0;
	// 		//Evaluamos si fue venta protegida
	// 		if (isset($_POST['protegida'])){
	// 			$protegida = true;
	// 			$prosa = 1;
	// 		}

	// 		for( $q = 0; $q < count( $this->input->post("formaPago")); $q++ ){
	// 			if ( $_POST['formaPago'][$q] == 2){
	// 				for ( $r = 0; $r < count( $this->input->post("cardNumber")); $r++ ){
	// 					if($_POST['cardNumber'][$r] != '') {
	// 						if($_POST['tarjetaPrimaria'][$r] == 1) $prosa = 1;
	// 					}
	// 				}
	// 			}
	// 		}

	// 		$con = 0;
	// 		$checki = 0;
	// 		//Array clientes ingresados
	// 		$all_clientes = array();

	// 		//Datos grales. de la venta.
	// 		$total = $_POST['total'];
	// 		$descuento = $_POST['descuento'];
	// 		$precioFinal = $_POST['precioFinal'];
	// 		$parcialidades = $_POST['parcialidades'];
	// 		$pagoCon = $_POST['pagoCon'];
	// 		$porcentaje = ($descuento * 100)/$total;
	// 		$compartido = '';
	// 		$area = $_POST['area_sel'];
	// 		$referencia = $_POST['referencia'];
	// 		$observaciones = $_POST['observaciones'];
	// 		$engancheTotal = 0;
	// 		$clave_rastreo = '';
	// 		$compartido = '';
	// 		$referencia = '';

	// 		//Si el precio final es igual al anticipo, mandamos estatus 3 
	// 		$precioFinal == $pagoCon ? $estatus_contrato = 3:$estatus_contrato = 1;			
	// 		$contador_paquete = 1;

	// 		//For con array de clientes ingresados
	// 		for( $i = 0; $i < count( $this->input->post("nombre")); $i++ ){
	// 			$checki = $i;
	// 			$nombre = $_POST['nombre'][$i];
	// 			$apellido_paterno = $_POST['apellido_paterno'][$i];
	// 			$apellido_materno = $_POST['apellido_materno'][$i];
	// 			$correo = $_POST['correo'][$i];
	// 			$telefono = $_POST['telefono'][$i];
	// 			$check = $_POST['checkT'];
	// 			$id_cliente_actual = $_POST['id_cliente_actual'];
	// 			$fecha_actual = date("d-m-Y");
	// 			if ($check == ($i + 1)){							
	// 				$prospeccion = $this->Clientes_model->get_lugar_prospeccion($id_cliente_actual);
	// 				$lugar_prospeccion = 0;
	// 				if( $lugar_prospeccion == null || $lugar_prospeccion == '' ) $lugar_prospeccion = '';				
	// 				$this->db->insert("contratos", array("id_cliente" => $id_cliente_actual , "tipo" => 3, "estatus" => $estatus_contrato, "servicio" => $area, "observaciones" => $observaciones));
	// 				$id_contrato = $this->db->insert_id();
	// 				if(isset($_POST['enfermeras'])){
	// 					for($n = 0; $n < count($_POST['enfermeras']); $n++){
	// 						$data_insert = array(
	// 							"estatus" => 1,
	// 							"creado_por" => $this->session->userdata("inicio_sesion")['id'],
	// 							"fecha_creacion" => date("Y-m-d H:i:s"),
	// 							"id_contrato" => $id_contrato,
	// 							"id_usuario" => $_POST['enfermeras'][$n]
	// 						);
	// 						$this->Clientes_model->insert_ventas_compartidas($data_insert);
	// 					}
	// 				}
	// 				for( $x = 0; $x < count( $this->input->post("formaPago")); $x++ ){
	// 					if ( $_POST['formaPago'][$x] == 2 || $protegida == true){
	// 						$vacio = '';
	// 						for ( $y = 0; $y < count( $this->input->post("cardNumber")); $y++ ){
	// 							if($_POST['cardNumber'][$y] != ''){
	// 								$tp = $_POST['tarjetaPrimaria'][$y];
	// 								$tipoCobro = 1;
	// 								$cardNumber = $_POST['cardNumber'][$y];
	// 								$mes = $_POST['mes'][$y];
	// 								$anio = $_POST['anio'][$y];
	// 								$nameInCard = $_POST['nameInCard'][$y];
	// 								$tipoTarjeta = $_POST['tipoTarjeta'][$y];
	// 								$banco = $_POST['banco'][$y];
	// 								$formaPago = $_POST['tipoCreDeb'][$y];
	// 								$montoEnganche = $_POST['montoT'][$y];
	// 								$engancheTotal +=  $montoEnganche;
	// 								$mesesi = $_POST['msi'][$y];
	// 								$referencia = $_POST['referencia'][$y];
	// 								$vacio = 1;
	// 							}
	// 							else $vacio = 0;

	// 							if($vacio == 1){
	// 								if(!$protegida && $montoEnganche != 0){
	// 									//Insertamos a la tabla cobro y obtenemos último id
	// 									$id_cobro = $this->insert_cobros($id_cliente_actual, $precioFinal, $mesesi,
	// 										$porcentaje, $fecha_actual, $parcialidades, $formaPago, $pagoCon,
	// 										$montoEnganche, $total, 0, $area, $referencia, $prosa, $id_contrato, $lugar_prospeccion, $clave_rastreo);
	// 								}
	// 								//Registro de tarjetas
	// 								$this->db->insert("tarjetas", array(
	// 									"id_cliente" => $id_cliente_actual,
	// 									"nombre" => $nameInCard,
	// 									"numero_tarjeta" => $cardNumber,
	// 									"mm" => $mes,
	// 									"aa" => $anio,
	// 									"estatus" => 1,
	// 									"fecha_creacion" => date("Y-m-d H:i:s"),
	// 									"creado_por" => $this->session->userdata("inicio_sesion")['id'],
	// 									"id_banco" => $banco,
	// 									"tipo_tarjeta" => $formaPago,
	// 									"tipo_cobro" => $tipoCobro,
	// 									"tarjeta_primaria" => $tp,
	// 									"compania" => $tipoTarjeta,
	// 									"id_contrato" => $id_contrato ));
	// 							}
	// 						}
	// 					}
	// 					//Evaluamos si de igual forma es protegida y efectivo o solo efectivo
	// 					if($_POST['formaPago'][$x] == 1){
	// 						//Forma pago en efectivo
	// 						$montoEnganche = $_POST['efectivo'];
	// 						$engancheTotal += $montoEnganche;
	// 						$mesesi = 0;
	// 						$formaPago = 3;
	// 						$referencia = '';

	// 						//Insertamos a la tabla cobro y obtenemos último id
	// 						$id_cobro = $this->insert_cobros($id_cliente_actual, $precioFinal, $mesesi, $porcentaje,
	// 							$fecha_actual, $parcialidades, $formaPago, $pagoCon, $montoEnganche, $total, 0,
	// 							$area, $referencia, $prosa, $id_contrato, $lugar_prospeccion, $clave_rastreo);
	// 					}
	// 					if($_POST['formaPago'][$x] == 6){
	// 						//Forma de pago transferencia bancaria
	// 						$montoEnganche = $_POST['monto_tb'];
	// 						$engancheTotal += $montoEnganche;
	// 						$mesesi = 0;
	// 						$formaPago = 6;
	// 						$referencia = '';
	// 						$clave_rastreo = $_POST['clave_rastreo_tb'];

	// 						//Insertamos a la tabla cobro y obtenemos último id
	// 						$id_cobro = $this->insert_cobros($id_cliente_actual, $precioFinal, $mesesi, $porcentaje, $fecha_actual, $parcialidades, $formaPago, $pagoCon, $montoEnganche, $total, 0, $area, $referencia, $prosa, $id_contrato, $lugar_prospeccion, $clave_rastreo);
	// 					}
	// 				}

	// 				$this->db->insert("historial_pagos", array(
	// 					"id_cliente" => $id_cliente_actual,
	// 					"tipo_pago" => 1,
	// 					"descripcion" => 'Anticipo hecho tras firmar el contrato.',
	// 					"fecha_creacion" => date("Y-m-d H:i:s"),
	// 					"creado_por" => $this->session->userdata("inicio_sesion")['id'],
	// 					"id_contrato"=>$id_contrato));

	// 					if($parcialidades!= 0) {
	// 						for ($q = 0; $q < count($this->input->post("mensualidades")); $q++) {
	// 							$fecha = str_replace('/', '-', $_POST['mensualidades'][$q]);
	// 							$fecha_mensualidad2 = date("Y-m-d", strtotime($fecha));
	// 							$b = $q;
	// 							$importe = round(($precioFinal-$pagoCon)/$parcialidades, 2);
	// 							if( ($b + 1) == count($this->input->post("mensualidades")) and $parcialidades > 2 ){
	// 								$importe = $this->ajusteCentavos($parcialidades, $importe, $precioFinal, $engancheTotal);
	// 							}	
								
	// 							$this->db->insert("quincenas", array(
	// 								"id_cobro" => $id_cobro, 
	// 								"importe" => $importe, 
	// 								"fecha_pago" => $fecha_mensualidad2,
	// 								"referencia" =>'0', 
	// 								"numero_pago" => ($q + 1), 					 
	// 								"fecha_creacion" => date("Y-m-d H:i: s"), 
	// 								"creado_por" => $this->session->userdata("inicio_sesion")['id'],
	// 								"id_contrato" => $id_contrato));
	// 						}
	// 					}
	// 			}
	// 			if($nombre != '' && $apellido_paterno != '' && $apellido_materno != '' && $correo != '' && $telefono != '') {
	// 				if ($check == ($checki + 1)) $titular = 1;
	// 				else $titular = 0;
	// 				if($i != 0)
	// 				{
	// 					//INSERT DE NUEVO CLIENTE REGISTRADO
	// 					$this->db->insert("clientes", array(
	// 						"id_vendedor" => $this->session->userdata("inicio_sesion")['id'],
	// 						"id_sucursal" => 1,
	// 						"nombre" => $nombre,
	// 						"apellido_paterno" => $apellido_paterno,
	// 						"apellido_materno" => $apellido_materno,
	// 						"personalidad_juridica" => 1,
	// 						"rfc" => "XXXXXXXXXXXX",
	// 						"curp" => "XXXXXXXXXXXXXXXXXX",
	// 						"correo" => $correo,
	// 						"telefono" => $telefono,
	// 						"tipo" => 1,
	// 						"facturable" => 1,
	// 						"estatus" => 1,
	// 						"nacionalidad" => 1,
	// 						"creado_por" => $this->session->userdata("inicio_sesion")['id'],
	// 						"titular" => $titular
	// 					));
	// 				}
	// 				//Último id insertado en la tabla clientes
	// 				$insert_id = ($i !=0 ) ? $this->db->insert_id() : $id_cliente_actual;
	// 				$fecha_actual = date("d-m-Y");

	// 				$this->db->insert("paquetes", array(
	// 					"id_cliente" => $insert_id,
	// 					"fecha_creacion" => date("Y-m-d H:i:s"),
	// 					"creado_por" => $this->session->userdata("inicio_sesion")['id'],
	// 					"id_contrato" => $id_contrato));
	// 				// Se obtiene último id de la tabla paquetes
	// 				$id_paquete = $this->db->insert_id();

	// 				if($i == 0){
	// 					if($con == 0){
	// 						if( $_POST['corte1'] != "0" ){
	// 							for( $a = 0; $a < $_POST['corte1']; $a++ ){
	// 								$corte1 = $this->input->post("selectPicker")[$a];
	// 								$this->db->insert("clientes_x_areas", array("id_cliente" => $id_cliente_actual, "id_area" => $corte1, "id_paquete" => $id_paquete));
	// 							}
	// 						}
	// 					}
	// 				}

	// 				if($con == 1){
	// 					if( $_POST['corte2'] != "0" ){
	// 						$contador2 = $_POST['corte1'];
	// 						for( $b = 1; $b <= $_POST['corte2']; $b++ ){
	// 							$corte2 = $this->input->post("selectPicker")[$contador2];
	// 							$this->db->insert("clientes_x_areas", array("id_cliente" => $insert_id, "id_area" => $corte2, "id_paquete" => $id_paquete));
	// 							$contador2 ++;
	// 						}
	// 					}
	// 				}

	// 				if($con == 2){
	// 					if( $_POST['corte3'] != "0" ){
	// 						$contador3 = $_POST['corte1'] + $_POST['corte2'];
	// 						for( $c = 1; $c <= $_POST['corte3']; $c++ ){
	// 							$corte3 = $this->input->post("selectPicker")[$contador3];
	// 							$this->db->insert("clientes_x_areas", array("id_cliente" => $insert_id, "id_area" => $corte3, "id_paquete" => $id_paquete));
	// 							$contador3 ++;
	// 						}
	// 					}
	// 				}

	// 				if($con == 3){
	// 					if( $_POST['corte4'] != "0" ){
	// 						$contador4 = $_POST['corte1'] + $_POST['corte2'] + $_POST['corte3'];
	// 						for( $d = 1; $d <= $_POST['corte4']; $d++ ){
	// 							$corte4 = $this->input->post("selectPicker")[$contador4];
	// 							$this->db->insert("clientes_x_areas", array("id_cliente" => $insert_id, "id_area" => $corte4, "id_paquete" => $id_paquete));
	// 							$contador4 ++;
	// 						}
	// 					}
	// 				}

	// 				if($con == 4){
	// 					if( $_POST['corte5'] != "0" ){
	// 						$contador5 = $_POST['corte1'] + $_POST['corte2'] + $_POST['corte3'] + $_POST['corte4'];
	// 						for( $e = 1; $e <= $_POST['corte5']; $e++ ){
	// 							$corte5 = $this->input->post("selectPicker")[$contador5];
	// 							$this->db->insert("clientes_x_areas", array("id_cliente" => $insert_id, "id_area" => $corte5, "id_paquete" => $id_paquete));
	// 							$contador5 ++;
	// 						}
	// 					}
	// 				}
	// 				if($i != 0){
	// 					$this->db->insert("clientes_contrato", array("id_contrato" => $id_contrato, "id_cliente" => $insert_id));
	// 				}
	// 				$con ++;
	// 			}
	// 		}
	// 		$json['resultado'] = TRUE;
	// 		$json['id_titular'] = $id_cliente_actual;
	// 		$json['id_paquete'] =  $id_paquete;
	// 		$json['id_contrato'] = $id_contrato;
	// 		$json['prosa'] = $prosa;
	// 	}
	// 	echo json_encode( $json );
	// }

	public function guardar_clientes(){
		date_default_timezone_set("America/Mexico_City");
		$json['resultado[]'] = FALSE;

		//Recibimos los array de los tratamientos RF
		$array1 = json_decode($_POST['arrayTratamientos1'], true);
		$array2 = json_decode($_POST['arrayTratamientos2'], true);
		$array3 = json_decode($_POST['arrayTratamientos3'], true);
		$array4 = json_decode($_POST['arrayTratamientos4'], true);
		$array5 = json_decode($_POST['arrayTratamientos5'], true);

		$protegida = false;
		$prosa = 0;
		//Evaluamos si fue venta protegida
		if (isset($_POST['protegida'])){
			$protegida = true;
			$prosa = 1; 
		}

		for( $q = 0; $q < count( $this->input->post("formaPago")); $q++ ){	
			if ( $_POST['formaPago'][$q] == 2){
				for ( $r = 0; $r < count( $this->input->post("cardNumber")); $r++ ){
					if($_POST['cardNumber'][$r] != '') {
						if($_POST['tarjetaPrimaria'][$r] == 1) $prosa = 1;
					}
				}
			}
		}
		$con = 0;
		$checki = 0;
		//Array clientes ingresados
		$all_clientes = array();
		
		//Datos grales. de la venta. 
		$total = $_POST['total'];
		$descuento = $_POST['descuento'];
		$pagoCon = $_POST['pagoCon'];
		$precioFinal = $_POST['precioFinalC'];
		//Si el precio final es igual al anticipo, mandamos estatus 3 
		$precioFinal == $pagoCon ? $estatus_contrato = 3:$estatus_contrato = 1;			
		$parcialidades = $_POST['parcialidades'];
		($descuento != 0) ? $porcentaje = ($descuento * 100)/$total : $porcentaje = 0;
		$compartido = '';
		$area = $_POST['area_sel'];
		$observaciones = $_POST['observaciones'];
		$engancheTotal = 0;
		$clave_rastreo = '';
		$compartido = '';
		$referencia = '';
		if(isset($_POST['lugar_prospeccion'])) $lugar_prospeccion = $_POST['lugar_prospeccion'];			
		else $lugar_prospeccion = 0;

		$id_contrato = '';
		$insert_id_two = array();
		//For con array de clientes ingresados
		for( $i = 0; $i < count( $this->input->post("nombre")); $i++ ){
			$checki = $i;
			$nombre = $_POST['nombre'][$i];
			$apellido_paterno = $_POST['apellido_paterno'][$i];
			$apellido_materno = $_POST['apellido_materno'][$i];
			$correo = $_POST['correo'][$i];
			$telefono = $_POST['telefono'][$i];
			$domicilio = $_POST['domicilio'][$i];
			$check = $_POST['checkT'];
			if($nombre != '' && $apellido_paterno != ''){
				if( $check == ($checki+1)) $titular = 1;
				else $titular = 0;				

				//INSERT DE NUEVO CLIENTE REGISTRADO					
				$this->db->insert("clientes", array(
					"id_vendedor" => $this->session->userdata("inicio_sesion")['id'],
					"id_sucursal" => 1,
					"nombre" => $nombre,
					"apellido_paterno" => $apellido_paterno,
					"apellido_materno" => $apellido_materno,
					"personalidad_juridica" => 1,
					"rfc" => "XXXXXXXXXXXX",
					"curp" => "XXXXXXXXXXXXXXXXXX",
					"correo" => $correo,
					"telefono" => $telefono,
					"domicilio" => $domicilio == '' ? 'DOMICILIO NO ESPECIFICADO' : $domicilio,
					"tipo" => 1,
					"facturable" => 1,
					"estatus" => 1,
					"nacionalidad" => 1,
					"creado_por" => $this->session->userdata("inicio_sesion")['id'],
					"titular" => $titular
				));

				//Último id insertado en la tabla clientes
				$insert_id = $this->db->insert_id();

				// MJ: SE LLENA ARRAY CON LOS ID DE LOS CLIENTES INSERTADOS
				$insert_id_two[$i] = $insert_id;
				$fecha_actual = date("d-m-Y");

				if ($titular == 1) {
					$this->db->insert("contratos", array("id_cliente" => $insert_id , "tipo" => 1, "estatus" => $estatus_contrato, "servicio" => $area, "observaciones"=>$observaciones));
					$id_contrato = $this->db->insert_id();
					if(isset($_POST['enfermeras']))
					{
						for($n = 0; $n < count($_POST['enfermeras']); $n++)
						{
							$data_insert = array(
								"estatus" => 1,
								"creado_por" => $this->session->userdata("inicio_sesion")['id'],
								"fecha_creacion" => date("Y-m-d H:i:s"),
								"id_contrato" => $id_contrato,
								"id_usuario" => $_POST['enfermeras'][$n]
							);
							$this->Clientes_model->insert_ventas_compartidas($data_insert);
						}
					}						
					for( $x = 0; $x < count( $this->input->post("formaPago")); $x++ ){		
						if ( $_POST['formaPago'][$x] == 2 || $protegida == true){	
							$vacio = '';
							for ( $y = 0; $y < count( $this->input->post("cardNumber")); $y++ ){
								if($_POST['cardNumber'][$y] != '') {
									$tp = $_POST['tarjetaPrimaria'][$y];
									$tipoCobro = 1;
									$cardNumber = $_POST['cardNumber'][$y];
									$mes = $_POST['mes'][$y];
									$anio = $_POST['anio'][$y];
									$nameInCard = $_POST['nameInCard'][$y];
									$tipoTarjeta = $_POST['tipoTarjeta'][$y];
									$banco = $_POST['banco'][$y];
									$formaPago = $_POST['tipoCreDeb'][$y];
									$montoEnganche = $_POST['montoT'][$y];
									$engancheTotal += $montoEnganche;
									$mesesi = $_POST['msi'][$y];
									$referencia = $_POST['referencia'][$y];
									$vacio = 1;
								}
								else $vacio = 0;

								if($vacio == 1){
									if(!$protegida && $montoEnganche != 0){		
										//Insertamos a la tabla cobro y obtenemos último id
										$id_cobro = $this->insert_cobros($insert_id, $precioFinal, $mesesi, $porcentaje, $fecha_actual, $parcialidades, $formaPago, $pagoCon, $montoEnganche, $total, 0, $area, $referencia, $prosa, $id_contrato, $lugar_prospeccion, $clave_rastreo);
									}										
									//Registro de tarjetas
									$this->db->insert("tarjetas", array(
										"id_cliente" => $insert_id, 
										"nombre" => $nameInCard, 
										"numero_tarjeta" => $cardNumber, 
										"mm" => $mes, 
										"aa" => $anio, 
										"estatus" => 1, 
										"fecha_creacion" => date("Y-m-d H:i:s"),
										"creado_por" => $this->session->userdata("inicio_sesion")['id'],
										"id_banco" => $banco,
										"tipo_tarjeta" => $formaPago,
										"tipo_cobro" => $tipoCobro, 
										"tarjeta_primaria" => $tp,
										"compania" => $tipoTarjeta,
										"id_contrato" => $id_contrato));		
								}
							}	
						}
						//Evaluamos si de igual forma es protegida y efectivo o solo efectivo
						if($_POST['formaPago'][$x] == 1){
							//Forma pago en efectivo
							$montoEnganche = $_POST['efectivo'];
							$engancheTotal += $montoEnganche;
							$mesesi = 0;
							$formaPago = 3;
							$referencia = '';

							//Insertamos a la tabla cobro y obtenemos último id
							$id_cobro = $this->insert_cobros($insert_id, $precioFinal, $mesesi, $porcentaje, $fecha_actual, $parcialidades, $formaPago, $pagoCon, $montoEnganche, $total, 0, $area, $referencia, $prosa, $id_contrato, $lugar_prospeccion, $clave_rastreo);
						}
						if($_POST['formaPago'][$x] == 5){
							//Forma de pago convenio influencer
							$montoEnganche = 0;
							$engancheTotal += $montoEnganche;
							$mesesi = 0;
							$formaPago = 5;

							//Insertamos a la tabla cobro y obtenemos último id
							$id_cobro = $this->insert_cobros($insert_id, $precioFinal, $mesesi, $porcentaje, $fecha_actual, $parcialidades, $formaPago, $pagoCon, $montoEnganche, $total, 0, $area, $referencia, $prosa, $id_contrato, $lugar_prospeccion, $clave_rastreo);
						}
						if($_POST['formaPago'][$x] == 6){
							//Forma de pago transferencia bancaria
							$montoEnganche = $_POST['monto_tb'];
							$engancheTotal += $montoEnganche;
							$mesesi = 0;
							$formaPago = 6;
							$referencia = '';
							$clave_rastreo = $_POST['clave_rastreo_tb'];

							//Insertamos a la tabla cobro y obtenemos último id
							$id_cobro = $this->insert_cobros($insert_id, $precioFinal, $mesesi, $porcentaje, $fecha_actual, $parcialidades, $formaPago, $pagoCon, $montoEnganche, $total, 0, $area, $referencia, $prosa, $id_contrato, $lugar_prospeccion, $clave_rastreo);
						}
					}
					
					$this->db->insert("historial_pagos", array(
						"id_cliente" => $insert_id, 
						"tipo_pago" => 1, 
						"descripcion" => 'Anticipo hecho tras firmar el contrato.', 
						"fecha_creacion" => date("Y-m-d H:i:s"), 
						"creado_por" => $this->session->userdata("inicio_sesion")['id'],
						"id_contrato" => $id_contrato));
					
					if($parcialidades!= 0) {
						for ($q = 0; $q < count($this->input->post("mensualidades")); $q++){
							$fecha = str_replace('/', '-', $_POST['mensualidades'][$q]);
							$fecha_mensualidad2 = date("Y-m-d", strtotime($fecha));
							$b = $q;
							$importe = round(($precioFinal-$pagoCon)/$parcialidades, 2);
							if( ($b + 1) == count($this->input->post("mensualidades")) and $parcialidades > 2 ){
								$importe = $this->ajusteCentavos($parcialidades, $importe, $precioFinal, $engancheTotal);
							}	
							
							$this->db->insert("quincenas", array(
								"id_cobro" => $id_cobro, 
								"importe" => $importe, 
								"fecha_pago" => $fecha_mensualidad2,
								"referencia" =>'0', 
								"numero_pago" => ($q + 1), 					 
								"fecha_creacion" => date("Y-m-d H:i: s"), 
								"creado_por" => $this->session->userdata("inicio_sesion")['id'],
								"id_contrato" => $id_contrato));
						}
					}
				}
				
				$arr = array();
				$arr['id'] = $insert_id;
				$arr['titular'] = $titular;
				$all_clientes[$i] = $arr;
			$con ++;
			}
		}

		$conTwo = 0;
		for( $j = 0; $j < count( $this->input->post("nombre")); $j++ ){
			$nombre = $_POST['nombre'][$j];
			$apellido_paterno = $_POST['apellido_paterno'][$j];
			if($nombre != '' && $apellido_paterno != ''){
				$this->db->insert("paquetes", array(
					"id_cliente" => $insert_id_two[$j] ,
					"fecha_creacion" => date("Y-m-d H:i:s"),
					"creado_por" => $this->session->userdata("inicio_sesion")['id'],
					"id_contrato" => $id_contrato));
				// Se obtiene último id de la tabla paquetes
				$id_paquete = $this->db->insert_id();

				if($conTwo == 0){
					if( $_POST['corte1'] != "0" ){
						for( $a = 0; $a < $_POST['corte1']; $a++ ){
							$corte1 = $this->input->post("selectPicker")[$a];
							$this->db->insert("clientes_x_areas", array("id_cliente" => $insert_id_two[$j], "id_area" => $corte1, "id_paquete" => $id_paquete));
						}
					}
					$this->guardar_tratamientos($array1, $insert_id_two[$j], $id_paquete);
				}

				if($conTwo == 1){
					if( $_POST['corte2'] != "0" ){
						$contador2 = $_POST['corte1'];
						for( $b = 1; $b <= $_POST['corte2']; $b++ ){
							$corte2 = $this->input->post("selectPicker")[$contador2];
							$this->db->insert("clientes_x_areas", array("id_cliente" => $insert_id_two[$j], "id_area" => $corte2, "id_paquete" => $id_paquete));
							$contador2 ++;
						}
					}
					$this->guardar_tratamientos($array2, $insert_id_two[$j], $id_paquete);
				}

				if($conTwo == 2){
					if( $_POST['corte3'] != "0" ){
						$contador3 = $_POST['corte1'] + $_POST['corte2'];
						for( $c = 1; $c <= $_POST['corte3']; $c++ ){
							$corte3 = $this->input->post("selectPicker")[$contador3];
							$this->db->insert("clientes_x_areas", array("id_cliente" => $insert_id_two[$j], "id_area" => $corte3, "id_paquete" => $id_paquete));
							$contador3 ++;
						}
					}
					$this->guardar_tratamientos($array3, $insert_id_two[$j], $id_paquete);
				}

				if($conTwo == 3){
					if( $_POST['corte4'] != "0" ){
						$contador4 = $_POST['corte1'] + $_POST['corte2'] + $_POST['corte3'];
						for( $d = 1; $d <= $_POST['corte4']; $d++ ){
							$corte4 = $this->input->post("selectPicker")[$contador4];
							$this->db->insert("clientes_x_areas", array("id_cliente" => $insert_id_two[$j], "id_area" => $corte4, "id_paquete" => $id_paquete));
							$contador4 ++;
						}
					}
					$this->guardar_tratamientos($array4, $insert_id_two[$j], $id_paquete);
				}

				if($conTwo == 4){
					if( $_POST['corte5'] != "0" ){
						$contador5 = $_POST['corte1'] + $_POST['corte2'] + $_POST['corte3'] + $_POST['corte4'];
						for( $e = 1; $e <= $_POST['corte5']; $e++ ){
							$corte5 = $this->input->post("selectPicker")[$contador5];
							$this->db->insert("clientes_x_areas", array("id_cliente" => $insert_id_two[$j], "id_area" => $corte5, "id_paquete" => $id_paquete));
							$contador5 ++;
						}
					}
					$this->guardar_tratamientos($array5, $insert_id_two[$j], $id_paquete);
				}
				$conTwo ++;
			}
		}

		$object = json_decode(json_encode((object) $all_clientes), FALSE);

		foreach($object as $key){			
			switch ($key->titular){
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
		$json['id_contrato'] = $id_contrato;
		$json['prosa'] = $prosa;
		
		echo json_encode( $json );
	}

	public function guardar_influencer(){
		date_default_timezone_set("America/Mexico_City");
		$json['resultado'] = FALSE;

		//Recibimos los array de los tratamientos RF
		$array1 = json_decode($_POST['arrayTratamientos1'], true);
		$array2 = json_decode($_POST['arrayTratamientos2'], true);
		$array3 = json_decode($_POST['arrayTratamientos3'], true);
		$array4 = json_decode($_POST['arrayTratamientos4'], true);
		$array5 = json_decode($_POST['arrayTratamientos5'], true);

		if($this->input->post("total")){			
			//Datos grales. de la venta. 
			$total = $_POST['total'];
			$descuento = $_POST['descuento'];			
			$precioFinal = $_POST['precioFinalC'];
			$anticipo = $precioFinal;
			//Si el precio final es igual al anticipo, mandamos estatus 3 
			$estatus_contrato = 3;			
			$parcialidades = 0;	
			$formaPago = 5;
			$mesesi = 0;	
			$compartido = 0;
			$prosa = 0;
			//$porcentaje = ($descuento * 100)/$total;			
			$porcentaje = 0;			
			$area = $_POST['area_sel'];
			$observaciones = $_POST['observaciones'];						
			$compartido = '';
			$referencia = '';
			$clave_rastreo = '';
			if(isset($_POST['lugar_prospeccion'])) $lugar_prospeccion = $_POST['lugar_prospeccion'];
			else $lugar_prospeccion = 0;
						
			$nombre = $_POST['nombre'][0];
			$apellido_paterno = $_POST['apellido_paterno'][0];
			$apellido_materno = $_POST['apellido_materno'][0];
			$correo = $_POST['correo'][0];
			$telefono = $_POST['telefono'][0];
			$domicilio = $_POST['domicilio'][0];			
			$titular = 1;

			//INSERT DE NUEVO CLIENTE REGISTRADO					
			$this->db->insert("clientes", array(
				"id_vendedor" => $this->session->userdata("inicio_sesion")['id'],
				"id_sucursal" => 1,
				"nombre" => $nombre,
				"apellido_paterno" => $apellido_paterno,
				"apellido_materno" => $apellido_materno,
				"personalidad_juridica" => 1,
				"rfc" => "XXXXXXXXXXXX",
				"curp" => "XXXXXXXXXXXXXXXXXX",
				"correo" => $correo,
				"telefono" => $telefono,
				"domicilio" => $domicilio == '' ? 'DOMICILIO NO ESPECIFICADO' : $domicilio,
				"tipo" => 2,
				"facturable" => 1,
				"estatus" => 1,
				"nacionalidad" => 1,
				"creado_por" => $this->session->userdata("inicio_sesion")['id'],
				"titular" => $titular
			));

			//Último id insertado en la tabla clientes
			$insert_id = $this->db->insert_id();
			$fecha_actual = date("d-m-Y");

			$this->db->insert("contratos", array("id_cliente" => $insert_id , "tipo" => 1, "estatus" => $estatus_contrato, "servicio" => $area, "observaciones"=>$observaciones));
			$id_contrato = $this->db->insert_id();												

			//Insertamos a la tabla cobro y obtenemos último id
			$id_cobro = $this->insert_cobros($insert_id, $precioFinal, $mesesi, $porcentaje, $fecha_actual, $parcialidades, $formaPago, $anticipo, $anticipo, $total, $compartido, $area, $referencia, $prosa, $id_contrato, $lugar_prospeccion, $clave_rastreo);
											
			$arr = array();
			$arr['id'] = $insert_id;
			$arr['titular'] = $titular;					
																		
			$this->db->insert("paquetes", array(
			"id_cliente" => $insert_id , 
			"fecha_creacion" => date("Y-m-d H:i:s"), 
			"creado_por" => $this->session->userdata("inicio_sesion")['id'],
			"id_contrato" => $id_contrato));
			// Se obtiene último id de la tabla paquetes
			$id_paquete = $this->db->insert_id();
				
			if( $_POST['corte1'] != "0" ){
				for($e = 0; $e < $_POST['corte1']; $e++ ){
					$corte1 = $this->input->post("selectPicker")[$e];
					$this->db->insert("clientes_x_areas", array("id_cliente" => $insert_id, "id_area" => $corte1, "id_paquete" => $id_paquete));
				}
			}									
			$this->guardar_tratamientos($array1, $insert_id, $id_paquete);
			$json['resultado'] = TRUE;
			$json['id_titular'] = $insert_id;
			$json['id_contrato'] = $id_contrato;			
		}
		echo json_encode( $json );
	}

	public function guardar_tratamientos($array, $insert_id, $id_paquete){
		if (!empty($array)){
			foreach($array as $tratamiento){
				if($tratamiento['id'] == '75'){
					$this->guardar_areas_lipo($tratamiento['areas'], $id_paquete);

					$this->db->insert("clientes_x_areas", array(
						"id_cliente" => $insert_id, 
						"id_area" => $tratamiento['id'], 
						"num_sesion" => 1,
						"unidades" => 1,
						"id_paquete" => $id_paquete
					));
				}
				else{
					$this->db->insert("clientes_x_areas", array(
						"id_cliente" => $insert_id, 
						"id_area" => $tratamiento['id'], 
						"num_sesion" => $tratamiento['sesiones'],
						"unidades" => $tratamiento['piezas'],
						"id_paquete" => $id_paquete
					));
				}
			}
		}
	}

	public function guardar_areas_lipo($lipoenzimas, $id_paquete){
		foreach($lipoenzimas as $arealipo){
			$this->db->insert("areas_x_lipoenzimas", array(
				"id_area" =>  $arealipo['id'], 
				"id_paquete" => $id_paquete,
				"sesiones" => $arealipo['sesiones'],
				"fecha_creacion" => date("Y-m-d H:i:s"),
				"creado_por" => $this->session->userdata("inicio_sesion")['id']
			));
		}
	}

	public function ver_cliente($valor){
		echo json_encode($this->Clientes_model->get_data_cliente($valor)->result_array() );
	}

	public function guardado(){ 
   		foreach (array_keys($_POST['nombre']) as $key) {
			$nombre = $_POST['nombre'][$key];
			$apellido = $_POST['apellido'][$key];

			echo "$nombre : $apellido".'<br>';
		}
	}

	public function getDateToday(){
		date_default_timezone_set("America/Mexico_City");
		$dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
		$meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
		$fechaHoy = $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
		echo $fechaHoy;
	}
	
	public function insert_cobros($insert_id, $precioFinal, $mesesi, $porcentaje, $fecha_actual, $parcialidades, $formaPago, $pagoCon, $montoEnganche, $total, $compartido, $area, $referencia, $prosa, $insert_cobros, $lugar_prospeccion, $clave_rastreo){
		date_default_timezone_set("America/Mexico_City");
		if ($parcialidades==0) $parcialidades = 1;
		$this->db->insert("cobros", array(
			"id_cliente" => $insert_id, 
			"concepto" => 'Anticipo', 
			"cantidad" => $precioFinal,
			"fecha_cobro" => date("Y-m-d H:i:s"),
			"msi" => $mesesi,
			"descuento" => $porcentaje,
			"fecha_vencimiento" => date("Y-m-d",strtotime($fecha_actual."+ $parcialidades month")),    // numero de exhibiciones de pago
			"forma_pago" => $formaPago,    // Array de formas de pago 
			"fecha_creacion" => date("Y-m-d H:i:s"),
			"creado_por" => $this->session->userdata("inicio_sesion")['id'],
			"mensualidad" => ($precioFinal-$pagoCon)/$parcialidades,
			"enganche" => $montoEnganche,
			"total" => $total,
			"parcialidades" => $parcialidades,
			"compartido" => $compartido,
			"servicio" => $area,
			"referencia" => $referencia, 
			"prosa" => $prosa, 
			"id_contrato" => $insert_cobros,
			"lugar_prospeccion" => $lugar_prospeccion,
			"clave_rastreo" => $clave_rastreo));
		return $this->db->insert_id();
	}

	public function getIncomeByPaymentForm(){ //NUEVA		
		$data = array();
		$total_v = 0;
		$begin_date = $_POST['begin_date'];
		$end_date = $_POST['end_date'];

		/*TC*/
		$total_tc_1 = $this->Clientes_model->getTotalTdc($begin_date, $end_date)->result();
		$total_tc_2 = $this->Clientes_model->getTotalTdcPQ($begin_date, $end_date)->result();

		$total_tc_1 = ($total_tc_1[0]->total_pagar=='' || $total_tc_1[0]->total_pagar==NULL || $total_tc_1[0]->total_pagar==null) ? 0: $total_tc_1[0]->total_pagar;
		$total_tc_2 = ($total_tc_2[0]->total_pagar=='' || $total_tc_2[0]->total_pagar==NULL || $total_tc_2[0]->total_pagar==null) ? 0 : $total_tc_2[0]->total_pagar;

		$data['total_tdc'][0]['total_pagar'] = $total_tc_1 + $total_tc_2;

		/*TD*/
		$total_td_1 = $this->Clientes_model->getTotalTdd($begin_date, $end_date)->result();
		$total_td_2 = $this->Clientes_model->getTotalTddPQ($begin_date, $end_date)->result();

		$total_td_1 = ($total_td_1[0]->total_pagar=='' || $total_td_1[0]->total_pagar==NULL || $total_td_1[0]->total_pagar==null) ? 0: $total_td_1[0]->total_pagar;
		$total_td_2 = ($total_td_2[0]->total_pagar=='' || $total_td_2[0]->total_pagar==NULL || $total_td_2[0]->total_pagar==null) ? 0: $total_td_2[0]->total_pagar;
		$data['total_tdd'][0]['total_pagar'] = $total_td_1 + $total_td_2;

		/*TCASH*/
		$total_tcash_1 = $this->Clientes_model->getTotalCash($begin_date, $end_date)->result();
		$total_tcash_2 = $this->Clientes_model->getTotalCashPQ($begin_date, $end_date)->result();

		$total_tcash_1 = ($total_tcash_1[0]->total_pagar=='' || $total_tcash_1[0]->total_pagar==NULL || $total_tcash_1[0]->total_pagar==null) ? 0 : $total_tcash_1[0]->total_pagar;
		$total_tcash_2 = ($total_tcash_2[0]->total_pagar=='' || $total_tcash_2[0]->total_pagar==NULL || $total_tcash_2[0]->total_pagar==null) ? 0 : $total_tcash_2[0]->total_pagar;

		$data['total_cash'][0]['total_pagar'] = $total_tcash_1 + $total_tcash_2;

				/*TB*/
		$total_ttb_1 = $this->Clientes_model->getTotalTB($begin_date, $end_date)->result();
		$total_ttb_2 = $this->Clientes_model->getTotalTBPQ($begin_date, $end_date)->result();
		$total_tb_1 = ($total_ttb_1[0]->total_pagar=='' || $total_ttb_1[0]->total_pagar==NULL || $total_ttb_1[0]->total_pagar==null) ? 0 : $total_ttb_1[0]->total_pagar;
		$total_tb_2 = ($total_ttb_2[0]->total_pagar=='' || $total_ttb_2[0]->total_pagar==NULL || $total_ttb_2[0]->total_pagar==null) ? 0 : $total_ttb_2[0]->total_pagar;
		$data['total_ttb'][0]['total_pagar'] = $total_tb_1 + $total_tb_2;

		$data_totales = $this->Clientes_model->getTotalVenta($begin_date, $end_date)->result();
		for($i = 0; $i<count($data_totales); $i++){
			$total_v = $total_v + $data_totales[$i]->cantidad;
		}
		$data['total_venta'] = $total_v;

		if ($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}

	public function clientes_activosDD(){
		$this->load->model("ListaClientes_model");
		$data = $this->ListaClientes_model->get_clientes_activos()->result_array();
		echo json_encode( array( "data" => $data ));
	}

	public function clientes_activos($begin_date, $end_date){ // UPDATED FUNCTION
		$data = $this->Clientes_model->get_clientes_activos_2($begin_date, $end_date)->result_array();
		echo json_encode( array( "data" => $data ));
	}
	
	public function clientes_activos_test($begin_date, $end_date){ // UPDATED FUNCTION
		$data = $this->Clientes_model->get_clientes_activos_2($begin_date, $end_date)->result_array();
		$data_2 = $this->Clientes_model->get_clientes_activos_22($begin_date, $end_date)->result_array();// PAGOS A QUINCENAS COMPLETOS (VIEJITOS)
		$data_3 = $this->Clientes_model->get_clientes_activos_222($begin_date, $end_date)->result_array();// SÓLO ABONOS A QUINCENAS (LOS QUE ESTÁN EN PROCESO)
		$data_4 = $this->Clientes_model->get_clientes_activos_2222($begin_date, $end_date)->result_array();// NUEVOS POGOS COMPLETOS QUE AHORA LA REFERENCIA SE OBTIENE DE ABONOS
		$data_final = array();
		for($n=0; $n < count($data) ; $n++){

			$array_alv = explode(",",$data[$n]['numero_pago']);
			$array_fp = explode(",",$data[$n]['forma_pago'] );

			$data_final[$n]['abonado'] = $data[$n]['abonado'] ;
			$data_final[$n]['cliente'] = $data[$n]['cliente'] ;
			$data_final[$n]['fecha_cobro'] = $data[$n]['fecha_cobro'] ;
			$data_final[$n]['vendedor'] = $data[$n]['vendedor'] ;
			$data_final[$n]['total_pagar'] = $data[$n]['total_pagar'] - $data[$n]['totalEnganche'];
			$data_final[$n]['total_pagar_gen'] = $data[$n]['total_pagar'] ;
			$data_final[$n]['enganche'] = $data[$n]['enganche'] ;
			$data_final[$n]['forma_pago'] = array_values(array_unique($array_fp, SORT_REGULAR)) ;
			$data_final[$n]['concepto'] = $data[$n]['concepto'] ;
			$data_final[$n]['id_cliente'] = $data[$n]['id_cliente'] ;
			$data_final[$n]['totalEnganche'] = $data[$n]['totalEnganche'] ;
			$data_final[$n]['v_compartida'] = ($data[$n]['v_compartida'] == null)?'':$data[$n]['v_compartida'];
			$data_final[$n]['v_compartida_anterior'] = ($data[$n]['v_compartida_anterior']==null)?'':$data[$n]['v_compartida_anterior'] ;
			$data_final[$n]['id_contrato'] = $data[$n]['id_contrato'] ;
			$data_final[$n]['tipo_contrato'] = $data[$n]['tipo'] ;
			$data_final[$n]['estatus_contrado'] = $data[$n]['estatus_contrado'];
			$data_final[$n]['numero_pago'] = array_unique($array_alv, SORT_REGULAR);
			$data_final[$n]['tipoTrans'] = $data[$n]['tipoTrans'];
		}
		// PARA LA 22
		$data_final_2 = array();
		for($i=0; $i < count($data_2) ; $i++){
			$array_compuesto = explode(",",$data_2[$i]['forma_pago']);

			$data_final_2[$i]['abonado'] = $data_2[$i]['abonado'] ;
			$data_final_2[$i]['cliente'] = $data_2[$i]['cliente'] ;
			$data_final_2[$i]['fecha_cobro'] = $data_2[$i]['fecha_cobro'] ;
			$data_final_2[$i]['vendedor'] = $data_2[$i]['vendedor'] ;

			$array_numpago_2 = explode(",",$data_2[$i]['numero_pago']);
			//$data_final_2[$i]['total_pagar'] = $data_2[$i]['total_pagar'] ;
			$cl_saldo = $this->Clientes_model->get_clientes_activos_2_byClient($begin_date, $end_date, $data_2[$i]['id_cliente'], $data_2[$i]['id_contrato'])->result_array();
			$cl_tq = $this->Clientes_model->getTotalQuincenas($end_date, 1, $data_2[$i]['id_contrato'])->result(); // MJ: REGRESA TOTAL PAGADO POR CONCEPTO
			if ($cl_saldo  != null) {
				$saldo_enganche = $cl_saldo[0]['totalEnganche'];
			} else {
				$saldo_enganche = 0;
			}
			$total_pagar = $data_2[$i]['total_pagar'] - $saldo_enganche;

			for($p=0; $p < COUNT($cl_tq); $p++)
			{
				$total_pagar = $total_pagar - $cl_tq[$p]->importe ;
			}

			$data_final_2[$i]['total_pagar'] = $total_pagar ;
			$data_final_2[$i]['total_pagar_gen'] = $data_2[$i]['total_pagar']  ;

			$data_final_2[$i]['enganche'] = $data_2[$i]['enganche'] ;
			$data_final_2[$i]['forma_pago'] = array_values(array_unique($array_compuesto, SORT_REGULAR));
			$data_final_2[$i]['concepto'] = $data_2[$i]['concepto'] ;
			$data_final_2[$i]['id_cliente'] = $data_2[$i]['id_cliente'] ;
			$data_final_2[$i]['totalEnganche'] = $data_2[$i]['totalEnganche'] ;
			$data_final_2[$i]['v_compartida'] = ($data_2[$i]['v_compartida'] == null)?'':$data_2[$i]['v_compartida'];
			$data_final_2[$i]['v_compartida_anterior'] = ($data_2[$i]['v_compartida_anterior'] == null)?'': $data_2[$i]['v_compartida_anterior'];
			$data_final_2[$i]['id_contrato'] = $data_2[$i]['id_contrato'] ;
			$data_final_2[$i]['tipo_contrato'] = $data_2[$i]['tipo'] ;
			$data_final_2[$i]['estatus_contrado'] = $data_2[$i]['estatus_contrado'];
			$data_final_2[$i]['numero_pago'] = array_unique($array_numpago_2, SORT_REGULAR);
			$data_final_2[$i]['tipoTrans'] = $data_2[$i]['tipoTrans'];
		}

		// PARA LA 222
		$data_final_3 = array();
		for($m=0; $m < count($data_3) ; $m++){
			$array_compuesto = explode(",",$data_3[$m]['forma_pago']);

			$data_final_3[$m]['abonado'] = $data_3[$m]['abonado'] ;
			$data_final_3[$m]['cliente'] = $data_3[$m]['cliente'] ;
			$data_final_3[$m]['fecha_cobro'] = $data_3[$m]['fecha_cobro'] ;
			$data_final_3[$m]['vendedor'] = $data_3[$m]['vendedor'] ;
			$array_numpago_3 = explode(",",$data_3[$m]['numero_pago']);
			//$data_final_2[$i]['total_pagar'] = $data_2[$i]['total_pagar'] ;
			$cl_saldo = $this->Clientes_model->get_clientes_activos_2_byClient($begin_date, $end_date, $data_3[$m]['id_cliente'], $data_3[$m]['id_contrato'])->result_array();
			$cl_tq = $this->Clientes_model->getTotalQuincenas($end_date, 2, $data_3[$m]['id_contrato'])->result(); // MJ: REGRESA TOTAL PAGADO POR CONCEPTO

			if ($cl_saldo  != null) {
				$saldo_enganche = $cl_saldo[0]['totalEnganche'];
			} else {
				$saldo_enganche = 0;
			}
			$total_pagar = $data_3[$m]['total_pagar'] - $saldo_enganche;

			for($p=0; $p < COUNT($cl_tq); $p++)
			{
				$total_pagar = $total_pagar - $cl_tq[$p]->importe;
			}

			$data_final_3[$m]['total_pagar'] = $total_pagar ;
			$data_final_3[$m]['total_pagar_gen'] = $data_3[$m]['total_pagar']  ;

			$data_final_3[$m]['enganche'] = $data_3[$m]['enganche'] ;
			$data_final_3[$m]['forma_pago'] = array_values(array_unique($array_compuesto, SORT_REGULAR));
			$data_final_3[$m]['concepto'] = $data_3[$m]['concepto'] ;
			$data_final_3[$m]['id_cliente'] = $data_3[$m]['id_cliente'] ;
			$data_final_3[$m]['totalEnganche'] = $data_3[$m]['totalEnganche'] ;
			$data_final_3[$m]['v_compartida'] = ($data_3[$m]['v_compartida'] == null)?'':$data_3[$m]['v_compartida'];
			$data_final_3[$m]['v_compartida_anterior'] = ($data_3[$m]['v_compartida_anterior'] == null)?'': $data_3[$m]['v_compartida_anterior'];
			$data_final_3[$m]['id_contrato'] = $data_3[$m]['id_contrato'] ;
			$data_final_3[$m]['tipo_contrato'] = $data_3[$m]['tipo'] ;
			$data_final_3[$m]['estatus_contrado'] = $data_3[$m]['estatus_contrado'];
			$data_final_3[$m]['numero_pago'] = array_unique($array_numpago_3, SORT_REGULAR);
			$data_final_3[$m]['tipoTrans'] = $data_3[$m]['tipoTrans'];
		}

		// PARA LA 2222
		$data_final_4 = array();
		for($n = 0; $n < count($data_4) ; $n++){
			$array_compuesto = explode(",",$data_4[$n]['forma_pago']);

			$data_final_4[$n]['abonado'] = $data_4[$n]['abonado'] ;
			$data_final_4[$n]['cliente'] = $data_4[$n]['cliente'] ;
			$data_final_4[$n]['fecha_cobro'] = $data_4[$n]['fecha_cobro'] ;
			$data_final_4[$n]['vendedor'] = $data_4[$n]['vendedor'] ;
			$array_numpago_4 = explode(",",$data_4[$n]['numero_pago']);
			//$data_final_2[$i]['total_pagar'] = $data_2[$i]['total_pagar'] ;
			$cl_saldo = $this->Clientes_model->get_clientes_activos_2_byClient($begin_date, $end_date, $data_4[$n]['id_cliente'], $data_4[$n]['id_contrato'])->result_array();
			$cl_tq = $this->Clientes_model->getTotalQuincenas($end_date, 3, $data_4[$n]['id_contrato'])->result(); // MJ: REGRESA TOTAL PAGADO POR CONCEPTO
			if ($cl_saldo  != null) {
				$saldo_enganche = $cl_saldo[0]['totalEnganche'];
			} else {
				$saldo_enganche = 0;
			}
			$total_pagar = $data_4[$n]['total_pagar'] - $saldo_enganche;

			for($p=0; $p < COUNT($cl_tq); $p++)
			{
				$total_pagar = $total_pagar - $cl_tq[$p]->importe ;
			}

			$data_final_4[$n]['total_pagar'] = $total_pagar ;
			$data_final_4[$n]['total_pagar_gen'] = $data_4[$n]['total_pagar']  ;

			$data_final_4[$n]['enganche'] = $data_4[$n]['enganche'] ;
			$data_final_4[$n]['forma_pago'] = array_values(array_unique($array_compuesto, SORT_REGULAR));
			$data_final_4[$n]['concepto'] = $data_4[$n]['concepto'] ;
			$data_final_4[$n]['id_cliente'] = $data_4[$n]['id_cliente'] ;
			$data_final_4[$n]['totalEnganche'] = $data_4[$n]['totalEnganche'] ;
			$data_final_4[$n]['v_compartida'] = ($data_4[$n]['v_compartida'] == null)?'':$data_4[$n]['v_compartida'];
			$data_final_4[$n]['v_compartida_anterior'] = ($data_4[$n]['v_compartida_anterior'] == null)?'': $data_4[$n]['v_compartida_anterior'];
			$data_final_4[$n]['id_contrato'] = $data_4[$n]['id_contrato'] ;
			$data_final_4[$n]['tipo_contrato'] = $data_4[$n]['tipo'] ;
			$data_final_4[$n]['estatus_contrado'] = $data_4[$n]['estatus_contrado'];
			$data_final_4[$n]['numero_pago'] = array_unique($array_numpago_4, SORT_REGULAR);
			$data_final_4[$n]['tipoTrans'] = $data_4[$n]['tipoTrans'];
		}

		$final_array = array_merge($data_final, $data_final_2, $data_final_4, $data_final_3);		
		echo json_encode( array( "data" => $final_array ));
	}

	public function saveFile($opc){		
		error_reporting(E_ALL ^ E_NOTICE);
		
		$fileNames = $this->handleUploadedFiles($opc);
		print_r( $_FILES["asprise_scans"]['name']);
		if(is_array($fileNames) && count($fileNames) > 0) {
			foreach($fileNames as $index => $filename) {
				if(strpos($filename, 'ERROR:') === 0) {
					print("<p>$filename</p>");
				} else {
					$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
					$targetUrl = dirname($this->getCurrentPageURL()) . str_replace(DIRECTORY_SEPARATOR, "/", substr(UPLOAD_DIR, strlen(__DIR__))) . $filename;
					//print('<a href="' . $targetUrl . '" target="_blank">');
					if (strpos($filename, 'ERROR:') !== 0 && in_array($extension, array('jpg', 'jpeg', 'gif', 'png'))) {
						$imgAnchor = '<img src="' . $targetUrl . '" height="160">';
					} else if (strpos($filename, 'ERROR:') !== 0 && in_array($extension, array('tif', 'tiff'))) {
						$imgAnchor = '<img src="' . dirname($this->getCurrentPageURL()) . '/icon-tif.png">';
					} else if (strpos($filename, 'ERROR:') !== 0 && $extension == 'pdf') {
						$imgAnchor = '<img src="' . dirname($this->getCurrentPageURL()) . '/icon-pdf.png">';
					} else {
						$imgAnchor = '<img src="' . dirname($this->getCurrentPageURL()) . '/icon-others.png">';
					}                        
				}
			}
		}				
	}
	/**
	 * @return an array of mixing simple names of the files uploaded into UPLOAD_DIR and error strings starting with 'ERROR: ' or empty array if there is no uploaded file.
	 */
	function handleUploadedFiles($opc) {
		$fileNames = array();
		if(is_array($_FILES)) {
			foreach($_FILES as $name => $fileSpec) {
				if(! is_array($fileSpec)) {
					continue;
				}

				if(is_array($fileSpec['tmp_name'])) { // multiple files with same name
					foreach($fileSpec['tmp_name'] as $index => $value) {
						if($fileSpec['error'][$index] == UPLOAD_ERR_OK) {
							array_push($fileNames, $this->doHandleUploadedFile($fileSpec['name'][$index], $fileSpec['type'][$index], $fileSpec['tmp_name'][$index], $fileSpec['error'][$index], $fileSpec['size'][$index], $opc));
						}
					}
				} else {
					if($fileSpec['error'] == UPLOAD_ERR_OK) {
						array_push($fileNames, $this->doHandleUploadedFile($fileSpec['name'], $fileSpec['type'], $fileSpec['tmp_name'], $fileSpec['error'], $fileSpec['size'], $opc));
					}
				}
			}
		}
		return $fileNames;
	}
	
	public function getCurrentPageURL() {
		$defaultPort = "80";
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {
			$pageURL .= "s";
			$defaultPort = "443";
		}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != $defaultPort) {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
	/**
	 * @return simple name of the file in the UPLOAD_DIR or an error string starting with 'ERROR: '.
	 */
	function doHandleUploadedFile($name, $type, $tmp_name, $error, $size, $opc) {
		if($error != UPLOAD_ERR_OK) {
			return 'ERROR: upload error code: ' . $error . ' for file ' . $name;
		}

		$extension = pathinfo($name, PATHINFO_EXTENSION);
		if($extension == null || strlen($extension) == 0) {
			$extension = $this->getImageExtensionByMimeType($type);
			if($extension != null) {
				$name .= '.' . $extension;
			}
		}

		if($extension == null || strlen($extension) == 0 ||  (strlen($extension) > 0 && (!in_array(strtolower($extension), array('jpg', 'jpeg', 'gif', 'png', 'tif', 'tiff', 'pdf'))))) {
			return 'ERROR: extension not allowed: ' . $extension . ' for file ' . $name;
		}

		$name = preg_replace("/[^A-Z0-9._-]/i", "_", $name);
		// don't overwrite an existing file
		$i = 0;
		$parts = pathinfo($name);
		while (file_exists(UPLOAD_DIR . $name)) {
			$i++;
			$name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
		}

		if(! file_exists(UPLOAD_DIR)) {
			mkdir(UPLOAD_DIR); // try to mkedir
		}
		$moved = move_uploaded_file($tmp_name, UPLOAD_DIR . DIRECTORY_SEPARATOR . $opc . DIRECTORY_SEPARATOR . $name);
			
		if($moved) {
			chmod(UPLOAD_DIR . DIRECTORY_SEPARATOR . $opc . DIRECTORY_SEPARATOR . $name, 0644);
		} else {
			return 'ERROR: moving uploaded file failed' . ' for file ' . $name;
		}
		return $name;
	}
	function getImageExtensionByMimeType($mimeType) {
		$mimeType = strtolower($mimeType);
		switch($mimeType) {
			case 'image/jpeg': return "jpg";
			case 'image/pjpeg': return 'jpg';
			case 'image/png': return 'png';
			case 'image/gif': return 'gif';
			case 'image/tiff': return 'tif';
			case 'image/x-tiff': return 'tif';
			case 'application/pdf': return 'pdf';
			default: return '';
		}
	}

	function ventaInfluencer(){
		$this->load->view('v_ventaInfluencer');
	}
	
	//Función para reimprimir(opción incluida en el menú)
	public function reimprimir_ticket(){
		$id_ticket = $_POST['id_ticket'];
		$dataArray = array();
		$data = $this->Clientes_model->get_old_ticket($id_ticket);
		$metodos = $this->Clientes_model->get_old_metodos($id_ticket);
		$total_pagado = 0;
		$quincena_pagada=0;
		$data_desglose = array();
		for($i=0; $i<count($metodos); $i++)
		{
			$data_desglose[$i]['metodo'] = $metodos[$i]['metodo_pagos'];
			$data_desglose[$i]['cantidad'] = $metodos[$i]['importeReal'];
			$data_desglose[$i]['fecha_pago'] = $metodos[$i]['fecha_creacion'];

			$total_pagado = ($total_pagado + $metodos[$i]['importeReal']);
		}
		$dataArray['metodos_usados'] = $data_desglose;
		$dataArray['total'] = number_format($total_pagado, 2);
		$dataArray['quincena_pagada'] = $quincena_pagada;
		$dataArray['datos'] = $data;
		if($data != null){
			echo json_encode($dataArray);
		} 
		else{
			$dataArray['datos'][0]['tipo_ticket']=1;
			echo json_encode($dataArray);
		}			
	}

	public function ri($id_ticket){
		$data = $this->Clientes_model->get_old_ticket($id_ticket);

		if($data != null){
			echo json_encode($data);
		} 
		else{
			echo json_encode(array());
		}
	}

	function getLP(){
		$data_request = $this->Clientes_model->getLP();
		print_r(json_encode($data_request));
	}

	function ajusteCentavos($no_par, $pre_par, $precioFinal, $engancheTotal){		
		$precio_uno = $no_par * $pre_par;
		$diferencia =  round($precioFinal - ($precio_uno + $engancheTotal), 2);		
		if ($diferencia < 0) $importe_n = $pre_par - ($diferencia * -1);		
		else $importe_n = $pre_par + $diferencia;
		return $importe_n;	
	}
	
	public function validateSession()
    {
        if ($this->session->userdata("inicio_sesion")['id'] == "") {
            redirect(base_url());
        }
    }

	public function get_areasLipoenzimas(){
		echo json_encode($this->Clientes_model->get_areasLipoenzimas()->result_array());
	}

	public function insertCXA() {
		$this->db->insert("clientes_x_areas", array("id_cliente" => 7, "id_area" => 12, "id_paquete" => 528));
	}
	
}