<?php
require "header.php";
$page = 'caja';
require "menu.php";
?>

<link href="<?= base_url("assets/css/v_Caja.css")?>" rel="stylesheet" />

<?php
if ($total_tdc[0]->total_pagar == '') {
	$ttdc = 0;
} else {
	$ttdc = $total_tdc[0]->total_pagar;
}
if ($total_tdd[0]->total_pagar == '') {
	$ttdd = 0;
} else {
	$ttdd = $total_tdd[0]->total_pagar;
}
if ($total_cash[0]->total_pagar == '') {
	$tcash = 0;
} else {
	$tcash = $total_cash[0]->total_pagar;
}
if ($total_tb[0]->total_pagar == '') {
	$ttb = 0;
} else {
	$ttb = $total_tb[0]->total_pagar;
}


if($total_tdcPQ[0]->total_pagar == '' || $total_tdcPQ[0]->total_pagar == null)
{
	$ttdcpq = 0;
}else
{
	$ttdcpq = $total_tdcPQ[0]->total_pagar;
}
if($total_tddPQ[0]->total_pagar == '' ||$total_tddPQ[0]->total_pagar == null)
{
	$ttddpq = 0;
}else
{
	$ttddpq = $total_tddPQ[0]->total_pagar;
}
if($total_cashPQ[0]->total_pagar == '' || $total_cashPQ[0]->total_pagar == null)
{
	$ttcashpq = 0;
}else
{
	$ttcashpq = $total_cashPQ[0]->total_pagar;
}
if($total_tbPQ[0]->total_pagar == '' || $total_tbPQ[0]->total_pagar == null)
{
	$ttbpq = 0;
}else
{
	$ttbpq = $total_tbPQ[0]->total_pagar;
}
$total = ($ttdc + $ttdcpq) + ($ttdd + $ttddpq) + ($tcash + $ttcashpq) + ($ttb + $ttbpq);
?>

<script>
	function formatMoney( n ){
		var c = isNaN(c = Math.abs(c)) ? 2 : c,
			d = d == undefined ? "." : d,
			t = t == undefined ? "," : t,
			s = n < 0 ? "-" : "",
			i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
			j = (j = i.length) > 3 ? j % 3 : 0;
		return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	};

jQuery(document).ready(function(){
	ttdc = <?= $ttdc + $ttdcpq ?> ;
	ttdd = <?= $ttdd + $ttddpq ?> ;
	tcash = <?= $tcash + $ttcashpq ?> ;
	ttb = <?= $ttb + $ttbpq ?> ;
	total = <?= $total ?> ;
	total_v = <?= $total_venta ?> ;

	$('#credito_print').val(ttdc);
	$('#debito_print').val(ttdd);
	$('#cash_print').val(tcash);
	$('#tranba_print').val(ttb);
	$('#total_venta_print').val(total_v);

	document.getElementById("ttdc").innerHTML = "$"+formatMoney(ttdc);
	document.getElementById("ttdd").innerHTML = "$"+formatMoney(ttdd);
	document.getElementById("tcash").innerHTML = "$"+formatMoney(tcash);
	document.getElementById("total").innerHTML = "$"+formatMoney(total);
	document.getElementById("ttb").innerHTML = "$"+formatMoney(ttb);
	document.getElementById("total_venta").innerHTML = "$"+formatMoney(total_v);

});

</script>

<input type="hidden"  id="credito_print">
<input type="hidden"  id="debito_print">
<input type="hidden"  id="cash_print">
<input type="hidden" id="tranba_print">
<input type="hidden"  id="total_print">
<input type="hidden"  id="total_venta_print">


