<?php
require "statusModals.php";
?>

</head>
<link href="<?= base_url("assets/css/scrollStyles.css")?>" rel="stylesheet" />
 <style>
    .stylemenu i{
        color: #333;
    }

    .stylemenu p{
        color: #333;
    }

    .stylemenu span{
        color: #333;
        font-size: 15px;
    }
    .btn-menu:focus,.btn-menu:active {
        outline: none !important;
    }
    .modal.show .modal-dialog-e{
        -webkit-transform: translate(0,-50%);
        -o-transform: translate(0,-50%);
        transform: translate(0,-50%);
        top: 50%;
        margin: 0 auto;
    }
    #id_ticket{
        border:none;
        border-bottom: 1px solid #333;
    }
    .btn-reimprimir{
        background-color: #BD98E0!important;
        color: #fff;
        border-radius: 25px;
        border: none;
        margin-top: 10px;
    }
    .btn-reimprimir:hover{
        background-color: #fff!important;
        color: #333;
    }
    .nav-link{
        margin: 2px 15px!important;
    }
 </style>
<body>
    <div class="wrapper">
        <div class="sidebar" data-image="<?=base_url() ?>assets/img/sidebar-5.jpg">
 
            <div class="sidebar-wrapper">
                <div class="logo" style="padding:5px 15px;">
                    <a href="<?=base_url()?>" class="simple-text">
                        BODY EFFECT
                    </a>
                </div>
                <ul class="nav">
                    <li class="<?php if($page == 'inicio'){echo 'active';} ?>">
                        <a class="nav-link active" href="<?= site_url("Home")?>">
                            <i class="fas fa-home"></i>
                            <p>&nbsp;&nbsp;Inicio</p>
                        </a>
                    </li>
                    <li class="<?php if($page == 'inicio'){echo 'active';} ?>">
                        <a class="nav-link active" href="<?= site_url("Usuarios/dashboardExternal")?>">
                            <i class="fas fa-home"></i>
                            <p>&nbsp;&nbsp;Chris</p>
                        </a>
                    </li>
                    <?php
                    if ($this->session->userdata('inicio_sesion')["id_rol"] != 6 && $this->session->userdata('inicio_sesion')["id_rol"] != 7) { // TODOS LOS ROLES MENOS CONTROL INTERNO VERÁN ESTAS 4 OPCIONES DE MENÚ
                    ?>
                    <li class="<?php if($page == 'venta_nueva'){echo 'active';} ?>">
                        <a class="nav-link" href="<?= site_url("Clientes")?>"><i class='fa fa-plus-circle'></i><p>&nbsp;&nbsp;Venta nueva</p></a>
                    </li>
                    <!-- <li> -->
                    <li class="<?php if($page == 'paq_clientes'){echo 'active';} ?>">
                        <a class="nav-link" href="<?= site_url("ListaClientes")?>"><i class='fa fa-user'></i><p>&nbsp;&nbsp;Paquetes clientes</p></a>
                    </li>
                    <!-- <li> -->
                    <li class="<?php if($page == 'agenda_dep'){echo 'active';} ?>">
                        <a class="nav-link" href="<?= site_url("Agenda")?>"><i class='fa fa-calendar'></i><p>&nbsp;&nbsp;Agenda</p></a>
                    </li>
                    <li class="<?php if($page == 'print_ticket'){echo 'active';} ?>">
                        <div class="nav-link">
                            <button type="button" class="btn-menu p-0" data-toggle="modal" data-target="#modalReimprimirTk" style="border:none; background-color:transparent; color:#ffffff; font-weight:700; opacity:.86; font-size:12px; line-height:31px"><i class="far fa-copy"></i>REIMPRIMIR TICKET</button>
                        </div>
                    </li>
                        
                    <?php
                    }
                    switch ($this->session->userdata('inicio_sesion')["id_rol"]) {
                        case 1:
                            echo "<li class='"; if($page == 'cobranza'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Cobranza")."'><i class='fa fa-credit-card'></i><p>&nbsp;&nbsp;Cobranza</p></a></li>";
                            echo "<li class='"; if($page == 'expedientes'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Expedientes")."'><i class='fa fa-folder-open'></i><p>&nbsp;&nbsp;Expedientes</p></a></li>";
                            echo "<li class='"; if($page == 'caja'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Caja")."'><i class='fa fa-archive'></i><p>&nbsp;&nbsp;Consulta caja</p></a></li>";
                            echo "<li class='"; if($page == 'reportes'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Reportes")."'><i class='fa fa-bars'></i><p>&nbsp;&nbsp;Reportes </p></a></li>";
                            echo "<li class='"; if($page == 'influencer'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Clientes/ventaInfluencer")."'><i class='fa fa-star'></i><p>&nbsp;&nbsp;Intercambio </p></a></li>";
                            echo "<li class='"; if($page == 'nuevo_user'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Usuarios/nuevo_usuario")."'><i class='fa fa-user-plus'></i><p>&nbsp;&nbsp;Nuevo Usuario </p></a></li>";
                            echo "<li class='"; if($page == 'tarifas'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Tarifas")."'><i class='fa fa-usd'></i><p>&nbsp;&nbsp;Tarifas</p></a></li>";
                            echo "<li class='"; if($page == 'ticket'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='javascript: AddTicket()'><i class='fas fa-exclamation-circle'></i><p>&nbsp;&nbsp;AGREGAR TICKET</p></a></li>";

                        break;
                        case 2:
                        case 4:
                        echo "<li class='"; if($page == 'cobranza'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Cobranza")."'><i class='fa fa-credit-card'></i><p>&nbsp;&nbsp;Cobranza</p></a></li>";
                        echo "<li class='"; if($page == 'expedientes'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Expedientes")."'><i class='fa fa-folder-open'></i><p>&nbsp;&nbsp;Expedientes</p></a></li>";
                        echo "<li class='"; if($page == 'caja'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Caja")."'><i class='fa fa-archive'></i><p>&nbsp;&nbsp;Consulta caja</p></a></li>";
                        echo "<li class='"; if($page == 'reportes'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Reportes")."'><i class='fa fa-bars'></i><p>&nbsp;&nbsp;Reportes </p></a></li>";
                        echo "<li class='"; if($page == 'influencer'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Clientes/ventaInfluencer")."'><i class='fa fa-star'></i><p>&nbsp;&nbsp;Intercambio </p></a></li>";
                        echo "<li class='"; if($page == 'nuevo_user'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Usuarios/nuevo_usuario")."'><i class='fa fa-user-plus'></i><p>&nbsp;&nbsp;Nuevo Usuario </p></a></li>";
                        echo "<li class='"; if($page == 'ticket'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='javascript: AddTicket()'><i class='fas fa-exclamation-circle'></i><p>&nbsp;&nbsp;AGREGAR TICKET</p></a></li>";

                        //fa-star
                        break;
                        case 2:
                        case 4:
                        echo "<li class='"; if($page == 'cobranza'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Cobranza")."'><i class='fa fa-credit-card'></i><p>&nbsp;&nbsp;Cobranza</p></a></li>";
                        echo "<li class='"; if($page == 'caja'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Caja")."'><i class='fa fa-archive'></i><p>&nbsp;&nbsp;Consulta caja</p></a></li>";
                        echo "<li class='"; if($page == 'reportes'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Reportes")."'><i class='fa fa-bars'></i><p>&nbsp;&nbsp;Reportes </p></a></li>";
                        echo "<li class='"; if($page == 'influencer'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Clientes/ventaInfluencer")."'><i class='fa fa-star'></i><p>&nbsp;&nbsp;Intercambio </p></a></li>";
                        echo "<li class='"; if($page == 'nuevo_user'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Usuarios/nuevo_usuario")."'><i class='fa fa-user-plus'></i><p>&nbsp;&nbsp;Nuevo Usuario </p></a></li>";
                        echo "<li class='"; if($page == 'ticket'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='javascript: AddTicket()'><i class='fas fa-exclamation-circle'></i><p>&nbsp;&nbsp;AGREGAR TICKET</p></a></li>";

                        //fa-star
                        break;

                        case 3:
                        echo "<li class='"; if($page == 'cobranza'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Cobranza")."'><i class='fa fa-credit-card'></i><p>&nbsp;&nbsp;Cobranza</p></a></li>";
                        echo "<li class='"; if($page == 'expedientes'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Expedientes")."'><i class='fa fa-folder-open'></i><p>&nbsp;&nbsp;Expedientes</p></a></li>";
                        echo "<li class='"; if($page == 'influencer'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Clientes/ventaInfluencer")."'><i class='fa fa-star'></i><p>&nbsp;&nbsp;Intercambio </p></a></li>";
                        echo "<li class='"; if($page == 'ticket'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='javascript: AddTicket()'><i class='fas fa-exclamation-circle'></i><p>&nbsp;&nbsp;AGREGAR TICKET</p></a></li>";

               
                        break;


                        case 5:
                        echo "<li class='"; if($page == 'expedientes'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Expedientes")."'><i class='fa fa-folder-open'></i><p>&nbsp;&nbsp;Expedientes</p></a></li>";
                        echo "<li class='"; if($page == 'cobranza'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Cobranza")."'><i class='fa fa-credit-card'></i><p>&nbsp;&nbsp;Cobranza</p></a></li>";
                        echo "<li class='"; if($page == 'caja'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Caja")."'><i class='fa fa-archive'></i><p>&nbsp;&nbsp;Consulta caja</p></a></li>";
                        echo "<li class='"; if($page == 'reportes'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Reportes")."'><i class='fa fa-bars'></i><p>&nbsp;&nbsp;Reportes </p></a></li>";
                        echo "<li class='"; if($page == 'influencer'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Clientes/ventaInfluencer")."'><i class='fa fa-user-plus'></i><p>&nbsp;&nbsp;Intercambio </p></a></li>";
                        echo "<li class='"; if($page == 'ticket'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='javascript: AddTicket()'><i class='fas fa-exclamation-circle'></i><p>&nbsp;&nbsp;AGREGAR TICKET</p></a></li>";

                        break;
                        case 6: // CONTROL INTERNO
	                        echo "<li class='"; if($page == 'caja'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Caja")."'><i class='fa fa-archive'></i><p>&nbsp;&nbsp;Consulta caja</p></a></li>";
	                        echo "<li class='"; if($page == 'reportes'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Reportes")."'><i class='fa fa-bars'></i><p>&nbsp;&nbsp;Reportes </p></a></li>";
                             echo "<li class='"; if($page == 'detalleCobranza'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Reportes/detalleCobranza")."'><i class='fa fa-credit-card-alt'></i><p>&nbsp;&nbsp;Detalle Cobranza </p></a></li>";
                             echo "<li class='"; if($page == 'ticket'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='javascript: AddTicket()'><i class='fas fa-exclamation-circle'></i><p>&nbsp;&nbsp;AGREGAR TICKET</p></a></li>";

                        break;
                        case 7: // CONTROL INTERNO
	                        echo "<li class='"; if($page == 'caja'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='".site_url("Caja")."'><i class='fa fa-archive'></i><p>&nbsp;&nbsp;Consulta caja</p></a></li>";
                            echo "<li class='"; if($page == 'ticket'){echo 'active';} echo"'><!--<li>--><a class='nav-link active' href='javascript: AddTicket()'><i class='fas fa-exclamation-circle'></i><p>&nbsp;&nbsp;AGREGAR TICKET</p></a></li>";
	                        
	                    break;
                    }
                    ?>
                </ul>
            </div>
        </div>



        <div class="main-panel scroll-styles">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#"><b><?php echo $this->session->userdata("inicio_sesion")['nombre']; ?></span>&nbsp;-&nbsp;</b><?php echo $this->session->userdata("inicio_sesion")['rol']; ?></a>
                    <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
 
                        <ul class="navbar-nav ml-auto">


                            <li class="nav-item">
                                <a class="nav-link">
                                    <span class="no-icon">Venta diaria: $<b id="venta_diaria"></b> </span>
                                </a>
                            </li>

                             <li class="nav-item">
                                <a class="nav-link">
                                    <span class="no-icon" title="SALDO DE LUNES A DOMINGO" >Venta semanal: $<b id="venta_semanal"></b> </span>
                                </a>
                            </li>

                             <li class="nav-item dropdown">
                                <!-- <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="no-icon">Mi perfil</span>
                                </a> -->
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="<?= site_url("Ajustes")?>">&nbsp;Ajustes de cuenta&nbsp;<i class="fa fa-cog" style="color: #95E8DA;"></i></a>
                                    <div class="divider"></div>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url("Inicio/close")?>">
                                    <span class="no-icon">Cerrar sesión</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="modal fade" id="modalReimprimirTk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-e" role="document">
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-content-end p-0 pr-2">
                            <a href="<?=base_url() ?>index.php/Home">x</a>
                        </div>
                        <div class="modal-body mt-0 pt-0">                        
                            <center><label><b>Ingrese el número de ticket a reimprimir</b></label></center> 
                            <form method="post" id="reimprimirForm">
                                <div class="" style="display:grid; width:60%; margin:auto">
                                    <input type="text" name="id_ticket" id="id_ticket">
                                    <button type="submit" id="btnSubmit" class="btn btn-reimprimir">Reimprimir</button>
                                </div>                                
                            </form>
                        </div>                        
                    </div>
                </div>
            </div>
            
            <script>
            $('#modalReimprimirTk').on('shown.bs.modal', function(){
                $('#id_ticket').focus();
            });
            var general_base_url = '<?=base_url()?>';


            function AddTicket(){
          $.post("<?=base_url()?>index.php/Ajustes/ServicePostTicket", function (data) {
                    var newtab =  window.open('','Sistema de tickets', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=1000,height=400,left = 390,top = 50');
                    newtab.document.write(data);  
                          }, 'json');
                    }
            </script>