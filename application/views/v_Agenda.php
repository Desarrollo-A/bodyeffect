<?php
	require("header.php");
  $page = 'agenda_dep';
	require("menu.php");
?>
 
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="row" >
        <div class="col-md-6" style="background-color : #fff;"><!-- inicio div primero -->
          <div class="box"><!-- inicio box--> 
            <div class="box-body">
              <div class="box-header with-border">
                <div class="nav-tabs-custom"><br>                  
                </div>
              </div>

              <div class="tab-content">
                <div class="active tab-pane" id="sol_activas">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-12 pr-1">
                              <div class="form-group">
                                <label>Cliente</label>
                                <select class="form-control myselect" style="width:100%;" name="selectCliente" id="selectCliente" required/></select>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <span id="min"></span>
                            </div>               
                            <div class="col-md-12 leyenda d-none">
                              <p>Ya se ha agendado un cita anteriormente, podrá agendar nuevamente una vez que se haga el registro del <b>expediente</b> o bien,<b>cancelando la cita anterior</b>.</p>
                            </div>                      
                            <div class="col-md-6">  
                              <div class="areas_valor_d" id="areas_valor_d"></div>
                            </div>
                            <div class="col-md-6">
                              <div class="areas_valor_m" id="areas_valor_m"></div>                              
                            </div>                                                                            
                            <div class="col-md-4 pr-1" style="margin:25px">
                              <div class="opciones_valor" id="opciones_valor"></div>
                            </div>
                            <div class="col-md-4 pr-1" style="margin:25px">
                              <div class="opciones_valor_segundo" id="opciones_valor_segundo"></div>
                            </div>
                            <div class="col-md-12" style="display:flex; justify-content:flex-end">
                              <div class="opciones_boton" id="opciones_boton"></div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group"><br>
                                <p  align="justify" style="font-size: 0.8em; color: gray;"><b>NOTA:</b> Recordarle al cliente que debe ser puntal en cada una de sus citas, esto con la intención de respetar su espacio y brindarle la mejor atención.</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="tab-pane" id="historial_dp">
                  <div class="row">
                    <div class="col-lg-12">
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th style="font-size: .9em;">CLIENTE</th>
                            <th style="font-size: .9em;">HORA</th>
                            <th style="font-size: .9em;">ÁREAS</th>
                            <th style="font-size: .9em;">TELÉFONO</th>
                            <th style="font-size: .9em;"># CITA</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sons_area = $this->db->query("SELECT c.id_cliente, convert(char(5), a.hora_inicio, 108) as hora_letra, c.telefono, STRING_AGG(ar.nombre, ', ') AS valor, CONCAT(c.nombre,' ', c.apellido_paterno,' ',c.apellido_materno) AS nombrecompleto, c.telefono, count(a.id_agenda) as citas, ar.no_sesion FROM [body_effect].[dbo].[areas] AS ar INNER JOIN [body_effect].[dbo].[clientes_x_areas] AS cxa ON cxa.id_area = ar.id_area INNER JOIN [body_effect].[dbo].[clientes] AS c ON c .id_cliente = cxa.id_cliente INNER JOIN [body_effect].[dbo].[agenda] as a on a.id_cliente = c.id_cliente WHERE a.fecha_cita = CONVERT (date, GETDATE()) AND a.estatus  in (0,1,2) GROUP BY cxa.id_cliente, c.nombre, c.apellido_paterno, c.apellido_materno, c.correo, c.telefono, c.tipo, c.estatus, a.hora_inicio, a.fecha_cita, c.id_cliente, ar.no_sesion ORDER BY a.hora_inicio");

                          if($sons_area->num_rows() > 0) 
                          {
                            foreach($sons_area->result() as $row){?>
                              <tr>
                                <td style="font-size: .8em;"><?php echo $row->nombrecompleto;?></td>
                                <td style="font-size: .8em;"><?php echo $row->hora_letra;?></td>  
                                <td style="font-size: .8em;"><?php echo $row->valor;?></td>
                                <td style="font-size: .8em;"><?php echo $row->telefono;?></td>
                                <td style="font-size: .8em;"><?php echo $row->citas." - ",$row->no_sesion;?></td>
 
                              </tr> 
                              <?php       
                            }  
                          }  
                          else
                          {
                            ?>  
                            <tr>
                              <td colspan="5">Sin Registros</td>  
                            </tr>
                            <?php  
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- fin box--> 
        </div><!-- fin div primero -->

        <div class="col-md-6" style="background-color : white;">
          <div class="container"><br>
            <div id="calendar"></div><br>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!-- END content -->

<?php require("footer.php");?>  

</div>
</div>

<!-- MODALS -->
<div class="modal fade" id="myModalCitaAgendada" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="container" style="padding: 20px">
        <div class="row">
          <div class="col-md-5">
            <center><br><img src="<?= base_url("assets/img/calendar-514.png")?>" style="width:140px; height: 140px"></center>
            <div class="col-izq">
            </div>
          </div>
          <div class="col-md-7" style="display:flex; align-items:flex-end; justify-content:center;"></div>
        </div> 
        <div class="row mt-5">
          <div class="col-md-12" style="display:flex; justify-content: space-evenly"></div>
        </div>
      </div>          
    </div>
  </div>
</div>
	
<div class="modal fade" id="myModalEditarCita" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">
      <form action="#" id="form_editaCitar" method="POST" name="form_editarCita">
        <div class="container" style="padding: 20px">                                                
          <div class="row">
            <input type="text" id="id_agenda" name="id_agenda" hidden>
            <input type="text" id="id_cliente_e" name="id_cliente_e" hidden> 
            <input type="hidden" id="ar_valuee" name="ar_value">
            <input type="hidden" id="servicioe" name="servicio">
            <input type="hidden" id="duracion_minutose" name="duracion">
            <input type="hidden" id="id_contratoe" name="id_contrato"> 
            <div class="col-md-12 d-flex justify-content-center">
              <input type="datetime-local" name="fech_eleccion" id="fech_eleccione" class="form-control inputDisabled" aria-invalid="false" disabled>
            </div>
          </div>                      
          <div class="row mt-2">
            <div class="col-md-6">
                <span id="mine"></span>
              </div>   
            <div class="col-md-6 text-right">
              <i onclick="remove_dbld()" class="fas fa-edit"></i>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">  
              <div class="areas_valor_dd" id="areas_valor_dd"></div>
            </div>
            <div class="col-md-6">
              <div class="areas_valor_mm" id="areas_valor_mm"></div>                              
            </div> 
          </div>                                                                                  
          <div class="row mt-1">
            <div class="col-md-12" style="display:flex; justify-content: space-evenly">
              <button type="button" class="btn btn-body regresar_cancelar">Regresar</button>
              <button type="submit" class="btn btn-body" id="continuar_editar" disabled>Continuar</button>
            </div>
          </div>
        </div>          
      </form>
    </div>
  </div>
</div>
	
<div class="modal fade" id="myModalSeleccionarFecha" role="dialog">
  <div class="modal-dialog">			
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header p-0">					
        <center><h4 class="modal-title">Seleccione una fecha para agendar</h4></center>
      </div>
      <div class="modal-body">
        <form action="#" id="form_cambio" method="POST" name="form_fechaCita">
          <input type="datetime-local" name="fech_eleccion" id="fech_eleccion" class="form-control">
          <input type="hidden" id="colorin" name="colorin">
          <input type="hidden" id="id_cliente" name="id_cliente">
          <input type="hidden" id="ar_value" name="ar_value">
          <input type="hidden" id="servicio" name="servicio">
          <input type="hidden" id="duracion_minutos" name="duracion">
          <input type="hidden" id="id_contrato" name="id_contrato">
          <br><br>
          <div class="box-btns" style="display:flex; justify-content: space-evenly;">              
            <button type="submit" class="btn btn-body" style="width:40%">Agendar</button>
            <button type="button" class="btn btn-body" data-dismiss="modal" style="width:40%">Cerrar</button>
          </div>					
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modal_opciones" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="overflow-y: scroll; max-height:85%;  margin-top: 50px; margin-bottom:50px;">
		<div class="modal-content">
			<div class="modal-header" id="modal-header">
				<div class="modal-body" id="modal-body" style="background: #93CEC4;">
        </div>
				<div class="modal-footer" id="modal-footer">
					<br>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" tabindex="1" role="dialog" id="modal_cancelar"  aria-labelledby="myModalLabel" aria-hidden="true"> 
  <div class="modal-dialog" > 
    <div class="modal-content">
      <form method="post" id="form_cancelar">
        <div class="modal-body">
        </div>          
      </form>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="modal_contrato" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" style="overflow-y: scroll; max-height:85%;  margin-top: 50px; margin-bottom:50px;" > 
    <div class="modal-content"> 
      <div class="modal-header">
        <h4 class="modal-title nameTittle"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div> 
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <br>
      </div>
    </div>
  </div>
</div>

<!-- END MODALS -->

<!-- HTML para Spinner-->
<div id="loader" class="lds-dual-ring hidden overlay"></div>
<!-- END HTML para Spinner -->

<style>

/*** Estilos para Spinner ***/
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

/***  Estilos para Spinner ***/
  .hide{
    display: none;
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

  #a-body:hover{
    color:#333!important;
  }

  table{
    text-align:center;
  }
      
  .modal-pago{
    width: 1000px;
  }

  .modal-imprimir{
      width: 700px;
  }

  .header-fail{
    background-color: #E85656;
    color:white;
  }
  
  .header-success{
    background-color: #398439;
    color:white;
  }

  .header-warning{
    background-color: #dfa334;
    color:white;
  }

  .header-blue{
    background-color: #337cb0;
    color:white;
    text-align: center;
  }

  .header-pink{
    background-color: #73353e;
    color:white;
    text-align: center;
  }

  .centered{
    text-align:center;
  }

  .img-centered{
    display:block;
    margin:auto;
  }

  #new-color:hover{
      background-color: #E99CBA;
      color: white;
      font-size: 25px;
  }

  .btn-circle.btn-xl{
    width: 70px;
    height: 70px;
    padding: 10px 16px;
    border-radius: 35px;
    font-size: 24px;
    line-height: 1.33;
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

  .containere {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 22px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }

  /* Hide the browser's default radio button */
  .containere input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
  }

  /* Create a custom radio button */
  .checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
    border-radius: 50%;
  }

  /* On mouse-over, add a grey background color */
  .containere:hover input ~ .checkmark {
    background-color: #ccc;
  }

  /* When the radio button is checked, add a blue background */
  .containere input:checked ~ .checkmark {
    background-color: #95E8DA;
  }

  /* Create the indicator (the dot/circle - hidden when not checked) */
  .checkmark:after {
    content: "";
    position: absolute;
    display: none;
  }

  /* Show the indicator (dot/circle) when checked */
  .containere input:checked ~ .checkmark:after {
    display: block;
  }

  /* Style the indicator (dot/circle) */
  .containere .checkmark:after {
    top: 9px;
    left: 9px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: white;
  }
  
  input[type="checkbox"] {
    cursor: pointer;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    outline: 0;
    border-radius: 3px;
    border: 1px solid lightgray;
    background-color: transparent;
    height:16px;
    width: 16px;
    color: red;
  }

  input[type="checkbox"]:checked {
    background-color: #BD98E0;
    border: 1px solid #BD98E0;
  }
 
  input[type="checkbox"]:hover {
    filter: brightness(90%);
  }

  input[type="checkbox"]:disabled {
    background: #e6e6e6;
    opacity: 0.6;
    pointer-events: none;
  }

  input[type="checkbox"]:checked:after {
    display: block;
  }

  input[type="checkbox"]:disabled:after {
    border-color: #7b7b7b;
  }
 
  .modal-dialog{
      overflow-y: initial !important
  }
  
  .modal-body{
      max-height: calc(80vh - 400px);
      overflow-y: auto;
  }

  .m-p-info{
    border-radius: 7px;
    background-color: #eee;
    padding: 6px;
    margin-bottom: 10px;
  }

  .modal-header {
    display: block;
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

  #dep input[type="checkbox"]:checked {
    background-color: #BD98E0!important;
  }

  #mold input[type="checkbox"]:checked {
    background-color: #BD98E0!important;
  }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link href="<?= base_url("assets/calendar/fullcalendar.css")?>" rel="stylesheet" />
