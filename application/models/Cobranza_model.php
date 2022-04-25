<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cobranza_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }
 
    function get_clientes_plan($dato){
        return $this->db->query("SELECT qu.id_quincena, qu.importe, qu.fecha_pago, (co.cantidad-((co.cantidad/100)*co.descuento)) as valor_final, 
        CONCAT(cl.nombre,' ',cl.apellido_paterno,' ',cl.apellido_materno) nom_completo, co.forma_pago, qu.estatus, qu.pago_realizado,
        (qu.importe - a.saldo) AS saldo
        FROM cobros AS co 
        INNER JOIN quincenas AS qu ON qu.id_cobro = co.id_cobro
        INNER JOIN clientes AS cl ON cl.id_cliente = co.id_cliente
        LEFT JOIN (SELECT id_quincena, SUM(pago) as saldo FROM abonos
		GROUP BY id_quincena) AS a ON a.id_quincena = qu.id_quincena and qu.estatus = 4
        WHERE co.id_contrato in (".$dato.")  ORDER BY fecha_pago");
    }

    function get_clientes_abonos($dato){
        return $this->db->query("SELECT q.id_quincena, q.id_contrato, c.cantidad, q.importe, SUM(c.enganche) total_enganche, q.estatus, ab2.abono_pagado FROM quincenas q 
        LEFT JOIN (SELECT SUM(pago) abono_pagado, id_contrato FROM abonos WHERE id_quincena in (SELECT id_quincena FROM quincenas WHERE estatus = 4) AND id_contrato = ".$dato." GROUP BY id_contrato) ab2 ON q.id_contrato = ab2.id_contrato
        INNER JOIN cobros c ON c.id_contrato = q.id_contrato
        WHERE q.id_contrato = ".$dato." GROUP BY q.id_quincena, q.id_contrato, c.cantidad, q.importe, q.estatus, ab2.abono_pagado;"); 
    }

    function get_clientes_pagar($id_contrato){
        return $this->db->query("SELECT qu.id_quincena, qu.fecha_pago, qu.importe, qu.estatus 
        FROM quincenas qu WHERE qu.estatus IN (0,4) and id_contrato = ".$id_contrato.""); 
    }

    function get_pago_una_exhibicion($dato){
        return $this->db->query("SELECT * FROM cobros WHERE id_contrato = ".$dato."");
    }

    function lista_clientes_cobranza(){
        return $this->db->query("SELECT distinct(co.id_contrato),  CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre, con.fecha_contrato, con.estatus
        FROM cobros co
        INNER JOIN clientes c ON  co.id_cliente = c.id_cliente 
        INNER JOIN contratos con ON co.id_contrato = con.id_contrato");
    }

    function update_quincenas($id_quincena){
        return $this->db->query("UPDATE quincenas SET estatus = 1, pago_realizado=GETDATE() WHERE id_quincena = ".$id_quincena."");
    }

    function update_quincenas_n($id_quincena, $historial){
        return $this->db->query("UPDATE quincenas SET estatus = 1, pago_realizado=GETDATE(), referencia = ".$historial." WHERE id_quincena = ".$id_quincena."");
    }

    function insert_pago_quincenas($id_contrato, $id_usuario_log, $tipo, $referencia, $monto, $id_folio){
        return $this->db->query("INSERT INTO pago_quincenas VALUES(".$id_contrato.", GETDATE(), ".$id_usuario_log.", ".$tipo.", '".$referencia."', ".$monto.", ".$id_folio.");");
    }

    function insert_historial_pago($id_cliente, $id_usuario_log, $id_contrato){        
        $this->db->insert("historial_pagos", array(
			"id_cliente" => $id_cliente, 
            "tipo_pago" => '2',
			"descripcion" => 'Pago de parcialidad',             
			"fecha_creacion" => date("Y-m-d H:i:s"),
			"creado_por" => $id_usuario_log,
			"id_contrato" => $id_contrato));
		return $this->db->insert_id();
    }

    function get_cliente($id_cliente){
        return $this->db->query("SELECT CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) as nombre FROM clientes WHERE id_cliente = ".$id_cliente."")->row();
    }

    function update_quincena_restante($id_quincena){
        return $this->db->query("UPDATE quincenas SET estatus = 4, pago_realizado=GETDATE() WHERE id_quincena = ".$id_quincena."");
   }
    function insert_abono_quincenas($id_contrato, $id_quincena, $importe, $referencia, $creado_por){
        return $this->db->query("INSERT INTO abonos VALUES(".$id_contrato.", ".$id_quincena.", ".$importe.", ".$referencia.", GETDATE(), ".$creado_por.", 1);");
    }


    function get_abono_by_quincena($id_contrato){
        return $this->db->query("SELECT a.id_quincena, SUM(a.pago) as pago
        FROM quincenas AS q
        INNER JOIN abonos AS a ON q.id_quincena = a.id_quincena
        WHERE q.id_contrato = ".$id_contrato." AND q.estatus = 4
        group by a.id_quincena")->result_array(); 
    }


    function get_saldo($id_contrato){
        return $this->db->query("SELECT a.id_quincena, SUM(a.pago) as pago
        FROM quincenas AS q
        INNER JOIN abonos AS a ON q.id_quincena = a.id_quincena
        WHERE q.id_contrato = ".$id_contrato." AND q.estatus = 4
        group by a.id_quincena")->result_array(); 
    }

    function get_saldo_plan($id_contrato){
        return $this->db->query("SELECT SUM(q.importe) as pago
        FROM quincenas AS q
        WHERE q.id_contrato = ".$id_contrato." AND q.estatus = 0")->result_array(); 
    }

    function get_abonos($id_quincena){
        return $this->db->query("SELECT a.id_quincena, a.fecha_creacion, a.pago, a.referencia, 
        CONCAT(u.nombre,' ',u.apellido_paterno,' ', u.apellido_materno) AS creado_por, STRING_AGG(oc.nombre, ', ') metodo_pago, cr.msi
        FROM abonos a 
        INNER JOIN usuarios u ON a.creado_por = u.id_usuario
        INNER JOIN pago_quincenas pq ON pq.historial = a.referencia
        INNER JOIN opciones_catalogo oc ON oc.id_opcion = pq.metodo AND oc.id_catalogo = 9
        INNER JOIN cobros cr ON cr.id_contrato = a.id_contrato
        WHERE id_quincena = $id_quincena
        GROUP BY a.id_quincena, a.fecha_creacion, a.pago, a.referencia, 
        CONCAT(u.nombre,' ',u.apellido_paterno,' ', u.apellido_materno), cr.msi")->result_array(); 
    }

    function get_last_quincena($id_contrato){
        return $this->db->query("SELECT id_quincena, importe FROM quincenas WHERE id_contrato 
        = ".$id_contrato." and estatus = 4")->result_array(); 
    }

    function get_all_abonos($id_contrato){
        return $this->db->query("SELECT abo.id_contrato, abo.id_quincena, abo.pago, abo.referencia
        FROM abonos abo
        INNER JOIN quincenas qui ON qui.id_quincena = abo.id_quincena
        WHERE abo.id_contrato = ".$id_contrato." AND qui.estatus = 4");
    }


    function updateContrato($id_contrato, $data)
    {
        $this->db->where("id_contrato",$id_contrato);
        $this->db->update('contratos',$data);
        return $this->db->affected_rows();
    }

    function checkIfIsFinished($id_contrato)
    {
        $query = $this->db->query("SELECT COUNT(id_quincena) as quincenas_restantes FROM quincenas WHERE id_contrato=$id_contrato AND estatus=0;");
        return $query->row();
    }

    function getFullPayments($id_quincena){
        return $this->db->query("SELECT q.id_quincena, q.pago_realizado fecha_creacion, q.importe pago, pq.historial referencia, 
		CONCAT(u.nombre,' ',u.apellido_paterno,' ', u.apellido_materno) AS creado_por, STRING_AGG(oc.nombre, ', ') metodo_pago, cr.msi
		FROM pago_quincenas pq
		INNER JOIN quincenas q ON q.referencia = pq.historial
		INNER JOIN usuarios u ON pq.creado_por = u.id_usuario
		INNER JOIN opciones_catalogo oc ON oc.id_opcion = pq.metodo AND oc.id_catalogo = 9
		INNER JOIN cobros cr ON cr.id_contrato = pq.id_contrato
		WHERE id_quincena IN ($id_quincena)
		GROUP BY q.id_quincena, q.pago_realizado, q.importe, pq.historial, CONCAT(u.nombre,' ',u.apellido_paterno,' ', u.apellido_materno), cr.msi")->result_array();
    }

    function getCompletePayment($id_contrato){
        return $this->db->query("SELECT cr.id_cobro id_quincena, cr.fecha_creacion, cr.cantidad pago, cr.referencia, 
        CONCAT(u.nombre,' ',u.apellido_paterno,' ', u.apellido_materno) AS creado_por, oc.nombre metodo_pago, cr.msi
        FROM cobros CR
        INNER JOIN usuarios u ON cr.creado_por = u.id_usuario
        INNER JOIN opciones_catalogo oc ON oc.id_opcion = cr.forma_pago AND oc.id_catalogo = 9
        WHERE CR.id_contrato = $id_contrato")->result_array();
    }


}