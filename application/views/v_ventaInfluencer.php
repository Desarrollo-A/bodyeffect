<?php
require("header.php");
$page = 'influencer';
require("menu.php");
?>
<meta charset='utf-8'>
<!-- Estilos y funciones para select de áreas y multiselect (formas de pago) -->
<link href="<?= base_url("assets/css/v_VentaNueva.css")?>" rel="stylesheet" />
<link href="<?= base_url("assets/css/select2.min.css")?>" rel="stylesheet" />
<link href="<?= base_url("assets/css/bootstrap-multiselect.css")?>" rel="stylesheet"/>
<script src="<?= base_url("assets/js/select2.full.min.js")?>"></script>
<script src="<?= base_url("assets/js/bootstrap-multiselect.js")?>"></script>
<script src="<?= base_url("assets/js/scanner.js")?>" type="text/javascript"></script>

<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col" style="background-color : white;">
				<div class="box">
					<div class="box-body">
						<div class="box-header with-border">
							<div class="">
								<div class="card-body">
									<h3><br>DATOS DEL CLIENTE [INFLUENCER]</h3><br>
									<!-- Nav tabs -->
									<ul class="nav nav-tabs" role="tablist">
										<div class="col-md-1"><li role="presentation" class="active"><a href="#cliente1" aria-controls="cliente1" role="tab" data-toggle="tab" class="clientesSTl">Cliente 1</a></li></div>
										<!--<div class="col-md-1"><li role="presentation"><a href="#cliente2" aria-controls="cliente2" role="tab" data-toggle="tab" class="clientesSTl">Cliente 2</a></li></div>
										<div class="col-md-1"><li role="presentation"><a href="#cliente3" aria-controls="cliente3" role="tab" data-toggle="tab" class="clientesSTl">Cliente 3</a></li></div>
										<div class="col-md-1"><li role="presentation"><a href="#cliente4" aria-controls="cliente4" role="tab" data-toggle="tab" class="clientesSTl">Cliente 4</a></li></div>
										<div class="col-md-1"><li role="presentation"><a href="#cliente5" aria-controls="cliente5" role="tab" data-toggle="tab" class="clientesSTl">Cliente 5</a></li></div>-->
									</ul>
									<form id="miform" method="post">
										<!-- Tab panes -->
										<div class="tab-content">
											<div role="tabpanel" class="tab-pane fade active show" id="cliente1">
												<div class="row">
													<div class="col-md-12 mt-2">
													</div>
												</div>
												<br>
												<div class="row">
													<div class="col-md-2 form-group">
														<input type="text" id="area_sel" name="area_sel" hidden>
														<label>* Nombres</label>
														<input class="form-control field-disabld" name="nombre[]" placeholder="Nombre" autocomplete="off" onkeyup="mayus(this);" onkeypress="return onlyLetters(event)" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
													</div>
													<div class="col-md-2 form-group">
														<label>* Apellido paterno</label>
														<input class="form-control field-disabld" name="apellido_paterno[]" placeholder="Apellido paterno" autocomplete="off" onkeyup="mayus(this);" onkeypress="return onlyLetters(event)" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
													</div>
													<div class="col-md-2 form-group">
														<label>* Apellido materno</label>
														<input class="form-control field-disabld" name="apellido_materno[]" placeholder="Apellido materno" autocomplete="off" onkeyup="mayus(this);" onkeypress="return onlyLetters(event)"  maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
													</div>
													<div class="col-md-2 form-group">
														<label>* Correo electrónico</label>
														<input type="email" class="form-control field-disabld" name="correo[]" placeholder="Correo" autocomplete="off" onkeyup="mayus(this);" maxlength="100"  oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" title="Por favor, introduzca una dirección de correo electrónico válida."/>
													</div>
													<div class="col-md-2 form-group">
														<label>* Teléfono</label>
														<input type="tel" class="form-control field-disabld" name="telefono[]" placeholder="Teléfono" autocomplete="off" minlength="14" maxlength="14" onkeyup="phoneMask(this);">
													</div>
													<div class="col-md-2 form-group text-center">
														<label>¿Es titular?</label>
														<div class="form-check">
															<label class="form-check-label" name="radioT">
																<input title="Persona responsable de pagar paquete(s) contratado(s)." type="radio" class=" form-check-input" name="checkT" value="1" checked>
															</label>
														</div>
														<input class="form-control check1" name="check[]" type="hidden" />
													</div>
												</div>

												<div class="row row-depmod">
													<div class="col-md-12">
														<div class="form-group">
															<div class="container p-0 mb-5">
	                                                            <div class="row">
	                                                                <div class="col-md-10 p-0 text-right">
	                                                                    <input class="form-control field-disabld domicilio" name="domicilio[]" placeholder="Domicilio" autocomplete="off" onkeyup="mayus(this);" onkeypress="return onlyLetters(event)" maxlength="500" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
	                                                                </div>
	                                                                <div class="col-md-2 p-0 text-right">
	                                                                    <button type="button" id="cuerpo-completo1" class="btn cuerpo-completo-btn d-none"><i class="fas fa-child m-1"></i>Cuerpo completo</button>
	                                                                </div>
	                                                            </div>
	                                                        </div>
	                                                        <div class="row areas-depmol">
																<label class="no-mrg">Áreas</label>
																<select class="form-control select-uno select-disabld areas" name="selectPicker[]" multiple>
																	<optgroup class="option-group-d" label="Depilación"></optgroup>
																	<optgroup class="option-group-m" label="Moldeo"></optgroup>
																</select>
																<input class="form-control corte1" name="corte1" type="hidden" value="0" />
																<input class="form-control rate-sl1" type="hidden" value="0.00" />
																<input class="form-control total-areas1" type="hidden" value="0"/>
																<input class="form-control completo-1" type="hidden" value="0"/>
																<input class="form-control idarea" type="hidden" />

																<input class="form-control areas_cp1" type="hidden" value="0"/>
															</div>
														</div>
													</div>
													<br><br>
													<div class="col-md-12 form-group areas-depmol">
														<div class="table-wrapper-scroll-y">
															<table class="table">
																<thead class="thead-dark-first header">
																<tr>
																	<th colspan="5" scope="col" id="flechaDesplegar"><h5 class="no-mrg">Áreas seleccionadas </h5><i class="fa fa-chevron-up" style="float: right;margin-top: -16px;"></i></th>
																</tr>
																</thead>
																<tbody id="tbody-areas1">
																<tr>
																	<th scope="row">No. Área</th>
																	<th scope="row">No. Sesiones</th>
																	<th scope="row">Área</th>
																	<th scope="row">Precio</th>
																	<th scope="row">Tipo</th>
																	<th scope="row" hidden>Clave</th>
																</tr>
																</tbody>
															</table>
														</div>
													</div>
													<div class="col-md-12 areas-depmol">
														<div class="row">
															<div class="col-md-10 d-flex justify-content-end align-items-center">
																<label style="font-size:14px; margin:0">TOTAL</label>
															</div>
															<div class="col-md-2">
																<input class="form-control rate-sl1" value="0.00" style="text-align:center; border:none"/>
															</div>
														</div>
													</div>
												</div>
												<br>
												<br>
												<div class="row row-tratamientos d-none">
													<div class="col-md-12">
														<div class="form-group">
															<label class="no-mrg">Tratamientos rejuvenecimiento facial</label>
															<select class="form-control select-disabld tratamientos" onchange="buildTable(this);" id="select6" multiple>
																<optgroup class="option-group-rf" label="Rejuvenecimiento facial"></optgroup>
															</select>
														</div>
													</div>
													<br>
													<div class="col-md-12 form-group">
														<div class="table-wrapper-scroll-y">
															<table class="table ttratamientos">
																<thead class="thead-dark-first header">
																	<tr>
																		<th colspan="8" scope="col" id="flechaDesplegar_6" class="style-encabezado-tbl"><h5 class="no-mrg">Tratamientos seleccionados</h5><i class="fa fa-chevron-up" style="float: right;margin-top: -16px;"></i></th>
																	</tr>
																</thead>
																<tbody id="tbody-tratamientos6">
																	<tr class="tr-principal">
																		<th scope="row">No. Tratamiento</th>
																		<th scope="row" >Tipo</th>
																		<th scope="row">No. Sesiones</th>
																		<th scope="row">Nombre</th>
																		<th scope="row" style="width:200px">Área</th>
																		<th scope="row">Piezas</th>
																		<th scope="row" >Precio unitario</th>
																		<th scope="row" >Precio total</th>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
													<div class="col-md-12 coltotales_6">
														<div class="row">
															<div class="col-md-10 d-flex justify-content-end align-items-center">
																<label style="font-size:14px; margin:0">TOTAL</label>
															</div>
															<div class="col-md-2">
																<input type="text" class="form-control g-disabld" id="sumat_6" value="0.00" style="text-align:center; border:none">
															</div>
														</div>
													</div>
												</div><!-- END row select2 tratamientos -->
											</div> <!-- End  tabpanel 1-->

											<div role="tabpanel" class="tab-pane fade" id="cliente2">
												<div class="row">
													<div class="col-md-12 mt-2">
														<p class="m-0">Datos cliente 2</p>
													</div>
												</div>
												<br>
												<div class="row">
													<div class="col-md-2 form-group">
														<label>* Nombres</label>
														<input class="form-control field-disabld" name="nombre[]"  placeholder="Nombre" autocomplete="off" onkeyup="mayus(this);" onkeypress="return onlyLetters(event)" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
													</div>
													<div class="col-md-2 form-group">
														<label>* Apellido paterno</label>
														<input class="form-control field-disabld" name="apellido_paterno[]" placeholder="Apellido paterno" autocomplete="off" onkeyup="mayus(this);" onkeypress="return onlyLetters(event)" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
													</div>
													<div class="col-md-2 form-group">
														<label>* Apellido materno</label>
														<input class="form-control field-disabld" name="apellido_materno[]" placeholder="Apellido materno" autocomplete="off" onkeyup="mayus(this);" onkeypress="return onlyLetters(event)" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
													</div>
													<div class="col-md-2 form-group">
														<label>* Correo electrónico</label>
														<input type="email" class="form-control field-disabld" name="correo[]" placeholder="Correo" autocomplete="off" onkeyup="mayus(this);" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" title="Por favor, introduzca una dirección de correo electrónico válida."/>
													</div>
													<div class="col-md-2 form-group">
														<label>* Teléfono</label>
														<input type="number" class="form-control field-disabld" name="telefono[]" placeholder="Teléfono" autocomplete="off" onkeypress="return onlyNumbers(event)" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
													</div>
													<div class="col-md-2 form-group text-center">
														<label>¿Es titular?</label>
														<div class="form-check">
															<label class="form-check-label" name="radioT">
																<input type="radio" class="form-check-input" name="checkT" value="2">
															</label>
														</div>
														<input class="form-control check2" name="check[]" type="hidden" />
													</div>
												</div>

												<div class="row row-depmod">
													<div class="col-md-12">
														<div class="form-group">
															<div class="col-md-12 p-0 text-right">
																<button type="button" id="cuerpo-completo2" class="cuerpo-completo-btn"><i class="fas fa-child m-1"></i>Cuerpo completo</button>
															</div>
															<label class="no-mrg">Áreas</label>
															<select class="form-control select-dos select-disabld areas" name="selectPicker[]" multiple>
																<optgroup class="option-group-d" label="Depilación"></optgroup>
																<optgroup class="option-group-m" label="Moldeo"></optgroup>
															</select>
															<input class="form-control corte2" name="corte2" type="hidden" value="0" />
															<input class="form-control rate-sl2" type="hidden" value="0.00" />
															<input class="form-control total-areas2" type="hidden" value="0"/>
															<input class="form-control completo-2" type="hidden" value="0"/>
															<input class="form-control idarea2" type="hidden" />

															<input class="form-control areas_cp2" type="hidden" value="0"/>
														</div>
													</div>
													<br><br>
													<div class="col-md-12 form-group">
														<div class="table-wrapper-scroll-y">
															<table class="table">
																<thead class="thead-dark-first">
																<tr>
																	<th colspan="5" scope="col"><h5>Áreas seleccionadas</h5></th>
																</tr>
																</thead>
																<tbody id="tbody-areas2">
																<tr>
																	<th scope="row">No. Área</th>
																	<th scope="row">No. Sesiones</th>
																	<th scope="row">Área</th>
																	<th scope="row">Precio</th>
																	<th scope="row">Tipo</th>
																	<th scope="row" hidden>Clave</th>
																</tr>
																</tbody>
															</table>
														</div>
													</div>
													<div class="col-md-12">
														<div class="row">
															<div class="col-md-10 d-flex justify-content-end align-items-center">
																<label style="font-size:14px; margin:0">TOTAL</label>
															</div>
															<div class="col-md-2">
																<input class="form-control rate-sl2" value="0.00" style="text-align:center; border:none"/>
															</div>
														</div>
													</div>
												</div><!-- END row select2 áreas y btn cuerpo completo -->
												<br>
												<br>
												<div class="row row-tratamientos d-none">
													<div class="col-md-12">
														<div class="form-group">
															<label class="no-mrg">Tratamientos rejuvenecimiento facial</label>
															<select class="form-control select-disabld tratamientos" onchange="buildTable(this);" id="select7" multiple>
																<optgroup class="option-group-rf" label="Rejuvenecimiento facial"></optgroup>
															</select>
														</div>
													</div>
													<br>
													<div class="col-md-12 form-group">
														<div class="table-wrapper-scroll-y">
															<table class="table ttratamientos">
																<thead class="thead-dark-first header">
																	<tr>
																		<th colspan="8" scope="col" id="flechaDesplegar_7" class="style-encabezado-tbl"><h5 class="no-mrg">Tratamientos seleccionados </h5><i class="fa fa-chevron-up" style="float: right;margin-top: -16px;"></i></th>
																	</tr>
																</thead>
																<tbody id="tbody-tratamientos7">
																	<tr class="tr-principal">
																		<th scope="row">No. Tratamiento</th>
																		<th scope="row" >Tipo</th>
																		<th scope="row">No. Sesiones</th>
																		<th scope="row">Nombre</th>
																		<th scope="row">Área</th>
																		<th scope="row">Piezas</th>
																		<th scope="row" >Precio unitario</th>
																		<th scope="row" >Precio total</th>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
													<div class="col-md-12 coltotales_7">
														<div class="row">
															<div class="col-md-10 d-flex justify-content-end align-items-center">
																<label style="font-size:14px; margin:0">TOTAL</label>
															</div>
															<div class="col-md-2">
																<input type="text" class="form-control g-disabld" id="sumat_7" value="0.00" onChange="" onkeypress="return onlyNumbers(event)" style="text-align:center; border:none">
															</div>
														</div>
													</div>
												</div><!-- END row select2 tratamientos -->
											</div> <!-- End tabpanel 2 -->



											<div role="tabpanel" class="tab-pane fade" id="cliente3">
												<div class="row">
													<div class="col-md-12 mt-2">
														<p class="m-0">Datos cliente 3</p>
													</div>
												</div>
												<br>
												<div class="row">
													<div class="col-md-2 form-group">
														<label>* Nombres</label>
														<input class="form-control field-disabld" name="nombre[]"  placeholder="Nombre" autocomplete="off" onkeyup="mayus(this);" onkeypress="return onlyLetters(event)" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
													</div>
													<div class="col-md-2 form-group">
														<label>* Apellido paterno</label>
														<input class="form-control field-disabld" name="apellido_paterno[]" placeholder="Apellido paterno" autocomplete="off" onkeyup="mayus(this);" onkeypress="return onlyLetters(event)" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
													</div>
													<div class="col-md-2 form-group">
														<label>* Apellido materno</label>
														<input class="form-control field-disabld" name="apellido_materno[]" placeholder="Apellido materno" autocomplete="off" onkeyup="mayus(this);" onkeypress="return onlyLetters(event)" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
													</div>
													<div class="col-md-2 form-group">
														<label>* Correo electrónico</label>
														<input type="email" class="form-control field-disabld" name="correo[]" placeholder="Correo" autocomplete="off" onkeyup="mayus(this);" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" title="Por favor, introduzca una dirección de correo electrónico válida."/>
													</div>
													<div class="col-md-2 form-group">
														<label>* Teléfono</label>
														<input type="number" class="form-control field-disabld" name="telefono[]" placeholder="Teléfono" autocomplete="off" onkeypress="return onlyNumbers(event)" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
													</div>
													<div class="col-md-2 form-group text-center">
														<label>¿Es titular?</label>
														<div class="form-check">
															<label class="form-check-label" name="radioT">
																<input type="radio" class="form-check-input" name="checkT" value="3">
															</label>
														</div>
														<input class="form-control check3" name="check[]" type="hidden" />
													</div>
												</div>

												<div class="row row-depmod">
													<div class="col-md-12">
														<div class="form-group">
															<div class="col-md-12 p-0 text-right">
																<button type="button" id="cuerpo-completo3" class="cuerpo-completo-btn"><i class="fas fa-child m-1"></i>Cuerpo completo</button>
															</div>
															<label class="no-mrg">Áreas</label>
															<select class="form-control select-tres select-disabld areas" name="selectPicker[]" multiple>
																<optgroup class="option-group-d" label="Depilación"></optgroup>
																<optgroup class="option-group-m" label="Moldeo"></optgroup>
															</select>
															<input class="form-control corte3" name="corte3" type="hidden" value="0" />
															<input class="form-control rate-sl3" type="hidden" value="0.00" />
															<input class="form-control total-areas3" type="hidden" value="0"/>
															<input class="form-control completo-3" type="hidden" value="0"/>
															<input class="form-control idarea3" type="hidden" />

															<input class="form-control areas_cp3" type="hidden" value="0"/>
														</div>
													</div>
													<br><br>
													<div class="col-md-12 form-group">
														<div class="table-wrapper-scroll-y">
															<table class="table">
																<thead class="thead-dark-first">
																<tr>
																	<th colspan="5" scope="col"><h5>Áreas seleccionadas</h5></th>
																</tr>
																</thead>
																<tbody id="tbody-areas3">
																<tr>
																	<th scope="row">No. Área</th>
																	<th scope="row">No. Sesiones</th>
																	<th scope="row">Área</th>
																	<th scope="row">Precio</th>
																	<th scope="row">Tipo</th>
																	<th scope="row" hidden>Clave</th>
																</tr>
																</tbody>
															</table>
														</div>
													</div>
													<div class="col-md-12">
														<div class="row">
															<div class="col-md-10 d-flex justify-content-end align-items-center">
																<label style="font-size:14px; margin:0">TOTAL</label>
															</div>
															<div class="col-md-2">
																<input class="form-control rate-sl3" value="0.00" style="text-align:center; border:none"/>
															</div>
														</div>
													</div>
												</div><!-- END row select2 áreas y btn cuerpo completo -->
												<br>
												<br>
												<div class="row row-tratamientos d-none">
													<div class="col-md-12">
														<div class="form-group">
															<label class="no-mrg">Tratamientos rejuvenecimiento facial</label>
															<select class="form-control select-disabld tratamientos" onchange="buildTable(this);" id="select8" multiple>
																<optgroup class="option-group-rf" label="Rejuvenecimiento facial"></optgroup>
															</select>
														</div>
													</div>
													<br>
													<div class="col-md-12 form-group">
														<div class="table-wrapper-scroll-y">
															<table class="table ttratamientos">
																<thead class="thead-dark-first header">
																	<tr>
																		<th colspan="8" scope="col" id="flechaDesplegar_8" class="style-encabezado-tbl"><h5 class="no-mrg">Tratamientos seleccionados </h5><i class="fa fa-chevron-up" style="float: right;margin-top: -16px;"></i></th>
																	</tr>
																</thead>
																<tbody id="tbody-tratamientos8">
																	<tr class="tr-principal">
																		<th scope="row">No. Tratamiento</th>
																		<th scope="row" >Tipo</th>
																		<th scope="row">No. Sesiones</th>
																		<th scope="row">Nombre</th>
																		<th scope="row">Área</th>
																		<th scope="row">Piezas</th>
																		<th scope="row" >Precio unitario</th>
																		<th scope="row" >Precio total</th>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
													<div class="col-md-12 coltotales_8">
														<div class="row">
															<div class="col-md-10 d-flex justify-content-end align-items-center">
																<label style="font-size:14px; margin:0">TOTAL</label>
															</div>
															<div class="col-md-2">
																<input type="text" class="form-control g-disabld" id="sumat_8" value="0.00" style="text-align:center; border:none">
															</div>
														</div>
													</div>
												</div><!-- END row select2 tratamientos -->
											</div> <!-- End tabpanel 3 -->

											<div role="tabpanel" class="tab-pane fade" id="cliente4">
												<div class="row">
													<div class="col-md-12 mt-2">
														<p class="m-0">Datos cliente 4</p>
													</div>
												</div>
												<br>
												<div class="row">
													<div class="col-md-2 form-group">
														<label>* Nombres</label>
														<input class="form-control field-disabld" name="nombre[]"  placeholder="Nombre" autocomplete="off" onkeyup="mayus(this);" onkeypress="return onlyLetters(event)" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
													</div>
													<div class="col-md-2 form-group">
														<label>* Apellido paterno</label>
														<input class="form-control field-disabld" name="apellido_paterno[]" placeholder="Apellido paterno" autocomplete="off" onkeyup="mayus(this);" onkeypress="return onlyLetters(event)" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
													</div>
													<div class="col-md-2 form-group">
														<label>* Apellido materno</label>
														<input class="form-control field-disabld" name="apellido_materno[]" placeholder="Apellido materno" autocomplete="off" onkeyup="mayus(this);" onkeypress="return onlyLetters(event)" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
													</div>
													<div class="col-md-2 form-group">
														<label>* Correo electrónico</label>
														<input type="email" class="form-control field-disabld" name="correo[]" placeholder="Correo" autocomplete="off" onkeyup="mayus(this);" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" title="Por favor, introduzca una dirección de correo electrónico válida."/>
													</div>
													<div class="col-md-2 form-group">
														<label>* Teléfono</label>
														<input type="number" class="form-control field-disabld" name="telefono[]" placeholder="Teléfono" autocomplete="off" onkeypress="return onlyNumbers(event)" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
													</div>
													<div class="col-md-2 form-group text-center">
														<label>¿Es titular?</label>
														<div class="form-check">
															<label class="form-check-label" name="radioT">
																<input type="radio" class="form-check-input" name="checkT" value="4">
															</label>
														</div>
														<input class="form-control check4" name="check[]" type="hidden" />
													</div>
												</div>

												<div class="row row-depmod">
													<div class="col-md-12">
														<div class="form-group">
															<div class="col-md-12 p-0 text-right">
																<button type="button" id="cuerpo-completo4" class="cuerpo-completo-btn"><i class="fas fa-child m-1"></i>Cuerpo completo</button>
															</div>
															<label class="no-mrg">Áreas</label>
															<select class="form-control select-cuatro select-disabld areas" name="selectPicker[]" multiple>
																<optgroup class="option-group-d" label="Depilación"></optgroup>
																<optgroup class="option-group-m" label="Moldeo"></optgroup>
															</select>
															<input class="form-control corte4" name="corte4" type="hidden" value="0" />
															<input class="form-control rate-sl4" type="hidden" value="0.00" />
															<input class="form-control total-areas4" type="hidden" value="0"/>
															<input class="form-control completo-4" type="hidden" value="0"/>
															<input class="form-control idarea4" type="hidden" />

															<input class="form-control areas_cp4" type="hidden" value="0"/>
														</div>
													</div>
													<br><br>
													<div class="col-md-12 form-group">
														<div class="table-wrapper-scroll-y">
															<table class="table">
																<thead class="thead-dark-first">
																<tr>
																	<th colspan="5" scope="col"><h5>Áreas seleccionadas</h5></th>
																</tr>
																</thead>
																<tbody id="tbody-areas4">
																<tr>
																	<th scope="row">No. Área</th>
																	<th scope="row">No. Sesiones</th>
																	<th scope="row">Área</th>
																	<th scope="row">Precio</th>
																	<th scope="row">Tipo</th>
																	<th scope="row" hidden>Clave</th>
																</tr>
																</tbody>
															</table>
														</div>
													</div>
													<div class="col-md-12">
														<div class="row">
															<div class="col-md-10 d-flex justify-content-end align-items-center">
																<label style="font-size:14px; margin:0">TOTAL</label>
															</div>
															<div class="col-md-2">
																<input class="form-control rate-sl4" value="0.00" style="text-align:center; border:none"/>
															</div>
														</div>
													</div>
												</div><!-- END row select2 áreas y btn cuerpo completo -->
												<br>
												<br>
												<div class="row row-tratamientos d-none">
													<div class="col-md-12">
														<div class="form-group">
															<label class="no-mrg">Tratamientos rejuvenecimiento facial</label>
															<select class="form-control select-disabld tratamientos" onchange="buildTable(this);" id="select9" multiple>
																<optgroup class="option-group-rf" label="Rejuvenecimiento facial"></optgroup>
															</select>
														</div>
													</div>
													<br>
													<div class="col-md-12 form-group">
														<div class="table-wrapper-scroll-y">
															<table class="table ttratamientos">
																<thead class="thead-dark-first header">
																	<tr>
																		<th colspan="8" scope="col" id="flechaDesplegar_9" class="style-encabezado-tbl"><h5 class="no-mrg">Tratamientos seleccionados </h5><i class="fa fa-chevron-up" style="float: right;margin-top: -16px;"></i></th>
																	</tr>
																</thead>
																<tbody id="tbody-tratamientos9">
																	<tr class="tr-principal">
																		<th scope="row">No. Tratamiento</th>
																		<th scope="row" >Tipo</th>
																		<th scope="row">No. Sesiones</th>
																		<th scope="row">Nombre</th>
																		<th scope="row">Área</th>
																		<th scope="row">Piezas</th>
																		<th scope="row" >Precio unitario</th>
																		<th scope="row" >Precio total</th>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
													<div class="col-md-12 coltotales_9">
														<div class="row">
															<div class="col-md-10 d-flex justify-content-end align-items-center">
																<label style="font-size:14px; margin:0">TOTAL</label>
															</div>
															<div class="col-md-2">
																<input type="text" class="form-control g-disabld" id="sumat_9" value="0.00" style="text-align:center; border:none">
															</div>
														</div>
													</div>
												</div><!-- END row select2 tratamientos -->
											</div> <!-- End tabpanel 4 -->



											<div role="tabpanel" class="tab-pane fade" id="cliente5">
												<div class="row">
													<div class="col-md-12 mt-2">
														<p class="m-0">Datos cliente 5</p>
													</div>
												</div>
												<br>
												<div class="row">
													<div class="col-md-2 form-group">
														<label>* Nombres</label>
														<input class="form-control field-disabld" name="nombre[]"  placeholder="Nombre" autocomplete="off" onkeyup="mayus(this);" onkeypress="return onlyLetters(event)" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
													</div>
													<div class="col-md-2 form-group">
														<label>* Apellido paterno</label>
														<input class="form-control field-disabld" name="apellido_paterno[]" placeholder="Apellido paterno" autocomplete="off" onkeyup="mayus(this);" onkeypress="return onlyLetters(event)" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
													</div>
													<div class="col-md-2 form-group">
														<label>* Apellido materno</label>
														<input class="form-control field-disabld" name="apellido_materno[]" placeholder="Apellido materno" autocomplete="off" onkeyup="mayus(this);" onkeypress="return onlyLetters(event)" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
													</div>
													<div class="col-md-2 form-group">
														<label>* Correo electrónico</label>
														<input type="email" class="form-control field-disabld" name="correo[]" placeholder="Correo" autocomplete="off" onkeyup="mayus(this);" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" title="Por favor, introduzca una dirección de correo electrónico válida."/>
													</div>
													<div class="col-md-2 form-group">
														<label>* Teléfono</label>
														<input type="number" class="form-control field-disabld" name="telefono[]" placeholder="Teléfono" autocomplete="off" onkeypress="return onlyNumbers(event)" maxlength="10" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
													</div>
													<div class="col-md-2 form-group text-center">
														<label>¿Es titular?</label>
														<div class="form-check">
															<label class="form-check-label" name="radioT">
																<input type="radio" class=" form-check-input" name="checkT" value="5">
															</label>
														</div>
														<input class="form-control check5" name="check[]" type="hidden" />
													</div>
												</div>

												<div class="row row-depmod">
													<div class="col-md-12">
														<div class="form-group">
															<div class="col-md-12 p-0 text-right">
																<button type="button" id="cuerpo-completo5" class="cuerpo-completo-btn"><i class="fas fa-child m-1"></i>Cuerpo completo</button>
															</div>
															<label class="no-mrg">Áreas</label>
															<select class="form-control select-cinco select-disabld areas" name="selectPicker[]" multiple>
																<optgroup class="option-group-d" label="Depilación"></optgroup>
																<optgroup class="option-group-m" label="Moldeo"></optgroup>
															</select>
															<input class="form-control corte5" name="corte5" type="hidden" value="0" />
															<input class="form-control rate-sl5" type="hidden" value="0.00" />
															<input class="form-control total-areas5" type="hidden" value="0"/>
															<input class="form-control completo-5" type="hidden" value="0"/>
															<input class="form-control idarea5" type="hidden" />

															<input class="form-control areas_cp5" type="hidden" value="0"/>
														</div>
													</div>
													<br><br>
													<div class="col-md-12 form-group">
														<div class="table-wrapper-scroll-y">
															<table class="table">
																<thead class="thead-dark-first">
																<tr>
																	<th colspan="5" scope="col"><h5>Áreas seleccionadas</h5></th>
																</tr>
																</thead>
																<tbody id="tbody-areas5">
																<tr>
																	<th scope="row">No. Área</th>
																	<th scope="row">No. Sesiones</th>
																	<th scope="row">Área</th>
																	<th scope="row">Precio</th>
																	<th scope="row">Tipo</th>
																	<th scope="row" hidden>Clave</th>
																</tr>
																</tbody>
															</table>
														</div>
													</div>
													<div class="col-md-12">
														<div class="row">
															<div class="col-md-10 d-flex justify-content-end align-items-center">
																<label style="font-size:14px; margin:0">TOTAL</label>
															</div>
															<div class="col-md-2">
																<input class="form-control rate-sl5" value="0.00" style="text-align:center; border:none"/>
															</div>
														</div>
													</div>
												</div><!-- END row select2 áreas y btn cuerpo completo -->
												<br>
												<br>
												<div class="row row-tratamientos d-none">
													<div class="col-md-12">
														<div class="form-group">
															<label class="no-mrg">Tratamientos rejuvenecimiento facial</label>
															<select class="form-control select-disabld tratamientos" onchange="buildTable(this);" id="select10" multiple>
																<optgroup class="option-group-rf" label="Rejuvenecimiento facial"></optgroup>
															</select>
														</div>
													</div>
													<br>
													<div class="col-md-12 form-group">
														<div class="table-wrapper-scroll-y">
															<table class="table ttratamientos">
																<thead class="thead-dark-first header">
																	<tr>
																		<th colspan="8" scope="col" id="flechaDesplegar_10"><h5 class="no-mrg">Tratamientos seleccionados</h5><i class="fa fa-chevron-up" style="float: right;margin-top: -16px;"></i></th>
																	</tr>
																</thead>
																<tbody id="tbody-tratamientos10">
																	<tr class="tr-principal">
																		<th scope="row">No. Tratamientos</th>
																		<th scope="row" >Tipo</th>
																		<th scope="row">No. Sesiones</th>
																		<th scope="row">Nombre</th>
																		<th scope="row">Área</th>
																		<th scope="row">Piezas</th>
																		<th scope="row" >Precio unitario</th>
																		<th scope="row" >Precio total</th>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
													<div class="col-md-12 coltotales_10">
														<div class="row">
															<div class="col-md-10 d-flex justify-content-end align-items-center">
																<label style="font-size:14px; margin:0">TOTAL</label>
															</div>
															<div class="col-md-2">
																<input type="text" class="form-control g-disabld" id="sumat_10" value="0.00" style="text-align:center; border:none">
															</div>
														</div>
													</div>
												</div><!-- END row select2 tratamientos -->
											</div> <!-- End tabpanel 5 -->
											
											<input class="form-control total-areasCP" type="hidden" id="num-areasCP" value="0" />
											<div class="box-anticipo d-none">
												<h3>DETALLE DE COBRANZA</h3><br>
												<div class="row">
													<div class="col-md-2 pr-1">
														<div class="form-group">
															<label style="font-size:14px">Total rejuvenecimiento</label>
															<input type="number" class="form-control" id="totalrf" name="totalrf" autocomplete="off" value="0" readonly>
														</div>
													</div>
													<div class="col-md-2 pr-1" style="display:none;">
														<div class="form-group">
															<label></label>
															<input type="number" class="form-control" name="total" id="total" placeholder="Total" autocomplete="off" value="0.00" readonly onkeypress="return onlyNumbers(event)">
														</div>
													</div>
													<div class="col-md-2 pr-1" style="display:none;">
														<div class="form-group">
															<label>Descuento</label>
															<input type="text" class="form-control" name="descuento" id="descuento" placeholder="Descuento" autocomplete="off" value="0.00" readonly onkeypress="return onlyNumbers(event)">
															<input class="form-control total-areas" type="hidden" id="num-areas" value="0" />
															<input class="form-control total-Cuerpocompleto" type="hidden" id="num-areas" value="0" />

														</div>
													</div>
													<div class="col-md-2 pr-1">
														<div class="form-group">
															<label style="font-size:14px">Total depilación / moldeo</label>
															<input type="text" class="form-control g-disabld precioFinal" name="precioFinal" autocomplete="off" value="0.00" onChange="changePriceDepMol();" onkeypress="return onlyNumbers(event)">
															<input type="hidden" class="form-control precioFinal2" name="precioFinal2" autocomplete="off" value="0.00">
														</div>
													</div>
													<div class="col-md-2 pr-1">
														<div class="form-group">
															<label><b>COSTO FINAL</b></label>
															<input type="text" class="form-control g-disabld" name="precioFinalC" id="precioFinalC" readonly>
														</div>
													</div>
													<div class="col-md-2 pr-1 d-none">
														<div class="form-group">
															<label style="font-size:14px">Saldo pendiente a cubrir</label>
															<input type="text" class="form-control" name="saldoPendiente" id="saldoPendiente" placeholder="Saldo pendiente" autocomplete="off" value="0.00" readonly onkeypress="return onlyNumbers(event)">
														</div>
													</div>
													<div class="col-md-2 pr-1 d-none">
														<div class="form-group">
															<label>Anticipo</label>
															<input type="number" class="form-control g-disabld" name="pagoCon" id="pagoCon" placeholder="0.00" autocomplete="off" onChange="validateAdvance(); changeAPagar(); valorMensualidad(); deselectMulti();" onkeypress="return onlyNumbers(event)" onkeyup="changeAPagar(); valorMensualidad(); changeEntrance(); deselectMulti();">
														</div>
													</div>
													<div class="col-md-3 pr-1">
														<div class="form-group" style="display:grid">
															<label>Forma de pago <b>(anticipo)</b></label>
															<select id="formaPago" class="form-control g-disabld" autocomplete="off" multiple="multiple" onchange="changePay(); changeEntrance(); changeAPagar();" disabled>
																<option value='5' class="infRequired" selected>Convenio Influencer</option>
															</select>
															<input type="hidden" name="formaPago[]" value="5">
														</div>
													</div>
													
													<div class="col-md-9">
														<div class="form-group box-pagos">
															<label>Observaciones</label>
															<textarea id="observaciones" name="observaciones" class="form-control"></textarea>
														</div> 
													</div>  
													<div class="col-md-3 d-none">
														<div class="form-group box-pagos">
															<label>Pagos por cubrir <b>(finiquito)</b></label>
															<select id="parcialidades" name="parcialidades" class="form-control g-disabld" autocomplete="off" onChange="valorMensualidad();">
															</select>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12 pr-1" id="monthly-payments"><h5><b>Servicio liquidado</b></h5></div>
												</div>
											</div>
											<br>

											<div class="row d-none">
												<div class="col-md-12 pr-1" id="monthly-inputs">
												</div>
											</div>

											<h3 class="payment-title d-none">FORMA DE PAGO DEL ANTICIPO</h3><br>
											<div id="box-cash" class="d-none mb-5">
												<div class="row">
													<div class="col-md-10">
														<div class="form-group">
															<label>Efectivo</label>
															<input type="text" class="form-control g-disabld" name="efectivo" id="efectivo" value="0.00" autocomplete="off"  onkeypress="return onlyNumbers(event)" onkeyup="changeEntrance(); changeAPagar(); evalueEntranceE(this.value);">
														</div>
													</div>
													<div class="col-md-2" style="display:grid; justify-items:center">
														<label for="protegida">Venta protegida</label>
														<input id="protegida" name="protegida" class="tarRequired g-disabld" type="checkbox"/>
													</div>
												</div>
											</div>
											<h4 id="lblProtegida" class="d-none"><b>Venta protegida para finiquito</b></h4>
											<div id="box-card" class="d-none">
												<label class="lblTipoCard"></label>
												<ul class="nav nav-tabs" role="tablist">
													<div class="col-md-1" id="tabtjt1">
														<li role="presentation" class="active">
															<a href="#tarjeta1" aria-controls="tarjeta1" role="tab" data-toggle="tab">Tarjeta 1</a>
														</li>
													</div>
													<div class="col-md-1" id="tabtjt2">
														<li role="presentation"><a href="#tarjeta2" aria-controls="tarjerta2" role="tab" data-toggle="tab">Tarjeta 2</a></li>
													</div>
												</ul>
												<div class="tab-content">
													<div role="tabpanel" class="tab-pane fade active show" id="tarjeta1">
														<div class="row mt-3">
															<div class="col-sm-12">
																<label><b>Datos tarjeta 1</b></label>
															</div>
														</div>
														<div class="row">
															<div class="col-md-3 pr-1">
																<div class="form-group">

																	<label>¿Tarjeta para pago recurrente?</label>
																	<select id="tp1" name="tarjetaPrimaria[]" class="form-control g-disabld" autocomplete="off">
																		<option value="2" data-value="7">No</option>
																		<option value="1" data-value="7" selected>Si</option>
																	</select>
																</div>
															</div>
															<!-- <div class="col-md-3 pr-1">
																<div class="form-group">
																	<label>Tipo cobro</label>
																	<select  name="tipoCobro[]" id="tipoCobro" class="form-control listado-tiposCobro g-disabld" autocomplete="off">
																		<option value="0">Seleccione una opción</option>
																	</select>
																</div>
															</div> -->
															<div class="col-md-4">
																<div class="from-group colCreDeb">
																	<label>Tipo de tarjeta</label>
																	<select name="tipoCreDeb[]" id="changeTipoTar1"
																			class="form-control g-disabld">
																		<option value="">Seleccione opción</option>
																		<option value="1">Crédito</option>
																		<option value="2">Débito</option>
																	</select>
																</div>
															</div>
															<div class="col-md-2">
																<div class="from-group box-monto">
																	<label>Monto:</label>
																	<input type="text" class="form-control g-disabld" name="montoT[]" id="montoTU" autocomplete="off" value = "0.00" onkeypress="return onlyNumbers(event)" onkeyup="changeEntrance(); changeAPagar(); evalueEntranceTU(this.value)">
																</div>
															</div>
															<div class="col-md-3">
																<div class="from-group box-msi d-none">
																	<label>MSI:</label>
																	<select id="msi1" name="msi[]" class="form-control g-disabld">
																		<option value="">Seleccione una opción</option>
																	</select>
																</div>
															</div>
														</div>
														<div class="row mPagoTarjeta">
															<div class="col-md-2 pr-1">
																<div class="form-group">
																	<label>Número de tarjeta</label>
																	<input class="form-control g-disabld" name="cardNumber[]" id="cardNumber" placeholder="XXXX XXXX XXXX XXXX" autocomplete="off" maxlength="19">
																</div>
															</div>
															<div class="col-md-1 pr-1">
																<div class="form-group">
																	<label>MM</label>
																	<input type="number" class="form-control g-disabld" name="mes[]" id="mes" placeholder="MM" autocomplete="off" onkeypress="return onlyNumbers(event)" maxlength="2" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
																</div>
															</div>
															<div class="col-md-1 pr-1">
																<div class="form-group">
																	<label>AA</label>
																	<input type="number" class="form-control g-disabld" name="anio[]" id="anio" placeholder="AA" autocomplete="off" onkeypress="return onlyNumbers(event)" maxlength="2" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
																</div>
															</div>

															<div class="col-md-3 pr-1">
																<div class="form-group">
																	<label>Nombre en la tarjeta</label>
																	<input type="text" class="form-control g-disabld" name="nameInCard[]" id="nameInCard" onkeyup="mayus(this);" placeholder="Nombre" autocomplete="off" onkeypress="return onlyLetters(event)" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
																</div>
															</div>
															<div class="col-md-2 pr-1">
																<div class="form-group">
																	<label>Compañia</label>
																	<select  name="tipoTarjeta[]" id="tipoTarjeta" class="form-control listado-tipos g-disabld" autocomplete="off">
																		<option value="">Seleccione una opción</option>
																	</select>
																</div>
															</div>
															<div class="col-md-2 pr-1">
																<div class="form-group">
																	<label>Institución bancaria</label>
																	<select name="banco[]" id="banco" class="form-control listado-bancos g-disabld myselect" autocomplete="off">
																		<option value="">Seleccione una opción</option>
																	</select>
																</div>
															</div>
															<div class="col-md-1 pr-1">
																<div class="form-group box-referencia">
																	<label>Referencia:</label>
																	<input type="text" class="form-control g-disabld referencia" name="referencia[]" id="referencia" autocomplete="off">
																</div>
															</div>
														</div>
													</div> <!-- End tab-pane tarjeta 1-->
													<div role="tabpanel" class="tab-pane fade .error" id="tarjeta2">
														<div class="row mt-3">
															<div class="col-sm-12">
																<label><b>Datos tarjeta 2</b></label>
															</div>
														</div>
														<div class="row mt-3">
															<div class="col-md-3 pr-1">
																<div class="form-group">
																	<label>¿Tarjeta para pago recurrente?</label>
																	<select id="tp2" name="tarjetaPrimaria[]" class="form-control g-disabld" autocomplete="off">
																		<option value="2" data-value="7" selected>No</option>
																		<option value="1" data-value="7">Si</option>
																	</select>
																</div>
															</div>
															<!-- <div class="col-md-3 pr-1">
																<div class="form-group">
																	<label>Tipo cobro</label>
																	<select name="tipoCobro[]" id="tipoCobro2" class="form-control listado-tiposCobro g-disabld" autocomplete="off">
																		<option value="0">
																		Seleccione una opción
																		</option>
																	</select>
																</div>
															</div> -->
															<div class="col-md-4">
																<div class="from-group colCreDeb">
																	<label>Tipo de tarjeta</label>
																	<select name="tipoCreDeb[]" id="changeTipoTar2" class="form-control g-disabld">
																		<option value="">
																			Seleccione opción
																		</option>
																		<option value="1">
																			Crédito
																		</option>
																		<option value="2">
																			Débito
																		</option>
																	</select>
																</div>
															</div>
															<div class="col-md-2">
																<div class="from-group">
																	<label>Monto:</label>
																	<input type="text" class="form-control g-disabld" name="montoT[]" id="montoTD" autocomplete="off" value = "0.00" onkeypress="return onlyNumbers(event)" onkeyup="changeEntrance(); changeAPagar(); evalueEntranceTD(this.value)">
																</div>
															</div>
															<div class="col-md-3">
																<div class="from-group box-msi2 d-none">
																	<label>MSI:</label>
																	<select id="msi2" name="msi[]" class="form-control g-disabld">
																	</select>
																</div>
															</div>
														</div>
														<div class="row mPagoTarjeta">
															<br>
															<div class="col-md-2 pr-1">
																<div class="form-group">
																	<label>Número de tarjeta</label>
																	<input class="form-control g-disabld" name="cardNumber[]" id="cardNumber2" placeholder="XXXX XXXX XXXX XXXX" autocomplete="off" maxlength="19">
																</div>
															</div>
															<div class="col-md-1 pr-1">
																<div class="form-group">
																	<label>MM</label>
																	<input type="number" class="form-control g-disabld" name="mes[]" id="mes2" placeholder="MM" autocomplete="off" onkeypress="return onlyNumbers(event)" maxlength="2" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
																</div>
															</div>
															<div class="col-md-1 pr-1">
																<div class="form-group">
																	<label>AA</label>
																	<input type="number" class="form-control g-disabld" name="anio[]" id="anio2" placeholder="AA" autocomplete="off" onkeypress="return onlyNumbers(event)" maxlength="2" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
																</div>
															</div>
															<div class="col-md-3 pr-1">
																<div class="form-group">
																	<label>Nombre en la tarjeta</label>
																	<input type="text" class="form-control g-disabld" name="nameInCard[]" id="nameInCard2" onkeyup="mayus(this);" placeholder="Nombre" autocomplete="off" onkeypress="return onlyLetters(event)" maxlength="100" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
																</div>
															</div>
															<div class="col-md-2 pr-1">
																<div class="form-group">
																	<label>Tipo</label>
																	<select name="tipoTarjeta[]" id="tipoTarjeta2" class="form-control listado-tipos g-disabld" autocomplete="off">
																		<option value="">Seleccione una opción</option>
																	</select>
																</div>
															</div>
															<div class="col-md-2 pr-1">
																<div class="form-group">
																	<label>Institución bancaria</label>
																	<select name="banco[]" id="banco2" class="form-control listado-bancos g-disabld myselect" autocomplete="off">
																		<option value="">Seleccione una opción</option>
																	</select>
																</div>
															</div>
															<div class="col-md-1 pr-1">
																<div class="form-group box-referencia">
																	<label>Referencia:</label>
																	<input type="text" class="form-control g-disabld referencia" name="referencia[]" id="referencia" autocomplete="off">
																</div>
															</div>
														</div>
													</div> <!-- End tab-pane tarjeta 2-->
												</div> <!-- End tab-content general tarjetas-->
											</div> <!-- End div box-card-->
											<br>
											<hr>
											<div class="box-detalle-fin d-none">
												<div class="row">
													<!-- <div class="col-sm-5">
														<div class="row">
															<div class="col-sm-6">
																<label for="compartida">
																	Venta compartida
																</label>
															</div>
															<div class="col-sm-6">
																<input id="compartida" class="g-disabld" name="compartida" type="checkbox"/>
															</div>
														</div>
														<div class="row">
															<div class="col-sm-12 box-compartida select-disabld d-none">
																<select id="enfermeras" name="enfermeras" class="select-disabld form-control listado-enfermeras"></select>
															</div>
														</div>
													</div> -->

													<div class="col-sm-7">
														<div class="row">
															<div class="col-sm-10 text-right">
																<p>A pagar anticipo:</p>
															</div>
															<div class="col-sm-2">
																<input type="number" class="form-control" name="aPagar" id="aPagar" placeholder="0.00" disabled>
															</div>
														</div>
														<div class="row">
															<div class="col-sm-10 text-right">
																<p>Entrada:</p>
															</div>
															<div class="col-sm-2">
																<input type="number" class="form-control" name="entrada" id="entrada" placeholder="0.00" disabled>
															</div>
														</div>
													</div>
												</div>
											</div>

											<br>
											<div class="row">
												<div class="col-md-12">
													<center><button id="btnsubmit" type="submit" class="btn" disabled>Finalizar venta</button></center>
												</div>
											</div> <!-- End row submit button -->
											<div class="row" id="documentsTable" style="display:none">
												<div class="col-md-12 pr-1">
													<table class="table">
														<thead class="thead-dark-first">
														<tr>
															<th colspan="2" scope="col"><h5>Documentos</h5></th>
														</tr>
														</thead>
														<tbody>
														<!-- <tr>
															<th scope="row">Recibo de Pago</th>
															<td>
																<i class="fas fa-print documents" onClick="imprimirReciboPago();"></i>
																<i title="Escanear recibo de pago." class="fas fa-copy documents" onclick="scanRecibo();"></i>
																<i title="Ver recibo escaneado" class="fas fa-eye eye-recibo documents" onclick="showDocument5()" style="display:none;"></i>
															</td>
														</tr> -->
														<tr>
															<th scope="row">1 Contrato</th>
															<td>
																<i class="fas fa-print documents" onClick="imprimirContrato();"></i>
																<i title="Escanear contrato firmado." class="fas fa-copy documents" onclick="scanContrato();"></i>
																<i title="Ver contrato firmado" class="fas fa-eye eye-contrato documents" onclick="showDocument3()" style="display:none;"></i>
															</td>
														</tr>
														<tr>
															<th scope="row">2 Identificación oficial</th>
															<td>
																<i title="Escanear INE/IFE." class="fas fa-copy documents" onclick="scanIne();"></i>
																<i title="Ver INE/IFE." class="fas fa-eye eye-id documents" onclick="showDocument1()" style="display:none;"></i>
															</td>
														</tr>
														<tr id="tarjeta-row" style="display:none;">
															<th scope="row">3 Tarjeta</th>
															<td>
																<i title="Escanear tarjeta." class="fas fa-copy documents" onclick="scanTarjeta();"></i>
																<i title="Ver tarjeta" class="fas fa-eye eye-tarjeta documents" onclick="showDocument2()" style="display:none;"></i>
															</td>
														</tr>
														<tr id="carta-prosa-row" style="display:none;">
															<th scope="row">4 Carta prosa</th>
															<td>
																<i class="fas fa-print documents" onClick="imprimirCartaProsa();"></i>
																<i title="Escanear carta prosa." class="fas fa-copy documents" onclick="scanCarta();"></i>
																<i title="Ver carta prosa." class="fas fa-eye eye-cprosa documents" onclick="showDocument4()" style="display:none;"></i>
															</td>
														</tr>
														</tbody>
													</table>
												</div>
												<div class="col-md-12 d-flex justify-content-center">
													<button id="btn-save-documents" title="Guarda los documentos previamente escaneados en su expediente." type="button" class="btn btn-plus btn-circle center" style="width:13%; height:40px;">GUARDAR</button>
												</div>
												<div class="col-md-12">
													<input type="hidden" class="form-control" id="id_titular">
												</div>
												<div class="col-md-12">
													<input type="hidden" class="form-control" id="id_contrato">
												</div>
											</div> <!-- End div row documentsTable-->
											<div class="row">
												<div class="col-md-2 pr-1">
													<div id="response" style="display: none;"></div>
													<div class="form-group" style="position: relative;">
														<input type="hidden" name="ine_nameFile" id="ine_nameFile">
													</div>
												</div>
												<div class="col-md-2 pr-1">
													<div id="response2" style="display: none;"></div>
													<div class="form-group">
														<input type="hidden" name="tarjeta_nameFile" id="tarjeta_nameFile">
													</div>
												</div>
												<div class="col-md-2 pr-1">
													<div id="response3" style="display: none;"></div>
													<div class="form-group">
														<input type="hidden" name="contrato_nameFile" id="contrato_nameFile">
													</div>
												</div>
												<div class="col-md-2 pr-1">
													<div id="response4" style="display: none;"></div>
													<div class="form-group">
														<input type="hidden" name="cprosa_nameFile" id="cprosa_nameFile">
													</div>
												</div>
												<div class="col-md-2 pr-1">
													<div id="response5" style="display: none;"></div>
													<div class="form-group" style="position: relative;">
														<input type="hidden" name="recibo_nameFile" id="recibo_nameFile">
													</div>
												</div>
											</div> <!-- End row files attributes-->
										</div> <!-- End tab-content -->
									</form> <!-- End form content -->
								</div> <!-- End card-body -->
							</div> <!-- End div class="" -->
						</div> <!-- End box-header with-border -->
					</div> <!-- End tab content box-body -->
				</div> <!--End tab box -->
			</div> <!-- end col -->
		</div> <!-- End row -->
	</div> <!-- End container-fluid -->
