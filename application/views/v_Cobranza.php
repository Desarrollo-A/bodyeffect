<?php
require "header.php";
$page = "cobranza";
require "menu.php";
?>
<meta charset='utf-8'>
<link href="<?= base_url("assets/css/bootstrap-multiselect.css")?>" rel="stylesheet"/>
<link href="<?= base_url("assets/css/select2.min.css")?>" rel="stylesheet" />
<script src="<?= base_url("assets/js/bootstrap-multiselect.js")?>"></script>
<script src="<?= base_url("assets/js/select2.full.min.js")?>"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url("assets/js/general.js")?>"></script> <!-- TIENE LAS FUNCIONES PARA RE IMPRIMIR EL TK (PARA LAS VISTAS QUE NO CARGAN EL FOOTER-->
<link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet"/>

<style>
  body {
    /* magic is here */
    overflow: hidden;
  }
  .sidebar,
  .main-panel {
      overflow: hidden !important;
    
  }
  .box-estado-pagos{
      overflow-x: hidden;
      overflow-y: auto;
      height: 420px;
  }
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
  .modal.show .modal-dialog-e{
		-webkit-transform: translate(0, 0);
		transform: translate(0, 0);
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
                    <h4 class="card-title">Cobranza Body Effect</h4>
                    <p class="card-category">En este apartado podrás realizar cobros a los clientes, liquidar cuentas y ver el historial de pago de cada cliente.</p>
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
                          <div class="col-lg-2 col-md-2 col-sm-1 col-xs-6 col-xs-6 center" style="background-color: #c574bd80;">
                            <div>
                              <p class="m-0 font-e text-center">ENGANCHE</p>
                              <div class="enganche" id="enganche"></div>  
                            </div>                                  
                          </div>
                          <div class="col-lg-2 col-md-2 col-sm-1 col-xs-6 col-xs-6 center" style="background-color: #c574bd80;">  
                            <div>
                              <p class="m-0 font-e">ABONADO</p>
                              <div class="abono" id="abono"></div>  
                            </div>                                                                        
                          </div>

                          <div class="col-lg-2 col-md-2 col-sm-1 col-xs-6 col-xs-6 center" style="background-color: #c58cbf73;">
                            <div>
                              <p class="m-0 font-e">SALDO PENDIENTE</p>
                              <div class="saldo" id="saldo"></div>
                              <input id="saldo_i" type="text" hidden>
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

                    <div class="row box-estado-1 pl-3 pr-3 mt-1">
                      <div class="col-md-12 d-flex m-0 justify-content-around align-items-center" style="background-color: #f7f7f7;">
                        <h5 class="text-center pt-3 pb-3 m-0" style="background-color: #f7f7f7; color:#333;">ESTADO DE PAGOS</h5>
                        <p id="btn-recurrente"class="d-none m-0 pr-2 pl-2" style="background:#f79f0591; border-radius:15px; font-size:14px">PAGOS RECURRENTES</p>
                        <p id="btn-completo"class="d-none m-0 pr-2 pl-2" style="background:#a8dda8; border-radius:15px; font-size:14px">PAGO(S) COMPLETO(S)</p>
                        <p id="btn-pu"class="d-none m-0 pr-2 pl-2" style="background:#a8dda8; border-radius:15px; font-size:14px">PAGO REALIZADO EN UNA EXHIBICIÓN</p>
                        <button id="btn-pu2" class="d-none btn-circle btn-md details2" style="background-color:#1ABC9C; border-color:#1ABC9C; color: #FFFFFF;"><i class="fa fa-info-circle"></i></button>
                        <p id="btn-pendiente"class="d-none m-0 pr-2 pl-2" style="background:#f79f0591; border-radius:15px; font-size:14px">PAGO(S) PENDIENTE(S) DE REALIZAR</p>
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
                            <input type="text" class="form-control"  name="valor_acumulado" id="valor_acumulado" placeholder="" autocomplete="off" readonly>
                          </div>                          
                        </div>  
                        <div class="col-sm-3 d-flex align-items-end">
                          <div class="form-group box-formaPago d-none">
                            <label>Forma de pago <b>(anticipo)</b></label>                                            
                            <select id="formaPago" name="formaPago[]" class="form-control g-disabld" autocomplete="off" multiple="multiple" onchange="changePay(); changeEntrance(); changeAPagar();">
                              <option value='1' class="efeRequired">Efectivo</option>    
                              <option value='2' class="tarRequired">Tarjeta</option>
                              <option value='6' class="tbRequired">Transferencia Bancaria</option>
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
                              <input type="text" class="form-control g-disabld" name="efectivo" id="efectivo"
                               autocomplete="off" onkeypress="return onlyNumbers(event)" onkeyup="changeEntrance(); changeAPagar(); evalueEntranceE(this.value); evalueEntrance();">  
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
                                  <input type="text" class="form-control g-disabld" name="montoT[]" id="montoTU" autocomplete="off" onkeypress="return onlyNumbers(event)" onkeyup="changeEntrance(); changeAPagar(); evalueEntranceTU(this.value);  evalueEntrance();"> 
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
                                  <input type="text" class="form-control g-disabld" name="montoT[]" id="montoTD" autocomplete="off" onkeypress="return onlyNumbers(event)" onkeyup="changeEntrance(); changeAPagar(); evalueEntranceTD(this.value);  evalueEntrance();"> 
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
                      <div id="box-tb" class="d-none">
                            <div class="">
                              <h3>Datos de la tranferencia bancaria</h3>
                              <br><br>
                              <div class="row">
                                <div class="col-md-3">
                                  <div class="form-group box-referencia">
                                    <label>Clave de rastreo:</label>
                                    <input type="text" class="form-control" name="clave_rastreo_tb"
                                        class="clave_rastreo_tb" id="clave_rastreo_tb" autocomplete="off" >
                                    <small><i>Introduce la clave de rastreo del comprobante de tranferencia</i></small>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="form-group box-referencia">
                                    <label>Monto:</label>
                                    <input type="text" class="form-control" name="monto_tb" class="monto_tb"
                                        autocomplete="off" id="monto_tb"
                                        onkeypress="return onlyNumbers(event);"
                                        onkeyup="changeEntranceTB(); evalueEntranceTB(this.value);  evalueEntrance();">
                                    <small><i>Introduce el monto de la tranferencia</i></small>
                                  </div>
                                </div>
                              </div>
                            </div>
                      </div> <!-- End div box-tb-->                
                      <div class="box-detalle-fin d-none">
                        <div class="row d-flex justify-content-end">                              
                          <div class="col-sm-7">
                            <div class="row">
                            <div class="col-sm-9 text-right">
                                <p>A pagar:</p>
                              </div>
                              <div class="col-sm-3">
                                <input type="number" class="form-control text-center" name="aPagar" id="aPagar" placeholder="0.00" disabled>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-9 text-right">
                                <p>Entrada:</p>
                              </div>
                              <div class="col-sm-3">
                                <input type="number" class="form-control text-center" name="entrada" id="entrada" placeholder="0.00" disabled>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div><!-- End box-detalle-fin -->               
                      <br>
                      <div class="row">
                        <div class="col-md-12">
                          <center><button id="btnsubmit" type="submit" class="btn btn-body" disabled>Finalizar</button></center>
                        </div>
                      </div> <!-- End row submit button -->
                    </div><!-- End box-pacialidades -->
                  </form><!-- End form -->
                  <br>               
                  <form  method="post" id="form_apply_payment_abono">
                    <div class="box-abono p-4 d-none" style="background-color:#f7f7f7">
                      <h4 class="text-center">COBRO DE ABONO</h4>
                      <br>
                      <input type="text" name="id_contrato_2" id="id_contrato_2" hidden>
                      <input type="text" name="id_cliente_2" id="id_cliente_2" hidden>
                      <input type="text" name="string_cantidad_2" id="string_cantidad_2" hidden>
                      <div class="row">                                          
                        <div class="col-sm-3 d-flex align-items-end">
                          <div class="form-group">
                            <label style="font-size:14px">A pagar:</label>
                            <input type="text" class="form-control" onkeypress="return onlyNumbers(event)" onkeyup="evaluateSaldo();" name="valor_acumulado_2" id="valor_acumulado_2" placeholder="" autocomplete="off">
                          </div>                          
                        </div>
                        <div class="col-sm-3 d-flex align-items-end">
                          <div class="form-group box-formaPago_2 d-none">
                            <label>Forma de pago <b>(anticipo)</b></label>                                            
                            <select id="formaPago_2" name="formaPago_2[]" class="form-control" autocomplete="off"
                              multiple="multiple" onchange="changePay_2(); changeEntrance_2(); changeAPagar_2();">
                              <option value='1' class="efeRequired">Efectivo</option>    
                              <option value='2' class="tarRequired">Tarjeta</option>
                              <option value='6' class="tbRequired">Transferencia Bancaria</option>
                            </select> 
                          </div>
                        </div>
                      </div><!-- End row -->
                      <br>
                      <div id="box-cash_2" class="d-none mb-1">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Efectivo</label>
                              <input type="text" class="form-control g-disabld" name="efectivo_2" id="efectivo_2" value="0.00" autocomplete="off" onkeypress="return onlyNumbers(event)" onkeyup="changeEntrance_2(); changeAPagar_2(); ">  
                            </div>
                          </div>
                        </div>
                      </div><!-- End box-cash -->
                      <div id="box-card2" class="d-none">
                        <label class="lblTipoCard"></label>
                        <ul class="nav nav-tabs" role="tablist">
                          <div class="col-md-1" id="tabtjt1">
                            <li role="presentation" class="active">
                              <a href="#tarjeta1_2" aria-controls="tarjeta1_2" role="tab" data-toggle="tab">Tarjeta 1</a>
                            </li>
                          </div>
                          <div class="col-md-1" id="tabtjt2_2">
                            <li role="presentation"><a href="#tarjeta2_2" aria-controls="tarjeta2_2" role="tab" data-toggle="tab">Tarjeta 2</a></li>
                          </div>
                        </ul>                                            
                        <div class="tab-content">
                          <div role="tabpanel" class="tab-pane fade active show" id="tarjeta1_2">
                            <div class="row mt-3">
                              <div class="col-sm-12">
                                  <label><b>Datos tarjeta 1</b></label>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-group box-referencia">
                                  <label>Referencia:</label>
                                  <input type="text" class="form-control g-disabld" name="referencia_2[]" id="referencia_2" class="referencia_2" onkeypress="return onlyNumbers(event)" autocomplete="off">
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="from-group colCreDeb">
                                  <label>Tipo de tarjeta</label>
                                  <select name="tipoCreDeb_2[]" id="changeTipoTar1_2"
                                  class="form-control g-disabld">
                                    <option value="">Seleccione opción</option>
                                    <option value="1">Crédito</option>
                                    <option value="2">Débito</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="from-group box-monto_2">
                                  <label>Monto:</label>
                                  <input type="text" class="form-control g-disabld" name="montoT_2[]" id="montoTU_2" autocomplete="off" value = "0.00" onkeypress="return onlyNumbers(event)" onkeyup="changeEntrance_2(); changeAPagar_2(); "> 
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="from-group box-msi_2 d-none">
                                  <label>MSI:</label>
                                  <select id="msi1_2" name="msi_2[]" class="form-control g-disabld">
                                    <option value="">Seleccione una opción</option>                            
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div> <!-- End tab-pane tarjeta 1-->
                          <div role="tabpanel" class="tab-pane fade .error" id="tarjeta2_2">
                            <div class="row mt-3">
                              <div class="col-sm-12">
                                <label><b>Datos tarjeta 2</b></label>
                              </div>
                            </div>
                            <div class="row mt-3">
                              <div class="col-md-3">
                                <div class="form-group box-referencia">
                                  <label>Referencia:</label>
                                  <input type="text" class="form-control g-disabld" name="referencia_2[]" id="referencia_2_2" class="referencia_2" onkeypress="return onlyNumbers(event)" autocomplete="off">
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="from-group colCreDeb">
                                  <label>Tipo de tarjeta</label>
                                  <select name="tipoCreDeb_2[]" id="changeTipoTar2_2" class="form-control g-disabld">
                                    <option value="">Seleccione opción</option>
                                    <option value="1">Crédito</option>
                                    <option value="2">Débito</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="from-group">
                                  <label>Monto:</label>
                                  <input type="text" class="form-control g-disabld" name="montoT_2[]" id="montoTD_2" autocomplete="off" value = "0.00" onkeypress="return onlyNumbers(event)" onkeyup="changeEntrance_2(); changeAPagar_2(); "> 
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="from-group box-msi2_2 d-none">
                                  <label>MSI:</label>
                                  <select id="msi2_2" name="msi_2[]" class="form-control g-disabld"></select>
                                </div>
                              </div>
                            </div><!-- End row -->                                                
                          </div> <!-- End tab-pane tarjeta 2-->
                        </div> <!-- End tab-content general tarjetas-->                        
                      </div> <!-- End div box-card-->                      
                      <div id="box-tb_2" class="d-none">
                            <div class="">
                              <h3>Datos de la tranferencia bancaria</h3>
                              <br><br>
                              <div class="row">
                                <div class="col-md-3">
                                  <div class="form-group box-referencia">
                                    <label>Clave de rastreo:</label>
                                    <input type="text" class="form-control" name="clave_rastreo_tb_2"
                                        class="clave_rastreo_tb_2" id="clave_rastreo_tb_2" autocomplete="off" >
                                    <small><i>Introduce la clave de rastreo del comprobante de tranferencia</i></small>
                                  </div>
                                </div>
                                <div class="col-md-3">
                                  <div class="form-group box-referencia">
                                    <label>Monto:</label>
                                    <input type="text" class="form-control" name="monto_tb_2" autocomplete="off" id="monto_tb_2" onkeypress="return onlyNumbers(event);" value="$0.00" onkeyup="changeEntrance_2(); changeAPagar_2();">
                                    <small><i>Introduce el monto de la tranferencia</i></small>
                                  </div>
                                </div>
                              </div>
                            </div>
                      </div> <!-- End div box-tb_2 -->                      
                      <div class="box-detalle-fin_2 d-none">
                        <div class="row d-flex justify-content-end">                              
                          <div class="col-sm-7">
                            <div class="row">
                              <div class="col-sm-9 text-right">
                                <p>A pagar:</p>
                              </div>
                              <div class="col-sm-3">
                                <input type="number" class="form-control text-center" name="aPagar_2" id="aPagar_2" placeholder="0.00" disabled>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-9 text-right">
                                <p>Entrada:</p>
                              </div>
                              <div class="col-sm-3">
                                <input type="number" class="form-control text-center" name="entrada_2" id="entrada_2" placeholder="0.00" disabled>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div><!-- End box-detalle-fin -->               
                      <br>
                      <div class="row">
                        <div class="col-md-12">
                          <center><button id="btnsubmit_2" type="submit" class="btn btn-body" disabled>Finalizar</button></center>
                        </div>
                      </div> <!-- End row submit button -->
                    </div><!-- End box-pacialidades -->
                  </form><!-- End form -->
                  </div><!-- End box-estado-pagos -->  

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
                <center><button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button></center>
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
        <center><button type="button" class="btn btn-body" data-dismiss="modal" onClick="reloadPage();">Finalizar</button></center>                
      </div>
    </div>
  </div>
</div>

<div id="modal_validate_saldo" class="modal fade" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body pago-validate">
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<div id="details_modal" class="modal fade" aria-hidden="false" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" style="-webkit-transform: none; transform: none">
    <div class="modal-content">
      <div class="modal-header" style="padding-top:24px">
        <h4 class="modal-title m-0"><b>Detalle de pago</b></h4>
      </div>
      <div class="modal-body">
        <table id="see_details" class="table table-bordered table-hover" width="100%" style="text-align:center;">
            <thead><tr>
              <th><center>Referencia</center></th>
              <th><center>Monto</center></th>
              <th><center>Fecha</center></th>
              <th><center>Responsable</center></th>
              <th><center>Método de pago</center></th>
              <th><center>MSI</center></th>
            </tr></thead>
        </table>
      </div>
      <div class="modal-footer">
        <span class="pull-left"></span>
          <button type="button" class="btn btn-body" data-dismiss="modal">¡Entendido!</button>
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

<script>
  var url = "<?=base_url()?>";
  var url2 = "<?=base_url()?>index.php/";
  var urlimg = "<?=base_url()?>/img/";
  $(document).ready(function(){

     $.post("<?=base_url()?>index.php/Home/get_total_dia/", function(data) {
        var total_hoy = 0;
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

    $('#formaPago').multiselect({
      nonSelectedText:'Seleccione una opción'
    });

    $('#formaPago_2').multiselect({
      nonSelectedText:'Seleccione una opción'
    });

    $('#efectivo').on('click focusin', function() {
      this.value = '';
    });

    $('#efectivo_2').on('click focusin', function() {
      this.value = '';
    });

    $('#efectivo').focusout(function(){
        if($('#efectivo').val()!= '')
          jQuery("#modalEfectivo").modal("show");
    });

    $('#efectivo_2').focusout(function(){
        if($('#efectivo_2').val()!= '')
          jQuery("#modalEfectivo").modal("show");
    });

    $('#montoTU').on('click focusin', function() {
        this.value = '';
    });

    $('#montoTU_2').on('click focusin', function() {
        this.value = '';
    });
    $('#montoTD').on('click focusin', function() {
        this.value = '';
    });  
    $('#montoTD_2').on('click focusin', function() {
        this.value = '';
    });  
    $('#monto_tb_2').on('click focusin', function() {
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
    $('#loader').removeClass('hidden');
    var id_contrato = $('#selectCliente').val();
    $("#id_contrato").val(id_contrato);
    $("#id_contrato_2").val(id_contrato);
    var estatus_contrato = $("#selectCliente option:selected").attr("data-value");
    var id_cliente = $("#selectCliente option:selected").attr("data-cliente");
    $("#id_cliente").val(id_cliente);
    $("#id_cliente_2").val(id_cliente);
    var engancheT = 0;
    var pendiente = 0;
    var importePagado = 0;
    var abono_TQuincenas = 0;
    var pagosR = 0;
    var pagosT = 0;    
    $(".box-parcialidades").addClass("d-none");
    $("#box-cash_2").addClass("d-none");
    $("#box-card2").addClass("d-none");
    $("#box-tb_2").addClass("d-none");
    $(".box-detalle-fin_2").addClass("d-none");
    $(".box-abono").addClass("d-none");

    if($("#selectCliente option:selected").val() != ''){
      $(".box-estado-pagos").removeClass("d-none");
      $("#tabla_corrida").html("");
      $("#total").html("");
      $("#enganche").html("");
      $("#abono").html("");
      $("#saldo").html("");
      $("#saldo_i").val("");
      $("#num_pagos").html("");      
      $("#botones").html("");
      $("#a_pagar").html("");
      $('#valor_acumulado_2').val('');
      $('#efectivo_2').val('');
      $('#changeTipoTar1_2').val('');
      $('#changeTipoTar2_2').val('');
      $('#msi1_2').val('');
      $('#msi2_2').val('');
      $('#referencia_2_2').val('');
      $('#referencia_2').val('');
      $('#montoTU_2').val(''); 
      $('#montoTD_2').val(''); 
      $('#clave_rastreo_tb_2').val('');
      $('#monto_tb_2').val('');
      jQuery('#formaPago_2').multiselect('clearSelection'); // to reset the multi select users dropdown

      jQuery('#formaPago_2').multiselect('refresh'); // to reset the multi select users dropdown
    // $('#formaPago_2').multiselect('refresh');
        // $('#form_apply_payment_abono :input').val('');
      if (estatus_contrato == 3){      
        console.log("terminado");
        $.getJSON(url2 + "Cobranza/pago_una_exhibicion/"+id_contrato).done(function( data ){          
          $.each(data, function(i, v){            
            engancheT += parseFloat(v.enganche);              
          });
          
          if(engancheT == data[0].cantidad){       
            $("#btn-recurrente").addClass("d-none");     
            $("#btn-completo").addClass("d-none");  
            $("#btn-pendiente").addClass("d-none");         
            $("#btn-pu").removeClass("d-none");     
            $("#btn-pu2").removeClass("d-none");
            $("#btn-pu2").val(id_contrato); 
            
            pendiente = data[0].cantidad - engancheT;            
            $("#a_pagar").append('<p style="text-align:center; margin:0; font-size:14px"><b>$ '+formatMoney(data[0].cantidad)+'</b></p>');
            $("#enganche").append('<p style="text-align:center; margin:0; font-size:14px"><b>$ '+formatMoney(engancheT)+'</b></p>');
            $("#abono").append('<p style="text-align:center; margin:0; font-size:14px"><b>$0.00</b></p>');
            $("#saldo").append('<p style="text-align:center; margin:0; font-size:14px"><b>$ '+formatMoney(pendiente)+'</b></p>');
            $("#num_pagos").append('<p style="text-align:center; margin:0; font-size:14px"><b>0 / 0</b></p>');            
            $("#saldo_i").val(pendiente);
          }
        });
      }
      $.getJSON(url2 + "Cobranza/plan_cliente_enganche/"+id_contrato).done(function( dataM ){
        $("#tabla_corrida").append('<div class="col-lg-12">');
        
        //Función para traer las quincenas del contrato seleccionado
        $.getJSON(url2 + "Cobranza/plan_cliente/"+id_contrato).done(function( data ){
          
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
                $("#tabla_corrida").append('<div class="row d-flex align-items-center pt-2 pb-2" style="color:#F79F05;"><div class="col-lg-1 text-center"><label class="m-0" style="font-size:10px;">'+(i+1)+'</label></div><div class="col-lg-3"><label class="m-0" style="font-size:12px;">'+v.nom_completo+'<label></div><div class="col-lg-2"><label class="m-0" style="font-size:12px;">'+(fecha.toLocaleDateString('es-ES', options))+'</label></div><div class="col-lg-2"><label style="font-size:12px;">$'+formatMoney(v.importe)+'</label></div><div class="col-lg-2"><label style="font-size:12px;"></label></div><div class="col-lg-1"><i class="fa fa-exclamation-triangle"></i></div><div class="col-lg-1 details" data-quincena="'+v.id_quincena+'"><i class="fa fa-info-circle"></i></div></div><hr class="m-0">');
              }
              else if(v.estatus==1){//ESTATUS 1
                $("#tabla_corrida").append('<div class="row d-flex align-items-center pt-2 pb-2" style="color:#2AAC00;"><div class="col-lg-1 text-center"><b><label class="m-0" style="font-size:10px;">'+(i+1)+'</label></b></div><div class="col-lg-3"><label class="m-0" style="font-size:12px;"><b>'+v.nom_completo+'</b><label></div><div class="col-lg-2"><b><label class="m-0" style="font-size:12px;">'+(fecha.toLocaleDateString('es-ES', options))+'</label></b></div><div class="col-lg-2"><label style="font-size:12px;"><b>$'+formatMoney(v.importe)+'</b></label></div><div class="col-lg-2"><label style="font-size:12px;"></label></div><div class="col-lg-1"><i class="fa fa-check" ></i></div><div class="col-lg-1 details" data-quincena="'+v.id_quincena+'"><i class="fa fa-info-circle"></i></div></div><hr class="m-0">');
              }
              else if(v.estatus == 4){//ESTATUS 1
                $("#tabla_corrida").append('<div class="row d-flex align-items-center pt-2 pb-2" style="color:#F79F05;"><div class="col-lg-1 text-center"><label class="m-0" style="font-size:10px;">'+(i+1)+'</label></div><div class="col-lg-3"><label class="m-0" style="font-size:12px;">'+v.nom_completo+'<label></div><div class="col-lg-2"><label class="m-0" style="font-size:12px;">'+(fecha.toLocaleDateString('es-ES', options))+'</label></div><div class="col-lg-2"><label style="font-size:12px;">$'+formatMoney(v.importe)+'</label></div><div class="col-lg-1"><label style="font-size:12px;">Abonado: <br>$ '+formatMoney(v.importe - v.saldo)+'</label></div><div class="col-lg-1"><label style="font-size:12px;">Saldo: <br>$ '+formatMoney(v.saldo)+'</label></div><div class="col-lg-1"><i class="fa fa-pause-circle"></i></div><div class="col-lg-1 details" data-quincena="'+v.id_quincena+'"><i class="fa fa-info-circle"></i></div></div><hr class="m-0">');
              }
			             }
            else{//FECHA NO VENCIDA
              if(v.estatus==0){//ESTATUS 0
                $("#tabla_corrida").append('<div class="row d-flex align-items-center pt-2 pb-2" style="color:#868686;"><div class="col-lg-1 text-center"><label class="m-0" style="font-size:10px;">'+(i+1)+'</label></div><div class="col-lg-3"><label class="m-0" style="font-size:12px;">'+v.nom_completo+'<label></div><div class="col-lg-2"><label class="m-0" style="font-size:12px;">'+(fecha.toLocaleDateString('es-ES', options))+'</label></div><div class="col-lg-2"><label style="font-size:12px;">$'+formatMoney(v.importe)+'</label></div><div class="col-lg-2"><label style="font-size:12px;"></label></div><div class="col-lg-1"><i class="fa fa-clock"></i></div><div class="col-lg-1 details" data-quincena="'+v.id_quincena+'"><i class="fa fa-info-circle"></i></div></div><hr class="m-0">');
              }
              else if(v.estatus==1){//ESTATUS 1
                $("#tabla_corrida").append('<div class="row d-flex align-items-center pt-2 pb-2" style="color:#2AAC00;"><div class="col-lg-1 text-center"><b><label class="m-0" style="font-size:10px;">'+(i+1)+'</label></b></div><div class="col-lg-3"><label class="m-0" style="font-size:12px;"><b>'+v.nom_completo+'</b><label></div><div class="col-lg-2"><b><label class="m-0" style="font-size:12px;">'+(fecha.toLocaleDateString('es-ES', options))+'</label></b></div><div class="col-lg-2"><label style="font-size:12px;"><b>$'+formatMoney(v.importe)+'</b></label></div><div class="col-lg-2"><label style="font-size:12px;"></label></div><div class="col-lg-1"><i class="fa fa-check" ></i></div><div class="col-lg-1 details" data-quincena="'+v.id_quincena+'"><i class="fa fa-info-circle"></i></div></div><hr class="m-0">');
              }
              else if(v.estatus == 4){//ESTATUS 1
                $("#tabla_corrida").append('<div class="row d-flex align-items-center pt-2 pb-2" style="color:#868686;"><div class="col-lg-1 text-center"><label class="m-0" style="font-size:10px;">'+(i+1)+'</label></div><div class="col-lg-3"><label class="m-0" style="font-size:12px;">'+v.nom_completo+'<label></div><div class="col-lg-2"><label class="m-0" style="font-size:12px;">'+(fecha.toLocaleDateString('es-ES', options))+'</label></div><div class="col-lg-2"><label style="font-size:12px;">$'+formatMoney(v.importe)+'</label></div><div class="col-lg-1"><label style="font-size:12px;">Abonado:<br> $ '+formatMoney(v.importe - v.saldo)+'</label></div><div class="col-lg-1"><label style="font-size:12px;">Saldo: <br>$ '+formatMoney(v.saldo)+'</label></div><div class="col-lg-1"><i class="fa fa-pause-circle"></i></div><div class="col-lg-1 details" data-quincena="'+v.id_quincena+'"><i class="fa fa-info-circle"></i></div></div><hr class="m-0">');
              }
            }//FIN FECHA VENCIDA
          });
          $('#loader').addClass('hidden');
        });

        //Función para llenar el encabezado de resumen 
        if (dataM != ''){          
          $.each(dataM, function(i, v){
            if(v.estatus == '1') importePagado = parseFloat(importePagado) + parseFloat(v.importe);              
            else pagosR++;       
            pagosT++;
          });
          dataM[0].abono_pagado == null ? abono_TQuincenas = 0 : abono_TQuincenas = dataM[0].abono_pagado;          
          console.log("total enganche: "+parseFloat(dataM[0].total_enganche));
          console.log("total de quincenas: "+ parseFloat(importePagado));
          console.log("total de abonos: "+abono_TQuincenas);
          abonoT = parseFloat(importePagado) + parseFloat(abono_TQuincenas);
          console.log("Abono total de: "+abonoT);
          pendiente = dataM[0].cantidad - abonoT - parseFloat(dataM[0].total_enganche);
          $("#a_pagar").append('<p style="text-align:center; margin:0; font-size:14px"><b>$ '+formatMoney(dataM[0].cantidad)+'</b></p>');
          $("#enganche").append('<p style="text-align:center; margin:0; font-size:14px"><b>$ '+formatMoney(dataM[0].total_enganche)+'</b></p>');
          $("#abono").append('<p style="text-align:center; margin:0; font-size:14px"><b>$ '+formatMoney(abonoT)+'</b></p>');
          $("#saldo").append('<p style="text-align:center; margin:0; font-size:14px"><b>$ '+formatMoney(pendiente)+'</b></p>');
          $("#num_pagos").append('<p style="text-align:center; margin:0; font-size:14px"><b>'+pagosR+' / '+pagosT+'</b></p>');
          $("#saldo_i").val(pendiente);
        
          if(pagosR == 0){            
            $("#btn-recurrente").addClass("d-none");     
            $("#btn-completo").removeClass("d-none");   
            $("#btn-pu").addClass("d-none");   
            $("#btn-pu2").addClass("d-none");   
            $("#btn-pendiente").addClass("d-none");
          }
          else{
            $("#btn-completo").addClass("d-none");   
            $("#btn-pu").addClass("d-none");  
            $("#btn-pu2").addClass("d-none");  
            $("#btn-pendiente").removeClass("d-none");  
            $("#botones").append('<br><button class="btn pagar_quincena" value="'+dataM[0].id_cobro+'"" style="border:none; color: #333; background-color: #c574bd80; padding: 5px 60px; border-radius:20px">PAGAR</button>');
            $("#botones").append('&nbsp&nbsp<button class="btn pagar_abono" value="'+dataM[0].id_cobro+'"" style="border:none; color: #333; background-color: #c574bd80; padding: 5px 60px; border-radius:20px;">ABONAR</button>');
          }
        }             
      });       
    }
    else{
      $(".box-estado-pagos").addClass('d-none'); 
    }
  });

  $(document).on("click", ".details", function(){
      id_q = $(this).attr("data-quincena");
      jQuery('#details_modal').modal('show');
      var url_table = '';
      url_table = "<?=base_url()?>index.php/Cobranza/get_abonos/"+id_q;
      $.getJSON(url_table).done( function( data ){
        arm_table_abonos(url_table);
      });

  });

  $(document).on("click", ".details2", function () {
    id_contrato = $(this).val();
    jQuery('#details_modal').modal('show');
    var url_table = '';
    url_table = "<?=base_url()?>index.php/Cobranza/get_abonos2/" + id_contrato;
    $.getJSON(url_table).done(function (data) {
      arm_table_abonos(url_table);
    });
  });

	function arm_table_abonos(url_table){
		table_abonos = jQuery('#see_details').DataTable({
			responsive: true,
			dom: 'Bfrti',
      "searching": false,
			"pageLength": 10,
			"language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
			},
			"destroy": true,
			"ordering": false,
			columns: [
				{ "data": "referencia" },
        {
          "data": function(d){
            return '$' + formatMoney(d.pago);
          }
		    },
				{ "data": "fecha_creacion" },
				{ "data": "creado_por" },
				{"data": "metodo_pago"},
				{"data": "msi"}
			],
			"ajax":
				{
					"url": url_table,
					"dataSrc": ""
				},
		});
	}
           
  $(document).on("click", ".pagar_quincena", function(){
    event.preventDefault();
    jQuery.noConflict();
    $(".pagar_quincena").addClass("d-none");
    $(".box-parcialidades").removeClass("d-none");
    $(".box-check-pagos").html("");
    $(".box-abono").addClass("d-none");
	$(".pagar_abono").removeClass("d-none");
	$("#valor_acumulado_2").val("");

    var id_contrato = $('#selectCliente').val();
    $.getJSON(url2 + "Cobranza/plan_pagar/"+id_contrato).done(function( data ){
	    var verifica= 0;
      $.each( data, function(i, v){
        var fecha = new Date(v.fecha_pago);
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
		if (v.estatus == 4){
        $(".box-check-pagos").append('<div class="row div_mensualidades"><div class="col-lg-2"><input type="checkbox" class="pago_quincena" name="pago_quincena[]" value="'+v.id_quincena+'" data-value="'+v.importe+'" onchange="evaluarChecked();" disabled="disabled"></div><div class="col-lg-6"><label>'+(fecha.toLocaleDateString('es-ES', options))+' - <span style="color:red">(Quincena en abono)</span></label></div><div class="col-lg-4"><label><center>$ '+formatMoney(v.importe)+'</center></label><input type="text" name="fecha_quincena[]" value="'+(fecha.toLocaleDateString('es-ES', options))+'" hidden><input type="text" name="importe_quincena[]" value="'+formatMoney(v.importe)+'" hidden></div></div>');
		verifica = 1; 
		} else {
			if(verifica == 1){
			$(".box-check-pagos").append('<div class="row div_mensualidades"><div class="col-lg-2"><input type="checkbox" class="pago_quincena" name="pago_quincena[]" value="'+v.id_quincena+'" data-value="'+v.importe+'" onchange="evaluarChecked();" disabled="disabled"></div><div class="col-lg-6"><label>'+(fecha.toLocaleDateString('es-ES', options))+'</label></div><div class="col-lg-4"><label><center>$ '+formatMoney(v.importe)+'</center></label><input type="text" name="fecha_quincena[]" value="'+(fecha.toLocaleDateString('es-ES', options))+'" hidden><input type="text" name="importe_quincena[]" value="'+formatMoney(v.importe)+'" hidden></div></div>');
			}else {
			$(".box-check-pagos").append('<div class="row div_mensualidades"><div class="col-lg-2"><input type="checkbox" class="pago_quincena" name="pago_quincena[]" value="'+v.id_quincena+'" data-value="'+v.importe+'" onchange="evaluarChecked();"></div><div class="col-lg-6"><label>'+(fecha.toLocaleDateString('es-ES', options))+'</label></div><div class="col-lg-4"><label><center>$ '+formatMoney(v.importe)+'</center></label><input type="text" name="fecha_quincena[]" value="'+(fecha.toLocaleDateString('es-ES', options))+'" hidden><input type="text" name="importe_quincena[]" value="'+formatMoney(v.importe)+'" hidden></div></div>');
			}
		}
      });
    });
  });
 
  function changePay(){
    var formas = 0;
    cleanTarjeta();
    $('#box-cash').addClass('d-none');
    $('#box-card').addClass('d-none');
    $('#box-tb').addClass('d-none');
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
      if( v == 6 ){
      //Regresamos al  estado inicial los tab, Validación*
      $('#box-tb').removeClass('d-none');      
    }
      formas++;
    });

    if(formas==0) $(".box-detalle-fin").addClass('d-none');
    else $(".box-detalle-fin").removeClass('d-none');
  }

  function changePay_2(){
    var formas = 0;
    $('#box-cash_2').addClass('d-none');
    $('#box-card2').addClass('d-none');
    $('#box-tb_2').addClass('d-none');
    $('#montoTU_2').val('0.00');
    $('#montoTD_2').val('0.00');
    $('#efectivo2').val('0.00');
    $('#monto_tb_2').val('0.00');

    $.each( $('#formaPago_2').val(), function( i, v){
      if ( v == 1 ){  
        //Regresamos al  estado inicial los tab, Validación*              
        $('#box-cash_2').removeClass('d-none'); 
        $("#tarjeta1_2").addClass('active');
        $("#tarjeta1_2").addClass('show');   
        $("#tarjeta2_2").removeClass('active');
        $("#tarjeta2_2").removeClass('show');    
      }
      if( v == 2 ){
        //Regresamos al  estado inicial los tab, Validación*  
        $('#box-card2').removeClass('d-none');
        $('#tabtjt2_2').removeClass('d-none');
        $('#tarjeta2_2').removeClass('d-none');
        $(".box-monto_2").removeClass('d-none');
      }
      if( v == 6 ){
      //Regresamos al  estado inicial los tab, Validación*
      $('#box-tb_2').removeClass('d-none');
    }
      formas++;
    });

    if(formas==0) $(".box-detalle-fin_2").addClass('d-none');
    else $(".box-detalle-fin_2").removeClass('d-none');
  }

  function check_values_tb()
  {
    var clave_rastreo_tb = $('#clave_rastreo_tb').val();
    var monto_tb = $('#monto_tb').val();

    if( clave_rastreo_tb != '' || monto_tb!='' )
      $('#btnsubmit').prop('disabled', true);
    else $('#btnsubmit').prop('disabled', false);

    changeAPagar();
    $("#entrada").val(parseInt($('#efectivo').val()) + parseInt($('#montoTU').val()) + parseInt($('#montoTD').val()));
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
      suma = (suma + parseFloat(arr2[i]));
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
    $("#form_apply_payment_abono").validate({
      rules: {         
          'tipoCreDeb[]':{
              required: ".tarRequired:checked"
          },
          'tipoCreDeb_2[]':{
              required: ".tarRequired:checked"
          },
          'montoT[]':{
              required: ".tarRequired:checked",
          },
          'montoT_2[]':{
              required: ".tarRequired:checked",
          },
          'referencia':{
              required: ".tarRequired:checked"
          },   
          'referencia_2':{
              required: ".tarRequired:checked"
          }, 
          'efectivo':{
              required: ".efeRequired:checked",
              min: 1 + Number.MIN_VALUE
          },
          'efectivo_2':{
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
          'montoT_2[]':{
              required: "Dato requerido",
          },
          'referencia':{
              required: "Dato requerido",
          },  
          'referencia_2':{
              required: "Dato requerido",
          },
          'efectivo':{
              required: "Ingrese un monto",
              min: "Ingrese un monto mayor a cero"
          },
          'efectivo_2':{
              required: "Ingrese un monto",
              min: "Ingrese un monto mayor a cero"
          },
      },
      //Se evaluan las rules anteriores después se puede ejectur el submit de la form
      submitHandler: function(form){
        $('#loader').removeClass('hidden');
        var data = new FormData( $(form)[0] );
        $.ajax({
          url: url2 + "Cobranza/guardar_pagos_2",
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          method: 'POST',
          type: 'POST',
          success: function(data){    
            $('#loader').addClass('hidden');              
            if(data.success==1){  
              jQuery("#myModal_respuesta_pago").modal({backdrop: 'static', keyboard: false})   
              imprimir(data);
            } else if(data.success == 0){
              validate_saldo();
            }
            else{
              jQuery("#modal_fail").modal("show");
            }
          },error: function(data){
            jQuery("#modal_fail").modal("show");
          }
        })
      }
    })
  });

  //Función recurrente para validar onSubmit el formulario en v_Cliente ----- ABONOS
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
            $('#loader').addClass('hidden');         
            if(data.success==1){   
              jQuery("#myModal_respuesta_pago").modal({backdrop: 'static', keyboard: false})   
              imprimir(data);
            }
            else{
              jQuery("#modal_fail").modal("show");
            }
          },error: function(data){
            $('#loader').addClass('hidden');   
            jQuery("#modal_fail").modal("show");
          }
        })
      }
    })
  });

  function changeEntranceTB(){
    if( ( parseFloat($('#monto_tb').val()) + parseFloat($('#efectivo').val()) + parseFloat($('#montoTU').val()) + parseFloat($('#montoTD').val()) ) < parseFloat($('#aPagar').val()) )
      $('#btnsubmit').prop('disabled', true);
    else $('#btnsubmit').prop('disabled', false);

    changeAPagar();
    $("#entrada").val(parseFloat($('#monto_tb').val()) + parseFloat($('#efectivo').val()) + parseFloat($('#montoTU').val()) + parseFloat($('#montoTD').val()));
  }

  function changeEntrance(){
    if( (parseFloat(parseFloat($('#monto_tb').val()) + $('#efectivo').val()) + parseFloat($('#montoTU').val()) + parseFloat($('#montoTD').val())) < parseFloat($('#aPagar').val()) )
        $('#btnsubmit').prop('disabled', true);
    else $('#btnsubmit').prop('disabled', false);

    changeAPagar();
    $("#entrada").val(parseFloat(parseFloat($('#monto_tb').val()) + $('#efectivo').val()) + parseFloat($('#montoTU').val()) + parseFloat($('#montoTD').val()));
  }

  function changeEntrance_2(){
    var efectivo_2 = (parseFloat($('#efectivo_2').val(),10) > 0) ? parseFloat($('#efectivo_2').val(),10) : 0;
    var montoTU_2 = (parseFloat($('#montoTU_2').val(),10) > 0) ? parseFloat($('#montoTU_2').val(),10) : 0;
    var monto_tb_2 = (parseFloat($('#monto_tb_2').val(),10) > 0) ? parseFloat($('#monto_tb_2').val(),10) : 0;
    var montoTD_2 = (parseFloat($('#montoTD_2').val(),10) > 0) ? parseFloat($('#montoTD_2').val(),10) : 0;

    var suma = efectivo_2 + montoTU_2 + monto_tb_2 + montoTD_2;    
    var totalDeuda = parseFloat($('#aPagar_2').val());    
    if( suma ==  totalDeuda){
    $('#btnsubmit_2').attr('disabled', false);    
    }
    else {
    $('#btnsubmit_2').attr('disabled', true);    
    }

    changeAPagar_2();
    $("#entrada_2").val(parseFloat($('#monto_tb_2').val()) + parseFloat($('#efectivo_2').val()) + parseFloat($('#montoTU_2').val()) + parseFloat($('#montoTD_2').val()));

  }

  function evalueEntranceE(e){
    var efectivo = (parseFloat(e) > 0) ? parseFloat(parseFloat(e)) : 0;
    var montoTU = (parseFloat($('#montoTU').val()) > 0) ? parseFloat($('#montoTU').val()) : 0;
    var montoTD = (parseFloat($('#montoTD').val()) > 0) ? parseFloat($('#montoTD').val()) : 0;
    var monto_tb = (parseFloat($('#monto_tb').val()) > 0) ? parseFloat($('#monto_tb').val()) : 0;

    var suma = (efectivo + montoTU + montoTD + monto_tb);

    if(suma > parseFloat($('#valor_acumulado').val())){
      $(".pago-menor-div").remove();
      $(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El monto ingresado es mayor al anticipo</b></label></center> <center><button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button></center></div>');
      jQuery("#modalPagoMenor").modal("show");
      $("#efectivo").val('');
    }
  }
  function evalueEntrance(){
    var efectivo = (parseFloat($('#efectivo').val()) > 0) ? parseFloat($('#efectivo').val()) : 0;
    var montoTU = (parseFloat($('#montoTU').val()) > 0) ? parseFloat($('#montoTU').val()) : 0;
    var montoTD = (parseFloat($('#montoTD').val()) > 0) ? parseFloat($('#montoTD').val()) : 0;
    var monto_tb = (parseFloat($('#monto_tb').val()) > 0) ? parseFloat($('#monto_tb').val()) : 0;

    var suma = (efectivo + montoTU + montoTD + monto_tb);
    var totalPagar = parseFloat($('#valor_acumulado').val());

    if(suma == totalPagar)
  {
    console.log('Si es la misma cantidad');
    $('#btnsubmit').attr('disabled', false);
  }
    else {
      console.log('No es la misma cantidad');
    $('#btnsubmit').attr('disabled', true);
  }

    console.log("Suma: " + suma);
    console.log("Total a pagar: " + totalPagar);


    /*if(parseFloat(e) + parseFloat($('#montoTU').val()) + parseFloat($('#montoTD').val()) > parseFloat($('#valor_acumulado').val())){
      $(".pago-menor-div").remove();
      $(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El monto ingresado es mayor al anticipo</b></label></center> <center><button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button></center></div>');
      jQuery("#modalPagoMenor").modal("show");
      $("#efectivo").val('');
    }*/
    $("#entrada").val(suma);
  }
  function evalueEntranceTB(e){
    var efectivo = (parseFloat($('#efectivo').val()) > 0) ? parseFloat($('#efectivo').val()) : 0;
    var montoTU = (parseFloat($('#montoTU').val()) > 0) ? parseFloat($('#montoTU').val()) : 0;
    var montoTD = (parseFloat($('#montoTD').val()) > 0) ? parseFloat($('#montoTD').val()) : 0;
    var monto_tb = (parseFloat(e) > 0) ? parseFloat(e) : 0;

    var suma = (efectivo + montoTU + montoTD + monto_tb);
    if(suma > parseFloat($('#valor_acumulado').val())){
      $(".pago-menor-div").remove();
      $(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El monto ingresado es mayor al anticipo</b></label></center> <center><button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button></center></div>');
      jQuery("#modalPagoMenor").modal("show");
      $("#monto_tb").val('');
    }
  }
  function evalueEntranceTU(e){
    var efectivo = (parseFloat($('#efectivo').val()) > 0) ? parseFloat($('#efectivo').val()) : 0;
    var montoTU = (parseFloat(e) > 0) ? parseFloat(e) : 0;
    var montoTD = (parseFloat($('#montoTD').val()) > 0) ? parseFloat($('#montoTD').val()) : 0;
    var monto_tb = (parseFloat($('#monto_tb').val()) > 0) ? parseFloat($('#monto_tb').val()) : 0;

    var suma = (efectivo + montoTU + montoTD + monto_tb);

    if((suma) > parseFloat($('#valor_acumulado').val())){
      $(".pago-menor-div").remove();
      $(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El monto ingresado es mayor al anticipo</b></label></center> <center><button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button></center></div>');
      jQuery("#modalPagoMenor").modal("show");
      $("#montoTU").val('');
    }
  }

  function evalueEntranceTD(e){
    var efectivo = (parseFloat($('#efectivo').val()) > 0) ? parseFloat($('#efectivo').val()) : 0;
    var montoTU = (parseFloat($('#montoTU').val()) > 0) ? parseFloat($('#montoTU').val()) : 0;
    var montoTD = (parseFloat(e) > 0) ? parseFloat(e) : 0;
    var monto_tb = (parseFloat($('#monto_tb').val()) > 0) ? parseFloat($('#monto_tb').val()) : 0;
    var suma = (efectivo + montoTU + montoTD + monto_tb);

    if((suma) > parseFloat($('#valor_acumulado').val())){
      $(".pago-menor-div").remove();
      $(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El monto ingresado es mayor al anticipo</b></label></center> <center><button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button></center></div>');
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
      $("#msi2").append('<option value="9">9</option>');
      $("#msi2").append('<option value="12">12</option>');
    }
  });

  $('#changeTipoTar2_2').change(function(){
    $('.box-msi2_2').removeClass('d-none'); 
    $("#msi2_2").empty();  
    if ( $(this).val() == 2){
      $("#msi2_2").append('<option value="0" selected>NORMAL</option>');
    }
    else{
      $("#msi2_2").append('<option value="">Seleccione una opción</option>');
      $("#msi2_2").append('<option value="0">NORMAL</option>');
      $("#msi2_2").append('<option value="3">3</option>');
      $("#msi2_2").append('<option value="6">6</option>');
      $("#msi2_2").append('<option value="9">9</option>');
      $("#msi2_2").append('<option value="12">12</option>');
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
      $("#msi1").append('<option value="9">9</option>');
      $("#msi1").append('<option value="12">12</option>');
    }          
  });

  $('#changeTipoTar1_2').change(function(){    
    $('.box-msi_2').removeClass('d-none');
    $("#msi1_2").empty();  
    if ( $(this).val() == 2){
      $("#msi1_2").append('<option value="0" selected>NORMAL</option>');
    }
    else{
      $("#msi1_2").append('<option value="">Seleccione una opción</option>');
      $("#msi1_2").append('<option value="0">NORMAL</option>');
      $("#msi1_2").append('<option value="3">3</option>');
      $("#msi1_2").append('<option value="6">6</option>');
      $("#msi1_2").append('<option value="9">9</option>');
      $("#msi1_2").append('<option value="12">12</option>');
    }          
  });

  function changeAPagar(){
    $('#aPagar').val($('#valor_acumulado').val());
  }

  function changeAPagar_2(){
    $('#aPagar_2').val($('#valor_acumulado_2').val());
    var stringCantidad_2 = NumeroALetras($('#valor_acumulado_2').val());
    $("#string_cantidad_2").val(stringCantidad_2);
  }

  function evaluateSaldo(){  
    console.log("Total ingresado: $" +$('#valor_acumulado_2').val());      
    console.log("Saldo total restante: $"+$("#saldo_i").val());
    if(parseInt($('#valor_acumulado_2').val()) > parseInt($("#saldo_i").val())){
      validate_saldo();
      $('#valor_acumulado_2').val('');
    }
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

  // MAJO WAS HERE
  $(document).on("click", ".pagar_abono", function(){
    event.preventDefault();
    jQuery.noConflict();
    $(".pagar_abono").addClass("d-none");
    $(".box-abono").removeClass("d-none");
    $('#btnsubmit').show();
    $('.box-formaPago_2').removeClass('d-none');
	
	$(".box-parcialidades").addClass("d-none");
    $(".box-check-pagos").html("");
	$(".pagar_quincena").removeClass("d-none");
  });

  function deselectMulti(){        
    jQuery('#formaPago').multiselect('deselect', ['1', '2']);
    $('#box-cash').addClass('d-none');        
    $('#box-card').addClass('d-none'); 
    cleanTarjeta();
  }

  function validate_saldo(e){
      $(".pago-validate-div").remove();
      $(".pago-validate").append('<div class="pago-validate-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>¡El monto es mayor que el saldo!</b></label></center> <center><button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button></center></div>');
      jQuery("#modal_validate_saldo").modal("show");
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
      /*data.letrasMonedaPlural="CENTIMOS";
      data.letrasMonedaSingular="CENTIMO";*/
    }

    /*if (data.centavos > 0)
      data.letrasCentavos = "CON " + NumeroALetras(data.centavos,true);*/

    if(data.enteros == 0)
      return "CERO " + data.letrasMonedaPlural + " " + data.letrasCentavos;
    if (data.enteros == 1)
      return Millones(data.enteros) + " " + data.letrasMonedaSingular + " " + data.letrasCentavos;
    else
      return Millones(data.enteros) + " " + data.letrasMonedaPlural + " " + data.letrasCentavos;
  }//NumeroALetras()
  
  function imprimir(data){
    var date = new Date();        
    var options = { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit'};
    var mywindow = window.open('', 'my div', 'height=750,width=720');
    var elementoG = '';
    var elementoU = '';
    var elementoD = '';
    let Decimal = data['monto_pago'];
    let cantidad_dec = Decimal.substring(Decimal.indexOf(".")+1, Decimal .length);

    elementoG += '<html><head></head><body style="text-align:center;font-family: Arial, Helvetica, sans-serif; font-size:12px"><img id="myImage" src="https://bodyeffect.gphsis.com/assets/img/logo.png" alt="logo" width="100%" />';
    elementoG += '<p>Plaza Midtown Jalisco, Local 53-A planta alta, Italia Providencia Guadalajara, Jal.<br>Teléfono: (332) 310 59 07<br>'
    +date.toLocaleDateString("es-ES", options)+'<p>';
    elementoG += '';
    elementoG += '<p>FOLIO: '+data['numero_ticket']+' <br>REFERENCIA: '+data['referencias']+' <br>Recibí de: <br>'+data['nombre_cliente']+'</p>';
    elementoG += '<p>La cantidad de: <br><b>'+data['string_cantidad']+' '+cantidad_dec+'/100 M.N.</b></p>';
    elementoG += '<p>Forma de pago: <br>';
    var sep ='';
    /**/for( b=0;b<data['forma_pago'].length;b++ ){
      if((b+1)<data['forma_pago'].length)
      {
          sep = ', ';
      }
      else
      {
        sep = '';
      }
      elementoG += '<b>'+data['forma_pago'][b]+'</b>';
    }
    elementoG += '</p>';


    elementoG += '<p>Pago de servicios<br>';
    for( n=0;n<data['pagos'].length;n++ ){
      sum = n +1;
      elementoG += sum+' pago  '+data['pagos'][n]+'<br>';
    }
    elementoG += '</p><br>';

    elementoG += '<div style="text-align:center !important">';
      elementoG += '<label>DESGLOSE DEL PAGO:</label><br>';
        for(var i=0; i<data['metodos_usados'].length; i++)
        {
            /*console.log("<b>Metodo</b>: " + data['metodos_usados'][i]['metodo']);
            console.log("<b>Cantidad</b>: " + data['metodos_usados'][i]['cantidad']);*/
            elementoG += "<b> " + (data['metodos_usados'][i]['metodo']).toUpperCase() +": </b>";
            elementoG += "$ "+formatMoney(data['metodos_usados'][i]['cantidad'])+"<br>";
        }
    elementoG += '</div><br><br>';
    elementoG += '<p style="text-align:left!important;margin-left:10%" width="100%"><table width="100%" style="width:100%">';
    elementoG += '<tr>';
    elementoG += '  <td>';
    elementoG += '    <p style="text-align:left!important;font-size:0.78em;line-height:10px;"><b>SUBTOTAL:</b></p>';
    elementoG += '  </td>';
    elementoG += '  <td>';
    elementoG += '    <p style="text-align:left!important;font-size:0.78em;line-height:10px;"> $'+data['monto_pago']+'</p>';
    elementoG += '  </td>';
    elementoG += '</tr>';
    elementoG += '<tr>';
    elementoG += '  <td>';
    elementoG += '    <p style="text-align:left!important;font-size:0.78em;line-height:10px;"><b>IVA:</b></p>';
    elementoG += '  </td>';
    elementoG += '  <td>';
    elementoG += '    <p style="text-align:left!important;font-size:0.78em;line-height:10px;"> $0.00</p>';
    elementoG += '  </td>';
    elementoG += '</tr>';
    elementoG += '<tr>';
    elementoG += '  <td>';
    elementoG += '    <p style="text-align:left!important;font-size:0.78em;line-height:10px;"><b>TOTAL:</b></p>';
    elementoG += '  </td>';
    elementoG += '  <td>';
    elementoG += '    <p style="text-align:left!important;font-size:0.78em;line-height:10px;">$'+data['monto_pago']+'</p>';
    elementoG += '  </td>';
    elementoG += '</tr>';
    elementoG += '</table></p><br>';
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

  function addCommas(nStr){
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