<div id="historial_modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    	<div class="modal-body">
    		<div class="row pl-3 pr-3">
    			<div class="col-md-12">											
    				<div class="row" style="height:90px">
    					<div class="col-lg-3 col-md-2 col-sm-1 col-xs-6 col-xs-6 center" style="background-color: #c58cbf73; display: flex; align-items:center; justify-content:center">	
    						<div>
    							<p class="m-0 font-e">TOTAL A PAGAR</p>
    							<div class="a_pagar" id="a_pagar"></div>	
    						</div>													
    					</div>

    					<div class="col-lg-3 col-md-2 col-sm-1 col-xs-6 col-xs-6 center" style="background-color: #c574bd80; display: flex; align-items:center; justify-content:center">  
    						<div>
    							<p class="m-0 font-e">ABONADO</p>
    							<div class="abono" id="abono"></div>	
    						</div>						
    					</div>

    					<div class="col-lg-3 col-md-2 col-sm-1 col-xs-6 col-xs-6 center" style="background-color: #c58cbf73; display: flex; align-items:center; justify-content:center">
    						<div>
    							<p class="m-0 font-e">SALDO PENDIENTE</p>
    							<div class="saldo" id="saldo"></div>
    						</div>                            														
    					</div>

    					<div class="col-lg-3 col-md-2 col-sm-1 col-xs-6 col-xs-6 center" style="background-color: #c574bd80; display: flex; align-items:center; justify-content:center">
    						<div>
    							<p class="m-0 font-e text-center">PAGOS POR CUBRIR</p>
    							<div class="num_pagos" id="num_pagos"></div>	
    						</div>
    					</div>
    				</div><!-- END row -->
    			</div><!-- END col-md-12-->
    		</div><!-- END row -->
    		<input name="total_pagarInput" id="total_pagarInput" type="hidden">
    		<input name="abonado_input" id="abonado_input" type="hidden">
    		<input name="saldopendiente_input" id="saldopendiente_input" type="hidden">
    		<input name="pago_cubrir_input" id="pago_cubrir_input" type="hidden">
    		<div class="row box-estado-1 pl-3 pr-3 mt-1">
    			<div class="col-md-12 d-flex m-0 justify-content-around align-items-center" style="background-color: #f7f7f7;">
    				<h5 class="text-center pt-3 pb-3 m-0" style="display: none;background-color: #f7f7f7; color:#333;">ESTADO DE PAGOS</h5>
    				<p id="btn-recurrente"class="d-none m-0 pr-2 pl-2" style="background:#f79f0591; border-radius:15px; font-size:14px">PAGOS RECURRENTES</p>
    				<p id="btn-completo"class="d-none m-0 pr-2 pl-2" style="background:#a8dda8; border-radius:15px; font-size:14px">PAGOS COMPLETOS</p>
    				<p id="btn-pu"class="d-none m-0 pr-2 pl-2" style="background:#a8dda8; border-radius:15px; font-size:14px">PAGOS REALIZADOS EN UNA EXHIBICIÓN</p>
    			</div><!-- END col-md-12 -->
    		</div><!-- END row -->
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
      <div class="modal-footer text-right" style="align-self: flex-end;">
        <button type="button" class="btn btn-body mr-auto"  data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>


<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col" style="background-color : white;">
				<div class="box">
					<div class="box-body">
						<div class="box-header with-border">
							<div class="">
								<div class="card-body">
									<h3>CONSULTA CAJA</h3><br>
									<div class="row">
										<div class="col-md-12">
											<div class="col-md-12 form-group">
												<div class="row">
													<div class="col-md-12">
														<h4><b>INGRESOS POR FORMA DE PAGO</b></h4>
													</div>
												</div>
												<br>
												<div class="row centered-text">
													<div class="col-md-2">
														<h5>EFECTIVO</h5>
														<h6 id="tcash"></h6>
													</div>
													<div class="col-md-2">
														<h5>TARJETA DE CRÉDITO</h5>
														<h6 id="ttdc"></h6>
													</div>
													<div class="col-md-2">
														<h5>TARJETA DE DÉBITO</h5>
														<h6 id="ttdd"></h6>
													</div>
													<div class="col-md-2">
														<h5>TRANSFERENCIAS BANCARIAS</h5>
														<h6 id="ttb"></h6>
													</div>
													<div class="col-md-2" style="color:#AD1457">
														<h5>TOTAL INGRESOS</h5>
														<h6 id="total"></h6>
													</div>
													<div class="col-md-2" style="color:#AD1457">
														<h5>TOTAL DE VENTAS</h5>
														<h6 id="total_venta"></h6>
													</div>
												</div>
												<br>
											</div>
											<form id="report_form" name="report_form">
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
											<div id="external_filter_container18"></div>
											<div class="table-responsive">
												<div class="material-datatables">
													<table id="tabla_clientes" class="table table-striped table-bordered" cellspacing="0" width="100%">
														<thead>
														<tr>
														<th style="font-size: .9em">CLIENTE</th>
															<th style="font-size: .9em">FECHA</th>
															<th style="font-size: .9em">COBRÓ</th>
															<th style="font-size: .9em">ANTICIPO</th>
															<th style="font-size: .9em">SALDO</th>
															<th style="font-size: .9em">TOTAL</th>
															<th style="font-size: .9em">MÉTODO PAGO</th>
															<th style="font-size: .9em">COMENTARIO</th>
															<th style="font-size: .9em">COMPARTIDO</th>
															<th style="font-size: .9em">HISTORIAL</th>
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

