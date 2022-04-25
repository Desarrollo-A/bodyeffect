<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expedientes_model extends CI_Model {


    function __construct(){
        parent::__construct();
    }

    function get_data_cliente($valor){
        return $this->db->query("SELECT * FROM [clientes] c WHERE id_cliente = ".$valor." ORDER BY c.nombre, c.apellido_paterno, c.apellido_materno ");
     }

     function get_lista_clientes(){
        return $this->db->query("SELECT cxa.id_cliente, STRING_AGG(ar.nombre, ', ') AS valor, COUNT(ar.id_area) 
        as numareas, CONCAT(c.nombre,' ',c.apellido_paterno,' ',c.apellido_materno) AS nombre, c.correo, c.telefono, 
        c.tipo, c.estatus, co.fecha_contrato FROM [areas] AS ar INNER JOIN [clientes_x_areas] AS cxa ON cxa.id_area = ar.id_area AND cxa.estatus = 1
        INNER JOIN [clientes] AS c ON c .id_cliente = cxa.id_cliente INNER JOIN [contratos] AS co ON co.id_cliente = c.id_cliente 
        WHERE CONVERT(DATE, co.fecha_contrato) = CONVERT(DATE, GETDATE()) AND co.estatus = 1
        GROUP BY cxa.id_cliente, c.nombre, c.apellido_paterno, c.apellido_materno, c.correo, c.telefono, c.tipo, c.estatus, co.fecha_contrato
        ORDER BY c.nombre, c.apellido_paterno, c.apellido_materno ");
     }

    function get_valoracion_cliente($valor){
        $this->db->query("SET LANGUAGE Spanish");
        return $this->db->query("SELECT cl.fotoTipo, ag.id_cliente, ag.id_agenda, ag.fecha_cita, CONCAT(cl.nombre,' ' ,cl.apellido_paterno,' ' ,cl.apellido_materno) name_cliente, ag.* 
        FROM [agenda] ag 
        INNER JOIN clientes cl ON cl.id_cliente = ag.id_cliente
        WHERE ag.id_cliente = '$valor' AND ag.estatus = 1 AND fecha_cita <= GETDATE(); ");
    }
    function get_areas_cliente($id_cliente){

		return $this->db->query("SELECT a.duracion, a.id_area, a.nombre, a.tipo, pq.id_contrato,CONCAT(c.nombre,' ',c.apellido_paterno,' ',c.apellido_materno) AS nombrecl, c.fotoTipo
		FROM clientes_x_areas  cxa
		INNER JOIN areas  a ON a.id_area=cxa.id_area AND a.tipo NOT IN (4)
		INNER JOIN paquetes  pq ON pq.id_paquete=cxa.id_paquete
        INNER JOIN clientes c ON c.id_cliente=cxa.id_cliente
        INNER JOIN contratos cn ON cn.id_cliente = c.id_cliente AND cn.estatus != 5
		WHERE cxa.id_cliente = $id_cliente AND cxa.estatus = 1");
	}
     function ver_lista_areas($valor){
        $this->db->query("SET LANGUAGE Spanish");
        $query_result = $this->db->query("SELECT lista_areas FROM [agenda] WHERE id_agenda = ".$valor."");
        $var_areas = strval($query_result->row()->lista_areas);
        return $this->db->query("SELECT id_area, nombre, tipo FROM areas WHERE id_area IN (".$var_areas.")");
    }

    function lista_areas_historial($valor){
        return $this->db->query("SELECT  ec.id_cliente, ec.id_area, ar.nombre,  CONCAT(c.nombre,' ' ,c.apellido_paterno,' ' ,c.apellido_materno) name_cliente, ar.tipo, c.fotoTipo
		FROM expediente_clinico ec
		INNER JOIN areas ar ON ar.id_area = ec.id_area
        INNER JOIN clientes c ON c.id_cliente = ec.id_cliente
        WHERE ec.id_cliente = '$valor' GROUP BY  ec.id_cliente, ec.id_area, ar.nombre, ar.tipo, c.nombre, c.apellido_materno, c.apellido_paterno, ar.tipo, c.fotoTipo  ORDER BY ar.tipo;");
    }

    function historial_expediente($cliente, $area){
        return $this->db->query("SELECT ROW_NUMBER() OVER(PARTITION BY ec.id_area ORDER BY ec.id_area DESC) AS row, 
        ec.id_clinico, CONVERT(char(10), ec.fecha_sesion, 111) fecha_sesion, ec.id_area, ec.potencia, ec.frecuencia, ec.bello_restante, ec.id_enfermera, 
        ec.observaciones, ec.fecha_creacion, ec.creado_por, ec.id_cliente, ec.id_agenda, ec.id_contrato, ec.tempIni, ec.rfIni, ec.rfFin, ec.tempFin,
        ec.duracion, ar.nombre, ar.tipo, u.nombre as name FROM expediente_clinico ec 
        INNER JOIN areas ar ON ar.id_area = ec.id_area
        INNER JOIN usuarios u ON u.id_usuario = ec.id_enfermera
        WHERE ec.id_cliente = $cliente AND ec.id_area = $area");
     }

     function historial_expediente_todo($cliente){
        return $this->db->query("SELECT ROW_NUMBER() OVER(PARTITION BY ec.id_area ORDER BY ec.fecha_sesion ASC) AS row, ec.id_clinico, CONVERT(char(10), ec.fecha_sesion, 111) fecha_sesion, ec.id_area, ec.potencia, ec.frecuencia, ec.bello_restante, ec.id_enfermera, 
        ec.observaciones, ec.fecha_creacion, ec.creado_por, ec.id_cliente, ec.id_agenda, ec.id_contrato, ec.tempIni, ec.rfIni, ec.rfFin, ec.tempFin,
        ec.duracion, ar.nombre, ar.tipo, u.nombre as name 
		FROM expediente_clinico ec 
        INNER JOIN areas ar ON ar.id_area = ec.id_area
        INNER JOIN usuarios u ON u.id_usuario = ec.id_enfermera
        WHERE ec.id_cliente = $cliente ORDER BY fecha_sesion ASC");
     }
 
     function get_expediente_u($id_expediente){
		return $this->db->query("SELECT ex.*, ar.nombre, ar.tipo
        FROM  expediente_clinico ex
        INNER JOIN areas ar ON ar.id_area = ex.id_area
        WHERE id_clinico = $id_expediente");
	}

    function get_clientes_servicio(){
        return $this->db->query("SELECT cl.id_cliente, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombre, cl.correo, cl.telefono,
        STRING_AGG((CASE ar.tipo WHEN 1 THEN CONCAT(ar.nombre, ' (depilación)') WHEN 2 THEN CONCAT(ar.nombre, ' (moldeo)') WHEN 4 THEN CONCAT(ar.nombre, ' (facial)') END), ', ') AS valor
        FROM clientes cl
        INNER JOIN paquetes paq ON paq.id_cliente = cl.id_cliente
        INNER JOIN clientes_x_areas cxa ON cxa.id_paquete = paq.id_paquete AND cxa.estatus = 1
        INNER JOIN areas ar ON ar.id_area = cxa.id_area GROUP BY cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, cl.correo, cl.telefono");
     }
     function get_enfermeras(){
        return $this->db->query("SELECT * FROM usuarios WHERE id_rol = 3");
    }

    function get_areas_cliente_2($id_cliente, $id_contrato){

        return $this->db->query("SELECT a.duracion, a.id_area, a.nombre, a.tipo, pq.id_contrato,CONCAT(c.nombre,' ',c.apellido_paterno,' ',c.apellido_materno) AS nombrecl, c.fotoTipo
        FROM contratos cn
        INNER JOIN paquetes  pq ON pq.id_contrato = cn.id_contrato
        INNER JOIN clientes c ON c.id_cliente = pq.id_cliente
        INNER JOIN (SELECT duracion, id_area, nombre, tipo, '$id_cliente' id_cliente FROM areas WHERE id_area IN (9, 22)) AS a ON a.id_cliente = c.id_cliente
        WHERE cn.id_contrato = $id_contrato AND cn.estatus != 5");
    }
    
    function update_registro_exp_m($tempIni, $rfIni, $rfFin, $tempFin, $dur_area, $observaciones, $id_sesion, $fecha_cita, $responsable, $id_expediente){
        
        $query = $this->db->query("UPDATE expediente_clinico SET tempIni = $tempIni, rfIni = '$rfIni', rfFin = '$rfFin', tempFin = $tempFin, duracion = $dur_area, fecha_modificacion = GETDATE(), modificado_por = $id_sesion, observaciones = '$observaciones', id_enfermera = $responsable, fecha_sesion = '$fecha_cita' WHERE id_clinico = $id_expediente");
        
        return $query;
    }

    function update_registro_exp_d($potencia, $frecuencia, $bellorestante, $dur_area, $observaciones, $id_sesion, $fecha_cita, $responsable, $id_expediente){

        $query = $this->db->query("UPDATE expediente_clinico SET potencia = $potencia, frecuencia = '$frecuencia', bello_restante = $bellorestante, duracion = $dur_area, fecha_modificacion = GETDATE(), modificado_por = $id_sesion, observaciones = '$observaciones', id_enfermera = $responsable, fecha_sesion = '$fecha_cita' WHERE id_clinico = $id_expediente");
        
        return $query;
    }

    function get_areas_cliente_two($id_cliente){

        return $this->db->query("SELECT a.duracion, a.id_area, a.nombre, a.tipo, pq.id_contrato,CONCAT(c.nombre,' ',c.apellido_paterno,' ',c.apellido_materno) AS nombrecl, c.fotoTipo
        FROM clientes_x_areas  cxa
        INNER JOIN areas  a ON a.id_area=cxa.id_area AND a.tipo NOT IN (4)
        INNER JOIN paquetes  pq ON pq.id_paquete=cxa.id_paquete
        INNER JOIN clientes c ON c.id_cliente=cxa.id_cliente
        INNER JOIN clientes_contrato cn ON cn.id_cliente = c.id_cliente AND cn.estatus != 5
        WHERE cxa.id_cliente = $id_cliente AND cxa.estatus = 1");
    }

}
