<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tarifas_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    
    function getAllAreas(){
        return $this->db->query("SELECT ar.id_area, ar.nombre, ar.tarifa, ar.estatus , ar.tipo, ar.duracion
        FROM areas ar WHERE ar.id_area != 75 AND ar.tipo = 4");
    }

    function updatePrice($area, $costo, $duracion){
        $query = $this->db->query("UPDATE areas SET tarifa= $costo, duracion= $duracion WHERE id_area= $area");
        return $query;
    }

    function changeStatus($status, $id_area){
        $query = $this->db->query("UPDATE areas SET estatus = $status WHERE id_area = $id_area");
        return $query;
    }
}
