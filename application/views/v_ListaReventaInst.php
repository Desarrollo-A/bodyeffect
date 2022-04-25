<?php
	require("header.php");
	require("menu.php");
?>

<style>
	.btn-reventa{
		border: 1px solid #BD98E0;
		color: #BD98E0;
		border-radius: 50%;
		width: 38px;
		height: 38px;
		padding: 0;
	}
	.btn-reventa:hover{
		border: 1px solid #BD98E0;
		background-color: #BD98E0;
		color: #FFF;
	}
	.bottom-table{
		width:100%;
		display:flex;
		justify-content:space-between;
	}
	.paginate_button:hover{
		background: none!important;
		background-color: none!important;
		border: none!important;
	}
	.btn-reventa{
		outline: none!important;
		box-shadow: none!important;
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
										<h4 class="card-title"><b>Reventa instantánea</b></h4>
										<p class="card-category">En este apartado podrás ver todos aquellos clientes que han firmado contrato <b>el día de hoy</b>. De esta manera puedes escoger a cualquier cliente que se muestre en la tabla y agregar <b>nuevas áreas</b> en el contrato que previamente se ha realizado y generar uno nuevo.</p>
									</div>
									<br>
									<div class="row">
										<div class="col-md-12">
											<div id="external_filter_container18"></div>
											<div class="table-responsive">
												<div class="material-datatables">
													<table id="tabla_activos" class="table table-striped table-bordered" cellspacing="0" width="100%">
														<thead>
														<tr>
															<th style="font-size: .9em">ID</th>
															<th style="font-size: .9em">NOMBRE</th>
															<th style="font-size: .9em">AREAS</th>
															<th style="font-size: .9em"></th>
														</tr>
														</thead>
													</table><!--End table -->
												</div><!--End material-datatables-->
											</div><!-- End table-responsive-->
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

<?php
    require("footer.php");
?>  
<script>
	var reventa_instantanea;
  	$(document).ready(function(){
		
		$('#tabla_activos thead tr:eq(0) th').each( function (i){
			if( i != 3 && i != 0){
				var title = $(this).text();
				$(this).html( '<input type="text" style="width:100%;" placeholder="'+title+'" />' );
				$('input', this).on('keyup change', function() {
					if (reventa_instantanea.column(i).search() !== this.value ) {
						reventa_instantanea
							.column(i)
							.search( this.value )
							.draw();

						var index = reventa_instantanea.rows( { selected: true, search: 'applied' } ).indexes();
						var data = reventa_instantanea.rows( index ).data();
					}
				});
			}
		}); 
	});

  $("#tabla_activos").ready( function (){
    reventa_instantanea = $("#tabla_activos").DataTable({
		"ajax": "Reventa/lista_clientes",
		dom: 'Brt<"bottom-table"ip>',
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
      		lengthMenu: [
				[10, 25, 50, -1],
				[10, 25, 50, "Todos"]
			],
			columns: [
        		{
					"orderable": false,
					"width": "5%",
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.id_cliente+'</p>';
					}
				},
        		{
					"orderable": false,
					"width": "35%",
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.nombre+'</p>';
					}
				},
        		{
					"orderable": false,
					"width": "40%",
					"data": function( d ){
						return '<p style="font-size: .8em">'+d.valor+'</p>';
					}
				},
        		{ 
					"orderable": false,
					"width": "20%",
					"data": function(d){
						opciones = '<div role="group">';
						opciones += '<center><button type="button" value="'+d.id_cliente+'" class="btn-reventa btn-default reventa"><i class="fas fa-exchange-alt"></i></button></center>';
						return opciones + '</div>';
          			}
        		}
      		],
    	});
  	});

	$(document).on("click", ".reventa", function(){
		index_cliente = $(this).attr("value");
		window.location.href = "ClientesReventaInst/index/" + index_cliente;
	});

	$(window).resize(function(){
			reventa_instantanea.columns.adjust();
		});
</script>
</html>