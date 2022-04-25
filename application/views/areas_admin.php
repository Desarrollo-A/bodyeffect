<?php
require("header.php");
$page = 'inicio';
require("menu.php");
?>


	<style>
		#table_areas th{
			text-align: center;
		}
		#table_areas_filter {
			display: none;
		}
		.hide
		{
			display: none;
		}

		#table_areas_paginate {
			position: absolute;
			right: 0;
			top: 100%;
		}

		.btn-body {
			border-radius: 25px;
			color: white;
			border: none;
			background-color: #bd98e0;
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

		.paginate_button a:focus {
			outline: none !important;
			border: none !important;
		}
		.btn-round {
			border-width: 1px;
			border-radius: 30px !important;
			padding: 10px 10px;
		}
		.btn-youtube.btn-outline {
			color: #e52d27;
			background-color: transparent;
			border: 1px solid #e52d27;
		}
		.btn-youtube.btn-outline:hover, .btn-youtube.btn-outline:focus, .btn-youtube.btn-outline:active, .btn-youtube.btn-outline.active, .open>.btn-youtube.btn-outline.dropdown-toggle {
			background-color: #c21d17;
			color: #FFFFFF;
			border: 1px solid #c21d17;
		}
		.btn-linkedin.btn-outline {
			color: #0976b4;
			background-color: transparent;
			border: 1px solid #0976b4;
		}
		.btn-linkedin.btn-outline:hover, .btn-linkedin.btn-outline:focus, .btn-linkedin.btn-outline:active, .btn-linkedin.btn-outline.active, .open>.btn-linkedin.btn-outline.dropdown-toggle {
			background-color: #075683;
			color: #FFFFFF;
			border: 1px solid #075683;
		}
		#nombre-error
		{
			color:red;
		}
		#tarifa-error
		{
			color: red;
		}
		#sesiones-error
		{
			color: red;
		}
		#duracion-error
		{
			color: red;
		}
		#tipo-error
		{
			color: red;
		}
	</style>
<!-- End Navbar -->

		<div class="modal fade" id="addArea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Nueva Área</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form name="nuevaAreaFrm" id="nuevaAreaFrm">
							<div class="row" style="padding-top: 25px">
								<div class="col-md-4 form-group">
									<label>* Nombre</label>
									<input class="form-control field-disabld" name="nombre" placeholder="Nombre"
										   autocomplete="off" maxlength="100"
										   oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
								</div>
								<div class="col-md-4 form-group">
									<label>* Tarifa</label>
									<input class="form-control field-disabld" name="tarifa" placeholder="1500"
										   autocomplete="off" maxlength="100"
										   oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
								</div>
								<div class="col-md-4 form-group">
									<label>* Sesiones</label>
									<input class="form-control field-disabld" name="sesiones" placeholder="5"
										   autocomplete="off" maxlength="100"
										   oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
								</div>
								<div class="col-md-3 form-group">
									<label>* Duración (min)</label>
									<input class="form-control field-disabld" name="duracion" placeholder="40"
										   autocomplete="off" maxlength="100"
										   oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
								</div>
								<div class="col-md-4 form-group">
									<label>Tipo:</label>
									<select class="form-control " name="tipo" id="tipo" onchange="loadPartesNA();">
										<option selected disabled>Selecciona un tipo</option>
										<option value="1">Depilación</option>
										<option value="2">Moldeo</option>
									</select>
								</div>
								<div class="col-md-4 form-group" style="padding-top: 36px;text-align: center">
									<label for="parte_de">¿Parte de otra zona? <input type="checkbox" name="parte_de" id="parte_de" onchange="checkParteNA()"></label>
								</div>
							</div>
							<div class="row hide" id="form_extra" style="margin-top: 50px">
								<div class="col-md-4 form-group">
									<label>¿A qué parte del cuerpo pertenece?</label>
									<select name="parte" class="form-control" id="parte">

									</select>
								</div>
							</div>
							<div class="row" style="padding-top: 30px">
								<div class="col col-xs-12 col-sm-12 col-md-12  col-lg-12">
									<center>
										<button class="btn btn-primary" id="btnSave">Guardar</button>
										<br><br>
									</center>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer hide">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade modal-mini modal-primary" id="eliminar_modal" tabindex="-1" role="dialog"
			 aria-labelledby="myModalLabel">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header justify-content-center">
						<div class="modal-profile">
							<i class="nc-icon nc-simple-remove"></i>
						</div>
					</div>
					<div class="modal-body text-center">
						<p>¿Realmente desea eliminar esta área?</p>
						<div class="modal-footer" style="justify-content: center;">
							<!--<button type="button" class="btn btn-link btn-simple">Back</button>-->
							<center>
								<button type="button" class="btn btn-link btn-simple confirmEliminar" id="confirmEliminar"
										data-dismiss="modal" style="color:red">Eliminar
								</button>
								<button type="button" class="btn btn-link btn-simple" data-dismiss="modal">Cerrar</button>
							</center>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Editar -->
		<div class="modal fade" id="editarAreaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
			 aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Editar Area</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form name="formEditaArea" id="formEditaArea">
							<div class="row" style="padding-top: 25px">
								<div class="col-md-4 form-group">
									<label>* Nombre</label>
									<input class="form-control field-disabld" name="nombreE" id="nombreE" placeholder="Nombre"
										   autocomplete="off" maxlength="100"
										   oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
								</div>
								<div class="col-md-4 form-group">
									<label>* Tarifa</label>
									<input class="form-control field-disabld" name="tarifaE" id="tarifaE" placeholder="1500"
										   autocomplete="off" maxlength="100"
										   oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
								</div>
								<div class="col-md-4 form-group">
									<label>* Sesiones</label>
									<input class="form-control field-disabld" name="sesionesE" id="sesionesE" placeholder="5"
										   autocomplete="off" maxlength="100"
										   oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
								</div>
								<div class="col-md-3 form-group">
									<label>* Duración (min)</label>
									<input class="form-control field-disabld" name="duracionE" id="duracionE" placeholder="40"
										   autocomplete="off" maxlength="100"
										   oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
								</div>
								<div class="col-md-4 form-group">
									<label>Tipo:</label>
									<select class="form-control " name="tipoE" id="tipoE" onchange="loadPartes();"></select>
								</div>
								<div class="col-md-4 form-group" style="padding-top: 36px;text-align: center">
									<label for="parte_deE">¿Parte de otra zona? <input type="checkbox" name="parte_deE"
																					  id="parte_deE" onchange="checkParte();"></label>
								</div>
							</div>
							<div class="row hide" id="form_extraE" style="margin-top: 50px">
								<div class="col-md-4 form-group">
									<label>¿A qué parte del cuerpo pertenece?</label>
									<select name="parteE" class="form-control" id="parteE">

									</select>
								</div>
							</div>
							<div id="noPartDiv"></div>
							<div class="row" style="padding-top: 30px">
								<div class="col col-xs-12 col-sm-12 col-md-12  col-lg-12">
									<center>
										<input type="hidden" name="id_areaE" id="id_areaE">
										<button class="btn btn-primary" id="saveEditArea">Guardar</button>
										<br><br>
									</center>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer hide">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</div>
		</div>

		<div class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col" style="background-color: #FFF">
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<center>
								<h3>Administracion de áreas</h3>
							</center>
							<div class="row" style="padding-top: 25px">
								<div class="table">
									<button class="btn btn-primary add_area"><i class="nc-icon nc-simple-add"></i> Área</button><br><br>
									<table id="table_areas" class="table-responsive" width="100%" >
										<thead>
											<th>Nombre</th>
											<th>Tarifa</th>
											<th>Tipo</th>
											<th>Duración</th>
											<th>estatus</th>
											<th>Acciones</th>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<!-- background-image: url(https://localhost:9081/bodyeff/assets/img/opcion_body_efect_3.jpg); -->
	</div>
<?php include("footer.php")?>
</div>
</div>
</body>
<script>
var listaAreas;
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();

		listaAreas = $('#table_areas').DataTable({
			ajax:{
				"url": "<?=base_url()?>index.php/Areas/getAreas",/*getAreas*/
				"dataSrc": ""
			},
			dom: '<"bottom"i>rt<"top"flp><"clear">',
			paging: true,
			info: false,
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
			"columnDefs": [
				{"orderable": false, "targets": 5}
			],
			"buttons": [
				'colvis',
				'copyHtml5',
				'csvHtml5',
				'excelHtml5',
				'pdfHtml5',
				'print'
			],
			drawCallback: function (settings) {
				$(".dropdown-toggle").dropdown();
				$('[data-toggle="tooltip"]').tooltip();
			},
			"columns": [
				{
					"data": function (d) {
						var nombre = '<center>'+d.nombre+'</center>';
						return nombre;
					}
				},
				{
					"data": function (d) {
						var tarifa = '<center>'+d.tarifa+'</center>';
						return tarifa;
					}
				},
				{
					"data": function (d) {
						var tipo = (d.tipo==1) ? 'Depilación' : 'Moldeo';
						return tipo;
					}
				},
				{

					"data": function (d) {
						var duracion = '<center>' + d.duracion + '</center>';
						return duracion;
					}
				},
				{
					"data": function (d) {
						var estatus = (d.estatus == 1) ? '<label class="label-success" class="label-success m-0" style="width: 60%;background-color: #BD98E0;color:white;border-radius: 12px; font-size: 14px">Activo</label>' : '<label class="label-success" class="label-success m-0"  style="width: 60%;background-color: #b3b3b3;color:white;border-radius: 12px; font-size: 14px">Inactivo</label>';
						return '<center>'+estatus+'</center>';
					}
				},
				{
					"data": function (d) {
						var actions = '';
						var btnEdit = '';
						var btnDelete = '';
						var btnReactivate = '';


						if(d.estatus == 1)
						{
							btnEdit = '<button class="btn btn-social btn-round btn-linkedin btn-outline editar" data-toggle="tooltip" data-placement="top" title="Editar" data-idArea="'+d.id_area+'">\n' +
								'           	<i class="fa fa-pencil"> </i>\n' +
								'			</button>';
							btnDelete = '<button class="btn btn-social btn-round btn-youtube btn-outline eliminar" data-toggle="tooltip" data-placement="top" title="Eliminar" data-idArea="'+d.id_area+'">\n' +
								'                 <i class="fa fa-trash"> </i>\n' +
								'            </button>';
							actions = '<center>'+btnEdit+'  '+btnDelete+'  </center>';
						}
						else
						{
							btnReactivate = '<button class="btn btn-social btn-round btn-linkedin btn-outline reactivar" data-toggle="tooltip" data-placement="top" title="Reactivar" data-idArea="'+d.id_area+'">\n' +
								'           	<i class="fa fa-refresh"> </i>\n' +
								'			</button>';
							actions = '<center>' + btnReactivate + '</center>';
						}

						return actions;
					}
				}
			],
		});


		$("#nuevaAreaFrm").validate({
			rules: {
				nombre : {
					required: true,
					minlength: 3
				},
				tarifa: {
					required: true,
					number: true,
					min: 18
				},
				sesiones: {
					required: true,
					number: true,
					min:1
				},
				duracion:{
					required:true
				},
				tipo:{
					required:true
				}
			},
			messages: {
				nombre:'Debes ingresar un nombre.',
				tarifa:'Debes ingresar una tarifa.',
				sesiones:'Debes ingresar un numero de sesiones.',
				duracion:'Debes ingresar la duración.',
				tipo:'Elige un tipo.'
			}
		});
	});


	function loadPartes()
	{
		$("#parteE").empty();

		var tipo = $("#tipoE").val();
		$.post("<?=base_url()?>index.php/Areas/getAreasByTipo/"+tipo, function (data) {
			var $selectParte = $("#parteE");
			$.each(data, function(index, value) {
				$selectParte.append($("<option>").val(value.id_area).text(value.nombre));
			});

		}, 'json');
	}
	function checkParte()
	{
		if($('#parte_deE:checkbox:checked').length > 0)
		{
			$('#form_extraE').removeClass('hide');
			$('#noPartDiv').html('');
		}
		else {
			$('#form_extraE').addClass('hide');
			var id_area = $('#id_areaE').val();
			$('#noPartDiv').append('<input type="hidden" value="'+id_area+'" name="parteE" id="parteE"/>');
		}
	}
	$(document).on('click', '.editar', function(){
		var $itself = $(this);

		var id_area = $itself.attr('data-idArea');
		console.log('editar ' + id_area);
		$.post("<?=base_url()?>index.php/Areas/get_areasById/"+id_area, function(data) {
			console.log(data);
			$('#nombreE').val(data[0].nombre);
			$('#tarifaE').val(data[0].tarifa);
			$('#sesionesE').val(data[0].no_sesion);
			$('#duracionE').val(data[0].duracion);
			// $('tipoE').val(data.tipo);
			// $('parte_deE').val();
			$('#parteE').val(data[0].partes);
			$('#id_areaE').val(data[0].id_area);
			$("#tipoE").empty();


			$('#tipoE').append($('<option selected>').val('').text('Selecciona un tipo'));
			if(data[0].tipo == 1)
			{
				$('#tipoE').append($('<option selected>').val(1).text('Depilación'));
				$('#tipoE').append($('<option>').val(2).text('Moldeo'));
			}
			else
			{
				$('#tipoE').append($('<option>').val(1).text('Depilación'));
				$('#tipoE').append($('<option selected>').val(2).text('Moldeo'));
			}

			if(data[0].id_area != data[0].Partes)
			{
				$('#noPartDiv').html('');
				$('#parte_deE').prop('checked', true);
				$('#form_extraE').removeClass('hide');
				$("#parteE").empty();

				$.post("<?=base_url()?>index.php/Areas/getAreasByTipo/"+data[0].tipo, function (data_2) {
					var $selectParte = $("#parteE");
					$.each(data_2, function(index, value) {
						if(value.id_area == data[0].Partes)
						{
							$selectParte.append($("<option selected>").val(value.id_area).text(value.nombre));
						}
						else {
							$selectParte.append($("<option>").val(value.id_area).text(value.nombre));
						}
					});

				}, 'json');
			}
			else {
				$('#form_extraE').addClass('hide');
				$('#parte_deE').prop('checked', false);
				/*añadir input hide para cuando no haya zona no sea completo*/
				$('#noPartDiv').append('<input type="hidden" value="'+data[0].id_area+'" name="parteE" id="parteE"/>');
			}

		}, 'json');

		$('#editarAreaModal').modal('toggle');

	});
	$(document).on('click', '.eliminar', function(){
		var $itself = $(this);

		var id_area = $itself.attr('data-idArea');
		$('#confirmEliminar').attr('data-idArea', id_area);
		$('#eliminar_modal').modal('toggle');
		// console.log('Elimina esta madre ' + id_area);
	});

	$(document).on('click', '.confirmEliminar', function(){
		var $itself = $(this);

		var id_area = $itself.attr('data-idArea');
		// console.log('voy a submitear este: '+id_area);
		var data = new FormData();
		data.append('id_area', id_area);
		$.ajax({
			type: 'POST',
			url: '<?=base_url()?>index.php/Areas/deleteArea',
			data: data,
			dataType:'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function(){
				$('#confirmEliminar').attr("disabled","disabled");
				$('#confirmEliminar').css("opacity",".5");

			},
			success: function(data) {
				if (data.success == 1) {
					$('#confirmEliminar').prop('disabled', false);
					$('#confirmEliminar').css("opacity","1");
					$('#eliminar_modal').modal("hide");
					//toastr.success("Se enviaron las autorizaciones correctamente");
					$('#table_areas').DataTable().ajax.reload();
					alert(data.message);
				} else {
					$('#confirmEliminar').prop('disabled', false);
					$('#confirmEliminar').css("opacity","1");
					//toastr.error("Asegúrate de haber llenado todos los campos mínimos requeridos");
					alert(data.message);
				}
			},
			error: function(){
				$('#confirmEliminar').prop('disabled', false);
				$('#confirmEliminar').css("opacity","1");
				//toastr.error("ops, algo salió mal.");
				alert('ops, algo salió mal, intentalo de nuevo');
			}
		});
	});


	$(document).on('click', '.reactivar', function(){
		var $itself = $(this);

		var id_area = $itself.attr('data-idArea');
		// console.log('voy a submitear este: '+id_area);
		var data = new FormData();
		data.append('id_area', id_area);
		$.ajax({
			type: 'POST',
			url: '<?=base_url()?>index.php/Areas/reactivateArea',
			data: data,
			dataType:'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function(){
				$('.reactivar').attr("disabled","disabled");
				$('.reactivar').css("opacity",".5");

			},
			success: function(data) {
				if (data.success == 1) {
					$('.reactivar').prop('disabled', false);
					$('.reactivar').css("opacity","1");
					$('#eliminar_modal').modal("hide");
					//toastr.success("Se enviaron las autorizaciones correctamente");
					$('#table_areas').DataTable().ajax.reload();
					alert(data.message);
				} else {
					$('.reactivar').prop('disabled', false);
					$('.reactivar').css("opacity","1");
					//toastr.error("Asegúrate de haber llenado todos los campos mínimos requeridos");
					alert(data.message);
				}
			},
			error: function(){
				$('.reactivar').prop('disabled', false);
				$('.reactivar').css("opacity","1");
				//toastr.error("ops, algo salió mal.");
				alert('ops, algo salió mal, intentalo de nuevo');
			}
		});
	});



	/*formEditaArea*/
	$("#formEditaArea").on('submit', function(e){
		e.preventDefault();

		$.ajax({
			type: 'POST',
			url: '<?=base_url()?>index.php/Areas/editarArea',
			data: new FormData(this),
			contentType: false,
			dataType:'json',
			cache: false,
			processData:false,
			beforeSend: function(){
				$('#saveEditArea').attr("disabled","disabled");
				$('#saveEditArea').css("opacity",".5");

			},
			success: function(data) {
				if (data.success == 1) {
					$('#saveEditArea').prop('disabled', false);
					$('#saveEditArea').css("opacity","1");
					$('#table_areas').DataTable().ajax.reload();
					alert(data.message);
				} else {
					$('#saveEditArea').prop('disabled', false);
					$('#saveEditArea').css("opacity","1");
					alert(data.message);
				}
				$('#editarAreaModal').modal("hide");
			},
			error: function(){
				$('#editarAreaModal').modal("hide");
				$('#saveEditArea').prop('disabled', false);
				$('#saveEditArea').css("opacity","1");
				//toastr.error("ops, algo salió mal.");
				alert( 'ops, algo salió mal, intentalo de nuevo');
			}
		});
	});

	/*nueva area*/
	function loadPartesNA()
	{
		$("#parte").empty();

		var tipo = $("#tipo").val();
		$.post("<?=base_url()?>index.php/Areas/getAreasByTipo/"+tipo, function (data) {
			var $selectParte = $("#parte");
			$.each(data, function(index, value) {
				$selectParte.append($("<option>").val(value.id_area).text(value.nombre));
			});

		}, 'json');
	}
	function checkParteNA()
	{
		if($('#parte_de:checkbox:checked').length > 0)
		{
			$('#form_extra').removeClass('hide');
		}
		else {
			$('#form_extra').addClass('hide');
		}
	}
	$(document).on('click', '.add_area', function(){
		$('#addArea').modal('toggle');
	});

	$("#nuevaAreaFrm").on('submit', function(e){
	e.preventDefault();
	var isvalid = $("#nuevaAreaFrm").valid();
	if (isvalid) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: '<?=base_url()?>index.php/Areas/addArea',
			data: new FormData(this),
			contentType: false,
			dataType:'json',
			cache: false,
			processData:false,
			beforeSend: function(){
				$('#btnSave').attr("disabled","disabled");
				$('#btnSave').css("opacity",".5");

			},
			success: function(data) {
				if (data.success == 1) {
					$('#btnSave').prop('disabled', false);
					$('#btnSave').css("opacity","1");
					$('#table_areas').DataTable().ajax.reload();
					alert(data.message);
				} else {
					$('#btnSave').prop('disabled', false);
					$('#btnSave').css("opacity","1");
					alert(data.message);
				}
				$('#addArea').modal("hide");
				$('#nuevaAreaFrm').trigger("reset");
			},
			error: function(data){
				$('#addArea').modal("hide");
				$('#btnSave').prop('disabled', false);
				$('#btnSave').css("opacity","1");
				//toastr.error("ops, algo salió mal.");
				alert( 'ops, algo salió mal, intentalo de nuevo ['+data+']');
				$('#nuevaAreaFrm').trigger("reset");
			}
		});
	}
});
</script>

</html>
