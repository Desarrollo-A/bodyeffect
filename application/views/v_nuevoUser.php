<?php
require "header.php";
$page = 'nuevo_user';
require "menu.php";
?>

<style>
	.input-body{
		background-color: #FFFFFF;
		border: 1px solid #E3E3E3;
		border-radius: 4px;
		color: #565656;
		padding: 8px 12px;
		height: 40px;    
		box-shadow: none;
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
		.has-error {
    color: #e74c3c!important;
}
</style>

<div id="modalNotification" class="modal fade" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<center><label id="finishLabelContent"></label></center>
				<center>
					<button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button>
				</center>
			</div>
		</div>
	</div>
</div>

<div class="content">
	<div class="container-fluid">
		<div class="card-header ">
            <h4 class="card-title">Administación de usuarios</h4>
            <p class="card-category">En este apartado podrás llevar a cabo la gestión de usuarios (alta y baja de registros).</p>
        </div>
		<ul class="nav nav-tabs" id="myTab" role="tablist">
		  <li class="nav-item">
		    <a class="nav-link active" id="addUser-tab" data-toggle="tab" href="#addUser" role="tab" aria-controls="addUser" aria-selected="true">Agregar</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" id="userList-tab" data-toggle="tab" href="#userList" role="tab" aria-controls="userList" aria-selected="false" onclick="javascript:$('#usersTable').DataTable().ajax.reload();">Lista</a>
		  </li>
		</ul>
		<div class="tab-content" id="myTabContent">
		  <div class="tab-pane fade show active" id="addUser" role="tabpanel" aria-labelledby="addUser-tab">
		  	<br><br>
		  	<form name="nuevo_usuario" id="nuevo_usuario" method="POST">
				<div class="row">
					<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<label>Nombre:</label>
						<input type="text" name="nombre" class="form-control input-body" required>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<label>Apellido paterno:</label>
						<input type="text" name="ap_paterno" class="form-control" required>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<label>Apellido materno:</label>
						<input type="text" name="ap_materno" class="form-control" required>
					</div>
				</div>
				<div class="row" style="padding-top: 30px;">
					<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<label>Correo:</label>
						<input type="email" onkeyup="valid(this)" id="correo" name="correo" class="form-control" required>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<label>Usuario:</label>
						<input type="text" name="usuario" class="form-control" required>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<label>Contraseña:</label>
						<input type="text" name="password" class="form-control" required>
					</div>
				</div>
				<div class="row" style="padding-top: 30px;">
					<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<label>Teléfono:</label>
						<input type="number" onkeyup="valid(this)" name="telefono" class="form-control" required>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<label>Edad:</label>
						<input type="number" onkeyup="valid(this)" name="edad" class="form-control" required>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<label>Dirección:</label>
						<input type="text" name="direccion" class="form-control" required>
					</div>
					<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top: 30px;">
						<label>Tipo de usuario</label>
						<select class="select form-control" name="tipo_usuario">
							<option value="3">Enfermero</option>
							<option value="2">Ventas</option>
							<option value="6">Control interno</option>
						</select>
					</div>

				</div>
				<div class="col col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-top: 20px;">
					<center>
						<button type="submit" class="btn btn-body" id="add_boton">Añadir</button>
					</center>
				</div>
			</form>
		  </div>
		  <div class="tab-pane fade" id="userList" role="tabpanel" aria-labelledby="userList-tab">
		  	<br><br>
		  	<div class="table-responsive">
				<div class="material-datatables">
					<table id="usersTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th style="font-size: .9em">ESTATUS</th>
								<th style="font-size: .9em">ID</th>
								<th style="font-size: .9em">NOMBRE</th>
								<th style="font-size: .9em">APELLIDO PATERNO</th>
								<th style="font-size: .9em">APELLIDO MATERNO</th>
								<th style="font-size: .9em">ACCIONES</th>
							</tr>
						</thead>
					</table><!--End table -->
				</div>
			</div>
		  </div>
		</div>
	</div>
</div>

<?php
require "footer.php";
?>
<script src="<?= base_url("assets/js/jquery.validate.js")?>"></script>

<script>

function valid(input) {
	$("#nuevo_usuario").validate({
		rules: {
			'correo': {
				required: true,
				email: true
			},
			'telefono': {
				required: true,
				number: true,
				minlength: 10,
				maxlength: 10
			},
			'edad': {
				required: true,
				number: true,
				minlength: 1,
				maxlength: 2
			}
		},
		messages: {
			'nombre':{
				required: "Nombre requerido."
			},
			'ap_paterno':{
				required: "Apellido paterno requerido."
			},
			'ap_materno':{
				required: "Apellido materno requerido."
			},
			'correo': {
				required: "Correo requerido."
			},
			'usuario':{
				required: "Usuario requerido."
			},
			'password':{
				required: "Contraseña requerida."
			},
			'direccion':{
				required: "Dirección requerida."
			},
			'telefono': {
				required: "Teléfono requerido.",
				minlength: 'Ingresa al menos 10 dígitos.',
				maxlength: "Ingresa solo 10 dígitos."
			},
			'edad': {
				required: "Edad requerida.",
				minlength: 'Ingresa al menos 1 dígito.',
				maxlength: "Ingresa una edad valida."
			}
		},
	})
}


	// $("#nuevo_usuario").on('submit', function (e) {
	// 	e.preventDefault();

	// });
$().ready(function () {
	$("#nuevo_usuario").validate({
		rules: {
			'correo': {
				required: true,
				email: true
			},
			'telefono': {
				required: true,
				number: true,
				minlength: 10,
				maxlength: 10
			},
			'edad': {
				required: true,
				number: true,
				minlength: 1,
				maxlength: 2
			}
		},
		messages: {
			'nombre':{
				required: "Nombre requerido."
			},
			'ap_paterno':{
				required: "Apellido paterno requerido."
			},
			'ap_materno':{
				required: "Apellido materno requerido."
			},
			'correo': {
				required: "Correo requerido.",
				email: "Ingresa un correo válido."
			},
			'usuario':{
				required: "Usuario requerido."
			},
			'password':{
				required: "Contraseña requerida."
			},
			'direccion':{
				required: "Dirección requerida."
			},
			'telefono': {
				required: "Teléfono requerido.",
				minlength: 'Ingresa al menos 10 dígitos.',
				maxlength: "Ingresa solo 10 dígitos."
			},
			'edad': {
				required: "Edad requerida.",
				minlength: 'Ingresa al menos 1 dígito.',
				maxlength: "Ingresa una edad valida."
			}
		},

		submitHandler: function (form) {
			var data = new FormData($(form)[0]);
			$.ajax({
				type: 'POST',
				url: '<?=base_url()?>index.php/Usuarios/addUser',
				data: data,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function () {
					$('#add_boton').attr("disabled", "disabled");
					$('#add_boton').css("opacity", ".5");

				},
				success: function (data) {
					console.log(data);
					if (data == 'true') {
						$('#add_boton').prop('disabled', false);
						$('#add_boton').css("opacity", "1");
						$('#nuevo_usuario').trigger("reset");
						jQuery("#modal_exito").modal("show");
					} else {
						$('#add_boton').prop('disabled', false);
						$('#add_boton').css("opacity", "1");
						jQuery("#modal_fail").modal("show");
					}
				},
				error: function (data) {
					$('#add_boton').prop('disabled', false);
					$('#add_boton').css("opacity", "1");
					jQuery("#modal_fail").modal("show");
				}
			});
		}
	})
});
    
    $('#usersTable thead tr:eq(0) th').each( function (i){
			var title = $(this).text();
			$(this).html( '<input type="text" style="width:90%;" placeholder="'+title+'" /><label style="visibility:hidden">'+title+'</label>' );
			$('input', this).on('keyup change', function() {
				if (userList.column(i).search() !== this.value ) {
					userList
						.column(i)
						.search( this.value )
						.draw();

					var total = 0;
					var index = userList.rows( { selected: true, search: 'applied' } ).indexes();
					var data = userList.rows( index ).data();
				}
			});
		});

    userList = $('#usersTable').DataTable({
            ajax: "getUsersList",
            dom: 'Brt<"bottom-table"ip>',
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
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
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
                    messageTop: 'Total Efectivo: ' + $('#cash_print').val() + ' | Total Débito: ' + $('#debito_print').val() + ' | Total Crédito: ' + $('#credito_print').val() + ' | Total tranferencia bancaria: ' + $('#tranba_print').val() + ' | TOTAL INGRESOS: ' + $('#total_print').val() + ' | TOTAL DE VENTA: ' + $('#total_venta_print').val() + '\nFiltro aplicado:\n Inicio: ' + $('#begin_date').val() + '' + '     |     Término: ' + $('#end_date').val(),
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    }

                }

            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            columns: [
                {
                    "data": function (d) {
                        let estatus = '';
                        switch (d.estatus) {
                            case '1':
                        		estatus = '<label style="background-color: #28B463;color: white;border-radius: 10px;font-size: 0.8em;width: 100px;" >Vigente</label>&nbsp;&nbsp;';
                                break;
                            case '0':
                        		estatus = '<label style="background-color: #2C3E50;color: white;border-radius: 10px;font-size: 0.8em;width: 100px;" >Sin vigencia</label>&nbsp;&nbsp;';
                                break;
                        }                        
                        return '<p style="font-size: .8em"><center>' + estatus + '</center></p>';
                    }
                },

                {
                    "data": function (d) {
                        return '<p style="font-size: .8em">' + d.id_usuario + '</p>';
                    }
                },

                {
                    "data": function (d) {
                        return '<p style="font-size: .8em">' + d.nombre + '</p>';
                    }
                },
                {
                    "data": function (d) {
                        return '<p style="font-size: .8em">' + d.apellido_paterno + '</p>';
                    }
                },
                {
                    "data": function (d) {
                        return '<p style="font-size: .8em">' + d.apellido_materno + '</p>';
                    }
                },
                {
                    "data": function (d) {
                    	let button;
                    	if (d.estatus == 1) {
                    		button = '<center><button class="change-user-status" data-estatus="0" data-id-usuario="' + d.id_usuario + '" style="height: 29px;width: 19px;border-color: #28B463;color: #28B463;background-color: #FFFFFF;margin-bottom: 10px;border-radius: 20px;cursor: pointer;opacity: 0.8;"><i class="fas fa-lock-open"></i></button></center>';
                    	} else if (d.estatus == 0) {
                    		button = '<center><button class="change-user-status" data-estatus="1" data-id-usuario="' + d.id_usuario + '" style="height: 29px;width: 19px;border-color: #566573;color: #566573;background-color: #FFFFFF;margin-bottom: 10px;border-radius: 20px;cursor: pointer;opacity: 0.8;"><i class="fas fa-lock"></i></button></center>';
                    	}
                        return button;
                    }
                }
            ],
        });
	
	$(document).on('click', '.change-user-status', function() {
	    estatus = $(this).attr("data-estatus");
	    $.ajax({
	        type: 'POST',
	        url: 'changeUserStatus',
	        data: {'id_usuario': $(this).attr("data-id-usuario"), 'estatus': $(this).attr("data-estatus")},
	        dataType: 'json',
	        success: function(data){
	            if( data == 1 ){
	            	document.getElementById("finishLabelContent").innerHTML = estatus == 1 ? "Registro activado con éxito." : "Registro desactivado con éxito.";
	            	jQuery("#modalNotification").modal("show");
	                userList.ajax.reload();
	            }else{
	            	document.getElementById("finishLabelContent").innerHTML = "Oops, algo salió mal.";
	            	jQuery("#modalNotification").modal("show");
	            }
	        },error: function( ){
	            document.getElementById("finishLabelContent").innerHTML = "Oops, algo salió mal.";
	            jQuery("#modalNotification").modal("show");
	        }
	    });
	});

</script>
