<?php
require "header.php";
$page = 'expedientes';
require "menu.php";
?>

<style>
	#tabla_expedientes_filter {
		display: none;
	}

	#tabla_expedientes_paginate {
		position: absolute;
		right: 0;
	}

	body .historial {
		max-width: 70%;
	}

	#table_historial_wrapper .row {
		margin: auto;
	}

	.dataTables_wrapper .dataTables_filter {
		margin-left: auto !important;
	}

	.btn-cir {
		border-radius: 50%;
		border-width: 1px;
		border-style: solid;
		margin-right: 2px;
	}

	.classDepilacion {
		background-color: rgb(251, 205, 229) !important;
	}

	.classMoldeo {
		background-color: rgb(189, 152, 224) !important;
	}

	.btn-body {
		border-radius: 25px;
		color: white;
		border: none;
		background-color: #bd98e0;
	}

	.btn-body:hover {
		background-color: white;
		color: #333;
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

	.modal.show .modal-dialog-e {
		-webkit-transform: translate(0, 5%);
		-o-transform: translate(0, 5%);
	}

	.buttons-pdf {
		border-color: #d9534f;
		color: #d9534f;
		background-color: #FFFFFF;
		margin-bottom: 10px;
		border-radius: 25px;
		width: 48px;
		height: 48px;
	}

	.font-size-col {
		font-size: 12px;
	}
</style>

<!-- Estilos para Spinner-->
<style>
	.lds-dual-ring.hidden {
		display: none;
	}

	.lds-dual-ring {
		display: inline-block;
		width: 80px;
		height: 80px;
	}

	.lds-dual-ring:after {
		content: " ";
		display: block;
		width: 64px;
		height: 64px;
		margin: 5% auto;
		border-radius: 50%;
		border: 6px solid #fff;
		border-color: #fff transparent #fff transparent;
		animation: lds-dual-ring 1.2s linear infinite;
	}

	@keyframes lds-dual-ring {
		0% {
			transform: rotate(0deg);
		}
		100% {
			transform: rotate(360deg);
		}
	}

	.overlay {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100vh;
		background-color: #1b021ee6;
		z-index: 9999999;
		opacity: 1;
		transition: all 0.5s;
		display: flex;
		align-items: center;
	}
</style>
<!-- Estilos para Spinner-->

<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="card-header ">
					<h4 class="card-title">Clientes Body Effect</h4>
					<p class="card-category">En este apartado podrás visualizar el historial clínico de cada uno de los
						clientes asi como agregar nueva información a su expediente según sea el caso requerido.</p>
				</div>
				<div class="card-body">
					<table id="tabla_expedientes" class="table table-striped table-bordered" cellspacing="0"
						   width="100%">
						<thead>
						<tr>
							<th style="font-size: .9em;">ID</th>
							<th style="font-size: .9em;">CLIENTE</th>
							<!-- <th style="font-size: .9em;">FECHA CONTRATO</th> -->
							<th style="font-size: .9em;">CORREO</th>
							<th style="font-size: .9em;">TELÉFONO</th>
							<th style="font-size: .9em;">ÁREAS CONTRATADAS</th>
							<th style="font-size: .9em;">
								<center>MÁS</center>
							</th>
						</tr>
						</thead>
					</table>
				</div><!-- END card-body -->
			</div><!-- END col-md-12 -->
		</div><!-- END row -->
	</div><!-- END cotainer-fluid-->
</div><!-- END content -->

<?php require("footer.php"); ?>

</div>
</div>

<div class="modal fade" id="Modal_data_cliente" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-body">
			</div>
		</div>
	</div>
</div>

<div id="Modal_data_expediente_info" class="modal fade modal-dialog-e" role="dialog" aria-hidden="true"
	 data-keyboard="false">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-body"></div>
		</div>
	</div>
</div>

<div id="Modal_registro_expediente" class="modal fade modal-dialog-e" role="dialog" aria-hidden="true"
	 data-keyboard="false">
	<div class="modal-dialog modal-lg" style="-webkit-transform: none; transform: none; max-width:1100px; z-index:999">
		<div class="modal-content">
			<div class="modal-head">
			</div>
			<form method="post" id="form_expediente">
				<div class="modal-body p-0 expediente_body" style="background-color:#F9F9F9"></div>
				<div class="modal-footer expediente_footer"
					 style="padding:30px 15px 15px; background-color:#F9F9F9"></div>
			</form>
			<form method="post" id="form_areas_expediente">
				<div class="modal-body p-0 areas_expediente_body" style="background-color:#F9F9F9"></div>
				<div class="modal-footer areas_expediente_footer"
					 style="padding:30px 15px 15px; background-color:#F9F9F9"></div>
			</form>
		</div>
	</div>
</div>

<div id="Modal_historial_expediente" class="modal fade" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg historial" style="-webkit-transform: none; transform: none">
		<div class="modal-content">
			<div class="modal-body p-0">
			</div>
			<div class="modal-footer text-right" style="align-self: flex-end;">
				<button type="button" class="btn btn-body mt-4" data-dismiss="modal" style="padding: 5px 50px">Cerrar
				</button>
			</div>
		</div>
	</div>
</div>

<div id="Modal_editar_expediente_m" class="modal modal_editar_exp fade" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="-webkit-transform: none; transform: none">
		<div class="modal-content">
			<div class="modal-head">
				<div class="col-md-12" style="padding: 20px 15px; background-color: #c7b1dd" ; border-radius:5px><p
							class="m-0" style="font-size: 16px; color:#FFF">EDITAR REGISTRO EN EXPEDIENTE </p></div>
			</div>
			<div class="modal-body p-0 pt-2 pb-3">
				<form method="post" id="form_editar_m" class="btn-editar">
				</form>
			</div>
		</div>
	</div>
</div>

<div id="Modal_editar_expediente_d" class="modal modal_editar_exp fade" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="-webkit-transform: none; transform: none">
		<div class="modal-content">
			<div class="modal-head">
				<div class="col-md-12" style="padding: 20px 15px; background-color: #c7b1dd" ; border-radius:5px><p
							class="m-0" style="font-size: 16px; color:#FFF">EDITAR REGISTRO EN EXPEDIENTE </p></div>
			</div>
			<div class="modal-body p-0 pt-2 pb-3">
				<form method="post" id="form_editar_d" class="btn-editar">
				</form>
			</div>
		</div>
	</div>
</div>

<!-- HTML para Spinner-->
<div id="loader" class="lds-dual-ring hidden overlay"></div>
<!-- END HTML para Spinner -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="<?= base_url("assets/js/jquery.validate.js") ?>"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

<script>
	$(document).ready(function () {
		var table_historial;

		$('#tabla_expedientes thead tr:eq(0) th').each(function (i) {
			if (i != 5 && i != 0) {
				var title = $(this).text();
				$(this).html('<input type="text" style="width:100%;" placeholder="' + title + '" />');
				$('input', this).on('keyup change', function () {
					if (lista_clientes.column(i).search() !== this.value) {
						lista_clientes
								.column(i)
								.search(this.value)
								.draw();
						var total = 0;
						var index = lista_clientes.rows({selected: true, search: 'applied'}).indexes();
						var data = lista_clientes.rows(index).data();
					}
				});
			}
		});

		lista_clientes = $('#tabla_expedientes').DataTable({
			"ajax": "Expedientes/clientes_servicio",
			dom: '<"bottom"i>rt<"top"flp><"clear">',
			"paging": true,
			"autoWidth": true,
			"searching": true,
			"lengthChange": false,
			"orderable": false,
			"bInfo": false,
			language: {
				url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
			},
			"columnDefs": [
				{"orderable": false, "targets": 5}
			],
			"buttons": [
				'copyHtml5',
				'csvHtml5',
				'excelHtml5',
				'pdfHtml5',
				'print'
			],
			"columns": [
				{
					"width": "5%",
					"data": function (d) {
						return '<p style="font-size: .8em">' + d.id_cliente + '</p>';
					}
				},
				{
					"orderable": false,
					"width": "27%",
					"data": function (d) {
						return '<p style="font-size: .8em">' + d.nombre + '</p>';
					}
				},
				{
					"orderable": false,
					"width": "1%",
					"data": function (d) {
						return '<p style="font-size: .8em">' + d.correo + '</p>';
					}
				},
				{
					"orderable": false,
					"width": "10%",
					"data": function (d) {
						return '<p style="font-size: .8em">' + d.telefono + '</p>';
					}
				},
				{
					"orderable": false,
					"width": "30%",
					"data": function (d) {
						return '<center><p style="font-size: .8em">' + d.valor + '</p></center>';
					}
				},
				{
					"orderable": false,
					"width": "17%",
					"data": function (d) {
						opciones = '<div role="group"><center>';
						opciones += '<button href="#" class="btn btn-simple btn-link btn-icon btn-cir ver_expediente_cliente" style="border-color:#008080;color:#008080;" title="Nuevo registro a expediente" value="' + d.id_cliente + '"><i class="far fa-edit"></i></button>';
						opciones += '<button href="#" class="btn btn-simple btn-link btn-icon btn-cir ver_expediente_HISTORIAL" style="border-color:#70D1E7;color:#70D1E7;" title="Historial Expediente" value="' + d.id_cliente + '"><i class="fas fa-paste"></i></button>';
						return opciones + '</center></div>';
					}
				}
			]
		});

		/******** Botón para agregar entrada a expediente ********/
		// ver_valoracion_cliente
		$("#tabla_expedientes tbody").on("click", ".ver_expediente_cliente", function () {
			$('#loader').removeClass('hidden');
			var searchIDs;
			index_id_cliente = $(this).attr("value");
			$.getJSON("Expedientes/get_areas_cliente/" + index_id_cliente).done(function (data) {
				jQuery.noConflict();
				$('#loader').addClass('hidden');
				if (data.length >= 1) {
					$("#Modal_registro_expediente .modal-head").html("");
					$("#Modal_registro_expediente .areas_expediente_body").show();
					$("#Modal_registro_expediente .areas_expediente_footer").show();
					$("#Modal_registro_expediente .areas_expediente_body").html("");
					$("#Modal_registro_expediente .areas_expediente_footer").html("");
					$("#Modal_registro_expediente .modal-body").html("");
					$("#Modal_registro_expediente .modal-footer").html("");
					jQuery("#Modal_registro_expediente").modal();
					$("#Modal_registro_expediente .modal-head").append('<div class="col-md-12" style="padding: 20px 5px; background-color: #c7b1dd"; border-radius:5px><p class="m-0" style="font-size: 16px; color:#FFF">REGISTRO EN EXPEDIENTE</p><p class="m-0" style="font-size: 24px; color:#FFF">' + data[0].nombrecl + '</p></div>');
					$("#Modal_registro_expediente .areas_expediente_body").append('<div id="dep" class="col-md-12" style="color: #333;"><legend>Áreas</legend></div><br>');
					$.each(data, function (i, v) {
						console.log(v);
						$("#Modal_registro_expediente .areas_expediente_body").find("#dep").append('<input type="checkbox" name="checks[]" data-cl="' + index_id_cliente + '" data-contrato="' + v.id_contrato + '" data-value="' + v.duracion + '" data-servicio="' + v.tipo + '" data-individual="' + v.nombre + '" value="' + v.id_area + '">' + ' ' + v.nombre + ' (' + (v.tipo == 1 ? 'Depilación' : 'Moldeo') + ')<br>');
					})
					$("#Modal_registro_expediente .areas_expediente_footer").append('<div style="display:flex; justify-content:flex-end; width:100%"><button type="submit" class="btn btn-body continue" style="margin-right: 10px;">Continuar</button></div>');

					if (data[0].fotoTipo == null && (data[0].servicio == 1 || data[0].servicio == 3)) {
						$("#Modal_registro_expediente .row").append('<div class="col-md-4 d-flex justify-content-end"><div><p style="margin:0; font-size:12px; color:#fff; text-align:center">FOTOTIPO</p><select name="fotoTipo" required style="border-radius:3px"><option value="F3CFB0" style="background:#F3CFB0;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1</option><option value="E6B48D" style="background:#E6B48D;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2</option><option value="D09E7B" style="background:#D09E7B;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3</option><option value="B8774F" style="background:#B8774F;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4</option><option value="A45D29" style="background:#A45D29;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5</option></select></div></div></div>')
					}
				} else if (data.length <= 0) {
					$("#Modal_registro_expediente .modal-head").html("");
					$("#Modal_registro_expediente .areas_expediente_body").show();
					$("#Modal_registro_expediente .areas_expediente_footer").show();
					$("#Modal_registro_expediente .areas_expediente_body").html("");
					$("#Modal_registro_expediente .areas_expediente_footer").html("");
					$("#Modal_registro_expediente .modal-body").html("");
					$("#Modal_registro_expediente .modal-footer").html("");
					jQuery("#Modal_registro_expediente").modal();
					$("#Modal_registro_expediente .modal-head").append('<div class="col-md-12" style="padding: 20px 5px; background-color: #c7b1dd"; border-radius:5px><p class="m-0" style="font-size: 16px; color:#FFF">REGISTRO EN EXPEDIENTE</p></div>');
					$("#Modal_registro_expediente .areas_expediente_body").append('<center><div id="dep" class="col-md-12" style="color: #333;"><legend>Sin información que mostrar</legend></div></center><br>');
					$("#Modal_registro_expediente .areas_expediente_footer").append('<div style="display:flex; justify-content:flex-end; width:100%"><button type="button" class="btn btn-body" data-dismiss="modal" style="margin-right: 10px;">Cerrar</button></div>');
				}
				var idAgenda;
				$.ajaxSetup({
					async: false
				});
			});
		}); //FIN PRIMER MODAL
		$("#tabla_expedientes tbody").on("click", ".ver_expediente_HISTORIAL", function () {
			$('#loader').removeClass('hidden');
			index_id_cliente = $(this).attr("value");
			$.getJSON("Expedientes/lista_areas_historial/" + index_id_cliente).done(function (data) {
				var codigo = '';
				jQuery.noConflict();
				if (data == '') {
					$('#loader').addClass('hidden');
					$("#Modal_data_expediente_info .modal-body").html("");
					jQuery("#Modal_data_expediente_info").modal();
					$("#Modal_data_expediente_info .modal-body").append("<center><img src='<?= base_url("assets/img/information.png")?>' width='150px;'><br><p>Aún no se ha generado un expediente clínico.</p></center><br><center><button type='button' class='btn btn-body' data-dismiss='modal' style='width:40%'>Cerrar</button></center>");
				} else {
					$('#loader').addClass('hidden');

					if (data[0].fotoTipo == 'F3CFB0') codigo = '1';
					else if (data[0].fotoTipo == 'E6B48D') codigo = '2';
					else if (data[0].fotoTipo == 'D09E7B') codigo = '3';
					else if (data[0].fotoTipo == 'B8774F') codigo = '4';
					else if (data[0].fotoTipo == 'A45D29') codigo = '5';
					$("#Modal_historial_expediente .modal-body").html("");
					jQuery("#Modal_historial_expediente").modal();
					$("#Modal_historial_expediente .modal-body").append('<div class="row" style="padding: 20px 5px; width:100%; margin:auto; background-color: #c7b1dd"><div class="col-md-6"><p class="m-0" style="font-size: 16px; color:#FFF">EXPEDIENTE CLÍNICO</p><p class="m-0" style="font-size: 24px; color:#FFF">' + data[0].name_cliente + '</p></div>');
					if (data[0].fotoTipo != null) {
						$("#Modal_historial_expediente .modal-body .row").append('<div class="col-md-6 d-flex" style="justify-content: flex-end"><div style="background-color: #' + data[0].fotoTipo + '; width: 15%;border-radius: 5px; color: #fff; display: flex; box-shadow: 0 0 7px; align-items:center; justify-content:center"><div><p class="m-0" style="font-size:11px">Fototipo</p><p class="m-0 text-center"><b>' + codigo + '</b></p></div></div></div>');
					}
					$("#Modal_historial_expediente .modal-body").append('<br><div class="row" style="width:100%; margin:auto" background-color: #fff"><div class="col-md-12"><select class="form-control myselect" id="areas"></select</div><br><br><br>');
					$("#Modal_historial_expediente .modal-body #areas").append('<option disabled selected>Seleccione un área.</option>');
					$("#Modal_historial_expediente .modal-body #areas").append('<option value="0" data-idCliente="' + index_id_cliente + '">Seleccionar todas las áreas</option>');
					$.each(data, function (i, v) {
						$("#Modal_historial_expediente .modal-body #areas").append('<option value="' + v.id_area + '" data-idCliente="' + index_id_cliente + '" data-tipo="' + v.tipo + '">' + v.nombre + ' (' + (v.tipo == 1 ? 'Depilación' : v.tipo == 2 ? 'Moldeo' : 'Mixto') + ')' + '</option>')
					});
				}

				$("#Modal_historial_expediente .modal-body").append('<br><div class="box-table" style="padding:0 15px"><table id="table_historial" class="table-striped table-bordered" style="width:100%">' +
						'<thead>' +
						'<tr>' +
						'<th style="font-size: .8em; padding: 5px">Fecha</th>' +
						'<th style="font-size: .8em; padding: 5px">Área</th>' +
						'<th style="font-size: .8em; padding: 5px"># de sesión</th>' +
						'<th style="font-size: .8em; padding: 5px">Fluencia</th>' +
						'<th style="font-size: .8em; padding: 5px">Modo</th>' +
						'<th style="font-size: .8em; padding: 5px">%Vello Restante</th>' +
						'<th style="font-size: .8em; padding: 5px">Temp. Inicial</th>' +
						'<th style="font-size: .8em; padding: 5px">% Inicial de RF</th>' +
						'<th style="font-size: .8em; padding: 5px">Duración</th>' +
						'<th style="font-size: .8em; padding: 5px">% final de RF</th>' +
						'<th style="font-size: .8em; padding: 5px">Duración</th>' +
						'<th style="font-size: .8em; padding: 5px">Observaciones</th>' +
						'<th style="font-size: .8em; padding: 5px">Tipo</th>' +
						'<th style="font-size: .8em; padding: 5px">Responsable</th>' +
						'<th style="font-size: .8em; padding: 5px">Más</th>' +
						'</tr>' +
						'</thead></table></div>');
			});

			$(document).on('change', '#areas', function (e) {
				e.preventDefault();
				e.stopImmediatePropagation();
				table_historial = jQuery('#table_historial').DataTable();
				var idArea = $(this).val();
				var cliente = $(this).find(':selected').attr('data-idCliente');
				if (idArea == 0) {
					var columns = [{
						"data": "fecha_sesion",
						"title": "Fecha",
						"className": 'font-size-col',
						"visible": true
					},
						{"data": "nombre", "title": "Área", "className": 'font-size-col', "visible": false},
						{"data": "row", "title": "# de sesión", "className": 'font-size-col', "visible": true},
						{
							"data": "potencia", "title": "Fluencia", "className": 'font-size-col', "visible": true,
							"render": function (data, type, row) {
								if (data == 0 || data == null) return 'N/A';
								else return data;
							}
						},
						{
							"data": "frecuencia", "title": "Modo", "className": 'font-size-col', "visible": true,
							"render": function (data, type, row) {
								if (data == 0 || data == null) return 'N/A';
								else return data;
							}
						},
						{
							"data": "bello_restante",
							"title": "%Vello Restante",
							"className": 'font-size-col',
							"visible": true,
							"render": function (data, type, row) {
								if (data == 0 || data == null) return 'N/A';
								else return data + '%';
							}
						},
						{
							"data": "tempIni", "title": "Temp. Inicial", "className": 'font-size-col', "visible": true,
							"render": function (data, type, row) {
								if (data == 0 || data == null) return 'N/A';
								else return data;
							}
						},
						{
							"data": "tempFin", "title": "Temp. Final", "className": 'font-size-col', "visible": true,
							"render": function (data, type, row) {
								if (data == 0 || data == null) return 'N/A';
								else return data;
							}
						},
						{
							"data": "rfIni", "title": "% Inicial de RF", "className": 'font-size-col', "visible": true,
							"render": function (data, type, row) {
								if (data == 0 || data == null) return 'N/A';
								else return data + '%';
							}
						},
						{
							"data": "rfFin", "title": "% final de RF", "className": 'font-size-col', "visible": true,
							"render": function (data, type, row) {
								if (data == 0 || data == null) return 'N/A';
								else return data + '%';
							}
						},
						{"data": "duracion", "title": "Duración", "className": 'font-size-col', "visible": true},
						{
							"data": "observaciones",
							"title": "Observaciones",
							"className": 'font-size-col',
							"visible": true
						},
						{"data": "tipo", "title": "Tipo", "className": 'font-size-col', "visible": false},
						{"data": "name", "title": "Responsable", "className": 'font-size-col', "visible": true},
						{
							"title": "Más",
							"visible": true,
							"data": function (data) {

								opciones = '<div role="group"><center>';
								opciones += '<button href="#" class="btn btn-simple btn-link btn-icon btn-cir editar_expediente" style="border-color:#008080;color:#008080;" title="Editar entrada de expediente" value="' + data.id_clinico + '" data-tipo="' + data.tipo + '"><i class="fa fa-pencil" aria-hidden="true"></i></button>';
								return opciones + '</center></div>';
							}
						}
					];

					table_historial.destroy();
					table_historial = jQuery('#table_historial').DataTable({
						"ajax": {
							"url": "Expedientes/historial_expediente_todo/",
							"type": "POST",
							"processing": true,
							"serverSide": true,
							"data": {cliente: cliente},
							"dataSrc": "",
						},
						language: {
							url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
						},
						"columns": columns,
						"order": [[1, 'asc'], [12, 'asc']],
						"rowGroup": {
							"startRender": function (rows, group) {
								var color = (group == 1 ? 'rgb(251,205,229)' : group == 2 ? 'rgb(189,152,224)' : 'black');
								return (group == 1 ? '<label style="font-size: 1em; background:' + color + '; color:black;  width:100%; : 2px; border-radius:15px;"><b>&nbsp;&nbsp;DEPILACIÓN &nbsp;&nbsp;</b></label>' : group == 2 ? '<label style="font-size: 1em; background:' + color + '; color:black; width:100%; : 2px; border-radius:15px;"><b>&nbsp;&nbsp;MOLDEO &nbsp;&nbsp;</b></label>' : group);
							},
							"dataSrc": ["nombre", "tipo"],
						},
						"dom": "<'row col-md-12'<'col-md-4'B><'col-md-8 p-0'f>><'row col-md-12 p-0'<'col-md-12 p-0't>><'row col-md-12 p-0'<'col-md-4'i><'col-md-8'p>>",
						"autoWidth": true,
						"paging": true,
						"bInfo": true,
						"buttons": [
							{"extend": 'pdfHtml5', "orientation": 'landscape', "title": 'Expediente clinico'}
						]
					});
				} else {
					var tipo = $(this).find(':selected').attr('data-tipo');
					console.log("el tipo: " + tipo);
					if (tipo == 2) {
						var columns = [{
							"data": "fecha_sesion",
							"title": "Fecha",
							"className": 'font-size-col',
							"visible": true
						},
							{"data": "nombre", "title": "Área", "className": 'font-size-col', "visible": false},
							{"data": "row", "title": "# de sesión", "className": 'font-size-col', "visible": true},
							{"data": "potencia", "title": "Fluencia", "className": 'font-size-col', "visible": false},
							{"data": "frecuencia", "title": "Modo", "className": 'font-size-col', "visible": false},
							{
								"data": "bello_restante",
								"title": "%Vello Restante",
								"className": 'font-size-col',
								"visible": false
							},
							{
								"data": "tempIni",
								"title": "Temp. Inicial",
								"className": 'font-size-col',
								"visible": true
							},
							{"data": "tempFin", "title": "Temp. Final", "className": 'font-size-col', "visible": true},
							{
								"data": "rfIni",
								"title": "% Inicial de RF",
								"className": 'font-size-col',
								"visible": true
							},
							{"data": "rfFin", "title": "% final de RF", "className": 'font-size-col', "visible": true},
							{"data": "duracion", "title": "Duración", "className": 'font-size-col', "visible": true},
							{
								"data": "observaciones",
								"title": "Observaciones",
								"className": 'font-size-col',
								"visible": true
							},
							{"data": "tipo", "title": "Tipo", "className": 'font-size-col', "visible": false},
							{"data": "name", "title": "Responsable", "className": 'font-size-col', "visible": true},
							{
								"title": "Más",
								"visible": true,
								"data": function (data) {
									opciones = '<div role="group"><center>';
									opciones += '<button href="#" class="btn btn-simple btn-link btn-icon btn-cir editar_expediente" style="border-color:#008080;color:#008080;" title="Editar entrada de expediente" value="' + data.id_clinico + '"><i class="fa fa-pencil" aria-hidden="true"></i></button>';
									return opciones + '</center></div>';
								}
							}
						];
					} else {
						var columns = [{
							"data": "fecha_sesion",
							"title": "Fecha",
							"className": 'font-size-col',
							"visible": true
						},
							{"data": "nombre", "title": "Área", "className": 'font-size-col', "visible": false},
							{"data": "row", "title": "# de sesión", "className": 'font-size-col', "visible": true},
							{
								"data": "tempIni",
								"title": "Temp. Inicial",
								"className": 'font-size-col',
								"visible": false
							},
							{"data": "tempFin", "title": "Temp. Final", "className": 'font-size-col', "visible": false},
							{
								"data": "rfIni",
								"title": "% Inicial de RF",
								"className": 'font-size-col',
								"visible": false
							},
							{"data": "rfFin", "title": "% final de RF", "className": 'font-size-col', "visible": false},
							{"data": "potencia", "title": "Fluencia", "className": 'font-size-col', "visible": true},
							{"data": "frecuencia", "title": "Modo", "className": 'font-size-col', "visible": true},
							{
								"data": "bello_restante",
								"title": "%Vello Restante",
								"className": 'font-size-col',
								"visible": true
							},
							{"data": "duracion", "title": "Duración", "className": 'font-size-col', "visible": true},
							{
								"data": "observaciones",
								"title": "Observaciones",
								"className": 'font-size-col',
								"visible": true
							},
							{"data": "tipo", "title": "Tipo", "className": 'font-size-col', "visible": false},
							{"data": "name", "title": "Responsable", "className": 'font-size-col', "visible": true},
							{
								"title": "Más",
								"visible": true,
								"data": function (data) {
									opciones = '<div role="group"><center>';
									opciones += '<button href="#" class="btn btn-simple btn-link btn-icon btn-cir editar_expediente" style="border-color:#008080;color:#008080;" title="Editar entrada de expediente" value="' + data.id_clinico + '"><i class="fa fa-pencil" aria-hidden="true"></i></button>';
									return opciones + '</center></div>';
								}
							}];
					}
					table_historial.destroy();
					table_historial = jQuery('#table_historial').DataTable({
						"ajax": {
							"url": "Expedientes/historial_expediente/",
							"type": "POST",
							"processing": true,
							"serverSide": true,
							"data": {cliente: cliente, idArea: idArea},
							"dataSrc": ""
						},
						language: {
							url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
						},
						"columns": columns,
						"dom": "<'row col-md-12'<'col-md-4'B><'col-md-8 p-0'f>><'row col-md-12 p-0'<'col-md-12 p-0't>><'row col-md-12 p-0'<'col-md-4'i><'col-md-8'p>>",
						"autoWidth": true,
						"paging": true,
						"bInfo": true,
						"buttons": [
							{"extend": 'pdfHtml5', "orientation": 'landscape', "title": 'Expediente clinico'}
						],
					});
				}

				$("#table_historial tbody").on("click", ".editar_expediente", function () {
					$('#loader').removeClass('hidden');
					var id_expediente = $(this).attr("value");
					var enfermera_res = '';
					jQuery("#Modal_historial_expediente").modal('toggle');

					$.getJSON("Expedientes/get_expediente_u/" + id_expediente).done(function (data) {
						console.log(data);
						var fecha_cita = data.fecha_sesion.split(" ");
						enfermera_res = data.id_enfermera;
						$("#form_editar_m").html("");
						$("#form_editar_d").html("");
						if (data.tipo == '1') {
							jQuery("#Modal_editar_expediente_d").modal();
							$("#Modal_editar_expediente_d #form_editar_d").append('<div class="row m-auto" style="width:100%"><div class="col-md-2"><b style="font-size:12px;">Área</b></div><div class="col-md-2"><b style="font-size:12px;">Fluencia</b></div><div class="col-md-2"><b style="font-size:12px;">Modo</b></div><div class="col-md-2"><b style="font-size:12px;">%Vello Rest.</b></div><div class="col-md-1"><b style="font-size:12px;">Duración</b></div><div class="col-md-3"><b style="font-size:12px;">Observaciones</b></div></div>');

							$("#Modal_editar_expediente_d #form_editar_d").append('<input type="hidden" class="id_expediente" name="id_expediente" value = "' + id_expediente + '"><div class="row m-auto" style="width:100%"><div class="col-md-2"><label style="font-size:12px;">' + data.nombre + ' (' + (data.tipo == 1 ? 'Depilación' : 'Moldeo') + ')<label></div><div class="col-md-2"><input type="text" style="font-size:12px; background-color:#f9f9f9; border:1px solid #cacaca; height: 35px" class="form-control" name="potencia" value="' + data.potencia + '"></div><div class="col-md-2"><select class="form-control frecuencia" name="frecuencia"></select></div><div class="col-md-2"><input type="text" style="font-size:12px; background-color:#f9f9f9; border:1px solid #cacaca; height: 35px"  class="form-control" name="bellorestante" value="' + data.bello_restante + '" onkeypress="return onlyNumbers(event)" min="0" max="100" maxlength="3"></div><div class="col-md-1"><input type="text" style="font-size:12px; background-color:#f9f9f9; border:1px solid #cacaca; height: 35px" class="form-control" name="dur_area" value="' + data.duracion + '"></div><div class="col-md-3"><input type="text" style="font-size:12px; background-color:#f9f9f9; border:1px solid #cacaca; height: 35px" class="form-control" name="observaciones" value="' + data.observaciones + '"></div></div>');

							if (data.frecuencia == "Pulsado") $("#Modal_editar_expediente_d #form_editar_d .frecuencia").append('<option value="Pulsado" selected>Pulsado</option><option value="Deslizado">Deslizado</option>');
							else {
								$("#Modal_editar_expediente_d #form_editar_d .frecuencia").append('<option value="Pulsado">Pulsado</option><option value="Deslizado" selected>Deslizado</option>');
							}
						} else if (data.tipo == '2') {
							jQuery("#Modal_editar_expediente_m").modal();
							$("#Modal_editar_expediente_m #form_editar_m").append('<input type="hidden" class="id_expediente" name="id_expediente" value = "' + id_expediente + '"><div class="row m-auto" style="width:100%"><div class="col-md-2"><b style="font-size:12px;">Área</b><label style="font-size:12px;">' + data.nombre + ' (' + (data.tipo == 1 ? 'Depilación' : 'Moldeo') + ')<label></div><div class="col-md-1"><b style="font-size:12px;">Tmp I</b><input type="text" style="font-size:12px; background-color:#f9f9f9; border:1px solid #cacaca; height: 35px" class="form-control" name="tempIni" value= "' + data.tempIni + '"></div><div class="col-md-2"><b style="font-size:12px;">% Inicial de RF</b><input type="text" style="font-size:12px; background-color:#f9f9f9; border:1px solid #cacaca; height: 35px" class="form-control" name="rfIni" value="' + data.rfIni + '"></div><div class="col-md-2"><b style="font-size:12px;">% Final de RF.</b><input type="text" style="font-size:12px; background-color:#f9f9f9; border:1px solid #cacaca; height: 35px"  class="form-control" name="rfFin" value="' + data.rfFin + '"></div><div class="col-md-1"><b style="font-size:12px;">Tmp F</b><input type="text" style="font-size:12px; background-color:#f9f9f9; border:1px solid #cacaca; height: 35px"  class="form-control" name="tempFin" value="' + data.tempFin + '"></div><div class="col-md-1"><b style="font-size:12px;">Duración</b><input type="text" style="font-size:12px; background-color:#f9f9f9; border:1px solid #cacaca; height: 35px"  class="form-control" name="dur_area" value="' + data.duracion + '"></div><div class="col-md-3"><b style="font-size:12px;">Observaciones</b><input type="text" style="font-size:12px; background-color:#f9f9f9; border:1px solid #cacaca; height: 35px"  class="form-control" name="observaciones" value="' + data.observaciones + '"></div></div>');
						}
						$(".modal_editar_exp .btn-editar").append('<div class="row m-auto" style="width:100%"><div class="col-md-6"><label style="font-size:12px;"><b style="font-size:12px;">Fecha de la cita: </b></label><input type="date" class="form-control" name="fecha_cita" value="' + fecha_cita[0] + '" required></div><div class="col-md-6"><label style="font-size:12px;"><b style="font-size:12px;">Responsable: </b></label><select class="form-control responsable" name="responsable" required><option selected disabled>Seleccione una opción.</option></select></div></div><div class="row w-100 m-auto"><div class="col-md-12 d-flex justify-content-end"><div><button type="submit" class="btn btn-body mt-4 mr-2" style="padding: 5px 50px">Guardar</button><button type="button" class="btn btn-body mt-4" onClick="reloadPage();" style="padding: 5px 50px">Cerrar</button></div></div></div>');

						$.getJSON("Expedientes/get_enfermeras/").done(function (data) {
							$.each(data, function (i, v) {
								$(".modal_editar_exp .responsable").append('<option value="' + v.id_usuario + '">' + v.nombre + ' ' + v.apellido_paterno + ' ' + v.apellido_materno + '</option>');
								if (v.id_usuario == enfermera_res)
									$(".modal_editar_exp .responsable option[value='" + v.id_usuario + "']").attr("selected", true);
								$('#loader').addClass('hidden');
							});
						});
					});
				});
			})
		}); //FIN TERCEER MODAL
	});

	$().ready(function () {
		$("#form_expediente").validate({
			rules: {
				'potencia[]': {
					required: true,
				},
				'bellorestante[]': {
					required: true,
				},
				'frecuencia[]': {
					required: true,
				},
				'dur_area[]': {
					required: true,
				}
			},
			messages: {
				'potencia[]': {
					required: "Potencia requerida",
				},
				'bellorestante[]': {
					required: "Dato requerido",
				},
				'frecuencia[]': {
					required: "Dato requerido",
				},
				'dur_area[]': {
					required: "Dato requerido",
				}
			},
			submitHandler: function (form) {
				$('#loader').removeClass('hidden');
				var data = new FormData($(form)[0]);
				$("#save_exp").addClass('d-none');
				jQuery("#Modal_registro_expediente").modal('toggle');
				$('#save_exp').prop('disabled', true);
				$.ajax({
					url: "Expedientes/agregar_registro_exp",
					data: data,
					cache: false,
					contentType: false,
					processData: false,
					dataType: 'json',
					method: 'POST',
					async: true,
					type: 'POST', // For jQuery < 1.9
					success: function (data) {
						if (data[0]) {
							$('#loader').addClass('hidden');
							$('#save_exp').prop('disabled', false);
							jQuery("#modal_exito").modal("show");
							$('#loader').addClass('hidden');
							lista_clientes.ajax.reload();
						} else {
							$('#loader').addClass('hidden');
							jQuery("#modal_fail").modal("show");
							$('#save_exp').prop('disabled', false);
						}
					}, error: function () {
						$('#loader').addClass('hidden');
						jQuery("#modal_fail").modal("show");
						$('#save_exp').prop('disabled', false);
					}
				});
			}
		});

		$("#form_editar_m").validate({
			rules: {
				'tempIni': {
					required: true
				},
				'rfIni': {
					required: true
				},
				'rfFin': {
					required: true
				},
				'tempFin': {
					required: true
				},
				'tempFin': {
					required: true
				},
				'dur_area': {
					required: true
				}
			},
			messages: {
				'tempIni': {
					required: "Dato requerido"
				},
				'rfIni': {
					required: "Dato requerido"
				},
				'rfFin': {
					required: "Dato requerido"
				},
				'tempFin': {
					required: "Dato requerido"
				},
				'tempFin': {
					required: "Dato requerido"
				},
				'dur_area': {
					required: "Dato requerido"
				}
			},
			submitHandler: function (form) {
				var data = new FormData($(form)[0]);
				$('#loader').removeClass('hidden');
				// jQuery("#Modal_editar_expediente").modal('toggle');
				var id_expediente = $(".id_expediente").val();
				$.ajax({
					url: "Expedientes/update_registro_exp_m/" + id_expediente,
					data: data,
					cache: false,
					contentType: false,
					processData: false,
					dataType: 'json',
					method: 'POST',
					type: 'POST', // For jQuery < 1.9
					success: function (data) {
						if (data) {
							$('#loader').addClass('hidden');
							jQuery("#Modal_editar_expediente_m").modal('toggle');
							jQuery("#modal_exito").modal("show");
						} else {
							$('#loader').addClass('hidden');
							jQuery("#Modal_editar_expediente_m").modal('toggle');
							jQuery("#modal_fail").modal("show");
						}
					}, error: function () {
						$('#loader').addClass('hidden');
						jQuery("#Modal_editar_expediente_m").modal('toggle');
						jQuery("#modal_fail").modal("show");
					}
				});
			}
		});

		$("#form_editar_d").validate({
			rules: {
				'bello_restante': {
					required: true
				},
				'potencia': {
					required: true
				},
				'duracion': {
					required: true
				}
			},
			messages: {
				'bello_restante': {
					required: "Dato requerido"
				},
				'potencia': {
					required: "Dato requerido"
				},
				'duracion': {
					required: "Dato requerido"
				}
			},
			submitHandler: function (form) {
				var data = new FormData($(form)[0]);
				$('#loader').removeClass('hidden');
				// jQuery("#Modal_editar_expediente").modal('toggle');
				var id_expediente = $(".id_expediente").val();
				$.ajax({
					url: "Expedientes/update_registro_exp_d/" + id_expediente,
					data: data,
					cache: false,
					contentType: false,
					processData: false,
					dataType: 'json',
					method: 'POST',
					type: 'POST', // For jQuery < 1.9
					success: function (data) {
						if (data) {
							$('#loader').addClass('hidden');
							jQuery("#Modal_editar_expediente_d").modal('toggle');
							jQuery("#modal_exito").modal("show");
						} else {
							$('#loader').addClass('hidden');
							jQuery("#Modal_editar_expediente_d").modal('toggle');
							jQuery("#modal_fail").modal("show");
						}
					}, error: function () {
						$('#loader').addClass('hidden');
						jQuery("#Modal_editar_expediente_d").modal('toggle');
						jQuery("#modal_fail").modal("show");
					}
				});
			}
		});

		$("#Modal_registro_expediente .expediente_footer").on("click", ".return", function (e) {
			e.preventDefault();

			$(".areas_expediente_body").show();
			$(".areas_expediente_footer").show();
			$(".expediente_body").hide();
			$(".expediente_footer").hide();
		});

		$("#Modal_registro_expediente .areas_expediente_footer").on("click", ".continue", function (e) {
			e.preventDefault();
			checked = $("input[type=checkbox]:checked").length;

			if (!checked) {
				jQuery.confirm({
					columnClass: 'col-md-6',
					title: false,
					content: '¡TIENES QUE SELECCIONAR AL MENOS UNA OPCIÓN!',
					buttons: {
						Aceptar: {
							btnClass: 'btn btn-body',
							action: function () {
							}
						}
					}
				});
				return false;
			} else {
				searchIDs = $("#dep input:checkbox:checked").map(function () {
					return [$(this).val()];
				}).get();
				var servicio = $("#dep input:checkbox:checked").map(function () {
					return $(this).attr('data-servicio');
				}).get();
				var nombre = $("#dep input:checkbox:checked").map(function () {
					return $(this).attr('data-individual');
				}).get();

				var cl = $("#dep input:checkbox:checked").map(function () {
					return $(this).attr('data-cl');
				}).get();

				$("#Modal_registro_expediente .areas_expediente_body").hide();
				$("#Modal_registro_expediente .areas_expediente_footer").hide();
				$("#Modal_registro_expediente .expediente_body").show();
				$("#Modal_registro_expediente .expediente_footer").show();
				$("#Modal_registro_expediente .expediente_body").html("");
				$("#Modal_registro_expediente .expediente_footer").html("");
				$("#Modal_registro_expediente .expediente_body").append('<input type="hidden" name="idcliente" value="' + cl[0] + '"><br>');

				for (var x = 0; x < searchIDs.length; x++) {

					if (servicio[x] == 1) {
						$("#Modal_registro_expediente .expediente_body").append('<div class="row m-auto" style="width:100%"><div class="col-md-2"><b style="font-size:12px;">Área</b></div><div class="col-md-2"><b style="font-size:12px;">Fluencia</b></div><div class="col-md-2"><b style="font-size:12px;">Modo</b></div><div class="col-md-2"><b style="font-size:12px;">%Vello Rest.</b></div><div class="col-md-1"><b style="font-size:12px;">Duración</b></div><div class="col-md-3"><b style="font-size:12px;">Observaciones</b></div></div>');
						$("#Modal_registro_expediente .expediente_body").append('<div class="row m-auto" style="width:100%"><div class="col-md-2"><input type="hidden" name="tipo' + searchIDs[x] + '[]" value="' + servicio[x] + '"><input type="hidden" name="idarea[]" value="' + searchIDs[x] + '"><label style="font-size:12px;">' + nombre[x] + ' (' + (servicio[x] == 1 ? 'Depilación' : 'Moldeo') + ')<label></div><div class="col-md-2"><input type="text" style="font-size:12px; background-color:#f9f9f9; border:1px solid #cacaca; height: 35px"  class="form-control" name="potencia' + searchIDs[x] + '[]" required></div><div class="col-md-2"><select class="form-control frecuencia" name="frecuencia' + searchIDs[x] + '[]" required><option selected disabled>Selecciona una opción.</option></select></div><div class="col-md-2"><input type="text" style="font-size:12px; background-color:#f9f9f9; border:1px solid #cacaca; height: 35px" class="form-control" name="bellorestante' + searchIDs[x] + '[]" onkeypress="return onlyNumbers(event)" min="0" max="100" maxlength="3" required></div><div class="col-md-1"><input type="text" style="font-size:12px; background-color:#f9f9f9; border:1px solid #cacaca; height: 35px" class="form-control" name="dur_area' + searchIDs[x] + '[]" onkeypress="return onlyNumbers(event)" min="0" max="100" maxlength="3" required></div><div class="col-md-3"><input type="text" style="font-size:12px; background-color:#f9f9f9; border:1px solid #cacaca; height: 35px" class="form-control" name="observacion_cita' + searchIDs[x] + '[]"></div></div>');
					} else {
						$("#Modal_registro_expediente .expediente_body").append('<div class="row m-auto" style="width:100%"><div class="col-md-2"><b style="font-size:12px;">Área</b></div><div class="col-md-1"><b style="font-size:12px;">Tmp I</b></div><div class="col-md-2"><b style="font-size:12px;">% Inicial de RF</b></div><div class="col-md-2"><b style="font-size:12px;">% Final de RF.</b></div><div class="col-md-1"><b style="font-size:12px;">Tmp F</b></div><div class="col-md-1"><b style="font-size:12px;">Duración</b></div><div class="col-md-3"><b style="font-size:12px;">Observaciones</b></div></div>');
						$("#Modal_registro_expediente .expediente_body").append('<div class="row m-auto" style="width:100%"><div class="col-md-2"><input type="hidden" name="tipo' + searchIDs[x] + '[]" value="' + servicio[x] + '"><input type="hidden" name="idarea[]" value="' + searchIDs[x] + '"><label style="font-size:12px;">' + nombre[x] + ' (' + (servicio[x] == 1 ? 'Depilación' : 'Moldeo') + ')<label></div><div class="col-md-1"><input type="text" style="font-size:12px; background-color:#f9f9f9; border:1px solid #cacaca; height: 35px" class="form-control" name="tempIni' + searchIDs[x] + '[]" required></div><div class="col-md-2"><input type="text" style="font-size:12px; background-color:#f9f9f9; border:1px solid #cacaca; height: 35px"  class="form-control" name="rfIni' + searchIDs[x] + '[]" required></div><div class="col-md-2"><input type="text" style="font-size:12px; background-color:#f9f9f9; border:1px solid #cacaca; height: 35px" class="form-control" name="rfFin' + searchIDs[x] + '[]" required></div><div class="col-md-1"><input type="text" style="font-size:12px; background-color:#f9f9f9; border:1px solid #cacaca; height: 35px"  class="form-control" name="tempFin' + searchIDs[x] + '[]" required></div><div class="col-md-1"><input type="text" style="font-size:12px; background-color:#f9f9f9; border:1px solid #cacaca; height: 35px"  class="form-control" name="dur_area' + searchIDs[x] + '[]" onkeypress="return onlyNumbers(event)"></div><div class="col-md-3"><input type="text" style="font-size:12px; background-color:#f9f9f9; border:1px solid #cacaca; height: 35px"  class="form-control" name="observacion_cita' + searchIDs[x] + '[]"></div></div>');
					}
				}

				$("#Modal_registro_expediente .expediente_body").append('<div class="row m-auto" style="width:100%"><div class="col-md-6"><label style="font-size:12px;"><b style="font-size:12px;">Fecha de la cita: </b></label><input type="date" class="form-control" name="fecha_cita" value="" required></div><div class="col-md-6"><label style="font-size:12px;"><b style="font-size:12px;">Responsable: </b></label><select class="form-control" id="responsable" name="responsable" required><option selected disabled>Seleccione una opción.</option></select></div></div>');
				$("#Modal_registro_expediente .expediente_footer").append('<div style="display:flex; justify-content:flex-start; width:100%"><button type="button" class="btn btn-body return">REGRESAR</button></div><div style="display:flex; justify-content:flex-end; width:100%"><button type="submit" class="btn btn-body" id="save_exp" style="margin-right: 10px;">GUARDAR</button><button type="button" class="btn btn-body" data-dismiss="modal">CANCELAR</button></div>');
				$.getJSON("Expedientes/get_enfermeras/").done(function (data) {
					$.each(data, function (i, v) {
						$("#Modal_registro_expediente .expediente_body #responsable").append('<option value="' + v.id_usuario + '">' + v.nombre + '</option>')
					});
				});

				$("#Modal_registro_expediente .expediente_body .frecuencia").append('<option value="Pulsado">Pulsado</option><option value="Deslizado">Deslizado</option>')
			}
		})
	});

	function onlyNumbers(e) {
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key);
		letras = " 0123456789";
		especiales = [8, 37, 39, 46];

		tecla_especial = false
		for (var i in especiales) {
			if (key == especiales[i]) {
				tecla_especial = true;
				break;
			}
		}

		if (letras.indexOf(tecla) == -1 && !tecla_especial)
			return false;
	}

	function formatMoney(n) {
		var c = isNaN(c = Math.abs(c)) ? 2 : c,
				d = d == undefined ? "." : d,
				t = t == undefined ? "," : t,
				s = n < 0 ? "-" : "",
				i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
				j = (j = i.length) > 3 ? j % 3 : 0;
		return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	};

	$(window).resize(function () {
		lista_clientes.columns.adjust();
	});

</script>