</div> <!-- End content -->


</div>
</div>


<!-- MODALS -->
<div id="modalSaveDocuments" class="modal fade" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div><center><img src='<?= base_url("assets/img/add_documento.png")?>' style='width:110px; height: 120px'></center></div>
				<center><label><b>Los archivos se han guardado correctamente.</b></label></center>
				<center><button type="button" class="btn" data-dismiss="modal" onClick="reloadPage();">Aceptar</button></center>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>

<div id="modalPagoMenor" class="modal fade" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body pago-menor">
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>

<div id="modalId" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" style="background-color: #525659;">
			<!-- <div class="modal-header">
				<h4 class="modal-title nameTittle"></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div> -->
			<div class="modal-body body-document" style="padding:0px; padding-bottom:10px">
			</div>
		</div>
	</div>
</div>

<div id="modalClientAdded" class="modal fade" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div><center><img src='<?= base_url("assets/img/add_cliente.png")?>' style='width:120px; height: 120px'></center></div>
				<center><label><b>Venta finalizada.</b></label></center>
				<center><button type="button" class="btn" data-dismiss="modal">Aceptar</button></center>
			</div>
		</div>
	</div>
</div>

<div id="modalTipoArea" class="modal fade modalCenter" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="padding: 30px 15px 0 15px;">
            <div class="modal-body mt-0 pt-0">
                <center><label class="m-0" style="font-size:20px; font-weight:500; color:#A95DB8"><b>Seleccione el servicio</b></label></center>
                <center><label>Para continuar con la venta seleccione un tipo de tratamiento, por favor.</label></center>
                <br>
                <div class="container d-flex justify-content-between p-0">
                    <button type="button" class="btn-area mr-2" data-dismiss="modal" value="1"><img src='<?= base_url("assets/img/hair_a.png")?>' style="width:100%;"><p>Depilación</p></button>
                    <button type="button" class="btn-area mr-2" data-dismiss="modal" value="2"><img src='<?= base_url("assets/img/body_a.png")?>' style="width:100%;"><p>Moldeo</p></button>
                    <button type="button" class="btn-area mr-2" data-dismiss="modal" value="4" onclick="disableFB();"><img src='<?= base_url("assets/img/syringe_a.png")?>' style="width:100%;"><p>Facial</p></button>
                    <button type="button" class="btn-area mr-2" data-dismiss="modal" value="3">
                        <div><img src='<?= base_url("assets/img/depmol.png")?>' style="width:100%;"></div>
                        <p style="font-size: 12px;">Dep. y Mol.</p>
                    </button>
                    <button type="button" class="btn-area" data-dismiss="modal" value="5">
                        <div><img src='<?= base_url("assets/img/rfmoldeo.png")?>' style="width:100%;"></div>
                        <p style="font-size: 12px;">Facial y Mol.</p>
                    </button>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-end">
                <a class="btn btn-body" href="<?=base_url() ?>index.php/Home" style="border:none; background-color:#bd98e0; color:#FFF">Cerrar</a>
            </div>
        </div>
    </div>
