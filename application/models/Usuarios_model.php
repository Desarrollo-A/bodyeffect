<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios_model extends CI_Model {


	function __construct(){
		parent::__construct();
	}

	public function insert_usuarios($data) {
		$this->db->insert('usuarios', $data);
		return true;
	}
	public function get_users()
	{
		$query = $this->db->query("SELECT * FROM usuarios");
		return $query->result();
	}
	public function update_usuario($id_usuario, $data_update)
	{
		$this->db->where("id_usuario",$id_usuario);
		$this->db->update('usuarios',$data_update);
		return $this->db->affected_rows();
	}
	public function getinfoById($id_usuario)
	{
		$query = $this->db->query("SELECT * FROM usuarios WHERE id_usuario=".$id_usuario);
		return $query->result();
	}

	function getUsersList(){
        $query = $this->db->query("SELECT id_usuario, estatus, UPPER(nombre) nombre, UPPER(apellido_paterno) apellido_paterno, UPPER(apellido_materno) apellido_materno FROM usuarios WHERE id_rol NOT IN (1, 4, 6) ORDER BY nombre, apellido_paterno, apellido_materno");
        return $query->result_array();
    }

    function changeUserStatus($data, $id_usuario) {
        $response = $this->db->update("usuarios", $data, "id_usuario = $id_usuario");
        if (! $response ) {
            return $finalAnswer = 0;
        } else {
            return $finalAnswer = 1;
        }
    }
}
