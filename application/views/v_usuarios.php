<?php
require "header.php";
require "menu.php";
?>
<style>
	#table_usuarios_filter{
		display: block;
	}
	#table_usuarios_paginate{
		position: absolute;
		right: 0;
	}


	.btn-cir {
		border-radius: 50%;
		border-width: 1px;
		border-style: solid;
		margin-right:2px;
	}

	.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
		color: white !important;
		border: 0px solid #111;
		background-color: transparent;
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, transparent), color-stop(100%, transparent));
		background: -webkit-linear-gradient(top, transparent 0%, transparent 100%);
		background: -moz-linear-gradient(top, transparent 0%, transparent 100%);
		background: -ms-linear-gradient(top, transparent 0%, transparent 100%);
		background: -o-linear-gradient(top, transparent 0%, transparent 100%);
		background: linear-gradient(to bottom, transparent 0%, transparent 100%);
	}

	.paginate_button a:focus{
		outline: none!important;
		border: none!important;
	}
	.form-inline {
		display: -ms-flexbox;
		display: block;
		-ms-flex-flow: row wrap;
		flex-flow: row wrap;
		-ms-flex-align: center;
		align-items: center;
	}
</style>

<div id="editar_usuario" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-body">
				<h5>Actualizando usuario <b id="nombre_user"></b></h5>

				<form name="update_user" id="update_user" >
					<div class="row">
						<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
							<label>Nombre:</label>
							<input type="text" name="nombre" class="form-control" id="nombre" required>
						</div>
						<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
							<label>Apellido Paterno:</label>
							<input type="text" name="ap_paterno" class="form-control" id="ap_paterno" required>
						</div>
						<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
							<label>Apellido Materno:</label>
							<input type="text" name="ap_materno" class="form-control" id="ap_materno" required>
						</div>
					</div>
					<div class="row" style="padding-top: 30px;">
						<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
							<label>Correo:</label>
							<input type="email" name="correo" class="form-control" id="correo" required>
						</div>
						<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
							<label>Usuario:</label>
							<input type="text" name="usuario" class="form-control" id="usuario" required>
						</div>
						<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
							<label>Contraseña:</label>
							<input type="text" name="password" class="form-control" id="password" required>
						</div>
					</div>
					<div class="row" style="padding-top: 30px;">
						<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
							<label>Teléfono:</label>
							<input type="text" name="telefono" class="form-control" id="telefono" required>
						</div>
						<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
							<label>Edad:</label>
							<input type="text" name="edad" class="form-control" id="edad" required>
						</div>
						<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
							<label>Dirección:</label>
							<input type="text" name="direccion" class="form-control" id="direccion" required>
						</div>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top: 30px;">
						<label>Tipo de usuario</label>
						<select class="select form-control" name="tipo_usuario" id="tipo_usuario">
							<!--<option value="3">Enfermero</option>
							<option value="2">Ventas</option>
							<option value="6">Control interno</option>-->
						</select>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top: 20px;">
						<center>
							<input type="hidden" name="id_usuario" id="id_usuario">
							<button type="submit" class="btn btn-success" id="add_boton">ACTUALIZAR</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
						</center>
					</div>
				</form>
			</div>
			<div class="modal-footer">
			</div>
		</div>

	</div>
</div>

<div class="content">
	<div class="container-fluid">
		<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<p style="font-size: 1.5em;font-weight: 100;text-align: center">ADMINISTRACIÓN DE USUARIOS</p>
			<br><br>
			<a class="btn btn-outline-success" href="<?=base_url()?>index.php/Usuarios/nuevo_usuario">Añadir usuario</a>
			<div class="table-responsive">
				<table id="table_usuarios" class="table table-striped table-bordered"  cellspacing="0" width="100%" style="width: 100%">
					<thead>
						<th>NOMBRE</th>
						<th>CORREO</th>
						<th>USUARIO</th>
						<th>TELÉFONO</th>
						<th>ACCIONES</th>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>

