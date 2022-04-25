<?php
require "header.php";
$page = 'paq_clientes';
require "menu.php";
?>
<link href="<?= base_url("assets/css/v_ListaClientes.css")?>" rel="stylesheet" />

<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col" style="background-color : white;">
				<div class="box">
					<div class="box-body">
						<div class="box-header with-border">
							<div class="">
								<div class="card-body">
									<div class="card-header ">
										<h4 class="card-title">Clientes Body Effect</h4>
										<p class="card-category">En este apartado podrás realizar la consulta de los
											datos del cliente, ver el contrato, bloquear al cliente y hacer una reventa
											instantánea o normal según el caso.
										</p>
									</div>
									<br>
									<form id="listaClientes_form" name="listaClientes_form">
										<div class="row ">
											<div class="col-md-3 form-group">
												<label>* Fecha inicial</label>
												<input class="form-control" type="date" name="begin_date" id="begin_date" required data-toggle="tooltip" title="Fecha inicial" />
											</div>
											<div class="col-md-3 form-group">
												<label>* Fecha final</label>
												<input class="form-control" type="date" name="end_date" id="end_date" required="" data-toggle="tooltip" title="Fecha final" />
											</div>
											<div class="col-md-6 d-flex align-items-end" style="padding-bottom:15px">
												<button type="submit" id="btn_submit" class="btn-circle btn-md" style="background-color:#1ABC9C; border-color:#1ABC9C; color: #FFFFFF;" data-toggle="tooltip" title="Obtener datos"><i class="fas fa-check"></i></button>
											</div>			
										</div>												
									</form>
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive">
												<div class="material-datatables">
													<table id="tabla_clientes" class="table table-striped table-bordered"
														   cellspacing="0" width="100%" style="width: 100%">
														<thead>
														<tr>
															<th style="font-size: .8em;">ID</th>
															<th style="font-size: .8em;">CLIENTE</th>
															<th style="font-size: .8em;">FECHA CONTRATO</th>
															<th style="font-size: .8em; width: 0px">CORREO</th>
															<th style="font-size: .8em;">TELÉFONO</th>
															<th style="font-size: .8em;">ÁREAS CONTRATADAS</th>
															<th style="font-size: .8em;">OBSERVACIONES</th>
															<th style="font-size: .8em;">EXPEDIENTE</th>
															<th style="font-size: .8em;">MÁS</th>
														</tr>
														</thead>
													</table><!--End table -->
												</div>
											</div>
										</div><!-- End col-md-12 -->
									</div> <!-- End row -->
								</div> <!-- End card-body-->
							</div> <!-- End div calss="" -->
						</div> <!-- End box-header with-border -->
					</div> <!-- End tab content box-body -->
				</div> <!--End tab box-->
			</div> <!-- end col -->
		</div> <!-- End row -->
	</div> <!-- End container-fluid -->
</div> <!-- End content -->


<!-- peguntar cancelar modal -->
<div id="confirmTransactionModal" class="modal fade" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header d-flex justify-content-end p-0 pr-2">
            <a href="<?=base_url() ?>index.php/Home">x</a>
          </div>
          <div class="modal-body">
              <div><center><img src='<?= base_url("assets/img/alerta.png")?>' style='width:130px; height: 120px'></center></div>
              <center><label><b>El ticket no fue encontrado o surgió un error</b></label></center>               
          </div>
          <div class="modal-footer"></div>
      </div>
  </div>
</div>

<div id="modal_cancelar_contrato" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header" style="display: none">
				<h4 class="modal-title">Cancelar contrato</h4>
				<button type="button" class="close" data-dismiss="modal">
				<span class="fa fa-times" aria-hidden="true"></span>
				</button>
			</div>
			<div class="modal-body">
				<center><h4 class="title">¿Realmente deseas cancelar este contrato?</h4></center>
				<br><br>
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 hide" id="status_bar">
					<div class="progress" style="height: 2px;">
						<div class="progress-bar progress-bar-striped indeterminate" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
					<center>
						<div id="textStatus"></div>
					</center>
				</div>
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-around" id="cancel_contract_buttons">
					<button class="btn btn-body" id="cancelar_def" style="width:40%">Sí</button>
					<button class="btn btn-body" data-dismiss="modal" id="cancelar_no" style="width:40%">No</button>
				</div>
			</div>
			<div class="modal-footer">
			</div>
		</div>

	</div>
</div>
<!-- Modal -->
<div id="modal_expedientes" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg" style="max-width: 90%;">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header d-flex justify-content-end p-0 pr-2">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form_expedientes" name="form_expedientes">
				<div class="modal-body" id="documentacion_main">

				</div>
			</form>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>

<div class="modal fade" id="Modal_data_cliente" role="dialog">
	<div class="modal-dialog modal-lg" style="width:38%">
		<div class="modal-content" style="border:1px solid #797979">
			<div class="modal-body" style="padding:0"></div>
			<div class="modal-footer" style="display:flex; justify-content:flex-end">
				<button type="button" class="btn btn-body" data-dismiss="modal" style="width:20%">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<div id="Modal_data_expediente" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static"
	 data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body">
			</div>
		</div>
	</div>
</div>

<div id="modalId" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title nameTittle"></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body body-document">
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="observationsModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cleanFields()">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="my_observations_form" name="my_observarions_form" method="post">
					<div class="row">
						<div class="col-md-12">
							<label>Observaciones:</label>
							<textarea class="form-control" id="observaciones" name="observaciones" rows="7" placeholder="Observaciones" style="margin-top: 0px; margin-bottom: 0px; height: 100px;"></textarea>
						</div>
						<input type="hidden" class="form-control" id="id_contrato_obs" name="id_contrato_obs">
						<input type="hidden" class="form-control" id="id_tipo_obs">
					</div>
					<br>
					<div class="row">
						<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<center><button type="submit" id="btn_obs" class="btn btn-body">Guardar</button></center>
						</div>
					</div>
				</form>

			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>

<div id="modalError" class="modal fade modalCenter" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div><center><img src='<?= base_url("assets/img/alerta.png")?>' style='width:120px; height: 120px'></center></div>
				<center><label><b>Ha ocurrido un error al cargar la información.</b></label></center>
				<center><button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button></center>
			</div>
		</div>
	</div>
</div>



