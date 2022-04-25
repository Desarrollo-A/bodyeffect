<?php
require "header.php";
$page = 'reportes';
require "menu.php";
?>
<link href="<?= base_url("assets/css/v_Caja.css")?>" rel="stylesheet" />

<style>
  #tabla_hoy_filter{
    display: none;
  }
  #tabla_mañana_filter{
    display: none;
  }
  #tabla_vencidos_filter{
    display: none;
  }

  #tabla_hoy_paginate{
    display: none;
  }
  #tabla_mañana_paginate{
    display: none;
  }
  #tabla_vencidos_paginate{
    display: none;
  }
  .nav-reportes{
    background-color: #BD98E0!important;
    border-radius: 4px!important;
	margin:0!important;
  }
  .nav-reportes:hover{
    color:#e0cbb5;
  }

  .btn-cir {
    border-radius: 50%;
    border-width: 1px; 
    border-style: solid; 
    margin-right:2px;
  } 

 #pills-profile-tab:hover{
 
    background-color: red;
  }

  .dt-buttons{
	  margin:0;
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
										<h4 class="card-title">Reportes de pagos</h4>
										<p class="card-category">En este apartado podrás ver a detalle los pagos vencidos y pagos pendientes de clientes que no han abonado su <b>pago correspondiente al día de hoy o mañana</b> y de esta manera <b>notificarle</b> al cliente, de otra manera no se le podrá otorgar la sesión.</p>
									</div>																		
									<div class="container-fluid m-0 p-0">
										<div class="row">
											<div class="col-sm-4">                    
												<a class="nav-link nav-reportes" id="pills-home-tab" data-toggle="pill" style="position: relative;top:50px;color:white; font-size:14px; text-align:center" href="#pagos_pendientes_cita_hoy"  role="tab" aria-controls="pills-home" aria-selected="true">CLIENTES PAGO PENDIENTE CITA HOY</a>                            
											</div>
											<div class="col-sm-4 p-0">                            
												<a class="nav-link nav-reportes" id="pills-profile-tab" data-toggle="pill" style="position: relative;top: 50px;color:white; font-size:14px; text-align:center;" href="#pagos_autoriza_dg_cheques" role="tab" aria-controls="pills-profile" aria-selected="false">CLIENTES PAGO PENDIENTE CITA MAÑANA</a>                            
											</div>
											<div class="col-sm-4">                            
												<a class="nav-link nav-reportes" id="pills-contact-tab" data-toggle="pill" style="position: relative;top: 50px;color:white; font-size:14px; text-align:center;" href="#pagos_autorizatrd" role="tab" aria-controls="pills-contact" aria-selected="false">CLIENTES PAGO VENCIDO</a>                            
											</div>
										</div><!-- END row-->
									</div><!-- END container -->											
                  					<br><br><br><br><br>
									<div>
										<div  id="pagos_pendientes_cita_hoy">
											<div class="row">
												<div class="col-lg-12">
													<table id="tabla_reportes" class="table table-striped table-bordered" cellspacing="0" width="100%" name="tabla_hoy">
														<thead>
														<th style="font-size: .9em">CLIENTE</th>
														<th style="font-size: .9em">HORA CITA</th>
														<th style="font-size: .9em">VENCIDO</th>
														<th style="font-size: .9em">FECHA DE PAGO</th>
														<th style="font-size: .9em">TELÉFONO</th>
														<th style="font-size: .9em">COSTO PAQ.</th>
														<th style="font-size: .9em">PAGADO</th>
														</tr>
														</thead>
													</table>
												</div>
											</div>
										</div>										
									</div>
								</div> <!-- End card-body-->
							</div> <!-- End div calss="" -->
						</div> <!-- End box-header with-border -->
					</div> <!-- End tab content box-body -->
				</div> <!--End tab box-->
			</div> <!-- end col -->
		</div> <!-- End row -->
	</div> <!-- End container-fluid -->
</div> <!-- End content -->
<?php
require "footer.php";
?>
 <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script>

var tota2 = 0;

$("#tabla_reportes").ready(function () {
	tabla_reportes = $("#tabla_reportes").DataTable({
		"ajax": "Reportes/get_pagos_pen_hoy",
		//"ajax": "Reportes/get_citas_hoy",
		// dom: '<"bottom"i>rt<"top"flp><"clear">',

		"paging": true,
		"autoWidth": true,
		"searching": false,
		"lengthChange": false,
		"orderable": false,
		"bInfo": false,
		"columnDefs": [{
			"orderable": false,
			"targets": 5
		}],
		dom: "<'row col-md-12'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
				"<'row col-md-12'<'col-sm-12'rt>>" +
				"<'row col-md-6'i><'row col-md-6 d-flex justify-content-end'p>",
		language: {
				"decimal": "",
				"emptyTable": "No hay información",
				"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
				"infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
				"infoFiltered": "(Filtrado de _MAX_ total entradas)",
				"infoPostFix": "",
				"thousands": ",",
				"lengthMenu": "Mostrar _MENU_ Entradas",
				"loadingRecords": "Cargando...",
				"processing": "Procesando...",
				"search": "Buscar:",
				"zeroRecords": "Sin resultados encontrados",
				"paginate": {
					"first": "Primero",
					"last": "Ultimo",
					"next": "Siguiente",
					"previous": "Anterior"
				}
			},
		buttons: [{
				extend: 'print',
				text: '<i class="fas fa-print mr-2"></i>',
				attr: {
					id: 'printBtn',
					class: 'toolsBtn',
					style: 'border-color: #0B5345; color: #0B5345; background-color: #FFFFFF; margin-bottom: 10px;position: relative;top: -50px;z-index:99;',
					title: 'Imprimir'
				}
			},
			{
				extend: 'pdf',
				text: '<i class="fas fa-file-pdf mr-2"></i>',
				attr: {
					id: 'pdfBtn',
					class: 'toolsBtn',
					style: 'border-color: #d9534f; color: #d9534f; background-color: #FFFFFF; margin-bottom: 10px;position: relative;top: -50px;z-index:99;',
					title: 'Descargar archivo .pdf'
				}
			},
			{
				extend: 'excel',
				text: '<i class="fas fa-file-excel mr-2"></i>',
				attr: {
					id: 'excelBtn',
					class: 'toolsBtn',
					style: 'border-color: #21AB17; color: #21AB17; background-color: #FFFFFF; margin-bottom: 10px;position: relative;top: -50px;z-index:99;',
					title: 'excel .xlsx'
				}
			}
		],
		"columns": [{
				"width": "17%",
				"data": function (d) {
					return '<p style="font-size: .8em"><b>' + d.cliente + '</b></p>';
				}
			},
			{
				"width": "15%",
				"data": function (d) {
					return '<p style="font-size: .8em">' + d.Cita + '</p>';
				}
			},
			{
				"width": "19%",
				"data": function (d) {
					return '<p style="font-size: .8em">$' + formatMoney(d.vencido) + '</p>';
				}
			},
			{
				"width": "15%",
				"data": function (d) {
					return '<p style="font-size: .8em">' + d.fecha_pago + '</p>';
				}
			},
			{
				"width": "7%",
				"data": function (d) {
					return '<p style="font-size: .8em">' + d.telefono + '</p>';
				}
			},
			{
				"width": "14%",
				"data": function (d) {
					return '<p style="font-size: .8em">$' + formatMoney(d.cantidad)+ '</p>';
				}
			},
			{
				"width": "13%",
				"data": function (d) {

					if (d.pagado != 'NULL') {
						return '<p style="font-size: .8em">$' + formatMoney(parseFloat(d.enganche + d.pagado))+ '</p>';
					} else {
						return '<p style="font-size: .8em">$' + formatMoney(d.enganche)+ '</p>';
					}
				}
			}
		],
	});
	// pendientes_hoy.ajax.reload();
});

// FUNCIONES REQUERIDAS PARA BOTONES
//FIN DE FUNCIONES REQUERIDAS PARA BOTONES
//INICIA TABLA 2  
//   $("#tabla_mañana").ready( function () {
// });
$('#pills-home-tab').on('click', function (event) {
	tabla_reportes.destroy();
	tabla_reportes = $("#tabla_reportes").DataTable({
		"ajax": "Reportes/get_pagos_pen_hoy",
		"paging": true,
		"autoWidth": true,
		"searching": false,
		"lengthChange": false,
		"orderable": false,
		"bInfo": false,
		"columnDefs": [{
			"orderable": false,
			"targets": 5
		}],
		dom: "<'row col-md-12'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
				"<'row col-md-12'<'col-sm-12'rt>>" +
				"<'row col-md-6'i><'row col-md-6 d-flex justify-content-end'p>",
		language: {
				"decimal": "",
				"emptyTable": "No hay información",
				"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
				"infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
				"infoFiltered": "(Filtrado de _MAX_ total entradas)",
				"infoPostFix": "",
				"thousands": ",",
				"lengthMenu": "Mostrar _MENU_ Entradas",
				"loadingRecords": "Cargando...",
				"processing": "Procesando...",
				"search": "Buscar:",
				"zeroRecords": "Sin resultados encontrados",
				"paginate": {
					"first": "Primero",
					"last": "Ultimo",
					"next": "Siguiente",
					"previous": "Anterior"
				}
			},
		buttons: [{
				extend: 'print',
				text: '<i class="fas fa-print mr-2"></i>',
				attr: {
					id: 'printBtn',
					class: 'toolsBtn',
					style: 'border-color: #0B5345; color: #0B5345; background-color: #FFFFFF; margin-bottom: 10px;position: relative;top: -50px;z-index:99;',
					title: 'Imprimir'
				}
			},
			{
				extend: 'pdf',
				text: '<i class="fas fa-file-pdf mr-2"></i>',
				attr: {
					id: 'pdfBtn',
					class: 'toolsBtn',
					style: 'border-color: #d9534f; color: #d9534f; background-color: #FFFFFF; margin-bottom: 10px;position: relative;top: -50px;z-index:99;',
					title: 'Descargar archivo .pdf'
				}
			},
			{
				extend: 'excel',
				text: '<i class="fas fa-file-excel mr-2"></i>',
				attr: {
					id: 'excelBtn',
					class: 'toolsBtn',
					style: 'border-color: #21AB17; color: #21AB17; background-color: #FFFFFF; margin-bottom: 10px;position: relative;top: -50px;z-index:99;',
					title: 'excel .xlsx'
				}
			}
		],
		"columns": [{
				"width": "17%",
				"data": function (d) {
					return '<p style="font-size: .8em"><b>' + d.cliente + '</b></p>';
				}
			},
			{
				"width": "15%",
				"data": function (d) {
					return '<p style="font-size: .8em">' + d.Cita + '</p>';
				}
			},
			{
				"width": "19%",
				"data": function (d) {
					return '<p style="font-size: .8em">$' + formatMoney(d.vencido) + '</p>';
				}
			},
			{
				"width": "15%",
				"data": function (d) {
					return '<p style="font-size: .8em">' + d.fecha_pago + '</p>';
				}
			},
			{
				"width": "7%",
				"data": function (d) {
					return '<p style="font-size: .8em">' + d.telefono + '</p>';
				}
			},
			{
				"width": "14%",
				"data": function (d) {
					return '<p style="font-size: .8em">$' + formatMoney(d.cantidad) + '</p>';
				}
			},
			{
				"width": "13%",
				"data": function (d) {

					if (d.pagado != 'NULL') {
						return '<p style="font-size: .8em">$' + formatMoney(parseFloat(d.enganche + d.pagado)) + '</p>';
					} else {
						return '<p style="font-size: .8em">$' + formatMoney(d.enganche) + '</p>';
					}
				}
			}
		],

	});
})

$('#pills-profile-tab').on('click', function (event) {
	tabla_reportes.destroy();
	tabla_reportes = $("#tabla_reportes").DataTable({
		"ajax": "Reportes/get_pagos_pen_manana",
		"paging": true,
		"autoWidth": true,
		"searching": false,
		"lengthChange": false,
		"orderable": false,
		"bInfo": false,
		"columnDefs": [{
			"orderable": false,
			"targets": 5
		}],
		dom: "<'row col-md-12'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
				"<'row col-md-12'<'col-sm-12'rt>>" +
				"<'row col-md-6'i><'row col-md-6 d-flex justify-content-end'p>",
		language: {
				"decimal": "",
				"emptyTable": "No hay información",
				"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
				"infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
				"infoFiltered": "(Filtrado de _MAX_ total entradas)",
				"infoPostFix": "",
				"thousands": ",",
				"lengthMenu": "Mostrar _MENU_ Entradas",
				"loadingRecords": "Cargando...",
				"processing": "Procesando...",
				"search": "Buscar:",
				"zeroRecords": "Sin resultados encontrados",
				"paginate": {
					"first": "Primero",
					"last": "Ultimo",
					"next": "Siguiente",
					"previous": "Anterior"
				}
			},
		buttons: [{
				extend: 'print',
				text: '<i class="fas fa-print mr-2"></i>',
				attr: {
					id: 'printBtn',
					class: 'toolsBtn',
					style: 'border-color: #0B5345; color: #0B5345; background-color: #FFFFFF; margin-bottom: 10px;position: relative;top: -50px;z-index:99;',
					title: 'Imprimir'
				}
			},
			{
				extend: 'pdf',
				text: '<i class="fas fa-file-pdf mr-2"></i>',
				attr: {
					id: 'pdfBtn',
					class: 'toolsBtn',
					style: 'border-color: #d9534f; color: #d9534f; background-color: #FFFFFF; margin-bottom: 10px;position: relative;top: -50px;z-index:99;',
					title: 'Descargar archivo .pdf'
				}
			},
			{
				extend: 'excel',
				text: '<i class="fas fa-file-excel mr-2"></i>',
				attr: {
					id: 'excelBtn',
					class: 'toolsBtn',
					style: 'border-color: #21AB17; color: #21AB17; background-color: #FFFFFF; margin-bottom: 10px;position: relative;top: -50px;z-index:99;',
					title: 'excel .xlsx'
				}
			}
		],
		"columns": [
			{
				"width": "17%",
				"data": function (d) {
					return '<p style="font-size: .8em"><b>' + d.cliente + '</b></p>';
				}
			},
			{
				"width": "15%",
				"data": function (d) {
					return '<p style="font-size: .8em">' + d.Cita + '</p>';
				}
			},
			{
				"width": "19%",
				"data": function (d) {
					return '<p style="font-size: .8em">$' + formatMoney(d.vencido)+ '</p>';
				}
			},
			{
				"width": "15%",
				"data": function (d) {
					return '<p style="font-size: .8em">' + d.fecha_pago + '</p>';
				}
			},
			{
				"width": "7%",
				"data": function (d) {
					return '<p style="font-size: .8em">' + d.telefono + '</p>';
				}
			},
			{
				"width": "14%",
				"data": function (d) {
					return '<p style="font-size: .8em">$' + formatMoney(d.cantidad) + '</p>';
				}
			},
			{
				"width": "13%",
				"data": function (d) {
					if (d.pagado != 'NULL') {
						return '<p style="font-size: .8em">$' + formatMoney(parseFloat(d.enganche + d.pagado)) + '</p>';
					} else {
						return '<p style="font-size: .8em">$' + formatMoney(d.enganche) + '</p>';
					}
				}
			}
		],

	});
})

$('#pills-contact-tab').on('click', function (event) {
	tabla_reportes.destroy();
	tabla_reportes = $("#tabla_reportes").DataTable({
		"ajax": "Reportes/get_pagos_pen",
		"paging": true,
		"autoWidth": true,
		"searching": false,
		"lengthChange": false,
		"orderable": false,
		"bInfo": false,
		"columnDefs": [{
			"orderable": false,
			"targets": 5
		}],
		dom: "<'row col-md-12'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
				"<'row col-md-12'<'col-sm-12'rt>>" +
				"<'row col-md-6'i><'row col-md-6 d-flex justify-content-end'p>",
		language: {
				"decimal": "",
				"emptyTable": "No hay información",
				"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
				"infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
				"infoFiltered": "(Filtrado de _MAX_ total entradas)",
				"infoPostFix": "",
				"thousands": ",",
				"lengthMenu": "Mostrar _MENU_ Entradas",
				"loadingRecords": "Cargando...",
				"processing": "Procesando...",
				"search": "Buscar:",
				"zeroRecords": "Sin resultados encontrados",
				"paginate": {
					"first": "Primero",
					"last": "Ultimo",
					"next": "Siguiente",
					"previous": "Anterior"
				}
			},
		buttons: [{
				extend: 'print',
				text: '<i class="fas fa-print mr-2"></i>',
				attr: {
					id: 'printBtn',
					class: 'toolsBtn',
					style: 'border-color: #0B5345; color: #0B5345; background-color: #FFFFFF; margin-bottom: 10px;position: relative;top: -50px;z-index:99;',
					title: 'Imprimir'
				}
			},
			{
				extend: 'pdf',
				text: '<i class="fas fa-file-pdf mr-2"></i>',
				attr: {
					id: 'pdfBtn',
					class: 'toolsBtn',
					style: 'border-color: #d9534f; color: #d9534f; background-color: #FFFFFF; margin-bottom: 10px;position: relative;top: -50px;z-index:99;',
					title: 'Descargar archivo .pdf'
				}
			},
			{
				extend: 'excel',
				text: '<i class="fas fa-file-excel mr-2"></i>',
				attr: {
					id: 'excelBtn',
					class: 'toolsBtn',
					style: 'border-color: #21AB17; color: #21AB17; background-color: #FFFFFF; margin-bottom: 10px;position: relative;top: -50px;z-index:99;',
					title: 'excel .xlsx'
				}
			}
		],
		"columns": [{
				"width": "17%",
				"data": function (d) {
					var label_contrato = '<label style="background-color: #BD98E0;color: white;border-radius: 10px;font-size: 0.8em;width: 100px;" > MT-0000' + d.id_contrato + '</label>&nbsp;&nbsp;';
					return '<p style="font-size: .8em"><center><b>' + label_contrato + '<br>' + d.cliente + '</b></center></p>';
				}
			},
			{
				"width": "15%",
				"data": function (d) {
					return '<p style="font-size: .8em">' + d.Cita + '</p>';
				}
			},
			{
				"width": "19%",
				"data": function (d) {
					return '<p style="font-size: .8em">$' + formatMoney(d.vencido) + '</p>';
				}
			},
			{
				"width": "15%",
				"data": function (d) {
					return '<p style="font-size: .8em">' + d.fecha_pago + '</p>';
				}
			},
			{
				"width": "7%",
				"data": function (d) {
					return '<p style="font-size: .8em">' + d.telefono + '</p>';
				}
			},
			{
				"width": "14%",
				"data": function (d) {
					return '<p style="font-size: .8em">$' + formatMoney(d.cantidad) + '</p>';
				}
			},
			{
				"width": "13%",
				"data": function (d) {
					if (d.pagado != 'NULL') {
						return '<p style="font-size: .8em">$' + formatMoney(parseFloat(d.enganche + d.pagado)) + '</p>';
					} else {
						return '<p style="font-size: .8em">$' + formatMoney(d.enganche) + '</p>';
					}
				}
			}
		],
	});
})
// FUNCIONES REQUERIDAS PARA BOTONES
//FIN DE FUNCIONES REQUERIDAS PARA BOTONES
//INICIA TABLA 3


// $("#tabla_vencidos").ready( function () {
    
     
        //$("#tabla_hoy").ajax.reload();
      //  $("#tabla_mañana").ajax.reload();
//       $("#tabla_mañana").load(); 
//       $("#tabla_hoy").load(); 
// });
 //FIN DE FUNCIONES REQUERIDAS PARA BOTONES

 function formatMoney( n ){
  var c = isNaN(c = Math.abs(c)) ? 2 : c,
  d = d == undefined ? "." : d,
  t = t == undefined ? "," : t,
  s = n < 0 ? "-" : "",
  i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
  j = (j = i.length) > 3 ? j % 3 : 0;
  return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};
</script>

</html>
