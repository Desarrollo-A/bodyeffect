<?php
    require "header.php";
    $page = 'tarifas';
    require "menu.php";
?>

<link href="<?= base_url("assets/css/general_styles.css")?>" rel="stylesheet" />

<div class="content">
	<div class="container-fluid">
        <div class="card-body">
            <div class="card-header ">
                <h4 class="card-title">Lista de áreas editables</h4>
                <p class="card-category">En este apartado podrás ver todas las áreas disponibles para editar su precio y/o duración así como activar o descativar el área deseada.</p>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div class="material-datatables">
                            <table id="tabla_tarifas" class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>ESTATUS</th>
                                        <th>ID</th>
                                        <th>NOMBRE</th>
                                        <th>COSTO</th>
                                        <th>DURACIÓN</th>
                                        <th>TIPO</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                            </table><!--End table -->
                        </div>
                    </div>
                </div><!-- End col-md-12 -->
            </div> <!-- End row -->
        </div><!-- End card -->
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-e" role="document">
        <div class="modal-content">
            <div class="modal-body mt-0 pt-3">                        
                <center>
                    <label>Editar datos del área: <b class="areaNm"></b></label>
                </center> 
                <form method="post" id="editForm">
                    <input type="text" name="idArea" id="idArea" hidden>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-6">
                            <label>Costo</label>
                            <input class="inp-be" type="text" name="costo" id="costo" onkeypress="return onlyNumbers(event)" required>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6">
                            <label>Duración (minutos)</label>
                            <input class="inp-be" type="text" name="duracion" id="duracion" onkeypress="return onlyNumbers(event)" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 d-flex justify-content-end">
                            <button type="submit" id="btnSubmit" class="btn btn-reimprimir">Guardar</button>
                        </div>
                    </div>                      
                </form>
            </div>                        
        </div>
    </div>
</div>

<?php
require "footer.php";
?>
</div>
</div>

<script>
    $('#tabla_tarifas thead tr:eq(0) th').each(function (i) {
        if (i != 0 && i != 6) {
            var title = $(this).text();
            $(this).html('<input type="text" class="filtertable" placeholder="' + title + '" />');
            $( 'input', this ).on('keyup change', function () {
                if ($('#tabla_tarifas').DataTable().column(i).search() !== this.value ) {
                    $('#tabla_tarifas').DataTable().column(i).search(this.value).draw();
                }
            });
        }
    });

    tabla_tarifas = $('#tabla_tarifas').DataTable({
        ajax: {
            url: 'Tarifas/getAllAreas',
            type: "POST",
            cache: false,
        },
        dom: 'rt'+ "<'container'<'row'<'col-12 col-sm-12 col-md-6 col-lg-6'i><'col-12 col-sm-12 col-md-6 col-lg-6'p>>>",
        pagingType: "full_numbers",
        language: {
            url: "<?=base_url()?>/assets/spanishLoader_v2.json",
            paginate: {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>"
            }
        },
        pageLength: 10,
        bAutoWidth: false,
        fixedColumns: true,
        ordering: false,
        columnDefs: [
            {"orderable": false, "targets": 5}
        ],
        columns: [
            {
                "data": function (d) {
                    
                    if(d.estatus == 1){
                        label = '<i class="fa fa-circle" aria-hidden="true" style="color: #29b148;"></i>';
                    }
                    else{
                        label = '<i class="fa fa-circle" aria-hidden="true" style="color: #fb404b;"></i>';
                    }

                    return label;
                }
            },
            {
                "data": function (d) {
                    return '<p>' + d.id_area + '</p>';
                }
            },
            {
                "data": function (d) {
                    return '<p>' + d.nombre + '</p>';
                }
            },
            {
                "data": function (d) {
                    return '<p>$' + formatMoney(d.tarifa) + '</p>';
                }
            },
            {
                "data": function (d) {
                    return '<p>' + d.duracion + '</p>';
                }
            },
            {
                "data": function (d) {
                    if(d.tipo == 1){
                        return '<p>Depilación</p>';
                    }
                    else if(d.tipo == 2){
                        return '<p>Moldeo</p>';
                    }
                    else if(d.tipo == 4){
                        return '<p>Rejuvenecimiento facial</p>';
                    }
                }
            },
            {
                "data": function (d) {
                    btns = '<button class="btn-table btn-edit m-1 editArea" data-id="'+d.id_area+'" data-nombre="'+d.nombre+'" data-costo="'+d.tarifa+'" data-duracion="'+d.duracion+'"><i class="fa fa-pencil" aria-hidden="true"></i></button>';
                    if(d.estatus == 1)
                        btns += '<button class="btn-table btn-red m-1 statusArea" data-id="'+d.id_area+'"  data-estatus="'+d.estatus+'"><i class="fa fa-power-off" aria-hidden="true"></i></button>';
                    else if(d.estatus == 0)
                        btns += '<button class="btn-table btn-green m-1 statusArea" data-id="'+d.id_area+'"  data-estatus="'+d.estatus+'"><i class="fa fa-power-off" aria-hidden="true"></i></button>';
                    
                    return '<div class="d-flex justify-content-center">'+btns+'</div>';
                }
            },
        ],
    });

    $("#tabla_tarifas").on("click", ".editArea", function(e){
        nombreArea = $(this).attr("data-nombre");
        idArea = $(this).attr("data-id");
        costo = $(this).attr("data-costo");
        duracion = $(this).attr("data-duracion");

        $("#idArea").val(idArea);
        $("#costo").val(costo);
        $("#duracion").val(duracion);
        $(".areaNm").text(nombreArea);
        
        $('#modalEdit').modal('show');
    });

    $("#tabla_tarifas").on("click", ".statusArea", function(e){
        $('#loader').removeClass('hidden');
        status = $(this).attr("data-estatus");
        idArea = $(this).attr("data-id");
        (status == 1 ) ? status = 0 : status = 1;
        $.getJSON( url2 + "Tarifas/changeStatus/" + status + "/" + idArea).done( function( data ){
            if(data){
                $('#loader').addClass('hidden');
				jQuery("#modal_exito").modal("show");
            }
            else{
                $('#loader').addClass('hidden');
                jQuery("#modal_fail").modal("show");
            }
        });
    });

    function formatMoney( n ){
        var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;

        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };
    
    function onlyNumbers(e){
        key = e.keyCode || e.which;
        tecla = String.fromCharCode(key);
        letras = " 0123456789";
        especiales = [8, 37, 39, 46];

        tecla_especial = false;
        for(var i in especiales) {
            if(key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla) == -1 && !tecla_especial)
            return false;
    }

    $("#editForm").submit( function(e) {
		$('#loader').removeClass('hidden');
        e.preventDefault();
    }).validate({
        submitHandler: function( form ) {
            var data = new FormData( $(form)[0] );
            $.ajax({
                url: url2 + "Tarifas/updatePrice",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                method: 'POST',
                type: 'POST',
                success: function(data){
                    if( data ){
                        $('#modalEdit').modal('toggle');
		                $('#loader').addClass('hidden');
					    jQuery("#modal_exito").modal("show");
                    }else{
                        $('#modalEdit').modal('toggle');
		                $('#loader').addClass('hidden');
                        jQuery("#modal_fail").modal("show");
                    }
                },error: function( ){
                    $('#modalEdit').modal('toggle');
		            $('#loader').addClass('hidden');
                    jQuery("#modal_fail").modal("show");
                }
            });
        }
    });

</script>