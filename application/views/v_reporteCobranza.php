<?php
require "header.php";
$page = 'detalleCobranza';
require "menu.php";
?>
<meta charset='utf-8'>
<link href="<?= base_url("assets/css/bootstrap-multiselect.css")?>" rel="stylesheet"/>

<link href="<?= base_url("assets/css/select2.min.css")?>" rel="stylesheet" />
<script src="<?= base_url("assets/js/bootstrap-multiselect.js")?>"></script>
<script src="<?= base_url("assets/js/select2.full.min.js")?>"></script>

<style>
  #tabla_clientes_filter{
    display: none;
  }
  #tabla_clientes_paginate{
    position: absolute;
    right: 0;
  }

  .btn-cir {
    border-radius: 50%;
    border-width: 1px; 
    border-style: solid; 
    margin-right:2px;
  } 
  .center{
    display:flex;
    justify-content:center;
    align-items:center;
  }
  .font-e{
    font-size:12px;
  }
  .pagar_quincena:hover{
    background-color: #c574bdc4;
  }
  #btnsubmit{
    background: #c7b1dd;
    color: white;
    border-radius: 20px;
    border: none;
    width: 300px;
  }
    .paginate_button a:focus{
        outline: none!important;
        border: none!important;
    }
    #table_pagos_filter{
      display: none;
    }
    #table_pagos_paginate{
      position: absolute;
      right: 0;
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
    table.dataTable.no-footer {
        border-bottom: 1px solid #111;
    }
    table.dataTable, table.dataTable th, table.dataTable td {
        box-sizing: content-box;
    }
    table.dataTable {
        width: 100%;
        margin: 0 auto;
        clear: both;
        border-collapse: separate;
        border-spacing: 0;
    }
    .table-bordered {
        border: 1px solid #e9ecef;
    }
    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 1rem;
        background-color: transparent;
    }
    .btn-circle {
        width: 30px;
        height: 30px;
        padding: 6px 0px;
        border-radius: 15px;
        text-align: center;
        font-size: 12px;
        line-height: 1.42857;
    }

    .btn-circle-bigger {
        width: 30px;
        height: 30px;
        padding: 6px 0px;
        border-radius: 15px;
        text-align: center;
        font-size: 12px;
        line-height: 1.42857;
    }
.round-button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    border-radius: 50%;
}

.btn-circle.btn-sm {
    width: 30px;
    height: 30px;
    padding: 6px 0px;
    border-radius: 15px;
    font-size: 8px;
    text-align: center;
    margin-top: 30px;
}
.btn-circle.btn-md {
    width: 40px;
    height: 40px;
    padding: 7px 10px;
    border-radius: 25px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.btn-circle.btn-xl {
    width: 70px;
    height: 70px;
    padding: 10px 16px;
    border-radius: 35px;
    font-size: 12px;
    text-align: center;
    margin-top: 30px;
}
.toolsBtn{
    border: 2px solid #888888;
    opacity: 0.8;
    color: #888888;

    text-align: center;
    width: 50px;
    height: 50px;
    padding: 7px 15px;
    border-radius: 25px;
    font-size: 18px;
}

#excelBtn:hover{
    border-color: #5cb85c;
    color:#5cb85c;
}

#excelBtn:hover p{
    color:#5cb85c;
}

#pdfBtn:hover{
    border-color:#d9534f;
    color:#d9534f;
}

#pdfBtn:hover p{
    color:#d9534f;
}

#printBtn:hover{
    border-color:#333;
    color:#333;
}