</div>

<div id="modalError" class="modal fade" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div><center><img src='<?= base_url("assets/img/falla.png")?>' style='width:120px; height: 120px'></center></div>
				<center><label><b>¡Algo salió mal. El archivo no fue cargado!</b></label></center>
				<center><button type="button" class="btn" data-dismiss="modal">Aceptar</button></center>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>

<div id="modalUserCancel" class="modal fade" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div><center><img src='<?= base_url("assets/img/alerta.png")?>' style='width:130px; height: 120px'></center></div>
				<center><label><b>Proceso cancelado o interrumpido. El archivo no fue cargado.</b></label></center>
				<center><button type="button" class="btn " data-dismiss="modal">Aceptar</button></center>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>

<div id="modalUploaded" class="modal fade" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div><center><img src='<?= base_url("assets/img/add_documento.png")?>' style='width:110px; height: 120px'></center></div>
				<center><label><b>El archivo ha sido cargado correctamente.</b></label></center>
				<center><button type="button" class="btn" data-dismiss="modal">Aceptar</button></center>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>

<div id="modalEfectivo" class="modal fade modalCenter" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div><center><img src='<?= base_url("assets/img/alerta.png")?>' style='width:120px; height: 120px'></center></div>
				<center><label><b>Asegúrese de haber recibido la cantidad en efectivo</b></label></center>
				<center><button type="button" class="btn" data-dismiss="modal">Aceptar</button></center>
			</div>
		</div>
	</div>
</div>

<!-- HTML para Spinner-->
<div id="loader" class="lds-dual-ring hidden overlay"></div>
<!-- END HTML para Spinner -->

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

<!-- SCRIPT PARA ESCANEO -->
<script>
	var url = "<?=base_url()?>";
	var url2 = "<?=base_url()?>index.php/";
	var urlimg = "<?=base_url()?>img/";
</script>
<script>
	function scanIne(){
		var opc = "INE";
		scanner.scan(displayResponseOnPage,
			{
				"output_settings": [
					{
						"type": "upload",
						"format": "pdf",
						"upload_target": {
							"url": "<?=base_url()?>index.php/Clientes/saveFile/"+opc,
							"post_fields": {
								"sample-field": "INE scan"
							}
						}
					}
				]
			}
		);
	}

	function scanTarjeta() {
		var opc = "TARJETA";
		scanner.scan(displayResponseOnPageTwo,
			{
				"output_settings": [
					{
						"type": "upload",
						"format": "pdf",
						"upload_target": {
							"url": "<?=base_url()?>index.php/Clientes/saveFile/"+opc,
							"post_fields": {
								"sample-field": "Tarjeta scan"
							}
						}
					}
				]
			}
		);
	}

	function scanContrato() {
		var opc = "CONTRATO";
		scanner.scan(displayResponseOnPageThree,
			{
				"output_settings": [
					{
						"type": "upload",
						"format": "pdf",
						"upload_target": {
							"url": "<?=base_url()?>index.php/Clientes/saveFile/"+opc,
							"post_fields": {
								"sample-field": "Contrato scan"
							}
						}
					}
				]
			}
		);
	}

	function scanCarta() {
		var opc = "CPROSA";
		scanner.scan(displayResponseOnPageFour,
			{
				"output_settings": [
					{
						"type": "upload",
						"format": "pdf",
						"upload_target": {
							"url": "<?=base_url()?>index.php/Clientes/saveFile/"+opc,
							"post_fields": {
								"sample-field": "Carta scan"
							}
						}
					}
				]
			}
		);
	}

	function scanRecibo() {
		var opc = "RECIBO";
		scanner.scan(displayResponseOnPageFive,
			{
				"output_settings": [
					{
						"type": "upload",
						"format": "pdf",
						"upload_target": {
							"url": "<?=base_url()?>index.php/Clientes/saveFile/"+opc,
							"post_fields": {
								"sample-field": "Test scan"
							}
						}
					}
				]
			}
		);
	}

	function displayResponseOnPage(successful, mesg, response) {
		if (!successful) {
			document.getElementById('response').innerHTML = 'Failed: ' + mesg;
			jQuery("#modalError").modal("show");
			return;
		}
		if (successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) { // User cancelled.
			document.getElementById('response').innerHTML = 'User cancelled';
			jQuery("#modalUserCancel").modal("show");
			return;
		}
		jQuery("#modalUploaded").modal("show");
		$('.eye-id').removeAttr("style");
		var file_name = scanner.getUploadResponse(response);
		console.log(file_name);
		$("#ine_nameFile").val(file_name);
		activarBoton();
	}

	function displayResponseOnPageTwo(successful, mesg, response) {
		if (!successful) {
			document.getElementById('response2').innerHTML = 'Failed: ' + mesg;
			jQuery("#modalError").modal("show");
			return;
		}
		if (successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) { // User cancelled.
			document.getElementById('response2').innerHTML = 'User cancelled';
			jQuery("#modalUserCancel").modal("show");
			return;
		}
		jQuery("#modalUploaded").modal("show");
		$('.eye-tarjeta').removeAttr("style");
		var file_name = scanner.getUploadResponse(response);
		console.log(file_name);
		$("#tarjeta_nameFile").val(file_name);
		activarBoton();
	}

	function displayResponseOnPageThree(successful, mesg, response) {
		if (!successful) {
			document.getElementById('response3').innerHTML = 'Failed: ' + mesg;
			jQuery("#modalError").modal("show");
			return;
		}
		if (successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) { // User cancelled.
			document.getElementById('response3').innerHTML = 'User cancelled';
			jQuery("#modalUserCancel").modal("show");
			return;
		}
		jQuery("#modalUploaded").modal("show");
		$('.eye-contrato').removeAttr("style");
		var file_name = scanner.getUploadResponse(response);
		console.log(file_name);
		$("#contrato_nameFile").val(file_name);
		activarBoton();
	}

	function displayResponseOnPageFour(successful, mesg, response) {
		if (!successful) {
			document.getElementById('response4').innerHTML = 'Failed: ' + mesg;
			jQuery("#modalError").modal("show");
			return;
		}
		if (successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) { // User cancelled.
			document.getElementById('response4').innerHTML = 'User cancelled';
			jQuery("#modalUserCancel").modal("show");
			return;
		}
		jQuery("#modalUploaded").modal("show");
		$('.eye-cprosa').removeAttr("style");
		var file_name = scanner.getUploadResponse(response);
		$("#cprosa_nameFile").val(file_name);
		activarBoton();
	}

	function displayResponseOnPageFive(successful, mesg, response){
		if (!successful) {
			document.getElementById('response5').innerHTML = 'Failed: ' + mesg;
			jQuery("#modalError").modal("show");
			return;
		}
		if (successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) { // User cancelled.
			document.getElementById('response5').innerHTML = 'User cancelled';
			jQuery("#modalUserCancel").modal("show");
			return;
		}
		jQuery("#modalUploaded").modal("show");
		$('.eye-recibo').removeAttr("style");
		var file_name = scanner.getUploadResponse(response);
		console.log(file_name);
		$("#recibo_nameFile").val(file_name);
		activarBoton();
	}