<link href="<?= base_url("assets/css/select2.min.css")?>" rel="stylesheet" />
<script src="<?= base_url("assets/calendar/moment.min.js")?>"></script>
<script src="<?= base_url("assets/calendar/fullcalendar.min.js")?>"></script>
<script src="<?= base_url("assets/js/select2.full.min.js")?>"></script>

<script>
	$(document).ready(function(){
		var calendar = $('#calendar').fullCalendar({
			editable: true,
			header:{
				left:'prev,next today',
				center:'title',
				right:'month,agendaWeek,agendaDay'
			},
			events: 'Agenda/obtener_datos',
      loading: function(isLoading, view ){
      if(isLoading) {
        $('#loader').removeClass('hidden');
      } else {
        $('#loader').addClass('hidden');
            }
     },
			selectable:true,
			selectHelper:true,
			timeFormat: 'h:mm a',

			eventClick: function(info){
				$('#myModalCitaAgendada .col-izq').html('');
				$('#myModalCitaAgendada .col-md-7').html('');
				$('#myModalCitaAgendada .col-md-12').html('');
        $('#loader').removeClass('hidden');
				var userid = info.ID;

				event.preventDefault();
				jQuery.noConflict();

				// AJAX request
				$.ajax({                          
					url: 'Agenda/datos_agenda',
					type: 'post',
					data: {userid: userid},
					success: function(response){
						var parsed_data = $.parseJSON(response);
            var dd = new Date();            
            var year = dd.getFullYear();
            var month = dd.getMonth()+1;
            if(month <= 9)  month = '0'+month;
            var date = dd.getDate();
            if(date <= 9) date = "0"+date;            
            var allDate = year + "-" + month + "-" + date;
            var fechaHoy=  allDate + " 23:59:99.999";
            var fecha = new Date(parsed_data[0].fecha_cita);
            var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }

						$('#myModalCitaAgendada .col-izq').append('<center><p class="m-0" style="color: #134563"><b>'+(fecha.toLocaleDateString('es-ES', options))+'</b></p class="m-0" style="color: #bd98e0"></center>');
						$('#myModalCitaAgendada .col-izq').append('<center><p class="m-0" style="color: #134563"><b>'+parsed_data[0].hora_letra+'</b></p class="m-0" style="color: #bd98e0"></center>');
            $('#myModalCitaAgendada .col-md-7').append('<div class="box-der">');
						$('#myModalCitaAgendada .box-der').append('<p class="m-p-info"><b>Cliente:</b> '+parsed_data[0].nombrecompleto+'</p>');
						$('#myModalCitaAgendada .box-der').append('<p class="m-p-info"><b>Teléfono:</b> '+parsed_data[0].telefono+'</p>');
						$('#myModalCitaAgendada .box-der').append('<p class="m-p-info"><b>Correo:</b> '+parsed_data[0].correo+'</p>');
						$('#myModalCitaAgendada .box-der').append('<p class="m-p-info"><b>Áreas:</b> '+parsed_data[0].valor+'</p>');
            $('#myModalCitaAgendada .col-md-7').append('</div>');
            if(parsed_data[0].estatus != 2){
              $('#myModalCitaAgendada .col-md-12').append('<input type="button" value="Cancelar cita" class="btn btn-body cancelar_cita" data-value="'+parsed_data[0].id_cliente+'" data-value1="'+parsed_data[0].nombrecompleto+'" data-value2="'+((fecha.toLocaleDateString('es-ES', options)).replace(',', '')+' a las '+formatDateHour(parsed_data[0].hora_letra))+'" data-value3="'+parsed_data[0].id_agenda+'" style="width:25%"><input type="button" class="btn btn-body editar_cita1" data-value="'+parsed_data[0].id_cliente+'" data-value2="'+parsed_data[0].id_agenda+'" data-fecha="'+fecha+'" data-hora="'+parsed_data[0].hora_letra+'" value="Editar" style="width:25%" onclick="add_dbld()"><input type="button" data-dismiss="modal" value="Cerrar" class="btn btn-body" style="width:25%">');
            }else{
              $('#myModalCitaAgendada .col-md-12').append('<input type="button" data-dismiss="modal" value="Cerrar" class="btn btn-body" style="width:40%">');
            }
            jQuery('#myModalCitaAgendada').modal('show');
            $('#loader').addClass('hidden');
					}
				});
			}
		});
	});
