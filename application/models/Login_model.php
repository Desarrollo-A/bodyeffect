<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {


    function __construct(){
        parent::__construct();
    }
 

    function verificar_usuario(){

        $igual = $this->input->post("login_password") == $this->input->post("login_usuario");
        $password = encriptar($this->input->post("login_password"));
        print_r($password);
        $usuario = $this->input->post("login_usuario");

        $query = $this->db->query("SELECT us.id_usuario,CONCAT(us.nombre,' ',us.apellido_paterno) AS nom_completo, oc.nombre as rol, us.id_rol FROM 
            [usuarios] as us INNER JOIN (SELECT * FROM [opciones_catalogo] as oc WHERE oc.id_catalogo = 1) oc ON us.id_rol = oc.id_opcion WHERE us.usuario = '$usuario' AND us.contrasena  = '$password' AND us.estatus in (1) ");
        if($query->num_rows() > 0){
            $this->session->set_userdata("inicio_sesion",array(
                "id" => $query->row()->id_usuario,
                "nombre" => $query->row()->nom_completo,
                "rol" => $query->row()->rol,
                "id_rol" => $query->row()->id_rol 
            ));
        }else{
            $this->session->set_flashdata('error_usuario', '<div class="col-md-1">&nbsp;</div><div style="-webkit-box-shadow: 8px 8px 5px 0px rgba(214,214,214,1);-moz-box-shadow: 8px 8px 5px 0px rgba(214,214,214,1);box-shadow: 8px 8px 5px 0px rgba(214,214,214,1);" class="col-md-11 alert alert-secondary text-danger" role="alert"><center><b>¡PASSWORD / USUARIO INCORRECTO!</b><br><span style="font-size:12px;">Verificar los datos o ponerse en contacto con un administrador.</span></center></div>');
        }
    }
}
