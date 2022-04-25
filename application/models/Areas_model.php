<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Areas_model extends CI_Model
{


	function __construct()
	{
		parent::__construct();
	}

	function getAreasByTipo($tipo)
	{
		$query = $this->db->query("SELECT id_area, nombre FROM areas WHERE tipo=$tipo AND estatus=1;");
		return $query->result_array();
	}

	function getAreas()
	{
		$query = $this->db->query("SELECT * FROM areas ORDER BY tipo");
		return $query->result_array();
	}

	function updateGeneral($table, $data, $id)
	{
		$this->db->where("id_area",$id);
		$this->db->update($table,$data);
		return $this->db->affected_rows();
	}

	function get_areasById($id)
	{
		$query = $this->db->query('SELECT * FROM areas WHERE id_area='.$id);
		return $query->result_array();
	}

	function insertArea($data)
	{
		$this->db->insert('areas',$data);
		return true;
	}
}
