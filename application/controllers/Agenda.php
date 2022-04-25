<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends CI_Controller {
	public function __construct() {
		parent::__construct();
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Headers: Content-Type');

		$this->load->model('Agenda_model');
		$this->validateSession();
	}

	public function index(){
		$this->load->view("v_Agenda");
	}

	public function obtener_datos(){
		$this->load->model('Agenda_model');		
		$array = array();
		$arrayp = array();		
		$arrayp['clientes'] = $this->Agenda_model->obtener_datos()->result();
		
		for($x = 0;$x<count($arrayp['clientes']);$x++){	
			$lit = array("ID" => $arrayp['clientes'][$x]->ID,
						 "title" => $arrayp['clientes'][$x]->title,
						 "start" => $arrayp['clientes'][$x]->start,
						 "end" => $arrayp['clientes'][$x]->endd,
						 "color" => $arrayp['clientes'][$x]->color);
			$array[] = $lit;
		}
		echo json_encode($array);		
		// print_r(json_encode($this->Agenda_model->obtener_datos()->result_array()));
	}

	public function datos_agenda(){
		$this->load->model('Agenda_model');
		echo json_encode($this->Agenda_model->datos_agenda($this->input->post('userid'))->result_array());
	}

	public function get_agenda_depilacion(){
		echo json_encode($this->Agenda_model->get_agenda_depilacion()->result_array());
	}

	public function ver_contenido($id){
		$this->load->model('Agenda_model');
		echo json_encode($this->Agenda_model->get_ruta_contrato($id)->result_array());
	}


	public function lista_proveedores_libres(){
		$data["provedores_total"] = $this->Agenda_model->get_proveedores_lista()->num_rows();
		echo json_encode( $data );
	}

	public function lista_clientes(){
		$this->load->model('Agenda_model');
		echo json_encode($this->Agenda_model->get_clientes_lista()->result_array());
	}

	public function existencia_agenda($id_agenda, $id_area){
		$this->load->model('Agenda_model');
		echo json_encode($this->Agenda_model-> get_existencia_agenda($id_agenda, $id_area)->result_array());
	}
	public function get_areas_depilacion($id_cliente){
		$this->load->model('Agenda_model');
		echo json_encode($this->Agenda_model->get_areas_depilacion($id_cliente)->result_array());
	}

	public function fechas_para_clientes($dia, $cliente){
		$this->load->model('Agenda_model');
		$respuesta_fech = $this->db->query("SELECT * FROM [agenda] WHERE id_cliente = ".$cliente);

		/*print_r($respuesta_fech->result());
		exit;*/
		if($respuesta_fech->num_rows()>0){
			$respuesta = $this->Agenda_model->get_clientes_fechas($dia, $cliente)->result_array();
		}
		else{
			$respuesta = $this->Agenda_model->get_clientes_fechas_pc($dia, $cliente)->result_array();
		}
		echo json_encode( $respuesta );
	}

	public function fechas_clientes_moldeo($dia, $cliente){
		$this->load->model('Agenda_model');
		echo json_encode($this->Agenda_model->get_clientes_fechas_moldeo($dia, $cliente)->result_array());
	}

	public function fecha_fina_cliente($dia, $cliente){
		$this->load->model('Agenda_model');
		echo json_encode($this->Agenda_model->fechas_final_clientes($dia, $cliente)->result_array());
	}

	public function verificar_fecha(){
		$depilacion = array();
		$moldeo= array();
		$service=0;
		$this->load->model('Agenda_model');
		$duracion = $this->input->post("duracion");
		$date=date("Y-m-d H:i:s",strtotime($this->input->post("fech_eleccion")));
		$date3=date("Y-m-d",strtotime($this->input->post("fech_eleccion")));
		$time = new DateTime($date);
		$time->add(new DateInterval('PT' . $duracion . 'M'));
		$stamp = $time->format('Y-m-d H:i');
		$servicio = $this->input->post("servicio");
		$servicio = explode(',',$servicio);
		foreach($servicio as $tipo){
			$tipo == 1 ? array_push($depilacion,$tipo):array_push($moldeo, $tipo);
		}
		if(count($depilacion)>0){
			$service++;
		}
		if(count($moldeo)>0){
			$service = $service+2;
		}

		$format = 'Y-m-d H:i:s';
		$date_hour = DateTime::createFromFormat($format, $date);
		//print_r($date_hour);
		$hora = $date_hour->format('H:i:s');/* $this->input->post("colorin")*/
		echo json_encode($this->Agenda_model->verificar_fecha($date3, $stamp, $service, $hora)->result_array());
	}

	public function citas_del_dia(){
		$depilacion = array();
		$moldeo= array();
		$service=0;
		$this->load->model('Agenda_model');
		$duracion = $this->input->post("duracion");
		$date=date("Y-m-d H:i:s",strtotime($this->input->post("fech_eleccion")));
		$date3=date("Y-m-d",strtotime($this->input->post("fech_eleccion")));
		$time = new DateTime($date);
		$time->add(new DateInterval('PT' . $duracion . 'M'));
		$stamp = $time->format('Y-m-d H:i');
		$servicio = $this->input->post("servicio");
		$servicio = explode(',',$servicio);
		foreach($servicio as $tipo){
			$tipo == 1 ? array_push($depilacion,$tipo):array_push($moldeo, $tipo);
		}
		if(count($depilacion)>0){
			$service++;
		}
		if(count($moldeo)>0){
			$service = $service+2;
		}

		$format = 'Y-m-d H:i:s';
		$date_hour = DateTime::createFromFormat($format, $date);
		//print_r($date_hour);
		$hora = $date_hour->format('H:i:s');/* $this->input->post("colorin")*/
		echo json_encode($this->Agenda_model->citas_del_dia($date3, $stamp, $service, $hora)->result_array());
	}

	public function verificar_citas_today(){
		$this->load->model('Agenda_model');
		$fecha = date("Y-m-d",strtotime($this->input->post("fecha_checar")));

		$data = $this->Agenda_model->verificar_citas_today($fecha);

		
		if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }	
	}

	public function agregar_datos_cita(){
		$this->load->model('Agenda_model');
		// $respuesta = array( FALSE );

		// if($this->input->post("colorin")){
			$depilacion = array();
			$moldeo= array();
			$service=0;
			$date1=date("Y-m-d H:i:s",strtotime($this->input->post("fech_eleccion")));
			$format = 'Y-m-d H:i:s';
			$date_hour = DateTime::createFromFormat($format, $date1);
			//print_r($date_hour);
			$hora = $date_hour->format('H:i:s');/* $this->input->post("colorin")*/
			$cliente = $this->input->post("id_cliente");
			//$this->input->post("fech_eleccion")
			$fecha = date("Y-m-d",strtotime($this->input->post("fech_eleccion")));
			$areas = $this->input->post("ar_value");
			$duracion = $this->input->post("duracion");
			$user = $this->session->userdata("inicio_sesion")['id'];
			$val_areas = $this->input->post("ar_value");
			$servicio = $this->input->post("servicio");
			$servicio = explode(',',$servicio);
			foreach($servicio as $tipo){
				$tipo == 1 ? array_push($depilacion,$tipo):array_push($moldeo, $tipo);
			}
			if(count($depilacion)>0){
				$service++;
			}
			if(count($moldeo)>0){
				$service = $service+2;
			}
			$verificar = $this->db->query("SELECT * FROM [agenda] WHERE id_cliente = ".$cliente."");
			if ($verificar->num_rows()>0){
				$this->db->query("UPDATE [clientes_x_areas] SET estatus = 1 WHERE estatus != 2 AND id_cliente = ".$cliente." AND id_area in (".$areas.")");
				$this->db->query("INSERT INTO [agenda] (id_cliente, fecha_cita, id_sucursal, estatus, fecha_creacion, creado_por, id_cabina, hora_inicio, hora_fin, lista_areas, servicio) VALUES(".$cliente.", '".$fecha."',1,1,GETDATE(),'".$user."',1,'".$hora."',DATEADD(minute,".$duracion.",'".$hora."'),'".$areas."','".$service."')");
			}
			else{
				$this->db->query("UPDATE [clientes_x_areas] SET estatus = 1 WHERE estatus != 2 AND id_cliente = ".$cliente." AND id_area in (".$areas.")");
				$this->db->query("INSERT INTO [agenda] (id_cliente, fecha_cita, id_sucursal, estatus, fecha_creacion, creado_por, id_cabina, hora_inicio, hora_fin, lista_areas, servicio) VALUES(".$cliente.", '".$fecha."',1,1,GETDATE(),'".$user."',1,'".$hora."',DATEADD(minute,".$duracion.",'".$hora."'),'".$areas."','".$service."')");
			}

			$ID_agenda = $this->db->insert_id();
			$array_areas = (explode(',', $val_areas));
			for($i=0;$i<sizeof($array_areas);$i++){
				$this->db->query("INSERT INTO [areas_x_cita] VALUES(".$ID_agenda.", '".$array_areas[$i]."', GETDATE(), 1)");
			}
			$respuesta = array( TRUE );
		// }
		echo json_encode( $respuesta );
	}

	public function cancelar_agenda(){
		$this->load->model('Agenda_model');
		$respuesta = array( FALSE );
		if($this->input->post("agenda_cancelada")){
			$user = $this->session->userdata("inicio_sesion")['id'];

			$respuesta =  $this->Agenda_model->cancelar_cita($this->input->post("agenda_cancelada"), $this->input->post("cliente"), $user);
			$respuesta = array( TRUE );
		}
		echo json_encode($respuesta);
	}

	function cargar_tipo_cambio(){
		$respuesta = array( FALSE );
		if($this->input->post("idautopago")){
			$data = array("tipoCambio" => $this->input->post("tipo_cambio"));
			$respuesta = array( $this->Solicitudes_cxp->update_autoPago( $this->input->post("idautopago"), $data ) );
		}
		echo json_encode( $respuesta );
	}

	public function fechas_obtenidas_sabado($fecha, $intervalo, $rango){
		$this->load->model('Agenda_model');
		if($rango=='1'){
			$hora_apertura = '11:00:00';
			$hora_cierre = '15:00:00';
		}

		if($rango=='2'){
			$hora_apertura = '15:00:00';
			$hora_cierre = '20:00:00';
		}

		$datos_ocupados = $this->db->query("SELECT * FROM [agenda] WHERE fecha_cita LIKE '".$fecha."' ORDER BY hora_inicio");

		if($datos_ocupados->num_rows()>0){
			foreach($datos_ocupados->result() as $row){
				$hora_uno = $row->hora_inicio;
				$hora_dos = $row->hora_fin;
				$entrada = new DateTime($hora_apertura);
				$cierre = new DateTime($hora_cierre);
				$salida = new DateTime($hora_uno);
				$salida_2 = new DateTime($hora_dos);
				$diferencia = $entrada->diff($salida);
				$diferenci2 = $cierre->diff($salida_2);
				$dife[] = $diferencia->format("%H:%i:%s");
				$dife_2[] = $diferenci2->format("%H:%i:%s");
			}

			$cola = $dife;
			array_push($cola, "09:00:0");
			$cola2 = $dife_2;
			array_unshift($cola2, "09:00:0");

			for($i=0;$i<count($cola);$i++){
				$porciones = explode(":", $cola[$i]);
				$var_t1 = (($porciones[0]*60)+$porciones[1])*60;
				$porciones_2 = explode(":", $cola2[$i]);
				$var_t2 = 60*(($porciones_2[0]*60)+$porciones_2[1]);
				$segundos_horaInicial=strtotime($hora_cierre);
				$nuevaHora=date("H:i:s",$segundos_horaInicial-$var_t2);
				$segundos_horaIn=strtotime($hora_apertura);
				$nuevaHora2=date("H:i:s",$segundos_horaIn+$var_t1);
				$data_1 =  ($this->intervaloHora( $nuevaHora, $nuevaHora2, $intervalo ));
				echo json_encode ($data_1);
			}
		}
		else{
			if($rango=='1'){
				$data_1 = ($this->intervaloHora('11:00:00', '15:00:00', $intervalo ));
				echo json_encode ($data_1);
			}
			if($rango=='2'){
				$data_1 = ($this->intervaloHora('15:00:00', '20:00:00', $intervalo ));
				echo json_encode ($data_1);
			}
		}
	}

	public function intervaloHora($hora_inicio, $hora_fin, $intervalo) {
		$hora_inicio = new DateTime($hora_inicio);
		$hora_fin  = new DateTime($hora_fin);
		$hora_fin->modify('+1 second');

		if ($hora_inicio > $hora_fin){
			$hora_fin->modify('+1 day');
		}
		$intervalo = new DateInterval('PT'.$intervalo.'M');
		$periodo = new DatePeriod($hora_inicio, $intervalo, $hora_fin);

		foreach($periodo as $hora) {
			$horas[] = $hora->format('H:i');
		}
		return $horas;
	}

	public function checkifHaveDate($id_contrato){
		/**CHECAR SI TRONARIA EN EL REAL PARA ASÍ COLOCARLO EN EL REAL**/
	
		$respuesta_fech = $this->db->query("SELECT * FROM [agenda] WHERE estatus=1 AND id_cliente = ".$id_contrato);
		$resp = $respuesta_fech->result();
		if($resp != null){
			echo json_encode($resp);
		} 
		else{
			echo json_encode(array());
		}
	}
	
	public function update_cita(){
		$depilacion = array();
		$moldeo= array();
		$this->load->model('Agenda_model');
		$idAgenda = $this->input->post("id_agenda");
		$areasArray = $this->input->post("valor_arease");
		$servicio = $this->input->post("servicio");
		$date1=date("Y-m-d H:i:s",strtotime($this->input->post("fech_eleccion")));
		$format = 'Y-m-d H:i:s';
		$date_hour = DateTime::createFromFormat($format, $date1);
		//print_r($date_hour);
		$hora = $date_hour->format('H:i:s');/* $this->input->post("colorin")*/
		//$this->input->post("fech_eleccion")
		$fecha = date("Y-m-d",strtotime($this->input->post("fech_eleccion")));
		$duracion = $this->input->post("duracion");
		$user = $this->session->userdata("inicio_sesion")['id'];
		$service =0;
		$servicio = explode(',',$servicio);

		$id_cliente = $this->input->post("id_cliente_e");

		foreach($servicio as $tipo){
			$tipo == 1 ? array_push($depilacion,$tipo):array_push($moldeo, $tipo);
		}
		if(count($depilacion)>0){
			$service++;
		}
		if(count($moldeo)>0){
			$service = $service+2;
		}
		// $this->db->query("UPDATE clientes_x_areas SET estatus = 1 WHERE estatus != 2 AND id_cliente = ".$cliente." AND id_area in (".$areas.")");
		$respuesta = $this->Agenda_model->update_cita($fecha, $user,$hora, $duracion, $areasArray, $service, $idAgenda);
		// }
		echo json_encode( $respuesta );
	}

	public function validateSession()
    {
        if ($this->session->userdata("inicio_sesion")['id'] == "") {
            redirect(base_url());
        }
    }
}
