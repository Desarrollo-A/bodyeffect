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
									<label for="parte_deE">¿Parte de otra zona? <input type="checkbox" name="parte_deE" id="parte_deE" onchange="checkParte();"></label>
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
	</div>
<?php include("footer.php")?>
</div>
</div>
</body>
<script src="<?= base_url("assets/js/controllers/areas_admin.js")?>"></script>
</html>