#printBtn:hover p{
    color:#333;
}
</style>

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
										<h4 class="card-title">Detalle cobranza</h4>
										<p class="card-category">Reportes de cobranza por contrato</p>
									</div>                  
									<div class="row">
										<div class="card-body">
											<div class="row">
												<div class="col-md-12 ">                        
													<select class="form-control myselect" id="selectCliente" name="selectCliente" required style="width:100%;" /></select>
												</div>												
											</div>
										</div>
									</div><!-- END Row -->   
                  <input name="total_pagarInput" id="total_pagarInput" type="hidden">
                  <input name="abonado_input" id="abonado_input" type="hidden">
                  <input name="saldopendiente_input" id="saldopendiente_input" type="hidden">
                  <input name="pago_cubrir_input" id="pago_cubrir_input" type="hidden">

                  <div class="box-estado-pagos d-none">
                    <div class="row pl-3 pr-3">
                      <div class="col-md-12">											
                        <div class="row" style="height:90px">
                          <div class="col-lg-3 col-md-2 col-sm-1 col-xs-6 col-xs-6 center" style="background-color: #c58cbf73;">	
                            <div>
                              <p class="m-0 font-e">TOTAL A PAGAR</p>
                              <div class="a_pagar" id="a_pagar"></div>	
                            </div>													                            													
                          </div>

                          <div class="col-lg-3 col-md-2 col-sm-1 col-xs-6 col-xs-6 center" style="background-color: #c574bd80;">  
                            <div>
                              <p class="m-0 font-e">ABONADO</p>
                              <div class="abono" id="abono"></div>	
                            </div>                                              													
                          </div>

                          <div class="col-lg-3 col-md-2 col-sm-1 col-xs-6 col-xs-6 center" style="background-color: #c58cbf73;">
                            <div>
                              <p class="m-0 font-e">SALDO PENDIENTE</p>
                              <div class="saldo" id="saldo"></div>
                            </div>                            														
                          </div>

                          <div class="col-lg-3 col-md-2 col-sm-1 col-xs-6 col-xs-6 center" style="background-color: #c574bd80;">
                            <div>
                              <p class="m-0 font-e text-center">PAGOS POR CUBRIR</p>
                              <div class="num_pagos" id="num_pagos"></div>	
                            </div>
                          </div>
                        </div><!-- END row -->
                      </div><!-- END col-md-12-->
                    </div><!-- END row -->
                    <div class="row">
                      <div class="col-md-12 "> 

                        <table id="table_pagos" class="table col-md-12 table-striped table-no-bordered table-hover" width="100%" style="text-align:center;width: 100%"><!--table table-bordered table-hover -->
                          <thead>
                            <tr>
                              <th class="disabled-sorting text-right"><center>Nombre</center></th>
                              <th class="disabled-sorting text-right"><center>Fecha Pago</center></th>
                              <th class="disabled-sorting text-right"><center>Cantidad ($)</center></th>
                              <th class="disabled-sorting text-right"><center>Estatus</center></th>
                              <th class="disabled-sorting text-right"><center>Fecha Pagado</center></th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                    </div>
                    <div class="row box-estado-1 pl-3 pr-3 mt-1">
                      <div class="col-md-12 d-flex m-0 justify-content-around align-items-center" style="background-color: #f7f7f7;">
                        <h5 class="text-center pt-3 pb-3 m-0" style="display: none;background-color: #f7f7f7; color:#333;">ESTADO DE PAGOS</h5>
                        <p id="btn-recurrente"class="d-none m-0 pr-2 pl-2" style="background:#f79f0591; border-radius:15px; font-size:14px">PAGOS RECURRENTES</p>
                        <p id="btn-completo"class="d-none m-0 pr-2 pl-2" style="background:#a8dda8; border-radius:15px; font-size:14px">PAGOS COMPLETOS</p>
                        <p id="btn-pu"class="d-none m-0 pr-2 pl-2" style="background:#a8dda8; border-radius:15px; font-size:14px">PAGOS REALIZADOS EN UNA EXHIBICIÓN</p>
                      </div><!-- END col-md-12 -->
                    </div><!-- END row -->
                    <div class="row box-estado-2 pl-3 pr-3 ">
                      <div class="col-md-12">
                        <div class="tabla_corrida" id="tabla_corrida"></div>                      
                      </div>
                      <div class="col-md-12 d-flex justify-content-center">
                        <div class="botones" id="botones"></div>
                      </div>
                    </div><!-- End row -->                    
                  </div><!-- End box-estado-pagos -->  
                  <br> 
                  <form  method="post" id="form_apply_payment">
                    <div class="box-parcialidades p-4 d-none" style="background-color:#f7f7f7">
                      <h4 class="text-center">COBRO DE PARCIALIDAD</h4>
                      <br>
                      <input type="text" name="id_contrato" id="id_contrato" hidden>
                      <input type="text" name="id_cliente" id="id_cliente" hidden>
                      <input type="text" name="string_cantidad" id="string_cantidad" hidden>
                      <div class="row">                      
                        <div class="col-sm-6">
                          <div class="box-check-pagos"></div>
                        </div>                      
                        <div class="col-sm-3 d-flex align-items-end">
                          <div class="form-group">
                            <label style="font-size:14px">A pagar:</label>
                            <input type="text" class="form-control" name="valor_acumulado" id="valor_acumulado" placeholder="" autocomplete="off" readonly>
                          </div>                          
                        </div>  
                        <div class="col-sm-3 d-flex align-items-end">
                          <div class="form-group box-formaPago d-none">
                            <label>Forma de pago <b>(anticipo)</b></label>                                            
                            <select id="formaPago" name="formaPago[]" class="form-control g-disabld" autocomplete="off" multiple="multiple" onchange="changePay(); changeEntrance(); changeAPagar();">
                              <option value='1' class="efeRequired">Efectivo</option>    
                              <option value='2' class="tarRequired">Tarjeta</option>         
                            </select>
                          </div>
                        </div>
                      </div><!-- End row -->
                      <br>
                      <div id="box-cash" class="d-none mb-1">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Efectivo</label>
                              <input type="text" class="form-control g-disabld" name="efectivo" id="efectivo" value="0.00" autocomplete="off" onkeypress="return onlyNumbers(event)" onkeyup="changeEntrance(); changeAPagar(); evalueEntranceE(this.value);">  
                            </div>
                          </div>
                        </div>
                      </div><!-- End box-cash -->
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
                              <div class="col-md-3">
                                <div class="form-group box-referencia">
                                  <label>Referencia:</label>
                                  <input type="text" class="form-control g-disabld" name="referencia[]" class="referencia" onkeypress="return onlyNumbers(event)" autocomplete="off">
                                </div>
                              </div>
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
                          </div> <!-- End tab-pane tarjeta 1-->
                          <div role="tabpanel" class="tab-pane fade .error" id="tarjeta2">
                            <div class="row mt-3">
                              <div class="col-sm-12">
                                <label><b>Datos tarjeta 2</b></label>
                              </div>
                            </div>
                            <div class="row mt-3">
                              <div class="col-md-3">
                                <div class="form-group box-referencia">
                                  <label>Referencia:</label>
                                  <input type="text" class="form-control g-disabld" name="referencia[]" class="referencia" onkeypress="return onlyNumbers(event)" autocomplete="off">
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="from-group colCreDeb">
                                  <label>Tipo de tarjeta</label>
                                  <select name="tipoCreDeb[]" id="changeTipoTar2" class="form-control g-disabld">
                                    <option value="">Seleccione opción</option>
                                    <option value="1">Crédito</option>
                                    <option value="2">Débito</option>
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
                                  <select id="msi2" name="msi[]" class="form-control g-disabld"></select>
                                </div>
                              </div>
                            </div><!-- End row -->                                                
                          </div> <!-- End tab-pane tarjeta 2-->
                        </div> <!-- End tab-content general tarjetas-->                        
                      </div> <!-- End div box-card-->        
                      <hr>
                      <div class="box-detalle-fin d-none">
                        <div class="row d-flex justify-content-end">                              
                          <div class="col-sm-7">
                            <div class="row">
                              <div class="col-sm-10 text-right">
                                <p>A pagar:</p>
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
                      </div><!-- End box-detalle-fin -->               
                      <br>
                      <div class="row">
                        <div class="col-md-12">
                          <center><button id="btnsubmit" type="submit" class="btn" disabled>Finalizar venta</button></center>
                        </div>
                      </div> <!-- End row submit button -->
                    </div><!-- End box-pacialidades -->
                  </form><!-- End form -->
                  <br>               
								</div> <!-- End card-body-->
							</div> <!-- End div calss="" -->
						</div> <!-- End box-header with-border -->
					</div> <!-- End tab content box-body -->
				</div> <!--End tab box-->
			</div> <!-- end col -->
		</div> <!-- End row -->
	</div> <!-- End container-fluid -->