</script>

<script>
  $(".myselect").select2();
  $("#selectCliente").ready( function(){
    $('#loader').removeClass('hidden');
    $("#selectCliente").append('<option value="">Seleccione un cliente</option>');
    $.getJSON(  "Clientes/get_agenda_depilacion").done( function( data ){
      $.each( data, function(i, v){
        if(v.tipo == "Cliente") $("#selectCliente").append('<option value="'+v.id_cliente+'" data-value="'+v.id_cliente+'">'+v.nombre+'</option>');
        else if (v.tipo == "Influencer") $("#selectCliente").append('<option value="'+v.id_cliente+'" data-value="'+v.id_cliente+'">'+v.nombre+' ('+v.tipo+')</option>');
      });
      $('#loader').addClass('hidden');
    });
  });

    $("#selectCliente").change(function(){
    $('#loader').removeClass('hidden');
    var combo = $('#selectCliente').val();
    $("#areas_valor_d").html("");
    $("#areas_valor_m").html("");
    $("#opciones_valor").html("");
    $("#opciones_valor_segundo").html("");
    $("#opciones_boton").html("");
    $("#tipo_areas").html("");
    $('#min').text("");
    $("#opciones_boton").html("");      
    $("#opciones_valor").html("");
    $("#opciones_valor_segundo").html("");      
    $("#opciones_boton").append('<center><button class="btn btn-body btn_agendar hide">Elegir fecha</button></center>');
    $('#min').append("<input name='minutos_area' class='minutos_area' id='minutos_area' type='hidden'>");
    $(".leyenda").addClass("d-none");

    var id_cliente = $('#selectCliente').val();      	
    var element = $('#selectCliente').find('option:selected');
  
    $.getJSON( "Agenda/get_areas_depilacion/"+id_cliente).done(function( data ){
      $("#areas_valor_d").append('<div id="dep" style="color: #333;"><legend>Depilación</legend></div><br>');
      $("#areas_valor_m").append('<div id="mold" style="color: #333;"><legend>Moldeo</legend></div>');
      if(data != ''){
        $.each( data, function(i, v){        
          if(v.tipo == 1){
            $("#areas_valor_d").find("#dep").append('<input type="checkbox" name="checks[]" data-contrato="'+v.id_contrato+'" data-value="'+v.duracion+'" data-servicio="'+v.tipo+'" data-individual="'+v.tipo+'" value="'+v.id_area+'">'+' '+v.nombre+'<br>');
          }
          else if(v.tipo == 2){
            $("#areas_valor_m").find("#mold").append('<input type="checkbox" name="checks[]" data-contrato="'+v.id_contrato+'" data-value="'+v.duracion+'" data-servicio="'+v.tipo+'" data-individual="'+v.tipo+'" value="'+v.id_area+'">'+' '+v.nombre+'<br>');
          }
        });
      }
      else{
        $("#areas_valor_d").html("");
        $("#areas_valor_m").html("");
        $(".leyenda").removeClass("d-none");
      }
      $('#loader').addClass('hidden');
    });
  });

  $(document).on("click", '[name="radios2"]', function(){
    $(".checar_disponibles").prop('disabled', false);
  });

  $(document).on("click", '[name="checks[]"]', function(){
    var arr2 = $('[name="checks[]"]:checked').map(function(){
      return $(this).attr("data-value");
      //Duración
    }).get();

    var arr3 = $('[name="checks[]"]:checked').map(function(){
      return $(this).attr("value");
      //Id área
    }).get();

    var arr4 = $('[name="checks[]"]:checked').map(function(){
      return $(this).attr("data-servicio");
      //Tipo de servicio
    }).get()

    var str = arr3.join(',');
    var arr5 = $('[name="checks[]"]:checked').map(function(){
      return $(this).attr("data-individual");
      //Tipo de servicio
    }).get()
    arr5.includes('1') == true ? depi = 1:depi = 0;
    arr5.includes('2') == true ? mold = 1:mold = 0;
    depi == 1 && mold == 1 ? arr4[0] = 3: depi == 1 && mold == 0 ? arr4[0] = 1: arr4[0] = 2;
    suma = 0;
    
    for(i = 0; i < arr2.length; i++){
      suma = (suma + parseInt(arr2[i]));
    }

    $('#min').text("Duración total: "+suma+" minutos");
    $('#duracion_minutos').val(suma);
    $('#minutos_area').val(suma);
    $('#min').append("<input name='valor_areas' data-servicio="+arr4[0]+" id='valor_areas' type='hidden'  value="+str+">");

    if(suma > 0) $('.btn_agendar').removeClass('hide');
    else $('.btn_agendar').addClass('hide');

  });

  //Función para edición de cita agendada
  $(document).on("click", '[name="checkse[]"]', function(){
    calculo_checks();
  });

  function calculo_checks(){
    var arr2 = $('[name="checkse[]"]:checked').map(function(){
      return $(this).attr("data-value");
    }).get();

    var arr3 = $('[name="checkse[]"]:checked').map(function(){
      return $(this).attr("value");
    }).get();

    var arr4 = $('[name="checkse[]"]:checked').map(function(){
      return $(this).attr("data-servicio");
    }).get()

    var str = arr3.join(',');
    var arr5 = $('[name="checkse[]"]:checked').map(function(){
      return $(this).attr("data-individual");
    }).get()
    arr5.includes('1') == true ? depi = 1:depi = 0;
    arr5.includes('2') == true ? mold = 1:mold = 0;
    depi == 1 && mold == 1 ? arr4[0] = 3: depi == 1 && mold == 0 ? arr4[0] = 1: arr4[0] = 2;
    suma = 0;
    
    for(i = 0; i < arr2.length; i++){
      suma = (suma + parseInt(arr2[i]));
    }

    $('#mine').text("Duración total: "+suma+" minutos");
    $('#duracion_minutose').val(suma);
    // $('#minutos_areae').val(suma);
    $('#mine').append("<input name='valor_arease' data-servicio="+arr4[0]+" id='valor_arease' type='hidden'  value="+str+">");

    if(suma > 0) $('#continuar_editar').removeClass('hide');
    else $('#continuar_editar').addClass('hide');
    $('#loader').addClass('hidden');
  }

  $(document).on('click','.btn_agendar',function (){
      //funcion que revisa si ya habia agendado una fecha antes y calcula que dia le toca la siguiente            
				var now = new Date();
				now.setMinutes(now.getMinutes() - now.getTimezoneOffset());

				function addZero(i){
					if (i < 10) i = "0" + i;
					return i;
				}
				var now2 = new Date();
				var hours = addZero(now2.getHours()); //returns 0-23
				var minutes = addZero(now2.getMinutes()); //returns 0-59
				var seconds = addZero(now2.getSeconds());
				var val_areas = $('#valor_areas').val();    

		    //#valor_areas        
				$('#colorin').val(hours+":"+minutes+":"+seconds);
				$('#id_cliente').val(id_cliente);
				$('#ar_value').val(val_areas);
        $('#fech_eleccion').val(now.toISOString().slice(0,16));    
	
      		 
		jQuery('#myModalSeleccionarFecha').modal('show');
	});

  $(document).on("click", '[name="radios"]', function(){
    $("#opciones_boton").html("");
    estado = $('input:radio[name=radios]:checked').val();
  });

  $(document).on("click", '[name="radios2"]', function(){
    $("#opciones_boton").html("");
    estado_rango = $('input:radio[name=radios2]:checked').val();

    if(estado_rango=='1'||estado_rango=='2'){
    var id_cliente = $('#selectCliente').val();
    $("#opciones_boton").append('<center><button class="btn bg-olive checar_disponibles">Ver opciones</button></center>');
    }
    else{
      jQuery.alert("Selecciona opción");
    }
  });

  $(document).on("click", '.checar_disponibles', function(){
    var tiempo_seleccionado = $('#minutos_area').val();
    var estado_tipo_2 = 1;
    var combo = $('#selectCliente').val();

    if(estado_tipo_2=='1'){
      $.getJSON( "Agenda/fechas_para_clientes/"+estado+"/"+combo).done(function( data ){
        $.each( data, function(i, v){
          $("#modal_opciones .modal-body").html("");
          $("#modal_opciones .modal-header").html("");
          $("#modal_opciones .modal-footer").html("");
          $("#modal_opciones .modal-header").append('<br><center><label><b style="color:#60C5B3;">Disponibilidad a un mes <br> ('+tiempo_seleccionado+' min de sesión) </b></label></center><br>');

          if (estado=='1'){
            var f1 = v.valor_uno_sem;
            var f2 = v.valor_dos_sem;
            var f3 = v.valor_tres_sem;
            var fech1 = new Date(v.valor_uno_sem+'T00:00:00');
            var fech2 = new Date(v.valor_dos_sem+'T00:00:00');
            var fech3 = new Date(v.valor_tres_sem+'T00:00:00');
            const options = { year: 'numeric', month: 'short', day: 'numeric' };

            $.get( "Agenda/fechas_obtenidas_sabado/"+v.valor_uno_sem+"/"+tiempo_seleccionado+"/"+estado_rango).done(function( data ){
              data1 = JSON.parse(data);              
              $.each(data1 , function(i, v){
                $("#modal_opciones .modal-body").append('<input type="radio" value="'+v+'" data-value="'+f1+'" name="colorin"><label>&nbsp;&nbsp;'+v+"&nbsp;&nbsp;-&nbsp;&nbsp;<b>"+(fech1.toLocaleDateString('es-ES', options))+'</b></label><br>');
              });
            });

            $.get( "Agenda/fechas_obtenidas_sabado/"+v.valor_dos_sem+"/"+tiempo_seleccionado+"/"+estado_rango).done(function( data ){
              data2 = JSON.parse(data);              
              $.each(data2 , function(i, v){
                $("#modal_opciones .modal-body").append('<input type="radio" value="'+v+'" data-value="'+f2+'" name="colorin"><label>&nbsp;&nbsp;'+v+"&nbsp;&nbsp;-&nbsp;&nbsp;<b>"+(fech2.toLocaleDateString('es-ES', options))+'</b></label><br>');
              });
            });

            $.get( "Agenda/fechas_obtenidas_sabado/"+v.valor_tres_sem+"/"+tiempo_seleccionado+"/"+estado_rango).done(function( data ){
              data3 = JSON.parse(data);              
              $.each(data3 , function(i, v){
                $("#modal_opciones .modal-body").append('<input type="radio" value="'+v+'" data-value="'+f3+'" name="colorin"><label>&nbsp;&nbsp;'+v+"&nbsp;&nbsp;-&nbsp;&nbsp;<b>"+(fech3.toLocaleDateString('es-ES', options))+'</b></label><br>');
              });
            });          
          }

          if (estado=='2'){
            var f4 = v.valor_sabado;
            var f5 = v.valor_domingo;
            var fecha = new Date(v.valor_sabado+'T00:00:00');
            var fechd = new Date(v.valor_domingo+'T00:00:00');
            const options = { year: 'numeric', month: 'short', day: 'numeric' };

            $.get( "Agenda/fechas_obtenidas_sabado/"+v.valor_sabado+"/"+tiempo_seleccionado+"/"+estado_rango).done(function( data ){
              data = JSON.parse(data);
              $.each(data , function(i, v){
                $("#modal_opciones .modal-body").append('<input type="radio" value="'+v+'" name="colorin" data-value="'+f4+'" id="colorin"><label>&nbsp;&nbsp;'+v+"&nbsp;&nbsp;-&nbsp;&nbsp;<b>"+(fecha.toLocaleDateString('es-ES', options))+'</b></label><br>');
              });
            });

            $.get( "Agenda/fechas_obtenidas_sabado/"+v.valor_domingo+"/"+tiempo_seleccionado+"/"+estado_rango).done(function( data ){
              data = JSON.parse(data);
              $.each(data , function(i, v){
                $("#modal_opciones .modal-body").append('<input type="radio" value="'+v+'" name="colorin" data-value="'+f5+'" id="colorin"><label>&nbsp;&nbsp;'+v+"&nbsp;&nbsp;-&nbsp;&nbsp;<b>"+(fechd.toLocaleDateString('es-ES', options))+'</b></label><br>');
              });
            });
          }
          $("#modal-footer").append('<br><center><button type="submit" class="btn btn-success" style="margin-right: 20px;margin-top: 20px;">ACEPTAR</button><button type="button" class="btn btn-danger" onClick="cerrar_btn()" style="margin-right: 20px;margin-top: 20px;">CANCELAR</button></center><br>');
          jQuery("#modal_opciones").modal(); 
        });
      });
    }
  });

	$(document).on("click", '[name="colorin"]', function(){
	  est = $('input:radio[name=colorin]:checked').val();
	  esg = $('input:radio[name=colorin]:checked').attr("data-value");
	  var areas_listado = $('#valor_areas').val();
	  var dura_sesion = $('#minutos_area').val();

	  if(est!=''){
		$("#modal_opciones .modal-body").append('<input type="hidden" name="fech_eleccion" id="fech_eleccion" value="'+esg+'">');
		$("#modal_opciones .modal-body").append('<input type="hidden" name="ar_value" id="ar_value" value="'+areas_listado+'">');
		 $("#modal_opciones .modal-body").append('<input type="hidden" name="duracion" id="duracion" value="'+dura_sesion+'">');
	  }
	  else{
      jQuery.alert("Selecciona opción");
	  }
	});

  $(document).on("click", '.cancelar_cita', function(){
    var value_cliente = $(this).attr("data-value");
    var value_nombre = $(this).attr("data-value1");
    var value_fecha = $(this).attr("data-value2");    
    var value_agenda = $(this).attr("data-value3");

    jQuery("#myModalCitaAgendada").modal('toggle');

    $("#modal_cancelar .modal-body").html("");
    $("#modal_cancelar .modal-body").append('<p style="text-align:center">¿Está seguro que quiere cancelar la cita para <b>'+value_nombre+'</b> el día <b>'+value_fecha+'</b>?</p> <input id="agenda_cancelada" name="agenda_cancelada" value="'+value_agenda+'" type="hidden"><input id="cliente" name="cliente" value="'+value_cliente+'" type="hidden">');
    $("#modal_cancelar .modal-body").append('<div style="display:flex; justify-content:space-around;"><input type="submit" value="¡Estoy seguro!" class="btn btn-body" style="width:40%;"><input type="button" data-dismiss="modal" value="Cerrar" class="btn btn-body" style="width:40%;"></div>'); 

    jQuery("#modal_cancelar").modal(); 
  });
 
  $(document).on("click", '.editar_cita1', function(){
    $('#loader').removeClass('hidden');
    jQuery('#myModalCitaAgendada').modal('toggle');
    var id_agenda = $(this).attr("data-value2");
    var id_cliente = $(this).attr("data-value");
    var fecha = $(this).attr("data-fecha");
    var hora = $(this).attr("data-hora");
    hora = hora.split(":");
    var now = new Date(fecha);
    now.setHours(hora[0], hora[1]);
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    $('#fech_eleccione').val(now.toISOString().slice(0,16));    
    $("#id_agenda").val(id_agenda);
    $("#id_cliente_e").val(id_cliente);
    $.getJSON( "Agenda/get_areas_depilacion/"+id_cliente).done(function( data ){
      $("#areas_valor_dd").html("");
      $("#areas_valor_mm").html("");
      $("#areas_valor_dd").append('<div id="dep" style="color: #333;"><legend class="text-center">Depilación</legend></div><br>');
      $("#areas_valor_mm").append('<div id="mold" style="color: #333;"><legend class="text-center">Moldeo</legend></div><br>');

      if(data != ''){
        $.each( data, function(i, v){  
          $.getJSON( "Agenda/existencia_agenda/"+id_agenda+"/"+v.id_area).done(function( data2 ){
            if(data2 != ''){
              if(v.tipo == 1){
                $("#areas_valor_dd").find("#dep").append('<input class="inputDisabled" type="checkbox" name="checkse[]" data-value="'+v.duracion+'" data-servicio="'+v.tipo+'" data-individual="'+v.tipo+'" value="'+v.id_area+'" checked disabled>'+' '+v.nombre+'<br>');
              }
              else if(v.tipo == 2){
                $("#areas_valor_mm").find("#mold").append('<input class="inputDisabled" type="checkbox" name="checkse[]" data-value="'+v.duracion+'" data-servicio="'+v.tipo+'" data-individual="'+v.tipo+'" value="'+v.id_area+'" checked disabled>'+' '+v.nombre+'<br>');
              }
            }
            else{
              if(v.tipo == 1){
                $("#areas_valor_dd").find("#dep").append('<input class="inputDisabled" type="checkbox" name="checkse[]" data-value="'+v.duracion+'" data-servicio="'+v.tipo+'" data-individual="'+v.tipo+'" value="'+v.id_area+'" disabled>'+' '+v.nombre+'<br>');
              }
              else if(v.tipo == 2){
                $("#areas_valor_mm").find("#mold").append('<input class="inputDisabled" type="checkbox" name="checkse[]" data-value="'+v.duracion+'" data-servicio="'+v.tipo+'" data-individual="'+v.tipo+'" value="'+v.id_area+'" disabled>'+' '+v.nombre+'<br>');
              }
            }   
            calculo_checks();         
          });                         
        });
        
      }            
    });    
    jQuery("#myModalEditarCita").modal();     
  });

