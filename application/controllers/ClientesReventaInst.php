<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ClientesReventaInst extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('ClientesReventaInst_model'));
		$this->load->model(array('Clientes_model'));
		$this->validar_sesion();
	}

	public function validar_sesion()
	{
		$id_usuario = $this->session->userdata("inicio_sesion")['id'];
		if ($id_usuario == '' || $id_usuario == null || $id_usuario == NULL) {
			redirect(base_url());
		}
	}

	public function index($data)
	{
		$array = array();
		$cxa = array();
		$array['clientes'] = $this->ClientesReventaInst_model->get_lista_clientes($data)->result();
		$array['tarjetas'] = $this->ClientesReventaInst_model->get_lista_tarjetas($data)->result();
		$array['cobros'] = $this->ClientesReventaInst_model->get_lista_cobros($data)->result();
		$array['expediente'] = $this->ClientesReventaInst_model->get_expediente($data)->result();
		$array['contratos'] = $this->ClientesReventaInst_model->get_contrato($data)->result();
		$array['paquetes'] = $this->ClientesReventaInst_model->get_lista_paquetes($data)->result();
		$array['cxamd'] = $this->ClientesReventaInst_model->get_lista_cxamd($data)->result();
		$array['cxarf'] = $this->ClientesReventaInst_model->get_lista_cxarf($data)->result();
		$servicio = $array['contratos'][0]->servicio;
		
		if($servicio == '4' || $servicio == '5'){
			for ($i = 0; $i < COUNT($array['cxarf']); $i++) {
				$array['clte_datail'][$i] = $this->ClientesReventaInst_model->get_areas_rf_details($array['cxarf'][$i]->id_paquete)->result();
			}
		}
		else{
			$array['clte_datail'] = [];
		}
		$this->load->view('v_ClienteReventaInst', $array);
	}

	public function areas_contrato($servicio, $data)
	{
		$array = array();
		$array = $this->ClientesReventaInst_model->get_lista_areas($servicio)->result();
		echo json_encode($array);
	}

	public function get_areas_rf($id_paquete, $id_area)
	{
		echo json_encode($this->ClientesReventaInst_model->get_areas_rf($id_paquete, $id_area)->result_array());
	}

	public function get_areas_lipoenzimas($id_paquete)
	{
		echo json_encode($this->ClientesReventaInst_model->get_areas_lipoenzimas($id_paquete)->result_array());
	}

	public function lista_areas($id_area)
	{
		echo json_encode($this->ClientesReventaInst_model->get_areas_lista($id_area)->result_array());
	}

	public function lista_metodosPago()
	{
		echo json_encode($this->ClientesReventaInst_model->get_metodos_pago()->result_array());
	}

	public function lista_tiposCobro()
	{
		echo json_encode($this->ClientesReventaInst_model->get_tipos_cobro()->result_array());
	}

	public function sino()
	{
		echo json_encode($this->ClientesReventaInst_model->lista_sino()->result_array());
	}

	public function lista_tipos()
	{
		echo json_encode($this->ClientesReventaInst_model->get_tipo_tarjeta()->result_array());
	}

	public function lista_bancos()
	{
		echo json_encode($this->ClientesReventaInst_model->get_bancos()->result_array());
	}

	public function guardarDocumentos()
	{
		date_default_timezone_set("America/Mexico_City");
		$json['resultado'] = FALSE;
		if ($this->input->post("id_titular")) {
			if ($_POST['prosaa'] == 1) { // YA NO PIDO LA TARJETA
				$dataExpediente = array(
					"contrato" => $_POST['contrato_nameFile'],
					"fecha_contrato" => date("Y-m-d H:i:s"),
					"recibo" => $_POST['recibo_nameFile'],
					"fecha_recibo" => date("Y-m-d H:i:s"),
					"carta" => $_POST['cprosa_nameFile'],
					"fecha_carta" => date("Y-m-d H:i:s"),);
			} else {
				if ($_POST['prosa'] == 1) { // PIDO PROSA
					$dataExpediente = array(
						"contrato" => $_POST['contrato_nameFile'],
						"fecha_contrato" => date("Y-m-d H:i:s"),
						"recibo" => $_POST['recibo_nameFile'],
						"fecha_recibo" => date("Y-m-d H:i:s"),
						"carta" => $_POST['cprosa_nameFile'],
						"fecha_carta" => date("Y-m-d H:i:s"),
						"tarjeta" => $_POST['tarjeta_nameFile'],
						"fecha_tarjeta" => date("Y-m-d H:i:s"));
				} else {
					// NO PIDO LA TARJETA
					$dataExpediente = array(
						"contrato" => $_POST['contrato_nameFile'],
						"fecha_contrato" => date("Y-m-d H:i:s"),
						"recibo" => $_POST['recibo_nameFile'],
						"fecha_recibo" => date("Y-m-d H:i:s"));
				}
			}


			$response = $this->ClientesReventaInst_model->update_expediente($dataExpediente, $_POST['id_contrato']);
			if (!$response) {
				$json['resultado'] = TRUE;
			} else {
				$json['resultado'] = FALSE;
			}
		}
		echo json_encode($json);
	}

	public function guardar_clientes()
	{
		date_default_timezone_set("America/Mexico_City");
		$json['resultado[]'] = FALSE;
		//Recibimos los array de los tratamientos RF
		$array1 = json_decode($_POST['arrayTratamientos1'], true);
		$array2 = json_decode($_POST['arrayTratamientos2'], true);
		$array3 = json_decode($_POST['arrayTratamientos3'], true);
		$array4 = json_decode($_POST['arrayTratamientos4'], true);
		$array5 = json_decode($_POST['arrayTratamientos5'], true);

		if ($this->input->post("total")) {
			$protegida = false;
			$protegidas = false;
			$prosa = 0;
			//Evaluamos si fue venta protegida
			if (isset($_POST['protegida']) || isset($_POST['protegidas'])) {
				$protegidas = true;
				$prosa = 1;
			}

			if (isset($_POST['formaPago'])) {
				for ($q = 0; $q < count($this->input->post("formaPago")); $q++) {
					if ($_POST['formaPago'][$q] == 2) {
						for ($r = 0; $r < count($this->input->post("cardNumber")); $r++) {
							if ($_POST['cardNumber'][$r] != '') {
								if ($_POST['tarjetaPrimaria'][$r] == 1) $prosa = 1;
							}
						}
					}
				}
			}

			$con = 0;
			$checki = 0;
			$id_cobro_new = 0;
			//Array clientes ingresados
			$all_clientes = array();

			//Datos grales. de la venta. 
			$total = $_POST['total'];
			$descuento = $_POST['descuento'];
			$pagoCon = $_POST['pagoCon'];
			$precioFinal = $_POST['precioFinalC'];
			$parcialidades = $_POST['parcialidades'];

			$pagoConA = $_POST['pagoConA'];

			$porcentaje = ($descuento * 100) / $total;
			$area = $_POST['area_sel'];
			$referencia = $_POST['referencia'];
			$observaciones = $_POST['observaciones'];
			$engancheTotal = 0;
			if (isset($_POST['lugar_prospeccion'])) $lugar_prospeccion = $_POST['lugar_prospeccion'];
			else $lugar_prospeccion = 0;

			if ($precioFinal == $pagoConA) $precioFinal = $_POST['precioFinal'] + $precioFinal;
			else $precioFinal = $_POST['precioFinalC'];

			//Cambiamos el status de prosa a 1 si ya había sido preseleccionado
			$prosaa = $_POST['prosaa'];
			if ($prosaa == 1) $prosa = 1;

			$contrato = $_POST['contrato_nameFile'];
			$id_contrato_old = $_POST['id_contrato'];
			$id_cobro_old = $_POST['id_cobro_old'];
			$id_cobro_new = $id_cobro_old;
			$referencia = '';
			$clave_rastreo = '';

			// MJ: SE MANDAN DESACTIVAR LOS REGISTROS EXISTAN EN CXA Y AXL
			$this->deactivateRecords($id_contrato_old);

			for ($i = 0; $i < count($this->input->post("id_cliente")); $i++) {
			    //echo "entra cliente ".$i;
				$checki = $i;
				$id_cliente = $_POST['id_cliente'][$i];
				$check = $_POST['checkT'];
				if ($id_cliente != '') {
					$fecha_actual = date("d-m-Y");
					if ($check == ($checki + 1)) $titular = 1;
					else $titular = 0;

					if ($titular == 1) {
					    //echo "entra validación titular";
						//Cambiamos el estatus del antiguo contrato
						$data = array("estatus" => 0);
						$this->db->where("id_contrato", $id_contrato_old);
						$this->db->update("contratos", $data);

						$this->db->insert("contratos", array(
							"id_cliente" => $id_cliente,
							"tipo" => 2,
							"estatus" => 1,
							"servicio" => $area,
							"observaciones" => $observaciones));
						$id_contrato = $this->db->insert_id();
						if (isset($_POST['enfermeras'])) {
						    //echo "entra validación enfermeras";
							for ($n = 0; $n < count($_POST['enfermeras']); $n++) {
								//print_r($_POST['enfermeras'][$n]);
								//exit;
								$data_vc_exist = $this->ClientesReventaInst_model->verifyIfExistVC($id_contrato_old, $_POST['enfermeras'][$n]);

								if (!empty($data_vc_exist)) {
									$data_update = array(
										"creado_por" => $this->session->userdata("inicio_sesion")['id'],
										"fecha_creacion" => date("Y-m-d H:i:s"),
										"id_contrato" => $id_contrato
									);
									$this->ClientesReventaInst_model->update_ventas_compartidas($data_update, $data_vc_exist[0]['id_vc']);
								} else {
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
						}
						$data2 = array("id_contrato" => $id_contrato);
						$this->db->where("id_contrato", $id_contrato_old);
						$this->db->update("clientes_contrato", $data2);

						//Hacemos update del contrato en tarjeta, si ya existía pago recurrente
						if ($prosaa == 1) $this->ClientesReventaInst_model->update_tarjeta($id_contrato_old, $id_contrato);

						if ($protegidas) {
							$tp = $_POST['tarjetaPrimaria'][0];
							$tipoCobro = 1;
							$cardNumber = $_POST['cardNumber'][0];
							$mes = $_POST['mes'][0];
							$anio = $_POST['anio'][0];
							$nameInCard = $_POST['nameInCard'][0];
							$tipoTarjeta = $_POST['tipoTarjeta'][0];
							$banco = $_POST['banco'][0];
							$formaPago = $_POST['tipoCreDeb'][0];
							$montoEnganche = $_POST['montoT'][0];
							$engancheTotal += $montoEnganche;
							$mesesi = $_POST['msi'][0];
							//Registro de tarjetas
							$this->db->insert("tarjetas", array(
								"id_cliente" => $id_cliente,
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
						if ($parcialidades != 0) $mensualidad = ($precioFinal - ($pagoCon + $pagoConA)) / $parcialidades;
						else $mensualidad = 0;
						$fecha_hoy = date("Y-m-d H:i:s");
						$fecha_vencimiento = date("Y-m-d", strtotime($fecha_actual . "+ $parcialidades month"));
						$this->ClientesReventaInst_model->update_cobros($precioFinal, $porcentaje, $fecha_hoy, $fecha_vencimiento, $parcialidades, $total, 0, $id_cliente, $prosa, $mensualidad, $id_contrato, $id_contrato_old, $lugar_prospeccion, $area);

						if (isset($_POST['formaPago'])) {
							for ($x = 0; $x < count($this->input->post("formaPago")); $x++) {
								if ($_POST['formaPago'][$x] == 2 || $protegida == true) {
									$vacio = '';
									for ($y = 0; $y < count($this->input->post("cardNumber")); $y++) {
										if ($_POST['cardNumber'][$y] != '') {
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
										} else $vacio = 0;

										if ($vacio == 1) {
											if (!$protegida && $montoEnganche != 0) {
												//Insertamos a la tabla cobro y obtenemos último id
												$id_cobro_new = $this->ClientesReventaInst_model->insert_cobros($id_cliente, $precioFinal, $mesesi, $porcentaje, $fecha_actual, $parcialidades, $formaPago, $pagoCon, $montoEnganche, $total, 0, $area, $referencia, $prosa, $mensualidad, $id_contrato, $lugar_prospeccion, $clave_rastreo);
											}
											//Registro de tarjetas
											$this->db->insert("tarjetas", array(
												"id_cliente" => $id_cliente,
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
								if ($_POST['formaPago'][$x] == 1) {
									//Forma pago en efectivo
									$montoEnganche = $_POST['efectivo'];
									$engancheTotal += $montoEnganche;
									$mesesi = 0;
									$formaPago = 3;
									$referencia = '';

									//Insertamos a la tabla cobro y obtenemos último id
									$id_cobro_new = $this->ClientesReventaInst_model->insert_cobros($id_cliente, $precioFinal, $mesesi, $porcentaje, $fecha_actual, $parcialidades, $formaPago, $pagoCon, $montoEnganche, $total, 0, $area, $referencia, $prosa, $mensualidad, $id_contrato, $lugar_prospeccion, $clave_rastreo);
								}

								if ($_POST['formaPago'][$x] == 6) {
									//Forma de pago transferencia bancaria
									$montoEnganche = $_POST['monto_tb'];
									$engancheTotal += $montoEnganche;
									$mesesi = 0;
									$formaPago = 6;
									$referencia = '';
									$clave_rastreo = $_POST['clave_rastreo_tb'];

									//Insertamos a la tabla cobro y obtenemos último id
									$id_cobro = $this->ClientesReventaInst_model->insert_cobros($id_cliente, $precioFinal, $mesesi, $porcentaje, $fecha_actual, $parcialidades, $formaPago, $pagoCon, $montoEnganche, $total, 0, $area, $referencia, $prosa, $mensualidad, $id_contrato, $lugar_prospeccion, $clave_rastreo);
								}
							}
						}
						$dataExpediente = array("id_contrato" => $id_contrato);
						$this->ClientesReventaInst_model->update_historial_pagos($id_contrato_old, $id_contrato);
						$this->ClientesReventaInst_model->update_paquetes($id_contrato_old, $id_contrato);
						$this->ClientesReventaInst_model->update_expediente($dataExpediente, $id_contrato_old);
						$this->ClientesReventaInst_model->delete_payments($id_contrato_old);

						if ($parcialidades != 0) {
							for ($q = 0; $q < count($this->input->post("mensualidades")); $q++) {
								$fecha = str_replace('/', '-', $_POST['mensualidades'][$q]);
								$fecha_mensualidad2 = date("Y-m-d", strtotime($fecha));
								$b = $q;
								$importe = round(($precioFinal - ($pagoCon + $pagoConA)) / $parcialidades, 2);
								if (($b + 1) == count($this->input->post("mensualidades")) and $parcialidades > 2) {
									$importe = $this->ajusteCentavos($parcialidades, $importe, $precioFinal, $engancheTotal, $pagoConA);
								}

								$this->db->insert("quincenas", array(
									"id_cobro" => $id_cobro_new,
									"importe" => $importe,
									"fecha_pago" => $fecha_mensualidad2,
									"referencia" => '0',
									"numero_pago" => ($q + 1),
									"fecha_creacion" => date("Y-m-d H:i: s"),
									"creado_por" => $this->session->userdata("inicio_sesion")['id'],
									"id_contrato" => $id_contrato));
							}
						}
					}
					$selectGeneral = count($this->input->post("selectPicker"));
					if ($con == 0) {
						if ($_POST['corte1'] != "0") {
							for ($a = 0; $a < $_POST['corte1']; $a++) {
								$corte1 = $this->input->post("selectPicker")[$a];
								$this->db->insert("clientes_x_areas", array("id_cliente" => $id_cliente, "id_area" => $corte1, "id_paquete" => $_POST['id_paquete'][$con]));
							}
						}
						$this->guardar_tratamientos($array1, $id_cliente, $_POST['id_paquete'][$con]);
					}
					if ($con == 1) {
						if ($_POST['corte2'] != "0") {
							$contador2 = $_POST['corte1'];
							for ($b = 1; $b <= $_POST['corte2']; $b++) {
								$corte2 = $this->input->post("selectPicker")[$contador2];
								// echo "<br> Esta es el área c2 | ".$corte2."<br>";
								$this->db->insert("clientes_x_areas", array("id_cliente" => $id_cliente, "id_area" => $corte2, "id_paquete" => $_POST['id_paquete'][$con]));
								$contador2++;
							}
						}
						$this->guardar_tratamientos($array2, $id_cliente, $_POST['id_paquete'][$con]);
					}
					if ($con == 2) {
						if ($_POST['corte3'] != "0") {
							$contador3 = $_POST['corte1'] + $_POST['corte2'];
							for ($c = 1; $c <= $_POST['corte3']; $c++) {
								$corte3 = $this->input->post("selectPicker")[$contador3];
								// echo "<br> Esta es el área c3 | ".$corte3."<br>";
								$this->db->insert("clientes_x_areas", array("id_cliente" => $id_cliente, "id_area" => $corte3, "id_paquete" => $_POST['id_paquete'][$con]));
								$contador3++;
							}
						}
						$this->guardar_tratamientos($array3, $id_cliente, $_POST['id_paquete'][$con]);
					}
					if ($con == 3) {
						if ($_POST['corte4'] != "0") {
							$contador4 = $_POST['corte1'] + $_POST['corte2'] + $_POST['corte3'];
							for ($d = 1; $d <= $_POST['corte4']; $d++) {
								$corte4 = $this->input->post("selectPicker")[$contador4];
								// echo "<br> Esta es el área c4 | ".$corte4."<br>";
								$this->db->insert("clientes_x_areas", array("id_cliente" => $id_cliente, "id_area" => $corte4, "id_paquete" => $_POST['id_paquete'][$con]));
								$contador4++;
							}
						}
						$this->guardar_tratamientos($array4, $id_cliente, $_POST['id_paquete'][$con]);
					}
					if ($con == 4) {
						if ($_POST['corte5'] != "0") {
							$contador5 = $_POST['corte1'] + $_POST['corte2'] + $_POST['corte3'] + $_POST['corte4'];
							for ($e = 1; $e <= $_POST['corte5']; $e++) {
								$corte5 = $this->input->post("selectPicker")[$contador5];
								// echo "<br> Esta es el área c5 | ".$corte5."<br>";
								$this->db->insert("clientes_x_areas", array("id_cliente" => $id_cliente, "id_area" => $corte5, "id_paquete" => $_POST['id_paquete'][$con]));
								$contador5++;
							}
						}
						$this->guardar_tratamientos($array5, $id_cliente, $_POST['id_paquete'][$con]);
					}
					$con++;
				}
			}
			$json['resultado'] = TRUE;
			$json['id_contrato'] = $id_contrato;
			$json['prosa'] = $prosa;
			$json['prosaa'] = $prosaa;
		}
		echo json_encode($json);
	}

	function ajusteCentavos($no_par, $pre_par, $precioFinal, $engancheTotal, $abonoVentaNueva)
	{
		$precio_uno = $no_par * $pre_par;
		$diferencia = round($precioFinal - ($precio_uno + $engancheTotal + $abonoVentaNueva), 2);
		if ($diferencia < 0) $importe_n = $pre_par - ($diferencia * -1);
		else $importe_n = $pre_par + $diferencia;
		return $importe_n;
	}

	public function getVCByContrato($id_contrato)
	{
		$data_vc = $this->ClientesReventaInst_model->getVCByContrato($id_contrato);

		if ($data_vc != null) {
			echo json_encode($data_vc);
		} else {
			echo json_encode(array());
		}
	}

	public function deactivateRecords($id_contrato)
	{
		//$id_contrato = 602;
		// MJ: getTableInformationByRecord (SELECT * FROM) LLEVA 3 PARÁMETROS $table, $key, $value
		$paquetes = $this->ClientesReventaInst_model->getTableInformationByRecord("paquetes", "id_contrato", $id_contrato)->result_array();
		// MJ: updateRecord (UPDATE) LLEVA 4 PARÁMETROS $table, $data, $key, $value
		$data = array("estatus" => 0);
		$response = array();
		//$response["contratos"] = $this->ClientesReventaInst_model->updateRecord("contratos", $data, "id_contrato", $id_contrato);
		//$response["cobros"] = $this->ClientesReventaInst_model->updateRecord("cobros", $data, "id_contrato", $id_contrato);
		//$response["tarjetas"] = $this->ClientesReventaInst_model->updateRecord("tarjetas", $data, "id_contrato", $id_contrato);
		//$response["quincenas"] = $this->ClientesReventaInst_model->updateRecord("quincenas", $data, "id_contrato", $id_contrato);
		//$response["paquetes"] = $this->ClientesReventaInst_model->updateRecord("paquetes", $data, "id_contrato", $id_contrato);
		//$response["hp"] = $this->ClientesReventaInst_model->updateRecord("historial_pagos", $data, "id_contrato", $id_contrato);
		//$response["cc"] = $this->ClientesReventaInst_model->updateRecord("clientes_contrato", $data, "id_contrato", $id_contrato);
		//$response["expedientes"] = $this->ClientesReventaInst_model->updateRecord("expediente", $data, "id_contrato", $id_contrato);
		for ($i=0; $i < COUNT($paquetes); $i++) { 
			$response[$i]["cxa"] = $this->ClientesReventaInst_model->updateRecord("clientes_x_areas", $data, "id_paquete", $paquetes[$i]['id_paquete']);
			$response[$i]["axl"] = $this->ClientesReventaInst_model->updateRecord("areas_x_lipoenzimas", $data, "id_paquete", $paquetes[$i]['id_paquete']);
		}
		//echo json_encode($response);
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


}


