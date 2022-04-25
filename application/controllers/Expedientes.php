<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Expedientes extends CI_Controller
{
	public function __construct(){
		parent::__construct();
        $this->load->model(array('Expedientes_model'));
		$this->validateSession();
	}

	public function index(){
		$this->load->view('v_expedientes');
	}

	public function lista_expedientes(){
	   $data = $this->Expedientes_model->get_lista_clientes()->result_array();
	   echo json_encode( array( "data" => $data ));
	}
	
	public function clientes_servicio(){
		$this->load->model("Expedientes_model");
	   	$data = $this->Expedientes_model->get_clientes_servicio()->result_array();
	   	echo json_encode( array( "data" => $data ));
	}
	

	public function ver_cliente($valor){
		echo json_encode($this->Expedientes_model->get_data_cliente($valor)->result_array() );
	}

	public function ver_valoracion_cliente($valor){
		$this->load->model("Expedientes_model");
		echo json_encode($this->Expedientes_model->get_valoracion_cliente($valor)->result_array() );
	}
	
	public function get_areas_cliente($valor){
		$data = $this->Expedientes_model->get_areas_cliente($valor)->result_array();
		if (COUNT($data) >= 1) {
			$data2 = array();
			for($i=0; $i < count($data) ; $i++){ // SE RECORRE ARRAY EN BUSCA DE Bikini + línea interglúteo (ÁREA 10)
				if ($data[$i]['id_area'] == 10) { // Bikini + línea interglúteo
					$data2 = $this->Expedientes_model->get_areas_cliente_2($valor, $data[$i]['id_contrato'])->result_array(); // SE TRAEN LAS ÁREAS POR SEPARADP
					unset($data[$i]); // SE ELIMINA Bikini + línea interglúteo DEL ARRAY
				}
			}
			$final_array = array_merge($data, $data2);	
		} else {
			$dataa = $this->Expedientes_model->get_areas_cliente_two($valor)->result_array();
			$data2 = array();
			for($i=0; $i < count($dataa) ; $i++){ // SE RECORRE ARRAY EN BUSCA DE Bikini + línea interglúteo (ÁREA 10)
				if ($dataa[$i]['id_area'] == 10) { // Bikini + línea interglúteo
					$data2 = $this->Expedientes_model->get_areas_cliente_2($valor, $dataa[$i]['id_contrato'])->result_array(); // SE TRAEN LAS ÁREAS POR SEPARADP
					unset($dataa[$i]); // SE ELIMINA Bikini + línea interglúteo DEL ARRAY
				}
			}
			$final_array = array_merge($dataa, $data2);
		}
		echo json_encode($final_array);
	}
	
	public function ver_lista_areas($valor){
		$this->load->model("Expedientes_model");
		echo json_encode($this->Expedientes_model->ver_lista_areas($valor)->result_array() );
	}


	public function historial_expediente(){
		$cliente = $_POST['cliente'];
		$idArea = $_POST['idArea'];
		$this->load->model("Expedientes_model");
		echo json_encode($this->Expedientes_model->historial_expediente($cliente, $idArea)->result_array() );
	}
	public function historial_expediente_todo(){
		$cliente = $_POST['cliente'];
		$this->load->model("Expedientes_model");
		echo json_encode($this->Expedientes_model->historial_expediente_todo($cliente)->result_array() );
	}
	public function lista_areas_historial($cliente){
		$this->load->model("Expedientes_model");
		echo json_encode($this->Expedientes_model->lista_areas_historial($cliente)->result_array() );
	}

	public function get_expediente_u($id_expediente){
		$this->load->model('Expedientes_model');
		echo json_encode($this->Expedientes_model->get_expediente_u($id_expediente)->row());
	}

	public function agregar_registro_exp(){
		$respuesta = array( FALSE );
  			$user = $this->session->userdata("inicio_sesion")['id'];
  			$identifcliente = $this->input->post("idcliente");
			$responsable = $this->input->post("responsable");
			$frecuencia = $this->input->post("frecuencia");
			$fecha_cita = date("Y-m-d H:i:s",strtotime($this->input->post("fecha_cita")));
				  $arrayArea = $this->input->post("idarea[]");
				$countDep = 0;
				$countMold= 0;
				  for($x=0;$x<count($arrayArea);$x++){
						$arrayTipo = $this->input->post("tipo".$arrayArea[$x]."[]");

					  if($arrayTipo[0] == 1){
						$arrayFrecuencia = $this->input->post("frecuencia".$arrayArea[$x]."[]"); 
						$arrayPotencia = $this->input->post("potencia".$arrayArea[$x]."[]"); 
						$arrayBello = $this->input->post("bellorestante".$arrayArea[$x]."[]");
						$dur_area = $this->input->post("dur_area".$arrayArea[$x]."[]");
						$observacion_exp = $this->input->post("observacion_cita".$arrayArea[$x]."[]"); 
						
						$this->db->query("INSERT INTO expediente_clinico (fecha_sesion, id_area, potencia, frecuencia, bello_restante, id_enfermera, observaciones, fecha_creacion, creado_por, id_cliente, duracion) VALUES('".$fecha_cita."', '".$arrayArea[$x]."', '".$arrayPotencia[0]."', '".$arrayFrecuencia[0]."', '".$arrayBello[0]."', '".$responsable."', '".$observacion_exp[0]."', GETDATE(), '".$user."', '".$identifcliente."', ".$dur_area[0].")");

						//$this->db->query("UPDATE clientes_x_areas SET estatus=0 WHERE id_cliente=".$identifcliente." AND id_area=".$arrayArea[$x]." AND estatus = 1;");
						$countDep++;
					  }
					  else{
						$arrayTempIni = $this->input->post("tempIni".$arrayArea[$x]."[]");  
						$rfIni = $this->input->post("rfIni".$arrayArea[$x]."[]"); 
						$rfFin = $this->input->post("rfFin".$arrayArea[$x]."[]"); 
						$arrayTempFin = $this->input->post("tempFin".$arrayArea[$x]."[]");
						$dur_area = $this->input->post("dur_area".$arrayArea[$x]."[]");
						$observacion_exp = $this->input->post("observacion_cita".$arrayArea[$x]."[]"); 
						
						$this->db->query("INSERT INTO expediente_clinico (fecha_sesion, id_area, potencia, frecuencia, bello_restante, tempIni, rfIni, rfFin, tempFin,id_enfermera, observaciones, fecha_creacion, creado_por, id_cliente, duracion) VALUES('".$fecha_cita."', '".$arrayArea[$x]."',0,0,0, '".$arrayTempIni[0]."', '".$rfIni[0]."', '".$rfFin[0]."', '".$arrayTempFin[0]."', '".$responsable."', '".$observacion_exp[0]."', GETDATE(), '".$user."', '".$identifcliente."', ".$dur_area[0].")");

						//$this->db->query("UPDATE clientes_x_areas SET estatus=0 WHERE id_cliente=".$identifcliente." AND id_area=".$arrayArea[$x]." AND estatus = 1;");
					  $countMold++;
					  }
					}
			  if($this->input->post("fotoTipo")){
				$fotoTipo = $this->input->post("fotoTipo");
				$this->db->query("UPDATE clientes SET fotoTipo = '$fotoTipo' WHERE id_cliente = '$identifcliente';");
			  }

  			$respuesta = array( TRUE );

  		echo json_encode( $respuesta );
	  }
	  

	  public function agregar_registro_expM(){
		$respuesta = array( FALSE );
		if($this->input->post("idagenda")) {
			$arrayArea = $this->input->post("idarea[]");
  			$arrayFrecuencia = $this->input->post("frecuencia[]");  
  			$arrayCelulitis = $this->input->post("celulitis[]"); 
  			$arrayMedidas = $this->input->post("medidas[]"); 
  			$observacion_exp = $this->input->post("observacion_cita"); 
  			$identificagenda = $this->input->post("idagenda");
  			$user = $this->session->userdata("inicio_sesion")['id'];
  			$identifcliente = $this->input->post("idcliente");

  			for ($i=0; $i < sizeof($arrayArea); $i++) {
  				$this->db->query("INSERT INTO [expediente_clinico] (fecha_sesion, id_area, potencia, frecuencia, bello_restante, id_enfermera, observaciones, fecha_creacion, creado_por, id_cliente, id_agenda) VALUES(GETDATE(), '".$arrayArea[$i]."', '".$arrayCelulitis[$i]."', '".$arrayFrecuencia[$i]."', '".$arrayMedidas[$i]."', '".$user."', '".$observacion_exp."', GETDATE(), '".$user."', '".$identifcliente."', '".$identificagenda."')");
  			}

  			$this->db->query("UPDATE [agenda] SET estatus = 3 where id_agenda = ".$identificagenda."");

  			$respuesta = array( TRUE );

  		}
  		echo json_encode( $respuesta );
  	}

	  public function get_enfermeras(){
		$this->load->model("Expedientes_model");
		echo json_encode($this->Expedientes_model->get_enfermeras()->result_array() );
	}

	public function update_registro_exp_d($id_expediente){
		$potencia =  $_POST['potencia'];
		$frecuencia =  $_POST['frecuencia'];
		$bellorestante = $_POST['bellorestante'];
		$dur_area = $_POST['dur_area'];
		$observaciones = $_POST['observaciones'];
		$fecha_cita = date("Y-m-d H:i:s",strtotime($_POST['fecha_cita']));;
		$responsable = $_POST['responsable'];
		$id_sesion = $this->session->userdata("inicio_sesion")['id'];

		$query = $this->Expedientes_model->update_registro_exp_d($potencia, $frecuencia, $bellorestante, $dur_area, $observaciones, $id_sesion, $fecha_cita, $responsable, $id_expediente);
		
		echo json_encode( $query );
	}

	public function update_registro_exp_m($id_expediente){
		$tempIni = $_POST['tempIni'];
		$rfIni = $_POST['rfIni'];
		$rfFin = $_POST['rfFin'];
		$tempFin = $_POST['tempFin'];
		$dur_area = $_POST['dur_area'];
		$observaciones = $_POST['observaciones'];
		$fecha_cita = date("Y-m-d H:i:s",strtotime($_POST['fecha_cita']));;
		$responsable = $_POST['responsable'];
		$id_sesion = $this->session->userdata("inicio_sesion")['id'];
	
		$query = $this->Expedientes_model->update_registro_exp_m($tempIni, $rfIni, $rfFin, $tempFin, $dur_area, $observaciones, $id_sesion, $fecha_cita, $responsable, $id_expediente);
		
		echo json_encode( $query );
	}

	public function validateSession()
    {
        if ($this->session->userdata("inicio_sesion")['id'] == "") {
            redirect(base_url());
        }
    }
 
}
 