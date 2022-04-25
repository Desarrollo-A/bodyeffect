<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ClientesReventa_model extends CI_Model {


    function __construct(){
        parent::__construct();
    }

    function get_lista_clientes($id_cliente){
      
      return $this->db->query("SELECT * FROM (SELECT cc.id_cliente, STRING_AGG(ar.nombre, ', ') AS areas, ct.nombre, ct.apellido_paterno, 
      ct.apellido_materno, ct.telefono, ct.correo, ct.titular, COUNT(ar.nombre) total_areas, SUM(ar.tarifa) total FROM [contratos] cn 
      LEFT JOIN [clientes_contrato] cc ON cn.id_contrato = cc.id_contrato
      LEFT JOIN [clientes_x_areas] cxa ON cc.id_cliente = cxa.id_cliente
      LEFT JOIN [areas] ar ON cxa.id_area = ar.id_area 
      INNER JOIN [clientes] ct ON cxa.id_cliente = ct.id_cliente
      WHERE cn.id_cliente = ".$id_cliente." GROUP BY cc.id_cliente, ct.nombre, ct.apellido_paterno, 
      ct.apellido_materno, ct.telefono, ct.correo, ct.titular) t1
      UNION (SELECT c.id_cliente, STRING_AGG(ar.nombre, ', ') AS areas, ct.nombre, ct.apellido_paterno, 
      ct.apellido_materno, ct.telefono, ct.correo, ct.titular, COUNT(ar.nombre) total_areas, SUM(ar.tarifa) total FROM [clientes] c 
      INNER JOIN [clientes_x_areas] cxa ON c.id_cliente = cxa.id_cliente 
      LEFT JOIN [areas] ar ON cxa.id_area = ar.id_area 
      INNER JOIN [clientes] ct ON cxa.id_cliente = ct.id_cliente
      WHERE c.id_cliente = ".$id_cliente." GROUP BY c.id_cliente, ct.nombre, ct.apellido_paterno, 
      ct.apellido_materno, ct.telefono, ct.correo, ct.titular) ORDER BY titular DESC");
   }

   function get_metodos_pago(){
       return $this->db->query("SELECT * FROM [opciones_catalogo] WHERE id_catalogo = 9 AND estatus = 1");
   }

   function get_tipos_cobro(){
       return $this->db->query("SELECT * FROM [opciones_catalogo] WHERE id_catalogo = 12 AND estatus = 1");
   }

   function lista_sino(){
       return $this->db->query("SELECT * FROM [opciones_catalogo] WHERE id_catalogo = 7 AND estatus = 1");
   }

   function get_tipo_tarjeta(){
       return $this->db->query("SELECT * FROM [opciones_catalogo] WHERE id_catalogo = 11 AND estatus = 1");
   }

   function get_bancos(){
       return $this->db->query("SELECT * FROM [bancos] WHERE estatus = 1 ORDER BY nombre");
   }

   function get_lista_tarjetas($id_cliente){
    return $this->db->query("SELECT * FROM [tarjetas] WHERE id_cliente = ".$id_cliente." ORDER BY tarjeta_primaria");
 }

 function get_lista_cobros($id_cliente){
    return $this->db->query("SELECT * FROM [cobros] WHERE id_cliente = ".$id_cliente." AND concepto = 'Anticipo'");
 }

 function get_expediente($id_cliente){
   return $this->db->query("SELECT id_expediente, id_cliente, ife, tarjeta, contrato, carta FROM [expediente] WHERE id_cliente = ".$id_cliente."");
 }

 function get_areas_lista(){
   return $this->db->query("SELECT id_area, nombre, tarifa, (CASE WHEN tipo = 1 THEN 'Depilación' WHEN tipo = 2 THEN 'Moldeo' END) tipo, no_sesion FROM [areas] WHERE estatus = 1 ORDER BY tipo, nombre");
 }

 function get_contrato($id_cliente){
   return $this->db->query("SELECT id_contrato, id_cliente FROM [contratos] WHERE id_cliente = ".$id_cliente."");
 }

}
