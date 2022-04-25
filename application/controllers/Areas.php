<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Areas extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Headers: Content-Type');

		$this->load->model('Areas_model');
	}

	public function index()
	{
		$this->load->view('areas_admin');
	}

	function getAreasByTipo($tipo)
	{
		$data = $this->Areas_model->getAreasByTipo($tipo);


		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}

	function getAreas()
	{
		$data = $this->Areas_model->getAreas();


		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}
	function deleteArea()
	{
		$id_area = $this->input->post('id_area');
		$table = 'areas';
		$data_update = array(
			'estatus' => 0
		);
		$data = $this->Areas_model->updateGeneral($table, $data_update, $id_area);
		//print_r($id_area);
		if($data>=1)
		{
			$data_request['success'] = 1;
			$data_request['message'] = 'Se ha eliiminado correctamente';
		}
		else{
			$data_request['success'] = 0;
			$data_request['message'] = 'Ha ocurrido un error la intentar eliminar, intentalo nuevamente';
		}
		if($data_request != null) {
			echo json_encode($data_request);
		} else {
			echo json_encode(array());
		}
	}

	function reactivateArea()
	{
		$id_area = $this->input->post('id_area');
		$table = 'areas';
		$data_update = array(
			'estatus' => 1
		);
		$data = $this->Areas_model->updateGeneral($table, $data_update, $id_area);
		//print_r($id_area);
		if($data>=1)
		{
			$data_request['success'] = 1;
			$data_request['message'] = 'Se ha actualizado correctamente';
		}
		else{
			$data_request['success'] = 0;
			$data_request['message'] = 'Ha ocurrido un error la intentar eliminar, intentalo nuevamente';
		}
		if($data_request != null) {
			echo json_encode($data_request);
		} else {
			echo json_encode(array());
		}
	}

	function get_areasById($id)
	{
		$data = $this->Areas_model->get_areasById($id);
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}

	function editarArea()
	{
		$id_area = $this->input->post('id_areaE');
		$nombre = $this->input->post('nombreE');
		$tarifa = $this->input->post('tarifaE');
		$sesiones = $this->input->post('sesionesE');
		$duracion = $this->input->post('duracionE');
		$tipo = $this->input->post('tipoE');
		$parte = $this->input->post('parteE');
		$valFinal = ($this->input->post('parte_deE')==null) ? 1 : 0;
		$data_update = array(
			"nombre" => $nombre,
			"tarifa" => $tarifa,
			"tipo" => $tipo,
			"no_sesion" => $sesiones,
			"duracion" => $duracion,
			"Partes" => $parte,
			"completo" => $valFinal
		);
		/*echo 'Area: '.$id_area."<br>";
		print_r($data_update);*/
		$table = 'areas';

		$request = $this->Areas_model->updateGeneral($table, $data_update, $id_area);

		if($request >= 1)
		{
			$data['success'] = 1;
			$data['message'] = 'Se actualizó correctamente el área.';
		}
		else{
			$data['success'] = 0;
			$data['message'] = 'Ocurrió un error al ejecutar la operación, intentalo de nuevo.';
		}
		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}

	}

	function addArea()
	{
		$nombre = $this->input->post('nombre');
		$tarifa = $this->input->post('tarifa');
		$sesiones = $this->input->post('sesiones');
		$duracion = $this->input->post('duracion');
		$tipo = $this->input->post('tipo');
		$parte = $this->input->post('parte');
		$valFinal = ($this->input->post('parte_de')==null) ? 1 : 0;
		$data_insert = array(
			"nombre" => $nombre,
			"tarifa" => $tarifa,
			"estatus" => 1,
			"fecha_creacion" => date('Y-m-d H:i:s'),
			"creado_por" => $this->session->userdata("inicio_sesion")['id'],
			"tipo" => $tipo,
			"no_sesion" => $sesiones,
			"duracion" => $duracion,
			"clave" => 0,
			"Partes" => $parte,
			"completo" => $valFinal
		);
		/*print_r($data_insert);
		exit;*/
		$request_insert = $this->Areas_model->insertArea($data_insert);
		if($request_insert >= 1 && $valFinal==1)
		{
			$last_insert_id = $this->db->insert_id();
			$data_update = array(
				"Partes" => $last_insert_id
			);
			$table = 'areas';
			$request_upd = $this->Areas_model->updateGeneral($table, $data_update, $last_insert_id);
			if($request_upd >= 1)
			{
				$data['success'] = 1;
				$data['message'] = 'Se añadió exitosamente el área';
			}
			else{
				$data['success'] = 0;
				$data['message'] = 'Ocurrio un error al actualizar [Partes] del área ID'.$last_insert_id.' intentalo nuevamente';
			}
		}
		else{
			if($request_insert >= 1)
			{
				$data['success'] = 1;
				$data['message'] = 'Se añadió exitosamente el área.';
			}
			else
			{
				$data['success'] = 0;
				$data['message'] = 'Ocurrio un error al añadir el área, intentalo nuevamente.';
			}
		}

		if($data != null) {
			echo json_encode($data);
		} else {
			echo json_encode(array());
		}
	}
}