<?php
require "footer.php";
?>
<script>
	$('#table_usuarios').DataTable({
		"ajax":
		{
			"url": '<?=base_url()?>index.php/Usuarios/get_users',
			"dataSrc": ""
		},
		paging: true,
		info : true,
		pagingType: "full_numbers",
		autoWidth: true,
		searching: true,
		pageLength: 10,
		bLengthChange: false,
		language: {
			url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
		},
		lengthChange: true,
		orderable: false,
		"columns": [
			{
				"data": function( d ){
					var lbl_estatus = '';
					if(d.estatus == 0)
					{
						lbl_estatus = '<small style="padding: 4px;background-color: red;color: white;width: fit-content;border-radius: 3px;font-size: 0.7em;">INACTIVO</small>';
					}

					else {
						lbl_estatus = '<small style="padding: 4px;background-color: green;color: white;width: fit-content;border-radius: 3px;font-size: 0.7em;">ACTIVO</small>';
					}
					var nombre = d.nombre + " " + d.apellido_paterno + " " + d.apellido_materno + ' ' + lbl_estatus;
					return '<center>'+nombre+'</center>';
				}
			},
			{
				"data": function( d ){
					return d.correo;
				}
			},
			{
				"data": function( d ){
					return d.usuario;
				}
			},
			{
				"data": function( d ){
					return d.telefono;
				}
			},
			{
				"data": function( d ){

					var btn_status;
					var btn_editar;

					if(d.estatus==1)
					{
						btn_status = '<button href="#" class="btn btn-simple btn-link btn-icon btn-cir" ' +
							'style="border-color:#D73939;color:#D73939;" title="Inabilitar usuario" onclick="confirma_borrado('+d.id_usuario+')">' +
							'<i class="fa fa-trash" aria-hidden="true"></i></button>';
						btn_editar = '<button href="#" class="btn btn-simple btn-link btn-icon btn-cir edit_usuario" ' +
							'style="border-color:#69DEB1;color:#69DEB1;margin-right:10px" title="Ver datos cliente" data-idusuario="'+d.id_usuario+'">' +
							'<i class="fa fa-pencil" aria-hidden="true"></i></button>';
					}
					else {
						btn_editar = '';
						btn_status = '<button href="#" class="btn btn-simple btn-link btn-icon btn-cir" ' +
							'style="border-color:#ff9103;color:#ff9103;" title="" onclick="confirma_reactivacion('+d.id_usuario+')">' +
							'<i class="fa fa-refresh" aria-hidden="true"></i></button>';
					}


					return btn_editar + btn_status;
				}
			},
		],
	});

	function confirma_borrado(id_usuario)
	{
			var bool=confirm("¿Realmente desea eliminar este usuario?");

			if(bool){
				$.post("<?=base_url()?>index.php/Usuarios/delete_user/"+id_usuario, function(data) {
					// console.log(data);
					if(data >= 1){
						jQuery("#modal_exito").modal("show");
						$('#table_usuarios').DataTable().ajax.reload();
					}
					else {
						jQuery("#modal_fail").modal("show");
						$('#table_usuarios').DataTable().ajax.reload();
					}
				},'json');
			}else{
				jQuery("#modal_fail").modal("show");
			}
	}

	function confirma_reactivacion(id_usuario)
	{
		var bool=confirm("¿Realmente desea habilitar este usuario?");

		if(bool){
			$.post("<?=base_url()?>index.php/Usuarios/renew_user/"+id_usuario, function(data) {
				// console.log(data);
				if(data >= 1)
				{
					alert("se habilitó correctamente");
					$('#table_usuarios').DataTable().ajax.reload();
				}
				else {
					alert("Ocurrió un error al ejecutar la operación, intentalo más tarde");
					$('#table_usuarios').DataTable().ajax.reload();
				}


			},'json');
		}else{

		}
	}
	$(document).on('click', '.edit_usuario', function () {
		var $itself = $(this);
		var id_usuario = $itself.attr('data-idusuario');
		// console.log(id_usuario);

		$.post("<?=base_url()?>index.php/Usuarios/getinfoById/"+id_usuario, function(data) {
			console.log(data);
			console.log(data.nombre);
			$('#nombre').val(data.nombre);
			$('#ap_paterno').val(data.apellido_paterno);
			$('#ap_materno').val(data.apellido_materno);
			$('#correo').val(data.correo);
			$('#usuario').val(data.usuario);
			$('#password').val(data.contrasena);
			$('#telefono').val(data.telefono);
			$('#edad').val(data.edad);
			$('#direccion').val(data.direccion);
			$('#id_usuario').val(data.id_usuario);

			if(data.id_rol == 3)
			{
				$('#tipo_usuario').append( '<option selected value="'+data.id_rol+'">Enfermera</option>' );
				$('#tipo_usuario').append( '<option value="2">Ventas</option>' );
				$('#tipo_usuario').append( '<option value="6">Control interno</option>' );
			}
			else if(data.id_rol == 2)
			{
				$('#tipo_usuario').append( '<option selected value="'+data.id_rol+'">Ventas</option>' );
				$('#tipo_usuario').append( '<option value="3">Enfermera</option>' );
				$('#tipo_usuario').append( '<option value="6">Control interno</option>' );
			}
			else if(data.id_rol == 6)
			{
				$('#tipo_usuario').append( '<option selected value="'+data.id_rol+'">Control interno</option>' );
				$('#tipo_usuario').append( '<option value="3">Enfermera</option>' );
				$('#tipo_usuario').append( '<option value="2">Ventas</option>' );
			}
			else {
				$('#tipo_usuario').append( '<option disabled selected>--SELECCIONA UNA OPCIÓN--</option>' );
				$('#tipo_usuario').append( '<option value="6">Control interno</option>' );
				$('#tipo_usuario').append( '<option value="3">Enfermera</option>' );
				$('#tipo_usuario').append( '<option value="2">Ventas</option>' );
			}

			$('#editar_usuario').modal();
		}, 'json');
	});
	/******************/
	$('#editar_usuario').on('hidden.bs.modal', function () {
		$("#tipo_usuario").empty();
	})
	/******************/
	$("#update_user").on('submit', function (e) {
		e.preventDefault();

		$.ajax({
			type: 'POST',
			url: '<?=base_url()?>index.php/Usuarios/update_user',
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			beforeSend: function () {
				$('#add_boton').attr("disabled", "disabled");
				$('#add_boton').css("opacity", ".5");

			},
			success: function (data) {
				console.log(data);
				if (data == 1) {
					$('#add_boton').prop('disabled', false);
					$('#add_boton').css("opacity", "1");
					alert("Se ha actualizado correctamente");
					//$('#tableBonificaciones').DataTable().ajax.reload();
					// alerts.showNotification('top', 'right', 'Se ha rechazado la bonificación', 'success');

					$('#update_user').trigger("reset");
					$('#editar_usuario').modal('hide');
					$('#table_usuarios').DataTable().ajax.reload();
				} else {
					$('#add_boton').prop('disabled', false);
					$('#add_boton').css("opacity", "1");
					alert("Asegúrate de haber llenado todos los campos mínimos requeridos");
					//toastr.error("Asegúrate de haber llenado todos los campos mínimos requeridos");
					//alerts.showNotification('top', 'right', 'Asegúrate de haber llenado todos los campos mínimos requeridos', 'danger');/
				}
			},
			error: function (data) {
				$('#add_boton').prop('disabled', false);
				$('#add_boton').css("opacity", "1");
				alert("ops, algo salió mal, intentalo de nuevo ["+data+"]");
				//toastr.error("ops, algo salió mal.");
				//alerts.showNotification('top', 'right', 'ops, algo salió mal, intentalo de nuevo', 'danger');
			}
		});
	});




</script>
