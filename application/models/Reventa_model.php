<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reventa_model extends CI_Model {


    function __construct(){
        parent::__construct();
    }

    function get_data_cliente($valor){
        return $this->db->query("SELECT * FROM [clientes] c WHERE id_cliente = ".$valor." ORDER BY c.nombre, c.apellido_paterno, c.apellido_materno ");
    }

    function get_lista_clientes(){
        return $this->db->query("SELECT cxa.id_cliente, STRING_AGG(ar.nombre, ', ') AS valor, COUNT(ar.id_area) 
        as numareas, CONCAT(c.nombre,' ',c.apellido_paterno,' ',c.apellido_materno) AS nombre, c.correo, c.telefono, 
        c.tipo, c.estatus, co.fecha_contrato FROM [areas] AS ar INNER JOIN [clientes_x_areas] AS cxa ON cxa.id_area = ar.id_area 
        INNER JOIN [clientes] AS c ON c .id_cliente = cxa.id_cliente INNER JOIN [contratos] AS co ON co.id_cliente = c.id_cliente 
        WHERE CONVERT(DATE, co.fecha_contrato) = CONVERT(DATE, GETDATE()) AND co.estatus = 1
        GROUP BY cxa.id_cliente, c.nombre, c.apellido_paterno, c.apellido_materno, c.correo, c.telefono, c.tipo, c.estatus, co.fecha_contrato
        ORDER BY c.nombre, c.apellido_paterno, c.apellido_materno ");
    }
    
    function getDataByClient($id_cliente)
	{
		 $query = $this->db-> query("SELECT * FROM clientes WHERE id_cliente=".$id_cliente);
		 return $query->row();
	}
	
    function get_clientes_activos()
	{
		 $query = $this->db-> query("SELECT * FROM clientes");
		 return  $query->result();
	}

    function getDataByCobro($id_cliente){
        return $this->db->query("SELECT * FROM cobros WHERE id_cliente = $id_cliente")->row();
     }
}
