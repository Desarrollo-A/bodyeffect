<?php
    require("header.php");
    $page = 'ajustes';
    require("menu.php");
?>

<div class="container">
  <div class="modal fade" id="modalCaambioaplicado" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div>
        <center><br><img src="<?= base_url("assets/img/userprofile.png")?>" style="width:80px; height: 80px"></center>
        </div>
        <div class="modal-body">
            <p>¡Los datos del usuario se han actualizado correctamente!</p>
        </div>
        <div class="modal-footer">
            <div class="col-md-12" align="center"><button type="button" onclick="location.reload();" class="btn btn-info" data-dismiss="modal">De acuerdo</button></div> 
        </div>
      </div>
    </div>
  </div>
</div>


<style>
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
    /* #new-color {
        background-color: #E99CBA;
    } */
    #new-color:hover {
        background-color: #E99CBA;
        color: white;
        font-size: 25px;
    }
    .btn-circle.btn-xl {
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


</style>

<div class="content">
    <div class="container-fluid">
        <!-- <div class="row"> -->
            <div class="row">
                 <div class="col-md-4" style="background-color : white;">
                    <div class="container"><br>
                        <div class="card card-user">
                            <div class="image">
                                <img src="<?= base_url("assets/img/bg-1.jpg")?>" alt="..." style="width: 100%; height: 30%;"/>
                            </div>
                            <div class="content">
                                <div class="author">
                                    <a href="#">
                                        <img class="avatar border-gray" src="<?= base_url("assets/img/perfil-1.jpg")?>" alt="..."/>
                                        <h4 class="title"><?= $datos_del_perfil[0]->nombre_completo ?><br/>
                                            <small><?= $datos_del_perfil[0]->edad ?> años</small>
                                        </h4>
                                    </a>
                                </div>
                                <p class="description text-center"><?= $datos_del_perfil[0]->correo ?> <br> </p>
                             </div>
                        </div>
                    </div>
                </div>



                <div class="col-md-8" style="background-color : #fff;"><!-- inicio div primero -->
                    <div class="box"><!-- inicio box--> 
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form method="post" id="form_cambio2">                                  
                                        <div class="header">
                                           <br><br>
                                        </div> <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Nombre (s)</label>
                                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre (s)" value="<?= $datos_del_perfil[0]->nombre ?>"> 
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Apellido paterno</label>
                                                    <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" placeholder="Apellido paterno" value="<?= $datos_del_perfil[0]->apellido_paterno ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Apellido materno</label>
                                                    <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" placeholder="Apellido materno" value="<?= $datos_del_perfil[0]->apellido_materno ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Dirección</label>
                                                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección personal" value="<?= $datos_del_perfil[0]->direccion ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Sobre mi</label>
                                                    <textarea type="text" id="aboutme" name="aboutme" class="form-control" placeholder="Describe alguna personalidad que destaques sobre los demás y que sea importante conocer."><?= $datos_del_perfil[0]->aboutme?></textarea> 
                                                </div>
                                            </div>
                                        </div>

                                         <div class="col-md-12">
                                                <div class="form-group">
                                                    <center><button type="submit" class="btn btn-info"  data-target="#modalImprimir" title="Clic en el botón para guardar la información que deseas actualizar.">Actualizar perfil</button></center>
                                                </div>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- fin box-->
                </div><!-- fin div primero -->
            </div>
        <!-- </div> -->
    </div>
</div>

 
<?php require("footer.php");?>  

<script src="<?= base_url("assets/js/jquery.validate.min.js")?>"></script>

 <script type="text/javascript">

$("#form_cambio2").submit( function(e) {
    e.preventDefault();
}).validate({
    submitHandler: function( form ) {

        var data = new FormData( $(form)[0] );
        // data.append("idautopago", idautopago);
        $.ajax({
            url: url2 + "Ajustes/actualizar_perfil",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function(data){
                    if( data[0] ){
                        jQuery.noConflict();
                        $('#modalCaambioaplicado').modal({ backdrop: 'static', keyboard: false });
                    }else{
                        jQuery("#modal_fail").modal("show");
                    }
                },error: function( ){
                    jQuery("#modal_fail").modal("show");
                }
            });
    }
});
 </script>
</body>
</html>