</script>

<!-- SCRIPT PARA ESCANEO -->
<script type="text/javascript">
	var creditcard = document.getElementById('cardNumber');
	function onkeyPress(event){
		creditcard.value = creditcard.value.replace(/[a-zA-Z]/g, '');
		//validamos si es american express para esto quitamos todos los espacios en blaco y luego veriricamos que tenga 4, 6 y 5 digitos.
		if(creditcard.value.replace(/ /g, '').match(/\b(\d{4})(\d{6})(\d{5})\b/))
			creditcard.value = creditcard.value
				.replace(/\W/gi, '')//quitamos todos los espacios demas
				.replace(/\b(\d{4})(\d{6})(\d{5})\b/, '$1 $2 $3') //si cumple el formato añadimos 3,6 y 5 digitos
				.trim();
		else //si no es american express entonces es una tarjeta visa o master card
			creditcard.value = creditcard.value
				.replace(/\W/gi, '')
				.replace(/(.{4})/g, '$1 ')
				.trim()
	}
	creditcard.addEventListener('keypress',onkeyPress);
	creditcard.addEventListener('keydown',onkeyPress);
	creditcard.addEventListener('keyup',onkeyPress);
</script>

<script type="text/javascript">
	var creditcard2 = document.getElementById('cardNumber2');
	function onkeyPress(event){
		creditcard2.value = creditcard2.value.replace(/[a-zA-Z]/g, '');
		//validamos si es american express para esto quitamos todos los espacios en blaco y luego veriricamos que tenga 4, 6 y 5 digitos.
		if(creditcard2.value.replace(/ /g, '').match(/\b(\d{4})(\d{6})(\d{5})\b/))
			creditcard2.value = creditcard2.value
				.replace(/\W/gi, '')//quitamos todos los espacios demas
				.replace(/\b(\d{4})(\d{6})(\d{5})\b/, '$1 $2 $3') //si cumple el formato añadimos 3,6 y 5 digitos
				.trim();
		else //si no es american express entonces es una tarjeta visa o master card
			creditcard2.value = creditcard2.value
				.replace(/\W/gi, '')
				.replace(/(.{4})/g, '$1 ')
				.trim()
	}
	creditcard2.addEventListener('keypress',onkeyPress);
	creditcard2.addEventListener('keydown',onkeyPress);
	creditcard2.addEventListener('keyup',onkeyPress);
</script>