</div> <!-- End content -->
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

<div id="modalPagoMenor" class="modal fade" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body pago-menor">
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<div id="Modal_data_expediente" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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

<div id="myModal_respuesta_pago" class="modal fade" aria-hidden="false" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div><center><img src='<?= base_url("assets/img/success.png")?>' style='width:120px; height: 120px'></center></div>
                <center><label>Cobro realizado con éxito</label></center> 
                <center><button type="button" class="btn" data-dismiss="modal" onClick="reloadPage();">Finalizar</button></center>                
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
<style>
/*Estilos para los mensajes de error de plugin jQuery Validation*/
.error {
    display:flex;
    /* color: #e74c3c!important; */
}
.has-error{
    color: #e74c3c!important;
}
</style>
<!-- Estilos para Spinner-->

<!-- <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
<script src="https://printjs-4de6.kxcdn.com/print.min.css"></script> -->
<script src="<?= base_url("assets/js/jquery.datatables.js")?>"></script>

<script src="https://kit.fontawesome.com/96ef2da2e9.js" crossorigin="anonymous"></script>
<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>


<script>
  $(document).ready(function(){
    $('#formaPago').multiselect({
      nonSelectedText:'Seleccione una opción'
    });

    $('#efectivo').on('click focusin', function() {
      this.value = '';
    });

    $('#efectivo').focusout(function(){
        if($('#efectivo').val()!= '')
          jQuery("#modalEfectivo").modal("show");
    });

    $('#montoTU').on('click focusin', function() {
        this.value = '';
    });

    $('#montoTD').on('click focusin', function() {
        this.value = '';
    });  
  });

  $(".myselect").select2();
  $("#selectCliente").ready(function(){    
    $("#selectCliente").append('<option value="">Seleccione un cliente</option>');
    $.getJSON( url2 + "Clientes/lista_clientes_cobranza").done( function( data ){
      $.each( data, function(i, v){
        $("#selectCliente").append('<option value="'+v.id_contrato+'" data-value="'+v.estatus+'" data-cliente="'+v.id_cliente+'">'+v.nombre+ '&nbsp;&nbsp;&#8226;&nbsp;&nbsp;(No. contrato '+ v.id_contrato+')</option>');
      });
    });
  });

  $("#selectCliente").change(function(){    
    var id_contrato = $('#selectCliente').val();
    $("#id_contrato").val(id_contrato);
    var estatus_contrato = $("#selectCliente option:selected").attr("data-value");
    var id_cliente = $("#selectCliente option:selected").attr("data-cliente");
    $("#id_cliente").val(id_cliente);
    var engancheT = 0;
    var pendiente = 0;
    var importePagado = 0;
    var pagosR = 0;
    var pagosT = 0;
    $(".pagar_quincena").removeClass();
    $(".box-parcialidades").addClass("d-none");
    if($("#selectCliente option:selected").val() != ''){
  
      $(".box-estado-pagos").removeClass("d-none");
      $("#tabla_corrida").html("");
      $("#total").html("");
      $("#abono").html("");
      $("#saldo").html("");
      $("#num_pagos").html("");
      $("#botones").html("");
      $("#a_pagar").html("");
    
      if (estatus_contrato == 3){
        $.getJSON(url2 + "Cobranza/pago_una_exhibicion/"+id_contrato).done(function( data ){
          $.each(data, function(i, v){            
              engancheT =+ v.enganche;              
          });
          
          if(engancheT == data[0].cantidad){       
            $("#btn-recurrente").addClass("d-none");     
            $("#btn-completo").addClass("d-none");   
            $("#btn-pu").removeClass("d-none");   
            
            pendiente = data[0].cantidad - engancheT;            
            $("#a_pagar").append('<p style="text-align:center; margin:0; font-size:14px"><b>$ '+formatMoney(data[0].cantidad)+'</b></p>');
            $("#abono").append('<p style="text-align:center; margin:0; font-size:14px"><b>$ '+formatMoney(engancheT)+'</b></p>');
            $("#saldo").append('<p style="text-align:center; margin:0; font-size:14px"><b>$ '+formatMoney(pendiente)+'</b></p>');
            $("#num_pagos").append('<p style="text-align:center; margin:0; font-size:14px"><b>0 / 0</b></p>');

          }
          else
          {
            $("#btn-recurrente").addClass("d-none");     
            $("#btn-completo").addClass("d-none");   
            $("#btn-pu").addClass("d-none");   
          }
        });
      }
        $.getJSON(url2 + "Cobranza/plan_cliente_enganche/"+id_contrato).done(function( dataM ){
          $("#tabla_corrida").append('<div class="col-lg-12">');
          if (dataM != ''){          
            $.each(dataM, function(i, v){
              if(v.estatus == '1') importePagado = parseInt(importePagado) + parseInt(v.importe);              
              else pagosR++;       
              pagosT++;
            });
            abonoT = parseInt(dataM[0].total_enganche) + parseInt(importePagado);
            pendiente = dataM[0].cantidad - abonoT;
            $("#a_pagar").append('<p style="text-align:center; margin:0; font-size:14px"><b>$ '+formatMoney(dataM[0].cantidad)+'</b></p>');
            $("#abono").append('<p style="text-align:center; margin:0; font-size:14px"><b>$ '+formatMoney(abonoT)+'</b></p>');
            $("#saldo").append('<p style="text-align:center; margin:0; font-size:14px"><b>$ '+formatMoney(pendiente)+'</b></p>');
            $("#num_pagos").append('<p style="text-align:center; margin:0; font-size:14px"><b>'+pagosR+' / '+pagosT+'</b></p>');

            $('#total_pagarInput').val(formatMoney(dataM[0].cantidad));
            $('#abonado_input').val(formatMoney(abonoT));
            $('#saldopendiente_input').val(formatMoney(pendiente));
            $('#pago_cubrir_input').val(pagosR+' / '+pagosT);
            updateTablePagos(id_contrato)
          }        
        });

        updateTablePagos(id_contrato)
        //chacha




      /*$.getJSON(url2 + "Cobranza/plan_cliente_enganche/"+id_contrato).done(function( dataM ){
        $("#tabla_corrida").append('<div class="col-lg-12">');
        
        //Función para traer las quincenas del contrato seleccionado
        $.getJSON(url2 + "Cobranza/plan_cliente/"+id_contrato).done(function( data ){
          console.log(data);
          
          $.each(data, function(i, v){
            var dd = new Date();            
            var year = dd.getFullYear();
            var month = dd.getMonth()+1;
            if(month <= 9)  month = '0'+month;
            var date = dd.getDate();
            if(date <= 9) date = "0"+date;            
            var allDate = year + "-" + month + "-" + date;
            var fechaHoy=  allDate + " 23:59:99.999";
            var fecha = new Date(v.fecha_pago);
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            if(v.fecha_pago<fechaHoy){//FECHA VENCIDA          
              if(v.estatus==0){
                $("#tabla_corrida").append('<div class="row d-flex align-items-center pt-2 pb-2" style="color:#F79F05;"><div class="col-lg-1 text-center"><label class="m-0" style="font-size:10px;">'+(i+1)+'</label></div><div class="col-lg-6"><label class="m-0" style="font-size:12px;">'+v.nom_completo+'<label></div><div class="col-lg-2"><label class="m-0" style="font-size:12px;">'+(fecha.toLocaleDateString('es-ES', options))+'</label></div><div class="col-lg-2"><label style="font-size:12px;">$'+formatMoney(v.importe)+'</label></div><div class="col-lg-1"><i class="fa fa-exclamation-triangle"></i></div></div><hr class="m-0">');
              }
              else if(v.estatus==1){//ESTATUS 1
                $("#tabla_corrida").append('<div class="row d-flex align-items-center pt-2 pb-2" style="color:#2AAC00;"><div class="col-lg-1 text-center"><b><label class="m-0" style="font-size:10px;">'+(i+1)+'</label></b></div><div class="col-lg-6"><label class="m-0" style="font-size:12px;"><b>'+v.nom_completo+'</b><label></div><div class="col-lg-2"><b><label class="m-0" style="font-size:12px;">'+(fecha.toLocaleDateString('es-ES', options))+'</label></b></div><div class="col-lg-2"><label style="font-size:12px;"><b>$'+formatMoney(v.importe)+'</b></label></div><div class="col-lg-1"><i class="fa fa-check" ></i></div></div><hr class="m-0">');
              }
            }
            else{//FECHA NO VENCIDA
              if(v.estatus==0){//ESTATUS 0
                $("#tabla_corrida").append('<div class="row d-flex align-items-center pt-2 pb-2" style="color:#868686;"><div class="col-lg-1 text-center"><label class="m-0" style="font-size:10px;">'+(i+1)+'</label></div><div class="col-lg-6"><label class="m-0" style="font-size:12px;">'+v.nom_completo+'<label></div><div class="col-lg-2"><label class="m-0" style="font-size:12px;">'+(fecha.toLocaleDateString('es-ES', options))+'</label></div><div class="col-lg-2"><label style="font-size:12px;">$'+formatMoney(v.importe)+'</label></div><div class="col-lg-1"><i class="fa fa-clock"></i></div></div><hr class="m-0">');
              }
              else if(v.estatus==1){//ESTATUS 1
                $("#tabla_corrida").append('<div class="row d-flex align-items-center pt-2 pb-2" style="color:#2AAC00;"><div class="col-lg-1 text-center"><b><label class="m-0" style="font-size:10px;">'+(i+1)+'</label></b></div><div class="col-lg-6"><label class="m-0" style="font-size:12px;"><b>'+v.nom_completo+'</b><label></div><div class="col-lg-2"><b><label class="m-0" style="font-size:12px;">'+(fecha.toLocaleDateString('es-ES', options))+'</label></b></div><div class="col-lg-2"><label style="font-size:12px;"><b>$'+formatMoney(v.importe)+'</b></label></div><div class="col-lg-1"><i class="fa fa-check" ></i></div></div><hr class="m-0">');
              }
            }//FIN FECHA VENCIDA
          });
        });

        if (dataM != ''){          
          $.each(dataM, function(i, v){
            if(v.estatus == '1') importePagado = parseInt(importePagado) + parseInt(v.importe);              
            else pagosR++;       
            pagosT++;
          });
          abonoT = parseInt(dataM[0].total_enganche) + parseInt(importePagado);
          pendiente = dataM[0].cantidad - abonoT;
          $("#a_pagar").append('<p style="text-align:center; margin:0; font-size:14px"><b>$ '+formatMoney(dataM[0].cantidad)+'</b></p>');
          $("#abono").append('<p style="text-align:center; margin:0; font-size:14px"><b>$ '+formatMoney(abonoT)+'</b></p>');
          $("#saldo").append('<p style="text-align:center; margin:0; font-size:14px"><b>$ '+formatMoney(pendiente)+'</b></p>');
          $("#num_pagos").append('<p style="text-align:center; margin:0; font-size:14px"><b>'+pagosR+' / '+pagosT+'</b></p>');
          
          if(pendiente == 0){
            $("#btn-recurrente").addClass("d-none");     
            $("#btn-completo").removeClass("d-none");   
            $("#btn-pu").addClass("d-none");   
          }
          else{
            if(dataM[0].prosa == 1){
              $("#btn-recurrente").removeClass("d-none");     
              $("#btn-completo").addClass("d-none");   
              $("#btn-pu").addClass("d-none");  
            } 
            $("#botones").append('<br><button class="btn pagar_quincena" value="'+dataM[0].id_cobro+'"" style="border:none; color: #333; background-color: #c574bd80; padding: 5px 60px; border-radius:20px">PAGAR</button>');
          }
        }        
      });*/  
    }
    else{
      $(".box-estado-pagos").addClass('d-none'); 
    }
  });
           
  $(document).on("click", ".pagar_quincena", function(){
    event.preventDefault();
    jQuery.noConflict();
    $(".pagar_quincena").addClass("d-none");
    $(".box-parcialidades").removeClass("d-none");
    $(".box-check-pagos").html("");

    var id_contrato = $('#selectCliente').val();
    $.getJSON(url2 + "Cobranza/plan_pagar/"+id_contrato).done(function( data ){
      $.each( data, function(i, v){
        var fecha = new Date(v.fecha_pago);
        const options = { year: 'numeric', month: 'short', day: 'numeric' };

        $(".box-check-pagos").append('<div class="row div_mensualidades"><div class="col-lg-2"><input type="checkbox" class="pago_quincena" name="pago_quincena[]" value="'+v.id_quincena+'" data-value="'+v.importe+'" onchange="evaluarChecked();"></div><div class="col-lg-6"><label>'+(fecha.toLocaleDateString('es-ES', options))+'</label></div><div class="col-lg-4"><label><center>$ '+formatMoney(v.importe)+'</center></label><input type="text" name="fecha_quincena[]" value="'+(fecha.toLocaleDateString('es-ES', options))+'" hidden><input type="text" name="importe_quincena[]" value="'+formatMoney(v.importe)+'" hidden></div></div>');
      });
    });
  });
 
  function changePay(){
    var formas = 0;
    cleanTarjeta();
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
      }
      formas++;
    });

    if(formas==0) $(".box-detalle-fin").addClass('d-none');
    else $(".box-detalle-fin").removeClass('d-none');
  }

  //Función para limpiar inputs con información de la tarjeta en caso de venir llenos
  function cleanTarjeta(){
    $('#tipoCobro').prop('selectedIndex',0);
    $('#tipoCobro2').prop('selectedIndex',0);
    $('#changeTipoTar1').prop('selectedIndex',0);
    $('#changeTipoTar2').prop('selectedIndex',0);
    $('#montoTU').val('0.00');
    $('#montoTD').val('0.00');
    $('#msi1').prop('selectedIndex',0);
    $('#msi2').prop('selectedIndex',0);
    $('.referencia').val('0');
  }
 
  function formatMoney( n ){
    var c = isNaN(c = Math.abs(c)) ? 2 : c,
      d = d == undefined ? "." : d,
      t = t == undefined ? "," : t,
      s = n < 0 ? "-" : "",
      i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
      j = (j = i.length) > 3 ? j % 3 : 0;

    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
  }
 
  $(document).on("click", '[name="pago_quincena[]"]', function(){
    $("#valor_acumulado").html("");
    $("#string_cantidad").html("");
    $("#aPagar").html("");
    $("#valor_recibi").val("");
    $("#valor_cambio").val("");
    $("#monto_gral").val("");
    $("#cant_pagos_add").val("");

  
    var arr2 = $('[name="pago_quincena[]"]:checked').map(function(){
      return $(this).attr("data-value");
    }).get();

    var cant_array = arr2.length;
    suma = 0;
    for(i = 0; i < arr2.length; i++){
      suma = (suma + parseInt(arr2[i]));
    }

    $("#cant_pagos_add").val(cant_array);
    $("#monto_gral").val(suma);
    $("#valor_acumulado").val(suma);    
    $("#aPagar").val(suma);
    var stringCantidad = NumeroALetras(suma);
    $("#string_cantidad").val(stringCantidad);
  });
 
  //Función recurrente para validar onSubmit el formulario en v_Cliente
  $().ready(function(){
    $("#form_apply_payment").validate({
      rules: {         
          'tipoCreDeb[]':{
              required: ".tarRequired:checked"
          },
          'montoT[]':{
              required: ".tarRequired:checked",
          },
          'referencia':{
              required: ".tarRequired:checked"
          },   
          'efectivo':{
              required: ".efeRequired:checked",
              min: 1 + Number.MIN_VALUE
          },
      },
      // Se especifican los mensajes del error ante el required: true u otro atributo que se desee
      messages: { 
          'tipoCreDeb[]':{
              required: "Seleccione opción"
          },
          'montoT[]':{
              required: "Dato requerido",
          },
          'referencia':{
              required: "Dato requerido",
          },  
          'efectivo':{
              required: "Ingrese un monto",
              min: "Ingrese un monto mayor a cero"
          },
      },
      //Se evaluan las rules anteriores después se puede ejectur el submit de la form
      submitHandler: function(form){
        $('#loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        $.ajax({
          url: url2 + "Cobranza/guardar_pagos",
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          method: 'POST',
          type: 'POST',
          success: function(data){ 
            console.log(data);           
            if(data.success==1){  
              $('#loader').addClass('hidden');
              jQuery("#myModal_respuesta_pago").modal({backdrop: 'static', keyboard: false})   
              imprimir(data);
            }
            else{
              jQuery("#modal_fail").modal("show");
            }
          },error: function( ){
            jQuery("#modal_fail").modal("show");
          }
        })
      }
    })
  });

  function changeEntrance(){    
    if( (parseInt($('#efectivo').val()) + parseInt($('#montoTU').val()) + parseInt($('#montoTD').val())) < parseInt($('#aPagar').val()) )
        $('#btnsubmit').prop('disabled', true);
    else $('#btnsubmit').prop('disabled', false);

    changeAPagar();
    $("#entrada").val(parseInt($('#efectivo').val()) + parseInt($('#montoTU').val()) + parseInt($('#montoTD').val()));
  }

  function evalueEntranceE(e){
    if(parseInt(e) + parseInt($('#montoTU').val()) + parseInt($('#montoTD').val()) > parseInt($('#valor_acumulado').val())){
      $(".pago-menor-div").remove();
      $(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El monto ingresado es mayor al anticipo</b></label></center> <center><button type="button" class="btn" data-dismiss="modal">Aceptar</button></center></div>');
      jQuery("#modalPagoMenor").modal("show");
      $("#efectivo").val('');
    }
  }

  function evalueEntranceTU(e){
    if(parseInt(e) + parseInt($('#efectivo').val()) + parseInt($('#montoTD').val()) > parseInt($('#valor_acumulado').val())){
      $(".pago-menor-div").remove();
      $(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El monto ingresado es mayor al anticipo</b></label></center> <center><button type="button" class="btn" data-dismiss="modal">Aceptar</button></center></div>');
      jQuery("#modalPagoMenor").modal("show");
      $("#montoTU").val('');
    }
  }

  function evalueEntranceTD(e){
    if(parseInt(e) + parseInt($('#efectivo').val()) + parseInt($('#montoTU').val()) > parseInt($('#valor_acumulado').val())){
      $(".pago-menor-div").remove();
      $(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El monto ingresado es mayor al anticipo</b></label></center> <center><button type="button" class="btn" data-dismiss="modal">Aceptar</button></center></div>');
      jQuery("#modalPagoMenor").modal("show");
      $("#montoTD").val('');
    }
  }

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
  });

  function changeAPagar(){
    $('#aPagar').val($('#valor_acumulado').val());
  }

  function evaluarChecked(){    
    if($('.box-check-pagos input:checked').length == 0){
      deselectMulti();
      $('.box-formaPago').addClass('d-none');
      $('#btnsubmit').hide();
    } 
    else{
      $('#btnsubmit').show();
      $('.box-formaPago').removeClass('d-none');
    }
  }

  function deselectMulti(){        
    jQuery('#formaPago').multiselect('deselect', ['1', '2']);
    $('#box-cash').addClass('d-none');        
    $('#box-card').addClass('d-none'); 
    cleanTarjeta();
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

  function reloadPage(){
    location.reload();
  }

  //Funciones para conversor de número a letras
  function Unidades(num){
    switch(num){
      case 1: return "UN";
      case 2: return "DOS";
      case 3: return "TRES";
      case 4: return "CUATRO";
      case 5: return "CINCO";
      case 6: return "SEIS";
      case 7: return "SIETE";
      case 8: return "OCHO";
      case 9: return "NUEVE";
    }
    return "";
  }

  function Decenas(num){
    decena = Math.floor(num/10);
    unidad = num - (decena * 10);

    switch(decena){
      case 1:
        switch(unidad){
          case 0: return "DIEZ";
          case 1: return "ONCE";
          case 2: return "DOCE";
          case 3: return "TRECE";
          case 4: return "CATORCE";
          case 5: return "QUINCE";
          default: return "DIECI" + Unidades(unidad);
        }
      case 2:
        switch(unidad){
          case 0: return "VEINTE";
          default: return "VEINTI" + Unidades(unidad);
        }
      case 3: return DecenasY("TREINTA", unidad);
      case 4: return DecenasY("CUARENTA", unidad);
      case 5: return DecenasY("CINCUENTA", unidad);
      case 6: return DecenasY("SESENTA", unidad);
      case 7: return DecenasY("SETENTA", unidad);
      case 8: return DecenasY("OCHENTA", unidad);
      case 9: return DecenasY("NOVENTA", unidad);
      case 0: return Unidades(unidad);
    }
  }//Unidades()

  function DecenasY(strSin, numUnidades){
    if (numUnidades > 0)
      return strSin + " Y " + Unidades(numUnidades)

    return strSin;
  }//DecenasY()

  function Centenas(num){
    centenas = Math.floor(num / 100);
    decenas = num - (centenas * 100);

    switch(centenas){
      case 1:
        if (decenas > 0)
          return "CIENTO " + Decenas(decenas);
        return "CIEN";
      case 2: return "DOSCIENTOS " + Decenas(decenas);
      case 3: return "TRESCIENTOS " + Decenas(decenas);
      case 4: return "CUATROCIENTOS " + Decenas(decenas);
      case 5: return "QUINIENTOS " + Decenas(decenas);
      case 6: return "SEISCIENTOS " + Decenas(decenas);
      case 7: return "SETECIENTOS " + Decenas(decenas);
      case 8: return "OCHOCIENTOS " + Decenas(decenas);
      case 9: return "NOVECIENTOS " + Decenas(decenas);
    }

    return Decenas(decenas);
  }//Centenas()

  function Seccion(num, divisor, strSingular, strPlural){
    cientos = Math.floor(num / divisor)
    resto = num - (cientos * divisor)

    letras = "";
    if (cientos > 0)
      if (cientos > 1) letras = Centenas(cientos) + " " + strPlural;
      else letras = strSingular;

    if (resto > 0) letras += "";

    return letras;
  }//Seccion()

  function Miles(num){
    divisor = 1000;
    cientos = Math.floor(num / divisor)
    resto = num - (cientos * divisor)

    strMiles = Seccion(num, divisor, "MIL", "MIL");
    strCentenas = Centenas(resto);

    if(strMiles == "") return strCentenas;

    return strMiles + " " + strCentenas;
  //return Seccion(num, divisor, "UN MIL", "MIL") + " " + Centenas(resto);
  }//Miles()

  function Millones(num){
    divisor = 1000000;
    cientos = Math.floor(num / divisor)
    resto = num - (cientos * divisor)

    strMillones = Seccion(num, divisor, "UN MILLON", "MILLONES");
    strMiles = Miles(resto);

    if(strMillones == "") return strMiles;

    return strMillones + " " + strMiles;

    //return Seccion(num, divisor, "UN MILLON", "MILLONES") + " " + Miles(resto);
  }//Millones()

  function NumeroALetras(num,centavos){
    var data = {
      numero: num,
      enteros: Math.floor(num),
      centavos: (((Math.round(num * 100)) - (Math.floor(num) * 100))),
      letrasCentavos: "",
    };
    if(centavos == undefined || centavos==false) {
      data.letrasMonedaPlural="PESOS";
      data.letrasMonedaSingular="PESO";
    }else{
      data.letrasMonedaPlural="CENTIMOS";
      data.letrasMonedaSingular="CENTIMO";
    }

    if (data.centavos > 0)
      data.letrasCentavos = "CON " + NumeroALetras(data.centavos,true);

    if(data.enteros == 0)
      return "CERO " + data.letrasMonedaPlural + " " + data.letrasCentavos;
    if (data.enteros == 1)
      return Millones(data.enteros) + " " + data.letrasMonedaSingular + " " + data.letrasCentavos;
    else
      return Millones(data.enteros) + " " + data.letrasMonedaPlural + " " + data.letrasCentavos;
  }//NumeroALetras()
  
  function imprimir(data){
    var date = new Date();    
    console.log(data['pagos'].length);
    var options = { year: 'numeric', month: 'numeric', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric'};
    var mywindow = window.open('', 'my div', 'height=750,width=720');
    var elementoG = '';
    var elementoU = '';
    var elementoD = '';
    elementoG += '<html><head></head><body style="text-align:center;font-family: Arial, Helvetica, sans-serif; font-size:12px"><img id="myImage" src="https://bodyeffect.gphsis.com/assets/img/logo.png" alt="logo" width="100%" />';
    elementoG += '<p>Plaza Midtown Jalisco, Local 53-A planta alta, Italia Providencia Guadalajara, Jal.<br>Teléfono: (332) 310 59 07<br>'+date.toLocaleDateString("es-ES", options)+'<p>';
    elementoG += '';
    elementoG += '<p>FOLIO: '+data['numero_ticket']+' <br>REFERENCIA: '+data['referencias']+' <br>Recibi de: <br>'+data['nombre_cliente']+'</p>';
    elementoG += '<p>La cantidad de: <br><b>'+data['string_cantidad']+' 0/0 CENTAVOS M.N</b></p>';
    elementoG += '<p>Forma de pago: <br><b>'+data['forma_pago']+'</b></p>';
    elementoG += '<p>Pago de servicios<br>';
    for( n=0;n<data['pagos'].length;n++ ){
      sum = n +1;
      elementoG += sum+' pago  '+data['pagos'][n]+'<br>';
    }
    elementoG += '</p><br>';
    elementoG += '<p style="text-align:right!important"><b>SUBTOTAL:</b> $'+formatMoney(data['monto_pago'])+'<br>';
    elementoG += '<b>IVA:</b> $0.00<br>';
    elementoG += '<b>TOTAL:</b> $'+formatMoney(data['monto_pago'])+'<br>';
    elementoG += '<p style="font-size:12px!important">¡En Body Effect queremos lo mejor para ti!<br>Si requiere factura favor de solicitarla al momento o bien proporcionar sus datos fiscales al siguiente correo electrónico <b>facturacion@bodyeffect.com.mx</b> en un tiempo no mayor a 72 horas se le hará llegar su comprobante<br><br><br></p>';
    elementoU = '<p><i>(copia cliente)</i></p><hr><br>';
    elementoD = '<p><i>(copia administrador)</i></p><br><br><br><hr><br><br>';
    elementoG = elementoG + elementoU + elementoG + elementoD + '</body></html>';
    mywindow.document.write(elementoG);
      
      $(mywindow).ready(function() {  
      // Call Later In Stack - really should be onload events or base64 images inline
      setTimeout(
        function(){
          mywindow.document.write('</body></html>');
          mywindow.document.close(); // necessary for IE >= 10
          mywindow.focus(); // necessary for IE >= 10
          mywindow.print();
          mywindow.close();
        },(1000));
    });
  }


  function updateTablePagos(id_contrato)
  {
        table = $('#table_pagos').DataTable( {
          width:"100%",
          destroy:true,
          dom: 'Bfrtip',
          paging: false,
          info : true,
          pagingType: "full_numbers",
          autoWidth: false,
          searching: false,
          pageLength: 10,
          language: {
            url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
          },
          buttons: [
          {
            extend: 'print',
            text: '<i class="fas fa-print mr-2"></i>',
            attr: {
              id: 'printBtn',
              class: 'toolsBtn',
              style: 'border-color: #212F3D; color: #212F3D; background-color: #FFFFFF; margin-bottom: 10px;',
              title: 'Imprimir'
            },
            orientation: 'LEGAL',
            messageTop: 'Total a pagar: ' + $('#total_pagarInput').val() + ' |  Abonado: ' + $('#abonado_input').val() + ' | Saldo pendiente: ' + $('#saldopendiente_input').val() + ' | Pagos por cubrir: ' + $('#pago_cubrir_input').val()
          },
          {
            extend : 'pdfHtml5',
            text: '<i class="fas fa-file-pdf mr-2"></i>',
            attr: {
              id: 'pdfBtn',
              class: 'toolsBtn',
              style: 'border-color: #d9534f; color: #d9534f; background-color: #FFFFFF; margin-bottom: 10px;',
              title: 'Descargar archivo .pdf'
            },
            orientation: 'LEGAL',
            messageTop: 'Total a pagar: ' + $('#total_pagarInput').val() + ' |  Abonado: ' + $('#abonado_input').val() + ' | Saldo pendiente: ' + $('#saldopendiente_input').val() + ' | Pagos por cubrir: ' + $('#pago_cubrir_input').val()

          },
          {
            extend: 'excel',
            text: '<i class="fas fa-file-excel mr-2"></i>',
            attr: {
              id: 'excelBtn',
              class: 'toolsBtn',
              style: 'border-color: #27AE60; color: #27AE60; background-color: #FFFFFF; margin-bottom: 10px;',
              title: 'Descargar archivo .xlsx'
            },
            messageTop: 'Total a pagar: ' + $('#total_pagarInput').val() + ' |  Abonado: ' + $('#abonado_input').val() + ' | Saldo pendiente: ' + $('#saldopendiente_input').val() + ' | Pagos por cubrir: ' + $('#pago_cubrir_input').val()
          }
          ],
          "pageLength": 10,
          "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
          },
          columns: [
            { "data": "nom_completo" },
            { 
              "data": function( d ){

                var dd = new Date();            
                var year = dd.getFullYear();
                var month = dd.getMonth()+1;
                if(month <= 9)  month = '0'+month;
                var date = dd.getDate();
                if(date <= 9) date = "0"+date;            
                var allDate = year + "-" + month + "-" + date;
                var fechaHoy=  allDate + " 23:59:99.999";
                var fecha = new Date(d.fecha_pago);
                const options = { year: 'numeric', month: 'short', day: 'numeric' };

                var fecha_final = fecha.toLocaleDateString('es-ES', options);
                return fecha_final;
              }
            },
            { 
              //"data": "importe"
              "data": function( d ){
                return "$ " + formatMoney(d.importe);
              }
            },
            { 
              "data": function(d){
                var estatus_label;
                if(d.estatus == 1)
                {
                  estatus_label = '<center><label style="background-color:#28a745;border-radius: 4px;padding: 5px;color: white;font-size: 0.6em;width: 80px;">PAGADO</label></center>';
                }
                else
                {
                  estatus_label = '<center><label style="background-color:#909090;border-radius: 4px;padding: 5px;color: white;font-size: 0.6em;width: 80px;">NO PAGADO</label></center>';
                }
                return estatus_label;
              }
            },
            {
              "data": function(d){
                var label_pago_realizado;
                if(d.pago_realizado == null || d.pago_realizado=='')
                {
                    label_pago_realizado = '<label style="background-color:#909090;border-radius: 4px;padding: 5px;color: white;font-size: 0.6em;width: 80px;">N/A</label>';
                }
                else
                {
                    label_pago_realizado = '<label style="background-color:#28a745;border-radius: 4px;padding: 5px;color: white;font-size: 0.6em;width: 80px;">'+d.pago_realizado+'</label>';
                }
                return "<center>"+label_pago_realizado+"</center>";
              }
            }
          ],
          "ajax": {
            "url": "<?=base_url()?>index.php/Cobranza/plan_cliente/"+id_contrato,
            "type": "POST",
            "dataSrc": "",
            cache: false,
            "data": function( d ){
            },

          },
        });
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
</script>
</html>