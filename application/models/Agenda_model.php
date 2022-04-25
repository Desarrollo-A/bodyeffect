<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agenda_model extends CI_Model {


	function __construct(){
		parent::__construct();
	}

	function obtener_datos(){
		return $this->db->query("SELECT a.id_agenda as ID, c.nombre as title, concat(CONVERT(VARCHAR(10),a.fecha_cita,23),' ', a.hora_inicio) as start, concat(CONVERT(VARCHAR(10),a.fecha_cita,23),' ', a.hora_fin) as endd,
    CASE 
      WHEN a.estatus = 2
        THEN 'rgb(174, 173, 173)'
      WHEN a.servicio=1
        THEN 'rgb(251,205,229)'
      WHEN a.servicio=2
        THEN 'rgb(199, 177, 221)'
      WHEN a.servicio=3
        THEN 'rgb(128, 228, 209)'
    END as color
		from [agenda] as a 
    INNER JOIN [clientes] as c ON c.id_cliente = a.id_cliente 
    WHERE a.estatus IN (1, 2)");
	}



	function get_ruta_contrato($data){
		return $this->db->query("SELECT contrato FROM [expediente] WHERE id_cliente = ".$data);
	}
	function cancelar_cita($agenda, $cliente, $user){
		//estatus 3 es cancelada
		$this->db->query("INSERT INTO [logs] VALUES(".$cliente.", ".$user.", 'CANCELÓ CITA ".$agenda."', GETDATE(), 1)");
		$this->db->query("UPDATE clientes_x_areas SET estatus = 0 WHERE id_area IN (SELECT id_area FROM areas_x_cita WHERE d_agenda = ".$agenda.") AND id_cliente = ".$cliente."");
		return $this->db->query("UPDATE [agenda] SET estatus = 3, hora_inicio = null, hora_fin = null WHERE id_agenda = ".$agenda."");
	}

	function datos_agenda($data){    
		$this->db->query("SET LANGUAGE Spanish");
		return $this->db->query("SELECT a.id_agenda, c.id_cliente,a.estatus, convert(char(5), a.hora_inicio, 108) as hora_letra, STRING_AGG((CASE ar.tipo WHEN 1 THEN CONCAT(ar.nombre, ' (depilación)') WHEN 2 THEN CONCAT(ar.nombre, ' (moldeo)') END), ', ') AS valor, a.fecha_cita , CONCAT(c.nombre,' ',c.apellido_paterno,' ',c.apellido_materno) AS nombrecompleto, c.correo, c.telefono
                FROM [areas] AS ar 
                INNER JOIN [areas_x_cita] AS cxa ON cxa.id_area = ar.id_area  
                INNER JOIN [agenda] as a on a.id_agenda = cxa.d_agenda 
                INNER JOIN [clientes] AS c ON c.id_cliente = a.id_cliente  
                WHERE a.id_agenda = ".$data."
                GROUP BY c.id_cliente, c.nombre, c.apellido_paterno, c.apellido_materno, c.correo, c.telefono, c.tipo, c.estatus,   a.hora_inicio, a.fecha_cita, c.id_cliente, a.id_agenda, a.estatus");

	}


	function get_clientes_lista(){
		return $this->db->query("SELECT CONCAT(nombre,' ',apellido_paterno,' ',apellido_materno) as nombre FROM [clientes] ORDER BY clientes.nombre");
	}

	function get_areas_depilacion($id_cliente){

		return $this->db->query("SELECT a.duracion, a.id_area, a.nombre, a.tipo, pq.id_contrato
		FROM [clientes_x_areas]  cxa
		INNER JOIN [areas]  a ON a.id_area=cxa.id_area
		INNER JOIN [paquetes]  pq ON pq.id_paquete=cxa.id_paquete
		WHERE cxa.id_cliente = $id_cliente");
	}

	function get_clientes_fechas_pc($dia, $cliente){

		switch ($dia) {
			case '2'://I N I C I A  C A S O  2
				return $this->db->query("SELECT id_cliente, fecha_contrato as ultima_cita, DATEADD(month, 1, fecha_contrato) AS NuevaUno,
                    (CASE
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) ) IN(1) THEN CAST( DATEADD(day, 0, DATEADD(day, 4, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) ) IN(2) THEN CAST( DATEADD(day, 0, DATEADD(day, 4, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) ) IN(3) THEN CAST( DATEADD(day, 0, DATEADD(day, 4, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) ) IN(4) THEN CAST( DATEADD(day, 0, DATEADD(day, 4, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) ) IN(5) THEN CAST( DATEADD(day, 0, DATEADD(day, 4, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) ) IN(6) THEN CAST( DATEADD(day, 0, DATEADD(day, 4, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) ) IN(7) THEN CAST( DATEADD(day, 0, DATEADD(day, 4, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) AS DATE)
                    END) AS valor_sabado,

                    (CASE
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) ) IN(1) THEN CAST( DATEADD(day, 5, DATEADD(day, 0, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) ) IN(2) THEN CAST( DATEADD(day, 5, DATEADD(day, 0, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) ) IN(3) THEN CAST( DATEADD(day, 5, DATEADD(day, 0, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) ) IN(4) THEN CAST( DATEADD(day, 5, DATEADD(day, 0, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) ) IN(5) THEN CAST( DATEADD(day, 5, DATEADD(day, 0, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) ) IN(6) THEN CAST( DATEADD(day, 5, DATEADD(day, 0, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) ) IN(7) THEN CAST( DATEADD(day, 5, DATEADD(day, 0, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_contrato END))) AS DATE)
                    END) AS valor_domingo 

                    FROM [contratos] WHERE id_cliente = ".$cliente);
				break; //F I N  C A S O  2


			case '1':
				// echo "HERE";
				return $this->db->query("SELECT id_cliente, fecha_contrato as ultima_cita, DATEADD(month, 1, fecha_contrato) AS NuevaUno,
                    (CASE
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, fecha_contrato)) ) IN(1) THEN CAST( DATEADD(day, 1, DATEADD(day, 0, fecha_contrato)) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, fecha_contrato)) ) IN(2) THEN CAST( DATEADD(day, 1, DATEADD(day, 0, fecha_contrato)) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, fecha_contrato)) ) IN(3) THEN CAST( DATEADD(day, 1, DATEADD(day, 0, fecha_contrato)) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, fecha_contrato)) ) IN(4) THEN CAST( DATEADD(day, 1, DATEADD(day, 0, fecha_contrato)) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, fecha_contrato)) ) IN(5) THEN CAST( DATEADD(day, 1, DATEADD(day, 0, fecha_contrato)) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, fecha_contrato)) ) IN(6) THEN CAST( DATEADD(day, 1, DATEADD(day, 0, fecha_contrato)) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, fecha_contrato)) ) IN(7) THEN CAST( DATEADD(day, 1, DATEADD(day, 0, fecha_contrato)) AS DATE)
                    END) AS valor_uno_sem,

                    (CASE
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, fecha_contrato)) ) IN(1) THEN CAST( DATEADD(day, 0, DATEADD(day, 2, fecha_contrato)) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, fecha_contrato)) ) IN(2) THEN CAST( DATEADD(day, 0, DATEADD(day, 2, fecha_contrato)) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, fecha_contrato)) ) IN(3) THEN CAST( DATEADD(day, 0, DATEADD(day, 2, fecha_contrato)) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, fecha_contrato)) ) IN(4) THEN CAST( DATEADD(day, 0, DATEADD(day, 2, fecha_contrato)) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, fecha_contrato)) ) IN(5) THEN CAST( DATEADD(day, 0, DATEADD(day, 2, fecha_contrato)) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, fecha_contrato)) ) IN(6) THEN CAST( DATEADD(day, 0, DATEADD(day, 2, fecha_contrato)) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, fecha_contrato)) ) IN(7) THEN CAST( DATEADD(day, 0, DATEADD(day, 2, fecha_contrato)) AS DATE)
                    END) AS valor_dos_sem,

                    (CASE
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, fecha_contrato)) ) IN(1) THEN CAST( DATEADD(day, 1, DATEADD(day, 2, fecha_contrato)) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, fecha_contrato)) ) IN(2) THEN CAST( DATEADD(day, 1, DATEADD(day, 2, fecha_contrato)) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, fecha_contrato)) ) IN(3) THEN CAST( DATEADD(day, 1, DATEADD(day, 2, fecha_contrato)) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, fecha_contrato)) ) IN(4) THEN CAST( DATEADD(day, 1, DATEADD(day, 2, fecha_contrato)) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, fecha_contrato)) ) IN(5) THEN CAST( DATEADD(day, 1, DATEADD(day, 2, fecha_contrato)) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, fecha_contrato)) ) IN(6) THEN CAST( DATEADD(day, 1, DATEADD(day, 2,  fecha_contrato)) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, fecha_contrato)) ) IN(7) THEN CAST( DATEADD(day, 1, DATEADD(day, 2, fecha_contrato)) AS DATE)
                    END) AS valor_tres_sem

                    FROM [contratos] WHERE id_cliente = ".$cliente."");
				break;

			default:
				# code...
				break;
		}
	}
	function getStatusFRomCliente($id_cliente)
	{
		return $this->db->query("SELECT estatus FROM [agenda] 
		where estatus IN (2,3,4) AND id_cliente = ".$id_cliente)->row();
	}

	function getDatosClienteCita($cliente){
		return $this->db->query("SELECT MAX(fecha_cita) fecha_cita FROM [agenda] 
		where estatus IN (2,3,4) AND id_cliente = ".$cliente)->row();
	}

	function getDatosClienteAge($fecha, $cliente){
		return $this->db->query("SELECT id_agenda FROM [agenda] where fecha_cita = '".$fecha."' AND id_cliente = ".$cliente)->row();
	}

	function getIdCitaByClient($cliente)
	{
		return $this->db->query("SELECT id_agenda FROM [agenda] where id_cliente = ".$cliente)->row();
	}



	function get_clientes_fechas($dia, $cliente){
		$queryAgenda = '';
		$queryinformacion = $this->Agenda_model->getDatosClienteCita($cliente);

		if($queryinformacion->fecha_cita=='') {
			$queryAgenda = $this->Agenda_model->getIdCitaByClient( $cliente);
		}
		else{
			$queryAgenda = $this->Agenda_model->getDatosClienteAge($queryinformacion->fecha_cita, $cliente);
		}


		$data_estatus = $this->Agenda_model->getStatusFRomCliente($cliente);
		// var_dump($queryinformacion);
		// echo "no aplica";


		if($queryinformacion){
			switch ($dia) {
				case '2':
					return $this->db->query("
                 SELECT (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END) as ultima_cita,  DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END)) AS NuevaUno,
                    (CASE
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(1) THEN CAST( DATEADD(day, 0, DATEADD(day, 4, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(2) THEN CAST( DATEADD(day, 0, DATEADD(day, 4, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(3) THEN CAST( DATEADD(day, 0, DATEADD(day, 4, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(4) THEN CAST( DATEADD(day, 0, DATEADD(day, 4, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(5) THEN CAST( DATEADD(day, 0, DATEADD(day, 4, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(6) THEN CAST( DATEADD(day, 0, DATEADD(day, 4, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(7) THEN CAST( DATEADD(day, 0, DATEADD(day, 4, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    END) AS valor_sabado,

                    (CASE
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(1) THEN CAST( DATEADD(day, 0, DATEADD(day, 5, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(2) THEN CAST( DATEADD(day, 0, DATEADD(day, 5, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(3) THEN CAST( DATEADD(day, 0, DATEADD(day, 5, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(4) THEN CAST( DATEADD(day, 0, DATEADD(day, 5, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(5) THEN CAST( DATEADD(day, 0, DATEADD(day, 5, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(6) THEN CAST( DATEADD(day, 0, DATEADD(day, 5, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(7) THEN CAST( DATEADD(day, 0, DATEADD(day, 5, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    END) AS valor_domingo
                    FROM [agenda] WHERE id_cliente = ".$cliente." AND estatus in (1,2,3,4) AND id_agenda = ".$queryAgenda->id_agenda."
                     ");
					// return $result_array =
					break;
				case '1':
					return $this->db->query("
                     SELECT id_cliente,fecha_cita as ultima_cita, 
                      (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END ) as fecha_cita,
                      DATEADD(day, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END)) AS NuevaUno,
                    (CASE
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(1) THEN CAST( DATEADD(day, 0, DATEADD(day, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(2) THEN CAST( DATEADD(day, 0, DATEADD(day, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(3) THEN CAST( DATEADD(day, 0, DATEADD(day, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(4) THEN CAST( DATEADD(day, -0, DATEADD(day,1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(5) THEN CAST( DATEADD(day, 0, DATEADD(day, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(6) THEN CAST( DATEADD(day, 0, DATEADD(day, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(7) THEN CAST( DATEADD(day, 0, DATEADD(day, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    END) AS valor_uno_sem,

                    (CASE
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(1) THEN CAST( DATEADD(day, 1, DATEADD(day, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(2) THEN CAST( DATEADD(day, 1, DATEADD(day, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(3) THEN CAST( DATEADD(day, 1, DATEADD(day, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(4) THEN CAST( DATEADD(day, 1, DATEADD(day, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(5) THEN CAST( DATEADD(day, 1, DATEADD(day, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(6) THEN CAST( DATEADD(day, 1, DATEADD(day, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(7) THEN CAST( DATEADD(day, 1, DATEADD(day, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    END) AS valor_dos_sem,

                    (CASE
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(1) THEN CAST( DATEADD(day, 2, DATEADD(day, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(2) THEN CAST( DATEADD(day, 2, DATEADD(day, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(3) THEN CAST( DATEADD(day, 2, DATEADD(day, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(4) THEN CAST( DATEADD(day, 2, DATEADD(day, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(5) THEN CAST( DATEADD(day, 2, DATEADD(day, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE) 
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(6) THEN CAST( DATEADD(day, 2, DATEADD(day, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    WHEN (select DATEPART(WEEKDAY, DATEADD(month, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) ) IN(7) THEN CAST( DATEADD(day, 2, DATEADD(day, 1, (CASE WHEN estatus = 3 THEN GETDATE() ELSE fecha_cita END))) AS DATE)
                    END) AS valor_tres_sem

                    FROM [agenda] WHERE id_cliente = ".$cliente." AND estatus in (1,2,3,4) AND id_agenda = ".$queryAgenda->id_agenda."

                       ");
					break;

				default:
					# code...
					break;
			}

		}else{
			return '';
		}



	}


	function get_clientes_fechas_moldeo($dia, $cliente){

		switch ($dia) {
			case '2':
				return $this->db->query("SELECT fecha_cita as ultima_cita, DATEADD(week, 1, fecha_cita) AS NuevaUno,
  (CASE
    WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(1) THEN CAST( DATEADD(day, -1, DATEADD(week, 1, fecha_cita)) AS DATE)
    WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(2) THEN CAST( DATEADD(day, 5, DATEADD(week, 1, fecha_cita)) AS DATE)
    WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(3) THEN CAST( DATEADD(day, 4, DATEADD(week, 1, fecha_cita)) AS DATE)
    WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(4) THEN CAST( DATEADD(day, 3, DATEADD(week, 1, fecha_cita)) AS DATE)
    WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(5) THEN CAST( DATEADD(day, 2, DATEADD(week, 1, fecha_cita)) AS DATE)
    WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(6) THEN CAST( DATEADD(day, 1, DATEADD(week, 1, fecha_cita)) AS DATE)
    WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(7) THEN CAST( DATEADD(day, 0, DATEADD(week, 1, fecha_cita)) AS DATE)
END) AS valor_sabado,

  (CASE
    WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(1) THEN CAST( DATEADD(day, 0, DATEADD(week, 1, fecha_cita)) AS DATE)
    WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(2) THEN CAST( DATEADD(day, 6, DATEADD(week, 1, fecha_cita)) AS DATE)
    WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(3) THEN CAST( DATEADD(day, 5, DATEADD(week, 1, fecha_cita)) AS DATE)
    WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(4) THEN CAST( DATEADD(day, 4, DATEADD(week, 1, fecha_cita)) AS DATE)
    WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(5) THEN CAST( DATEADD(day, 3, DATEADD(week, 1, fecha_cita)) AS DATE)
    WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(6) THEN CAST( DATEADD(day, 2, DATEADD(week, 1, fecha_cita)) AS DATE)
    WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(7) THEN CAST( DATEADD(day, 1, DATEADD(week, 1, fecha_cita)) AS DATE)
END) AS valor_domingo

  FROM [agenda] WHERE id_cliente = ".$cliente." AND estatus = 2");
				break;

			case '1':
				return $this->db->query("SELECT id_cliente, fecha_cita as ultima_cita, DATEADD(week, 1, fecha_cita) AS NuevaUno,
  (CASE
     WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(1) THEN CAST( DATEADD(day, 1, DATEADD(week, 1, fecha_cita)) AS DATE) 
     WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(2) THEN CAST( DATEADD(day, 2, DATEADD(week, 1, fecha_cita)) AS DATE) 
     WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(3) THEN CAST( DATEADD(day, 3, DATEADD(week, 1, fecha_cita)) AS DATE)
     WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(4) THEN CAST( DATEADD(day, -1, DATEADD(week, 1, fecha_cita)) AS DATE) 
     WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(5) THEN CAST( DATEADD(day, 0, DATEADD(week, 1, fecha_cita)) AS DATE) 
     WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(6) THEN CAST( DATEADD(day, 3, DATEADD(week, 1, fecha_cita)) AS DATE)
     WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(7) THEN CAST( DATEADD(day, 3, DATEADD(week, 1, fecha_cita)) AS DATE)
END) AS valor_uno_sem,

  (CASE
     WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(1) THEN CAST( DATEADD(day, 2, DATEADD(week, 1, fecha_cita)) AS DATE) 
     WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(2) THEN CAST( DATEADD(day, 3, DATEADD(week, 1, fecha_cita)) AS DATE) 
     WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(3) THEN CAST( DATEADD(day, 6, DATEADD(week, 1, fecha_cita)) AS DATE)
     WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(4) THEN CAST( DATEADD(day, 0, DATEADD(week, 1, fecha_cita)) AS DATE) 
     WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(5) THEN CAST( DATEADD(day, 1, DATEADD(week, 1, fecha_cita)) AS DATE) 
     WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(6) THEN CAST( DATEADD(day, 4, DATEADD(week, 1, fecha_cita)) AS DATE)
     WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(7) THEN CAST( DATEADD(day, 4, DATEADD(week, 1, fecha_cita)) AS DATE)
END) AS valor_dos_sem,

(CASE
    WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(1) THEN CAST( DATEADD(day, 3, DATEADD(week, 1, fecha_cita)) AS DATE) 
    WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(2) THEN CAST( DATEADD(day, 4, DATEADD(week, 1, fecha_cita)) AS DATE) 
    WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(3) THEN CAST( DATEADD(day, 7, DATEADD(week, 1, fecha_cita)) AS DATE)
    WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(4) THEN CAST( DATEADD(day, 1, DATEADD(week, 1, fecha_cita)) AS DATE) 
    WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(5) THEN CAST( DATEADD(day, 4, DATEADD(week, 1, fecha_cita)) AS DATE) 
    WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(6) THEN CAST( DATEADD(day, 5, DATEADD(week, 1, fecha_cita)) AS DATE)
    WHEN (select DATEPART(WEEKDAY, DATEADD(week, 1, fecha_cita)) ) IN(7) THEN CAST( DATEADD(day, 5, DATEADD(week, 1, fecha_cita)) AS DATE)
END) AS valor_tres_sem

  FROM [agenda] WHERE id_cliente = ".$cliente." AND estatus = 2");
				break;

			default:
				# code...
				break;
		}
  }
  
  public function verificar_fecha($date, $date2, $servicio, $hora){
    if($servicio == 3){
      return $this->db->query("SELECT a.id_agenda,a.fecha_cita,a.hora_inicio, a.hora_fin, a.servicio, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) as nombre  FROM agenda a 
      INNER JOIN clientes cl ON cl.id_cliente=a.id_cliente WHERE (CAST(a.fecha_cita as DATE) = '$date') AND ('$hora'  BETWEEN a.hora_inicio AND a.hora_fin) AND (a.servicio IN ($servicio,1,2)) AND a.estatus = 1");
  
    }else{
      return $this->db->query("SELECT a.id_agenda,a.fecha_cita, a.hora_inicio, a.hora_fin, a.servicio, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) as nombre FROM agenda a 
      INNER JOIN clientes cl ON cl.id_cliente=a.id_cliente WHERE (CAST(a.fecha_cita as DATE) = '$date') AND ('$hora'  BETWEEN a.hora_inicio AND a.hora_fin) AND (a.servicio = $servicio OR a.servicio = 3) AND a.estatus = 1");
    }
  } 

  public function citas_del_dia($date, $date2, $servicio, $hora){
    if($servicio == 3){
      return $this->db->query("SELECT a.id_agenda,a.fecha_cita,a.hora_inicio, a.hora_fin, a.servicio, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) as nombre  FROM agenda a 
      INNER JOIN clientes cl ON cl.id_cliente=a.id_cliente WHERE (CAST(a.fecha_cita as DATE) = '$date') AND (a.servicio IN ($servicio,1,2)) AND a.estatus = 1");
  
    }else{
      return $this->db->query("SELECT a.id_agenda,a.fecha_cita,a.hora_inicio, a.hora_fin, a.servicio, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) as nombre FROM agenda a 
       INNER JOIN clientes cl ON cl.id_cliente=a.id_cliente WHERE (CAST(a.fecha_cita as DATE) = '$date') AND (a.servicio = $servicio OR a.servicio = 3) AND a.estatus = 1");
    }
  }
  
  public function get_existencia_agenda($id_agenda, $id_area){    
    return $this->db->query("SELECT ar.duracion, ar.tipo, ar.id_area, ar.nombre
    FROM agenda ag
    INNER JOIN areas_x_cita axc ON axc.d_agenda = ag.id_agenda
    INNER JOIN areas ar ON ar.id_area = axc.id_area
    WHERE ag.id_agenda = $id_agenda AND axc.id_area = $id_area");
  }

  public function update_cita($fecha, $user,$hora, $duracion, $areasArray, $service, $idAgenda){
    $this->db->query("DELETE FROM areas_x_cita WHERE d_agenda = '$idAgenda' AND id_area NOT IN ($areasArray)");
		$areasArray2 = explode(',',$areasArray);
    for($x = 0;$x<count($areasArray2);$x++){
      $check = $this->db->query("SELECT id_ac FROM areas_x_cita WHERE id_area = '$areasArray2[$x]' AND d_agenda = '$idAgenda'");
      $check = $check->result_array();
      if(count($check)<=0){
        $insert = $this->db->query("INSERT INTO areas_x_cita VALUES(".$idAgenda.", '".$areasArray2[$x]."', GETDATE(), 1)");
      }
    }
    return $this->db->query("UPDATE agenda SET fecha_cita = '$fecha', fecha_creacion = GETDATE(), creado_por = '$user', hora_inicio= '$hora', hora_fin = DATEADD(minute,$duracion,'$hora'), lista_areas= '$areasArray', servicio = '$service' WHERE id_agenda='$idAgenda'");
  }
}