<script>
	let arrayTratamientos1 = [];
    let arrayTratamientos2 = [];
    let arrayTratamientos3 = [];
    let arrayTratamientos4 = [];
    let arrayTratamientos5 = [];
    let venus = false, cuerpoCompleto = false;
    let seleccionPrincipal = 0;

	function imprimirContrato(){
		var index_cliente = $('#id_titular').val();
		var id_contrato = $('#id_contrato').val();
		window.open(url+"index.php/Archivos/contrato/"+index_cliente+"/"+id_contrato);
	}

	function imprimirCartaProsa(){
		var index_cliente = $('#id_titular').val();
		var id_contrato = $('#id_contrato').val();
		window.open(url+"index.php/Archivos/carta/"+index_cliente+"/"+id_contrato);
	}

	function imprimirReciboPago(){
		index_contrato = $('#id_contrato').val();
		index_cliente = $('#id_titular').val();
		window.open(url+"index.php/Archivos/recibo/"+index_cliente+"/"+index_contrato);
	}

	function onlyLetters(e){
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key).toUpperCase();
		letras = " ÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
		especiales = [8, 37, 39, 46];

		tecla_especial = false
		for(var i in especiales) {
			if(key == especiales[i]) {
				tecla_especial = true;
				break;
			}
		}

		if(letras.indexOf(tecla) == -1 && !tecla_especial)
			return false;
	}

	function onlyNumbers(e){
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key);
		letras = " 0123456789";
		especiales = [8, 37, 39, 46];

		tecla_especial = false
		for(var i in especiales) {
			if(key == especiales[i]) {
				tecla_especial = true;
				break;
			}
		}

		if(letras.indexOf(tecla) == -1 && !tecla_especial)
			return false;
	}

	function changePriceDepMol(){
        $precioFinal = parseInt($('.precioFinal2').val());
        if ($('.precioFinal').val() < $precioFinal) {
            $('.precioFinal').val($precioFinal);
            $("#precioFinalC").val($precioFinal + parseFloat($("#totalrf").val()));
            calcularAnticipo();
            validateAdvance();
            $(".pago-menor-div").remove();
            $(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El costo total del servicio no puede ser menor a $'+ $precioFinal +'.</b></label></center> <center><button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button></center></div>');
            jQuery("#modalPagoMenor").modal("show");
        }
        else{
            $('#pagoCon').val(0);
            $precioFinal = parseFloat($('.precioFinal').val());
            $("#precioFinalC").val($precioFinal + parseFloat($("#totalrf").val()));
            if ($precioFinal >= 10000) {
                $("#pagoCon").val(($precioFinal * 0.10) + parseFloat($("#totalrf").val()));
                $("#aPagar").val($precioFinal * 0.10  + parseFloat($("#totalrf").val()));
            }
            else if ($precioFinal > 1000 && $precioFinal < 10000) {
                $("#pagoCon").val(1000  + parseFloat($("#totalrf").val()));
                $("#aPagar").val(1000  + parseFloat($("#totalrf").val()));
            }
            
            validateAdvance();
        }
    }

	$( ".btn-area" ).click(function(){
        $('#loader').removeClass('hidden');
        seleccionPrincipal = $(this).val();
        $("#area_sel").val(seleccionPrincipal);
        $.getJSON( url2 + "Clientes/lista_areas/"+seleccionPrincipal).done( function( data ){
            console.log(data);
            $.each( data, function( i, v){
                event.preventDefault();
                jQuery.noConflict();
                if(v.tipo == "Depilación"){
                    $(".option-group-d").append('<option value="'+v.id_area+'" data-value="'+v.tarifa+'" tipo="'+v.tipo+'" no-sesion="'+v.no_sesion+'" clave="'+v.clave+'" nombre="'+v.nombre+'" >'+v.nombre+'</option>');
                }
                else if(v.tipo == "Moldeo"){
                    $(".option-group-m").append('<option value="'+v.id_area+'" data-value="'+v.tarifa+'" tipo="'+v.tipo+'" no-sesion="'+v.no_sesion+'" clave="'+v.clave+'" nombre="'+v.nombre+'">'+v.nombre+'</option>');
                }
                else if(v.tipo == "Rejuvenecimiento facial"){
                    $(".option-group-rf").append('<option value="'+v.id_area+'" data-value="'+v.tarifa+'" tipo="'+v.tipo+'" no-sesion="'+v.no_sesion+'" data-piezas="'+v.piezas_edit+'" data-sesione = "'+v.sesiones_e+'" data-promo="'+v.promo_sesion+'" nombre="'+v.nombre+'" venus="'+v.venus+'">'+v.nombre+'</option>');
                }
            });
            $('#loader').addClass('hidden');
        });

        if ( seleccionPrincipal == 1 || seleccionPrincipal == 3 ) $(".cuerpo-completo-btn").removeClass('d-none');
        if ( seleccionPrincipal == 4 || seleccionPrincipal == 5 ) $(".row-tratamientos").removeClass('d-none');
        if ( seleccionPrincipal == 4 ){
            $(".areas-depmol").addClass('d-none');
            $('.precioFinal').attr('disabled', 'disabled');
        }
    });

	$(document).on('click', '#btn-save-documents', function(){
		$.ajax({
			type: 'POST',
			url: url2 + "Clientes/guardarDocumentos",
			data: {
				'recibo_nameFile': $('#recibo_nameFile').val(),
				'ine_nameFile': $('#ine_nameFile').val(),
				'tarjeta_nameFile': $('#tarjeta_nameFile').val(),
				'contrato_nameFile': $('#contrato_nameFile').val(),
				'cprosa_nameFile': $('#cprosa_nameFile').val(),
				'id_titular': $('#id_titular').val(),
				'id_contrato': $('#id_contrato').val()
			},
			dataType: 'json',
			success: function(data){
				if( data.resultado ){
					jQuery("#modalSaveDocuments").modal("show");
				}else{
					jQuery("#modal_fail").modal("show");
				}
			},error: function( ){
				jQuery("#modal_fail").modal("show");
			}
		});
	});

	function disableFields(){
		$('.field-disabld').attr('disabled', 'disabled');
		$('.select-disabld').attr('disabled', 'disabled');
		$('.form-check-input').attr('disabled', 'disabled');
		$('.g-disabld').attr('disabled', 'disabled');
		$('.multiselect').attr('disabled', 'disabled');
		$('.multiselect').css('background-color', '#F5F5F5');
		$('.multiselect').css('border', '1px solid #afafaf');
		$('#btnsubmit').hide();
		$('#btn_add').hide();
		$('#documentsTable').removeAttr("style");
	}

	// FUNCIÓN QUE SE EJECUTA CUANDO EL ANTICIPO CAMBIA #PAGOCON VALIDA EL ANTICIPO
	function validateAdvance(){
        if ($('#precioFinalC').val() != 0) {
        	$('#btnsubmit').removeAttr('disabled');
            $('#btnsubmit').show();
            $(".box-anticipo").removeClass('d-none');
			$("#parcialidades").append('<option value="0">0</option>');
            $anticipo = parseInt($('#precioFinalC').val());
			$('#pagoCon').val($anticipo);
        }
        else{
        	$('#btnsubmit').addAttr('disabled');
            $('#pagoCon').prop('disabled', false);
            $('#btnsubmit').hide();
            $('#aPagar').val(0);
            $('#pagoCon').val(0);
            $('#saldoPendiente').val(parseFloat($('#precioFinalC').val()) - parseFloat($('#pagoCon').val()));
            $(".box-anticipo").addClass('d-none');
            $("#box-cash").addClass('d-none');
            $("#box-card").addClass('d-none');
            $(".payment-title").addClass('d-none');
            $("#box-tb").addClass('d-none');
            $('#protegida').prop("disabled", false);
            $("#protegida").prop('checked', false);
        }
    }

	function changeAPagar(){
		$('#aPagar').val($('#pagoCon').val(0));
	}

	function changeEntrance(){
		/*if( (parseInt($('#efectivo').val()) + parseInt($('#montoTU').val()) + parseInt($('#montoTD').val())) < parseInt($('#aPagar').val()) )
			$('#btnsubmit').prop('disabled', true);
		else $('#btnsubmit').prop('disabled', false);*/

		//Validar es venta protegida o normal.
		if($('#protegida').is(':checked')){
			$("#referencia").val("0");
			changeAPagar();
			$("#entrada").val(parseInt($('#efectivo').val()));
			/*if (parseInt($('#efectivo').val()) < parseInt($('#aPagar').val())){
				$('#btnsubmit').prop('disabled', true);
			}
			else{
				$('#btnsubmit').prop('disabled', false);
			}*/
		}
		else{
			changeAPagar();
			$("#entrada").val(parseInt($('#efectivo').val()) + parseInt($('#montoTU').val()) + parseInt($('#montoTD').val()));
		}
	}

	function evalueEntranceE(e){
		if(!$('#protegida').is(':checked')){
			if(parseInt(e) + parseInt($('#montoTU').val()) + parseInt($('#montoTD').val()) > parseInt($('#pagoCon').val())){
				$(".pago-menor-div").remove();
				$(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El monto ingresado es mayor al anticipo</b></label></center> <center><button type="button" class="btn" data-dismiss="modal">Aceptar</button></center></div>');
				jQuery("#modalPagoMenor").modal("show");
				$("#efectivo").val('');
			}
		}
	}

	function evalueEntranceTU(e){
		if(parseInt(e) + parseInt($('#efectivo').val()) + parseInt($('#montoTD').val()) > parseInt($('#pagoCon').val())){
			$(".pago-menor-div").remove();
			$(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El monto ingresado es mayor al anticipo</b></label></center> <center><button type="button" class="btn" data-dismiss="modal">Aceptar</button></center></div>');
			jQuery("#modalPagoMenor").modal("show");
			$("#montoTU").val('');
		}
	}

	function evalueEntranceTD(e){
		if(parseInt(e) + parseInt($('#efectivo').val()) + parseInt($('#montoTU').val()) > parseInt($('#pagoCon').val())){
			$(".pago-menor-div").remove();
			$(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El monto ingresado es mayor al anticipo</b></label></center> <center><button type="button" class="btn" data-dismiss="modal">Aceptar</button></center></div>');
			jQuery("#modalPagoMenor").modal("show");
			$("#montoTD").val('');
		}
	}

	function valorMensualidad(){
		$noMensualidades = $("#parcialidades option:selected").val();
		$costoMensualidad = (parseInt($("#precioFinalC").val()) - parseInt($("#pagoCon").val())) / parseInt($noMensualidades);
		$("#label-payment").remove();

		$("#monthly-payments").html('');
		$("#monthly-inputs").html('');
		const options = { year: 'numeric', month: 'short', day: 'numeric' };

		var fecha1 = new Date();
		var day, day2;
		if(fecha1.getDate()>15 && fecha1.getDate()<30){
			day = 30;
			day2 = 15;
			$monthCount = 0;
		}else{
			day = 15;
			day2 = 30;
		}
		//  fecha1.setDate(fecha1.getDate()-fecha1.getDate()+1);
		function createDate(fecha1, day){
			if(fecha1.getDate() > 29){
				if(fecha1.getMonth()==0){
					fecha1.setDate(28);
					console.log('segundo if');

				}
				console.log('primer if');
				fecha1.setMonth(fecha1.getMonth() + 1);
			}else if(fecha1.getDate()>27 && fecha1.getMonth()==1){
				fecha1.setMonth(fecha1.getMonth() + 1);
				console.log('tercer if');

			}

			if(fecha1.getMonth() == 1 && fecha1.getDate() == 15){
				day = 28;
				console.log('cuarto if');

			}
			fecha1.setDate(day);
			return fecha1;
		}

		switch($noMensualidades){
			case '0':
				$("#monthly-payments").append('<label><b>Servicio liquidado</b></label>');
				break;
			case '1':
				var diaZ = createDate(fecha1, day);
				console.log(diaZ);
				var dia1 = diaZ.getFullYear() + '-' + ('0' + (diaZ.getMonth()+1)).slice(-2) +'-'+ diaZ.getDate();
				$("#monthly-payments").append('<label id="label-payment">1° pago el próximo <input class="form-control-sm g-disabld" name="mensualidades[]"  type="date" value="'+dia1+'"/> cada uno con un valor de <b>$'+formatMoney($costoMensualidad)+'</b></label><br>');
				break;

			case '2':
				var diaZ = createDate(fecha1, day);
				var dia1 = diaZ.getFullYear() + '-' + ('0' + (diaZ.getMonth()+1)).slice(-2) +'-'+ diaZ.getDate();
				var diaY = createDate(fecha1, day2);
				var dia2 = diaY.getFullYear() + '-' + ('0' + (diaY.getMonth()+1)).slice(-2) +'-'+ diaY.getDate();

				$("#monthly-payments").append('<label id="label-payment">1° pago el próximo <input class="form-control-sm g-disabld" name="mensualidades[]"  type="date" value="'+dia1+'"/>  cada uno con un valor de <b>$'+formatMoney($costoMensualidad)+'</b></label><br>'+'<label id="label-payment">2° pago el próximo <input class="form-control-sm g-disabld" name="mensualidades[]" type="date" value="'+dia2+'"/>  cada uno con un valor de <b>$'+formatMoney($costoMensualidad)+'</b></label><br>');
				break;

			case '3':
				var diaZ = createDate(fecha1, day);
				var dia1 = diaZ.getFullYear() + '-' + ('0' + (diaZ.getMonth()+1)).slice(-2) +'-'+ diaZ.getDate();
				var diaY = createDate(fecha1, day2);
				var dia2 = diaY.getFullYear() + '-' + ('0' + (diaY.getMonth()+1)).slice(-2) +'-'+ diaY.getDate();
				var diaX = createDate(fecha1, day);
				var dia3 = diaX.getFullYear() + '-' + ('0' + (diaX.getMonth()+1)).slice(-2) +'-'+ diaX.getDate();

				$("#monthly-payments").append('<label id="label-payment">1° pago el próximo <input class="form-control-sm g-disabld" name="mensualidades[]" type="date" value="'+dia1+'"/> cada uno con un valor de <b>$'+formatMoney($costoMensualidad)+'</b></label><br>'
					+'<label id="label-payment">2° pago el próximo <input class="form-control-sm g-disabld" name="mensualidades[]" type="date" value="'+dia2+'"/> cada uno con un valor de <b>$'+formatMoney($costoMensualidad)+'</b></label><br>'
					+'<label id="label-payment">3° pago el próximo <input class="form-control-sm g-disabld" name="mensualidades[]" type="date" value="'+dia3+'"/> cada uno con un valor de <b>$'+formatMoney($costoMensualidad)+'</b></label><br>');
				break;

			case '4':
				var diaZ = createDate(fecha1, day);
				var dia1 = diaZ.getFullYear() + '-' + ('0' + (diaZ.getMonth()+1)).slice(-2) +'-'+ diaZ.getDate();
				var diaY = createDate(fecha1, day2);
				var dia2 = diaY.getFullYear() + '-' + ('0' + (diaY.getMonth()+1)).slice(-2) +'-'+ diaY.getDate();
				var diaX = createDate(fecha1, day);
				var dia3 = diaX.getFullYear() + '-' + ('0' + (diaX.getMonth()+1)).slice(-2) +'-'+ diaX.getDate();
				var diaW = createDate(fecha1, day2);
				var dia4 = diaW.getFullYear() + '-' + ('0' + (diaW.getMonth()+1)).slice(-2) +'-'+ diaW.getDate();

				$("#monthly-payments").append('<label id="label-payment">1° pago el próximo <input class="form-control-sm g-disabld" name="mensualidades[]" type="date" value="'+dia1+'"/> cada uno con un valor de <b>$'+formatMoney($costoMensualidad)+'</b></label><br>'
					+'<label id="label-payment">2° pago el próximo <input class="form-control-sm g-disabld" name="mensualidades[]" type="date" value="'+dia2+'"/> cada uno con un valor de <b>$'+formatMoney($costoMensualidad)+'</b></label><br>'
					+'<label id="label-payment">3° pago el próximo <input class="form-control-sm g-disabld" name="mensualidades[]" type="date" value="'+dia3+'"/> cada uno con un valor de <b>$'+formatMoney($costoMensualidad)+'</b></label><br>'
					+'<label id="label-payment">4° pago el próximo <input class="form-control-sm g-disabld" name="mensualidades[]" type="date" value="'+dia4+'"/> cada uno con un valor de <b>$'+formatMoney($costoMensualidad)+'</b></label><br>');
				break;

			case '5':
				var diaZ = createDate(fecha1, day);
				var dia1 = diaZ.getFullYear() + '-' + ('0' + (diaZ.getMonth()+1)).slice(-2) +'-'+ diaZ.getDate();
				var diaY = createDate(fecha1, day2);
				var dia2 = diaY.getFullYear() + '-' + ('0' + (diaY.getMonth()+1)).slice(-2) +'-'+ diaY.getDate();
				var diaX = createDate(fecha1, day);
				var dia3 = diaX.getFullYear() + '-' + ('0' + (diaX.getMonth()+1)).slice(-2) +'-'+ diaX.getDate();
				var diaW = createDate(fecha1, day2);
				var dia4 = diaW.getFullYear() + '-' + ('0' + (diaW.getMonth()+1)).slice(-2) +'-'+ diaW.getDate();
				var diaV = createDate(fecha1, day);
				var dia5 = diaV.getFullYear() + '-' + ('0' + (diaV.getMonth()+1)).slice(-2) +'-'+ diaV.getDate();
				$("#monthly-payments").append('<label id="label-payment">1° pago el próximo <input class="form-control-sm g-disabld" name="mensualidades[]" type="date" value="'+dia1+'"/> cada uno con un valor de <b>$'+formatMoney($costoMensualidad)+'</b></label><br>'
					+'<label id="label-payment">2° pago el próximo <input class="form-control-sm g-disabld" name="mensualidades[]" type="date" value="'+dia2+'"/> cada uno con un valor de <b>$'+formatMoney($costoMensualidad)+'</b></label><br>'
					+'<label id="label-payment">3° pago el próximo <input class="form-control-sm g-disabld" name="mensualidades[]" type="date" value="'+dia3+'"/> cada uno con un valor de <b>$'+formatMoney($costoMensualidad)+'</b></label><br>'
					+'<label id="label-payment">4° pago el próximo <input class="form-control-sm g-disabld" name="mensualidades[]" type="date" value="'+dia4+'"/> cada uno con un valor de <b>$'+formatMoney($costoMensualidad)+'</b></label><br>'
					+'<label id="label-payment">5° pago el próximo <input class="form-control-sm g-disabld" name="mensualidades[]" type="date" value="'+dia5+'"/> cada uno con un valor de <b>$'+formatMoney($costoMensualidad)+'</b></label><br>');
				break;

			case '6':
				var diaZ = createDate(fecha1, day);
				var dia1 = diaZ.getFullYear() + '-' + ('0' + (diaZ.getMonth()+1)).slice(-2) +'-'+ diaZ.getDate();
				var diaY = createDate(fecha1, day2);
				var dia2 = diaY.getFullYear() + '-' + ('0' + (diaY.getMonth()+1)).slice(-2) +'-'+ diaY.getDate();
				var diaX = createDate(fecha1, day);
				var dia3 = diaX.getFullYear() + '-' + ('0' + (diaX.getMonth()+1)).slice(-2) +'-'+ diaX.getDate();
				var diaW = createDate(fecha1, day2);
				var dia4 = diaW.getFullYear() + '-' + ('0' + (diaW.getMonth()+1)).slice(-2) +'-'+ diaW.getDate();
				var diaV = createDate(fecha1, day);
				var dia5 = diaV.getFullYear() + '-' + ('0' + (diaV.getMonth()+1)).slice(-2) +'-'+ diaV.getDate();
				var diaU = createDate(fecha1, day2);
				var dia6 = diaU.getFullYear() + '-' + ('0' + (diaU.getMonth()+1)).slice(-2) +'-'+ diaU.getDate();
				$("#monthly-payments").append('<label id="label-payment">1° pago el próximo <input class="form-control-sm g-disabld" name="mensualidades[]" type="date" value="'+dia1+'"/> cada uno con un valor de <b>$'+formatMoney($costoMensualidad)+'</b></label><br>'
					+'<label id="label-payment">2° pago el próximo <input class="form-control-sm g-disabld" name="mensualidades[]" type="date" value="'+dia2+'"/> cada uno con un valor de <b>$'+formatMoney($costoMensualidad)+'</b></label><br>'
					+'<label id="label-payment">3° pago el próximo <input class="form-control-sm g-disabld" name="mensualidades[]" type="date" value="'+dia3+'"/> cada uno con un valor de <b>$'+formatMoney($costoMensualidad)+'</b></label><br>'
					+'<label id="label-payment">4° pago el próximo <input class="form-control-sm g-disabld" name="mensualidades[]" type="date" value="'+dia4+'"/> cada uno con un valor de <b>$'+formatMoney($costoMensualidad)+'</b></label><br>'
					+'<label id="label-payment">5° pago el próximo <input class="form-control-sm g-disabld" name="mensualidades[]" type="date" value="'+dia5+'"/> cada uno con un valor de <b>$'+formatMoney($costoMensualidad)+'</b></label><br>'
					+'<label id="label-payment">6° pago el próximo <input class="form-control-sm g-disabld" name="mensualidades[]" type="date" value="'+dia6+'"/> cada uno con un valor de <b>$'+formatMoney($costoMensualidad)+'</b></label><br>');
				break;
		}


		$("#monthly-payments").append('<br>');
	}

	function calcularAnticipo(){
        $('#pagoCon').val(0);
        $precioFinal = parseInt($('#precioFinalC').val());
        if ($precioFinal >= 10000) {
            $("#pagoCon").val($precioFinal * 0.10);
            $("#aPagar").val($precioFinal * 0.10);
        }
        else if ($precioFinal > 1000 && $precioFinal < 10000) {
            $("#pagoCon").val(1000);
            $("#aPagar").val(1000);
        }
        else{
            $("#pagoCon").val($precioFinal);
            $("#aPagar").val($precioFinal);
        }
        validateAdvance();
    }

	function reloadPage(){
		location.reload();
	}

	function showDocument1(){
		$('.nameTittle').text("Identificación oficial");
		$(".embed-doc").remove();
		$(".btn-closing").remove();
		var id = $(this).attr("id");
		var nameFile = $("#ine_nameFile").val();
		$(".body-document").append('<embed class="embed-doc" src="<?= base_url("assets/expediente/INE/'+nameFile+'")?>"frameborder="0" width="100%" height="600px" ><div class="modal-footer btn-closing" style="padding: 0 15px; display: flex; justify-content: flex-end;"><button type="button" class="btn btn-default" data-dismiss="modal" style="border:none; background-color:#323639; color:#FFF">Cerrar</button></div>');
		jQuery("#modalId").modal("show");
	}

	function showDocument2(){
		$('.nameTittle').text("Tarjeta");
		$(".embed-doc").remove();
		$(".btn-closing").remove();
		var id = $(this).attr("id");
		var nameFile = $("#tarjeta_nameFile").val();
		$(".body-document").append('<embed class="embed-doc" src="<?= base_url("assets/expediente/TARJETA/'+nameFile+'")?>" frameborder="0" width="100%" height="600px" ><div class="modal-footer btn-closing" style="padding: 0 15px; display: flex;justify-content: flex-end;"><button type="button" class="btn btn-default" data-dismiss="modal" style="border:none; background-color:#323639; color:#FFF">Cerrar</button></div>');
		jQuery("#modalId").modal("show");
	}

	function showDocument3(){
		$('.nameTittle').text("Contrato");
		$(".embed-doc").remove();
		$(".btn-closing").remove();
		var id = $(this).attr("id");
		var nameFile = $("#contrato_nameFile").val();
		$(".body-document").append('<embed class="embed-doc" src="<?= base_url("assets/expediente/CONTRATO/'+nameFile+'")?>" frameborder="0" width="100%" height="600px" ><div class="modal-footer btn-closing" style="padding: 0 15px; display: flex;justify-content: flex-end;"><button type="button" class="btn btn-default" data-dismiss="modal" style="border:none; background-color:#323639; color:#FFF">Cerrar</button></div>');
		jQuery("#modalId").modal("show");
	}

	function showDocument4(){
		$('.nameTittle').text("Contrato");
		$(".embed-doc").remove();
		$(".btn-closing").remove();
		var id = $(this).attr("id");
		var nameFile = $("#cprosa_nameFile").val();
		$(".body-document").append('<embed class="embed-doc" src="<?= base_url("assets/expediente/CPROSA/'+nameFile+'")?>" frameborder="0" width="100%" height="600px"><div class="modal-footer btn-closing" style="padding: 0 15px; display: flex;justify-content: flex-end;"><button type="button" class="btn btn-default" data-dismiss="modal" style="border:none; background-color:#323639; color:#FFF">Cerrar</button></div>');
		jQuery("#modalId").modal("show");
	}

	function showDocument5(){
		$('.nameTittle').text("Recibo");
		$(".embed-doc").remove();
		$(".btn-closing").remove();
		var id = $(this).attr("id");
		var nameFile = $("#recibo_nameFile").val();
		console.log(nameFile);
		$(".body-document").append('<embed class="embed-doc" src="<?= base_url("assets/expediente/RECIBO/'+nameFile+'")?>" frameborder="0" width="100%" height="600px"><div class="modal-footer btn-closing" style="padding: 0 15px; display: flex;justify-content: flex-end;"><button type="button" class="btn btn-default" data-dismiss="modal" style="border:none; background-color:#323639; color:#FFF">Cerrar</button></div>');
		jQuery("#modalId").modal("show");
	}

	function changePay(){
		var formas = 0;
		cleanTarjeta();
		$("#lblProtegida").addClass('d-none');
		var prote = true;
		$('#box-cash').addClass('d-none');
		$('#box-card').addClass('d-none');
		$('#montoTU').val('0.00');
		$('#montoTD').val('0.00');
		$('#efectivo').val('0.00');
		$.each( $('#formaPago').val(), function( i, v){
			if ( v == 1 ){
				//Regresamos al  estado inicial los tab, Validación*
				$('#box-cash').removeClass('d-none');
				$("#tarjeta1").addClass('active');
				$("#tarjeta1").addClass('show');
				$("#tarjeta2").removeClass('active');
				$("#tarjeta2").removeClass('show');
			}
			if( v == 2 ){
				//Regresamos al  estado inicial los tab, Validación*
				$('#box-card').removeClass('d-none');
				$('#tabtjt2').removeClass('d-none');
				$('#tarjeta2').removeClass('d-none');
				$(".box-monto").removeClass('d-none');
				$(".box-referencia").removeClass('d-none');
				prote = false;
			}
			if( v == 5 ){
				//Regresamos al  estado inicial los tab, Validación* 
				//chacha
				/*if($('#formaPago').val() == 5)
				{
					$('#btnsubmit').attr('disabled', false);
				}*/
			}
			formas++;
		});

		if(prote){
			$('#protegida').prop("disabled", false);
		}
		else{
			$('#protegida').prop("disabled", true);
			$("#protegida").prop('checked', false);
			$(".box-referencia").removeClass('d-none');
		}

		if(formas==0) $(".box-detalle-fin").addClass('d-none');
		else $(".box-detalle-fin").removeClass('d-none');
	}

	// Obtiene total respecto a las áreas seleccionadas select1
	$('.select-uno').change(function(){
		select1();
	});

	// Obtiene total respecto a las áreas seleccionadas select2T
	$('.select-dos').change(function() {
		select2();
	});

	// Obtiene total respecto a las áreas seleccionadas select3
	$('.select-tres').change(function() {
		select3();
	});

	// Obtiene total respecto a las áreas seleccionadas select4
	$('.select-cuatro').change(function() {
		select4();
	});

	// Obtiene total respecto a las áreas seleccionadas select5
	$('.select-cinco').on('change',function() {
		select5();
	});

	function select1(){
		// Obtenemos el total de opiones seleccionadas
		var slValue =  $('.select-uno').val();
		var idArea = [];
		if(slValue != undefined && slValue != null && slValue != ''){
			var contador = $('.select-uno option:selected').length;
			$(".total-areas1").val(contador);
			$(".row-tbl1").remove();
			if ($('.select-uno option:selected').length > 0) {
				var noArea = 1;
				tarifas1 = $('.select-uno option:selected').map(function () {
					var areasArray = [];
					$("#tbody-areas1").append('<tr class="row-tbl1"><td>'+noArea+'</td><td>'+$(this).attr("no-sesion")+'</td><td>'+$(this).attr("nombre")+'</td><td>'+$(this).attr("data-value")+'</td><td>'+$(this).attr("tipo")+'</td><td hidden>'+$(this).attr("clave")+'</td></tr>');
					noArea ++;
					areasArray.push([$(this).attr("data-value"), $(this).attr("clave"),$(this).attr("value")]);
					idArea.push([$(this).attr("value")]);

					return areasArray;
				}).get();
			}

			$(".idarea").val(idArea);
			var string2 = ($(".idarea2").val()).split(',');
			var string3 = ($(".idarea3").val()).split(',');
			var string4 = ($(".idarea4").val()).split(',');
			var string5 = ($(".idarea5").val()).split(',');
			var countComplete = 0;
			for(var z = 0;z<tarifas1.length;z++){
				if(tarifas1[z][1] == 1){
					countComplete++;
					var found2, found3, found4, found5;
					if(string2.length > 0){
						for(var y=0;y<string2.length;y++){
							found2 = string2.find(element => element == tarifas1[z][2]);
						}
					}
					if(string3.length > 0){
						for(var y=0;y<string2.length;y++){
							found3 = string3.find(element => element == tarifas1[z][2]);
						}
					}
					if(string4.length > 0){
						for(var y=0;y<string4.length;y++){
							found4 = string4.find(element => element == tarifas1[z][2]);
						}
					}
					if(string5.length > 0){
						for(var y=0;y<string5.length;y++){
							found5 = string5.find(element => element == tarifas1[z][2]);
						}
					}
					if(found2 != undefined || found3 != undefined || found4 != undefined || found5 != undefined){
						countComplete--;
					}
				}
			}
			console.log(countComplete);

			$(".completo-1").val(countComplete);

			var suma1 = 0;
			var areasCp1 = 0;
			if(tarifas1 != undefined){
				for(i = 0; i < tarifas1.length; i++) {
					suma1 = (suma1 + parseInt(tarifas1[i][0]));
					if(parseInt(tarifas1[i][1]) == 1) areasCp1++;
				}
			}

			$("#total").val(valor2);
			$(".rate-sl1").val(suma1);
			var valor2 = parseInt($(".rate-sl1").val()) + parseInt($(".rate-sl2").val()) + parseInt($(".rate-sl3").val()) + parseInt($(".rate-sl4").val()) + parseInt($(".rate-sl5").val());
			$("#total").val(valor2);

			var complete = parseInt($(".completo-2").val()) + parseInt($(".completo-3").val())+ parseInt($(".completo-4").val())+ parseInt($(".completo-5").val());
			$(".total-Cuerpocompleto").val(countComplete+complete);
			var areas = parseInt($(".total-areas2").val()) + parseInt($(".total-areas3").val()) + parseInt($(".total-areas4").val()) + parseInt($(".total-areas5").val());
			$(".total-areas").val(contador + areas);
			if (parseInt($(".total-areas").val()) == 1)
				$("#descuento").val(parseInt($("#total").val()) * 0.40);

			if (parseInt($(".total-areas").val()) == 2)
				$("#descuento").val(parseInt($("#total").val()) * 0.50);

			if (parseInt($(".total-areas").val()) == 3)
				$("#descuento").val(parseInt($("#total").val()) * 0.60);

			if (parseInt($(".total-areas").val()) >= 4)
				$("#descuento").val(parseInt($("#total").val()) * 0.65);
			if(parseInt($(".total-Cuerpocompleto").val())>15)
				$("#descuento").val(parseInt($("#total").val()) * 0.70);

			$(".precioFinal").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $(".precioFinal2").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $("#precioFinalC").val(parseInt($(".precioFinal").val()) + parseInt($("#totalrf").val()));

			calcularAnticipo();
			validateAdvance();
			changeAPagar();
			changeEntrance();
			valorMensualidad();
		}
		else {
			$(".total-areas1").val(0);
			$(".row-tbl1").remove();
			$(".rate-sl1").val(0);
			var valor2 = parseInt($(".rate-sl1").val()) + parseInt($(".rate-sl2").val()) + parseInt($(".rate-sl3").val()) + parseInt($(".rate-sl4").val()) + parseInt($(".rate-sl5").val());
			$("#total").val(valor2);
			var complete = parseInt($(".completo-2").val()) + parseInt($(".completo-3").val())+ parseInt($(".completo-4").val())+ parseInt($(".completo-5").val());
			$(".total-Cuerpocompleto").val(countComplete+complete);
			var areas = parseInt($(".total-areas2").val()) + parseInt($(".total-areas3").val()) + parseInt($(".total-areas4").val()) + parseInt($(".total-areas5").val());
			$(".total-areas").val(0 + areas);
			if (parseInt($(".total-areas").val()) == 0){
				$("#descuento").val(0);
			}
			if (parseInt($(".total-areas").val()) == 1){
				$("#descuento").val(parseInt($("#total").val()) * 0.40);
			}
			if (parseInt($(".total-areas").val()) == 2){
				$("#descuento").val(parseInt($("#total").val()) * 0.50);
			}
			if (parseInt($(".total-areas").val()) == 3){
				$("#descuento").val(parseInt($("#total").val()) * 0.60);
			}
			if (parseInt($(".total-areas").val()) >= 4){
				$("#descuento").val(parseInt($("#total").val()) * 0.65);
			}

			if(parseInt($(".total-Cuerpocompleto").val())>15)
				$("#descuento").val(parseInt($("#total").val()) * 0.70);

			$(".precioFinal").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $(".precioFinal2").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $("#precioFinalC").val(parseInt($(".precioFinal").val()) + parseInt($("#totalrf").val()));

			calcularAnticipo();
			validateAdvance();
			changeAPagar();
			changeEntrance();
			valorMensualidad();
		}
	}

	function select2(){
		// Obtenemos el total de opiones seleccionadas
		var slValue =  $('.select-dos').val();
		var idArea = [];
		if(slValue != undefined && slValue != null && slValue != ''){
			var contador = $('.select-dos option:selected').length;
			$(".total-areas2").val(contador);
			$(".row-tbl2").remove();
			if ($('.select-dos option:selected').length > 0) {
				var noArea = 1;
				tarifas2 = $('.select-dos option:selected').map(function () {
					var areasArray = [];
					$("#tbody-areas2").append('<tr class="row-tbl2"><td>'+noArea+'</td><td>'+$(this).attr("no-sesion")+'</td><td>'+$(this).attr("nombre")+'</td><td>'+$(this).attr("data-value")+'</td><td>'+$(this).attr("tipo")+'</td><td hidden>'+$(this).attr("clave")+'</td></tr>');
					noArea ++;
					areasArray.push([$(this).attr("data-value"), $(this).attr("clave"), $(this).attr("value")]);
					idArea.push([$(this).attr("value")]);

					return areasArray;
				}).get();
			}
			$(".idarea2").val(idArea);
			var string1 = ($(".idarea").val()).split(',');
			var string3 = ($(".idarea3").val()).split(',');
			var string4 = ($(".idarea4").val()).split(',');
			var string5 = ($(".idarea5").val()).split(',');
			var countComplete = 0;
			for(var z = 0;z<tarifas2.length;z++){
				if(tarifas2[z][1] == 1){
					countComplete++;
					var found, found3, found4, found5;
					if(string1.length > 1){
						for(var y=0;y<string1.length;y++){
							found = string1.find(element => element == tarifas2[z][2]);
						}
					}
					if(string3.length > 0){
						for(var y=0;y<string3.length;y++){
							found3 = string3.find(element => element == tarifas2[z][2]);
						}
					}
					if(string4.length > 0){
						for(var y=0;y<string4.length;y++){
							found4 = string4.find(element => element == tarifas2[z][2]);
						}
					}
					if(string5.length > 0){
						for(var y=0;y<string5.length;y++){
							found5 = string5.find(element => element == tarifas2[z][2]);
						}
					}
					if(found != undefined || found3 != undefined || found4 != undefined || found5 != undefined){
						countComplete--;
					}
				}
			}
			$(".completo-2").val(countComplete);
			var suma2 = 0;
			var areasCp2 = 0;
			if(tarifas2 != undefined){
				for(i = 0; i < tarifas2.length; i++){
					suma2 = (suma2 + parseInt(tarifas2[i][0]));
					if(parseInt(tarifas2[i][1]) == 1) areasCp2++;
				}
			}

			$(".rate-sl2").val(suma2);
			var valor = parseInt($(".rate-sl1").val()) + parseInt($(".rate-sl2").val()) + parseInt($(".rate-sl3").val()) + parseInt($(".rate-sl4").val()) + parseInt($(".rate-sl5").val());
			$("#total").val(valor);
			var complete = parseInt($(".completo-1").val()) + parseInt($(".completo-3").val())+ parseInt($(".completo-4").val())+ parseInt($(".completo-5").val());
			$(".total-Cuerpocompleto").val(countComplete + complete);
			var areas = parseInt($(".total-areas1").val()) + parseInt($(".total-areas3").val()) + parseInt($(".total-areas4").val()) + parseInt($(".total-areas5").val());
			$(".total-areas").val(contador + areas);

			if (parseInt($(".total-areas").val()) == 1){
				$("#descuento").val(parseInt($("#total").val()) * 0.40);
			}
			if (parseInt($(".total-areas").val()) == 2){
				$("#descuento").val(parseInt($("#total").val()) * 0.50);
			}
			if (parseInt($(".total-areas").val()) == 3){
				$("#descuento").val(parseInt($("#total").val()) * 0.60);
			}
			if (parseInt($(".total-areas").val()) >= 4){
				$("#descuento").val(parseInt($("#total").val()) * 0.65);
			}
			if(parseInt($(".total-Cuerpocompleto").val())>15)
				$("#descuento").val(parseInt($("#total").val()) * 0.70);

			$(".precioFinal").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $(".precioFinal2").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $("#precioFinalC").val(parseInt($(".precioFinal").val()) + parseInt($("#totalrf").val()));

			calcularAnticipo();
			validateAdvance();
			changeAPagar();
			changeEntrance();
			valorMensualidad();
		}
		else{
			$(".total-areas2").val(0);
			$(".row-tbl2").remove();
			$(".rate-sl2").val(0);
			var valor2 = parseInt($(".rate-sl1").val()) + parseInt($(".rate-sl2").val()) + parseInt($(".rate-sl3").val()) + parseInt($(".rate-sl4").val()) + parseInt($(".rate-sl5").val());
			$("#total").val(valor2);
			var complete = parseInt($(".completo-1").val()) + parseInt($(".completo-3").val())+ parseInt($(".completo-4").val())+ parseInt($(".completo-5").val());
			$(".total-Cuerpocompleto").val(countComplete + complete);
			var areas = parseInt($(".total-areas1").val()) + parseInt($(".total-areas3").val()) + parseInt($(".total-areas4").val()) + parseInt($(".total-areas5").val());
			$(".total-areas").val(0 + areas);
			if (parseInt($(".total-areas").val()) == 0){
				$("#descuento").val(0);
			}
			if (parseInt($(".total-areas").val()) == 1){
				$("#descuento").val(parseInt($("#total").val()) * 0.40);
			}
			if (parseInt($(".total-areas").val()) == 2){
				$("#descuento").val(parseInt($("#total").val()) * 0.50);
			}
			if (parseInt($(".total-areas").val()) == 3){
				$("#descuento").val(parseInt($("#total").val()) * 0.60);
			}
			if (parseInt($(".total-areas").val()) >= 4){
				$("#descuento").val(parseInt($("#total").val()) * 0.65);
			}
			if(parseInt($(".total-Cuerpocompleto").val())>15)
				$("#descuento").val(parseInt($("#total").val()) * 0.70);
				
			$(".precioFinal").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $(".precioFinal2").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $("#precioFinalC").val(parseInt($(".precioFinal").val()) + parseInt($("#totalrf").val()));

			calcularAnticipo();
			validateAdvance();
			changeAPagar();
			changeEntrance();
			valorMensualidad();
		}
	}

	function select3(){
		// Obtenemos el total de opiones seleccionadas
		var slValue =  $('.select-tres').val();
		var idArea = [];
		if(slValue != undefined && slValue != null && slValue != ''){
			var contador = $('.select-tres option:selected').length;
			$(".total-areas3").val(contador);
			$(".row-tbl3").remove();
			if ($('.select-tres option:selected').length > 0) {
				var noArea = 1;
				var tarifas3 = $('.select-tres option:selected').map(function () {
					var areasArray = [];
					$("#tbody-areas3").append('<tr class="row-tbl3"><td>'+noArea+'</td><td>'+$(this).attr("no-sesion")+'</td><td>'+$(this).attr("nombre")+'</td><td>'+$(this).attr("data-value")+'</td><td>'+$(this).attr("tipo")+'</td><td hidden>'+$(this).attr("clave")+'</td></tr>');
					noArea ++;
					areasArray.push([$(this).attr("data-value"), $(this).attr("clave"), $(this).attr("value")]);
					idArea.push([$(this).attr("value")]);
					return areasArray;
				}).get();
			}

			$(".idarea3").val(idArea);
			var string1 = ($(".idarea").val()).split(',');
			var string2 = ($(".idarea2").val()).split(',');
			var string4 = ($(".idarea4").val()).split(',');
			var string5 = ($(".idarea5").val()).split(',');
			var countComplete = 0;
			for(var z = 0;z<tarifas3.length;z++){
				if(tarifas3[z][1] == 1){
					countComplete++;
					var found, found2, found4, found5;
					if(string1.length > 0){
						for(var y=0;y<string1.length;y++){
							found = string1.find(element => element == tarifas3[z][2]);
						}
					}
					if(string2.length > 0){
						for(var y=0;y<string2.length;y++){
							found2 = string2.find(element => element == tarifas3[z][2]);
						}
					}
					if(string4.length > 0){
						for(var y=0;y<string4.length;y++){
							found4 = string4.find(element => element == tarifas3[z][2]);
						}
					}
					if(string5.length > 0){
						for(var y=0;y<string5.length;y++){
							found5 = string5.find(element => element == tarifas3[z][2]);
						}
					}
					if(found != undefined || found2 != undefined || found4 != undefined || found5 != undefined){
						countComplete--;
					}
				}
			}
			$(".completo-3").val(countComplete);

			var suma3 = 0;
			if(tarifas3 != undefined){
				for(i = 0; i < tarifas3.length; i++) {
					suma3 = (suma3 + parseInt(tarifas3[i]));
				}
			}
			$(".rate-sl3").val(suma3);

			var valor = parseInt($(".rate-sl1").val()) + parseInt($(".rate-sl2").val()) + parseInt($(".rate-sl4").val()) + parseInt($(".rate-sl5").val());
			$("#total").val(suma3 + valor);
			var complete = parseInt($(".completo-1").val()) + parseInt($(".completo-2").val())+ parseInt($(".completo-4").val())+ parseInt($(".completo-5").val());
			$(".total-Cuerpocompleto").val(countComplete+complete);
			var areas = parseInt($(".total-areas1").val()) + parseInt($(".total-areas2").val()) + parseInt($(".total-areas4").val()) + parseInt($(".total-areas5").val());
			$(".total-areas").val(contador + areas);

			if (parseInt($(".total-areas").val()) == 1){
				$("#descuento").val(parseInt($("#total").val()) * 0.40);
			}
			if (parseInt($(".total-areas").val()) == 2){
				$("#descuento").val(parseInt($("#total").val()) * 0.50);
			}
			if (parseInt($(".total-areas").val()) == 3){
				$("#descuento").val(parseInt($("#total").val()) * 0.60);
			}
			if (parseInt($(".total-areas").val()) >= 4){
				$("#descuento").val(parseInt($("#total").val()) * 0.65);
			}
			if(parseInt($(".total-Cuerpocompleto").val())>15)
				$("#descuento").val(parseInt($("#total").val()) * 0.70);

			$(".precioFinal").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $(".precioFinal2").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $("#precioFinalC").val(parseInt($(".precioFinal").val()) + parseInt($("#totalrf").val()));

			calcularAnticipo();
			validateAdvance();
			changeAPagar();
			changeEntrance();
			valorMensualidad();
		}
		else{
			$(".total-areas3").val(0);
			$(".row-tbl3").remove();
			$(".rate-sl3").val(0);
			var valor2 = parseInt($(".rate-sl1").val()) + parseInt($(".rate-sl2").val()) + parseInt($(".rate-sl3").val()) + parseInt($(".rate-sl4").val()) + parseInt($(".rate-sl5").val());
			$("#total").val(valor2);
			var complete = parseInt($(".completo-1").val()) + parseInt($(".completo-2").val())+ parseInt($(".completo-4").val())+ parseInt($(".completo-5").val());
			$(".total-Cuerpocompleto").val(countComplete+complete);
			var areas = parseInt($(".total-areas1").val()) + parseInt($(".total-areas2").val()) + parseInt($(".total-areas4").val()) + parseInt($(".total-areas5").val());
			$(".total-areas").val(0 + areas);
			if (parseInt($(".total-areas").val()) == 0){
				$("#descuento").val(0);
			}
			if (parseInt($(".total-areas").val()) == 1){
				$("#descuento").val(parseInt($("#total").val()) * 0.40);
			}
			if (parseInt($(".total-areas").val()) == 2){
				$("#descuento").val(parseInt($("#total").val()) * 0.50);
			}
			if (parseInt($(".total-areas").val()) == 3){
				$("#descuento").val(parseInt($("#total").val()) * 0.60);
			}
			if (parseInt($(".total-areas").val()) >= 4){
				$("#descuento").val(parseInt($("#total").val()) * 0.65);
			}
			if(parseInt($(".total-Cuerpocompleto").val())>15)
				$("#descuento").val(parseInt($("#total").val()) * 0.70);
			
			$(".precioFinal").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $(".precioFinal2").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $("#precioFinalC").val(parseInt($(".precioFinal").val()) + parseInt($("#totalrf").val()));

			calcularAnticipo();
			validateAdvance();
			changeAPagar();
			changeEntrance();
			valorMensualidad();
		}
	}

	function select4(){
		// Obtenemos el total de opiones seleccionadas
		var slValue =  $('.select-cuatro').val();
		var idArea = [];
		if(slValue != undefined && slValue != null && slValue != ''){
			var contador = $('.select-cuatro option:selected').length;
			$(".total-areas4").val(contador);
			$(".row-tbl4").remove();
			if ($('.select-cuatro option:selected').length > 0) {
				var noArea = 1;
				var tarifas4 = $('.select-cuatro option:selected').map(function () {
					var areasArray = [];
					$("#tbody-areas4").append('<tr class="row-tbl4"><td>'+noArea+'</td><td>'+$(this).attr("no-sesion")+'</td><td>'+$(this).attr("nombre")+'</td><td>'+$(this).attr("data-value")+'</td><td>'+$(this).attr("tipo")+'</td><td hidden>'+$(this).attr("clave")+'</td></tr>');
					noArea ++;
					areasArray.push([$(this).attr("data-value"), $(this).attr("clave"), $(this).attr("value")]);
					idArea.push([$(this).attr("value")]);
					return areasArray;
				}).get();
			}

			$(".idarea4").val(idArea);
			var string1 = ($(".idarea").val()).split(',');
			var string2 = ($(".idarea2").val()).split(',');
			var string3 = ($(".idarea3").val()).split(',');
			var string5 = ($(".idarea5").val()).split(',');
			var countComplete = 0;
			for(var z = 0;z<tarifas4.length;z++){
				if(tarifas4[z][1] == 1){
					countComplete++;
					var found, found2, found3, found5;
					if(string1.length > 0){
						for(var y=0;y<string1.length;y++){
							found = string1.find(element => element == tarifas4[z][2]);
						}
					}
					if(string2.length > 0){
						for(var y=0;y<string2.length;y++){
							found2 = string2.find(element => element == tarifas4[z][2]);
						}
					}
					if(string3.length > 0){
						for(var y=0;y<string3.length;y++){
							found3 = string3.find(element => element == tarifas4[z][2]);
						}
					}
					if(string5.length > 0){
						for(var y=0;y<string5.length;y++){
							found5 = string5.find(element => element == tarifas4[z][2]);
						}
					}
					if(found != undefined || found2 != undefined || found3 != undefined || found5 != undefined){
						countComplete--;
					}
				}
			}
			$(".completo-4").val(countComplete);

			var suma4 = 0;
			if(tarifas4 != undefined){
				for(i = 0; i < tarifas4.length; i++) {
					suma4 = (suma4 + parseInt(tarifas4[i]));
				}
			}
			$(".rate-sl4").val(suma4);

			var valor = parseInt($(".rate-sl1").val()) + parseInt($(".rate-sl2").val()) + parseInt($(".rate-sl3").val()) + parseInt($(".rate-sl5").val());
			$("#total").val(suma4 + valor);
			// console.log("ESTE ES EL VALOR ACTUAL DE TOTAL 4: ", $("#total").val());
			var complete = parseInt($(".completo-1").val()) + parseInt($(".completo-2").val())+ parseInt($(".completo-3").val())+ parseInt($(".completo-5").val());
			$(".total-Cuerpocompleto").val(countComplete+complete);
			var areas = parseInt($(".total-areas1").val()) + parseInt($(".total-areas2").val()) + parseInt($(".total-areas3").val()) + parseInt($(".total-areas5").val());
			$(".total-areas").val(contador + areas);

			if (parseInt($(".total-areas").val()) == 1){
				$("#descuento").val(parseInt($("#total").val()) * 0.40);
			}
			if (parseInt($(".total-areas").val()) == 2){
				$("#descuento").val(parseInt($("#total").val()) * 0.50);
			}
			if (parseInt($(".total-areas").val()) == 3){
				$("#descuento").val(parseInt($("#total").val()) * 0.60);
			}
			if (parseInt($(".total-areas").val()) >= 4){
				$("#descuento").val(parseInt($("#total").val()) * 0.65);
			}
			if(parseInt($(".total-Cuerpocompleto").val())>15)
				$("#descuento").val(parseInt($("#total").val()) * 0.70);

			$(".precioFinal").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $(".precioFinal2").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $("#precioFinalC").val(parseInt($(".precioFinal").val()) + parseInt($("#totalrf").val()));

			calcularAnticipo();
			validateAdvance();
			changeAPagar();
			changeEntrance();
			valorMensualidad();
		}
		else{
			$(".total-areas4").val(0);
			$(".row-tbl4").remove();
			$(".rate-sl4").val(0);
			var valor2 = parseInt($(".rate-sl1").val()) + parseInt($(".rate-sl2").val()) + parseInt($(".rate-sl3").val()) + parseInt($(".rate-sl4").val()) + parseInt($(".rate-sl5").val());
			$("#total").val(valor2);
			var complete = parseInt($(".completo-1").val()) + parseInt($(".completo-2").val())+ parseInt($(".completo-3").val())+ parseInt($(".completo-5").val());
			$(".total-Cuerpocompleto").val(countComplete+complete);
			var areas = parseInt($(".total-areas1").val()) + parseInt($(".total-areas2").val()) + parseInt($(".total-areas3").val()) + parseInt($(".total-areas5").val());
			$(".total-areas").val(0 + areas);
			if (parseInt($(".total-areas").val()) == 0){
				$("#descuento").val(0);
			}
			if (parseInt($(".total-areas").val()) == 1){
				$("#descuento").val(parseInt($("#total").val()) * 0.40);
			}
			if (parseInt($(".total-areas").val()) == 2){
				$("#descuento").val(parseInt($("#total").val()) * 0.50);
			}
			if (parseInt($(".total-areas").val()) == 3){
				$("#descuento").val(parseInt($("#total").val()) * 0.60);
			}
			if (parseInt($(".total-areas").val()) >= 4){
				$("#descuento").val(parseInt($("#total").val()) * 0.65);
			}

			if(parseInt($(".total-Cuerpocompleto").val())>15)
				$("#descuento").val(parseInt($("#total").val()) * 0.70);

			$(".precioFinal").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $(".precioFinal2").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $("#precioFinalC").val(parseInt($(".precioFinal").val()) + parseInt($("#totalrf").val()));

			calcularAnticipo();
			validateAdvance();
			changeAPagar();
			changeEntrance();
			valorMensualidad();
		}
	}

	function select5(){
		// Obtenemos el total de opiones seleccionadas
		var slValue = $('.select-cinco').val();
		var idArea = [];
		if(slValue != undefined && slValue != null && slValue != ''){
			var contador = $('.select-cinco option:selected').length;
			$(".total-areas5").val(contador);
			$(".row-tbl5").remove();
			if ($('.select-cinco option:selected').length > 0) {
				var noArea = 1;
				var tarifas5 = $('.select-cinco option:selected').map(function () {
					var areasArray = [];
					$("#tbody-areas5").append('<tr class="row-tbl5"><td>'+noArea+'</td><td>'+$(this).attr("no-sesion")+'</td><td>'+$(this).attr("nombre")+'</td><td>'+$(this).attr("data-value")+'</td><td>'+$(this).attr("tipo")+'</td><td hidden>'+$(this).attr("clave")+'</td></tr>');
					noArea ++;
					areasArray.push([$(this).attr("data-value"), $(this).attr("clave"), $(this).attr("value")]);
					idArea.push([$(this).attr("value")]);
					return areasArray;
				}).get();
			}
			$(".idarea5").val(idArea);
			var string1 = ($(".idarea").val()).split(',');
			var string2 = ($(".idarea2").val()).split(',');
			var string3 = ($(".idarea3").val()).split(',');
			var string4 = ($(".idarea4").val()).split(',');
			var countComplete = 0;
			for(var z = 0;z<tarifas5.length;z++){
				if(tarifas5[z][1] == 1){
					countComplete++;
					var found, found2, found3, found4;
					if(string1.length > 0){
						for(var y=0;y<string1.length;y++){
							found = string1.find(element => element == tarifas5[z][2]);
						}
					}
					if(string2.length > 0){
						for(var y=0;y<string2.length;y++){
							found2 = string2.find(element => element == tarifas5[z][2]);
						}
					}
					if(string3.length > 0){
						for(var y=0;y<string3.length;y++){
							found3 = string3.find(element => element == tarifas5[z][2]);
						}
					}
					if(string4.length > 0){
						for(var y=0;y<string4.length;y++){
							found4 = string4.find(element => element == tarifas5[z][2]);
						}
					}
					if(found != undefined || found2 != undefined || found3 != undefined || found4 != undefined){
						countComplete--;
					}
				}
			}
			$(".completo-5").val(countComplete);

			var suma5 = 0;
			var areasCp5 = 0;
			if(tarifas5 != undefined){
				for(i = 0; i < tarifas5.length; i++) {
					suma5 = (suma5 + parseInt(tarifas5[i][0]));
					if(parseInt(tarifas5[i][1]) == 1) areasCp5++;
				}
			}

			$(".rate-sl5").val(suma5);
			var valor = parseInt($(".rate-sl1").val()) + parseInt($(".rate-sl2").val()) + parseInt($(".rate-sl3").val()) + parseInt($(".rate-sl4").val());
			$("#total").val(suma5 + valor);
			var complete = parseInt($(".completo-1").val()) + parseInt($(".completo-2").val())+ parseInt($(".completo-3").val())+ parseInt($(".completo-4").val());
			$(".total-Cuerpocompleto").val(countComplete+complete);

			var areas = parseInt($(".total-areas1").val()) + parseInt($(".total-areas2").val()) + parseInt($(".total-areas3").val()) + parseInt($(".total-areas4").val());
			$(".total-areas").val(contador + areas);

			if (parseInt($(".total-areas").val()) == 1)
				$("#descuento").val(parseInt($("#total").val()) * 0.40);

			if (parseInt($(".total-areas").val()) == 2)
				$("#descuento").val(parseInt($("#total").val()) * 0.50);

			if (parseInt($(".total-areas").val()) == 3)
				$("#descuento").val(parseInt($("#total").val()) * 0.60);

			if (parseInt($(".total-areas").val()) >= 4)
				$("#descuento").val(parseInt($("#total").val()) * 0.65);

			if(parseInt($(".total-Cuerpocompleto").val())>15)
				$("#descuento").val(parseInt($("#total").val()) * 0.70);

			$(".precioFinal").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $(".precioFinal2").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $("#precioFinalC").val(parseInt($(".precioFinal").val()) + parseInt($("#totalrf").val()));

			calcularAnticipo();
			validateAdvance();
			changeAPagar();
			changeEntrance();
			valorMensualidad();
		}
		else{
			$(".total-areas5").val(0);
			$(".row-tbl5").remove();
			$(".rate-sl5").val(0);
			var valor2 = parseInt($(".rate-sl1").val()) + parseInt($(".rate-sl2").val()) + parseInt($(".rate-sl3").val()) + parseInt($(".rate-sl4").val()) + parseInt($(".rate-sl5").val());
			$("#total").val(valor2);
			var complete = parseInt($(".completo-1").val()) + parseInt($(".completo-2").val())+ parseInt($(".completo-3").val())+ parseInt($(".completo-4").val());
			$(".total-Cuerpocompleto").val(countComplete+complete);
			var areas = parseInt($(".total-areas1").val()) + parseInt($(".total-areas2").val()) + parseInt($(".total-areas3").val()) + parseInt($(".total-areas4").val());
			$(".total-areas").val(0 + areas);
			if (parseInt($(".total-areas").val()) == 0){
				$("#descuento").val(0);
			}
			if (parseInt($(".total-areas").val()) == 1){
				$("#descuento").val(parseInt($("#total").val()) * 0.40);
			}
			if (parseInt($(".total-areas").val()) == 2){
				$("#descuento").val(parseInt($("#total").val()) * 0.50);
			}
			if (parseInt($(".total-areas").val()) == 3){
				$("#descuento").val(parseInt($("#total").val()) * 0.60);
			}
			if (parseInt($(".total-areas").val()) >= 4){
				$("#descuento").val(parseInt($("#total").val()) * 0.65);
			}

			if(parseInt($(".total-Cuerpocompleto").val())>15)
				$("#descuento").val(parseInt($("#total").val()) * 0.70);

			$(".precioFinal").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $(".precioFinal2").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $("#precioFinalC").val(parseInt($(".precioFinal").val()) + parseInt($("#totalrf").val()));

			calcularAnticipo();
			validateAdvance();
			changeAPagar();
			changeEntrance();
			valorMensualidad();
		}
	}

	$("#cuerpo-completo1").on('click',function(){
		var valArr = [6, 7, 9, 10, 12, 14, 15, 16, 18, 19, 20, 21, 24, 27, 28, 32, 33];
		size = valArr.length; // detect array length
		// looping over array
		for (i = 0; i < size; i++) {
			$(".select-uno option[value='" + valArr[i] + "']").attr("selected", 1);
		}
		select1();
	})

	$("#cuerpo-completo2").on('click',function(){
		var valArr = [6, 7, 9, 10, 12, 14, 15, 16, 18, 19, 20, 21, 24, 27, 28, 32, 33];
		size = valArr.length; // detect array length
		// looping over array
		for (i = 0; i < size; i++) {
			$(".select-dos option[value='" + valArr[i] + "']").attr("selected", 1);
		}
		select2();
	})

	$("#cuerpo-completo3").on('click',function(){
		var valArr = [6, 7, 9, 10, 12, 14, 15, 16, 18, 19, 20, 21, 24, 27, 28, 32, 33];
		size = valArr.length; // detect array length
		// looping over array
		for (i = 0; i < size; i++) {
			$(".select-tres option[value='" + valArr[i] + "']").attr("selected", 1);
		}
		select3();
	})

	$("#cuerpo-completo4").on('click',function(){
		var valArr = [6, 7, 9, 10, 12, 14, 15, 16, 18, 19, 20, 21, 24, 27, 28, 32, 33];
		size = valArr.length; // detect array length
		// looping over array
		for (i = 0; i < size; i++) {
			$(".select-cuatro option[value='" + valArr[i] + "']").attr("selected", 1);
		}
		select4();
	})

	$("#cuerpo-completo5").on('click',function(){
		var valArr = [6, 7, 9, 10, 12, 14, 15, 16, 18, 19, 20, 21, 24, 27, 28, 32, 33];
		size = valArr.length; // detect array length
		// looping over array
		for (i = 0; i < size; i++) {
			$(".select-cinco option[value='" + valArr[i] + "']").attr("selected", 1);
		}
		select5();
	})

	function buildTable(t){
        let id_select = t.id;
        let origen = id_select.replace('select','');
        let slValue =  $('#'+id_select).val();
        let noVenus = 0;
        console.log($('#' + id_select + ' option:selected').val());
        //AA:  Limpiamos el array del select donde se dispara la función después se hace el push de los obj.
        if(slValue != undefined && slValue != null && slValue != ''){
            arrayDinamico = identificarArray(origen);
            $('#' + id_select + ' option:selected').map(function (index, value) {
                let indexx = index + 1;
                opcion = compararArraysNpush(arrayDinamico, slValue, value, false, origen);
                if (opcion.nuevaOp){
                    html = '<tr class="content-tabs" id="row-b-tbl'+$(this).val()+'_'+origen+'">';
                    html += '<td>' + arrayDinamico.length + '</td>';
                    // html += '<td>1</td>';
                    html += '<td>'+$(this).attr("tipo")+'</td>';

                    html += '<td><input type="text" id="sesiones_'+$(this).val()+'" class="form-control readonlys" onkeypress="return onlyNumbers(event)" value="'+$(this).attr("no-sesion")+'"/></td>';
                    
                    html += '<td>'+$(this).attr("nombre")+'</td>';

                    //AA: Validamos si vamos si el área seleccionada es Lipoenzímatica si sí aplicamos multiselect si no N/A
                    if ($(this).val() == "75") html += '<td><select class="g-disabld form-control scroll-styles areaslipo areastratamiento_'+$(this).val()+'" data-name="areastratamiento_'+$(this).val()+'" style="overflow: auto !important; height: 60px !important;" name="areaslipo" multiple></select></td>';
                    else html += '<td><input type="text" class="form-control" value="N/A" disabled/></td>';

                    if ($(this).val() == "75") html += '<td><input type="text" id="piezas_'+$(this).val()+'" class="form-control readonlys" onkeypress="return onlyNumbers(event)" value="'+$(this).attr("no-sesion")+'"></td>';
                    else html += '<td><input type="text" id="piezas_'+$(this).val()+'" class="form-control readonlys" onkeypress="return onlyNumbers(event)" value="'+$(this).attr("no-sesion")+'"></td>';
                    
                    if ($(this).val() == "75") html += '<td><input type="text" class="form-control" value="$'+formatMoney($(this).attr("data-value"))+'" disabled style="color: white;"></td>';
                    else html += '<td><input type="text" class="form-control" value="$'+formatMoney($(this).attr("data-value"))+'" disabled></td>';
                    
                    html += '<td><input  id="precio_'+$(this).val()+'" type="text" class="form-control" onkeypress="return onlyNumbers(event)" value="$'+formatMoney($(this).attr("data-value"))+'" disabled></td></tr>';
                    $("#tbody-tratamientos"+origen).append(html);

                    let id_tratamiento = $(this).val();
                    let input_piezas = document.querySelector('#row-b-tbl'+$(this).val()+'_'+origen+' #piezas_'+$(this).val());
                    let input_precio = document.querySelector('#row-b-tbl'+$(this).val()+'_'+origen+' #precio_'+$(this).val());
                    let input_sesiones = document.querySelector('#row-b-tbl'+$(this).val()+'_'+origen+' #sesiones_'+$(this).val());

                    let precioBase = $("select[id='select"+origen+"'] option[value='"+$(this).val()+"']").data("value");
                    let promociones = $("select[id='select"+origen+"'] option[value='"+$(this).val()+"']").data("promo");

                    //AA: Evaluamos si se pueden editar las sesiones si es 0 no se editan.
                    if ($(this).attr("data-sesione") == "0" || $(this).val() == "75") input_sesiones.disabled = true;
                    else input_sesiones.style.border = "3px solid #a06fce";

                    //AA: Evaluamos si las piezas serán editables o no
                    if ($(this).attr("data-piezas") == "1" || $(this).val() == "75") input_piezas.disabled = true;
                    else input_piezas.style.border = "3px solid #a06fce";

                    //AA: Añadimos funcionalidad select2 a selects que tengan clase areastratamiento_x
                    let multiareas = document.querySelector('#tbody-tratamientos'+origen+' .areastratamiento_'+$(this).val());
                    if (multiareas != null){
                        jQuery(multiareas).select2({
                            allowClear: false
                        }).on("select2:unselecting", function(e) {
                            $(this).data('state', 'unselected');
                        }).on("select2:open", function(e){
                            if ($(this).data('state') === 'unselected') {
                                $(this).removeData('state');
                                jQuery(multiareas).select2('close');
                            }
                        });

                        jQuery(multiareas).on("select2:select", function (evt){
                            var element = evt.params.data.element;
                            var $element = $(element);
                            $element.detach();
                            $(this).append($element);
                        });
                        getAreasLipoenzimas(multiareas, id_tratamiento, origen);
                    }
                    calcMontosTratamientos(origen);

                    input_piezas.onkeyup = () => piezasXprecio(id_tratamiento, origen, input_piezas, input_precio, precioBase);
                    input_piezas.onchange = () => validateEmpty(id_tratamiento, origen, input_piezas, input_precio, input_sesiones, precioBase);
                    input_sesiones.onkeyup = ()=> sesionesXprecio(id_tratamiento, origen, input_precio, input_sesiones, precioBase, promociones, false);
                    input_sesiones.onchange = () => validateEmpty(id_tratamiento, origen, input_piezas, input_precio, input_sesiones, precioBase);
                    if (multiareas != null) multiareas.onchange = () => buildSubtable(id_tratamiento, origen, multiareas, input_precio, input_sesiones, input_piezas);
                }
                if(opcion.deleteOp){
                    $("#row-b-tbl"+opcion.deleteId+'_'+origen).remove();
                    calcMontosTratamientos(origen);
                }
            });
        }
        else{
            //AA: Limpiamos toda la tabla del clienteX, dejamos el encabezado e inicialisamos el arrayX en []
            $("#tbody-tratamientos"+origen+" .content-tabs").remove();
            limpiarArrays(origen);
            calcMontosTratamientos(origen);
            validateVenus();
        }
    }

	//AA: Función para eliminar la subtable del tratamiento lipoenzimas
    function buildSubtable(id_tratamiento, origen, multiareas){
        let class_lipoen = multiareas.dataset.name;
        let valueSlc =  $('#tbody-tratamientos'+origen+ ' .'+class_lipoen).val();
        arrayDinamico = identificarArray(origen);
        //AA: Array de las áreas de lipoenzimas, puede ser del cliente1, cliente2, etc...
        objectFound = arrayDinamico.find(obj => obj.id == id_tratamiento);
        if( valueSlc != undefined && valueSlc != null && valueSlc != ''){
            arrayDetail = objectFound;
            //AA: Solo creamos el encabezado para el primera opción
            $('#tbody-tratamientos' +origen+ ' .'+class_lipoen+' option:selected').map(function (index, value) {
                //AA: Recibimos un objeto con un id y una bandera para identificar si se eliminó o añadió una nueva área al select de lipo
                opcionn = compararArraysNpush(arrayDetail.areas, valueSlc, value, true, origen);            
                let id_area = value;
                //AA: Si es verdadero significa que el ID del área seleccionada aún no existia en el array y lo agregamos a la subtabla.
                if (opcionn.nuevaOp){
                    html = '<tr class="detail-tabs" id="row-tbl-detail'+$(this).val()+'_'+origen+'" style="text-align:center">';
                    // html += '<td>'+indexx+'</td>';
                    html += '<td>1</td>';
                    html += '<td>Lipoenzimas</td>';
                    html += '<td><input type="text" id="sesionesd_'+$(this).val()+'" class="form-control readonlys" onkeypress="return onlyNumbers(event)" value="1" style="text-align:center; background-color: #eee7f5; border: 3px solid #a06fce;"/></td>';
                    html += '<td>'+$(this).attr("nombre")+'</td>';
                    html += '<td><input type="text" id="preciobase_'+$(this).val()+'" class="form-control" value="$'+formatMoney($(this).attr("data-value"))+'" style="text-align:center; background-color: #eee7f5;" disabled></td>';
                    html += '<td><input type="text" id="precio_'+$(this).val()+'" class="form-control" onkeypress="return onlyNumbers(event)" value="$'+formatMoney($(this).attr("data-value"))+'" style="text-align:center; background-color: #eee7f5;" disabled></td></tr>';
                    $("#tbody-lipoenzimas"+origen).append(html);

                    let input_sesiones = document.querySelector('#row-tbl-detail'+$(this).val()+'_'+origen+' #sesionesd_'+$(this).val());
                    let input_precio = document.querySelector('#row-tbl-detail'+$(this).val()+'_'+origen+' #precio_'+$(this).val());
                    let input_preciobase = document.querySelector('#row-tbl-detail'+$(this).val()+'_'+origen+' #preciobase_'+$(this).val());
                    let precioBase = parseInt(unmaskMoney(input_preciobase.value));

                    input_sesiones.onkeyup = ()=> sesionesXdetail(origen, arrayDetail, input_sesiones, input_precio, precioBase, id_area, id_tratamiento);
                    input_sesiones.onchange = () => validateEmptyDetail(origen, arrayDetail, input_sesiones, input_precio, precioBase, id_area, id_tratamiento);
                    calcLipoenzimas(origen, arrayDetail, id_tratamiento);
                }
                //AA: Si es falso, significa que ya no existe en el array pero que si existe en la subtabla por tanto eliminaos en base a la clase en espcifico
                if(opcionn.deleteOp){
                    $("#row-tbl-detail"+opcionn.deleteId+'_'+origen).remove();
                    //AA: Se vuelve a hacer el calculo de los totales que llevamos al eliminar un elemento
                    calcLipoenzimas(origen, arrayDetail, id_tratamiento);
                }
            });
        }
        else{
            //AA: Limpiamos toda la subtable de lipoenzimas, dejamos el encabezado e inicialisampos el array de áreas lipoenzimas a []
            $("#tbody-tratamientos"+origen+" .detail-tabs").remove();
            objectFound.areas = [];
            calcLipoenzimas(origen, arrayDetail, id_tratamiento);
        }
    }

    function getAreasLipoenzimas(multiareas, id_tratamiento, origen){
        $('#loader').removeClass('hidden');
        $.getJSON( url2 + "Clientes/get_areasLipoenzimas").done( function( data ){
            $.each( data, function( i, v){
                event.preventDefault();
                jQuery.noConflict();
                multiareas.innerHTML += '<option value="'+v.id_area+'" data-value="'+v.tarifa+'" no-sesion="1" nombre="'+v.nombre+'">'+v.nombre+'</option>';
            });
			$('#loader').addClass('hidden');
        });
        let row_tratamiento = document.getElementById('row-b-tbl'+id_tratamiento+'_'+origen);
        var tr_base = document.createElement("tr");
        tr_base.setAttribute("id", "tr_subTable_"+origen+"");

        tr_base.innerHTML = '<td colspan="13" style="padding: 10px 50px"><table class="table" style="background-color: #eee7f5!important; border-radius: 10px;"><tbody id="tbody-lipoenzimas'+origen+'""><tr style="border-bottom: 1px solid #fff; color: #4b4b4b; text-align:center"><td style="width: 8%; font-size: 12px; border-top:0;">No. área</td><td style="width:15%; border-top:0;">Tipo</td><td style="width:12%; border-top:0;">No. sesiones</td><td style="width:75px; border-top:0;">Área</td><td style="width:20%; border-top:0;">Precio unitario</td><td style="width:20%; border-top:0;">Precio total</td></tr></tbody></table></td>';
        row_tratamiento.insertAdjacentElement('afterend', tr_base);
    }

    function sesionesXprecio(id_tratamiento, origen, input_precio, input_sesiones, precioBase, promociones, lipoenzimas){
        if (promociones != "0"){
            if (input_sesiones.value != "3" && input_sesiones.value != "4" && input_sesiones.value != "6"){
                input_precio.value = '$'+formatMoney(input_sesiones.value * precioBase);
            }
            else{
                arrayPromo = promociones.toString().split(',');
                for(let i=0; i<arrayPromo.length; i++){
                    if(input_sesiones.value == arrayPromo[i] && input_sesiones.value == "3" ){
                        if(id_tratamiento == "74") input_precio.value = '$'+formatMoney(5400);
                        break;
                    }
                    else if(input_sesiones.value == arrayPromo[i] && input_sesiones.value == "4" ){
                        if(id_tratamiento == "66") input_precio.value = '$'+formatMoney(16900);
                        else if(id_tratamiento == "68" || id_tratamiento == "69" || id_tratamiento == "70" || id_tratamiento == "71" || id_tratamiento == "73"){
                            input_precio.value = '$'+formatMoney(10900);
                        }
                        else if(id_tratamiento == "72") input_precio.value = '$'+formatMoney(5900);
                        else if(id_tratamiento == "76" || id_tratamiento == "77") input_precio.value = '$'+formatMoney(4900);
                        break;
                    }
                    else if(input_sesiones.value == arrayPromo[i] && input_sesiones.value == "6" ){
                        if(id_tratamiento == "68" || id_tratamiento == "69" || id_tratamiento == "70" || id_tratamiento == "71")input_precio.value = '$'+formatMoney(14900);
                        else if(id_tratamiento == "75" || id_tratamiento == "76" || id_tratamiento == "77")input_precio.value = '$'+formatMoney(9900);
                        break;
                    }
                    else{
                        input_precio.value = '$'+formatMoney(input_sesiones.value * precioBase);
                    }
                }
            }
        }
        else{
            input_precio.value = '$'+formatMoney(input_sesiones.value * precioBase);
        }
        arrayDinamico = identificarArray(origen);
        if(arrayDinamico.length > 0) objectFound = arrayDinamico.find(obj => obj.id == id_tratamiento);
        objectFound.costo = unmaskMoney(input_precio.value);
        calcMontosTratamientos(origen);
    }

    function sesionesXdetail(origen, arrayDetail, input_sesiones, input_precio, precioBase, id_area, id_tratamiento){
        input_precio.value = '$'+formatMoney(input_sesiones.value * precioBase);
        for(let i=0; i < arrayDetail.areas.length; i++){
            if (arrayDetail.areas[i].id == id_area.value){
                arrayDetail.areas[i].costo = input_sesiones.value * precioBase;
                arrayDetail.areas[i].sesiones =  input_sesiones.value;
                break;
            }
        }
        calcLipoenzimas(origen, arrayDetail, id_tratamiento);
    }

    //AA: Push del objeto a los array generales, validamos en que array se hará dicho push
    function identificarArray(origen){
        if ( origen == 6 ) return arrayTratamientos1;
        else if ( origen == 7 ) return arrayTratamientos2;
        else if ( origen == 8 ) return arrayTratamientos3;
        else if ( origen == 9 ) return arrayTratamientos4;
        else if ( origen == 10 ) return arrayTratamientos5;
    }

    //AA: Función para limpiar arrayX según sea el origen
    function limpiarArrays(origen){
        if(origen == 6) arrayTratamientos1 = [];
        else if(origen == 7) arrayTratamientos2 = [];
        else if(origen == 8) arrayTratamientos3 = [];
        else if(origen == 9) arrayTratamientos4 = [];
        else if(origen == 10) arrayTratamientos5 = [];
    }

    //AA: Función para hacer push en el arrayX así como delete en arrayX según sea el caso
    function compararArraysNpush(arrayDinamico, slValue, option, lipoenzimas, origen){
        let response = {
            'nuevaOp': false,
            'deleteOp': false,
            'deleteId': ''
        };
        let tratamientoObj = {};
        if(!lipoenzimas){
            slValue = $('#select'+origen).val();
            tratamientoObj = { id: option.value, sesiones: option.getAttribute("no-sesion"), costo : option.getAttribute("data-value"), areas: [], piezas: '1', venus: option.getAttribute("venus")};
        }
        else{
            tratamientoObj = {id: option.value, sesiones: option.getAttribute("no-sesion"), costo : option.getAttribute("data-value"), piezas: '1'};
        }

        for (let i=0; i < slValue.length; i++){
            objectFound = arrayDinamico.find(obj => obj.id == slValue[i]);
            if(arrayDinamico.length < slValue.length){
                if(objectFound == undefined){
                    response.nuevaOp = true;
                    arrayDinamico.push(tratamientoObj);
                }
            }
            else if (arrayDinamico.length > slValue.length){                
                for (let z = 0; z<arrayDinamico.length; z++){
                    deleted = slValue.find(obj => obj == arrayDinamico[z].id);
                    if(deleted == undefined){
                        response.deleteOp = true;
                        response.deleteId = arrayDinamico[z].id;
                        arrayDinamico.splice(z, 1);
                        //AA: Evaluamos si el área eliminada es Lipoenzias para limpiar el encabezado de subtable lipoenzimas 
                        if (response.deleteId == '75'){
                            document.getElementById("tr_subTable_"+origen+"").innerHTML ='';
                        }
                    }
                }
            }
        }

        if (!lipoenzimas) validateVenus();
        return response;
    }

    function piezasXprecio(id_tratamiento, origen, input_piezas, input_precio, precioBase){
        let newPrice =  input_piezas.value * precioBase;
        input_precio.value = '$' +formatMoney(newPrice);
        arrayDinamico = identificarArray(origen);
        //AA: Buscamos en el array el objeto por su id y lo modificamos
        if(arrayDinamico.length > 0) objectFound = arrayDinamico.find(obj => obj.id == id_tratamiento);
        objectFound.piezas = input_piezas.value;
        objectFound.costo = unmaskMoney(input_precio.value);
        calcMontosTratamientos(origen);
    }

    //AA: Función para validar si algún fue dejado en blanco en el evento on change de ser así, arrojo un valor default de 1 y precio base
    function validateEmpty(id_tratamiento, origen, input_piezas, input_precio, input_sesiones, precioBase){
        if( input_piezas.value == '' || input_piezas.value == 0){
            input_piezas.value = 1;
            let newPrice =  input_piezas.value * precioBase;
            input_precio.value = '$'+formatMoney(newPrice);
        }
        if (input_sesiones.value == '' || input_sesiones.value == 0){
            input_sesiones.value = 1;
            let newPrice = input_sesiones.value * precioBase;
            input_precio.value = '$'+formatMoney(newPrice);
        }
        arrayDinamico = identificarArray(origen);
        //AA: Buscamos en el array el objeto por su id y lo modificamos
        if(arrayDinamico.length > 0) objectFound = arrayDinamico.find(obj => obj.id == id_tratamiento);
        objectFound.piezas = input_piezas.value;
        objectFound.sesiones = input_sesiones.value;
        objectFound.costo = unmaskMoney(input_precio.value);
        calcMontosTratamientos(origen);
    }

    //AA: Función para validar si algún fue dejado en blanco en el evento on change de ser así, arrojo un valor default de 1 y precio base
    function validateEmptyDetail(origen, arrayDetail, input_sesiones, input_precio, precioBase, id_area, id_tratamiento){
        let newPrice = '';
        if (input_sesiones.value == '' || input_sesiones.value == 0){
            input_sesiones.value = 1;
            newPrice = input_sesiones.value * precioBase;
            input_precio.value = '$'+formatMoney(newPrice);

            for(let i=0; i < arrayDetail.areas.length; i++){
                if (arrayDetail.areas[i].id == id_area.value){
                    arrayDetail.areas[i].costo = newPrice;
                    arrayDetail.areas[i].sesiones =  1;
                    break;
                }
            }
            calcLipoenzimas(origen, arrayDetail, id_tratamiento);
        }
    }

    function calcMontosTratamientos(origen){
        let suma = 0;
        let total = 0;
        let input_suma = document.querySelector('#sumat_'+origen);
        arrayDinamico = identificarArray(origen);
        if (arrayDinamico.length > 0) {
            for(let i=0; i < arrayDinamico.length; i++){
                suma = suma + parseInt(arrayDinamico[i].costo);
            }
        }
        input_suma.value = '$'+formatMoney(suma);
        input_totalrf = document.querySelector('#totalrf');
        input_totaldm = document.querySelector('.precioFinal');
        input_total = document.querySelector('#precioFinalC');
        for(i=6; i<11; i++){
            let input_t = document.querySelector('#sumat_'+i);
            total = total + parseInt(unmaskMoney(input_t.value));
        }
        input_totalrf.value = total;
        input_total.value = parseInt(input_totalrf.value) + parseInt(input_totaldm.value);
        calcularAnticipo();
        valorMensualidad();
    }

    //AA: Función para calcular los montos según las sesiones y áreas de lipoenzimas seleccionadas.
    function calcLipoenzimas(origen, arrayDinamico, id_tratamiento){
        let suma = 0;
        let sesiones = 0;
        let noareas = 0;

        let input_piezas_g = document.querySelector('#row-b-tbl'+id_tratamiento+'_'+origen+' #piezas_'+id_tratamiento);
        let input_precio_g = document.querySelector('#row-b-tbl'+id_tratamiento+'_'+origen+' #precio_'+id_tratamiento);
        let input_sesiones_g = document.querySelector('#row-b-tbl'+id_tratamiento+'_'+origen+' #sesiones_'+id_tratamiento);
        if (arrayDinamico.areas.length > 0) {
            noareas = noareas + arrayDinamico.areas.length;
            for(let i=0; i < arrayDinamico.areas.length; i++){
                suma = suma + parseInt(arrayDinamico.areas[i].costo);
                sesiones = sesiones + parseInt(arrayDinamico.areas[i].sesiones); 
                
            }
        }
        input_piezas_g.value = noareas;
        input_sesiones_g.value = sesiones;
        input_precio_g.value = '$'+formatMoney(suma);
        arrayDinamico.costo = suma;
        arrayDinamico.sesiones = sesiones;
        calcMontosTratamientos(origen);
    }

    //AA: Función para validad si al menos uno de los array por cliente trae algun área de Venus, de ser así cambiamos el valor de area_sel, para imprimir el contrato mixto 
    function validateVenus(){
        let cont = 0;
        for(let i=0; i < arrayTratamientos1.length; i++){
            if (arrayTratamientos1[i].venus == 1) cont++;
        }
        for(let i=0; i < arrayTratamientos2.length; i++){
            if (arrayTratamientos2[i].venus == 1) cont++;
        }
        for(let i=0; i < arrayTratamientos3.length; i++){
            if (arrayTratamientos3[i].venus == 1) cont++;            
        }
        for(let i=0; i < arrayTratamientos4.length; i++){
            if (arrayTratamientos4[i].venus == 1) cont++;
        }
        for(let i=0; i < arrayTratamientos5.length; i++){
            if (arrayTratamientos5[i].venus == 1) cont++;
        }

        if(cont > 0){
            venus = true
            $("#area_sel").val(5);
        } 
        else if (seleccionPrincipal != 5){
            venus = false;
            $("#area_sel").val(4);
        }
    }

	//Aplica el multiselect al select "areas"
	$(".areas").select2({
		allowClear: false,
    }).on("select2:unselecting", function(e) {
        $(this).data('state', 'unselected');
    }).on("select2:open", function(e){
        if ($(this).data('state') === 'unselected') {
            $(this).removeData('state');
            jQuery(".areas").select2('close');
        }
    });

	//Aplica el multiselect al select "tratamientos"
    $(".tratamientos").select2({
        allowClear: false
    }).on("select2:unselecting", function(e) {
        $(this).data('state', 'unselected');
    }).on("select2:open", function(e){
        if ($(this).data('state') === 'unselected') {
            $(this).removeData('state');
            jQuery(".tratamientos").select2('close');
        }
    });

	//Unordered select
	$(".areas").on("select2:select", function (evt){
		var element = evt.params.data.element;
		var $element = $(element);
		$element.detach();
		$(this).append($element);
		$(this).trigger("change");
	});

	$(".tratamientos").on("select2:select", function (evt) {
      var element = evt.params.data.element;
      var $element = $(element);
      $element.detach();
      $(this).append($element);
      $(this).trigger("change");
    });

	//Cambiar opción seleccionada tarjeta titular
	$("#tp1").change(function(){
		var valor = $(this).val();
		if ( valor = 1 ){
			$("#tp2").val(2);
		}
	});

	//Cambiar opción seleccionada tarjeta titular
	$("#tp2").change(function(){
		var valor = $(this).val();
		if ( valor = 1 ){
			$("#tp1").val(2);
		}
	});

	//Llena todos los selects cuya clase sea listado-tiposCobro, con opciones de tipo de cobro
	$(".listado-tiposCobro").ready( function(){
		$.getJSON( url2 + "Clientes/lista_tiposCobro").done( function( data ){
			$.each( data, function( i, v){
				event.preventDefault();
				jQuery.noConflict();
				$(".listado-tiposCobro").append('<option value="'+v.id_opcion+'" data-value="'+v.id_catalogo+'">'+v.nombre+'</option>');
			});
		});
	});

	$(".listado-tipos").ready( function(){
		// $(".listado-tipos").append('<option value="">Seleccione una opción</option>');
		$.getJSON( url2 + "Clientes/lista_tipos").done( function( data ){
			$.each( data, function( i, v){
				event.preventDefault();
				jQuery.noConflict();
				$(".listado-tipos").append('<option value="'+v.id_opcion+'" data-value="'+v.id_catalogo+'">'+v.nombre+'</option>');
			});
		});
	});

	$(".myselect").select2();

	$(".listado-bancos").ready( function(){
		$.getJSON( url2 + "Clientes/lista_bancos").done( function( data ){
			$.each( data, function( i, v){
				event.preventDefault();
				jQuery.noConflict();
				$(".listado-bancos").append('<option value="'+v.id_banco+'">'+v.nombre+'</option>');
			});
		});
	});

	$(".listado-enfermeras").ready( function(){
		$(".listado-enfermeras").append('<option value="">Seleccione una opción</option>');
		$.getJSON( url2 + "Clientes/getEnfermeras").done( function( data ){
			$.each( data, function( i, v){
				event.preventDefault();
				jQuery.noConflict();
				$(".listado-enfermeras").append('<option value="'+v.id_usuario+'">'+v.name_enfermera+'</option>');
			});
		});
	})

	$(document).ready(function(){
		//Modal para seleccionar area inicial
		jQuery("#modalTipoArea").modal("show");
		// $('#tp1').prop("disabled", true);

		//Habilitamos formaPago para que sea Multiselect
		$('#formaPago').multiselect({
			nonSelectedText:'Seleccione una opción'
		});

		$('#efectivo').on('click focusin', function() {
			this.value = '';
			changeEntrance();
		});

		$('#efectivo').focusout(function(){
			if($('#efectivo').val()!= '')
				jQuery("#modalEfectivo").modal("show");
		});

		$('#montoTU').on('click focusin', function() {
			this.value = '';
			changeEntrance();
		});

		$('#montoTD').on('click focusin', function() {
			this.value = '';
			changeEntrance();
		});

		$(document).on('click', '#btnsubmit', function(){
			$('#tp1').prop("disabled", false);
			$('#tp2').prop("disabled", false);
			$('#parcialidades').prop("disabled", false);

			var values1 = $('.select-uno');
			$(".corte1").val(values1.val().length);

			if ($('#trdos').is(':hidden')) {
				$("#trdos").remove();
			}
			else{
				var values2 = $('.select-dos');
				$(".corte2").val(values2.val().length);
			}

			if ($('#trtres').is(':hidden')) {
				$("#trtres").remove();
			}
			else{
				var values3 = $('.select-tres');
				$(".corte3").val(values3.val().length);
			}

			if ($('#trcuatro').is(':hidden')) {
				$("#trcuatro").remove();
			}
			else{
				var values4 = $('.select-cuatro');
				$(".corte4").val(values4.val().length);
			}

			if ($('#trcinco').is(':hidden')) {
				$("#trcinco").remove();
			}
			else{
				var values5 = $('.select-cinco');
				$(".corte5").val(values5.val().length);
			}
		});
	});

	//Función para habilitar card-box en venta protegida
	$("#protegida").change(function() {
		//Limpiamos inputs en caso de vener con info
		cleanTarjeta();
		if($('#protegida').is(':checked')){
			$("#referencia").val("0");
			$("#lblProtegida").removeClass('d-none');
			//Asignamos un valor por defecto al monto para jqueryValidation (no lo tomamos en back)
			$("#montoTU").val("0");
			$(".box-referencia").addClass('d-none');
			//Activamos y deshabilitamos datos que requerimos y no requerimos
			$("#box-card").removeClass('d-none');
			$("#tarjeta1").addClass('active');
			$("#tarjeta1").addClass('show');
			$("#tarjeta2").addClass('d-none');
			$("#tabtjt2").addClass('d-none');
			$(".box-monto").addClass('d-none');
			$(".box-msi").addClass('d-none');
		} else {
			$("#lblProtegida").addClass('d-none');
			//Habilitamos tarjeta 2
			$("#box-card").addClass('d-none');
			$("#tabtjt2").removeClass('d-none');
			$(".box-referencia").removeClass('d-none');
			$("#referencia").val("0");
		}
	});

	//Función para validar si es venta compartida o no
	$('#compartida').change(function() {
		if($('#compartida').is(':checked')){
			$('.box-compartida').removeClass('d-none');
		}
		else{
			$('.box-compartida').addClass('d-none');
			$('#enfermeras').prop('selectedIndex',0);
		}
	});

	//Función recurrente para validar onSubmit el formulario en v_Cliente
	$().ready(function(){
		$("#miform").validate({
			rules: {
				'nombre[]':{
					required: true,
				},
				'apellido_paterno[]':{
					required: true,
				},
				'apellido_materno[]':{
					required: true,
				},
				'correo[]':{
					required: true,
				},
				'telefono[]':{
					required: true,
					minlength: 14
				},
				'parcialidades':{
					required: true,
				},
				'tipoCobro':{
					required: ".tarRequired:checked"
				},
				'tipoCreDeb[]':{
					required: ".tarRequired:checked"
				},
				'montoT[]':{
					required: ".tarRequired:checked",
				},
				'cardNumber[]':{
					required: ".tarRequired:checked"
				},
				'mes[]':{
					required: ".tarRequired:checked",
					minlength: 2
				},
				'anio[]':{
					required: ".tarRequired:checked",
					minlength: 2
				},
				'referencia':{
					required: ".tarRequired:checked"
				},
				'nameInCard[]':{
					required: ".tarRequired:checked"
				},
				'tipoTarjeta[]':{
					required: ".tarRequired:checked"
				},
				'banco[]':{
					required: ".tarRequired:checked"
				},
				'efectivo':{
					required: ".efeRequired:checked",
					min: 1 + Number.MIN_VALUE
				},
				'enfermeras':{
					required: "#compartida:checked"
				},
			},
			// Se especifican los mensajes del error ante el required: true u otro atributo que se desee
			messages: {
				'nombre[]':{
					required : "Dato requerido"
				},
				'apellido_paterno[]':{
					required : "Dato requerido"
				},
				'apellido_materno[]':{
					required : "Dato requerido"
				},
				'correo[]':{
					required : "Dato requerido"
				},
				'telefono[]':{
					required : "Dato requerido",
					minlength: "Ingrese 14 dígitos"
				},
				'parcialidades':{
					required: "Seleccione el número de pagos"
				},
				'tipoCobro':{
					required: "Dato requerido"
				},
				'tipoCreDeb[]':{
					required: "Seleccione opción"
				},
				'montoT[]':{
					required: "Dato requerido",
				},
				'cardNumber[]':{
					required: "Dato requerido",
				},
				'mes[]':{
					required: "Dato requerido",
					minlength: "Formato MM"
				},
				'anio[]':{
					required: "Dato requerido",
					minlength: "Formato AA"
				},
				'referencia':{
					required: "Dato requerido",
				},
				'nameInCard[]':{
					required: "Dato requerido"
				},
				'tipoTarjeta[]':{
					required: "Dato requerido"
				},
				'banco[]':{
					required: "Dato requerido"
				},
				'efectivo':{
					required: "Ingrese un monto",
					min: "Ingrese un monto mayor a cero"
				},
				'enfermeras':{
					required: "Seleccione una opción"
				},
			},
			//Se evaluan las rules anteriores después se puede ejectur el submit de la form
			submitHandler: function(form) {
				$('#loader').removeClass('hidden');
				var data = new FormData( $(form)[0] );
				data.append('arrayTratamientos1', JSON.stringify(arrayTratamientos1));
                data.append('arrayTratamientos2', JSON.stringify(arrayTratamientos2));
                data.append('arrayTratamientos3', JSON.stringify(arrayTratamientos3));
                data.append('arrayTratamientos4', JSON.stringify(arrayTratamientos4));
                data.append('arrayTratamientos5', JSON.stringify(arrayTratamientos5));
				var tarjeta = 0;
				$.ajax({
					url: url2 + "Clientes/guardar_influencer",
					data: data,
					cache: false,
					contentType: false,
					processData: false,
					dataType: 'json',
					method: 'POST',
					type: 'POST',
					success: function(data){
						if( data.resultado ){
							$('#loader').addClass('hidden');
							disableFields();
							$("#id_titular").val(data.id_titular);
							$("#id_contrato").val(data.id_contrato);
							jQuery("#modalClientAdded").modal("show");
							disableFB();
							imprimirContrato();							
						}
						else{
							$('#loader').addClass('hidden');
							jQuery("#modal_fail").modal("show");
						}
					}
				});
			}
		})
	});

	function mayus(e) {
		e.value = e.value.toUpperCase();
	}

	function formatMoney( n ){
		var c = isNaN(c = Math.abs(c)) ? 2 : c,
			d = d == undefined ? "." : d,
			t = t == undefined ? "," : t,
			s = n < 0 ? "-" : "",
			i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
			j = (j = i.length) > 3 ? j % 3 : 0;

		return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	};

	$('#changeTipoTar2').change(function(){
		$('.box-msi2').removeClass('d-none');
		$("#msi2").empty();
		if ( $(this).val() == 2){

			$("#msi2").append('<option value="0" selected>NORMAL</option>');
		}
		else{
			$("#msi2").append('<option value="">Seleccione una opción</option>');
			$("#msi2").append('<option value="0">NORMAL</option>');
			$("#msi2").append('<option value="3">3</option>');
			$("#msi2").append('<option value="6">6</option>');
			$("#msi2").append('<option value="12">12</option>');
		}
	});

	$('#changeTipoTar1').change(function(){
		if($('#protegida').is(':checked')){
			$('.box-msi').addClass('d-none');
			$("#msi1").empty();
			$("#msi1").append('<option value="0" selected>NORMAL</option>');
		}
		else{
			$('.box-msi').removeClass('d-none');
			$("#msi1").empty();
			if ( $(this).val() == 2){
				$("#msi1").append('<option value="0" selected>NORMAL</option>');
			}
			else{
				$("#msi1").append('<option value="">Seleccione una opción</option>');
				$("#msi1").append('<option value="0">NORMAL</option>');
				$("#msi1").append('<option value="3">3</option>');
				$("#msi1").append('<option value="6">6</option>');
				$("#msi1").append('<option value="12">12</option>');
			}
		}
	});

	function activarBoton(){
		if($('#protegida').is(':checked') || $('#tp1').val() == 1 || $('#tp2').val() == 1){
			if($("#contrato_nameFile").val()!='' && $("#ine_nameFile").val()!='' && $("#cprosa_nameFile").val() !='' && $('#tarjeta_nameFile').val() != '')
				$('#btn-save-documents').removeClass('d-none');
		}
		else{
			if($("#contrato_nameFile").val()!='' && $("#ine_nameFile").val()!='')
				$('#btn-save-documents').removeClass('d-none');
		}
	}

	function deselectMulti(){
		jQuery('#formaPago').multiselect('deselect', ['1', '2']);
		$('#lblProtegida').addClass('d-none');
		$('#box-cash').addClass('d-none');
		$(".protegida").prop('checked', false);
		$('.protegida').prop("disabled", false);
		$('#box-card').addClass('d-none');
		cleanTarjeta();
	}

	//Función para limpiar inputs con información de la tarjeta en caso de venir llenos
	function cleanTarjeta(){
		if(parseInt($('#precioFinalC').val()) == parseInt($('#pagoCon').val())){
			$('#tp1').prop('selectedIndex',0);
			$('#tp2').prop('selectedIndex',0);
			$('#tp1').prop('disabled', true);
			$('#tp2').prop('disabled', true);
		}
		else{
			$('#tp1').prop('selectedIndex',1);
			$('#tp2').prop('selectedIndex',0);
			$('#tp1').prop('disabled', false);
			$('#tp2').prop('disabled', false);
		}
		$('#tipoCobro').prop('selectedIndex',0);
		$('#tipoCobro2').prop('selectedIndex',0);
		$('#changeTipoTar1').prop('selectedIndex',0);
		$('#changeTipoTar2').prop('selectedIndex',0);
		$('#montoTU').val('0.00');
		$('#montoTD').val('0.00');
		$('#msi1').prop('selectedIndex',0);
		$('#msi2').prop('selectedIndex',0);
		$('#cardNumber').val('');
		$('#cardNumber2').val('');
		$('#mes').val('');
		$('#mes2').val('');
		$('#anio').val('');
		$('#anio2').val('');
		$('#referencia').val('');
		$('#nameInCard').val('');
		$('#nameInCard2').val('');
		$('#tipoTarjeta').prop('selectedIndex',0);
		$('#tipoTarjeta2').prop('selectedIndex',0);
		$('#banco').prop('selectedIndex',0);
		$('#banco2').prop('selectedIndex',0);
	}

    $.post("<?=base_url()?>index.php/Home/get_total_dia/", function(data) {
        var total_hoy = 0;
    console.log("longitud: "+data.length);
    for( var i = 0; i<data.length; i++){
      total_hoy += parseFloat(data[i]['suma_hoy_cobros']);
    }
        // console.log(data.total_vendido_hoy);
        $('#venta_diaria').append(addCommas(total_hoy)+" MXN");
    },'json');

    //get_venta_semanal
    $.post("<?=base_url()?>index.php/Home/get_total_semana/", function(data) {
    var total_semana = 0;
    for( var i = 0; i<data.length; i++){
      total_semana += parseFloat(data[i]['suma_semana_cobros']);
    }

        $('#venta_semanal').append(addCommas(total_semana)+" MXN");
    },'json');

	function addCommas(nStr)
	{
		nStr += '';
		x = nStr.split('.');
		x1 = x[0];
		x2 = x.length > 1 ? '.' + x[1] : '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(x1)) {
			x1 = x1.replace(rgx, '$1' + ',' + '$2');
		}
		return x1 + x2;
	}
	  $('.header').click(function(){
   $(this).find('span').text(function(_, value){return value=='-'?'+':'-'});
    $(this).nextUntil('tr.header').slideToggle(100, function(){
    });
    /*$('.fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-up');*/
    });
  $(document).ready(function(){
  });
	$('#flechaDesplegar').click(function() {
        //$('#display_advance').toggle('1000');
    	$("i", this).toggleClass("fa-chevron-up fa-chevron-down");
    });

    function disableFB(){
    	for(var i=1; i < 2; i++){
			$('#cuerpo-completo' + i).attr('disabled', true);
			$('#cuerpo-completo' + i).removeClass('cuerpo-completo-btn');
			$('#cuerpo-completo' + i).addClass('cuerpo-completo-btn-disabled');
    	}
    }
	
	function phoneMask(e) {
		let arr = e.value.replace(/[^\dA-Z]/g, '').replace(/[\s-)(]/g, '').split('');
		if(arr.length >= 1) arr.splice(0, 0, '(');
		if(arr.length > 4) arr.splice(4, 0, ') ');
		if(arr.length > 8) arr.splice(8, 0, '-');
		e.value = arr.toString().replace(/[,]/g, '');
	}

	function unmaskMoney(str) {
        str = str.replace('$','');
        str = str.replace(',','');
        return str;
    }
</script>
</body>
</html>