function formatTime(time, prefix = ""){
  return typeof time == "object" ? prefix + time.toLocaleDateString() : "";
}

function remove_dbld(){
  $('.inputDisabled').prop("disabled", false);
  $('#continuar_editar').prop("disabled", false);  
}

function add_dbld(){
  $('.inputDisabled').prop("disabled", true);
  $('#continuar_editar').prop("disabled", true);  
}

$("#form_cambio").submit( function(e){
  $('#loader').removeClass('hidden');
  var elem = document.getElementById('valor_areas');
  e.preventDefault();
  jQuery.noConflict();
  }).validate({
    submitHandler: function( form ) {
      var radio = $('[name="checks[]"]:checked').map(function(){
      return $(this).attr("data-servicio");
    }).get();
        var data = new FormData($(form)[0]);
        data.append("id_cliente", $('#selectCliente').val());
        data.append("servicio", radio);
        $.ajax({
          url: "Agenda/verificar_fecha",
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          method: 'POST',
          type: 'POST',
          success: function(response){
            if(response.length > 0){
              jQuery("#myModalSeleccionarFecha").modal('toggle');
              jQuery.confirm({
                columnClass: 'col-md-9',
                title: false,
                content: 'Ya hay una cita agendada en este horario. <br>',
                onContentReady: function () {
                    var self = this;
                    var servicio;
                    for(var x = 0;x<response.length;x++){
                      response[x].servicio == 1 ? (servicio='depilación'): response[x].servicio == 2 ? (servicio = 'moldeo'): (servicio = 'mixto');
                      self.setContentAppend('<div style="color:#333;"><strong>Cita: '+(response[x].hora_inicio).slice(0,-8)+'&nbsp;&nbsp;-&nbsp;&nbsp;'+(response[x].hora_fin).slice(0,-8)+' ('+servicio+' / '+response[x].nombre+')</strong></div>');
                    }
                    self.setContentAppend('<br>Las citas agendadas en este día son: <br>');
                    $.ajax({
                      url:  "Agenda/citas_del_dia",
                      data: data,
                      cache: false,
                      contentType: false,
                      processData: false,
                      dataType: 'json',
                      method: 'POST',
                      type: 'POST', // For jQuery < 1.9
                      success: function(res){
                        $('#loader').addClass('hidden');
                        for(var y=0;y<res.length;y++){
                          res[y].servicio == 1 ? (servicio='depilación'): res[y].servicio == 2 ? (servicio = 'moldeo'): (servicio = 'mixto');
                          self.setContentAppend('<div style="color:#333;"><strong>Cita: '+(res[y].hora_inicio).slice(0,-8)+'&nbsp;&nbsp;-&nbsp;&nbsp;'+(res[y].hora_fin).slice(0,-8)+' ('+servicio+' / '+res[y].nombre+')</strong></div>');
                        }
                      }
                    })
                  },
                  buttons: {
                      Continuar: {
                        btnClass:'btn btn-body',
                          action: function () {
                            $.ajax({
                              url:  "Agenda/agregar_datos_cita",
                              data: data,
                              cache: false,
                              contentType: false,
                              processData: false,
                              dataType: 'json',
                              method: 'POST',
                              type: 'POST', // For jQuery < 1.9
                              success: function(data){
                                if(data[0]!=true){
                                  $('#loader').addClass('hidden');
                                  jQuery.alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD, SELECCIONA UNA OPCIÓN");
                                }
                                else{
                                  jQuery("#myModalSeleccionarFecha").modal('toggle');
                                  $("#tipo_areas").html("");
                                  $("#areas_valor_d").html("");
                                  $("#areas_valor_m").html("");
                                  $("#opciones_valor").html("");
                                  $("#opciones_boton").html("");
                                  $("#opciones_valor_segundo").html("");
                                  $("#min").html("");
                                  location.reload(true);
                                  jQuery.alert("¡CITA AGENDADA EXITOSAMENTE!");
                                }
                              },error: function(){
                                jQuery.alert("ERROR EN EL SISTEMA");
                              }
                            });
                          }
                      },
                      Cancelar: {
                        btnClass:'btn btn-body',
                          action: function () {
                            jQuery('#myModalSeleccionarFecha').modal('show');
                          }
                      },
                  }
              });
            }else{
              $.ajax({
                url:  "Agenda/agregar_datos_cita",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                  $('#loader').addClass('hidden');
                  if(data[0]!=true){
                    jQuery.alert("NO SE HA PODIDO COMPLETAR LA SOLICITUD, SELECCIONA UNA OPCIÓN");
                  }
                  else{
                    jQuery("#myModalSeleccionarFecha").modal( 'toggle' );
                    $("#tipo_areas").html("");
                    $("#areas_valor_d").html("");
                    $("#areas_valor_m").html("");
                    $("#opciones_valor").html("");
                    $("#opciones_boton").html("");
                    $("#opciones_valor_segundo").html("");
                    $("#min").html("");
                    location.reload(true);
                    jQuery.alert("¡CITA AGENDADA EXITOSAMENTE!");
                  }
                  },error: function(){
                  $('#loader').addClass('hidden');
                  jQuery.alert("ERROR EN EL SISTEMA");
                }
              });
            }
          },error: function(){
            $('#loader').addClass('hidden');
            jQuery.alert("ERROR EN EL SISTEMA");
          }
        })
      }
    }); 

    $("#form_editaCitar").submit( function(e){
        $('#loader').removeClass('hidden');
        var elem = document.getElementById('valor_areas');
        e.preventDefault();
        jQuery.noConflict();
    }).validate({
        submitHandler: function( form ) {
          var radio = $('[name="checkse[]"]:checked').map(function(){
            return $(this).attr("data-servicio");
          }).get();

        var data = new FormData($(form)[0]);
        // data.append("id_cliente_e", $('#selectCliente').val());
        data.append("servicio", radio);
        $.ajax({
          url: "Agenda/verificar_fecha",
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          method: 'POST',
          type: 'POST',
          success: function(response){
            $('#loader').addClass('hidden');
            if(response.length > 0){
              jQuery.confirm({
                columnClass: 'col-md-9',
                title: false,
                content: 'Ya hay una cita agendada en este horario. <br>',
                onContentReady: function () {
                    var self = this;
                    var servicio;
                    for(var x = 0;x<response.length;x++){
                      response[x].servicio == 1 ? (servicio='depilación'): response[x].servicio == 2 ? (servicio = 'moldeo'): (servicio = 'mixto');
                      self.setContentAppend('<div style="color:#333;"><strong>Cita: '+(response[x].hora_inicio).slice(0,-8)+'&nbsp;&nbsp;-&nbsp;&nbsp;'+(response[x].hora_fin).slice(0,-8)+' ('+servicio+' / '+response[x].nombre+')</strong></div>');
                    }
                    self.setContentAppend('<br>Las citas agendadas en este día son: <br>');
                    $.ajax({
                      url:  "Agenda/citas_del_dia",
                      data: data,
                      cache: false,
                      contentType: false,
                      processData: false,
                      dataType: 'json',
                      method: 'POST',
                      type: 'POST', // For jQuery < 1.9
                      success: function(res){
                        for(var y=0;y<res.length;y++){
                          res[y].servicio == 1 ? (servicio='depilación'): res[y].servicio == 2 ? (servicio = 'moldeo'): (servicio = 'mixto');
                          self.setContentAppend('<div style="color:#333;"><strong>Cita: '+(res[y].hora_inicio).slice(0,-8)+'&nbsp;&nbsp;-&nbsp;&nbsp;'+(res[y].hora_fin).slice(0,-8)+' ('+servicio+' / '+res[y].nombre+')</strong></div>');
                        }
                      }
                    })
                  },
                  buttons: {
                      Continuar: {
                          btnClass:'btn btn-body',
                          action: function () {
                            $.ajax({
                              url:  "Agenda/update_cita",
                              data: data,
                              cache: false,
                              contentType: false,
                              processData: false,
                              dataType: 'json',
                              method: 'POST',
                              type: 'POST', // For jQuery < 1.9
                              success: function(data){
                               
                                  // jQuery("#myModalSeleccionarFecha").modal( 'toggle' );
                                  $("#tipo_areas").html("");
                                  $("#areas_valor_d").html("");
                                  $("#areas_valor_m").html("");
                                  $("#opciones_valor").html("");
                                  $("#opciones_boton").html("");
                                  $("#opciones_valor_segundo").html("");
                                  $("#min").html("");
                                  location.reload(true);
                                  jQuery.alert("¡CITA AGENDADA EXITOSAMENTE!");
                                
                              },error: function(){
                                jQuery.alert("ERROR EN EL SISTEMA");
                              }
                            });
                          }
                      },
                      Cancelar: {
                          btnClass:'btn btn-body',
                          action: function () {
                            jQuery.alert('Por favor, seleccione otra fecha.');
                          }
                      },
                  }
              });
            }else{
              $.ajax({
                url:  "Agenda/update_cita",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                 
                    // jQuery("#myModalSeleccionarFecha").modal( 'toggle' );
                    $("#tipo_areas").html("");
                    $("#areas_valor_d").html("");
                    $("#areas_valor_m").html("");
                    $("#opciones_valor").html("");
                    $("#opciones_boton").html("");
                    $("#opciones_valor_segundo").html("");
                    $("#min").html("");
                    location.reload(true);
                    jQuery.alert("¡CITA AGENDADA EXITOSAMENTE!");
                  
                },error: function(){
                  jQuery.alert("ERROR EN EL SISTEMA");
                }
              });
            }
          },error: function(){
            jQuery.alert("ERROR EN EL SISTEMA");
          }
        })
      }
    }); 

  $("#form_cancelar").submit( function(e){
    $('#loader').removeClass('hidden');
    e.preventDefault();
    jQuery.noConflict();
    }).validate({
      submitHandler: function( form ) {
        var data = new FormData($(form)[0]);        
        $.ajax({
          url:  "Agenda/cancelar_agenda",
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          method: 'POST',
          type: 'POST', // For jQuery < 1.9
          success: function(data){
            if(data[0]!=true){
              jQuery("#modal_fail").modal("show");
              $('#loader').addClass('hidden');
            }
            else{
              $('#loader').addClass('hidden');
              jQuery("#modal_cancelar").modal( 'toggle' );              
              jQuery.confirm({
                columnClass: 'col-md-4',
                title: false,
                content: '¡CITA CANCELADA!',
                buttons: {
                  Aceptar: {
                    btnClass:'btn btn-body',
                    action: function () {
                      location.reload(true);
                    }
                  }
                }
              })
            }
          },error: function(){
            $('#loader').addClass('hidden');
            jQuery("#modal_fail").modal("show");
          }
        });
      }
  }); 

  function cerrar_btn(){
    jQuery("#modal_opciones").modal('toggle');
  }

  $(document).on('click','.regresar_cancelar',function (){
    jQuery("#myModalEditarCita").modal('toggle');
    jQuery('#myModalCitaAgendada').modal();
  });

  $(document).on("click", '.visualizar_contrato', function(){
    var value_contrato =  $(this).attr("value"); 
    $("#modal_contrato .modal-body").html('');  
    $.get( "Agenda/ver_contenido/"+value_contrato).done(function( data ){
      data = JSON.parse(data);
      $.each(data , function(i, v){        
        $("#modal_contrato .modal-body").append('<embed src="<?= base_url("assets/expediente/CONTRATO/'+v.contrato+'")?>" type="application/pdf" width="100%" height="800px" />');
      });
    });
    $("#modal_contrato").modal();
  });

  function confirmAgenda() {
	  var confirmar = confirm('¿Realmente desea agendar esta cita?');
	  if (confirmar) {		  
		  $('#submit_hide').click();		  
	  }
  }
  
  function formatDateHour(date) {
    var split = date.split(':');
    var hours = split[0];
    var minutes = split[1];
    var ampm = hours >= 12 ? 'p.m.' : 'a.m.';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
  }
</script>

</body>
</html>
