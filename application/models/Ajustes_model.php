<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajustes_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    function update_perfil($id_user, $data){
        return $this->db->update( "usuarios", $data, "id_usuario = '$id_user'" );
    }

    function get_datos_perfil(){
        return $this->db->query("SELECT CONCAT(nombre,' ',apellido_paterno,' ',apellido_materno) as nombre_completo, edad, correo, nombre, apellido_paterno, apellido_materno, direccion, aboutme FROM [usuarios] WHERE id_usuario = ".$this->session->userdata("inicio_sesion")['id']."");
	}
	
	/*cobros de hoy*/
    function getTotalCobrosToday($hoy){
		$query = $this->db-> query("SELECT co.cantidad suma_hoy_cobros, co.id_contrato FROM cobros co
		INNER JOIN contratos cn ON cn.id_contrato = co.id_contrato
		INNER JOIN clientes cl ON cl.id_cliente = cn.id_cliente AND cl.tipo = 1
		WHERE co.fecha_cobro BETWEEN '$hoy 00:00.00' AND '$hoy 23:59.59' GROUP BY co.cantidad, co.id_contrato");
		return $query->result_array();		
	}

	function getTotalCobrosQuincenaToday($hoy){
		$query = $this->db->query("SELECT SUM(importe) as suma_hoy_quincenas FROM quincenas WHERE estatus=1 AND fecha_pago BETWEEN '$hoy 00:00.00' AND '$hoy 23:59.59'");
		return $query->result();
	}

	/*cobros de la semana actual*/
	function getTotalCobrosWeek($monday, $sunday){
		$query = $this->db-> query("SELECT DISTINCT(co.id_contrato), co.cantidad as suma_semana_cobros FROM cobros co
		INNER JOIN contratos cn ON cn.id_contrato = co.id_contrato
		INNER JOIN clientes cl ON cl.id_cliente = cn.id_cliente AND cl.tipo = 1
		WHERE co.fecha_cobro BETWEEN '$monday 00:00.000' AND '$sunday 23:59.59'");
		return $query->result();
	}

	function getTotalCobrosQuincenaWeek($monday, $sunday){
		$query = $this->db->query("SELECT SUM(importe) as suma_semana_quincenas FROM quincenas WHERE estatus=1 AND fecha_pago BETWEEN '$monday 00:00.00' AND '$sunday 23:59.59'");
		return $query->result();
	}
}
