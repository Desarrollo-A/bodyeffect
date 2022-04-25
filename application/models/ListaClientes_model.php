<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ListaClientes_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }

    function get_data_cliente($id_contrato){
        $this->db->query("SET LANGUAGE Spanish");
       
        return $this->db->query("SELECT cl.id_cliente, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) AS nombrecompleto, co.id_contrato,
		STRING_AGG(ar.nombre, ', ') AS valor, COUNT(ar.id_area) as numareas, cl.correo, cl.telefono, cl.tipo, cl.estatus, co.fecha_contrato ,
		cob.cantidad, cob.enganche, cob.parcialidades, cob.mensualidad, cl.fecha_creacion, UPPER(oxc.nombre) AS forma_pago, co.servicio
		FROM contratos co
		INNER JOIN clientes cl ON co.id_cliente=cl.id_cliente
		LEFT JOIN [paquetes] AS pq ON pq.id_contrato = co.id_contrato
		LEFT JOIN [clientes_x_areas] AS cxa ON cxa.id_paquete = pq.id_paquete AND cxa.estatus = 1
		LEFT JOIN [areas] AS ar ON ar.id_area=cxa.id_area
		LEFT JOIN [cobros] AS cob ON co.id_contrato = cob.id_contrato
		INNER JOIN [opciones_catalogo] oxc ON cob.forma_pago = oxc.id_opcion
		WHERE cl.estatus in (1,2,3) AND cob.id_contrato= ".$id_contrato." AND  oxc.id_catalogo = 9
		GROUP BY cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, co.id_contrato, cl.correo, cl.telefono, cl.tipo, cl.estatus, co.fecha_contrato,
		cob.cantidad, cob.enganche, cob.parcialidades, cob.mensualidad,  cl.fecha_creacion, oxc.nombre, co.servicio");
	}
	
    function getDetallePaqueteByClient($id_cliente, $id_contrato){
	 	return $this->db->query("SELECT CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) AS nombre, co.id_contrato, STRING_AGG((CASE ar.tipo WHEN 1 THEN CONCAT(ar.nombre, ' (depilación)') WHEN 2 THEN CONCAT(ar.nombre, ' (moldeo)') WHEN 4 THEN CONCAT(ar.nombre, ' (facial)') END), ', ') AS valor, 
		 COUNT(ar.id_area) as numareas, cl.correo, cl.telefono, cl.tipo, cl.estatus, co.fecha_contrato
		 FROM contratos co
		 INNER JOIN clientes cl ON cl.id_cliente = co.id_cliente
		 INNER JOIN paquetes pa ON pa.id_contrato = co.id_contrato
		 INNER JOIN clientes_x_areas cxa ON cxa.id_paquete = pa.id_paquete AND cxa.estatus = 1
		 INNER JOIN areas ar ON ar.id_area = cxa.id_area
		 WHERE co.id_contrato = $id_contrato and pa.id_cliente = $id_cliente
		 GROUP BY cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, co.id_contrato, cl.correo, cl.telefono, cl.tipo, cl.estatus, co.fecha_contrato");
	}

	function getPaquetesAdByContrato($id_contrato){
		return $this->db->query("SELECT * FROM clientes_contrato cl 
		INNER JOIN paquetes pq ON pq.id_cliente = cl.id_cliente
		WHERE cl.id_contrato = $id_contrato");
	}

	 function getClientNoTitular($id_cliente, $id_contrato, $id_paquete){
	 	return $this->db->query("SELECT cl.id_cliente, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) AS nombre, co.id_contrato, STRING_AGG((CASE ar.tipo WHEN 1 THEN CONCAT(ar.nombre, ' (depilación)') WHEN 2 THEN CONCAT(ar.nombre, ' (moldeo)') WHEN 4 THEN CONCAT(ar.nombre, ' (facial)') END), ', ') AS valor, COUNT(ar.id_area) as numareas, cl.correo, cl.telefono, cl.tipo, cl.estatus
		FROM clientes_contrato co
		INNER JOIN clientes cl ON co.id_cliente=cl.id_cliente
		LEFT JOIN [paquetes] AS pq ON pq.id_contrato = co.id_contrato
		LEFT JOIN [clientes_x_areas] AS cxa ON cxa.id_paquete = pq.id_paquete AND cxa.estatus = 1
		LEFT JOIN [areas] AS ar ON ar.id_area=cxa.id_area
		WHERE cl.estatus in (1,2,3) AND cl.id_cliente= $id_cliente AND co.id_contrato= $id_contrato AND pq.id_paquete = $id_paquete
		GROUP BY cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, co.id_contrato, cl.correo, cl.telefono, cl.tipo, cl.estatus");
	 }

	public function get_cliente_adicional($id_paquete){
		return $this->db->query("SELECT * FROM paquetes pa INNER JOIN clientes_contrato clc ON clc.id_cliente = pa.id_cliente
		WHERE pa.id_paquete = $id_paquete");
	}
	
    function get_valoracion_cliente($valor){
        $this->db->query("SET LANGUAGE Spanish");
        return $this->db->query("SELECT CAST(CASE WHEN fecha_cita = CONVERT (date, GETDATE()) THEN 1 ELSE 0 END AS bit) as fecha_encontrada, CONCAT(DATENAME(weekday, fecha_cita),' ', DATENAME(day, fecha_cita),' de ', DATENAME(month, fecha_cita),' del ',DATENAME(year, fecha_cita)) as fecha_letra, * FROM [agenda] WHERE id_cliente = ".$valor." AND estatus = 1 ");
    }

    function get_seleccion_areas($cliente){
        return $this->db->query("SELECT CAST(CASE WHEN fecha_cita = CONVERT (date, GETDATE()) THEN 1 ELSE 0 END AS bit) as fecha_encontrada, CONCAT(DATENAME(weekday, fecha_cita),' ', DATENAME(day, fecha_cita),' de ', DATENAME(month, fecha_cita),' del ',DATENAME(year, fecha_cita)) as fecha_letra, * FROM [agenda] WHERE id_cliente = ".$valor." AND estatus = 1");
    }

	function get_clientes_activos($beginDate, $endDate){
        return $this->db->query("SELECT cl.id_cliente, CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) AS nombre, co.id_contrato, STRING_AGG(ar.nombre, ', ') AS valor, COUNT(ar.id_area) as numareas, cl.correo, cl.telefono, cl.tipo, cl.estatus as estatus_cl, co.fecha_contrato, expd.ife, expd.contrato, expd.carta, expd.tarjeta, expd.recibo, co.servicio, isNULL(co.observaciones, 'No tiene comentarios') as observaciones, co.estatus
		FROM contratos co
		INNER JOIN clientes cl ON co.id_cliente=cl.id_cliente AND cl.fecha_creacion BETWEEN '$beginDate 00:00:00' AND '$endDate 23:59:59'
		LEFT JOIN [paquetes] AS pq ON pq.id_contrato = co.id_contrato
		LEFT JOIN [clientes_x_areas] AS cxa ON cxa.id_paquete = pq.id_paquete AND cxa.estatus = 1
		LEFT JOIN [areas] AS ar ON ar.id_area=cxa.id_area
		LEFT JOIN [expediente] AS expd ON expd.id_contrato=co.id_contrato
		WHERE cl.estatus in (1,2,3) AND co.estatus NOT IN (0) GROUP BY cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, co.id_contrato, cl.correo, cl.telefono, cl.tipo, cl.estatus, co.fecha_contrato,expd.ife, expd.contrato, expd.carta, expd.tarjeta, expd.recibo, co.servicio, co.observaciones, co.estatus;");
    }

     function get_clientes(){
		$query = $this->db-> query("SELECT c.id_cliente, CONCAT(c.nombre,' ', c.apellido_paterno, ' ', c.apellido_materno) as nombre, c.correo, c.telefono FROM clientes c WHERE c.estatus in (1,2,3) AND titular=1");
		return $query->result();
	}

	function get_contratosbyClient($id_cliente){
		$query = $this->db-> query("SELECT id_contrato, fecha_contrato, estatus
			FROM contratos WHERE estatus=1 AND id_cliente=".$id_cliente);
		return $query->result();
	}

	function get_areasByClient($id_cliente, $id_contrato){
		$query = $this->db->query("SELECT STRING_AGG(ar.nombre, ', ') AS areas
		 FROM [areas] AS ar 
		INNER JOIN [clientes_x_areas] AS cxa ON cxa.id_area = ar.id_area AND cxa.estatus = 1
		INNER JOIN paquetes pq ON pq.id_paquete=cxa.id_paquete 
		INNER JOIN contratos con ON con.id_contrato=pq.id_contrato
		WHERE  pq.id_contrato=$id_contrato");
		return $query->result();
	}

	function get_expediente_by_client($id_cliente, $id_contrato)
	{
		$query = $this->db->query("SELECT * FROM expediente WHERE id_cliente=".$id_cliente." AND id_contrato=".$id_contrato);
		return $query->result_array();
	}

	function update_expediente($id_expediente, $data_update)
	{
		$this->db->where("id_expediente",$id_expediente);
		$this->db->update('expediente',$data_update);
		return $this->db->affected_rows();
	}
	function new_expediente($data_update)
	{
		$this->db->insert('expediente',$data_update);
		return $this->db->affected_rows();
	}

	/*xd*/
	function getCobroByContrato($id_contrato)
	{
		$query = $this->db->query("SELECT * FROM cobros WHERE id_contrato=".$id_contrato);
		return $query->result_array();
	}

	function getPaqByContrato($id_contrato)
	{
		$query = $this->db->query("SELECT * FROM paquetes WHERE id_contrato=".$id_contrato);
		return $query->result_array();
	}

	function getQuincenaByCobCon($id_cobro, $id_contrato)
	{
		$query = $this->db->query("SELECT * FROM quincenas WHERE id_cobro=".$id_cobro." AND id_contrato=".$id_contrato);
		return $query->result_array();
	}
	function getclsxareasByClPaq($id_cliente, $id_paquete)
	{
		$query = $this->db->query("SELECT * FROM clientes_x_areas  WHERE id_cliente = $id_cliente AND id_paquete = $id_paquete AND estatus = 1");
		return $query->result_array();
	}

	function updateTableGen($table, $id, $data_update)
	{
		$this->db->where($id);
		$this->db->update($table, $data_update);
		return $this->db->affected_rows();
	}

	function observations($data, $id_contrato)
	{
		$response = $this->db->update("contratos", $data, "id_contrato = $id_contrato");
		if (!$response) {
			return $finalAnswer = 0;
		} else {
			return $finalAnswer = 1;
		}
	}


}