<style>
	.modal.show .modal-dialog {
      -webkit-transform: translate(0,0);
      transform: translate(0,0);
    }

	.btn-body{
		border-radius: 25px;
		color:white;
		border:none;
		background-color: #bd98e0;
	}

	.btn-body:hover{
		background-color: white;
		color:#333;
	}

</style>
<?php
require "footer.php";
?>

<!--DATATABLE BUTTONS DATA EXPORT-->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script>
	var url = "<?=base_url()?>";
	var url2 = "<?=base_url()?>index.php/";
	var urlimg = "<?=base_url()?>img/";
</script>
<script>

	var lista_clientes;
	$(document).ready(function(){
		userType = <?= $this->session->userdata('inicio_sesion')["id_rol"] ?> ;
		$('#tabla_clientes thead tr:eq(0) th').each( function (i){
			var title = $(this).text();
			$(this).html( '<input type="text" style="width:90%;" placeholder="'+title+'" /><label style="visibility:hidden">'+title+'</label>' );
			$('input', this).on('keyup change', function() {
				if (lista_clientes.column(i).search() !== this.value ) {
					lista_clientes
						.column(i)
						.search( this.value )
						.draw();

					var total = 0;
					var index = lista_clientes.rows( { selected: true, search: 'applied' } ).indexes();
					var data = lista_clientes.rows( index ).data();
				}
			});
		});

		var today = new Date();
		var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
		var url = '<?=base_url()?>index.php/Clientes/clientes_activos_test/'+date+'/'+date;
		if(userType == 6 && userType == 7) updateTableControlInterno(url);
	 	else updateTable(url);

		$('[data-toggle="tooltip"]').tooltip();
		$('.toolsBtn').tooltip();

	});

	$("#report_form").on('submit', function (e){
		e.preventDefault();

		var url = '<?=base_url()?>index.php/Clientes/clientes_activos_test/'+$("#begin_date").val()+'/'+$("#end_date").val();
		if(userType == 6 && userType == 7) updateTableControlInterno(url);
		else updateTable(url);

		$.ajax({
			type: 'POST',
			url: '<?=base_url()?>index.php/clientes/getIncomeByPaymentForm',
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			beforeSend: function () {
				$('#btn_submit').attr("disabled", "disabled");
				$('#btn_submit').css("opacity", ".5");
			},
			success: function (data) {
				$('#btn_submit').prop('disabled', false);
				$('#btn_submit').css("opacity", "1");
				data = JSON.parse(data);
				//$('#tabla_activos').DataTable().ajax.reload();
				total = data['total_cash'][0]['total_pagar'] + data['total_tdc'][0]['total_pagar']+ data['total_tdd'][0]['total_pagar'] + data['total_ttb'][0]['total_pagar'];
				var total_cash = parseFloat((data['total_cash'][0]['total_pagar']==null || data['total_cash'][0]['total_pagar']=='')?0:data['total_cash'][0]['total_pagar']);
				var total_tdc = parseFloat((data['total_tdc'][0]['total_pagar']==null || data['total_tdc'][0]['total_pagar']=='')?0:data['total_tdc'][0]['total_pagar']);
				var total_tdd = parseFloat((data['total_tdd'][0]['total_pagar']==null || data['total_tdd'][0]['total_pagar']=='')?0:data['total_tdd'][0]['total_pagar']);
				var total_ttb = parseFloat((data['total_ttb'][0]['total_pagar']==null || data['total_ttb'][0]['total_pagar']=='')?0:data['total_ttb'][0]['total_pagar']);
				
				var total_venta = data['total_venta'];
				var total_final = total_cash +  total_tdc + total_tdd + total_ttb;
			
				$('#credito_print').val("$"+formatMoney(total_tdc));
				$('#debito_print').val("$"+formatMoney(total_tdd));
				$('#cash_print').val("$"+formatMoney(total_cash));
				$('#tranba_print').val("$"+formatMoney(total_ttb));
				$('#total_print').val("$"+formatMoney(total_final));
				$('#total_venta_print').val("$"+formatMoney(total_venta));

				if(userType == 6 || userType == 7)  updateTableControlInterno(url);
			 	else updateTable(url);			

				document.getElementById("ttdc").innerHTML = "$"+formatMoney(data['total_tdc'][0]['total_pagar']);
				document.getElementById("ttdd").innerHTML = "$"+formatMoney(data['total_tdd'][0]['total_pagar']);
				document.getElementById("tcash").innerHTML = "$"+formatMoney(data['total_cash'][0]['total_pagar']);
				document.getElementById("ttb").innerHTML = "$"+formatMoney(data['total_ttb'][0]['total_pagar']);
				document.getElementById("total").innerHTML = "$"+formatMoney(total_final);
				document.getElementById("total_venta").innerHTML = "$"+formatMoney(total_venta);

			},
			error: function () {
				$('#btn_submit').prop('disabled', false);
				$('#btn_submit').css("opacity", "1");
			}
		});
	});

	function updateTable(url) {
			lista_clientes = $('#tabla_clientes').DataTable( {
			//ajax: "ListaClientes/clientes_activos",
			ajax: url,
			dom:'Brt<"bottom-table"ip>',
			paging: true,
			info: true,
			pagingType: "full_numbers",
			autoWidth: true,
			searching: true,
			language: {
				url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
			},
			lengthChange: true,
			orderable: false,
			columnDefs: [{
				defaultContent: "-",
				targets: "_all",
				orderable: false
			}],
			destroy: true,
			buttons: [
				{
					extend: 'print',
					text: '<i class="fas fa-print mr-2"></i>',
					attr: {
						id: 'printBtn',
						class: 'toolsBtn',
						style: 'border-color: #0B5345; color: #0B5345; background-color: #FFFFFF; margin-bottom: 10px;',
						title: 'Imprimir'
					},
	                 exportOptions: {
                      columns: [0,1,2,3,4,5,6,7,8],
                    }
				},				
	            {
	                extend: 'pdf',
					text: '<i class="fas fa-file-pdf mr-2"></i>',
					attr: {
						id: 'pdfBtn',
						class: 'toolsBtn',
						style: 'border-color: #d9534f; color: #d9534f; background-color: #FFFFFF; margin-bottom: 10px;',
						title: 'Descargar archivo .pdf'
					},
					orientation: 'landscape',
	                messageTop: 'Total Efectivo: ' + $('#cash_print').val() + ' | Total Débito: ' + $('#debito_print').val() + ' | Total Crédito: ' + $('#credito_print').val() + ' | Total tranferencia bancaria: '+$('#tranba_print').val()+' | TOTAL INGRESOS: '+ $('#total_print').val()+' | TOTAL DE VENTA: '+ $('#total_venta_print').val()+ '\nFiltro aplicado:\n Inicio: '+ $('#begin_date').val()+''+'     |     Término: ' + $('#end_date').val(),
	                 exportOptions: {
                      columns: [0,1,2,3,4,5,6,7,8],
                    }

	            }

			],
			lengthMenu: [
				[10, 25, 50, -1],
				[10, 25, 50, "Todos"]
			],
			columns: [
				{
					"orderable": false,
					"data": function( d ){
						var tipo_contrato='';
						switch (d.tipo_contrato) 
						{
							  case '1':
							    tipo_contrato = 'Venta nueva';
							    break;
							  case '2':
							    tipo_contrato = 'Reventa instantanea';
							    break;
							  case '3':
							    tipo_contrato = 'Reventa';
							    break;
							  default:
							    tipo_contrato = 'No definida';
							    break;
						}
						var label_tcontrato='<label style="background-color: #1ABC9C;color: white;border-radius: 10px;font-size: 0.8em;width: 100px;" >'+tipo_contrato+'</label>&nbsp;&nbsp;';
						var label_contrato='<label style="background-color: '+(d.estatus_contrado == 5 ? '#f35555':d.estatus_contrado == 3 ? '#27AE60':'#BD98E0')+';color: white;border-radius: 10px;font-size: 0.8em;width: 100px;" > MT-0000'+d.id_contrato+(d.estatus_contrado == 5 ? '<br>(Cancelado)':d.estatus_contrado == 3 ? '<br>Liquidado':'')+'</label>&nbsp;&nbsp;';
						return '<p style="font-size: .8em"><center>'+label_contrato + '<br>'+label_tcontrato+'</center><br>' +d.cliente+'</p>';
					}
				},

				{
					"orderable": true,
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.fecha_cobro+'</p>';
					}
				},

				{
					"orderable": false,
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.vendedor+'</p>';
					}
				},
				{
					"orderable": false,
					"data": function( d ){
						var col_def = '';

						if(d.tipoTrans == '1'){
							col_def = d.totalEnganche;
						}
						else if(d.tipoTrans == '2' || d.tipoTrans == '3' || d.tipoTrans == '4'){
							col_def = d.abonado;
						}
						else{
							col_def = 'N/A';
						}
						return '<p style="font-size: .8em">$'+formatMoney(col_def)+'</p>';
					}
				},

				{
					"orderable": false,
					"data": function( d ){
						return '<p style="font-size: .8em">$'+formatMoney(d.total_pagar)+'</p>';
					}
				},
				
				{
					"orderable": false,
					"data": function( d ){
						var total_pagar_general = '';
						if(d.concepto == 'Parcialidad' || d.concepto == 'Abono a parcialidad')
						{
							total_pagar_general = '0';
						}
						else
						{
							total_pagar_general = formatMoney(d.total_pagar_gen);
						}
						return '<p style="font-size: .8em">$'+total_pagar_general+'</p>';
					}
				},

				{
					"orderable": false,
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.forma_pago+'</p>';
					}
				},

				{
					"orderable": false,
					"data": function( d ){						
						var lblConcepto = '';
						if(d.numero_pago == 0)
						{
							lblConcepto = '<p style="font-size: .8em">'+d.concepto+'</p>';
						}
						else {
							lblConcepto = '<p style="font-size: .8em">'+d.concepto +' '+d.numero_pago+'</p>';
						}
						return lblConcepto;
					}
				},
				{
					//MAJO WAS HERE
					"orderable": false,
					
					"data": function( d ){

						var compartida_new = (d.v_compartida!='' || d.v_compartida!=null)?d.v_compartida: '';
						var compartida_old = (d.v_compartida_anterior!='' || d.v_compartida_anterior!=null)?d.v_compartida_anterior: '';

						var final_result = '<p style="font-size: .8em">';
						final_result += compartida_new + ' ';
						final_result += compartida_old + ' ';
						final_result += '</p>';

						return final_result;
					}
				},
				{
					"orderable" : false,
					"data": function (d)
					{
						var button_historial = '';

						if(d.forma_pago == 'Influencer')
						{
							button_historial ='<center><label style="background-color: #c5c5c5;color: #333;border-radius: 10px;font-size: 0.7em;width: 100px;" > CONVENIO INFLUENCER</label></center>';
						}
						else {
							button_historial = '<center><button class="ver_historial" data-idContrato="'+d.id_contrato+'" data-statusContrato="'+d.estatus_contrado+'" style="height: 29px;width: 19px;border-color: #1d47b1;color: #001a85;background-color: #FFFFFF;margin-bottom: 10px;border-radius: 20px;cursor: pointer;opacity: 0.8;"><i class=" fas  mr-2 fa-history"></i></button></center>';
						}
						return button_historial;
					}
				}
			],
		});
	}

	function updateTableControlInterno(url) {
			lista_clientes = $('#tabla_clientes').DataTable( {
			//ajax: "ListaClientes/clientes_activos",
			ajax: url,
			dom:'Brt<"bottom-table"ip>',
			paging: true,
			info: true,
			pagingType: "full_numbers",
			autoWidth: true,
			searching: true,
			language: {
				url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
			},
			lengthChange: false,
			orderable: false,
			columnDefs: [{
				defaultContent: "-",
				targets: "_all",
				orderable: false
			}],
			destroy: true,
			buttons: [
				{
					extend: 'print',
					text: '<i class="fas fa-print mr-2"></i>',
					attr: {
						id: 'printBtn',
						class: 'toolsBtn',
						style: 'border-color: #212F3D; color: #212F3D; background-color: #FFFFFF; margin-bottom: 10px;',
						title: 'Imprimir'
					}
				},
	            {
	                extend: 'pdf',
					text: '<i class="fas fa-file-pdf mr-2"></i>',
					attr: {
						id: 'pdfBtn',
						class: 'toolsBtn',
						style: 'border-color: #d9534f; color: #d9534f; background-color: #FFFFFF; margin-bottom: 10px;',
						title: 'Descargar archivo .pdf'
					},
					orientation: 'landscape',
	                messageTop: 'Total Efectivo: ' + $('#cash_print').val() + ' | Total Débito: ' + $('#debito_print').val() + ' | Total Crédito: ' + $('#credito_print').val() + ' |Total Transferencia bancaria: '+$('#tranba_print').val()+' | TOTAL INGRESOS: '+ $('#total_print').val()+ '  | TOTAL DE VENTA: '+ $('#total_venta_print').val()+ '\nFiltro aplicado:\n Inicio: '+ $('#begin_date').val()+''+'     |     Término: ' + $('#end_date').val()

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
	                messageTop: 'Total Efectivo: ' + $('#cash_print').val() + ' | Total Débito: ' + $('#debito_print').val() + ' | Total Crédito: ' + $('#credito_print').val() + ' |Total Transferencia bancaria: '+$('#tranba_print').val()+' | TOTAL INGRESOS: '+ $('#total_print').val()+ '  | TOTAL DE VENTA: '+ $('#total_venta_print').val()+' | Filtro aplicado:\n Inicio: '+ $('#begin_date').val()+''+'     |     Término: ' + $('#end_date').val()
				}
			],
			lengthMenu: [
				[10, 25, 50, -1],
				[10, 25, 50, "Todos"]
			],
			columns: [
				{
					"orderable": false,
					"data": function( d ){
						var tipo_contrato='';
						switch (d.tipo_contrato) 
						{
							  case '1':
							    tipo_contrato = 'Venta nueva';
							    break;
							  case '2':
							    tipo_contrato = 'Reventa instantanea';
							    break;
							  case '3':
							    tipo_contrato = 'Reventa';
							    break;
							  default:
							    tipo_contrato = 'No definida';
							    break;
						}
						var label_tcontrato='<label style="background-color: #1ABC9C;color: white;border-radius: 10px;font-size: 0.8em;width: 100px;" >'+tipo_contrato+'</label>&nbsp;&nbsp;';
						var label_contrato='<label style="background-color: #BD98E0;color: white;border-radius: 10px;font-size: 0.8em;width: 100px;" > MT-0000'+d.id_contrato+'</label>&nbsp;&nbsp;';
						return '<p style="font-size: .8em"><center>'+label_contrato + '<br>'+label_tcontrato+'</center><br>' +d.cliente+'</p>';
						//return '<p style="font-size: .8em">'+d.cliente+'</p>';
					}
				},

				{
					"orderable": true,
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.fecha_cobro+'</p>';
					}
				},

				{
					"orderable": false,
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.vendedor+'</p>';
					}
				},


				{
					"orderable": false,
					"data": function( d ){

						var col_def = '';

						if(d.tipoTrans == '1')
						{
							col_def = d.totalEnganche;
						}
						else if(d.tipoTrans == '2' || d.tipoTrans == '3' || d.tipoTrans == '4')
						{
							col_def = d.abonado;
						}
						else{
							col_def = 'N/A';
						}
						return '<p style="font-size: .8em">$'+formatMoney(col_def)+'</p>';
					}
				},
				{
					"orderable": false,
					"data": function( d ){
						return '<p style="font-size: .8em">$'+formatMoney(d.total_pagar)+'</p>';
					}
				},
				{
					"orderable": false,
					"data": function( d ){
						var total_pagar_general = '';
						if(d.concepto == 'Parcialidad' || d.concepto == 'Abono a parcialidad')
						{
							total_pagar_general = '0';
						}
						else
						{
							total_pagar_general = formatMoney(d.total_pagar_gen);
						}
						return '<p style="font-size: .8em">$'+total_pagar_general+'</p>';
					}
				},
				{
					"orderable": false,
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.forma_pago+'</p>';
					}
				},

				{
					"orderable": false,
					"data": function( d ){						
						var lblConcepto = '';
						if(d.numero_pago == 0)
						{
							lblConcepto = '<p style="font-size: .8em">'+d.concepto+'</p>';
						}
						else {
							lblConcepto = '<p style="font-size: .8em">'+d.concepto +' '+d.numero_pago+'</p>';
						}
						return lblConcepto;
					}
				},
				{
					//MAJO WAS HERE
					"orderable": false,
					
					"data": function( d ){
						var compartida_new = (d.v_compartida!='' || d.v_compartida!=null)?d.v_compartida: '';
						var compartida_old = (d.v_compartida_anterior!='' || d.v_compartida_anterior!=null)?d.v_compartida_anterior: '';

						var final_result = '<p style="font-size: .8em">';
						final_result += compartida_new + ' ';
						final_result += compartida_old + ' ';
						final_result += '</p>';

						return final_result;
					}
				},
				{
					"orderable" : false,
					"data": function (d)
					{
						var button_historial = '';

						if(d.forma_pago == 'Influencer')
						{
							button_historial ='<center><label style="background-color: #c5c5c5;color: #333;border-radius: 10px;font-size: 0.7em;width: 100px;" > CONVENIO INFLUENCER</label></center>';
						}
						else {
							button_historial = '<center><button class="ver_historial" data-idContrato="'+d.id_contrato+'" data-statusContrato="'+d.estatus_contrado+'" style="height: 29px;width: 19px;border-color: #1d47b1;color: #001a85;background-color: #FFFFFF;margin-bottom: 10px;border-radius: 20px;cursor: pointer;opacity: 0.8;"><i class=" fas  mr-2 fa-history"></i></button></center>';
						}
						return button_historial;
					}
				}
			],
		});
	}

	$(document).on('click', '.ver_historial', function(){
		var $itself = $(this);

		var id_contrato = $itself.attr('data-idContrato');
		var estatus_contrato = $itself.attr('data-statusContrato');
		/****************INSIDE*****************/

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
		      // $("#total").html("");
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
		      		$("#btn-recurrente").addClass("d-none");     
		            $("#btn-completo").addClass("d-none");   
		            $("#btn-pu").addClass("d-none"); 

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
		    }
		    else{
		      $(".box-estado-pagos").addClass('d-none'); 
		    }





		/**************INSIDE END*****************/





		//updateTablePagos(id_contrato);
		$('#historial_modal').modal('toggle');

	});
	
	$(window).resize(function(){
		lista_clientes.columns.adjust();
	});

	document.getElementById("ttdc").innerHTML = "$"+formatMoney(ttdc);
	document.getElementById("ttdd").innerHTML = "$"+formatMoney(ttdd);
	document.getElementById("tcash").innerHTML = "$"+formatMoney(tcash);
	document.getElementById("ttb").innerHTML = "$"+formatMoney(ttb);
	document.getElementById("total").innerHTML = "$"+formatMoney(total);
	// document.getElementById("total_ventas").innerHTML = "$"+formatMoney(total_ventas);


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

</script>
</html>