<div id="modal_alerta" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header d-flex justify-content-end p-0 pr-2">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="bodyAlert" style="text-align: center;">

			</div>

			<div class="modal-footer" style="align-self: center">
				<button class="btn btn-body" data-dismiss="modal" type="button">Aceptar</button>
			</div>
		</div>
	</div>
</div>

<!-- HTML para Spinner-->
<div id="loader" class="lds-dual-ring hidden overlay"></div>
<!-- END HTML para Spinner -->

<?php
require "footer.php";
?>

</div>
</div>

<script>
var rol = '<?php echo $this->session->userdata("inicio_sesion")["id_rol"]; ?>';

	Shadowbox.init();
	$(document).ready(function () {

		// BEGIN DATE
		const fechaInicio = new Date();
		// Iniciar en este año, este mes, en el día 1
		const beginDate =  new Date(fechaInicio.getFullYear(), fechaInicio.getMonth(), 1);

		// END DATE
		const fechaFin = new Date();
		// Iniciar en este año, el siguiente mes, en el día 0 (así que así nos regresamos un día)
		const endDate = new Date(fechaFin.getFullYear(), fechaFin.getMonth() + 1, 0);

		finalBeginDate = [beginDate.getFullYear(), ('0' + (beginDate.getMonth() + 1)).slice(-2), ('0' + beginDate.getDate()).slice(-2)].join('-');
		finalEndDate = [endDate.getFullYear(), ('0' + (endDate.getMonth() + 1)).slice(-2), ('0' + endDate.getDate()).slice(-2)].join('-');

		fillDataTable(finalBeginDate, finalEndDate);

		/*cancelar contrato*/
		$(document).on('click', '.cancelar_contrato', function () {

			var id_contrato = $(this).attr("data-idContrato");
			var id_cliente = $(this).attr("data-idCliente");


			$('#modal_cancelar_contrato').modal();
			$('#cancelar_def').attr("data-idContrato", id_contrato);
			$('#cancelar_def').attr("data-idCliente", id_cliente);
			//cancelar_contrato
		});
		$(document).on('click', '#cancelar_def', function () {
			var id_contrato = $(this).attr("data-idContrato");
			var id_cliente = $(this).attr("data-idCliente");			
			var data = new FormData();
			data.append("id_contrato", id_contrato);
			data.append("id_cliente", id_cliente);
			$.ajax({
				url: "<?=base_url()?>index.php/ListaClientes/cancelaContrato/",
				data: data,
				cache: false,
				contentType: false,
				processData: false,
				method: 'POST',
				type: 'POST',
				dataType: 'json',
				beforeSend: function () {
					$('#cancelar_def').attr("disabled", "disabled");
					$('#cancelar_def').css("opacity", ".5");

					$('#cancelar_no').attr("disabled", "disabled");
					$('#cancelar_no').css("opacity", ".5");

					$('#textStatus').html("");
					$('#textStatus').append("<p style='color:orange;font-size:1em;'>Cancelando contrato</p>");
					$('#status_bar').removeClass('hide');
					$('#cancel_contract_buttons').addClass('hide');
				},
				success: function (data) {					
					$('#cancelar_def').attr("disabled", false);
					$('#cancelar_def').css("opacity", "1");

					$('#cancelar_no').attr("disabled", false);
					$('#cancelar_no').css("opacity", "1");

					$('#cancelar_def').addClass('hide');
					$('#cancelar_no').addClass('hide');


					$('#textStatus').html("");
					$('#textStatus').append("<p style='color:#00d600;font-size:1em;'>Enviado correctamente</p>");

					if (data.success == 1) {
						$('#textStatus').append(data.message);
						setTimeout(function () {
							$('#status_bar').addClass('hide');
							$('#btnSbmit').attr("disabled", false);
							$('#btnSbmit').css("opacity", "1");
							$('#textStatus').html("");
							$('#modal_cancelar_contrato').modal('toggle');
							$('#cancel_contract_buttons').removeClass('hide');
							$('#cancelar_def').removeClass('hide');
							$('#cancelar_no').removeClass('hide');
						}, 3000);
						$('#tabla_clientes').DataTable().ajax.reload();
					} else {
						jQuery("#modal_fail").modal("show");
					}
				},
				error: function (data) {					
					$('#textStatus').html("");
					$('#textStatus').append("<p style='color:#ff6c64;font-size:1em;'>Ocurrio un error [" + data.message + "]</p>");


					setTimeout(function () {
						$('#cancelar_def').attr("disabled", false);
						$('#cancelar_def').css("opacity", "1");

						$('#cancelar_no').attr("disabled", false);
						$('#cancelar_no').css("opacity", "1");

						$('#cancelar_def').removeClass('hide');
						$('#cancelar_no').removeClass('hide');

						$('#status_bar').addClass('hide');
					}, 3000);
				}
			});
		});
		$(document).on('click', '#cancelar_no', function () {			
			$('#modal_cancelar_contrato').modal('toggle');
		});
		/*finzaliza cancela contrato*/


		$(document).on('click', '#expClients', function () {
			/*limpiar el modal*/
			$('#documentacion_main').html('');
			//chacha
			var id_contrato = $(this).attr("data-idContrato");
			var id_cliente = $(this).attr("data-idCliente");
			var cnt_container = '';
			// cnt_container = '<form id="form_expedientes" name="form_expedientes">';
			$.post("<?=base_url()?>index.php/ListaClientes/get_expediente_by_client/" + id_cliente + "/" + id_contrato, function (data) {
				if (data.length > 0) {					
					/*IFE*/
					if (data[0].ife != null && data[0].ife != '') {
						cnt_container += '<div class="row" id="ife_exist">';
						cnt_container += '  <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
						cnt_container += '    <center>IFE</center>';
						cnt_container += '    <iframe src="<?=base_url()?>assets/expediente/INE/' + data[0].ife + '" width="100%" height="380px"></iframe>';
						cnt_container += '    <small>Registro actual del expediete IFE/INE*</small>';
						cnt_container += '    <div><center>';
						cnt_container += '    <a href="#" class="btn btn-simple btn-link btn-icon btn-cir upife" ' +
							'         style="border-color:#00289c;color:#0027bb;margin-right:10px" title="Actualizar IFE" ' +
							'         ><i class="fa fa-refresh" aria-hidden="true"></i></a>';
						cnt_container += '    <a href="#" class="btn btn-simple btn-link btn-icon btn-cir delete" ' +
							'         style="border-color:#ff0a00;color:#ff4c3f;margin-right:10px" title="Eliminar IFE" ' +
							'         data-expediente="IFE" data-idExpediente="' + data[0].id_expediente + '"><i class="fa fa-trash" aria-hidden="true"></i></a>';
						cnt_container += '    </center></div>';
						cnt_container += '    <input type="hidden" value="' + data[0].ife + '" name="actualiza_ife"><br><hr></center></div>';
						cnt_container += '  </div>';
						cnt_container += '</div>';
						/*por si decide actualizar el archivo*/
						cnt_container += '<div class="row" id="ife_noexist" style="display: none">';
						cnt_container += '  <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
						cnt_container += '    <center>IFE</center>';
						cnt_container += '    <label>Ingrese su documento:</label>';
						cnt_container += '    <input type="file" class="form-control" name="ife_insert" onchange="return fileValidation(this)" accept="application/pdf">';
						cnt_container += '    <small>Asegúrese que su archivo esté en formato PDF*</small><br><br><hr>';
						cnt_container += '  </div>';
						cnt_container += '</div>';
					} else {
						cnt_container += '<div class="row" id="ife_noexist">';
						cnt_container += '  <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
						cnt_container += '    <center>IFE</center>';
						cnt_container += '    <label>Ingrese su documento:</label>';
						cnt_container += '    <input type="file" class="form-control" name="ife_insert" onchange="return fileValidation(this)" accept="application/pdf">';
						cnt_container += '    <small>Asegúrese que su archivo esté en formato PDF*</small><br><br><hr>';
						cnt_container += '  </div>';
						cnt_container += '</div>';
					}

					/*CONTRATO*/
					if (data[0].contrato != null && data[0].contrato != '') {
						cnt_container += '<div class="row" id="contrato_exist">';
						cnt_container += '  <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
						cnt_container += '    <center>CONTRATO</center>';
						cnt_container += '    <iframe src="<?=base_url()?>assets/expediente/CONTRATO/' + data[0].contrato + '" width="100%" height="380px"></iframe>';
						cnt_container += '    <small>Registro actual del contrato*</small>';
						cnt_container += '    <div><center>';
						cnt_container += '    <a href="#" class="btn btn-simple btn-link btn-icon btn-cir upcontrato" ' +
							'         style="border-color:#00289c;color:#0027bb;margin-right:10px" title="Actualizar contrato" ' +
							'         ><i class="fa fa-refresh" aria-hidden="true"></i></a>';
						cnt_container += '    <a href="#" class="btn btn-simple btn-link btn-icon btn-cir delete" ' +
							'         style="border-color:#ff0a00;color:#ff4c3f;margin-right:10px" title="Eliminar contrato" ' +
							'         data-expediente="CONTRATO" data-idExpediente="' + data[0].id_expediente + '"><i class="fa fa-trash" aria-hidden="true"></i></a>';
						cnt_container += '    </center></div>';
						cnt_container += '    <input type="hidden" value="' + data[0].contrato + '" name="actualiza_contrato" onchange="return fileValidation(this)"><br><hr></center></div>';
						cnt_container += '  </div>';
						cnt_container += '</div>';
						/*por si decide actualizar el archivo*/
						cnt_container += '<div class="row" id="contrato_noexist" style="display: none">';
						cnt_container += '  <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
						cnt_container += '    <center>CONTRATO</center>';
						cnt_container += '    <label>Ingrese su documento:</label>';
						cnt_container += '    <input type="file" class="form-control" name="contrato_insert" accept="application/pdf" onchange="return fileValidation(this)">';
						cnt_container += '    <small>Asegúrese que su archivo esté en formato PDF*</small><br><br><hr>';
						cnt_container += '  </div>';
						cnt_container += '</div>';
					} else {
						cnt_container += '<div class="row" id="contrato_noexist">';
						cnt_container += '  <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
						cnt_container += '    <center>CONTRATO</center>';
						cnt_container += '    <label>Ingrese su documento:</label>';
						cnt_container += '    <input type="file" class="form-control" name="contrato_insert" accept="application/pdf" onchange="return fileValidation(this)">';
						cnt_container += '    <small>Asegúrese que su archivo esté en formato PDF*</small><br><br><hr>';
						cnt_container += '  </div>';
						cnt_container += '</div>';
					}

					/*CARTA*/
					if (data[0].carta != null && data[0].carta != '') {
						cnt_container += '<div class="row" id="contrato_exist">';
						cnt_container += '  <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
						cnt_container += '    <center>CARTA PROSA</center>';
						cnt_container += '    <iframe src="<?=base_url()?>assets/expediente/CPROSA/' + data[0].carta + '" width="100%" height="380px"></iframe>';
						cnt_container += '    <small>Registro actual de la carta*</small>';
						cnt_container += '    <div><center>';
						cnt_container += '    <a href="#" class="btn btn-simple btn-link btn-icon btn-cir upcartaprosa" ' +
							'         style="border-color:#00289c;color:#0027bb;margin-right:10px" title="Actualizar Carta prosa" ' +
							'         ><i class="fa fa-refresh" aria-hidden="true"></i></a>';
						cnt_container += '    <a href="#" class="btn btn-simple btn-link btn-icon btn-cir delete" ' +
							'         style="border-color:#ff0a00;color:#ff4c3f;margin-right:10px" title="Eliminar carta prosa" ' +
							'         data-expediente="PROSA" data-idExpediente="' + data[0].id_expediente + '"><i class="fa fa-trash" aria-hidden="true"></i></a>';
						cnt_container += '    </center></div>';
						cnt_container += '    <input type="hidden" value="' + data[0].carta + '" name="actualiza_carta" onchange="return fileValidation(this)"><br><hr></center></div>';
						cnt_container += '  </div>';
						cnt_container += '</div>';
						/*por si decide actualizar el archivo*/
						cnt_container += '<div class="row" id="carta_noexist" style="display: none">';
						cnt_container += '  <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
						cnt_container += '    <center>CARTA PROSA</center>';
						cnt_container += '    <label>Ingrese su documento:</label>';
						cnt_container += '    <input type="file" class="form-control" name="carta_insert" accept="application/pdf" onchange="return fileValidation(this)">';
						cnt_container += '    <small>Asegúrese que su archivo esté en formato PDF*</small><br><br><hr>';
						cnt_container += '  </div>';
						cnt_container += '</div>';
					} else {
						cnt_container += '<div class="row" id="carta_noexist">';
						cnt_container += '  <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
						cnt_container += '    <center>CARTA PROSA</center>';
						cnt_container += '    <label>Ingrese su documento:</label>';
						cnt_container += '    <input type="file" class="form-control" name="carta_insert" accept="application/pdf" onchange="return fileValidation(this)">';
						cnt_container += '    <small>Asegúrese que su archivo esté en formato PDF*</small><br><br><hr>';
						cnt_container += '  </div>';
						cnt_container += '</div>';
					}

					/*TARJETA*/
					if (data[0].tarjeta != null && data[0].tarjeta != '') {
						cnt_container += '<div class="row" id="contrato_exist">';
						cnt_container += '  <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
						cnt_container += '    <center>TARJETA</center>';
						cnt_container += '    <iframe src="<?=base_url()?>assets/expediente/TARJETA/' + data[0].tarjeta + '" width="100%" height="380px"></iframe>';
						cnt_container += '    <small>Registro actual de la tarjeta*</small>';
						cnt_container += '    <div><center>';
						cnt_container += '    <a href="#" class="btn btn-simple btn-link btn-icon btn-cir uptarjeta" ' +
							'         style="border-color:#00289c;color:#0027bb;margin-right:10px" title="Actualizar Tarjeta" ' +
							'         ><i class="fa fa-refresh" aria-hidden="true"></i></a>';
						cnt_container += '    <a href="#" class="btn btn-simple btn-link btn-icon btn-cir delete" ' +
							'         style="border-color:#ff0a00;color:#ff4c3f;margin-right:10px" title="Eliminar tarjeta" ' +
							'         data-expediente="TARJETA" data-idExpediente="' + data[0].id_expediente + '"><i class="fa fa-trash" aria-hidden="true"></i></a>';
						cnt_container += '    </center></div>';
						cnt_container += '    <input type="hidden" value="' + data[0].tarjeta + '" name="actualiza_tarjeta" onchange="return fileValidation(this)"><br><hr></center></div>';
						cnt_container += '  </div>';
						cnt_container += '</div>';
						/*por si decide actualizar el archivo*/
						cnt_container += '<div class="row" id="tarjeta_noexist" style="display: none">';
						cnt_container += '  <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
						cnt_container += '    <center>TARJETA</center>';
						cnt_container += '    <label>Ingrese su documento:</label>';
						cnt_container += '    <input type="file" class="form-control" name="tarjeta_insert" accept="application/pdf" onchange="return fileValidation(this)">';
						cnt_container += '    <small>Asegúrese que su archivo esté en formato PDF*</small><br><br><hr>';
						cnt_container += '  </div>';
						cnt_container += '</div>';
					} else {
						cnt_container += '<div class="row" id="tarjeta_noexist">';
						cnt_container += '  <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
						cnt_container += '    <center>TARJETA</center>';
						cnt_container += '    <label>Ingrese su documento:</label>';
						cnt_container += '    <input type="file" class="form-control" name="tarjeta_insert" accept="application/pdf" onchange="return fileValidation(this)">';
						cnt_container += '    <small>Asegúrese que su archivo esté en formato PDF*</small><br><br><hr>';
						cnt_container += '  </div>';
						cnt_container += '</div>';
					}

					/*RECIBO*/
					if (data[0].recibo != null && data[0].recibo != '') {
						cnt_container += '<div class="row" id="contrato_exist">';
						cnt_container += '  <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
						cnt_container += '    <center>RECIBO</center>';
						cnt_container += '    <iframe src="<?=base_url()?>assets/expediente/RECIBO/' + data[0].recibo + '" width="100%" height="380px"></iframe>';
						cnt_container += '    <small>Registro actual del recibo*</small>';
						cnt_container += '    <div><center>';
						cnt_container += '    <a href="#" class="btn btn-simple btn-link btn-icon btn-cir uprecibo" ' +
							'         style="border-color:#00289c;color:#0027bb;margin-right:10px" title="Actualizar Recibo" ' +
							'         ><i class="fa fa-refresh" aria-hidden="true"></i></a>';
						cnt_container += '    <a href="#" class="btn btn-simple btn-link btn-icon btn-cir delete" ' +
							'         style="border-color:#ff0a00;color:#ff4c3f;margin-right:10px" title="Eliminar recibo" ' +
							'         data-expediente="RECIBO" data-idExpediente="' + data[0].id_expediente + '"><i class="fa fa-trash" aria-hidden="true"></i></a>';
						cnt_container += '    </center></div>';
						cnt_container += '    <input type="hidden" value="' + data[0].recibo + '" onchange="return fileValidation(this)" name="actualiza_recibo"><br><hr></center></div>';
						cnt_container += '  </div>';
						cnt_container += '</div>';
						/*por si decide actualizar el archivo*/
						cnt_container += '<div class="row" id="recibo_noexist" style="display: none">';
						cnt_container += '  <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
						cnt_container += '    <center>RECIBO</center>';
						cnt_container += '    <label>Ingrese su documento:</label>';
						cnt_container += '    <input type="file" class="form-control" name="recibo_insert" onchange="return fileValidation(this)" accept="application/pdf">';
						cnt_container += '    <small>Asegúrese que su archivo esté en formato PDF*</small><br><br><hr>';
						cnt_container += '  </div>';
						cnt_container += '</div>';
					} else {
						cnt_container += '<div class="row" id="recibo_noexist">';
						cnt_container += '  <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
						cnt_container += '    <center>RECIBO</center>';
						cnt_container += '    <label>Ingrese su documento:</label>';
						cnt_container += '    <input type="file" class="form-control" name="recibo_insert" onchange="return fileValidation(this)" accept="application/pdf">';
						cnt_container += '    <small>Asegúrese que su archivo esté en formato PDF*</small><br><br><hr>';
						cnt_container += '  </div>';
						cnt_container += '</div>';
					}
					cnt_container += '    <input name="id_expediente" type="hidden" value="' + data[0].id_expediente + '">';
				} else {
					//IFE
					cnt_container += '<div class="row" id="ife_noexist">';
					cnt_container += '  <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
					cnt_container += '    <center>IFE</center>';
					cnt_container += '    <label>Ingrese su documento:</label>';
					cnt_container += '    <input type="file" class="form-control" onchange="return fileValidation(this)" name="ife_insert" accept="application/pdf">';
					cnt_container += '    <small>Asegúrese que su archivo esté en formato PDF*</small><br><br><hr>';
					cnt_container += '  </div>';
					cnt_container += '</div>';
					//CONTRATO
					cnt_container += '<div class="row" id="contrato_noexist">';
					cnt_container += '  <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
					cnt_container += '    <center>CONTRATO</center>';
					cnt_container += '    <label>Ingrese su documento:</label>';
					cnt_container += '    <input type="file" class="form-control" onchange="return fileValidation(this)" name="contrato_insert" accept="application/pdf">';
					cnt_container += '    <small>Asegúrese que su archivo esté en formato PDF*</small><br><br><hr>';
					cnt_container += '  </div>';
					cnt_container += '</div>';
					//CPROSA
					cnt_container += '<div class="row" id="carta_noexist">';
					cnt_container += '  <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
					cnt_container += '    <center>CARTA PROSA</center>';
					cnt_container += '    <label>Ingrese su documento:</label>';
					cnt_container += '    <input type="file" class="form-control" onchange="return fileValidation(this)" name="carta_insert" accept="application/pdf">';
					cnt_container += '    <small>Asegúrese que su archivo esté en formato PDF*</small><br><br><hr>';
					cnt_container += '  </div>';
					cnt_container += '</div>';
					//TARJETA
					cnt_container += '<div class="row" id="tarjeta_noexist">';
					cnt_container += '  <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
					cnt_container += '    <center>TARJETA</center>';
					cnt_container += '    <label>Ingrese su documento:</label>';
					cnt_container += '    <input type="file" class="form-control" onchange="return fileValidation(this)" name="tarjeta_insert" accept="application/pdf">';
					cnt_container += '    <small>Asegúrese que su archivo esté en formato PDF*</small><br><br><hr>';
					cnt_container += '  </div>';
					cnt_container += '</div>';
					//RECIBO
					cnt_container += '<div class="row" id="recibo_noexist">';
					cnt_container += '  <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
					cnt_container += '    <center>RECIBO</center>';
					cnt_container += '    <label>Ingrese su documento:</label>';
					cnt_container += '    <input type="file" class="form-control" onchange="return fileValidation(this)" name="recibo_insert" accept="application/pdf">';
					cnt_container += '    <small>Asegúrese que su archivo esté en formato PDF*</small><br><br><hr>';
					cnt_container += '  </div>';
					cnt_container += '</div>';
					cnt_container += '    <input name="id_expediente" type="hidden" value="0">';
				}
				cnt_container += '<div class="row">';
				cnt_container += '  <div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12">';
				cnt_container += '    <input name="id_cliente" type="hidden" value="' + id_cliente + '">';
				cnt_container += '    <input name="id_contrato" type="hidden" value="' + id_contrato + '">';
				cnt_container += '    <center><button class="btn btn-body" type="submit">Actualizar expedientes</button></center>';
				cnt_container += '  </div>';
				cnt_container += '</div>';
				// cnt_container += '</form>';
				$('#documentacion_main').append(cnt_container);				
				$('#modal_expedientes').modal();
			}, 'json');
		});
		$(document).on('click', '.upife', function () {
			$("#ife_exist").css("display", "none");
			$("#ife_noexist").css("display", "block");
		});
		$(document).on('click', '.upcontrato', function () {
			$("#contrato_exist").css("display", "none");
			$("#contrato_noexist").css("display", "block");
		});


		/*ELIMINAR ACTION*/
		$(document).on('click', '.delete', function () {
			var tipo_expediente = $(this).attr("data-expediente");
			var id_expediente = $(this).attr("data-idExpediente");

			var data = new FormData();
			var cntAlert = '';
			data.append("id_expediente", id_expediente);
			data.append("tipo_expediente", tipo_expediente);
			$.ajax({
				url: "<?=base_url()?>index.php/ListaClientes/deleteByTipoExp/",
				data: data,
				cache: false,
				contentType: false,
				processData: false,
				method: 'POST',
				type: 'POST',
				dataType: 'json',
				beforeSend: function () {
					$('.delete').attr("disabled", "disabled");
					$('.delete').css("opacity", ".5");

				},
				success: function (data) {
					$('#bodyAlert').html('');					
					$('.delete').prop('disabled', false);
					$('.delete').css("opacity", "1");
					if (data.status_action == 1) {
						cntAlert += '<h5>'+data.message+'</h5>';
						$('#bodyAlert').append(cntAlert);
						$('#modal_alerta').modal('toggle');
						$('#tabla_clientes').DataTable().ajax.reload();
						$('#modal_expedientes').modal('toggle');
					} else {
						cntAlert += '<h5>'+data.message+'</h5>';
						$('#bodyAlert').append(cntAlert);
						$('#modal_alerta').modal('toggle');
						$('#modal_expedientes').modal('toggle');
					}
				},
				error: function (data) {
					console.log(data);
				}
			});
		});


		$('#form_expedientes').on('submit', function (e) {
			e.preventDefault();
			var cntAlert = '';
			$.ajax({
				type: 'POST',
				url: "<?=base_url()?>index.php/ListaClientes/enviarExpedientes",
				data: new FormData(this),
				contentType: false,
				cache: false,
				dataType: 'json',
				processData: false,
				beforeSend: function () {
					$('.delete').attr("disabled", "disabled");
					$('.delete').css("opacity", ".5");
				},
				success: function (data) {
					$('#bodyAlert').html('');					
					$('.delete').prop('disabled', false);
					$('.delete').css("opacity", "1");
					if (data.status_action == 1) {
						cntAlert += '<h5>'+data.message+'</h5>';
						$('#bodyAlert').append(cntAlert);
						$('#modal_alerta').modal('toggle');
						$('#modal_expedientes').modal('toggle');
						$('#tabla_clientes').DataTable().ajax.reload();
					} else {
						cntAlert += '<h5>'+data.message+'</h5>';
						$('#bodyAlert').append(cntAlert);
						$('#modal_alerta').modal('toggle');
						$('#modal_expedientes').modal('toggle');
					}
				},
				error: function (data) {
					jQuery("#modal_fail").modal("show");
				}
			});
		});


		/****************/

		$(document).on("click", "#reventaIns", function () {
			index_id_contrato = $(this).attr("value");
			window.location.href = "ClientesReventaInst/index/" + index_id_contrato;
		});

		$(document).on("click", "#reventa", function () {
			var id_cliente = $(this).attr("value");			
			window.location.href = "<?=base_url()?>index.php/Reventa/nueva_reventa/" + id_cliente;
		});

		$("#tabla_clientes tbody").on("click", ".ver_info_cliente", function () {			
			var id_cliente = $(this).attr("value");
			var id_contrato = $(this).attr("data-idContrato");
			// e.preventDefault();
			var cnt_modal = '';
			$.getJSON("ListaClientes/ver_cliente/" + id_contrato).done(function (data) {
				$('#loader').removeClass('hidden');
				var nombre_cl = data[0].nombrecompleto;
				var telefono_cl = data[0].telefono;				
				var fecha = new Date(data[0].fecha_creacion);
				var lbl_contrato = '<p class="m-0" style="color:white; font-size:24px">CONTRATO</p><p class="m-0" style="color:white; font-size:38px; margin-top: -14px!important;">MT-0000' + data[0].id_contrato + '</p>';
				const options = {year: 'numeric', month: 'short', day: 'numeric'};
				cnt_modal += "<div class='row' style='background-color: #c7b1dd; width: 100%; margin:auto; padding-top:20px'>";
				cnt_modal += "<div class='col-md-7' style='display: flex; align-items:flex-end;'><div style='display:grid'>" + lbl_contrato + "<p style='color:white;'>" + data[0].nombrecompleto + "</p></div></div>";
				cnt_modal += "<div class='col-md-5' style='display: flex; align-items:flex-end; justify-content: flex-end'><div style='display:grid'><p class='m-0' style='color:white; font-size:12px;text-align:end'>Fecha contrato: <br><b style='font-size:12px;'>" + (fecha.toLocaleDateString('es-ES', options)) + "</b></p>";
				cnt_modal += "<p class='m-0' style='color:white; font-size:12px;text-align:end'>Costo paquete: <br><b style='font-size:12px;'>$ " + formatMoney(data[0].cantidad) + "</b></p>";
				cnt_modal += "<p style='color:white; font-size:12px; text-align:end'>Forma de pago: <br><b style='font-size:12px;'> " + data[0].forma_pago + "</b></label></div></div></div>";
				cnt_modal += "<div class='row' style='width: 100%; margin: auto;'>";
				cnt_modal += "<div id='contenido_areas' style='padding:0 15px; width:100%; margin-top:10px'><p style='text-align:center'>Detalle del contrato</p></div><br><br>";
				cnt_modal += "</div>";

				$("#Modal_data_cliente .modal-body").html("");
				$("#Modal_data_cliente .modal-body").append(cnt_modal);

				$.post("<?=base_url()?>index.php/ListaClientes/getDetallePaqueteByClient/" + id_cliente + "/" + id_contrato, function (data2) {		
					console				
					if(data2 == '' || data2 == null ){						
						$('#contenido_areas').append("<p class='m-0' style='font-size: 0.8em'>Nombre: <b>" + nombre_cl + " <small style='background-color: #BD98E0;color: white;border-radius: 4px;padding: 3px;'>TITULAR</small></b></p>");
						$('#contenido_areas').append("<p class='m-0' style='font-size: 0.8em'>Teléfono: <b>" + telefono_cl + "</b></p>");
						$('#contenido_areas').append("<p class='m-0' style='font-size: 0.8em'>Número áreas: <b>N/A</b></p>");
						$('#contenido_areas').append("<p class='m-0' style='font-size: 0.8em'>Áreas: <b>N/A</b></p><hr>");
					}		
					else{
						$('#contenido_areas').append("<p class='m-0' style='font-size: 0.8em'>Nombre: <b>" + data2.nombre + " <small style='background-color: #BD98E0;color: white;border-radius: 4px;padding: 3px;'>TITULAR</small></b></p>");
						$('#contenido_areas').append("<p class='m-0' style='font-size: 0.8em'>Teléfono: <b>" + data2.telefono + "</b></p>");
						$('#contenido_areas').append("<p class='m-0' style='font-size: 0.8em'>Número áreas: <b>" + data2.numareas + "</b></p>");
						$('#contenido_areas').append("<p class='m-0' style='font-size: 0.8em'>Áreas: <b>" + data2.valor + "</b></p><hr>");						
					}										
				}, 'json');	

				$.post("<?=base_url()?>index.php/ListaClientes/getnumeropaquetes/" + id_contrato, function (data) {	
					var lengPaquetes = data.length;	
					for (var $i = 0; $i < lengPaquetes; $i++) {	
						$.post("<?=base_url()?>index.php/ListaClientes/getClientNoTitular/" + data[$i]['id_cliente'] + "/" + id_contrato + "/" + data[$i]['id_paquete'], function (data) {
							$('#contenido_areas').append("<div><p class='m-0' style='font-size: 0.8em'>Nombre: <b>" + data.nombre + " </b></p>");
							$('#contenido_areas').append("<p class='m-0' style='font-size: 0.8em'>Teléfono: <b>" + data.telefono + "</b></p>");
							$('#contenido_areas').append("<p class='m-0' style='font-size: 0.8em'>Número áreas: <b>" + data.numareas + "</b></p>");
							$('#contenido_areas').append("<p class='m-0' style='font-size: 0.8em'>Áreas: <b>" + data.valor + "</b></p><hr></div>");
						}, 'json');
					}	
					$('#loader').addClass('hidden');	
				}, 'json');
				$("#Modal_data_cliente").modal();
			});	
		});

		$("#tabla_clientes tbody").on("click", ".certificado", function () {
			index_cliente = $(this).attr("value");
			window.open("Archivos/certificado/" + index_cliente);
		});

		$("#tabla_clientes tbody").on("click", ".bloquear", function () {
			index_cliente = $(this).attr("value");
			$.getJSON("ListaClientes/bloquear_cliente/" + index_cliente).done(function (data) {
				if (data) {
					lista_clientes.ajax.reload();
					jQuery("#modal_exito").modal("show");
				} else {
					jQuery("#modal_fail").modal("show");
				}
			});
		});

		$("#tabla_clientes tbody").on("click", ".desbloquear", function () {
			index_cliente = $(this).attr("value");
			$.getJSON("ListaClientes/desbloquear_cliente/" + index_cliente).done(function (data) {
				if (data) {
					lista_clientes.ajax.reload();
					jQuery("#modal_exito").modal("show");
				} else {
					jQuery("#modal_fail").modal("show");
				}
			});
		});

		$("#tabla_clientes tbody").on("click", ".ejemplo", function () {
			index_cliente = $(this).attr("value");
			window.location.href = "index.php/ClientesReventa/index/" + index_cliente;
		});
	});
	$(document).on("change", ".see_exp", function () {
		var value = $(this).val();
		var div = value.split('&');

		var nombre_archivo = div[0];
		var tipo_doc = div[1];

		var ubicacion = (tipo_doc == 'ife') ? "<?=base_url()?>assets/expediente/INE/" :
			(tipo_doc == 'contrato') ? "<?=base_url()?>assets/expediente/CONTRATO/" :
				(tipo_doc == 'carta') ? "<?=base_url()?>assets/expediente/CPROSA/" :
					(tipo_doc == 'tarjeta') ? "<?=base_url()?>assets/expediente/TARJETA/" :
						(tipo_doc == 'recibo') ? "<?=base_url()?>assets/expediente/RECIBO/" :
							'';
		Shadowbox.open({
			content: '<iframe style="overflow:hidden;width: 100%;height: 99%;" src=" ' + ubicacion + nombre_archivo + ' "></iframe>',
			player: "html",
			title: "Visualizando archivo: " + tipo_doc,
			width: 985,
			height: 660,
			options: { 
            	onClose: refreshSelect
    		}
		});

	});

	function refreshSelect()
	{
			//$('.see_exp').find('option:first').removeAttr('selected');
			$('.see_exp').prop('selectedIndex',0);
	}
	function printPDF() {
		var w = window.open("about:blank");
		w.document.write(htmlPage);
		w.print();
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

	$(document).on('click', '.observations', function () {
		var id_contrato = $(this).attr("data-id_contrato");
		var id_tipo = $(this).attr("data-type");
		var observaciones = $(this).attr("data-observacion");
		$("#id_contrato_obs").val(id_contrato);
		$("#id_tipo_obs").val(id_tipo);
		if (id_tipo == 1) { // AGREGAR OBSERVACIÓN
			document.getElementById("exampleModalLabel").innerHTML = "Agregar observación";
		} else { // EDITAR OBSERVACIÓN
			document.getElementById("exampleModalLabel").innerHTML = "Editar observación";
			$("#observaciones").val(observaciones);
		}
		$("#observationsModal").modal();
	});

	$("#my_observations_form").on('submit', function(e){
		$('#loader').removeClass('hidden');
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: 'ListaClientes/observations',
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function(){
				// Actions before send post
			},
			success: function(data) {
				$('#loader').addClass('hidden');
				$('#observationsModal').modal("hide");
				if (data == 1) {
					cleanFields();
					$('#tabla_clientes').DataTable().ajax.reload();
				} else {
					$('#modalError').modal();
				}
			},
			error: function(){
				$('#loader').addClass('hidden');
				$('#observationsModal').modal("hide");
				$('#modalError').modal();
			}
		});
	});

	function cleanFields() {
		$("#id_contrato_obs").val('');
		$("#id_tipo_obs").val('');
		$("#observaciones").val('');
	}
	function fileValidation(valueFile) { 
            var fileInput =  valueFile; 
              
            var filePath = fileInput.value; 
            var cntAlert = '';
            $('#bodyAlert').html('');
          
            // Allowing file type 
            var allowedExtensions =  /(\.jpg|\.jpeg|\.png|\.pdf)$/i; 
              
            if (!allowedExtensions.exec(filePath)) { 
                /*alert('Invalid file type'); */
                cntAlert += '<h5>El tipo de archivo es inválido.</h5>';
						$('#bodyAlert').append(cntAlert);
						$('#modal_alerta').modal('toggle');
                fileInput.value = ''; 
                return false; 
            }  
    }
    $('#modal_alerta').on('hidden.bs.modal', function (e) {
  		// do something...
  		$('body').addClass('modal-open');
	});

	$('#tabla_clientes thead tr:eq(0) th').each(function (i) {
			if (i != 0 && i != 8) {
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
	
	function fillDataTable(beginDate, endDate) {

		lista_clientes = $('#tabla_clientes').DataTable({
			ajax: {
                url: 'ListaClientes/clientes_activos',
                type: "POST",
                cache: false,
                data: {
                    "beginDate": beginDate,
                    "endDate": endDate
                }
            },
			dom: '<"bottom"i>rt<"top"flp><"clear">',
			paging: true,
			info: false,
			destroy: true,
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
			},
			"columns": [
				{
					"data": function (d) {
						return '<p style="font-size: .8em">' + d.id_cliente + '</p>';
					}
				},
				{
					"orderable": false,
					"data": function (d) {
						return '<p style="font-size: .8em">' + d.nombre + '</p>';
					}
				},
				{
					"orderable": false,
					"data": function (d) {
						fe_crea = (d.fecha_contrato).substr(0, 10);
						var fecha = new Date(fe_crea);
						var dias = 1;
						fecha.setDate(fecha.getDate() + dias);
						var options = {year: 'numeric', month: 'numeric', day: 'numeric'};
						return '<p style="font-size: .8em">' + (fecha.toLocaleDateString("es-ES", options)) + '</p>';
					}
				},
				{
					"width": "230px",
					"orderable": false,
					"data": function (d) {
						return '<p style="font-size: .8em; width: 230px; text-align:center">' + d.correo + '</p>';
					}
				},
				{
					"width": "90px",
					"orderable": false,
					"data": function (d) {
						return '<p style="font-size: .8em; width:90px; text-align:center">' + d.telefono + '</p>';
					}
				},
				{
					"orderable": false,
					"width": "43%",
					"data": function (d) {
						if (d.servicio == 1)
							var tipo_contrato = 'depilación';
						else if (d.servicio == 2)
							var tipo_contrato = 'moldeo';
						else if (d.servicio == 3)
							var tipo_contrato = 'depilación/moldeo';
						else if (d.servicio == 4)
							var tipo_contrato = 'facial';
						else if (d.servicio == 5)
							var tipo_contrato = 'moldeo/facial';

							var lbl_contrato = '<p class="label-success m-0" style="width: 50%;background-color: #BD98E0;color:white;border-radius: 27px; font-size: 14px">MT-0000' + d.id_contrato + '<br>(' + tipo_contrato + ')</p>';
						var areas_contratadas = '<p style="font-size: .8em">' + d.valor + '</p>';
						return '<center>' + lbl_contrato + '<br>' + areas_contratadas + '</center>';
					}
				},
				{
					"width": "10%",
					"data": function (d) {
						return '<p style="font-size: .8em">' + d.observaciones + '</p>';
					}
				},
				{
					"data": "select",
					"width": "2%",
					"render": function (data, type, row) {
						var default_option = '<option disabled selected >-- SELECCIONA UN DOCUMENTO -- </option>';
						var ine = (row.ife == null || row.ife == '') ? '' : '<option value=' + row.ife + '&ife' + ' > IFE </option>';
						var contrato = (row.contrato == null || row.contrato == '') ? '' : '<option value=' + row.contrato + '&contrato' + ' > CONTRATO </option>';
						var carta = (row.carta == null || row.carta == '') ? '' : '<option value=' + row.carta + '&carta' + ' > CARTA </option>';
						var tarjeta = (row.tarjeta == null || row.tarjeta == '') ? '' : '<option value=' + row.tarjeta + '&tarjeta' + ' > TARJETA </option>';
						var recibo = (row.recibo == null || row.recibo == '') ? '' : '<option value=' + row.recibo + '&recibo' + ' > RECIBO </option>';
						return (ine == '' && contrato == '' && carta == '' && tarjeta == '' && recibo == '') ? 'S/E' : '<select class="see_exp" ></selec>' + default_option + ine + contrato + carta + tarjeta + recibo;

					}
				},
				{
					"width": "3%",
					"orderable": false,
					"data": function (d) {
						var dd = new Date();

						var year = dd.getFullYear();
						var month = dd.getMonth() + 1;
						if (month <= 9) month = '0' + month;
						var date = dd.getDate();
						if (date <= 9) date = "0" + date;
						var allDate = year + "-" + month + "-" + date;
						var dateInitial = allDate + " 00:00:00.000";
						var dateFinal = allDate + " 23:59:99.999";

						var commonsBtns = '';

						if (d.estatus_cl == '1' || d.estatus_cl == '3') {
							if(rol == 1){
									// BOTONES EN COMÚN INDEPENDIENTEMENTE DEL ESTATUS
									commonsBtns = '<button class="dropdown-item ver_info_cliente" data-idContrato="' + d.id_contrato + '" title="Ver datos cliente" value="' + d.id_cliente + '"><i class="fa fa-user" style="color: #69DEB1;"></i> Ver cliente</button>';
									commonsBtns += '<button class="dropdown-item" id="expClients" title="Editar expediente de cliente" data-idContrato="' + d.id_contrato + '" data-idCliente="' + d.id_cliente + '"><i class="fa fa-files-o" style="color: #f96332;"></i> Editar expediente</button>';
									commonsBtns += '<button class="dropdown-item bloquear" title="Bloquear cliente" value="' + d.id_cliente + '"><i class="fa fa-lock" style="color: #D73939;"></i> Bloquear</button>';
									// SE VALIDA FECHA PARA SABER SI SE MANDA REVENTA O REVENTA INSTANTÁNEA
									if (d.fecha_contrato > dateInitial && d.fecha_contrato < dateFinal) { // REVENTA INSTANTÁNEA
										commonsBtns += '<button class="dropdown-item" id="reventaIns" title="Reventa instantánea a cliente" value="' + d.id_contrato + '"><i class="fa fa-undo" style="color: #6a67ce;"></i> Reventa instantánea</button>';
									} else if (d.fecha_contrato < dateInitial) { // REVENTA
										commonsBtns += '<button class="dropdown-item" id="reventa" data-id_cliente="' + d.id_cliente + '" title="Reventa a cliente" value="' + d.id_cliente + '"><i class="fa fa-exchange" style="color: #6a67ce;"></i> Reventa</button>';
									}
									// VALIDACIÓN PARA AGREGAR O EDITAR OBSERVACIONES
									if (d.observaciones == 'No tiene comentarios') { // AGREGAR OBSERVACION, NO TIENE
										commonsBtns += '<button class="dropdown-item observations" title="Agregar observaciones" data-type="1" data-id_contrato="' + d.id_contrato + '" data-observacion="' + d.observaciones + '"><i class="fas fa-comment-medical" style="color: #28B463;"></i> Agregar observación</button>';
									} else { // EDITAR OBBSERVACIÓN
										commonsBtns += '<button class="dropdown-item observations" title="Editar observaciones" data-type="2" data-id_contrato="' + d.id_contrato + '" data-observacion="' + d.observaciones + '"><i class="fas fa-comment-slash" style="color: #2980B9;"></i> Editar observación</button>';
									}

									if(d.estatus != 5){
								commonsBtns += '<button class="dropdown-item cancelar_contrato" title="Editar observaciones" data-type="2"  data-idContrato="' + d.id_contrato + '" data-idCliente="' + d.id_cliente + '"><i class="fas fa-window-close" style="color: #D73939;"></i> Cancelar Contrato</button>';
							}
									// EL CLIENTE ESTÁ BLOQUEADO, SÓLO TIENE LA OPCIÓN PARA DESBLOQUEO
									
							} else {
									commonsBtns = '<button class="dropdown-item ver_info_cliente" data-idContrato="' + d.id_contrato + '" title="Ver datos cliente" value="' + d.id_cliente + '"><i class="fa fa-user" style="color: #69DEB1;"></i> Ver cliente</button>';
									commonsBtns += '<button class="dropdown-item bloquear" title="Bloquear cliente" value="' + d.id_cliente + '"><i class="fa fa-lock" style="color: #D73939;"></i> Bloquear</button>';
							}
									
						} else if (d.estatus_cl == '2') {
							commonsBtns += '<button class="dropdown-item desbloquear" title="Desbloquear" value="' + d.id_cliente + '"><i class="fa fa-lock-open" style="color: #B6B6B6;"></i> Desbloquear</button>';
						}
						// SE ARMA EL DROPDOWN Y SE LE COLOCAN LOS COMMON BTNS Y SE RETORNA FINALBTNS
						var finalBtns = '<div class="nav-item dropdown">' +
							'<button class="btn btn-simple btn-link btn-icon btn-cir nav-link dropdown-toggle" style="height: 25px; width: 25px;" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>' +
							'<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">' +
							'' + commonsBtns + '' +
							'</div>' +
							'</div>';

						return finalBtns;

					}

				},

			],
		});
	}

	$("#listaClientes_form").on('submit', function (e){
		e.preventDefault();
		const finalBeginDate = $("#begin_date").val();
		const finalEndDate = $("#end_date").val();
		fillDataTable(finalBeginDate, finalEndDate);
	});

</script>
</html>
