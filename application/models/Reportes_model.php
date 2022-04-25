<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportes_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }
 
    function get_pagos_pen_hoy(){
        return  $this->db->query("SELECT CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) as cliente, ag.hora_inicio, CONCAT(CAST(fecha_cita as DATE),' ',hora_inicio) as Cita,
        quin2.importe as vencido, quin2.fecha_pago, cli.telefono, cob.cantidad, quin.pagado, cob.enganche
        from [cobros] cob
        left join (SELECT SUM(importe) pagado, id_cobro FROM [quincenas] quin WHERE estatus = 1 GROUP BY id_cobro) quin ON cob.id_cobro = quin.id_cobro
        INNER JOIN [clientes] AS cli ON cli.id_cliente = cob.id_cliente
        INNER JOIN [agenda] AS ag ON ag.id_cliente = cob.id_cliente
        INNER JOIN [quincenas] AS quin2 ON quin2.id_cobro = cob.id_cobro
        WHERE CONVERT(DATE, quin2.fecha_pago) <= CONVERT(DATE, GETDATE())
        AND quin2.estatus = 0
        AND CONVERT(DATE, ag.fecha_cita) = CONVERT(DATE,GETDATE())");
        // return $query->result();
    }

    function get_pagos_pen_manana(){
        return $this->db->query("SELECT CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) as cliente, ag.hora_inicio, CONCAT(CAST(fecha_cita as DATE),' ',hora_inicio) as Cita,
        quin2.importe as vencido, quin2.fecha_pago, cli.telefono, cob.cantidad, quin.pagado, cob.enganche
        from [cobros] cob
        left join (SELECT SUM(importe) pagado, id_cobro FROM [quincenas] quin WHERE estatus = 1 GROUP BY id_cobro) quin ON cob.id_cobro = quin.id_cobro
        INNER JOIN [clientes] AS cli ON cli.id_cliente = cob.id_cliente
        INNER JOIN [agenda] AS ag ON ag.id_cliente = cob.id_cliente
        INNER JOIN [quincenas] AS quin2 ON quin2.id_cobro = cob.id_cobro
        WHERE CAST(quin2.fecha_pago AS DATE) <  (SELECT DATEADD(day, 1, CAST(GETDATE() AS DATE)))
        AND quin2.estatus = 0
        AND CAST(ag.fecha_cita AS DATE) = (SELECT DATEADD(day, 1, CAST(GETDATE() AS DATE)))");
         
    }

    function get_pagos_pen(){
        return $this->db->query("SELECT CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) as cliente, ag.hora_inicio, CONCAT(CAST(fecha_cita as DATE),' ',hora_inicio) as Cita,
        quin2.importe as vencido, quin2.fecha_pago, cli.telefono, cob.cantidad, quin.pagado, cob.enganche, cob.id_contrato
        from [cobros] cob
        left join (SELECT SUM(importe) pagado, id_cobro FROM [quincenas] quin WHERE estatus = 1 GROUP BY id_cobro) quin ON cob.id_cobro = quin.id_cobro
        INNER JOIN [clientes] AS cli ON cli.id_cliente = cob.id_cliente
        INNER JOIN [agenda] AS ag ON ag.id_cliente = cob.id_cliente
        INNER JOIN [quincenas] AS quin2 ON quin2.id_cobro = cob.id_cobro
        WHERE CONVERT(DATE, quin2.fecha_pago) < (SELECT DATEADD(DAY, 1, CONVERT(DATE,GETDATE())))
        AND quin2.estatus = 0
        AND CONVERT(DATE, ag.fecha_cita) < (SELECT DATEADD(DAY, 1, CONVERT(DATE,GETDATE())))");
         
    }

    function get_citas_hoy(){
        return $this->db->query("SELECT CONCAT(cli.nombre, ' ', cli.apellido_paterno, ' ', cli.apellido_materno) AS cliente, ag.hora_inicio, 
        ag.hora_fin, cli.telefono 
        FROM [agenda] ag
        INNER JOIN [clientes] AS cli ON cli.id_cliente = ag.id_cliente
        WHERE fecha_cita = CONVERT(DATE, GETDATE())");
        // return $query->result();
    }
}
