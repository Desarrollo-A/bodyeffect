var listaAreas;
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();

		listaAreas = $('#table_areas').DataTable({
			ajax:{
				"url": url2+"Areas/getAreas",
				"dataSrc": ""
			},
			dom: '<"bottom"i>rt<"top"flp><"clear">',
			paging: true,
			info: false,
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
				$('[data-toggle="tooltip"]').tooltip();
			},
			"columns": [
				{
					"data": function (d) {
						var nombre = '<center>'+d.nombre+'</center>';
						return nombre;
					}
				},
				{
					"data": function (d) {
						var tarifa = '<center>'+d.tarifa+'</center>';
						return tarifa;
					}
				},
				{
					"data": function (d) {
						var tipo = (d.tipo==1) ? 'Depilación' : 'Moldeo';
						return tipo;
					}
				},
				{

					"data": function (d) {
						var duracion = '<center>' + d.duracion + '</center>';
						return duracion;
					}
				},
				{
					"data": function (d) {
						var estatus = (d.estatus == 1) ? '<label class="label-success" class="label-success m-0" style="width: 60%;background-color: #BD98E0;color:white;border-radius: 12px; font-size: 14px">Activo</label>' : '<label class="label-success" class="label-success m-0"  style="width: 60%;background-color: #b3b3b3;color:white;border-radius: 12px; font-size: 14px">Inactivo</label>';
						return '<center>'+estatus+'</center>';
					}
				},
				{
					"data": function (d) {
						var actions = '';
						var btnEdit = '';
						var btnDelete = '';
						var btnReactivate = '';


						if(d.estatus == 1)
						{
							btnEdit = '<button class="btn btn-social btn-round btn-linkedin btn-outline editar" data-toggle="tooltip" data-placement="top" title="Editar" data-idArea="'+d.id_area+'">\n' +
								'           	<i class="fa fa-pencil"> </i>\n' +
								'			</button>';
							btnDelete = '<button class="btn btn-social btn-round btn-youtube btn-outline eliminar" data-toggle="tooltip" data-placement="top" title="Eliminar" data-idArea="'+d.id_area+'">\n' +
								'                 <i class="fa fa-trash"> </i>\n' +
								'            </button>';
							actions = '<center>'+btnEdit+'  '+btnDelete+'  </center>';
						}
						else
						{
							btnReactivate = '<button class="btn btn-social btn-round btn-linkedin btn-outline reactivar" data-toggle="tooltip" data-placement="top" title="Reactivar" data-idArea="'+d.id_area+'">\n' +
								'           	<i class="fa fa-refresh"> </i>\n' +
								'			</button>';
							actions = '<center>' + btnReactivate + '</center>';
						}

						return actions;
					}
				}
			],
		});


		$("#nuevaAreaFrm").validate({
			rules: {
				nombre : {
					required: true,
					minlength: 3
				},
				tarifa: {
					required: true,
					number: true,
					min: 18
				},
				sesiones: {
					required: true,
					number: true,
					min:1
				},
				duracion:{
					required:true
				},
				tipo:{
					required:true
				}
			},
			messages: {
				nombre:'Debes ingresar un nombre.',
				tarifa:'Debes ingresar una tarifa.',
				sesiones:'Debes ingresar un numero de sesiones.',
				duracion:'Debes ingresar la duración.',
				tipo:'Elige un tipo.'
			}
		});
	});


	function loadPartes()
	{
		$("#parteE").empty();

		var tipo = $("#tipoE").val();
		$.post(url2+"Areas/getAreasByTipo/"+tipo, function (data) {
			var $selectParte = $("#parteE");
			$.each(data, function(index, value) {
				$selectParte.append($("<option>").val(value.id_area).text(value.nombre));
			});

		}, 'json');
	}
	function checkParte()
	{
		if($('#parte_deE:checkbox:checked').length > 0)
		{
			$('#form_extraE').removeClass('hide');
			$('#noPartDiv').html('');
		}
		else {
			$('#form_extraE').addClass('hide');
			var id_area = $('#id_areaE').val();
			$('#noPartDiv').append('<input type="hidden" value="'+id_area+'" name="parteE" id="parteE"/>');
		}
	}
	$(document).on('click', '.editar', function(){
		var $itself = $(this);

		var id_area = $itself.attr('data-idArea');
		console.log('editar ' + id_area);
		$.post(url2+"Areas/get_areasById/"+id_area, function(data) {
			$('#nombreE').val(data[0].nombre);
			$('#tarifaE').val(data[0].tarifa);
			$('#sesionesE').val(data[0].no_sesion);
			$('#duracionE').val(data[0].duracion);
			$('#parteE').val(data[0].partes);
			$('#id_areaE').val(data[0].id_area);
			$("#tipoE").empty();


			$('#tipoE').append($('<option selected>').val('').text('Selecciona un tipo'));
			if(data[0].tipo == 1)
			{
				$('#tipoE').append($('<option selected>').val(1).text('Depilación'));
				$('#tipoE').append($('<option>').val(2).text('Moldeo'));
			}
			else
			{
				$('#tipoE').append($('<option>').val(1).text('Depilación'));
				$('#tipoE').append($('<option selected>').val(2).text('Moldeo'));
			}

			if(data[0].id_area != data[0].Partes)
			{
				$('#noPartDiv').html('');
				$('#parte_deE').prop('checked', true);
				$('#form_extraE').removeClass('hide');
				$("#parteE").empty();

				$.post(url2+"Areas/getAreasByTipo/"+data[0].tipo, function (data_2) {
					var $selectParte = $("#parteE");
					$.each(data_2, function(index, value) {
						if(value.id_area == data[0].Partes)
						{
							$selectParte.append($("<option selected>").val(value.id_area).text(value.nombre));
						}
						else {
							$selectParte.append($("<option>").val(value.id_area).text(value.nombre));
						}
					});

				}, 'json');
			}
			else {
				$('#form_extraE').addClass('hide');
				$('#parte_deE').prop('checked', false);
				/*añadir input hide para cuando no haya zona no sea completo*/
				$('#noPartDiv').append('<input type="hidden" value="'+data[0].id_area+'" name="parteE" id="parteE"/>');
			}

		}, 'json');

		$('#editarAreaModal').modal('toggle');

	});
	$(document).on('click', '.eliminar', function(){
		var $itself = $(this);

		var id_area = $itself.attr('data-idArea');
		$('#confirmEliminar').attr('data-idArea', id_area);
		$('#eliminar_modal').modal('toggle');
	});

	$(document).on('click', '.confirmEliminar', function(){
		var $itself = $(this);
		var id_area = $itself.attr('data-idArea');
		var data = new FormData();
		data.append('id_area', id_area);
		$.ajax({
			type: 'POST',
			url: url2+'Areas/deleteArea',
			data: data,
			dataType:'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function(){
				$('#confirmEliminar').attr("disabled","disabled");
				$('#confirmEliminar').css("opacity",".5");

			},
			success: function(data) {
				if (data.success == 1) {
					$('#confirmEliminar').prop('disabled', false);
					$('#confirmEliminar').css("opacity","1");
					$('#eliminar_modal').modal("hide");
					$('#table_areas').DataTable().ajax.reload();
					alert(data.message);
				} else {
					$('#confirmEliminar').prop('disabled', false);
					$('#confirmEliminar').css("opacity","1");
					alert(data.message);
				}
			},
			error: function(){
				$('#confirmEliminar').prop('disabled', false);
				$('#confirmEliminar').css("opacity","1");
				alert('ops, algo salió mal, intentalo de nuevo');
			}
		});
	});

	$(document).on('click', '.reactivar', function(){
		var $itself = $(this);
		var id_area = $itself.attr('data-idArea');
		var data = new FormData();
		data.append('id_area', id_area);
		$.ajax({
			type: 'POST',
			url: url2+'Areas/reactivateArea',
			data: data,
			dataType:'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function(){
				$('.reactivar').attr("disabled","disabled");
				$('.reactivar').css("opacity",".5");

			},
			success: function(data) {
				if (data.success == 1) {
					$('.reactivar').prop('disabled', false);
					$('.reactivar').css("opacity","1");
					$('#eliminar_modal').modal("hide");
					$('#table_areas').DataTable().ajax.reload();
					alert(data.message);
				} else {
					$('.reactivar').prop('disabled', false);
					$('.reactivar').css("opacity","1");
					alert(data.message);
				}
			},
			error: function(){
				$('.reactivar').prop('disabled', false);
				$('.reactivar').css("opacity","1");
				alert('ops, algo salió mal, intentalo de nuevo');
			}
		});
	});

	$("#formEditaArea").on('submit', function(e){
		e.preventDefault();

		$.ajax({
			type: 'POST',
			url: url2+'Areas/editarArea',
			data: new FormData(this),
			contentType: false,
			dataType:'json',
			cache: false,
			processData:false,
			beforeSend: function(){
				$('#saveEditArea').attr("disabled","disabled");
				$('#saveEditArea').css("opacity",".5");

			},
			success: function(data) {
				if (data.success == 1) {
					$('#saveEditArea').prop('disabled', false);
					$('#saveEditArea').css("opacity","1");
					$('#table_areas').DataTable().ajax.reload();
					alert(data.message);
				} else {
					$('#saveEditArea').prop('disabled', false);
					$('#saveEditArea').css("opacity","1");
					alert(data.message);
				}
				$('#editarAreaModal').modal("hide");
			},
			error: function(){
				$('#editarAreaModal').modal("hide");
				$('#saveEditArea').prop('disabled', false);
				$('#saveEditArea').css("opacity","1");
				alert( 'ops, algo salió mal, intentalo de nuevo');
			}
		});
	});

	/*nueva area*/
	function loadPartesNA(){
		$("#parte").empty();

		var tipo = $("#tipo").val();
		$.post(url2+"Areas/getAreasByTipo/"+tipo, function (data) {
			var $selectParte = $("#parte");
			$.each(data, function(index, value) {
				$selectParte.append($("<option>").val(value.id_area).text(value.nombre));
			});

		}, 'json');
	}
	function checkParteNA()
	{
		if($('#parte_de:checkbox:checked').length > 0)
		{
			$('#form_extra').removeClass('hide');
		}
		else {
			$('#form_extra').addClass('hide');
		}
	}
	$(document).on('click', '.add_area', function(){
		$('#addArea').modal('toggle');
	});

	$("#nuevaAreaFrm").on('submit', function(e){
	e.preventDefault();
	var isvalid = $("#nuevaAreaFrm").valid();
	if (isvalid) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: url2+'Areas/addArea',
			data: new FormData(this),
			contentType: false,
			dataType:'json',
			cache: false,
			processData:false,
			beforeSend: function(){
				$('#btnSave').attr("disabled","disabled");
				$('#btnSave').css("opacity",".5");

			},
			success: function(data) {
				if (data.success == 1) {
					$('#btnSave').prop('disabled', false);
					$('#btnSave').css("opacity","1");
					$('#table_areas').DataTable().ajax.reload();
					alert(data.message);
				} else {
					$('#btnSave').prop('disabled', false);
					$('#btnSave').css("opacity","1");
					alert(data.message);
				}
				$('#addArea').modal("hide");
				$('#nuevaAreaFrm').trigger("reset");
			},
			error: function(data){
				$('#addArea').modal("hide");
				$('#btnSave').prop('disabled', false);
				$('#btnSave').css("opacity","1");
				alert( 'ops, algo salió mal, intentalo de nuevo ['+data+']');
				$('#nuevaAreaFrm').trigger("reset");
			}
		});
	}
});