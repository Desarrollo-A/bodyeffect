<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clientes_model extends CI_Model {

   function __construct(){
        parent::__construct();
   }

   function get_areas_lista($id_area){
    if($id_area == 3){
      return $this->db->query("SELECT id_area, nombre, tarifa, (CASE WHEN tipo = 1 THEN 'Depilación' WHEN tipo = 2 THEN 'Moldeo' END) tipo, no_sesion, clave, piezas_edit, sesiones_e, sesiones_maxmin, promo_sesion, venus FROM [areas] WHERE estatus = 1 AND tipo IN (1,2) ORDER BY tipo, nombre");
    }
    else if($id_area == 5){
      return $this->db->query("SELECT id_area, nombre, tarifa, (CASE WHEN tipo = 2 THEN 'Moldeo' WHEN tipo = 4 THEN 'Rejuvenecimiento facial' END) tipo, no_sesion, clave, piezas_edit, sesiones_e, sesiones_maxmin, promo_sesion, venus
      FROM [areas] WHERE estatus = 1 AND tipo IN (2,4) ORDER BY tipo, nombre");
    }
    else{
        return $this->db->query("SELECT id_area, nombre, tarifa, (CASE WHEN tipo = 1 THEN 'Depilación' WHEN tipo = 2 THEN 'Moldeo' WHEN tipo = 4 THEN 'Rejuvenecimiento facial' END) tipo, no_sesion, clave, piezas_edit, sesiones_e, sesiones_maxmin, promo_sesion, venus FROM [areas] WHERE estatus = 1 AND tipo = $id_area ORDER BY tipo, nombre");
    }
  }

     function get_metodos_pago(){
        return $this->db->query("SELECT * FROM [opciones_catalogo] WHERE id_catalogo = 9 AND estatus = 1 ORDER BY id_opcion");
     }

     function get_tipos_cobro(){
         return $this->db->query("SELECT * FROM [opciones_catalogo] WHERE id_catalogo = 12 AND estatus = 1");
      }

      function getEnfermeras(){
         return $this->db->query("SELECT id_usuario, CONCAT(nombre,' ',apellido_paterno,' ',apellido_materno) name_enfermera FROM usuarios WHERE id_rol in (3,7) AND estatus = 1");
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

     function get_clientes_lista(){
        return $this->db->query("SELECT c.id_cliente, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre FROM [clientes] c ORDER BY c.nombre, c.apellido_paterno, c.apellido_materno ");
     }

   function get_clientes_lista_agenda($inicio, $fin){
      if ($inicio ==  undefined && $fin == undefined){
         return $this->db->query("((SELECT c.id_cliente, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre FROM [clientes] c INNER JOIN agenda a ON a.id_cliente = c.id_cliente WHERE a.estatus IN (2))) UNION ((SELECT c.id_cliente, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre FROM [clientes] c WHERE c.id_cliente NOT IN (SELECT id_cliente FROM [agenda])))");
      } 
   }

   function get_clientes_lista_titular(){
      return $this->db->query("SELECT c.id_cliente, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre FROM [clientes] c WHERE c.titular = 1 ORDER BY c.nombre, c.apellido_paterno, c.apellido_materno");
   }

   function get_clientes_lista_cobranza(){
      return $this->db->query("SELECT distinct(co.id_contrato), c.id_cliente, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre, con.fecha_contrato, con.estatus
      FROM [cobros] co
      INNER JOIN [clientes] c ON  co.id_cliente = c.id_cliente 
      INNER JOIN [contratos] con ON co.id_contrato = con.id_contrato");
   }

   function get_datos_clientes(){
      return $this->db->query("SELECT c.id_cliente, CONCAT(c.nombre, ' ', c.apellido_paterno, ' ', c.apellido_materno) nombre, c.correo, c.telefono, 
      c.fecha_creacion, ar.nombre nombre_area, c.estatus FROM [clientes] c 
      INNER JOIN [clientes_x_areas] cxa ON c.id_cliente = cxa.id_cliente AND cxa.estatus = 1
      INNER JOIN [areas] ar ON ar.id_area = cxa.id_area ORDER BY  c.nombre, c.apellido_paterno, c.apellido_materno");
   }

   function get_data_cliente($valor){
      return $this->db->query("SELECT * FROM [clientes] c WHERE id_cliente = ".$valor." ORDER BY c.nombre, c.apellido_paterno, c.apellido_materno");
   }

   function get_clientes_activos(){
      $query_1 = $this->db->query("SELECT CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) as cliente, co.fecha_cobro, 
      CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno, ' ( ', oc.nombre, ' )') as vendedor,
      co.cantidad as total_pagar, qui.abono_pagado as abonado, co.enganche, co.forma_pago
      FROM [cobros] co 
      INNER JOIN clientes AS cli ON cli.id_cliente = co.id_cliente
      INNER JOIN usuarios AS us ON us.id_usuario = co.creado_por
      INNER JOIN opciones_catalogo AS oc ON oc.id_opcion = us.id_rol
      LEFT JOIN (SELECT SUM(importe) abono_pagado, id_cobro, COUNT(id_quincena) pagos FROM [quincenas] WHERE estatus in (1) GROUP BY id_cobro) qui ON co.id_cobro = qui.id_cobro
      LEFT JOIN (SELECT SUM(importe) abono_pendiente, id_cobro, COUNT(id_quincena) pp FROM [quincenas] WHERE estatus in (0) GROUP BY id_cobro) qu2 ON co.id_cobro = qu2.id_cobro
      WHERE oc.id_catalogo = 1
      GROUP BY cli.nombre, cli.apellido_paterno, cli.apellido_materno, co.fecha_cobro, us.nombre, us.apellido_paterno, us.apellido_materno, oc.nombre, co.cantidad, qui.abono_pagado, co.enganche, qu2.abono_pendiente, qu2.pp, co.parcialidades, co.forma_pago");
      return $query_1->result();
   }

   function get_clientes_activos_2($begin_date, $end_date){ //UPDATED FUNCTION
      return $this->db->query(" SELECT '1' as tipoTrans ,'0' as numero_pago, '0' as abonado, '0' as enganche, 
    CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) as cliente, convert(char(10), co.fecha_cobro, 111) as fecha_cobro,
      CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno, ' ( ', oc.nombre, ' )') as vendedor,
      co.cantidad as total_pagar, STRING_AGG(oc2.nombre, ',') forma_pago, co.concepto, co.id_cliente, t.totalEnganche,
      CONCAT(us_c_ant.nombre, ' ', us_c_ant.apellido_paterno, ' ', us_c_ant.apellido_materno) as v_compartida_anterior, 
    nombre_vc as v_compartida,
    co.id_contrato, con.tipo, con.estatus as estatus_contrado
      FROM [cobros] co
      JOIN (SELECT id_cliente, id_contrato, SUM(enganche) AS totalEnganche FROM cobros GROUP BY id_cliente, id_contrato)AS t ON co.id_cliente=t.id_cliente
      INNER JOIN clientes AS cli ON cli.id_cliente = co.id_cliente
      INNER JOIN usuarios AS us ON us.id_usuario = co.creado_por
      INNER JOIN opciones_catalogo AS oc ON oc.id_opcion = us.id_rol
      INNER JOIN opciones_catalogo AS oc2 ON oc2.id_opcion = co.forma_pago
    LEFT JOIN usuarios AS us_c_ant ON us_c_ant.id_usuario = co.compartido/*comp v1*/
    LEFT JOIN (SELECT STRING_AGG(CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), ',') nombre_vc, id_contrato FROM ventas_compartidas vc LEFT JOIN usuarios u ON u.id_usuario=vc.id_usuario GROUP BY id_contrato) as us_c ON us_c.id_contrato=co.id_contrato

      INNER JOIN contratos con ON co.id_contrato=con.id_contrato
      WHERE oc.id_catalogo = 1 AND oc2.id_catalogo = 9 AND t.id_contrato=co.id_contrato 
      AND co.fecha_creacion BETWEEN '$begin_date 00:00:00' AND '$end_date 23:59:59'
      GROUP BY co.cantidad,
    CONCAT(us_c_ant.nombre, ' ', us_c_ant.apellido_paterno, ' ', us_c_ant.apellido_materno),
      CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno), convert(char(10), co.fecha_cobro, 111),
      CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno, ' ( ', oc.nombre, ' )'), co.concepto, co.id_cliente, t.totalEnganche,
    nombre_vc, co.id_contrato, con.tipo, con.estatus;");
   }

   //SE COMENTÓ EL QUI.PAGO DEL GROUP BY PORQUE COMO ES DIFERENTE LO ESTABA SEPARANDO Y NO AGRUPABA TODOS LOS PARÁMETROS
   public function get_clientes_activos_22($begin_date, $end_date){ // PAGOS A QUINCENAS COMPLETOS (VIEJITOS)
    return $this->db->query("SELECT '2' as tipoTrans ,STRING_AGG(qui.referencia, ', ') id_hpagos, STRING_AGG(qui.numero_pago, ', ') WITHIN GROUP 
    (ORDER BY qui.numero_pago) numero_pago, 
    (CASE WHEN COUNT(DISTINCT(pq.historial)) > 1 THEN SUM(qui.importe) ELSE (CASE WHEN COUNT(DISTINCT(pq.metodo)) > 1 THEN /*SUM(pq.importe)*/ SUM(DISTINCT(pq.importe)) ELSE SUM(DISTINCT(pq.importe)) END) END) abonado, 
    CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as cliente,'Parcialidad' as concepto, 
    CONVERT(char(10), pq.fecha_creado, 111)  as fecha_cobro, co.id_cliente,
    pq.id_contrato, co.cantidad as total_pagar, 
    CONCAT(us_c_ant.nombre, ' ', us_c_ant.apellido_paterno, ' ', us_c_ant.apellido_materno) as v_compartida_anterior, 
    nombre_vc as v_compartida, co.cantidad totalEnganche,
    CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno, ' ( ', oc.nombre, ' )') as vendedor,
    con.tipo, con.estatus as estatus_contrado, 
    (CASE WHEN COUNT(DISTINCT(pq.historial)) > 1 THEN SUM(qui.importe) ELSE (CASE WHEN COUNT(DISTINCT(pq.metodo)) > 1 THEN /*SUM(pq.importe)*/ SUM(DISTINCT(pq.importe)) ELSE SUM(DISTINCT(pq.importe))END) END) enganche, 
    STRING_AGG(oc2.nombre,',') forma_pago
    FROM contratos con
    INNER JOIN quincenas qui ON qui.id_contrato=con.id_contrato AND qui.estatus=1 
    INNER JOIN pago_quincenas pq ON pq.historial = qui.referencia
    INNER JOIN historial_pagos hp ON hp.id_hpagos = qui.referencia
    INNER JOIN cobros co ON co.id_cobro = qui.id_cobro
    INNER JOIN usuarios AS us ON us.id_usuario = co.creado_por
    INNER JOIN opciones_catalogo AS oc ON oc.id_opcion = us.id_rol AND oc.id_catalogo = 1
    INNER JOIN clientes cl ON cl.id_cliente=co.id_cliente
    INNER JOIN opciones_catalogo AS oc2 ON oc2.id_opcion = pq.metodo AND oc2.id_catalogo = 9
    INNER JOIN opciones_catalogo AS oc3 ON oc3.id_opcion = co.forma_pago AND oc3.id_catalogo = 9
    LEFT JOIN usuarios AS us_c_ant ON us_c_ant.id_usuario = co.compartido
    LEFT JOIN (SELECT STRING_AGG(CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), ',') nombre_vc, id_contrato FROM ventas_compartidas vc LEFT JOIN usuarios u ON u.id_usuario=vc.id_usuario GROUP BY id_contrato) as us_c ON us_c.id_contrato=co.id_contrato
    WHERE pq.fecha_creado BETWEEN '$begin_date 00:00:00' AND '$end_date 23:59:59'
    GROUP BY CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno),
    CONVERT(char(10), pq.fecha_creado, 111), co.id_cliente, pq.id_contrato, co.cantidad,
    CONCAT(us_c_ant.nombre, ' ', us_c_ant.apellido_paterno, ' ', us_c_ant.apellido_materno),
    nombre_vc, /*qui.importe,*/ CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno, ' ( ', oc.nombre, ' )'),
    con.tipo, con.estatus");
  }

  //SE COMENTÓ EL QUI.PAGO DEL GROUP BY PORQUE COMO ES DIFERENTE LO ESTABA SEPARANDO Y NO AGRUPABA TODOS LOS PARÁMETROS
  public function get_clientes_activos_222($begin_date, $end_date){ // SÓLO ABONOS A QUINCENAS (LOS QUE ESTÁN EN PROCESO)
    return $this->db->query("SELECT '3' as tipoTrans ,STRING_AGG(hp.id_hpagos, ', ') id_hpagos, STRING_AGG(qui.numero_pago, ', ') WITHIN GROUP 
    (ORDER BY qui.numero_pago) numero_pago, 
    --(CASE WHEN COUNT(DISTINCT(pq.historial)) > 1 THEN SUM(ab.pago) ELSE (CASE WHEN COUNT(DISTINCT(pq.metodo)) > 1 THEN SUM(ab.pago) ELSE SUM(DISTINCT(ab.pago))END) END) as abonado, 
    (CASE WHEN COUNT(DISTINCT(pq.historial)) > 1 THEN SUM(ab.pago) ELSE (CASE WHEN COUNT(DISTINCT(pq.metodo)) > 1 THEN ab.pago ELSE SUM(ab.pago)END) END) abonado,
    CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as cliente,'Abono a parcialidad' as concepto, 
    CONVERT(char(10), pq.fecha_creado, 111)  as fecha_cobro, co.id_cliente,
    pq.id_contrato, co.cantidad as total_pagar, 
    CONCAT(us_c_ant.nombre, ' ', us_c_ant.apellido_paterno, ' ', us_c_ant.apellido_materno) as v_compartida_anterior, 
    nombre_vc as v_compartida, co.cantidad totalEnganche,
    CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno, ' ( ', oc.nombre, ' )') as vendedor,
    con.tipo, con.estatus as estatus_contrado, 
    --(CASE WHEN COUNT(DISTINCT(pq.historial)) > 1 THEN SUM(ab.pago) ELSE (CASE WHEN COUNT(DISTINCT(pq.metodo)) > 1 THEN SUM(ab.pago) ELSE SUM(DISTINCT(ab.pago))END) END) enganche, 
    (CASE WHEN COUNT(DISTINCT(pq.historial)) > 1 THEN SUM(ab.pago) ELSE (CASE WHEN COUNT(DISTINCT(pq.metodo)) > 1 THEN ab.pago ELSE SUM(ab.pago)END) END) enganche, 
    STRING_AGG(oc2.nombre,',') forma_pago
    FROM contratos con
    INNER JOIN quincenas qui ON qui.id_contrato=con.id_contrato AND qui.estatus = 4
    INNER JOIN abonos ab ON ab.id_quincena = qui.id_quincena
    INNER JOIN pago_quincenas pq ON pq.historial = ab.referencia
    INNER JOIN historial_pagos hp ON hp.id_hpagos = ab.referencia
    INNER JOIN cobros co ON co.id_cobro = qui.id_cobro
    INNER JOIN usuarios AS us ON us.id_usuario = co.creado_por
    INNER JOIN opciones_catalogo AS oc ON oc.id_opcion = us.id_rol AND oc.id_catalogo = 1
    INNER JOIN clientes cl ON cl.id_cliente=co.id_cliente
    INNER JOIN opciones_catalogo AS oc2 ON oc2.id_opcion = pq.metodo AND oc2.id_catalogo = 9
    INNER JOIN opciones_catalogo AS oc3 ON oc3.id_opcion = co.forma_pago AND oc3.id_catalogo = 9
    LEFT JOIN usuarios AS us_c_ant ON us_c_ant.id_usuario = co.compartido
    LEFT JOIN (SELECT STRING_AGG(CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), ',') nombre_vc, id_contrato FROM ventas_compartidas vc LEFT JOIN usuarios u ON u.id_usuario=vc.id_usuario GROUP BY id_contrato) as us_c ON us_c.id_contrato=co.id_contrato
    WHERE pq.fecha_creado BETWEEN '$begin_date 00:00:00' AND '$end_date 23:59:59'
    GROUP BY CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno),
    CONVERT(char(10), pq.fecha_creado, 111), co.id_cliente, pq.id_contrato, co.cantidad,
    CONCAT(us_c_ant.nombre, ' ', us_c_ant.apellido_paterno, ' ', us_c_ant.apellido_materno),
    nombre_vc, /*qui.importe,*/ CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno, ' ( ', oc.nombre, ' )'),
    con.tipo, con.estatus, ab.pago");
  }

  // SE REMOVIÓ DISTINCT ABONADO Y ENGANCHE (EL ÚLTIMO) Y SE COMENTÓ EL QUI.PAGO DEL GROUP BY PORQUE COMO ES DIFERENTE LO ESTABA SEPARANDO Y NO AGRUPABA TODOS LOS PARÁMETROS
  public function get_clientes_activos_2222($begin_date, $end_date){ // NUEVOS POGOS COMPLETOS QUE AHORA LA REFERENCIA SE OBTIENE DE ABONOS
    return $this->db->query("SELECT '4' as tipoTrans ,STRING_AGG(qui.referencia, ', ') id_hpagos, STRING_AGG(qui.numero_pago, ', ') WITHIN GROUP 
    (ORDER BY qui.numero_pago) numero_pago, 
    (CASE WHEN COUNT(DISTINCT(pq.historial)) > 1 THEN SUM(ab.pago) ELSE (CASE WHEN COUNT(DISTINCT(pq.metodo)) > 1 THEN ab.pago ELSE SUM(/*DISTINCT(*/ab.pago/*)*/)END) END) abonado,
    CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno) as cliente,'Parcialidad' as concepto, 
    CONVERT(char(10), pq.fecha_creado, 111)  as fecha_cobro, co.id_cliente,
    pq.id_contrato, co.cantidad as total_pagar, 
    CONCAT(us_c_ant.nombre, ' ', us_c_ant.apellido_paterno, ' ', us_c_ant.apellido_materno) as v_compartida_anterior, 
    nombre_vc as v_compartida, co.cantidad totalEnganche,
    CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno, ' ( ', oc.nombre, ' )') as vendedor,
    con.tipo, con.estatus as estatus_contrado, 
    (CASE WHEN COUNT(DISTINCT(pq.historial)) > 1 THEN SUM(ab.pago) ELSE (CASE WHEN COUNT(DISTINCT(pq.metodo)) > 1 THEN ab.pago ELSE SUM(/*DISTINCT(*/ab.pago/*)*/)END) END) enganche, 
    STRING_AGG(oc2.nombre,',') forma_pago
    FROM contratos con
    INNER JOIN quincenas qui ON qui.id_contrato=con.id_contrato AND qui.estatus = 1
    INNER JOIN abonos ab ON ab.id_quincena = qui.id_quincena
    INNER JOIN pago_quincenas pq ON pq.historial = ab.referencia
    INNER JOIN historial_pagos hp ON hp.id_hpagos = ab.referencia
    INNER JOIN cobros co ON co.id_cobro = qui.id_cobro
    INNER JOIN usuarios AS us ON us.id_usuario = co.creado_por
    INNER JOIN opciones_catalogo AS oc ON oc.id_opcion = us.id_rol AND oc.id_catalogo = 1
    INNER JOIN clientes cl ON cl.id_cliente=co.id_cliente
    INNER JOIN opciones_catalogo AS oc2 ON oc2.id_opcion = pq.metodo AND oc2.id_catalogo = 9
    INNER JOIN opciones_catalogo AS oc3 ON oc3.id_opcion = co.forma_pago AND oc3.id_catalogo = 9
    LEFT JOIN usuarios AS us_c_ant ON us_c_ant.id_usuario = co.compartido
    LEFT JOIN (SELECT STRING_AGG(CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno), ',') nombre_vc, id_contrato FROM ventas_compartidas vc LEFT JOIN usuarios u ON u.id_usuario=vc.id_usuario GROUP BY id_contrato) as us_c ON us_c.id_contrato=co.id_contrato
    WHERE pq.fecha_creado BETWEEN '$begin_date 00:00:00' AND '$end_date 23:59:59'
    GROUP BY CONCAT(cl.nombre,' ', cl.apellido_paterno, ' ', cl.apellido_materno),
    CONVERT(char(10), pq.fecha_creado, 111), co.id_cliente, pq.id_contrato, co.cantidad,
    CONCAT(us_c_ant.nombre, ' ', us_c_ant.apellido_paterno, ' ', us_c_ant.apellido_materno),
    nombre_vc, /*qui.importe,*/ CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno, ' ( ', oc.nombre, ' )'),
    con.tipo, con.estatus, ab.pago");
  }
   
  function get_clientes_activos_2_byClient($begin_date, $end_date, $id_cliente, $id_contrato){ //UPDATED FUNCTION
    return $this->db->query("SELECT '0' as numero_pago, '0' as abonado, '0' as enganche, CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) as cliente, convert(char(10), co.fecha_cobro, 111) as fecha_cobro,
      CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno, ' ( ', oc.nombre, ' )') as vendedor,
      co.cantidad as total_pagar, STRING_AGG(oc2.nombre, ',') forma_pago, co.concepto, co.id_cliente, t.totalEnganche,
      CONCAT(us_c.nombre, ' ', us_c.apellido_paterno, ' ', us_c.apellido_materno) as v_copartida, co.id_contrato, con.tipo, con.estatus as estatus_contrado
      FROM [cobros] co
      JOIN (SELECT id_cliente, id_contrato, SUM(enganche) AS totalEnganche FROM cobros GROUP BY id_cliente, id_contrato)AS t ON co.id_cliente=t.id_cliente
      INNER JOIN clientes AS cli ON cli.id_cliente = co.id_cliente
      INNER JOIN usuarios AS us ON us.id_usuario = co.creado_por
      INNER JOIN opciones_catalogo AS oc ON oc.id_opcion = us.id_rol
      INNER JOIN opciones_catalogo AS oc2 ON oc2.id_opcion = co.forma_pago
      LEFT JOIN usuarios AS us_c ON us_c.id_usuario = co.compartido
      INNER JOIN contratos con ON co.id_contrato=con.id_contrato
      WHERE oc.id_catalogo = 1 AND oc2.id_catalogo = 9 AND t.id_contrato=co.id_contrato 
      AND co.id_cliente=".$id_cliente." AND co.id_contrato=".$id_contrato."
      GROUP BY co.cantidad,
      CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno), convert(char(10), co.fecha_cobro, 111),
      CONCAT(us.nombre, ' ', us.apellido_paterno, ' ', us.apellido_materno, ' ( ', oc.nombre, ' )'), co.concepto, co.id_cliente, t.totalEnganche,
      CONCAT(us_c.nombre, ' ', us_c.apellido_paterno, ' ', us_c.apellido_materno), co.id_contrato, con.tipo, con.estatus");
  }

   function getTotalQuincenas($end_date, $type, $id_contrato){ // MJ: REGRESA TOTAL PAGADO POR CONCEPTO
   	switch ($type) {
   		case 1: // PARA QUINCENAS COMPLETAS SIN ABONOS
   			$qry = $this->db->query("SELECT q.id_quincena, STRING_AGG(q.referencia, ', ') referencia, q.importe FROM quincenas q
			INNER JOIN pago_quincenas pq ON pq.historial = q.referencia
      INNER JOIN historial_pagos hp ON hp.id_hpagos = q.referencia
			WHERE q.id_contrato = $id_contrato AND q.estatus = 1 AND pq.fecha_creado <= '$end_date 23:59:59'
			GROUP BY q.id_quincena, q.importe
      UNION ALL
      SELECT q.id_quincena, STRING_AGG(q.referencia, ', ') referencia, q.importe FROM quincenas q
        INNER JOIN abonos ab ON ab.id_quincena = q.id_quincena
        INNER JOIN pago_quincenas pq ON pq.historial = ab.referencia
        INNER JOIN historial_pagos hp ON hp.id_hpagos = ab.referencia
        WHERE q.id_contrato = $id_contrato AND q.estatus = 1 AND pq.fecha_creado <= '$end_date 23:59:59'
        GROUP BY q.id_quincena, q.importe");
   			break;
   		
   		case 2: // PARA ABONOS (PAGOS SIN COMPLETAR)
   			$qry = $this->db->query("SELECT q.id_quincena, STRING_AGG(q.referencia, ', ') referencia, pq.importe FROM quincenas q
        INNER JOIN abonos ab ON ab.id_quincena = q.id_quincena
        INNER JOIN pago_quincenas pq ON pq.historial = ab.referencia
        INNER JOIN historial_pagos hp ON hp.id_hpagos = ab.referencia
        WHERE q.id_contrato = $id_contrato AND q.estatus = 4 AND pq.fecha_creado <= '$end_date 23:59:59'
        GROUP BY q.id_quincena, pq.importe
        UNION ALL
        SELECT q.id_quincena, STRING_AGG(q.referencia, ', ') referencia, q.importe FROM quincenas q
        INNER JOIN pago_quincenas pq ON pq.historial = q.referencia
        INNER JOIN historial_pagos hp ON hp.id_hpagos = q.referencia
        WHERE q.id_contrato = $id_contrato AND q.estatus = 1 AND pq.fecha_creado <= '$end_date 23:59:59'
        GROUP BY q.id_quincena, q.importe;");
   			break;

   		case 3: // PARA PAGOS COMPLETOS POR ABONOS
   			$qry = $this->db->query("SELECT q.id_quincena, STRING_AGG(q.referencia, ', ') referencia, q.importe FROM quincenas q
        INNER JOIN abonos ab ON ab.id_quincena = q.id_quincena
        INNER JOIN pago_quincenas pq ON pq.historial = ab.referencia
        INNER JOIN historial_pagos hp ON hp.id_hpagos = ab.referencia
        WHERE q.id_contrato = $id_contrato AND q.estatus = 1 AND pq.fecha_creado <= '$end_date 23:59:59'
        GROUP BY q.id_quincena, q.importe
        UNION ALL
        SELECT q.id_quincena, STRING_AGG(q.referencia, ', ') referencia, q.importe FROM quincenas q
        INNER JOIN pago_quincenas pq ON pq.historial = q.referencia
        INNER JOIN historial_pagos hp ON hp.id_hpagos = q.referencia
        WHERE q.id_contrato = $id_contrato AND q.estatus = 1 AND pq.fecha_creado <= '$end_date 23:59:59'
        GROUP BY q.id_quincena, q.importe;");
   			break;
   	}
    return $qry;
  }

   function getTotalTdcPQ($begin_date, $end_date){
      return $this->db->query("SELECT SUM(importe) as total_pagar FROM pago_quincenas pq 
      INNER JOIN opciones_catalogo oc ON pq.metodo=oc.id_opcion
      WHERE id_catalogo=9 AND id_opcion=1 AND pq.fecha_creado BETWEEN '$begin_date 00:00:00' AND '$end_date 23:59:59';");
   }
   function getTotalTdc($begin_date, $end_date){ // NEW FUNCTION
    return $this->db->query("SELECT SUM(co.enganche) total_pagar
                                FROM [cobros] co 
                                INNER JOIN clientes AS cli ON cli.id_cliente = co.id_cliente
                                INNER JOIN usuarios AS us ON us.id_usuario = co.creado_por
                                INNER JOIN opciones_catalogo AS oc ON oc.id_opcion = us.id_rol
                                INNER JOIN opciones_catalogo AS oc2 ON oc2.id_opcion = co.forma_pago
                                LEFT JOIN (SELECT SUM(importe) abono_pagado, id_cobro, COUNT(id_quincena) pagos FROM [quincenas] 
                                WHERE estatus in (1) GROUP BY id_cobro) qui ON co.id_cobro = qui.id_cobro
                                LEFT JOIN (SELECT SUM(importe) abono_pendiente, id_cobro, COUNT(id_quincena) pp FROM [quincenas] 
                                WHERE estatus in (0) GROUP BY id_cobro) qu2 ON co.id_cobro = qu2.id_cobro
                                WHERE oc.id_catalogo = 1 AND oc2.id_catalogo = 9 AND co.fecha_creacion BETWEEN '$begin_date 00:00:00' AND '$end_date 23:59:59' AND co.forma_pago = 1");
  }

  function getTotalTddPQ($begin_date, $end_date){
    return $this->db->query("SELECT SUM(importe) as total_pagar FROM pago_quincenas pq 
    INNER JOIN opciones_catalogo oc ON pq.metodo=oc.id_opcion
    WHERE id_catalogo=9 AND id_opcion=2 AND pq.fecha_creado BETWEEN '$begin_date 00:00:00' AND '$end_date 23:59:59';");
  }

  function getTotalTdd($begin_date, $end_date){ //NEW FUNCTION
    return $this->db->query("SELECT SUM(co.enganche) total_pagar
                                FROM [cobros] co 
                                INNER JOIN clientes AS cli ON cli.id_cliente = co.id_cliente
                                INNER JOIN usuarios AS us ON us.id_usuario = co.creado_por
                                INNER JOIN opciones_catalogo AS oc ON oc.id_opcion = us.id_rol
                                INNER JOIN opciones_catalogo AS oc2 ON oc2.id_opcion = co.forma_pago
                                LEFT JOIN (SELECT SUM(importe) abono_pagado, id_cobro, COUNT(id_quincena) pagos FROM [quincenas] 
                                WHERE estatus in (1) GROUP BY id_cobro) qui ON co.id_cobro = qui.id_cobro
                                LEFT JOIN (SELECT SUM(importe) abono_pendiente, id_cobro, COUNT(id_quincena) pp FROM [quincenas] 
                                WHERE estatus in (0) GROUP BY id_cobro) qu2 ON co.id_cobro = qu2.id_cobro
                                WHERE oc.id_catalogo = 1 AND oc2.id_catalogo = 9 AND co.fecha_creacion BETWEEN '$begin_date 00:00:00' AND '$end_date 23:59:59' AND co.forma_pago = 2");

   }

  function getTotalCashPQ($begin_date, $end_date){
    return $this->db->query("SELECT SUM(importe) as total_pagar FROM pago_quincenas pq 
    INNER JOIN opciones_catalogo oc ON pq.metodo=oc.id_opcion
    WHERE id_catalogo=9 AND id_opcion=3 AND pq.fecha_creado BETWEEN '$begin_date 00:00:00' AND '$end_date 23:59:59';");
  }

   function getTotalCash($begin_date, $end_date){ // NEW FUNCTION
    return $this->db->query("SELECT SUM(co.enganche) total_pagar
                                FROM [cobros] co 
                                INNER JOIN clientes AS cli ON cli.id_cliente = co.id_cliente
                                INNER JOIN usuarios AS us ON us.id_usuario = co.creado_por
                                INNER JOIN opciones_catalogo AS oc ON oc.id_opcion = us.id_rol
                                INNER JOIN opciones_catalogo AS oc2 ON oc2.id_opcion = co.forma_pago
                                LEFT JOIN (SELECT SUM(importe) abono_pagado, id_cobro, COUNT(id_quincena) pagos FROM [quincenas] 
                                WHERE estatus in (1) GROUP BY id_cobro) qui ON co.id_cobro = qui.id_cobro
                                LEFT JOIN (SELECT SUM(importe) abono_pendiente, id_cobro, COUNT(id_quincena) pp FROM [quincenas] 
                                WHERE estatus in (0) GROUP BY id_cobro) qu2 ON co.id_cobro = qu2.id_cobro
                                WHERE oc.id_catalogo = 1 AND oc2.id_catalogo = 9 AND co.fecha_creacion BETWEEN '$begin_date 00:00:00' AND '$end_date 23:59:59' AND co.forma_pago = 3");
   }
  /*nuevo 04122020*/
  function getTotalTBPQ($begin_date, $end_date){
    return $this->db->query("SELECT SUM(importe) as total_pagar FROM pago_quincenas pq 
    INNER JOIN opciones_catalogo oc ON pq.metodo=oc.id_opcion
    WHERE id_catalogo=9 AND id_opcion=6 AND pq.fecha_creado BETWEEN '$begin_date 00:00:00' AND '$end_date 23:59:59';");
  }

  function getTotalTB($begin_date, $end_date){ // NEW FUNCTION
    return $this->db->query("SELECT SUM(co.enganche) total_pagar
                              FROM [cobros] co 
                              INNER JOIN clientes AS cli ON cli.id_cliente = co.id_cliente
                              INNER JOIN usuarios AS us ON us.id_usuario = co.creado_por
                              INNER JOIN opciones_catalogo AS oc ON oc.id_opcion = us.id_rol
                              INNER JOIN opciones_catalogo AS oc2 ON oc2.id_opcion = co.forma_pago
                              LEFT JOIN (SELECT SUM(importe) abono_pagado, id_cobro, COUNT(id_quincena) pagos FROM [quincenas] 
                              WHERE estatus in (1) GROUP BY id_cobro) qui ON co.id_cobro = qui.id_cobro
                              LEFT JOIN (SELECT SUM(importe) abono_pendiente, id_cobro, COUNT(id_quincena) pp FROM [quincenas] 
                              WHERE estatus in (0) GROUP BY id_cobro) qu2 ON co.id_cobro = qu2.id_cobro
                              WHERE oc.id_catalogo = 1 AND oc2.id_catalogo = 9 AND co.fecha_creacion BETWEEN '$begin_date 00:00:00' AND '$end_date 23:59:59' AND co.forma_pago = 6");
  }
   /***************/
   function get_agenda_depilacion(){
      return $this->db->query("SELECT cl.id_cliente, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombre, oxc.nombre as tipo
		FROM clientes_x_areas cxa
		INNER JOIN clientes cl ON  cl.id_cliente=cxa.id_cliente
		INNER JOIN paquetes pq ON  pq.id_cliente=cxa.id_cliente
		INNER JOIN contratos co ON co.id_contrato = pq.id_contrato
    INNER JOIN opciones_catalogo oxc ON oxc.id_opcion = cl.tipo AND oxc.id_catalogo = 17 
    WHERE cxa.estatus = 1 
		GROUP BY cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, oxc.nombre");
   }
   function get_agenda_moldeo(){
      return $this->db->query("SELECT cl.id_cliente, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombre, pq.id_contrato
		FROM clientes_x_areas cxa
		INNER JOIN clientes cl ON  cl.id_cliente=cxa.id_cliente
		INNER JOIN paquetes pq ON  pq.id_cliente=cxa.id_cliente
		INNER JOIN contratos co ON co.id_contrato = pq.id_contrato AND co.servicio = 2
		 WHERE cxa.estatus = 1
		GROUP BY cl.id_cliente, cl.nombre, cl.apellido_paterno, cl.apellido_materno, pq.id_contrato");/*cxa.estatus in (0)  AND */
   }

   function get_old_ticket($id_ticket){
      $data_quincenas = $this->db->query("SELECT hp.id_hpagos AS folio,hp.fecha_creacion, hp.creado_por, STRING_AGG(oc.nombre, ', ') as metodo_pagos, STRING_AGG(pq.referencia, ', ') as referencias,
      qu.importe, qu.fecha_pago, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombre_cliente, qu.pago_realizado, '2' as tipo_ticket, qu.importe as importe_quincena, 'LIQUIDADO' as concepto
      FROM pago_quincenas pq
      INNER JOIN historial_pagos hp ON hp.id_hpagos = pq.historial
      INNER JOIN quincenas qu ON qu.referencia = hp.id_hpagos
      INNER JOIN clientes cl ON cl.id_cliente = hp.id_cliente
      INNER JOIN opciones_catalogo oc ON oc.id_opcion = pq.metodo
      WHERE hp.id_hpagos = ".$id_ticket."  AND oc.id_catalogo = 9
      GROUP BY  hp.id_hpagos, hp.id_hpagos, hp.creado_por, qu.importe,hp.fecha_creacion, qu.fecha_pago, cl.nombre, cl.apellido_paterno, cl.apellido_materno, qu.pago_realizado ORDER BY fecha_pago")->result_array();

      if(count($data_quincenas) > 0)
      {
        return $data_quincenas;
      }
      else
      {
        $query = $this->db->query("SELECT hp.id_hpagos AS folio,hp.fecha_creacion, hp.creado_por, STRING_AGG(oc.nombre, ', ') as metodo_pagos, STRING_AGG(pq.referencia, ', ') as referencias, ab.pago importe, qu.fecha_pago, CONCAT(cl.nombre, ' ', cl.apellido_paterno, ' ', cl.apellido_materno) as nombre_cliente, qu.pago_realizado, '2' as tipo_ticket, qu.importe as importe_quincena,qu.estatus,
        CASE WHEN qu.estatus = 1 THEN 'LIQUIDADO' ELSE 'ABONADO A QUINCENA' END as concepto
        FROM quincenas qu
        INNER JOIN abonos ab ON ab.id_quincena=qu.id_quincena
        INNER JOIN historial_pagos hp ON hp.id_hpagos = ab.referencia
        INNER JOIN pago_quincenas pq ON pq.historial = ab.referencia
        INNER JOIN clientes cl ON cl.id_cliente = hp.id_cliente
        INNER JOIN opciones_catalogo oc ON oc.id_opcion = pq.metodo
        WHERE hp.id_hpagos = ".$id_ticket."  AND oc.id_catalogo = 9
        GROUP BY  hp.id_hpagos,ab.pago, hp.id_hpagos,hp.fecha_creacion, hp.creado_por, qu.importe, qu.fecha_pago, cl.nombre, cl.apellido_paterno, cl.apellido_materno, qu.pago_realizado, qu.estatus ORDER BY fecha_pago");
        return $query->result_array();
      }
   }

   function get_old_metodos($id_ticket){
      
      $data_quincenas = $this->db->query("SELECT hp.id_hpagos AS folio,hp.fecha_creacion, hp.creado_por, oc.nombre as metodo_pagos,
      pq.referencia as referencias,
      (CASE WHEN COUNT(DISTINCT(pq.historial)) > 1 THEN SUM(qu.importe) ELSE (CASE WHEN COUNT(DISTINCT(pq.metodo)) > 1 THEN SUM(pq.importe) ELSE SUM(DISTINCT(pq.importe))END) END) importeReal
       FROM pago_quincenas pq
            INNER JOIN historial_pagos hp ON hp.id_hpagos = pq.historial
            INNER JOIN quincenas qu ON qu.referencia = hp.id_hpagos
            INNER JOIN clientes cl ON cl.id_cliente = hp.id_cliente
            INNER JOIN opciones_catalogo oc ON oc.id_opcion = pq.metodo
            WHERE hp.id_hpagos = ".$id_ticket."  AND oc.id_catalogo = 9
      GROUP BY hp.id_hpagos, hp.fecha_creacion, hp.creado_por, oc.nombre, pq.importe, pq.referencia")->result_array();

      if(count($data_quincenas) > 0)
      {
        return $data_quincenas;
      }
      else
      {
        $query = $this->db->query("SELECT hp.id_hpagos AS folio,hp.fecha_creacion, hp.creado_por, oc.nombre as metodo_pagos,
        pq.referencia as referencias,
        (CASE WHEN COUNT(DISTINCT(pq.historial)) > 1 THEN SUM(qu.importe) ELSE (CASE WHEN COUNT(DISTINCT(pq.metodo)) > 1 THEN SUM(pq.importe) ELSE SUM(DISTINCT(pq.importe))END) END) importeReal
        FROM quincenas qu
        INNER JOIN abonos ab ON ab.id_quincena=qu.id_quincena
        INNER JOIN historial_pagos hp ON hp.id_hpagos = ab.referencia
        INNER JOIN pago_quincenas pq ON pq.historial = ab.referencia
        INNER JOIN clientes cl ON cl.id_cliente = hp.id_cliente
        INNER JOIN opciones_catalogo oc ON oc.id_opcion = pq.metodo
        WHERE hp.id_hpagos = ".$id_ticket."  AND oc.id_catalogo = 9
        GROUP BY hp.id_hpagos, hp.fecha_creacion, hp.creado_por, oc.nombre, pq.importe, pq.referencia");
        return $query->result_array();
      }
   }
  
  function getTotalVenta($begin_date, $end_date){
    $query = $this->db-> query("SELECT id_contrato, cantidad FROM cobros WHERE fecha_cobro BETWEEN '$begin_date 00:00.00' AND '$end_date 23:59.59' AND estatus = 1 AND forma_pago != 5 GROUP BY id_contrato, cantidad");
		return $query;
  }

    /*101220*/
  function insert_ventas_compartidas($data_insert){
    $this->db->insert('ventas_compartidas',$data_insert);
    return $this->db->affected_rows();
  }

    /*141220*/
  function getLP(){
    $query = $this->db->query("SELECT * FROM opciones_catalogo WHERE id_catalogo=16 AND estatus=1");
    return $query->result_array();
  }

  function get_lugar_prospeccion($id_cliente){
      $query = $this->db->query("SELECT lugar_prospeccion FROM cobros WHERE id_cliente = ".$id_cliente."");      
      return $query->result_array();
  }

  function get_areasLipoenzimas(){
    return $this->db->query("SELECT * FROM lipoenzimas_areas WHERE estatus = 1 ORDER BY nombre");
  }
}