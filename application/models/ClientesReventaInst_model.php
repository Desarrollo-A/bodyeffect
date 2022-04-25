<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ClientesReventaInst_model extends CI_Model {

   function __construct(){
        parent::__construct();
   }

   function get_lista_clientes($id_contrato){
      return $this->db->query("SELECT ct.id_cliente, ISNULL(STRING_AGG(ar.nombre, ', '),0) AS areas,ISNULL(STRING_AGG(ar.Partes, ', '),0) as Partes,ISNULL(STRING_AGG(ar.Completo,' ,'),0) as Completo,ISNULL(STRING_AGG(ar.id_area,' ,'),0) as idArea, ct.nombre, ct.apellido_paterno, 
      ct.apellido_materno, ct.telefono, ct.correo, ct.titular, CAST(ct.domicilio AS NVARCHAR(100)) domicilio, COUNT(ar.nombre) total_areas, ISNULL(SUM(ar.tarifa),0) total FROM [contratos] cn 
      LEFT JOIN [paquetes] pq ON pq.id_contrato = cn.id_contrato 
      LEFT JOIN [clientes_x_areas] cxa ON cxa.id_paquete = pq.id_paquete AND cxa.estatus = 1
      LEFT JOIN [areas] ar ON cxa.id_area = ar.id_area 
      LEFT JOIN [clientes] ct ON pq.id_cliente = ct.id_cliente
      WHERE cn.id_contrato = $id_contrato GROUP BY ct.id_cliente, ct.nombre, ct.apellido_paterno, 
      ct.apellido_materno, ct.telefono, ct.correo, ct.titular, CAST(ct.domicilio AS NVARCHAR(100)) ORDER BY CT.titular DESC");
   }

   function get_id_areas_by_Parte($parte){
      $query = $this->db->query("SELECT id_area FROM areas WHERE Partes= $parte;");
      return $query->result_array();
   }

   function get_areas_lista($id_area){
      return $this->db->query("SELECT id_area, nombre, tarifa, (CASE WHEN tipo = 1 THEN 'Depilación' WHEN tipo = 2 THEN 'Moldeo' END) tipo, no_sesion FROM [areas] WHERE estatus = 1 AND tipo = ".$id_area." ORDER BY tipo, nombre");
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

   function get_lista_tarjetas($id_contrato){
      return $this->db->query("SELECT * FROM [tarjetas] WHERE id_contrato = ".$id_contrato." ORDER BY tarjeta_primaria");
   }

   function get_lista_cobros($id_contrato){
      return $this->db->query("SELECT * FROM [cobros] WHERE id_contrato = ".$id_contrato."");
   }
   
   function get_lista_cxamd($id_contrato){
      return $this->db->query("SELECT * FROM (SELECT ct.id_cliente, ISNULL(STRING_AGG(cxa.id_area, ','),0) AS areas, ct.titular FROM [contratos] cn
      LEFT JOIN [paquetes] paq ON paq.id_contrato = cn.id_contrato 
       LEFT JOIN [clientes_x_areas] cxa ON cxa.id_cliente = paq.id_cliente AND cxa.estatus = 1
       LEFT JOIN [clientes] ct ON paq.id_cliente = ct.id_cliente
	   LEFT JOIN [areas] ar ON cxa.id_area = ar.id_area
       WHERE cn.id_contrato = $id_contrato AND paq.id_contrato = $id_contrato AND ar.tipo != 4 GROUP BY ct.id_cliente, ct.titular) t1z");
   }

   function get_lista_cxarf($id_contrato){
      return $this->db->query("SELECT * FROM (SELECT paq.id_paquete, ct.id_cliente, ISNULL(STRING_AGG(cxa.id_area, ','),0) AS areas, ct.titular FROM [contratos] cn
      LEFT JOIN [paquetes] paq ON paq.id_contrato = cn.id_contrato 
       LEFT JOIN [clientes_x_areas] cxa ON cxa.id_cliente = paq.id_cliente AND cxa.estatus = 1
       LEFT JOIN [clientes] ct ON paq.id_cliente = ct.id_cliente
	   LEFT JOIN [areas] ar ON cxa.id_area = ar.id_area
       WHERE cn.id_contrato = $id_contrato AND ar.tipo = 4 GROUP BY paq.id_paquete, ct.id_cliente, ct.titular) t1z");
   }

   function get_lista_areas($servicio){
      // if(count($partes)==0) $parts = '0';
      // else $parts= implode( "," , $partes );  
      
      if($servicio == 3){
         return $this->db->query("SELECT id_area, nombre, tarifa, (CASE WHEN tipo = 1 THEN 'Depilación' WHEN tipo = 2 THEN 'Moldeo' END) tipo, no_sesion, clave, piezas_edit, sesiones_e, sesiones_maxmin, promo_sesion, venus FROM [areas] WHERE estatus = 1 AND tipo IN (1,2) ORDER BY tipo, nombre");
      }
      else if($servicio == 5){
         return $this->db->query("SELECT id_area, nombre, tarifa, (CASE WHEN tipo = 2 THEN 'Moldeo' WHEN tipo = 4 THEN 'Rejuvenecimiento facial' END) tipo, no_sesion, clave, piezas_edit, sesiones_e, sesiones_maxmin, promo_sesion, venus
         FROM [areas] WHERE estatus = 1 AND tipo IN (2,4) ORDER BY tipo, nombre");
      }
      else{
           return $this->db->query("SELECT id_area, nombre, tarifa, (CASE WHEN tipo = 1 THEN 'Depilación' WHEN tipo = 2 THEN 'Moldeo' WHEN tipo = 4 THEN 'Rejuvenecimiento facial' END) tipo, no_sesion, clave, piezas_edit, sesiones_e, sesiones_maxmin, promo_sesion, venus FROM [areas] WHERE estatus = 1 AND tipo = $servicio ORDER BY tipo, nombre");
      }
   }

   function get_areas_rf($id_paquete, $id_area){
      // if($j = 1){
      //    return $this->db->query("SELECT cxa.id_area, cxa.unidades, cxa.num_sesion, axl.id_area as id_area_lipo, axl.sesiones as sesiones_lipo FROM contratos con
      //    INNER JOIN clientes cl ON con.id_cliente = cl.id_cliente
      //    INNER JOIN paquetes pa ON cl.id_cliente = pa.id_cliente
      //    INNER JOIN clientes_x_areas cxa ON cxa.id_paquete = pa.id_paquete
      //    INNER JOIN areas ar ON cxa.id_area = ar.id_area AND ar.tipo = 4
      //    LEFT JOIN areas_x_lipoenzimas axl ON axl.id_paquete = pa.id_paquete
      //    LEFT JOIN lipoenzimas_areas la ON la.id_area = axl.id_area
      //    WHERE con.id_contrato = $id_contrato AND cl.id_cliente = $id_cliente ");
      // }
      // else{
      //    return $this->db->query("SELECT cxa.id_area, cxa.unidades, cxa.num_sesion, axl.id_area as id_area_lipo, axl.sesiones as sesiones_lipo FROM contratos con
      //    INNER JOIN clientes_contrato cc ON con.id_contrato = cc.id_contrato
      //    INNER JOIN clientes cl ON cc.id_cliente = cl.id_cliente
      //    INNER JOIN paquetes pa ON cl.id_cliente = pa.id_cliente
      //    INNER JOIN clientes_x_areas cxa ON cxa.id_paquete = pa.id_paquete
      //    INNER JOIN areas ar ON cxa.id_area = ar.id_area AND ar.tipo = 4
      //    LEFT JOIN areas_x_lipoenzimas axl ON axl.id_paquete = pa.id_paquete
      //    LEFT JOIN lipoenzimas_areas la ON la.id_area = axl.id_area
      //    WHERE con.id_contrato = $id_contrato AND cl.id_cliente = $id_cliente");
      // }
      return $this->db->query("SELECT cxa.*, ar.venus, ar.tarifa FROM clientes_x_areas cxa LEFT JOIN areas ar ON cxa.id_area = ar.id_area WHERE cxa.id_paquete = $id_paquete AND cxa.id_area = $id_area AND cxa.estatus = 1");
   }

   function get_areas_lipoenzimas($id_paquete){
      return $this->db->query("SELECT axl.*, la.tarifa FROM areas_x_lipoenzimas axl LEFT JOIN lipoenzimas_areas la ON axl.id_area = la.id_area WHERE id_paquete = $id_paquete AND axl.estatus = 1");
   }

   function get_expediente($id_contrato){
      return $this->db->query("SELECT id_expediente, id_cliente, ife, tarjeta, contrato, carta FROM [expediente] WHERE id_contrato = ".$id_contrato."");
   }

   function get_contrato($id_contrato){
      return $this->db->query("SELECT id_contrato, id_cliente, servicio, observaciones FROM [contratos] WHERE id_contrato = ".$id_contrato."");
   }

   function get_lista_paquetes($id_contrato){
      return $this->db->query("SELECT * FROM [paquetes] WHERE id_contrato = ".$id_contrato." AND CONVERT(DATE, fecha_creacion) = CONVERT(DATE, GETDATE())");
   }

   function get_oldest_ticket($cliente){
      return $this->db->query("SELECT MIN(id_hpagos) AS 'id_oldest' FROM historial_pagos WHERE id_cliente = ".$cliente."");
   }

   function update_cobros($precioFinal, $porcentaje, $fecha_hoy, $fecha_vencimiento, $parcialidades, $total, $compartido, $id_cliente, $prosa, $mensualidad, $id_contrato, $id_contrato_old, $lugar_prospeccion, $area){      
      $this->db->query("UPDATE [cobros] SET cantidad = ".$precioFinal.", fecha_cobro = GETDATE(), descuento = ".$porcentaje.", fecha_vencimiento = '".$fecha_vencimiento."', fecha_creacion = GETDATE(), parcialidades = ".$parcialidades.", mensualidad = ".$mensualidad.", total = ".$total.", compartido = ".$compartido.", servicio = ".$area.", prosa = ".$prosa.", id_contrato = ".$id_contrato.", lugar_prospeccion=".$lugar_prospeccion."  WHERE id_contrato =".$id_contrato_old."");
   }

   function update_expediente($dataExpediente, $id_contrato_old){
		$this->db->update("expediente", $dataExpediente, "id_contrato = $id_contrato_old");
	}

   function update_tarjeta($id_contrato_old, $id_contrato){
      $this->db->query("UPDATE tarjetas SET id_contrato = ".$id_contrato." WHERE id_contrato = ".$id_contrato_old."");
   }
   
   function insert_cobros($insert_id, $precioFinal, $mesesi, $porcentaje, $fecha_actual, $parcialidades, $formaPago, $pagoCon, $montoEnganche, $total, $compartido, $area, $referencia, $prosa, $mensualidad, $id_contrato, $lugar_prospeccion, $clave_rastreo){
      //if ($parcialidades==0) $parcialidades = 1;
      // $query = $this->db->query("SELECT referencia FROM cobros WHERE id_contrato = '$id_contrato';");
      // $row = $query->result();
      $this->db->insert("cobros", array(
         "id_cliente" => $insert_id,
         "concepto" => 'Anticipo',
         "cantidad" => $precioFinal,
         "fecha_cobro" => date("Y-m-d H:i:s"),
         "msi" => $mesesi,
         "descuento" => $porcentaje,
         "fecha_vencimiento" => date("Y-m-d",strtotime($fecha_actual."+ $parcialidades month")),    // numero de exhibiciones de pago
         "forma_pago" => $formaPago,    // Array de formas de pago
         "fecha_creacion" => date("Y-m-d H:i:s"),
         "creado_por" => $this->session->userdata("inicio_sesion")['id'],
         "mensualidad" => $mensualidad,
         "enganche" => $montoEnganche,
         "total" => $total,
         "parcialidades" => $parcialidades,
         "compartido" => $compartido,
         "servicio" => $area,
         "referencia" => $referencia,
         "prosa" => $prosa,
         "id_contrato" => $id_contrato,
         "lugar_prospeccion" => $lugar_prospeccion,
         "clave_rastreo" => $clave_rastreo));
      return $this->db->insert_id();
   }
   
   public function update_historial_pagos($id_contrato_old, $id_contrato){
      $this->db->query("UPDATE [historial_pagos] SET id_contrato = ".$id_contrato." WHERE id_contrato = ".$id_contrato_old." AND descripcion = 'Anticipo hecho tras firmar el contrato.'");
   }

   public function update_paquetes($id_contrato_old, $id_contrato){
      $this->db->query("UPDATE [paquetes] SET id_contrato = ".$id_contrato." WHERE id_contrato = ".$id_contrato_old."");
   }

   function delete_payments($id_contrato_old){
      $this->db->query("DELETE FROM quincenas WHERE id_contrato = ".$id_contrato_old."");
   }

   function getVCByContrato($id_contrato)
   {
      $query = $this->db->query("SELECT * FROM [ventas_compartidas] WHERE id_contrato=".$id_contrato);
      return $query->result_array();
   }

   function verifyIfExistVC($id_contrato, $id_usuario)
   {
      $query = $this->db->query("SELECT * FROM ventas_compartidas WHERE id_contrato=".$id_contrato." AND id_usuario=".$id_usuario);
      return $query->result_array();
   }
   
   function update_ventas_compartidas($data_update, $id_vc){
      $this->db->update("ventas_compartidas", $data_update, "id_vc = $id_vc");
      return $this->db->affected_rows();
   }

    function get_areas_rf_details($id_paquete){
        return $this->db->query("SELECT paq.id_paquete, ct.id_cliente, ar.tarifa, cxa.id_area, cxa.num_sesion, cxa.unidades, axl.id_area id_area_lipo, 
        axl.sesiones sesiones_lipo, la.tarifa tarifa_lipo, ar.venus FROM [contratos] cn
        INNER JOIN [paquetes] paq ON paq.id_contrato = cn.id_contrato AND paq.id_paquete = $id_paquete
        INNER JOIN [clientes_x_areas] cxa ON cxa.id_cliente = paq.id_cliente AND cxa.estatus = 1
        INNER JOIN [clientes] ct ON paq.id_cliente = ct.id_cliente
        INNER JOIN [areas] ar ON cxa.id_area = ar.id_area AND ar.tipo = 4
        LEFT JOIN [areas_x_lipoenzimas] axl ON axl.id_paquete = paq.id_paquete AND cxa.id_area = 75 AND axl.estatus = 1
        LEFT JOIN [lipoenzimas_areas] la ON la.id_area = axl.id_area");
    }

    public function addRecord($table, $data) // MJ: AGREGA UN REGISTRO A UNA TABLA EN PARTICULAR, RECIBE 2 PARÁMETROS. LA TABLA Y LA DATA A INSERTAR
      {
         if ($data != '' && $data != null) {
            $response = $this->db->insert($table, $data);
            if (!$response) {
               return $finalAnswer = 0;
            } else {
               return $finalAnswer = 1;
            }
         } else {
            return 0;
         }
      }

   public function updateRecord($table, $data, $key, $value) // MJ: ACTUALIZA LA INFORMACIÓN DE UN REGISTRO EN PARTICULAR, RECIBE 4 PARÁMETROS. TABLA, DATA A ACTUALIZAR, LLAVE (WHERE) Y EL VALOR DE LA LLAVE
   {
      $response = $this->db->update($table, $data, "$key = '$value'");
      if (!$response) {
         return $finalAnswer = 0;
      } else {
         return $finalAnswer = 1;
      }
   }

   public function getTableInformationByRecord($table, $key, $value){
      $query = $this->db->query("SELECT * FROM $table WHERE $key = $value AND estatus = 1");
      return $query;
   }

}