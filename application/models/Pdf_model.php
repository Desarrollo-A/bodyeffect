<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pdf_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }

    function get_datos_para_certificado($id_cliente){
    	$this->db->query("SET LANGUAGE Spanish");
        return $this->db->query("SELECT CONCAT(DATENAME(weekday, GETDATE()),' ',DATENAME(day, GETDATE()),' de ',DATENAME(month, GETDATE()),' del ', DATENAME(year, GETDATE())) 
        as fecha_letra, (CONVERT(CHAR(5), GETDATE(), 108)+ CASE WHEN DATEPART(HH, GETDATE()) > 12 THEN ' P.M.' ELSE ' A.M.' END) as hora_letra, 
        c.id_cliente, STRING_AGG(ar.nombre, ', ') AS valor, CONCAT(c.nombre,' ',c.apellido_paterno,' ',c.apellido_materno) AS nombre FROM [areas] AS ar 
        INNER JOIN [clientes_x_areas] AS cxa ON cxa.id_area = ar.id_area AND cxa.estatus = 1 INNER JOIN [clientes] AS c ON c .id_cliente = cxa.id_cliente WHERE c.id_cliente = '".$id_cliente."' 
        GROUP BY c.apellido_paterno, c.apellido_materno, c.id_cliente, c.nombre ");
    }
    
    function get_clients($id_contrato, $type){
        if($type == 1) { // CONTRATO POR VENTA NUEVA
            $query = $this->db->query("SELECT * FROM (SELECT cc.id_cliente, STRING_AGG(ar.nombre + ' (' + CONVERT(VARCHAR(250), (CASE WHEN ar.tipo IN (1,2) THEN CAST(CONCAT(ar.no_sesion, ' sesiones') AS TEXT) 
            WHEN ar.tipo = 4 THEN (CASE WHEN ar.id_area = 75 THEN CAST(
            CONCAT(la.nombre, ' - ', axl.sesiones, (CASE WHEN axl.sesiones <= 1 THEN ' sesión' ELSE ' sesiones' END), (CASE WHEN ar.venus = 1 THEN (CONCAT(' - ', ar.desc_paquete)) ELSE '' END) ) AS TEXT) 
            ELSE (CASE WHEN ar.piezas_edit <= 1 THEN CAST(CONCAT(cxa.num_sesion, (CASE WHEN cxa.num_sesion <= 1 THEN ' sesión' ELSE ' sesiones' END), (CASE WHEN ar.venus = 1 THEN (CONCAT(' - ', ar.desc_paquete)) ELSE '' END) ) AS TEXT) ELSE CAST(CONCAT(cxa.unidades, 
            (CASE WHEN cxa.unidades <= 1 THEN ' unidad' ELSE ' unidades' END), (CASE WHEN ar.venus = 1 THEN (CONCAT(' - ', ar.desc_paquete)) ELSE '' END) ) AS TEXT) END) END)
            END)) + ')', ', ')
            AS areas, CONCAT(ct.nombre, '_', ct.apellido_paterno, '_', ct.apellido_materno) AS nombre, ct.titular FROM [contratos] cn
            LEFT JOIN [clientes_contrato] cc ON cn.id_contrato = cc.id_contrato
            LEFT JOIN [clientes_x_areas] cxa ON cc.id_cliente = cxa.id_cliente AND cxa.estatus = 1
            LEFT JOIN [areas] ar ON cxa.id_area = ar.id_area
            INNER JOIN [clientes] ct ON cxa.id_cliente = ct.id_cliente
            LEFT JOIN [paquetes] pq ON pq.id_paquete = cxa.id_paquete
            LEFT JOIN [contratos] con ON con.id_contrato = pq.id_paquete
            LEFT JOIN [areas_x_lipoenzimas] axl ON axl.id_paquete = pq.id_paquete AND axl.estatus = 1
            LEFT JOIN [lipoenzimas_areas] la ON la.id_area = axl.id_area
            WHERE cn.id_contrato = $id_contrato GROUP BY cc.id_cliente, ct.nombre, ct.apellido_paterno, ct.apellido_materno, ct.titular) t1
            UNION (SELECT c.id_cliente, STRING_AGG(ar.nombre + ' (' + CONVERT(VARCHAR(250), (CASE WHEN ar.tipo IN (1,2) THEN CAST(CONCAT(ar.no_sesion, ' sesiones') AS TEXT) 
            WHEN ar.tipo = 4 THEN (CASE WHEN ar.id_area = 75 THEN CAST(
            CONCAT(la.nombre, ' - ', axl.sesiones, (CASE WHEN axl.sesiones <= 1 THEN ' sesión' ELSE ' sesiones' END), (CASE WHEN ar.venus = 1 THEN (CONCAT(' - ', ar.desc_paquete)) ELSE '' END) ) AS TEXT) 
            ELSE (CASE WHEN ar.piezas_edit <= 1 THEN CAST(CONCAT(cxa.num_sesion, (CASE WHEN cxa.num_sesion <= 1 THEN ' sesión' ELSE ' sesiones' END), (CASE WHEN ar.venus = 1 THEN (CONCAT(' - ', ar.desc_paquete)) ELSE '' END) ) AS TEXT) ELSE CAST(CONCAT(cxa.unidades, 
            (CASE WHEN cxa.unidades <= 1 THEN ' unidad' ELSE ' unidades' END), (CASE WHEN ar.venus = 1 THEN (CONCAT(' - ', ar.desc_paquete)) ELSE '' END) ) AS TEXT) END) END)
            END)) + ')', ', ')
            AS areas, CONCAT(ct.nombre, '_', ct.apellido_paterno, '_', ct.apellido_materno) AS nombre, ct.titular
            FROM [clientes] c
            INNER JOIN [clientes_x_areas] cxa ON c.id_cliente = cxa.id_cliente AND cxa.estatus = 1
            LEFT JOIN [areas] ar ON cxa.id_area = ar.id_area
            INNER JOIN [clientes] ct ON cxa.id_cliente = ct.id_cliente
            LEFT JOIN [paquetes] pq ON pq.id_paquete = cxa.id_paquete
            LEFT JOIN [contratos] con ON con.id_contrato = pq.id_paquete
            LEFT JOIN [areas_x_lipoenzimas] axl ON axl.id_paquete = pq.id_paquete AND axl.estatus = 1
            LEFT JOIN [lipoenzimas_areas] la ON la.id_area = axl.id_area
            WHERE pq.id_contrato= $id_contrato GROUP BY c.id_cliente, ct.nombre, ct.apellido_paterno, ct.apellido_materno, ct.titular) ORDER BY titular DESC");
            return $query;
        } else { // CONTRATO POR REVENTA INSTANTÁNEA O REVENTA
            return $this->db->query("SELECT c.id_cliente, STRING_AGG(ar.nombre + ' (' + CONVERT(VARCHAR(250), (CASE WHEN ar.tipo IN (1,2) THEN CAST(CONCAT(ar.no_sesion, ' sesiones') AS TEXT) 
            WHEN ar.tipo = 4 THEN (CASE WHEN ar.id_area = 75 THEN CAST(
            CONCAT(la.nombre, ' - ', axl.sesiones, (CASE WHEN axl.sesiones <= 1 THEN ' sesión' ELSE ' sesiones' END), (CASE WHEN ar.venus = 1 THEN (CONCAT(' - ', ar.desc_paquete)) ELSE '' END) ) AS TEXT) 
            ELSE (CASE WHEN ar.piezas_edit <= 1 THEN CAST(CONCAT(cxa.num_sesion, (CASE WHEN cxa.num_sesion <= 1 THEN ' sesión' ELSE ' sesiones' END), (CASE WHEN ar.venus = 1 THEN (CONCAT(' - ', ar.desc_paquete)) ELSE '' END) ) AS TEXT) ELSE CAST(CONCAT(cxa.unidades, 
            (CASE WHEN cxa.unidades <= 1 THEN ' unidad' ELSE ' unidades' END), (CASE WHEN ar.venus = 1 THEN (CONCAT(' - ', ar.desc_paquete)) ELSE '' END) ) AS TEXT) END) END)
            END)) + ')', ', ')
             AS areas, CONCAT(ct.nombre, '_', ct.apellido_paterno, '_', ct.apellido_materno) AS nombre, ct.titular
            FROM [clientes] c
            INNER JOIN [clientes_x_areas] cxa ON c.id_cliente = cxa.id_cliente AND cxa.estatus = 1
            LEFT JOIN [areas] ar ON cxa.id_area = ar.id_area
            INNER JOIN [clientes] ct ON cxa.id_cliente = ct.id_cliente
            LEFT JOIN [paquetes] pq ON pq.id_paquete = cxa.id_paquete
            LEFT JOIN [contratos] con ON con.id_contrato = pq.id_paquete
            LEFT JOIN [areas_x_lipoenzimas] axl ON axl.id_paquete = pq.id_paquete AND axl.estatus = 1
            LEFT JOIN [lipoenzimas_areas] la ON la.id_area = axl.id_area
            WHERE pq.id_contrato= ".$id_contrato." GROUP BY c.id_cliente, ct.nombre, ct.apellido_paterno, ct.apellido_materno, ct.titular ORDER BY titular DESC");
        }
    }

    function get_datos_tarjeta($id_contrato){
        return $this->db->query("SELECT t.numero_tarjeta, t.mm, t.aa, t.nombre, b.nombre AS banco, oxc.nombre AS compania, t.tipo_tarjeta FROM [tarjetas] t
        INNER JOIN [bancos] b ON b.id_banco = t.id_banco
        INNER JOIN [opciones_catalogo] oxc ON oxc.id_opcion = t.compania
        WHERE id_contrato = ".$id_contrato."  AND oxc.id_catalogo = 11 AND t.tarjeta_primaria = 1");
    }
 
    function get_datos_pago($id_contrato){
        return $this->db->query("SELECT c.concepto, c.cantidad, c.fecha_cobro, c.parcialidades, c.descuento, c.forma_pago, c.mensualidad, c.enganche, UPPER(oxc.nombre) AS forma_pago, c.servicio
        FROM [cobros] c INNER JOIN opciones_catalogo oxc ON c.forma_pago = oxc.id_opcion
        WHERE id_contrato = ".$id_contrato." AND concepto = 'Anticipo' AND oxc.id_catalogo = 9");
    }

    function get_cobros($id_contrato){
        return $this->db->query("SELECT * FROM cobros WHERE id_contrato = ".$id_contrato."");
    }

    function get_contrato($id_contrato){
        return $this->db->query("SELECT * FROM [contratos] WHERE id_contrato = ".$id_contrato." AND estatus IN (1, 3)");
    }

    function get_titular($id_cliente){
        return $this->db->query("SELECT id_cliente, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) nombre, correo, domicilio FROM [clientes] WHERE id_cliente = ".$id_cliente." AND estatus = 1");
    }

    function get_quincenas($id_contrato){
        return $this->db->query("SELECT q.id_contrato, FORMAT(q.importe, 'C') importe, CONVERT(varchar, q.fecha_pago, 103) fecha_pago FROM quincenas q 
        INNER JOIN cobros c ON q.id_cobro = c.id_cobro 
        WHERE c.id_contrato = $id_contrato");
        /*
        SELECT q.id_contrato, COUNT(*) total_quincenas, STRING_AGG('(' + FORMAT(q.importe, 'C') + ' - ' 
                        + RIGHT('0' + CONVERT(VARCHAR, DATEPART(D, q.fecha_pago)),2) + '-' 
                        + RIGHT('0' + CONVERT(VARCHAR, DATEPART(M, q.fecha_pago)),2) + '-' 
                        + CONVERT(VARCHAR(10), DATEPART(YYYY, q.fecha_pago)), '), ') AS fechas, FORMAT(q.importe, 'C') importe FROM 
                        quincenas q INNER JOIN cobros c ON q.id_cobro = c.id_cobro WHERE c.id_contrato = ".$id_contrato." GROUP BY q.id_contrato, q.importe
        */
    }

    function get_first_payment($id_cobro){
        return $this->db->query("SELECT MIN(q.fecha_pago) AS inicial_fecha_pago  FROM cobros c
        INNER JOIN quincenas q ON q.id_cobro = c.id_cobro
        WHERE c.id_cobro = ".$id_cobro."");
    }

    function get_last_payment($id_cobro){
        return $this->db->query("SELECT MAX(q.fecha_pago) AS ultima_fecha_pago  FROM cobros c
        INNER JOIN quincenas q ON q.id_cobro = c.id_cobro
        WHERE c.id_cobro = ".$id_cobro."");
    }

    function get_areas($id_cliente, $tipo_contrato){
        return $this->db->query("SELECT * FROM (SELECT cc.id_cliente, ar.nombre as area, opc.nombre as tipo, CONCAT(ct.nombre, '_', ct.apellido_paterno, '_', ct.apellido_materno) AS nombre, ct.titular FROM [contratos] cn 
                LEFT JOIN [clientes_contrato] cc ON cn.id_contrato = cc.id_contrato
                LEFT JOIN [clientes_x_areas] cxa ON cc.id_cliente = cxa.id_cliente AND cxa.estatus = 1
                LEFT JOIN [areas] ar ON cxa.id_area = ar.id_area 
                INNER JOIN [clientes] ct ON cxa.id_cliente = ct.id_cliente
                INNER JOIN [opciones_catalogo] opc ON opc.id_opcion = ar.tipo
                WHERE cn.id_cliente = ".$id_cliente." AND cn.tipo = ".$tipo_contrato." AND cn.estatus = 1 AND opc.id_catalogo = 8
                GROUP BY cc.id_cliente, ar.nombre, opc.nombre, ct.nombre, ct.apellido_paterno, 
                ct.apellido_materno, ct.titular) t1
                UNION (SELECT c.id_cliente, ar.nombre as area, opc.nombre as tipo, CONCAT(ct.nombre, '_', ct.apellido_paterno, '_', ct.apellido_materno) AS nombre, ct.titular
                FROM [clientes] c 
                INNER JOIN [clientes_x_areas] cxa ON c.id_cliente = cxa.id_cliente AND cxa.estatus = 1
                LEFT JOIN [areas] ar ON cxa.id_area = ar.id_area 
                INNER JOIN [clientes] ct ON cxa.id_cliente = ct.id_cliente
                INNER JOIN [opciones_catalogo] opc ON opc.id_opcion = ar.tipo
                WHERE c.id_cliente = ".$id_cliente." AND opc.id_catalogo = 8 GROUP BY c.id_cliente, ar.nombre, opc.nombre, ct.nombre, ct.apellido_paterno, 
                ct.apellido_materno, ct.titular) ORDER BY titular DESC");
    }

    function get_oldest_ticket($id_contrato){
        return $this->db->query("SELECT MIN(id_hpagos) AS 'id_oldest' FROM historial_pagos WHERE id_contrato = ".$id_contrato."");
    }
    function get_old_recibo($id_ticket){
        return $this->db->query("SELECT hp.id_hpagos, con.id_contrato, con.id_cliente, con.fecha_contrato, cob.forma_pago, cob.clave_rastreo, CAST( cob.referencia AS NVARCHAR(100)) referencia, SUM(cob.enganche) as enganche, cob.cantidad, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) as cliente,  CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno) as usuario, '1' as tipo_ticket	, cob.servicio
        FROM historial_pagos hp
        INNER JOIN contratos con ON con.id_contrato = hp.id_contrato
        INNER JOIN cobros cob ON cob.id_contrato = con.id_contrato
        INNER JOIN opciones_catalogo opc ON opc.id_opcion = cob.forma_pago
        INNER JOIN clientes cl ON cl.id_cliente = hp.id_cliente
        INNER JOIN usuarios us ON us.id_usuario = hp.creado_por
        WHERE hp.id_hpagos = ".$id_ticket." AND opc.id_catalogo = 9
        GROUP BY hp.id_hpagos, con.id_contrato, con.id_cliente, con.fecha_contrato, cob.forma_pago, cob.clave_rastreo, CAST( cob.referencia AS NVARCHAR(100)), cob.cantidad, cl.nombre, cl.apellido_paterno, cl.apellido_materno, us.nombre, us.apellido_paterno, us.apellido_materno, cob.servicio");
     }
}