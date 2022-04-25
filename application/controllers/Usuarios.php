<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller
{

	public function __construct() {
		parent::__construct();
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Headers: Content-Type');
		$this->load->model("Usuarios_model");
		$this->validateSession();
	}


	public function index(){
		$this->load->view('v_usuarios');
	}

	public function nuevo_usuario()
	{
		$this->load->view('v_nuevoUser');
	}

	public function addUser()
	{
		/*enfermero, ventas, control interno*/
		$nombre = $this->input->post('nombre');
		$apellido_paterno = $this->input->post('ap_paterno');
		$apellido_materno = $this->input->post('ap_materno');
		$mail = $this->input->post('correo');
		$password = $this->input->post('password');
		$telefono = $this->input->post('telefono');
		$usuario = $this->input->post('usuario');
		$creado_por = $this->session->userdata("inicio_sesion")['id'];
		$edad = $this->input->post('edad');
		$direccion = $this->input->post('direccion');
		$tipo_usuario = $this->input->post('tipo_usuario');

		$data_insert = array(
			"id_lider" => 1,
			"id_rol" => $tipo_usuario,
			"id_sucursal" => 1,
			"nombre" => $nombre,
			"apellido_paterno" => $apellido_paterno,
			"apellido_materno" => $apellido_materno,
			'correo' => $mail,
			"usuario" =>  $usuario,
			"contrasena" =>encriptar($password),
			"telefono" => $telefono,
			"estatus" => 1,
			"sesion_activa" => 1,
			"imagen_perfil" => "perfil.png",
			"fecha_creacion" => date('Y-m-d H:i:s'),
			"creado_por" => $creado_por,
			"edad" => $edad,
			"direccion" => $direccion,
			"aboutme" => "N/A"
		);

		$insertar_req = $this->Usuarios_model->insert_usuarios($data_insert);
		if($insertar_req != null) {
			echo json_encode($insertar_req);
		} else {
			echo json_encode(array());
		}
	}

	public function get_users()
	{
		$data_users = $this->Usuarios_model->get_users();
		if($data_users != null) {
			echo json_encode($data_users);
		} else {
			echo json_encode(array());
		}
	}

	public function delete_user($id_usuario)
	{
		$data_delete = array(
			"estatus" => 0
		);
		$data_users = $this->Usuarios_model->update_usuario($id_usuario, $data_delete);
		if($data_users != null) {
			echo json_encode($data_users);
		} else {
			echo json_encode(array());
		}
	}

	public function renew_user($id_usuario)
	{
		$data_renew = array(
			"estatus" => 1
		);
		$data_users = $this->Usuarios_model->update_usuario($id_usuario, $data_renew);
		if($data_users != null) {
			echo json_encode($data_users);
		} else {
			echo json_encode(array());
		}
	}

	public function getinfoById($id_usuario)
	{
		$data_user = $this->Usuarios_model->getinfoById($id_usuario);
		$data = array();

		$data['id_usuario'] = $data_user[0] -> id_usuario;
		$data['id_lider'] = $data_user[0] -> id_lider;
		$data['id_rol'] = $data_user[0] -> id_rol;
		$data['id_sucursal'] = $data_user[0] -> id_sucursal;
		$data['nombre'] = $data_user[0] -> nombre;
		$data['apellido_paterno'] = $data_user[0] -> apellido_paterno;
		$data['apellido_materno'] = $data_user[0] -> apellido_materno;
		$data['correo'] = $data_user[0] -> correo;
		$data['usuario'] = $data_user[0] -> usuario;
		$data['contrasena'] =desencriptar( $data_user[0] -> contrasena);
		$data['telefono'] = $data_user[0] -> telefono;
		$data['estatus'] = $data_user[0] -> estatus;
		$data['sesion_activa'] = $data_user[0] -> sesion_activa;
		$data['imagen_perfil'] = $data_user[0] -> imagen_perfil;
		$data['fecha_creacion'] = $data_user[0] -> fecha_creacion;
		$data['creado_por'] = $data_user[0] -> creado_por;
		$data['edad'] = $data_user[0] -> edad;
		$data['direccion'] = $data_user[0] -> direccion;
		$data['aboutme'] = $data_user[0] -> aboutme;



		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}

	}
	function update_user()
	{
		$nombre = $this->input->post('nombre');
		$apellido_paterno = $this->input->post('ap_paterno');
		$apellido_materno = $this->input->post('ap_materno');
		$correo = $this->input->post('correo');
		$usuario = $this->input->post('usuario');
		$contrasena = $this->input->post('password');

		$telefono = $this->input->post('telefono');
		$edad = $this->input->post('edad');
		$direccion = $this->input->post('direccion');

		$id_usuario = $this->input->post('id_usuario');
		$tipo_usuario = $this->input->post('tipo_usuario');
		/*print_r($id_usuario);
		exit;*/




		$data_actualizar = array(
			"nombre" => $nombre,
			"apellido_paterno" => $apellido_paterno,
			"apellido_materno" => $apellido_materno,
			"correo" => $correo,
			"usuario" => $usuario,
			"contrasena" => encriptar($contrasena),
			"telefono" => $telefono,
			"edad" => $edad,
			"direccion" => $direccion,
			"id_rol" => $tipo_usuario
		);

		//print_r($data_actualizar);

		$data_update_user = $this->Usuarios_model->update_usuario($id_usuario, $data_actualizar);


		if($data_update_user != null) {
			echo json_encode($data_update_user);
		} else {
			echo json_encode(array());
		}

	}

	public function validateSession()
    {
        if ($this->session->userdata("inicio_sesion")['id'] == "") {
            redirect(base_url());
        }
    }

    public function getUsersList(){
    	$data['data'] = $this->Usuarios_model->getUsersList();
        if($data != null) {
            echo json_encode($data);
        } else {
            echo json_encode(array());
        }
	}

	public function changeUserStatus(){
        if(isset($_POST) && !empty($_POST)){
            $data = array(
                "estatus" => $this->input->post("estatus")
            );
            $response = $this->Usuarios_model->changeUserStatus($data, $this->input->post("id_usuario"));
            echo json_encode($response);
        }
    }

}
