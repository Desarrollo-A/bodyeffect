<?php
require("header.php");
$page = 'venta_nueva';
require("menu.php");
?>
<meta charset='utf-8'>
<!-- Estilos y funciones para select de áreas y multiselect (formas de pago) -->
<link href="<?= base_url("assets/css/v_VentaNueva.css") ?>" rel="stylesheet"/>
<link href="<?= base_url("assets/css/select2.min.css") ?>" rel="stylesheet"/>
<link href="<?= base_url("assets/css/bootstrap-multiselect.css") ?>" rel="stylesheet"/>
<script src="<?= base_url("assets/js/select2.full.min.js") ?>"></script>
<script src="<?= base_url("assets/js/bootstrap-multiselect.js") ?>"></script>
<script src="<?= base_url("assets/js/scanner.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/js/general.js") ?>" type="text/javascript"></script>
<!-- TIENE LAS FUNCIONES PARA RE IMPRIMIR EL TK (PARA LAS VISTAS QUE NO CARGAN EL FOOTER-->

<?php
    $id_cliente0 = "";
    $id_cliente1 = "";
    $id_cliente2 = "";
    $id_cliente3 = "";
    $id_cliente4 = "";
    $id_paquete0 = "";
    $id_paquete1 = "";
    $id_paquete2 = "";
    $id_paquete3 = "";
    $id_paquete4 = "";
    $nombre0 = "";
    $nombre1 = "";
    $nombre2 = "";
    $nombre3 = "";
    $nombre4 = "";
    $app0 = "";
    $app1 = "";
    $app2 = "";
    $app3 = "";
    $app4 = "";
    $apm0 = "";
    $apm1 = "";
    $apm2 = "";
    $apm3 = "";
    $apm4 = "";
    $correo0 = "";
    $correo1 = "";
    $correo2 = "";
    $correo3 = "";
    $correo4 = "";
    $tel0 = "";
    $tel1 = "";
    $tel2 = "";
    $tel3 = "";
    $tel4 = "";
    $domicilio0 = "";
    $domicilio1 = "";
    $domicilio2 = "";
    $domicilio3 = "";
    $domicilio4 = "";
    $areasmd0 = "";
    $areasmd1 = "";
    $areasmd2 = "";
    $areasmd3 = "";
    $areasmd4 = "";

    $areasrf0 = "";
    $areasrf1 = "";
    $areasrf2 = "";
    $areasrf3 = "";
    $areasrf4 = "";

    $clte_datail0 = "";
    $clte_datail1 = "";
    $clte_datail2 = "";
    $clte_datail3 = "";
    $clte_datail4 = "";

    $ta0 = 0;
    $ta1 = 0;
    $ta2 = 0;
    $ta3 = 0;
    $ta4 = 0;
    $total0 = 0;
    $total1 = 0;
    $total2 = 0;
    $total3 = 0;
    $total4 = 0;
    $prosaa = false;

    for ($i = 0; $i < COUNT($clientes); $i++) {
        ${"id_cliente" . $i} = $clientes[$i]->id_cliente;
        ${"nombre" . $i} = $clientes[$i]->nombre;
        ${"app" . $i} = $clientes[$i]->apellido_paterno;
        ${"apm" . $i} = $clientes[$i]->apellido_materno;
        ${"correo" . $i} = $clientes[$i]->correo;
        ${"tel" . $i} = $clientes[$i]->telefono;
        ${"domicilio" . $i} = $clientes[$i]->domicilio;
        ${"areas" . $i} = $clientes[$i]->areas;
        ${"ta" . $i} = $clientes[$i]->total_areas;
        ${"total" . $i} = $clientes[$i]->total;
    }

    $numAreas = $ta0 + $ta1 + $ta2 + $ta3 + $ta4;

    $nameInCard0 = "";
    $nameInCard1 = "";
    $cardNumber0 = "";
    $cardNumber1 = "";
    $mes0 = "";
    $mes1 = "";
    $anio0 = "";
    $anio1 = "";
    $banco0 = "";
    $banco1 = "";
    $tipoTarjeta0 = "";
    $tipoTarjeta1 = "";
    $tipoCobro0 = "";
    $tipoCobro1 = "";
    $tp0 = "";
    $tp1 = "";
    for ($a = 0; $a < COUNT($tarjetas); $a++) {
        ${"nameInCard" . $a} = $tarjetas[$a]->nombre;
        ${"cardNumber" . $a} = $tarjetas[$a]->numero_tarjeta;
        ${"mes" . $a} = $tarjetas[$a]->mm;
        ${"anio" . $a} = $tarjetas[$a]->aa;
        ${"banco" . $a} = $tarjetas[$a]->id_banco;
        ${"tipoTarjeta" . $a} = $tarjetas[$a]->tipo_tarjeta;
        ${"tipoCobro" . $a} = $tarjetas[$a]->tipo_cobro;
        ${"tp" . $a} = $tarjetas[$a]->tarjeta_primaria;
    }

    for ($a = 0; $a < COUNT($cxamd); $a++) {
        ${"areasmd" . $a} = $cxamd[$a]->areas;
    }

    for ($a = 0; $a < COUNT($cxarf); $a++) {
        ${"areasrf" . $a} = $cxarf[$a]->areas;
    }

    for ($a = 0; $a < COUNT($clte_datail); $a++) {
        ${"clte_datail" . $a} = $clte_datail[$a];
    }

    $id_cobro_old = "";
    $total = "";
    $precioFinal = "";
    $engancheT = 0;
    $parcialidades = "";
    $servicio = "";
    $compartido = "";

    for ($b = 0; $b < COUNT($cobros); $b++) {
        $id_cobro_old = $cobros[$b]->id_cobro;
        $total = $cobros[$b]->total;
        //$descuento = $total * .65;
        $precioFinal = $cobros[$b]->cantidad;
        $engancheT = $engancheT + $cobros[$b]->enganche;
        $parcialidades = $cobros[$b]->parcialidades;
        $servicio = $cobros[$b]->servicio;
        $lugar_prospeccion = $cobros[$b]->lugar_prospeccion;
        $compartido = $cobros[$b]->compartido;
        $prosaa = $cobros[$b]->prosa;
        $referenciaa = $cobros[$b]->referencia;
    }

    $saldoPendiente = $precioFinal - $engancheT;
    $id_expediente = "";
    $ife = "";
    $tarjeta = "";
    $contrato = "";
    $cprosa = "";

    for ($c = 0; $c < COUNT($expediente); $c++) {
        $id_expediente = $expediente[$c]->id_expediente;
        $ife = $expediente[$c]->ife;
        $tarjeta = $expediente[$c]->tarjeta;
        $contrato = $expediente[$c]->contrato;
        $cprosa = $expediente[$c]->carta;
    }

    $id_contrato = "";
    $observaciones = "";

    for ($d = 0; $d < COUNT($contratos); $d++) {
        $id_contrato = $contratos[$d]->id_contrato;
        $observaciones = $contratos[$d]->observaciones;
    }

    $id_paquete1 = "";
    for ($e = 0; $e < COUNT($paquetes); $e++) {
        ${"id_paquete" . $e} = $paquetes[$e]->id_paquete;
    }
    $precioFinal_formato = number_format($precioFinal, 2);
    $saldoPendiente_formato = number_format($saldoPendiente, 2);
    $engancheT_formato = number_format($engancheT, 2);
?>

<style>
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
                                    <h3><br>DATOS DEL CLIENTE</h3><br>
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <div class="col-md-1">
                                            <li role="presentation" class="active"><a href="#cliente1" aria-controls="cliente1" role="tab" data-toggle="tab" class="clientesSTl">Cliente 1</a>
                                            </li>
                                        </div>
                                        <div class="col-md-1">
                                            <li role="presentation"><a href="#cliente2" aria-controls="cliente2" role="tab" data-toggle="tab" class="clientesSTl">Cliente 2</a></li>
                                        </div>
                                        <div class="col-md-1">
                                            <li role="presentation"><a href="#cliente3" aria-controls="cliente3" role="tab" data-toggle="tab" class="clientesSTl">Cliente 3</a></li>
                                        </div>
                                        <div class="col-md-1">
                                            <li role="presentation"><a href="#cliente4" aria-controls="cliente4" role="tab" data-toggle="tab" class="clientesSTl">Cliente 4</a></li>
                                        </div>
                                        <div class="col-md-1">
                                            <li role="presentation"><a href="#cliente5" aria-controls="cliente5" role="tab" data-toggle="tab" class="clientesSTl">Cliente 5</a></li>
                                        </div>
                                        <br><br>
                                    </ul>
                                    <form id="miform" method="post">
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade active show" id="cliente1">
                                                <div class="row">
                                                    <div class="col-md-12 mt-2">
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-2 form-group">
                                                        <input type="text" id="area_sel"
                                                               name="area_sel" value="<?= $servicio ?>" hidden>
                                                        <input type="text" id="id_cobro_old"
                                                               name="id_cobro_old" value="<?= $id_cobro_old ?>" hidden>
                                                        <label>* Nombres</label>
                                                        <input class="form-control field-disabld" name="nombre[]"
                                                               disabled value="<?= $nombre0 ?>"/>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label>* Apellido paterno</label>
                                                        <input class="form-control field-disabld"
                                                               name="apellido_paterno[]" disabled value="<?= $app0 ?>"/>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label>* Apellido materno</label>
                                                        <input class="form-control field-disabld"
                                                               name="apellido_materno[]" disabled value="<?= $apm0 ?>"/>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label>* Correo electrónico</label>
                                                        <input type="text" class="form-control field-disabld"
                                                               name="correo[]" disabled value="<?= $correo0 ?>"/>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label>* Teléfono</label>
                                                        <input type="tel" class="form-control field-disabld "
                                                               name="telefono[]" disabled value="<?= $tel0 ?>">
                                                    </div>
                                                    <div class="col-md-2 form-group text-center">
                                                        <label>¿Es titular?</label>
                                                        <div class="form-check">
                                                            <label class="form-check-label" name="radioT">
                                                                <input type="radio" class="form-check-input radioBtn"
                                                                       name="checkT" disabled value="1" checked>
                                                            </label>
                                                        </div>
                                                        <input class="form-control check1" name="check[]"
                                                               type="hidden"/>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($areasmd0 != '') {
                                                    ?>
                                                    <input type="text" id="areas_ant0" value="<?= $areasmd0 ?>" hidden>
                                                    <?php
                                                }
                                                ?>
                                                <div class="row row-depmod">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="container p-0 mb-5">
                                                                <div class="row">
                                                                    <div class="col-md-10 p-0 text-right">
                                                                        <input class="form-control field-disabld domicilio" value="<?= $domicilio0 ?>" name="domicilio[]" placeholder="Domicilio" autocomplete="off" onkeyup="mayus(this);" maxlength="500" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" readonly/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row areas-depmol">
                                                                <label class="no-mrg">Áreas</label>
                                                                <select class="form-control select-uno select-disabld areas"
                                                                        id="select1" name="selectPicker[]" multiple>
                                                                    <optgroup class="option-group-d"
                                                                              label="Depilación"></optgroup>
                                                                    <optgroup class="option-group-m"
                                                                              label="Moldeo"></optgroup>
                                                                </select>
                                                                <input class="form-control corte1" name="corte1"
                                                                       type="hidden" value="0"/>
                                                                <input class="form-control rate-sl1" type="hidden"
                                                                       value="<?= $total0 ?>"/>
                                                                <input class="form-control rate-sl1-1" type="hidden"
                                                                       value="<?= $total0 ?>"/>
                                                                <input class="form-control total-areas1" type="hidden"
                                                                       value="<?= $ta0 ?>"/>
                                                                <input class="form-control total-areaa1" type="hidden"
                                                                       value="<?= $ta0 ?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                    <div class="col-md-12 form-group areas-depmol">
                                                        <div class="table-wrapper-scroll-y">
                                                            <table class="table">
                                                                <thead class="thead-dark-first header">
                                                                <tr>
                                                                    <th colspan="5" scope="col" id="flechaDesplegar"
                                                                        class="style-encabezado-tbl"><h5 class="no-mrg">
                                                                            Áreas seleccionadas </h5><i
                                                                                class="fa fa-chevron-up"
                                                                                style="float: right;margin-top: -16px;"></i>
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="tbody-areas1">
                                                                <tr class="tr-principal">
                                                                    <th scope="row">No. Área</th>
                                                                    <th scope="row">Tipo</th>
                                                                    <th scope="row">No. Sesiones</th>
                                                                    <th scope="row">Área</th>
                                                                    <th scope="row">Precio</th>
                                                                    <th scope="row" hidden>Clave</th>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 areas-depmol">
                                                        <div class="row">
                                                            <div class="col-md-10 d-flex justify-content-end align-items-center">
                                                                <label style="font-size:14px; margin:0">TOTAL</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input class="form-control rate-sl1" value="0.00"
                                                                       style="text-align:center; border:none"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- END row select2 áreas y btn cuerpo completo -->
                                                <br>
                                                <br>
                                                <div class="row row-tratamientos d-none">
                                                    <?php
                                                        if ($areasrf0 != '') {
                                                            ?>
                                                            <input type="text" id="areasrf_ant6" value="<?= $areasrf0 ?>" hidden>
                                                            <?php
                                                        }
                                                    ?>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="no-mrg">Tratamientos rejuvenecimiento
                                                                facial</label>
                                                            <select class="form-control select-disabld tratamientos"
                                                                    onchange="buildTable(this);" id="select6" multiple>
                                                                <optgroup class="option-group-rf"
                                                                          label="Rejuvenecimiento facial"></optgroup>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="col-md-12 form-group">
                                                        <div class="table-wrapper-scroll-y">
                                                            <table class="table ttratamientos">
                                                                <thead class="thead-dark-first header">
                                                                <tr>
                                                                    <th colspan="8" scope="col" id="flechaDesplegar_6"
                                                                        class="style-encabezado-tbl"><h5 class="no-mrg">
                                                                            Tratamientos seleccionados</h5><i
                                                                                class="fa fa-chevron-up"
                                                                                style="float: right;margin-top: -16px;"></i>
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="tbody-tratamientos6">
                                                                <tr class="tr-principal">
                                                                    <th scope="row">No. Tratamiento</th>
                                                                    <th scope="row">Tipo</th>
                                                                    <th scope="row">No. Sesiones</th>
                                                                    <th scope="row">Nombre</th>
                                                                    <th scope="row" style="width:200px">Área</th>
                                                                    <th scope="row">Piezas</th>
                                                                    <th scope="row">Precio unitario</th>
                                                                    <th scope="row">Precio total</th>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 coltotales_6">
                                                        <div class="row">
                                                            <div class="col-md-10 d-flex justify-content-end align-items-center">
                                                                <label style="font-size:14px; margin:0">TOTAL</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control g-disabld"
                                                                       id="sumat_6" value="0.00"
                                                                       style="text-align:center; border:none">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- END row select2 tratamientos -->
                                            </div> <!-- End  tabpanel 1-->

                                            <div role="tabpanel" class="tab-pane fade" id="cliente2">
                                                <div class="row">
                                                    <div class="col-md-12 mt-2">
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-2 form-group">
                                                        <label>* Nombres</label>
                                                        <input class="form-control field-disabld" name="nombre[]"
                                                               disabled value="<?= $nombre1 ?>"/>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label>* Apellido paterno</label>
                                                        <input class="form-control field-disabld"
                                                               name="apellido_paterno[]" disabled value="<?= $app1 ?>"/>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label>* Apellido materno</label>
                                                        <input class="form-control field-disabld"
                                                               name="apellido_materno[]" disabled value="<?= $apm1 ?>"/>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label>* Correo electrónico</label>
                                                        <input type="email" class="form-control field-disabld"
                                                               name="correo[]" disabled value="<?= $correo1 ?>"/>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label>* Teléfono</label>
                                                        <input type="tel" class="form-control field-disabld "
                                                               name="telefono[]" disabled value="<?= $tel1 ?>">
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label>¿Es titular?</label>
                                                        <div class="form-check">
                                                            <label class="form-check-label" name="radioT">
                                                                <input type="radio" class="form-check-input radioBtn"
                                                                       name="checkT" disabled value="2">
                                                            </label>
                                                        </div>
                                                        <input class="form-control check2" name="check[]"
                                                               type="hidden"/>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($areasmd1 != '') {
                                                    ?>
                                                    <input type="text" id="areas_ant1" value="<?= $areasmd1 ?>" hidden>
                                                    <?php
                                                }
                                                ?>
                                                <div class="row row-depmod">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="container p-0 mb-5">
                                                                <div class="row">
                                                                    <div class="col-md-10 p-0 text-right">
                                                                        <input class="form-control field-disabld domicilio" value="<?= $domicilio1 ?>" name="domicilio[]" placeholder="Domicilio" autocomplete="off" onkeyup="mayus(this);" maxlength="500" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" readonly/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row areas-depmol">
                                                                <label class="no-mrg">Áreas</label>
                                                                <select class="form-control select-dos select-disabld areas"
                                                                        id="select2" name="selectPicker[]" multiple>
                                                                    <optgroup class="option-group-d"
                                                                              label="Depilación"></optgroup>
                                                                    <optgroup class="option-group-m"
                                                                              label="Moldeo"></optgroup>
                                                                </select>
                                                                <input class="form-control corte2" type="hidden"
                                                                       name="corte2" value="0"/>
                                                                <input class="form-control rate-sl2" type="hidden"
                                                                       value="<?= $total1 ?>"/>
                                                                <input class="form-control rate-sl1-2" type="hidden"
                                                                       value="<?= $total1 ?>"/>
                                                                <input class="form-control total-areas2" type="hidden"
                                                                       value="<?= $ta1 ?>" value="0"/>
                                                                <input class="form-control total-areaa2" type="hidden"
                                                                       value="<?= $ta1 ?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                    <div class="col-md-12 form-group areas-depmol">
                                                        <div class="table-wrapper-scroll-y">
                                                            <table class="table">
                                                                <thead class="thead-dark-first header">
                                                                <tr>
                                                                    <th colspan="5" scope="col" id="flechaDesplegar_2"
                                                                        class="style-encabezado-tbl"><h5 class="no-mrg">
                                                                            Áreas seleccionadas </h5><i
                                                                                class="fa fa-chevron-up"
                                                                                style="float: right;margin-top: -16px;"></i>
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="tbody-areas2">
                                                                <tr class="tr-principal">
                                                                    <th scope="row">No. Área</th>
                                                                    <th scope="row">Tipo</th>
                                                                    <th scope="row">No. Sesiones</th>
                                                                    <th scope="row">Área</th>
                                                                    <th scope="row">Precio</th>
                                                                    <th scope="row" hidden>Clave</th>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 areas-depmol">
                                                        <div class="row">
                                                            <div class="col-md-10 d-flex justify-content-end align-items-center">
                                                                <label style="font-size:14px; margin:0">TOTAL</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input class="form-control rate-sl2" value="0.00"
                                                                       style="text-align:center; border:none"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- END row select2 áreas y btn cuerpo completo -->
                                                <br>
                                                <br>
                                                <div class="row row-tratamientos d-none">
                                                    <?php
                                                    if ($areasrf1 != '') {
                                                        ?>
                                                        <input type="text" id="areasrf_ant7" value="<?= $areasrf1 ?>" hidden>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="no-mrg">Tratamientos rejuvenecimiento
                                                                facial</label>
                                                            <select class="form-control select-disabld tratamientos"
                                                                    onchange="buildTable(this);" id="select7" multiple>
                                                                <optgroup class="option-group-rf"
                                                                          label="Rejuvenecimiento facial"></optgroup>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="col-md-12 form-group">
                                                        <div class="table-wrapper-scroll-y">
                                                            <table class="table ttratamientos">
                                                                <thead class="thead-dark-first header">
                                                                <tr>
                                                                    <th colspan="8" scope="col" id="flechaDesplegar_7"
                                                                        class="style-encabezado-tbl"><h5 class="no-mrg">
                                                                            Tratamientos seleccionados </h5><i
                                                                                class="fa fa-chevron-up"
                                                                                style="float: right;margin-top: -16px;"></i>
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="tbody-tratamientos7">
                                                                <tr class="tr-principal">
                                                                    <th scope="row">No. Tratamiento</th>
                                                                    <th scope="row">Tipo</th>
                                                                    <th scope="row">No. Sesiones</th>
                                                                    <th scope="row">Nombre</th>
                                                                    <th scope="row">Área</th>
                                                                    <th scope="row">Piezas</th>
                                                                    <th scope="row">Precio unitario</th>
                                                                    <th scope="row">Precio total</th>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 coltotales_7">
                                                        <div class="row">
                                                            <div class="col-md-10 d-flex justify-content-end align-items-center">
                                                                <label style="font-size:14px; margin:0">TOTAL</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control g-disabld"
                                                                       id="sumat_7" value="0.00" onChange=""
                                                                       onkeypress="return onlyNumbers(event)"
                                                                       style="text-align:center; border:none">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- END row select2 tratamientos -->
                                            </div> <!-- End tabpanel 2 -->

                                            <div role="tabpanel" class="tab-pane fade" id="cliente3">
                                                <div class="row">
                                                    <div class="col-md-12 mt-2">
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-2 form-group">
                                                        <label>* Nombres</label>
                                                        <input class="form-control field-disabld" name="nombre[]"
                                                               disabled value="<?= $nombre2 ?>"/>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label>* Apellido paterno</label>
                                                        <input class="form-control field-disabld"
                                                               name="apellido_paterno[]" disabled value="<?= $app2 ?>"/>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label>* Apellido materno</label>
                                                        <input class="form-control field-disabld"
                                                               name="apellido_materno[]" disabled value="<?= $apm2 ?>"/>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label>* Correo electrónico</label>
                                                        <input type="email" class="form-control field-disabld"
                                                               name="correo[]" disabled value="<?= $correo2 ?>"/>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label>* Teléfono</label>
                                                        <input type="tel" class="form-control field-disabld "
                                                               name="telefono[]" disabled value="<?= $tel2 ?>"/>
                                                    </div>
                                                    <div class="col-md-2 form-group text-center">
                                                        <label>¿Es titular?</label>
                                                        <div class="form-check">
                                                            <label class="form-check-label" name="radioT">
                                                                <input type="radio" class="form-check-input radioBtn"
                                                                       name="checkT" disabled value="3">
                                                            </label>
                                                        </div>
                                                        <input class="form-control check3" name="check[]"
                                                               type="hidden"/>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($areasmd2 != '') {
                                                    ?>
                                                    <input type="text" id="areas_ant2" value="<?= $areasmd2 ?>" hidden>
                                                    <?php
                                                }
                                                ?>
                                                <div class="row row-depmod">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="container p-0 mb-5">
                                                                <div class="row">
                                                                    <div class="col-md-10 p-0 text-right">
                                                                        <input class="form-control field-disabld domicilio" value="<?= $domicilio2 ?>" name="domicilio[]" placeholder="Domicilio" autocomplete="off" onkeyup="mayus(this);" maxlength="500" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" readonly/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row areas-depmol">
                                                                <label class="no-mrg">Áreas</label>
                                                                <select class="form-control select-tres select-disabld areas"
                                                                        id="select3" name="selectPicker[]" multiple>
                                                                    <optgroup class="option-group-d"
                                                                              label="Depilación"></optgroup>
                                                                    <optgroup class="option-group-m"
                                                                              label="Moldeo"></optgroup>
                                                                </select>
                                                                <input class="form-control corte3" type="hidden"
                                                                       name="corte3" value="0"/>
                                                                <input class="form-control rate-sl3" type="hidden"
                                                                       value="<?= $total2 ?>"/>
                                                                <input class="form-control rate-sl1-3" type="hidden"
                                                                       value="<?= $total2 ?>"/>
                                                                <input class="form-control total-areas3" type="hidden"
                                                                       value="<?= $ta2 ?>" value="0"/>
                                                                <input class="form-control total-areaa3" type="hidden"
                                                                       value="<?= $ta2 ?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                    <div class="col-md-12 form-group areas-depmol">
                                                        <div class="table-wrapper-scroll-y">
                                                            <table class="table">
                                                                <thead class="thead-dark-first header">
                                                                <tr>
                                                                    <th colspan="5" scope="col" id="flechaDesplegar_3"
                                                                        class="style-encabezado-tbl"><h5 class="no-mrg">
                                                                            Áreas seleccionadas </h5><i
                                                                                class="fa fa-chevron-up"
                                                                                style="float: right;margin-top: -16px;"></i>
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="tbody-areas3">
                                                                <tr class="tr-principal">
                                                                    <th scope="row">No. Área</th>
                                                                    <th scope="row">Tipo</th>
                                                                    <th scope="row">No. Sesiones</th>
                                                                    <th scope="row">Área</th>
                                                                    <th scope="row">Precio</th>
                                                                    <th scope="row" hidden>Clave</th>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 areas-depmol">
                                                        <div class="row">
                                                            <div class="col-md-10 d-flex justify-content-end align-items-center">
                                                                <label style="font-size:14px; margin:0">TOTAL</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input class="form-control rate-sl3" value="0.00"
                                                                       style="text-align:center; border:none"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- END row select2 áreas y btn cuerpo completo -->
                                                <br>
                                                <br>
                                                <div class="row row-tratamientos d-none">
                                                    <?php
                                                    if ($areasrf2 != '') {
                                                        ?>
                                                        <input type="text" id="areasrf_ant8" value="<?= $areasrf2 ?>" hidden>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="no-mrg">Tratamientos rejuvenecimiento
                                                                facial</label>
                                                            <select class="form-control select-disabld tratamientos"
                                                                    onchange="buildTable(this);" id="select8" multiple>
                                                                <optgroup class="option-group-rf"
                                                                          label="Rejuvenecimiento facial"></optgroup>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="col-md-12 form-group">
                                                        <div class="table-wrapper-scroll-y">
                                                            <table class="table ttratamientos">
                                                                <thead class="thead-dark-first header">
                                                                <tr>
                                                                    <th colspan="8" scope="col" id="flechaDesplegar_8"
                                                                        class="style-encabezado-tbl"><h5 class="no-mrg">
                                                                            Tratamientos seleccionados </h5><i
                                                                                class="fa fa-chevron-up"
                                                                                style="float: right;margin-top: -16px;"></i>
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="tbody-tratamientos8">
                                                                <tr class="tr-principal">
                                                                    <th scope="row">No. Tratamiento</th>
                                                                    <th scope="row">Tipo</th>
                                                                    <th scope="row">No. Sesiones</th>
                                                                    <th scope="row">Nombre</th>
                                                                    <th scope="row">Área</th>
                                                                    <th scope="row">Piezas</th>
                                                                    <th scope="row">Precio unitario</th>
                                                                    <th scope="row">Precio total</th>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 coltotales_8">
                                                        <div class="row">
                                                            <div class="col-md-10 d-flex justify-content-end align-items-center">
                                                                <label style="font-size:14px; margin:0">TOTAL</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control g-disabld"
                                                                       id="sumat_8" value="0.00"
                                                                       style="text-align:center; border:none">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- END row select2 tratamientos -->
                                            </div> <!-- End tabpanel 3 -->

                                            <div role="tabpanel" class="tab-pane fade" id="cliente4">
                                                <div class="row">
                                                    <div class="col-md-12 mt-2">
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-2 form-group">
                                                        <label>* Nombres</label>
                                                        <input class="form-control field-disabld" name="nombre[]"
                                                               disabled value="<?= $nombre3 ?>"/>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label>* Apellido paterno</label>
                                                        <input class="form-control field-disabld"
                                                               name="apellido_paterno[]" disabled value="<?= $app3 ?>"/>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label>* Apellido materno</label>
                                                        <input class="form-control field-disabld"
                                                               name="apellido_materno[]" disabled value="<?= $apm3 ?>"/>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label>* Correo electrónico</label>
                                                        <input type="email" class="form-control field-disabld"
                                                               name="correo[]" disabled value="<?= $correo3 ?>"/>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label>* Teléfono</label>
                                                        <input type="tel" class="form-control field-disabld "
                                                               name="telefono[]" disabled value="<?= $tel3 ?>">
                                                    </div>
                                                    <div class="col-md-2 form-group text-center">
                                                        <label>¿Es titular?</label>
                                                        <div class="form-check">
                                                            <label class="form-check-label" name="radioT">
                                                                <input type="radio" class="form-check-input radioBtn"
                                                                       name="checkT" disabled value="4">
                                                            </label>
                                                        </div>
                                                        <input class="form-control check4" name="check[]"
                                                               type="hidden"/>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($areasmd3 != '') {
                                                    ?>
                                                    <input type="text" id="areas_ant3" value="<?= $areasmd3 ?>" hidden>
                                                    <?php
                                                }
                                                ?>
                                                <div class="row row-depmod">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="container p-0 mb-5">
                                                                <div class="row">
                                                                    <div class="col-md-10 p-0 text-right">
                                                                        <input class="form-control field-disabld domicilio" value="<?= $domicilio3 ?>" name="domicilio[]" placeholder="Domicilio" autocomplete="off" onkeyup="mayus(this);" maxlength="500" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" readonly/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row areas-depmol">
                                                                <label class="no-mrg">Áreas</label>
                                                                <select class="form-control select-cuatro select-disabld areas"
                                                                        id="select4" name="selectPicker[]" multiple>
                                                                    <optgroup class="option-group-d"
                                                                              label="Depilación"></optgroup>
                                                                    <optgroup class="option-group-m"
                                                                              label="Moldeo"></optgroup>
                                                                </select>
                                                                <input class="form-control corte4" type="hidden"
                                                                       name="corte4" value="0"/>
                                                                <input class="form-control rate-sl4" type="hidden"
                                                                       value="<?= $total3 ?>"/>
                                                                <input class="form-control rate-sl1-4" type="hidden"
                                                                       value="<?= $total3 ?>"/>
                                                                <input class="form-control total-areas4" type="hidden"
                                                                       value="<?= $ta3 ?>" value="0"/>
                                                                <input class="form-control total-areaa4" type="hidden"
                                                                       value="<?= $ta3 ?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                    <div class="col-md-12 form-group areas-depmol">
                                                        <div class="table-wrapper-scroll-y">
                                                            <table class="table">
                                                                <thead class="thead-dark-first header">
                                                                <tr>
                                                                    <th colspan="5" scope="col" id="flechaDesplegar_4"
                                                                        class="style-encabezado-tbl"><h5 class="no-mrg">
                                                                            Áreas seleccionadas </h5><i
                                                                                class="fa fa-chevron-up"
                                                                                style="float: right;margin-top: -16px;"></i>
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="tbody-areas4">
                                                                <tr class="tr-principal">
                                                                    <th scope="row">No. Área</th>
                                                                    <th scope="row">Tipo</th>
                                                                    <th scope="row">No. Sesiones</th>
                                                                    <th scope="row">Área</th>
                                                                    <th scope="row">Precio</th>
                                                                    <th scope="row" hidden>Clave</th>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 areas-depmol">
                                                        <div class="row">
                                                            <div class="col-md-10 d-flex justify-content-end align-items-center">
                                                                <label style="font-size:14px; margin:0">TOTAL</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input class="form-control rate-sl4" value="0.00"
                                                                       style="text-align:center; border:none"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- END row select2 áreas y btn cuerpo completo -->
                                                <br>
                                                <br>
                                                <div class="row row-tratamientos d-none">
                                                    <?php
                                                    if ($areasrf3 != '') {
                                                        ?>
                                                        <input type="text" id="areasrf_ant9" value="<?= $areasrf3 ?>" hidden>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="no-mrg">Tratamientos rejuvenecimiento
                                                                facial</label>
                                                            <select class="form-control select-disabld tratamientos"
                                                                    onchange="buildTable(this);" id="select9" multiple>
                                                                <optgroup class="option-group-rf"
                                                                          label="Rejuvenecimiento facial"></optgroup>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="col-md-12 form-group">
                                                        <div class="table-wrapper-scroll-y">
                                                            <table class="table ttratamientos">
                                                                <thead class="thead-dark-first header">
                                                                <tr>
                                                                    <th colspan="8" scope="col" id="flechaDesplegar_9"
                                                                        class="style-encabezado-tbl"><h5 class="no-mrg">
                                                                            Tratamientos seleccionados </h5><i
                                                                                class="fa fa-chevron-up"
                                                                                style="float: right;margin-top: -16px;"></i>
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="tbody-tratamientos9">
                                                                <tr class="tr-principal">
                                                                    <th scope="row">No. Tratamiento</th>
                                                                    <th scope="row">Tipo</th>
                                                                    <th scope="row">No. Sesiones</th>
                                                                    <th scope="row">Nombre</th>
                                                                    <th scope="row">Área</th>
                                                                    <th scope="row">Piezas</th>
                                                                    <th scope="row">Precio unitario</th>
                                                                    <th scope="row">Precio total</th>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 coltotales_9">
                                                        <div class="row">
                                                            <div class="col-md-10 d-flex justify-content-end align-items-center">
                                                                <label style="font-size:14px; margin:0">TOTAL</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control g-disabld"
                                                                       id="sumat_9" value="0.00"
                                                                       style="text-align:center; border:none">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- END row select2 tratamientos -->
                                            </div> <!-- End tabpanel 4 -->

                                            <div role="tabpanel" class="tab-pane fade" id="cliente5">
                                                <div class="row">
                                                    <div class="col-md-12 mt-2">
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-2 form-group">
                                                        <label>* Nombres</label>
                                                        <input class="form-control field-disabld" name="nombre[]"
                                                               disabled value="<?= $nombre4 ?>"/>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label>* Apellido paterno</label>
                                                        <input class="form-control field-disabld"
                                                               name="apellido_paterno[]" disabled value="<?= $app4 ?>"/>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label>* Apellido materno</label>
                                                        <input class="form-control field-disabld"
                                                               name="apellido_materno[]" disabled value="<?= $apm4 ?>"/>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label>* Correo electrónico</label>
                                                        <input type="email" class="form-control field-disabld"
                                                               name="correo[]" disabled value="<?= $correo4 ?>"/>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <label>* Teléfono</label>
                                                        <input type="tel" class="form-control field-disabld "
                                                               name="telefono[]" disabled value="<?= $tel4 ?>">
                                                    </div>
                                                    <div class="col-md-2 form-group text-center">
                                                        <label>¿Es titular?</label>
                                                        <div class="form-check">
                                                            <label class="form-check-label" name="radioT">
                                                                <input type="radio" class=" form-check-input radioBtn"
                                                                       name="checkT" disabled value="5">
                                                            </label>
                                                        </div>
                                                        <input class="form-control check5" name="check[]"
                                                               type="hidden"/>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($areasmd4 != '') {
                                                    ?>
                                                    <input type="text" id="areas_ant4" value="<?= $areasmd4 ?>" hidden>
                                                    <?php
                                                }
                                                ?>
                                                <div class="row row-depmod">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="container p-0 mb-5">
                                                                <div class="row">
                                                                    <div class="col-md-10 p-0 text-right">
                                                                        <input class="form-control field-disabld domicilio" value="<?= $domicilio4 ?>" name="domicilio[]" placeholder="Domicilio" autocomplete="off" onkeyup="mayus(this);" maxlength="500" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" readonly/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row areas-depmol">
                                                                <label class="no-mrg">Áreas</label>
                                                                <select class="form-control select-cinco select-disabld areas"
                                                                        id="select5" name="selectPicker[]" multiple>
                                                                    <optgroup class="option-group-d"
                                                                              label="Depilación"></optgroup>
                                                                    <optgroup class="option-group-m"
                                                                              label="Moldeo"></optgroup>
                                                                </select>
                                                                <input class="form-control corte5" type="hidden"
                                                                       name="corte5" value="0"/>
                                                                <input class="form-control rate-sl5" type="hidden"
                                                                       value="<?= $total4 ?>"/>
                                                                <input class="form-control rate-sl1-5" type="hidden"
                                                                       value="<?= $total4 ?>"/>
                                                                <input class="form-control total-areas5" type="hidden"
                                                                       value="<?= $ta4 ?>" value="0"/>
                                                                <input class="form-control total-areaa5" type="hidden"
                                                                       value="<?= $ta4 ?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                    <div class="col-md-12 form-group areas-depmol">
                                                        <div class="table-wrapper-scroll-y">
                                                            <table class="table">
                                                                <thead class="thead-dark-first header">
                                                                <tr>
                                                                    <th colspan="5" scope="col" id="flechaDesplegar_5"
                                                                        class="style-encabezado-tbl"><h5
                                                                                class="no-mrg style-encabezado-tbl">
                                                                            Áreas seleccionadas </h5><i
                                                                                class="fa fa-chevron-up"
                                                                                style="float: right;margin-top: -16px;"></i>
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="tbody-areas5">
                                                                <tr class="tr-principal">
                                                                    <th scope="row">No. Área</th>
                                                                    <th scope="row">Tipo</th>
                                                                    <th scope="row">No. Sesiones</th>
                                                                    <th scope="row">Área</th>
                                                                    <th scope="row">Precio</th>
                                                                    <th scope="row" hidden>Clave</th>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 areas-depmol">
                                                        <div class="row">
                                                            <div class="col-md-10 d-flex justify-content-end align-items-center">
                                                                <label style="font-size:14px; margin:0">TOTAL</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input class="form-control rate-sl5" value="0.00"
                                                                       style="text-align:center; border:none"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- END row select2 áreas y btn cuerpo completo -->
                                                <br>
                                                <br>
                                                <div class="row row-tratamientos d-none">
                                                    <?php
                                                    if ($areasrf4 != '') {
                                                        ?>
                                                        <input type="text" id="areasrf_ant10" value="<?= $areasrf4 ?>" hidden>
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="no-mrg">Tratamientos rejuvenecimiento
                                                                facial</label>
                                                            <select class="form-control select-disabld tratamientos"
                                                                    onchange="buildTable(this);" id="select10" multiple>
                                                                <optgroup class="option-group-rf"
                                                                          label="Rejuvenecimiento facial"></optgroup>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="col-md-12 form-group">
                                                        <div class="table-wrapper-scroll-y">
                                                            <table class="table ttratamientos">
                                                                <thead class="thead-dark-first header">
                                                                <tr>
                                                                    <th colspan="8" scope="col" id="flechaDesplegar_10">
                                                                        <h5 class="no-mrg">Tratamientos
                                                                            seleccionados</h5><i
                                                                                class="fa fa-chevron-up"
                                                                                style="float: right;margin-top: -16px;"></i>
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="tbody-tratamientos10">
                                                                <tr class="tr-principal">
                                                                    <th scope="row">No. Tratamientos</th>
                                                                    <th scope="row">Tipo</th>
                                                                    <th scope="row">No. Sesiones</th>
                                                                    <th scope="row">Nombre</th>
                                                                    <th scope="row">Área</th>
                                                                    <th scope="row">Piezas</th>
                                                                    <th scope="row">Precio unitario</th>
                                                                    <th scope="row">Precio total</th>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 coltotales_10">
                                                        <div class="row">
                                                            <div class="col-md-10 d-flex justify-content-end align-items-center">
                                                                <label style="font-size:14px; margin:0">TOTAL</label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" class="form-control g-disabld"
                                                                       id="sumat_10" value="0.00"
                                                                       style="text-align:center; border:none">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- END row select2 tratamientos -->
                                            </div> <!-- End tabpanel 5 -->

                                            <input class="form-control total-areasCP" type="hidden" id="num-areasCP"
                                                   value="0"/>
                                            <div class="box-anticipo">
                                                <h4>DETALLE DE COBRANZA</h4>
                                                <div class="row">
                                                    <div class="col-md-2 pr-1">
                                                        <div class="form-group">
                                                            <label class="m-0" style="font-size: 14px; color: #888;"><i>Costo
                                                                    total anterior</i></label>
                                                            <input class="form-control" name="lugar_prospeccion"
                                                                   type="hidden" value="<?= $lugar_prospeccion ?>"/>
                                                            <input class="form-control" id="precioFinalA"
                                                                   name="precioFinalA" value="<?= $precioFinal ?>"
                                                                   readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2 pr-1">
                                                        <label class="m-0" style="font-size: 14px; color: #888;"><i>Saldo
                                                                pendiente anterior</i></label>
                                                        <input class="form-control" value="<?= $saldoPendiente ?>"
                                                               disabled>
                                                    </div>
                                                    <div class="col-sm-2 pr-1">
                                                        <label class="m-0"><i style="color: #888;">Anticipo a favor</i></label>
                                                        <input class="form-control" name="pagoConA" id="pagoConA"
                                                               value="<?= $engancheT ?>" disabled>
                                                    </div>
                                                </div>
                                            </div><!-- End box-cobranza-a -->
                                            <div class="box-anticipo d-none">
                                                <div class="row">
                                                    <div class="col-md-2 pr-1 d-none">
                                                        <div class="form-group">
                                                            <label>Total</label>
                                                            <input type="number" class="form-control" name="total" id="total" placeholder="Total" autocomplete="off" value="<?= $total ?>" readonly onkeypress="return onlyNumbers(event)">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 pr-1 d-none">
                                                        <div class="form-group">
                                                            <label>Descuento</label>
                                                            <input type="text" class="form-control" name="descuento"
                                                                   id="descuento" placeholder="Descuento"
                                                                   autocomplete="off" value="0" readonly
                                                                   onkeypress="return onlyNumbers(event)">
                                                            <input class="form-control total-areas" type="hidden"
                                                                   value="<?= $numAreas ?>"/>
                                                            <input class="form-control" type="hidden" id="areasa"
                                                                   value="<?= $numAreas ?>"/>
                                                            <input class="form-control" type="hidden" name="prosaa"
                                                                   id="prosaa" value="<?= $prosaa ?>"/>
                                                            <input class="form-control" type="hidden" name="referenciaa"
                                                                   id="referenciaa" value="<?= $referenciaa ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 pr-1">
                                                        <div class="form-group">
                                                            <label style="font-size:14px">Total rejuvenecimiento</label>
                                                            <input type="number" class="form-control" id="totalrf" name="totalrf" autocomplete="off" value="0" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 pr-1">
                                                        <div class="form-group">
                                                            <label style="font-size:14px">Total depilación / moldeo</label>
                                                            <input type="text" class="form-control g-disabld precioFinal" name="precioFinal" id="" autocomplete="off" value="0.00" onChange="changePriceDepMol();" onkeypress="return onlyNumbers(event)">
                                                            <input type="hidden" class="form-control precioFinal2" name="precioFinal2" id="" autocomplete="off" value="0.00">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 pr-1">
                                                        <div class="form-group">
                                                            <label><b>COSTO FINAL</b></label>
                                                            <input type="text" class="form-control g-disabld" name="precioFinalC" id="precioFinalC" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 pr-1">
                                                        <div class="form-group">
                                                            <label style="font-size:14px"><b>Nuevo saldo
                                                                    pendiente</b></label>
                                                            <input type="text" class="form-control"
                                                                   name="saldoPendiente" id="saldoPendiente"
                                                                   autocomplete="off" value="<?= $saldoPendiente ?>"
                                                                   readonly onkeypress="return onlyNumbers(event)">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 pr-1">
                                                        <div class="form-group">
                                                            <label style="font-size:11px"><b>Nuevo anticipo</b></label>
                                                            <input type="number" class="form-control g-disabld"
                                                                   name="pagoCon" id="pagoCon" placeholder="0.00"
                                                                   autocomplete="off" value="0"
                                                                   onChange="validateAdvance(); changeAPagar(); valorMensualidad(); deselectMulti();"
                                                                   onkeypress="return onlyNumbers(event)"
                                                                   onkeyup="changeAPagar(); valorMensualidad(); changeEntrance(); deselectMulti();">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 pr-1">
                                                        <div class="form-group" style="display:grid">
                                                            <label>Forma de pago <b>(anticipo)</b></label>
                                                            <select id="formaPago" name="formaPago[]"
                                                                    class="form-control g-disabld" autocomplete="off"
                                                                    multiple="multiple"
                                                                    onchange="changePay(); changeEntrance(); changeAPagar();">
                                                                <option value='1' class="efeRequired">Efectivo</option>
                                                                <option value='2' class="tarRequired">Tarjeta</option>
                                                                <option value='6' class="tranRequired">Transferencia
                                                                    bancaria
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if (!$prosaa) {
                                                        ?>
                                                        <div class="col-md-2 protegidaS d-none"
                                                             style="display:grid; justify-items:center">
                                                            <label for="protegida1">Venta protegida</label>
                                                            <input id="protegida1" class="protegida" name="protegidas"
                                                                   class="tarRequired g-disabld" type="checkbox"/>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div><!--End Box anticipo -->
                                            <h4>DETALLE DEL CONTRATO</h4>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group box-pagos">
                                                        <label>Pagos por cubrir <b>(finiquito)</b></label>
                                                        <select id="parcialidades" name="parcialidades"
                                                                class="form-control g-disabld" autocomplete="off"
                                                                onChange="valorMensualidad();">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 d-none">
                                                    <div class="form-group box-pagos">
                                                        <label>Lugar de prospección</label>
                                                        <input class="form-control" name="lugar_prospeccion"
                                                               type="hidden" value="<?= $lugar_prospeccion ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-group box-pagos">
                                                        <label>Observaciones</label>
                                                        <textarea onkeyup="mayus(this);" id="observaciones" name="observaciones"
                                                                  class="form-control"><?= $observaciones ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12 pr-1" id="monthly-payments">
                                                </div>
                                            </div>

                                            <div class="row d-none">
                                                <div class="col-md-12 pr-1" id="monthly-inputs">
                                                </div>
                                            </div>

                                            <h4 class="payment-title d-none">PAGO DEL ANTICIPO</h4>
                                            <div id="box-cash" class="d-none mb-5">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <label>Efectivo</label>
                                                            <input type="text" class="form-control g-disabld"
                                                                   name="efectivo" id="efectivo" value="0.00"
                                                                   autocomplete="off"
                                                                   onkeypress="return onlyNumbers(event)"
                                                                   onkeyup="changeEntrance(); changeAPagar(); evalueEntranceE(this.value);">
                                                        </div>
                                                    </div>

                                                    <?php
                                                    if (!$prosaa) {
                                                        ?>
                                                        <div class="col-md-2"
                                                             style="display:grid; justify-items:center">
                                                            <label for="protegida2">Venta protegida</label>
                                                            <input id="protegida2" class="protegida" name="protegida"
                                                                   class="tarRequired g-disabld" type="checkbox"/>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <h4 id="lblProtegida" class="d-none"><b>Venta protegida para finiquito</b>
                                            </h4>
                                            <div id="box-card" class="d-none">
                                                <label class="lblTipoCard"></label>
                                                <ul class="nav nav-tabs" role="tablist">
                                                    <div class="col-md-1" id="tabtjt1">
                                                        <li role="presentation" class="active">
                                                            <a href="#tarjeta1" aria-controls="tarjeta1" role="tab"
                                                               data-toggle="tab">Tarjeta 1</a>
                                                        </li>
                                                    </div>
                                                    <div class="col-md-1" id="tabtjt2">
                                                        <li role="presentation"><a href="#tarjeta2"
                                                                                   aria-controls="tarjerta2" role="tab"
                                                                                   data-toggle="tab">Tarjeta 2</a></li>
                                                    </div>
                                                </ul>
                                                <div class="tab-content">
                                                    <div role="tabpanel" class="tab-pane fade active show"
                                                         id="tarjeta1">
                                                        <div class="row mt-3">
                                                            <div class="col-sm-12">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3 pr-1">
                                                                <div class="form-group">

                                                                    <label>¿Tarjeta para pago recurrente?</label>
                                                                    <select id="tp1" name="tarjetaPrimaria[]"
                                                                            class="form-control g-disabld"
                                                                            autocomplete="off">
                                                                        <?php
                                                                        if ($prosaa) {
                                                                            ?>
                                                                            <option value="1" data-value="7">Si</option>
                                                                            <option value="2" data-value="7" selected>
                                                                                No
                                                                            </option>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <option value="2" data-value="7">No</option>
                                                                            <option value="1" data-value="7" selected>
                                                                                Si
                                                                            </option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
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
                                                                    <input type="text" class="form-control g-disabld"
                                                                           name="montoT[]" id="montoTU"
                                                                           autocomplete="off" value="0.00"
                                                                           onkeypress="return onlyNumbers(event)"
                                                                           onkeyup="changeEntrance(); changeAPagar(); evalueEntranceTU(this.value)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="from-group box-msi d-none">
                                                                    <label>MSI:</label>
                                                                    <select id="msi1" name="msi[]"
                                                                            class="form-control g-disabld">
                                                                        <option value="">Seleccione una opción</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mPagoTarjeta">
                                                            <div class="col-md-2 pr-1">
                                                                <div class="form-group">
                                                                    <label>Número de tarjeta</label>
                                                                    <input class="form-control g-disabld"
                                                                           name="cardNumber[]" id="cardNumber"
                                                                           placeholder="XXXX XXXX XXXX XXXX"
                                                                           autocomplete="off" maxlength="19"
                                                                           minlength="19">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1 pr-1">
                                                                <div class="form-group">
                                                                    <label>MM</label>
                                                                    <input type="number" class="form-control g-disabld"
                                                                           name="mes[]" id="mes" placeholder="MM"
                                                                           autocomplete="off"
                                                                           onkeypress="return onlyNumbers(event)"
                                                                           maxlength="2"
                                                                           oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1 pr-1">
                                                                <div class="form-group">
                                                                    <label>AA</label>
                                                                    <input type="number" class="form-control g-disabld"
                                                                           name="anio[]" id="anio" placeholder="AA"
                                                                           autocomplete="off"
                                                                           onkeypress="return onlyNumbers(event)"
                                                                           maxlength="2"
                                                                           oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3 pr-1">
                                                                <div class="form-group">
                                                                    <label>Nombre en la tarjeta</label>
                                                                    <input type="text" class="form-control g-disabld"
                                                                           name="nameInCard[]" id="nameInCard"
                                                                           onkeyup="mayus(this);" placeholder="Nombre"
                                                                           autocomplete="off"
                                                                           onkeypress="return onlyLetters(event)"
                                                                           maxlength="100"
                                                                           oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 pr-1">
                                                                <div class="form-group">
                                                                    <label>Compañia</label>
                                                                    <select name="tipoTarjeta[]" id="tipoTarjeta"
                                                                            class="form-control listado-tipos g-disabld"
                                                                            autocomplete="off">
                                                                        <option value="">Seleccione una opción</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 pr-1">
                                                                <div class="form-group">
                                                                    <label>Institución bancaria</label>
                                                                    <select name="banco[]" id="banco"
                                                                            class="form-control listado-bancos g-disabld"
                                                                            autocomplete="off">
                                                                        <option value="">Seleccione una opción</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1 pr-1">
                                                                <div class="form-group box-referencia">
                                                                    <label>Referencia:</label>
                                                                    <input type="text"
                                                                           class="form-control g-disabld referencia"
                                                                           name="referencia[]" id="referencia"
                                                                           autocomplete="off">
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
                                                            <div class="col-md-3 pr-1">
                                                                <div class="form-group">
                                                                    <label>¿Tarjeta para pago recurrente?</label>
                                                                    <select id="tp2" name="tarjetaPrimaria[]"
                                                                            class="form-control g-disabld"
                                                                            autocomplete="off">
                                                                        <?php
                                                                        if ($prosaa) {
                                                                            ?>
                                                                            <option value="2" data-value="7" selected>
                                                                                No
                                                                            </option>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <option value="2" data-value="7" selected>
                                                                                No
                                                                            </option>
                                                                            <option value="1" data-value="7">Si</option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="from-group colCreDeb">
                                                                    <label>Tipo de tarjeta</label>
                                                                    <select name="tipoCreDeb[]" id="changeTipoTar2"
                                                                            class="form-control g-disabld">
                                                                        <option value="">
                                                                            Seleccione opción
                                                                        </option>
                                                                        <option value="1">
                                                                            Crédito
                                                                        </option>
                                                                        <option value="2">
                                                                            Débito
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="from-group">
                                                                    <label>Monto:</label>
                                                                    <input type="text" class="form-control g-disabld"
                                                                           name="montoT[]" id="montoTD"
                                                                           autocomplete="off" value="0.00"
                                                                           onkeypress="return onlyNumbers(event)"
                                                                           onkeyup="changeEntrance(); changeAPagar(); evalueEntranceTD(this.value)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="from-group box-msi2 d-none">
                                                                    <label>MSI:</label>
                                                                    <select id="msi2" name="msi[]"
                                                                            class="form-control g-disabld">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mPagoTarjeta">
                                                            <br>
                                                            <div class="col-md-2 pr-1">
                                                                <div class="form-group">
                                                                    <label>Número de tarjeta</label>
                                                                    <input class="form-control g-disabld"
                                                                           name="cardNumber[]" id="cardNumber2"
                                                                           placeholder="XXXX XXXX XXXX XXXX"
                                                                           autocomplete="off" maxlength="19"
                                                                           minlength="19">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1 pr-1">
                                                                <div class="form-group">
                                                                    <label>MM</label>
                                                                    <input type="number" class="form-control g-disabld"
                                                                           name="mes[]" id="mes2" placeholder="MM"
                                                                           autocomplete="off"
                                                                           onkeypress="return onlyNumbers(event)"
                                                                           maxlength="2"
                                                                           oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1 pr-1">
                                                                <div class="form-group">
                                                                    <label>AA</label>
                                                                    <input type="number" class="form-control g-disabld"
                                                                           name="anio[]" id="anio2" placeholder="AA"
                                                                           autocomplete="off"
                                                                           onkeypress="return onlyNumbers(event)"
                                                                           maxlength="2"
                                                                           oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 pr-1">
                                                                <div class="form-group">
                                                                    <label>Nombre en la tarjeta</label>
                                                                    <input type="text" class="form-control g-disabld"
                                                                           name="nameInCard[]" id="nameInCard2"
                                                                           onkeyup="mayus(this);" placeholder="Nombre"
                                                                           autocomplete="off"
                                                                           onkeypress="return onlyLetters(event)"
                                                                           maxlength="100"
                                                                           oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 pr-1">
                                                                <div class="form-group">
                                                                    <label>Tipo</label>
                                                                    <select name="tipoTarjeta[]" id="tipoTarjeta2"
                                                                            class="form-control listado-tipos g-disabld"
                                                                            autocomplete="off">
                                                                        <option value="">Seleccione una opción</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 pr-1">
                                                                <div class="form-group">
                                                                    <label>Institución bancaria</label>
                                                                    <select name="banco[]" id="banco2"
                                                                            class="form-control listado-bancos g-disabld"
                                                                            autocomplete="off">
                                                                        <option value="">Seleccione una opción</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1 pr-1">
                                                                <div class="form-group box-referencia">
                                                                    <label>Referencia:</label>
                                                                    <input type="text"
                                                                           class="form-control g-disabld referencia"
                                                                           name="referencia[]" id="referencia"
                                                                           autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> <!-- End tab-pane tarjeta 2-->
                                                </div> <!-- End tab-content general tarjetas-->
                                            </div> <!-- End div box-card-->
                                            <div id="box-tb" class="d-none">
                                                <h4>Datos de transferencia bancaria</h4>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group box-referencia">
                                                            <label>Clave de rastreo:</label>
                                                            <input type="text" class="form-control"
                                                                   name="clave_rastreo_tb" class="clave_rastreo_tb"
                                                                   id="clave_rastreo_tb" autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group box-referencia">
                                                            <label>Monto:</label>
                                                            <input type="text" class="form-control monto_tb"
                                                                   name="monto_tb" id="monto_tb" autocomplete="off"
                                                                   value="0.00" onkeypress="return onlyNumbers(event);"
                                                                   onkeyup="changeEntrance(); changeAPagar(); evalueEntranceTB(this.value)">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- End div box-tb-->
                                            <br>
                                            <hr>
                                            <div class="box-detalle-fin">
                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <?php
                                                        if ($compartido == 0) {
                                                            ?>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <label for="compartida">
                                                                        Venta compartida
                                                                    </label>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <input id="compartida" class="g-disabld" name="compartida" type="checkbox"/>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-12 box-compartida select-disabld d-none">
                                                                    <!--<select id="enfermeras" name="enfermeras" class="form-control listado-enfermeras"></select>-->
                                                                    <select id="enfermeras" name="enfermeras[]" multiple class="form-control select-disabld listado-enfermeras">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>

                                                    <div class="col-sm-7">
                                                        <div class="row">
                                                            <div class="col-sm-10 text-right">
                                                                <p>A pagar anticipo:</p>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <input type="number" class="form-control" name="aPagar" id="aPagar" placeholder="0.00" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-10 text-right">
                                                                <p>Entrada:</p>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <input type="number" class="form-control" name="entrada" id="entrada" placeholder="0.00" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <center>
                                                        <button id="btnsubmit" type="submit" class="btn" disabled>
                                                            Finalizar venta
                                                        </button>
                                                    </center>
                                                </div>
                                            </div> <!-- End row submit button -->
                                            <div class="row" id="documentsTable" style="display:none;">
                                                <div class="col-md-12 pr-1">
                                                    <table class="table">
                                                        <thead class="thead-dark-first">
                                                        <tr>
                                                            <th colspan="2" scope="col"><h5>Documentos</h5></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <th scope="row">Recibo de Pago</th>
                                                            <td>
                                                                <i class="fas fa-print documents" onClick="imprimirReciboPago();"></i>
                                                                <i title="Escanear recibo de pago." class="fas fa-copy documents" onclick="scanRecibo();"></i>
                                                                <i title="Ver recibo escaneado" class="fas fa-eye eye-recibo documents" onclick="showDocument5()" style="display:none;"></i>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">1 Contrato</th>
                                                            <td>
                                                                <i class="fas fa-print documents" onClick="imprimirContrato();"></i>
                                                                <i title="Escanear contrato firmado." class="fas fa-copy documents" onclick="scanContrato();"></i>
                                                                <i title="Ver contrato firmado" class="fas fa-eye eye-contrato documents" onclick="showDocument3()" style="display:none;"></i>
                                                            </td>
                                                        </tr>
                                                        <tr id="tarjeta-row" style="display:none;">
                                                            <th scope="row">3 Tarjeta</th>
                                                            <td>
                                                                <i title="Escanear tarjeta." class="fas fa-copy" onclick="scanTarjeta();"></i>
                                                                <i title="Ver tarjeta" class="fas fa-eye eye-tarjeta documents" onclick="showDocument2()" style="display:none;"></i>
                                                            </td>
                                                        </tr>
                                                        <tr id="carta-prosa-row" style="display:none;">
                                                            <th scope="row">4 Carta prosa</th>
                                                            <td>
                                                                <i class="fas fa-print documents" onClick="imprimirCartaProsa();"></i>
                                                                <i title="Escanear carta prosa." class="fas fa-copy documents" onclick="scanCarta();"></i>
                                                                <i title="Ver carta prosa." class="fas fa-eye eye-cprosa documents" onclick="showDocument4()" style="display:none;"></i>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-12 d-flex justify-content-center">
                                                    <button id="btn-save-documents"
                                                            title="Guarda los documentos previamente escaneados en su expediente."
                                                            type="button" class="btn btn-plus btn-circle center d-none"
                                                            style="width:13%; height:40px;">GUARDAR
                                                    </button>
                                                </div>

                                                <div class="col-md-12">
                                                    <input type="hidden" class="form-control" name="id_cliente[]" id="id_titular1" value="<?= $id_cliente0 ?>">
                                                    <input type="hidden" class="form-control" name="id_cliente[]" id="id_titular2" value="<?= $id_cliente1 ?>">
                                                    <input type="hidden" class="form-control" name="id_cliente[]" id="id_titular3" value="<?= $id_cliente2 ?>">
                                                    <input type="hidden" class="form-control" name="id_cliente[]" id="id_titular4" value="<?= $id_cliente3 ?>">
                                                    <input type="hidden" class="form-control" name="id_cliente[]" id="id_titular5" value="<?= $id_cliente4 ?>">
                                                    <input type="hidden" class="form-control" name="id_contrato" id="id_contrato" value="<?= $id_contrato ?>">
                                                    <input type="hidden" class="form-control" name="id_expediente" id="id_expediente" value="<?= $id_expediente ?>">
                                                </div>

                                                <div class="col-md-12">
                                                    <input type="hidden" class="form-control" name="id_paquete[]" id="id_paquete1" value="<?= $id_paquete0 ?>">
                                                    <input type="hidden" class="form-control" name="id_paquete[]" id="id_paquete2" value="<?= $id_paquete1 ?>">
                                                    <input type="hidden" class="form-control" name="id_paquete[]" id="id_paquete3" value="<?= $id_paquete2 ?>">
                                                    <input type="hidden" class="form-control" name="id_paquete[]" id="id_paquete4" value="<?= $id_paquete3 ?>">
                                                    <input type="hidden" class="form-control" name="id_paquete[]" id="id_paquete5" value="<?= $id_paquete4 ?>">
                                                </div>

                                            </div> <!-- End div row documentsTable-->
                                            <div class="row">
                                                <div class="col-md-2 pr-1">
                                                    <div id="response" style="display: none;"></div>
                                                    <div class="form-group" style="position: relative;">
                                                        <input type="hidden" name="ine_nameFile" id="ine_nameFile" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 pr-1">
                                                    <div id="response2" style="display: none;"></div>
                                                    <div class="form-group">
                                                        <input type="hidden" name="tarjeta_nameFile" id="tarjeta_nameFile" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 pr-1">
                                                    <div id="response3" style="display: none;"></div>
                                                    <div class="form-group">
                                                        <input type="hidden" name="contrato_nameFile" id="contrato_nameFile" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 pr-1">
                                                    <div id="response4" style="display: none;"></div>
                                                    <div class="form-group">
                                                        <input type="hidden" name="cprosa_nameFile" id="cprosa_nameFile" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 pr-1">
                                                    <div id="response5" style="display: none;"></div>
                                                    <div class="form-group" style="position: relative;">
                                                        <input type="hidden" name="recibo_nameFile" id="recibo_nameFile">
                                                    </div>
                                                </div>
                                            </div> <!-- End row files attributes-->
                                        </div><!-- End taab-content-->
                                    </form><!-- End form -->
                                </div> <!-- End card-body -->
                            </div> <!-- End div calss="" -->
                        </div> <!-- End box-header with-border -->
                    </div> <!-- End tab content box-body -->
                </div> <!--End tab box -->
            </div> <!-- end col -->
        </div> <!-- End row -->
    </div> <!-- End container-fluid -->
</div> <!-- End content -->
</div>
</div>

<!-- MODALS -->
<div id="modalSaveDocuments" class="modal fade" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div>
                    <center><img src='<?= base_url("assets/img/add_documento.png") ?>'
                                 style='width:110px; height: 120px'></center>
                </div>
                <center><label><b>Los archivos se han guardado correctamente.</b></label></center>
                <center>
                    <button type="button" class="btn btn-body" data-dismiss="modal" onClick="reloadPage();">Aceptar
                    </button>
                </center>
            </div>
            <div class="modal-footer"></div>
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

<div id="modalId" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: #525659;">
            <div class="modal-body body-document" style="padding:0px; padding-bottom:10px">
            </div>
        </div>
    </div>
</div>

<div id="modalClientAdded" class="modal fade" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div>
                    <center><img src='<?= base_url("assets/img/add_cliente.png") ?>' style='width:120px; height: 120px'>
                    </center>
                </div>
                <center><label><b>Venta finalizada.</b></label></center>
                <center>
                    <button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button>
                </center>
            </div>
        </div>
    </div>
</div>

<div id="modalError" class="modal fade" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div>
                    <center><img src='<?= base_url("assets/img/falla.png") ?>' style='width:120px; height: 120px'>
                    </center>
                </div>
                <center><label><b>¡Algo salió mal. El archivo no fue cargado!</b></label></center>
                <center>
                    <button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button>
                </center>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<div id="modalUserCancel" class="modal fade" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div>
                    <center><img src='<?= base_url("assets/img/alerta.png") ?>' style='width:130px; height: 120px'>
                    </center>
                </div>
                <center><label><b>Proceso cancelado o interrumpido. El archivo no fue cargado.</b></label></center>
                <center>
                    <button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button>
                </center>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<div id="modalUploaded" class="modal fade" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div>
                    <center><img src='<?= base_url("assets/img/add_documento.png") ?>'
                                 style='width:110px; height: 120px'></center>
                </div>
                <center><label><b>El archivo ha sido cargado correctamente.</b></label></center>
                <center>
                    <button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button>
                </center>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<div id="modalEfectivo" class="modal fade modalCenter" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div>
                    <center><img src='<?= base_url("assets/img/alerta.png") ?>' style='width:120px; height: 120px'>
                    </center>
                </div>
                <center><label><b>Asegúrese de haber recibido la cantidad en efectivo</b></label></center>
                <center>
                    <button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button>
                </center>
            </div>
        </div>
    </div>
</div>

<div id="modalTipoArea" class="modal fade modalCenter" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content" style="padding: 30px 15px 0 15px;">
            <div class="modal-body mt-0 pt-0">
                <center><label class="m-0" style="font-size:20px; font-weight:500; color:#A95DB8"><b>Seleccione el
                            servicio</b></label></center>
                <center><label>Para continuar con la venta seleccione un tipo de tratamiento, por favor.</label>
                </center>
                <br>
                <div class="container d-flex justify-content-around p-0">
                    <button type="button" class="btn-area btn-depila" data-dismiss="modal" value="1"><img
                                src='<?= base_url("assets/img/hair_a.png") ?>' style="width:100%;">
                        <p>Depilación</p></button>
                    <button type="button" class="btn-area btn-moldeo" data-dismiss="modal" value="2"><img
                                src='<?= base_url("assets/img/body_a.png") ?>' style="width:100%;">
                        <p>Moldeo</p></button>
                    <button type="button" class="btn-area btn-facial" data-dismiss="modal" value="4"
                            onclick="disableFB();"><img src='<?= base_url("assets/img/syringe_a.png") ?>'
                                                        style="width:100%;">
                        <p>Facial</p></button>
                    <button type="button" class="btn-area btn-depmol" data-dismiss="modal" value="3">
                        <div><img src='<?= base_url("assets/img/depmol.png") ?>' style="width:100%;"></div>
                        <p style="font-size: 12px;">Dep. y Mol.</p>
                    </button>
                    <button type="button" class="btn-area btn-facmol" data-dismiss="modal" value="5">
                        <div><img src='<?= base_url("assets/img/rfmoldeo.png") ?>' style="width:100%;"></div>
                        <p style="font-size: 12px;">Facial y Mol.</p>
                    </button>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-end">
                <a class="btn btn-body" href="<?= base_url() ?>index.php/Home"
                   style="border:none; background-color:#bd98e0; color:#FFF">Cerrar</a>
            </div>
        </div>
    </div>
</div>
<!-- END MODALS -->

<!-- HTML para Spinner-->
<div id="loader" class="lds-dual-ring hidden overlay"></div>
<!-- END HTML para Spinner -->

<!-- Estilos para Spinner-->
<style>
    .nav-tabs .active {
        border-bottom: 2px solid #b3a7c4;
        color: #b3a5c5 !important;
    }

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
<!-- Estilos para Spinner-->

<script>
    var precioFinal;
</script>

<!-- SCRIPT PARA ESCANEO -->
<script>
    let clte_datail6 = <?php echo json_encode($clte_datail0);?>;
    let clte_datail7 = <?php echo json_encode($clte_datail1);?>;
    let clte_datail8 = <?php echo json_encode($clte_datail2);?>;
    let clte_datail9 = <?php echo json_encode($clte_datail3);?>;
    let clte_datail10 = <?php echo json_encode($clte_datail4);?>;


    let arrayTratamientos1 = [];
    let arrayTratamientos2 = [];
    let arrayTratamientos3 = [];
    let arrayTratamientos4 = [];
    let arrayTratamientos5 = [];

    let arrayTratamientosOld1 = [];
    let arrayTratamientosOld2 = [];
    let arrayTratamientosOld3 = [];
    let arrayTratamientosOld4 = [];
    let arrayTratamientosOld5 = [];
    let venus = false;

    function scanIne() {
        var opc = "INE";
        scanner.scan(displayResponseOnPage,
            {
                "output_settings": [
                    {
                        "type": "upload",
                        "format": "pdf",
                        "upload_target": {
                            "url": "https://bodyeffect.gphsis.com/index.php/Clientes/saveFile/" + opc,
                            "post_fields": {
                                "sample-field": "INE scan"
                            }
                        }
                    }
                ]
            }
        );
    }

    function scanTarjeta() {
        var opc = "TARJETA";
        scanner.scan(displayResponseOnPageTwo,
            {
                "output_settings": [
                    {
                        "type": "upload",
                        "format": "pdf",
                        "upload_target": {
                            "url": "https://bodyeffect.gphsis.com/index.php/Clientes/saveFile/" + opc,
                            "post_fields": {
                                "sample-field": "Tarjeta scan"
                            }
                        }
                    }
                ]
            }
        );
    }

    function scanContrato() {
        var opc = "CONTRATO";
        scanner.scan(displayResponseOnPageThree,
            {
                "output_settings": [
                    {
                        "type": "upload",
                        "format": "pdf",
                        "upload_target": {
                            "url": "https://bodyeffect.gphsis.com/index.php/Clientes/saveFile/" + opc,
                            "post_fields": {
                                "sample-field": "Contrato scan"
                            }
                        }
                    }
                ]
            }
        );
    }

    function scanCarta() {
        var opc = "CPROSA";
        scanner.scan(displayResponseOnPageFour,
            {
                "output_settings": [
                    {
                        "type": "upload",
                        "format": "pdf",
                        "upload_target": {
                            "url": "https://bodyeffect.gphsis.com/index.php/Clientes/saveFile/" + opc,
                            "post_fields": {
                                "sample-field": "Carta scan"
                            }
                        }
                    }
                ]
            }
        );
    }

    function scanRecibo() {
        var opc = "RECIBO";
        scanner.scan(displayResponseOnPageFive,
            {
                "output_settings": [
                    {
                        "type": "upload",
                        "format": "pdf",
                        "upload_target": {
                            "url": "https://bodyeffect.gphsis.com/index.php/Clientes/saveFile/" + opc,
                            "post_fields": {
                                "sample-field": "Test scan"
                            }
                        }
                    }
                ]
            }
        );
    }

    function displayResponseOnPage(successful, mesg, response) {
        if (!successful) {
            document.getElementById('response').innerHTML = 'Failed: ' + mesg;
            jQuery("#modalError").modal("show");
            return;
        }
        if (successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) { // User cancelled.
            document.getElementById('response').innerHTML = 'User cancelled';
            jQuery("#modalUserCancel").modal("show");
            return;
        }
        jQuery("#modalUploaded").modal("show");
        $('.eye-id').removeAttr("style");
        var file_name = scanner.getUploadResponse(response);
        $("#ine_nameFile").val(file_name);        
    }

    function displayResponseOnPageTwo(successful, mesg, response) {
        if (!successful) {
            document.getElementById('response2').innerHTML = 'Failed: ' + mesg;
            jQuery("#modalError").modal("show");
            return;
        }
        if (successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) { // User cancelled.
            document.getElementById('response2').innerHTML = 'User cancelled';
            jQuery("#modalUserCancel").modal("show");
            return;
        }
        jQuery("#modalUploaded").modal("show");
        $('.eye-tarjeta').removeAttr("style");
        var file_name = scanner.getUploadResponse(response);
        $("#tarjeta_nameFile").val(file_name);
    }

    function displayResponseOnPageThree(successful, mesg, response) {
        if (!successful) {
            document.getElementById('response3').innerHTML = 'Failed: ' + mesg;
            jQuery("#modalError").modal("show");
            return;
        }
        if (successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) { // User cancelled.
            document.getElementById('response3').innerHTML = 'User cancelled';
            jQuery("#modalUserCancel").modal("show");
            return;
        }
        jQuery("#modalUploaded").modal("show");
        $('.eye-contrato').removeAttr("style");
        var file_name = scanner.getUploadResponse(response);
        $("#contrato_nameFile").val(file_name);        
    }

    function displayResponseOnPageFour(successful, mesg, response) {
        if (!successful) {
            document.getElementById('response4').innerHTML = 'Failed: ' + mesg;
            jQuery("#modalError").modal("show");
            return;
        }
        if (successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) { // User cancelled.
            document.getElementById('response4').innerHTML = 'User cancelled';
            jQuery("#modalUserCancel").modal("show");
            return;
        }
        jQuery("#modalUploaded").modal("show");
        $('.eye-cprosa').removeAttr("style");
        var file_name = scanner.getUploadResponse(response);
        $("#cprosa_nameFile").val(file_name);        
    }

    function displayResponseOnPageFive(successful, mesg, response){
        if (!successful) {
            document.getElementById('response5').innerHTML = 'Failed: ' + mesg;
            jQuery("#modalError").modal("show");
            return;
        }
        if (successful && mesg != null && mesg.toLowerCase().indexOf('user cancel') >= 0) { // User cancelled.
            document.getElementById('response5').innerHTML = 'User cancelled';
            jQuery("#modalUserCancel").modal("show");
            return;
        }
        jQuery("#modalUploaded").modal("show");
        $('.eye-recibo').removeAttr("style");
        var file_name = scanner.getUploadResponse(response);
        $("#recibo_nameFile").val(file_name);        
    }

    function reloadPage() {
        //location.reload();
        window.location.href = "<?=base_url()?>index.php/ListaClientes";
    }

    function showDocument2() {
        $('.nameTittle').text("Tarjeta");
        $(".embed-doc").remove();
        $(".btn-closing").remove();
        var id = $(this).attr("id");
        var nameFile = $("#tarjeta_nameFile").val();
        $(".body-document").append('<embed class="embed-doc" src="<?= base_url("assets/expediente/TARJETA/'+nameFile+'")?>" frameborder="0" width="100%" height="600px" ><div class="modal-footer btn-closing" style="padding: 0 15px; display: flex;justify-content: flex-end;"><button type="button" class="btn btn-body" data-dismiss="modal" style="border:none; background-color:#323639; color:#FFF">Cerrar</button></div>');
        jQuery("#modalId").modal("show");
    }

    function showDocument3() {
        $('.nameTittle').text("Contrato");
        $(".embed-doc").remove();
        $(".btn-closing").remove();
        var id = $(this).attr("id");
        var nameFile = $("#contrato_nameFile").val();
        $(".body-document").append('<embed class="embed-doc" src="<?= base_url("assets/expediente/CONTRATO/'+nameFile+'")?>" frameborder="0" width="100%" height="600px" ><div class="modal-footer btn-closing" style="padding: 0 15px; display: flex;justify-content: flex-end;"><button type="button" class="btn btn-body" data-dismiss="modal" style="border:none; background-color:#323639; color:#FFF">Cerrar</button></div>');
        jQuery("#modalId").modal("show");
    }

    function showDocument4() {
        $('.nameTittle').text("Contrato");
        $(".embed-doc").remove();
        $(".btn-closing").remove();
        var id = $(this).attr("id");
        var nameFile = $("#cprosa_nameFile").val();
        $(".body-document").append('<embed class="embed-doc" src="<?= base_url("assets/expediente/CPROSA/'+nameFile+'")?>" frameborder="0" width="100%" height="600px"><div class="modal-footer btn-closing" style="padding: 0 15px; display: flex;justify-content: flex-end;"><button type="button" class="btn btn-body" data-dismiss="modal" style="border:none; background-color:#323639; color:#FFF">Cerrar</button></div>');
        jQuery("#modalId").modal("show");
    }

    function showDocument5() {
        $('.nameTittle').text("Recibo");
        $(".embed-doc").remove();
        $(".btn-closing").remove();
        var id = $(this).attr("id");
        var nameFile = $("#recibo_nameFile").val();
        $(".body-document").append('<embed class="embed-doc" src="<?= base_url("assets/expediente/RECIBO/'+nameFile+'")?>" frameborder="0" width="100%" height="600px"><div class="modal-footer btn-closing" style="padding: 0 15px; display: flex;justify-content: flex-end;"><button type="button" class="btn btn-body" data-dismiss="modal" style="border:none; background-color:#323639; color:#FFF">Cerrar</button></div>');
        jQuery("#modalId").modal("show");
    }

    function imprimirContrato() {
        var index_cliente = $('#id_titular1').val();
        var id_contrato = $('#id_contrato').val();
        window.open(url + "index.php/Archivos/contrato/" + index_cliente + "/" + id_contrato);
    }

    function imprimirCartaProsa() {
        var index_cliente = $('#id_titular1').val();
        var id_contrato = $('#id_contrato').val();
        window.open(url + "index.php/Archivos/carta/" + id_contrato);
    }

    function imprimirReciboPago() {
        var index_contrato = $('#id_contrato').val();
        var index_cliente = $('#id_titular1').val();
        window.open(url + "index.php/Archivos/recibo/" + index_contrato);
    }

</script>
<!-- SCRIPT PARA ESCANEO -->

<script>
    //Aplica el multiselect al select "areas"
    $(".areas").select2({
        allowClear: false,
    }).on("select2:unselecting", function (e) {
        $(this).data('state', 'unselected');
    }).on("select2:open", function (e) {
        if ($(this).data('state') === 'unselected') {
            $(this).removeData('state');
            jQuery(".areas").select2('close');
        }
    });

    //Aplica el multiselect al select "tratamientos"
    $(".tratamientos").select2({
        allowClear: false
    }).on("select2:unselecting", function (e) {
        $(this).data('state', 'unselected');
    }).on("select2:open", function (e) {
        if ($(this).data('state') === 'unselected') {
            $(this).removeData('state');
            jQuery(".tratamientos").select2('close');
        }
    });

    $(".listado-enfermeras").select2({
        allowClear: false
    }).on("select2:unselecting", function (e) {
        $(this).data('state', 'unselected');
    }).on("select2:open", function (e) {
        if ($(this).data('state') === 'unselected') {
            $(this).removeData('state');
            jQuery(".listado-enfermeras").select2('close');
        }
    });

    //Unordered select
    $(".areas").on("select2:select", function (evt) {
        var element = evt.params.data.element;
        var $element = $(element);
        $element.detach();
        $(this).append($element);
        $(this).trigger("change");
    });

    $(".tratamientos").on("select2:select", function (evt) {
        var element = evt.params.data.element;
        var $element = $(element);

        $element.detach();
        $(this).append($element);
    });

    function changeFinalPrice() {
        precioFinal = parseInt($('#precioFinal2').val());
        if ($('#precioFinalC').val() < precioFinal) {
            $('#precioFinalC').val(precioFinal);
            validateAdvance();
            $(".pago-menor-div").remove();
            $(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El costo total del servicio no puede ser menor a $' + $precioFinal + '.</b></label></center> <center><button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button></center></div>');
            jQuery("#modalPagoMenor").modal("show");
        }
    }

    // FUNCIÓN QUE SE EJECUTA CUANDO EL ANTICIPO CAMBIA #PAGOCON VALIDA EL ANTICIPO
    function validateAdvance(){
        precioFinal = $('#precioFinalC').val();
        if ($('#precioFinalC').val() != 0) {

            $('#btnsubmit').show();
            $(".box-anticipo").removeClass('d-none');            
            if (precioFinal >= 10000) {
                $anticipo = parseInt($('#precioFinalC').val()) * 0.10;
                $('.protegidaS').addClass('d-none');
                //Calculamos el anticipo correctamente
                if (parseInt($('#precioFinalA').val()) == parseInt($('#pagoConA').val())) {
                    var anticipo = parseInt($('#precioFinalC').val()) * 0.10;
                    if ($('#pagoCon').val() < anticipo) {
                        $(".pago-menor-div").remove();
                        $(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El anticipo mínimo requerido es de $' + anticipo + '</b></label></center> <center><button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button></center></div>');
                        jQuery("#modalPagoMenor").modal("show");
                        $('#pagoCon').val(anticipo);
                        $('#aPagar').val(anticipo);
                        saldoPendienteCalc();
                    } 
                    else if (parseInt($('#precioFinalC').val()) - parseInt($('#pagoCon').val()) == 0) {
                        $("#parcialidades").empty();
                        $("#parcialidades").append('<option value="0">0</option>');
                        $("#parcialidades option[value='0']").attr("selected", true);
                        $('#parcialidades').prop('disabled', 'disabled');
                        $(".protegida").prop('checked', false);

                        $('.protegida').prop("disabled", true);
                        $('.box-protegida').addClass('d-none');
                        valorMensualidad();
                    } else if (parseInt($('#precioFinalC').val()) - parseInt($('#pagoCon').val()) < 0) {
                        $(".pago-menor-div").remove();
                        $(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El anticipo ingresado excede el costo total del servicio</b></label></center> <center><button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button></center></div>');
                        jQuery("#modalPagoMenor").modal("show");
                        $('#pagoCon').val(anticipo);
                        $('#aPagar').val(anticipo);
                        $("#parcialidades").empty();
                        $("#parcialidades").append('<option value="">Seleccione una opción</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option>');
                        $('#parcialidades').prop("disabled", false);
                        saldoPendienteCalc();
                    } else {
                        $("#parcialidades").empty();
                        $("#parcialidades").append('<option value="">Seleccione una opción</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option>');
                        $('#parcialidades').prop("disabled", false);
                        $('.protegida').prop("disabled", false);
                    }
                    saldoPendienteCalc();
                    $('.boxFormaPago').removeClass('d-none');
                } else {
                    var anticipo = (parseInt($('#precioFinalC').val()) * 0.10) - parseInt($('#pagoConA').val());
                    if (anticipo < 0) anticipo = 0;
                    saldoPendienteCalc();
                    // if ($('#pagoCon').val() < anticipo) {
                    //     $(".pago-menor-div").remove();
                    //     $(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El anticipo mínimo requerido es de $' + anticipo + '</b></label></center> <center><button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button></center></div>');
                    //     jQuery("#modalPagoMenor").modal("show");
                    //     $('#pagoCon').val(anticipo);
                    //     $('#aPagar').val(anticipo);
                    //     saldoPendienteCalc();
                    // } 
                    if (parseInt($('#precioFinalC').val()) - (parseInt($('#pagoCon').val()) + parseInt($('#pagoConA').val())) == 0) {
                        $("#parcialidades").empty();
                        $("#parcialidades").append('<option value="0">0</option>');
                        $("#parcialidades option[value='0']").attr("selected", true);
                        $('#parcialidades').prop('disabled', 'disabled');
                        $(".protegida").prop('checked', false);
                        $('.protegida').prop("disabled", true);
                        $('.box-protegida').addClass('d-none');
                        valorMensualidad();
                    } else if (parseInt($('#precioFinalC').val()) - (parseInt($('#pagoCon').val()) + parseInt($('#pagoConA').val())) < 0) {
                        $(".pago-menor-div").remove();
                        $(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El anticipo ingresado excede el costo total del servicio</b></label></center> <center><button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button></center></div>');
                        jQuery("#modalPagoMenor").modal("show");
                        $('#pagoCon').val(anticipo);
                        $('#aPagar').val(anticipo);
                        $("#parcialidades").empty();
                        $("#parcialidades").append('<option value="">Seleccione una opción</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option>');
                        $('#parcialidades').prop("disabled", false);
                        saldoPendienteCalc();
                    } else {
                        $("#parcialidades").empty();
                        $("#parcialidades").append('<option value="">Seleccione una opción</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option>');
                        $('#parcialidades').prop("disabled", false);
                        $('.protegida').prop("disabled", false);
                    }
                    $('.boxFormaPago').removeClass('d-none');
                }
            } else if (precioFinal < 10000) {
                if (parseInt($('#precioFinalA').val()) == parseInt($('#pagoConA').val())) {
                    $('.boxFormaPago').removeClass('d-none');
                    if ($('#pagoCon').val() < 1000 || $('#pagoCon').val() == '') {
                        $(".pago-menor-div").remove();
                        $(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El anticipo mínimo requerido es de $1,000</b></label></center> <center><button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button></center></div>');
                        jQuery("#modalPagoMenor").modal("show");
                        $('#pagoCon').val(1000);
                        $('#aPagar').val(1000);
                        $("#parcialidades").empty();
                        $("#parcialidades").append('<option value="">Seleccione una opción</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option>');
                        $('#parcialidades').prop("disabled", false);
                    } 
                    else if (parseInt($('#precioFinalC').val()) - parseInt($('#pagoCon').val()) == 0) {
                        $("#parcialidades").empty();
                        $("#parcialidades").append('<option value="0">0</option>');
                        $("#parcialidades option[value='0']").attr("selected", true);
                        $('#parcialidades').prop('disabled', 'disabled');
                        valorMensualidad();
                    } else if (parseInt($('#precioFinalC').val()) - parseInt($('#pagoCon').val()) < 0) {
                        $(".pago-menor-div").remove();
                        $(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El anticipo ingresado excede el costo total del servicio</b></label></center> <center><button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button></center></div>');
                        jQuery("#modalPagoMenor").modal("show");
                        $('#pagoCon').val(1000);
                        $('#aPagar').val(1000);
                        $("#parcialidades").empty();
                        $("#parcialidades").append('<option value="">Seleccione una opción</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option>');
                        $('#parcialidades').prop("disabled", false);
                    } else {
                        $("#parcialidades").empty();
                        $("#parcialidades").append('<option value="">Seleccione una opción</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option>');
                        $('#parcialidades').prop("disabled", false);
                    }
                    saldoPendienteCalc();
                } else {
                    if ($('#pagoCon').val() < 0 || $('#pagoCon').val() == '') {
                        $('#pagoCon').val(0);
                        $('#aPagar').val(0);
                        $("#parcialidades").empty();
                        $("#parcialidades").append('<option value="">Seleccione una opción</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option>');
                        $('#parcialidades').prop("disabled", false);
                        $('.boxFormaPago').addClass('d-none');
                        $('#btnsubmit').prop('disabled', false);
                        $('.protegidaS').removeClass('d-none');
                        $('#protegida1').prop('checked', false);
                        $('#protegida1').prop("disabled", false);
                    } 
                    else if (parseInt($('#precioFinalC').val()) - (parseInt($('#pagoCon').val()) + parseInt($('#pagoConA').val())) == 0) {
                        $("#parcialidades").empty();
                        $("#parcialidades").append('<option value="0">0</option>');
                        $("#parcialidades option[value='0']").attr("selected", true);
                        $('#parcialidades').prop('disabled', 'disabled');
                        $('.boxFormaPago').removeClass('d-none');
                        $('#btnsubmit').prop('disabled', true);
                        $('.protegidaS').addClass('d-none');
                        $('#protegida1').prop('checked', false);
                        $('#protegida1').prop("disabled", false);
                        valorMensualidad();
                    } else if (parseInt($('#precioFinalC').val()) - (parseInt($('#pagoCon').val()) + parseInt($('#pagoConA').val())) < 0) {
                        $(".pago-menor-div").remove();
                        $(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El anticipo ingresado excede el costo total del servicio</b></label></center> <center><button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button></center></div>');
                        jQuery("#modalPagoMenor").modal("show");
                        $('#pagoCon').val(0);
                        $('#aPagar').val(0);
                        $("#parcialidades").empty();
                        $("#parcialidades").append('<option value="">Seleccione una opción</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option>');
                        $('#parcialidades').prop("disabled", false);
                        $('.boxFormaPago').addClass('d-none');
                        $('.protegidaS').removeClass('d-none');
                        $('#protegida1').prop('checked', false);
                        $('#protegida1').prop("disabled", false);
                        $('#btnsubmit').prop('disabled', false);
                    } else if (parseInt($('#pagoCon').val()) == 0) {
                        $("#parcialidades").empty();
                        $("#parcialidades").append('<option value="">Seleccione una opción</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option>');
                        $('#parcialidades').prop("disabled", false);
                        $('.protegidaS').removeClass('d-none');
                        $('#protegida1').prop('checked', false);
                        $('#protegida1').prop("disabled", false);
                        $('#btnsubmit').prop('disabled', false);
                        $('.boxFormaPago').addClass('d-none');
                    } else {
                        $("#parcialidades").empty();
                        $("#parcialidades").append('<option value="">Seleccione una opción</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option>');
                        $('#parcialidades').prop("disabled", false);
                        $('.protegidaS').addClass('d-none');
                        $('#protegida1').prop('checked', false);
                        $('#protegida1').prop("disabled", false);
                        $('#btnsubmit').prop('disabled', true);
                        $('.boxFormaPago').removeClass('d-none');
                    }
                    saldoPendienteCalc();
                }
            }
        } else {
            $('#btnsubmit').hide();
            $('#aPagar').val(0);
            $('#pagoCon').val(0);
            saldoPendienteCalc();
            $('.box-anticipo').addClass('d-none');
            deselectMulti();
        }
    }


    function changeAPagar() {
        $('#aPagar').val($('#pagoCon').val());
    }

    function changeEntrance() {
        if ((parseInt($('#efectivo').val()) + parseInt($('#montoTU').val()) + parseInt($('#montoTD').val())) + parseInt($('#monto_tb').val()) < parseInt($('#aPagar').val())) $('#btnsubmit').prop('disabled', true);
        else $('#btnsubmit').prop('disabled', false);

        //Validar es venta protegida o normal.
        if ($('.protegida').is(':checked')) {
            changeAPagar();
            $("#entrada").val(parseInt($('#efectivo').val()));
            if (parseInt($('#efectivo').val()) < parseInt($('#aPagar').val())) $('#btnsubmit').prop('disabled', true);
            else $('#btnsubmit').prop('disabled', false);
        } else {
            changeAPagar();
            $("#entrada").val(parseInt($('#efectivo').val()) + parseInt($('#montoTU').val()) + parseInt($('#montoTD').val()) + parseInt($('#monto_tb').val()));
        }
    }

    function disableFields() {
        $('.field-disabld').attr('disabled', 'disabled');
        $('.select-disabld').attr('disabled', 'disabled');
        $('.form-check-input').attr('disabled', 'disabled');
        $('.g-disabld').attr('disabled', 'disabled');
        $('.multiselect').attr('disabled', 'disabled');
        $('.multiselect').css('background-color', '#F5F5F5');
        $('.multiselect').css('border', '1px solid #afafaf');
        $('#btnsubmit').hide();
        $('#btn_add').hide();
        $('#documentsTable').removeAttr("style");
        $('#btn-save-documents').removeClass('d-none');
    }

    function changePay() {
        var formas = 0;
        cleanTarjeta();
        $("#lblProtegida").addClass('d-none');
        var prote = true;
        $('#box-cash').addClass('d-none');
        $('#box-card').addClass('d-none');
        $('#box-tb').addClass('d-none');
        $('#montoTU').val('0.00');
        $('#montoTD').val('0.00');
        $('#efectivo').val('0.00');
        $('#monto_tb').val('0.00');
        $('#clave_rastreo_tb').val('');
        $.each($('#formaPago').val(), function (i, v) {
            if (v == 1) {
                //Regresamos al  estado inicial los tab, Validación*
                $('#box-cash').removeClass('d-none');
                $("#tarjeta1").addClass('active');
                $("#tarjeta1").addClass('show');
                $("#tarjeta2").removeClass('active');
                $("#tarjeta2").removeClass('show');
            }
            if (v == 2) {
                //Regresamos al  estado inicial los tab, Validación*
                $('#box-card').removeClass('d-none');
                $('#tabtjt2').removeClass('d-none');
                $('#tarjeta2').removeClass('d-none');
                $(".box-monto").removeClass('d-none');
                $("#referencia").removeClass('d-none');
                prote = false;
            }
            if (v == 6) {
                //Same
                $("#box-tb").removeClass('d-none');
                $("#tarjeta1").addClass('active');
                $("#tarjeta1").addClass('show');
                $("#tarjeta2").removeClass('active');
                $("#tarjeta2").removeClass('show');
            }
            formas++;
        });

        if (prote) {
            $('.protegida').prop("disabled", false);
        } else {
            $('.protegida').prop('disabled', true);
            $('.protegida').prop('checked', false);
            $('.box-protegida').addClass('d-none');
            $('#referencia').removeClass('d-none');
        }

        if (formas == 0) $(".box-detalle-fin").addClass('d-none');
        else $(".box-detalle-fin").removeClass('d-none');
    }

    function valorMensualidad() {
        $noMensualidades = $("#parcialidades option:selected").val();
        $costoMensualidad = (parseInt($("#precioFinalC").val()) - (parseInt($("#pagoCon").val())) - parseInt($("#pagoConA").val()))/ parseInt($noMensualidades);
        $("#label-payment").remove();

        $("#monthly-payments").html('');
        $("#monthly-inputs").html('');
        const options = {year: 'numeric', month: 'short', day: 'numeric'};

        var fecha1 = new Date();
        var day, day2;
        if (fecha1.getDate() > 15 && fecha1.getDate() < 30) {
            day = 30;
            day2 = 15;
        } else {
            day = 15;
            day2 = 30;
        }

        function createDate(fecha1, day) {
            if (fecha1.getDate() > 29) {
                if (fecha1.getMonth() == 0) {
                    fecha1.setDate(28);
                }
                fecha1.setMonth(fecha1.getMonth() + 1);
            } else if (fecha1.getDate() > 27 && fecha1.getMonth() == 1) {
                fecha1.setMonth(fecha1.getMonth() + 1);
            }
            if (fecha1.getMonth() == 1 && fecha1.getDate() < 29) {
                day = 28;
            }
            fecha1.setDate(day);
            return fecha1;
        }

        switch ($noMensualidades) {
            case '0':
                $("#monthly-payments").append('<label><b>Servicio liquidado</b></label>');
                break;
            case '1':
                var diaZ = createDate(fecha1, day);
                var dia1 = diaZ.getFullYear() + '-' + ('0' + (diaZ.getMonth() + 1)).slice(-2) + '-' + diaZ.getDate();
                $("#monthly-payments").append('<label id="label-payment">1° pago el próximo <input class="form-control-sm field-disabld" name="mensualidades[]"  type="date" value="' + dia1 + '"/> cada uno con un valor de <b>$' + formatMoney($costoMensualidad) + '</b></label><br>');
                break;

            case '2':
                var diaZ = createDate(fecha1, day);
                var dia1 = diaZ.getFullYear() + '-' + ('0' + (diaZ.getMonth() + 1)).slice(-2) + '-' + diaZ.getDate();
                var diaY = createDate(fecha1, day2);
                var dia2 = diaY.getFullYear() + '-' + ('0' + (diaY.getMonth() + 1)).slice(-2) + '-' + diaY.getDate();

                $("#monthly-payments").append('<label id="label-payment">1° pago el próximo <input class="form-control-sm field-disabld" name="mensualidades[]"  type="date" value="' + dia1 + '"/>  cada uno con un valor de <b>$' + formatMoney($costoMensualidad) + '</b></label><br>' + '<label id="label-payment">2° pago el próximo <input class="form-control-sm field-disabld" name="mensualidades[]" type="date" value="' + dia2 + '"/>  cada uno con un valor de <b>$' + formatMoney($costoMensualidad) + '</b></label><br>');
                break;

            case '3':
                var diaZ = createDate(fecha1, day);
                var dia1 = diaZ.getFullYear() + '-' + ('0' + (diaZ.getMonth() + 1)).slice(-2) + '-' + diaZ.getDate();
                var diaY = createDate(fecha1, day2);
                var dia2 = diaY.getFullYear() + '-' + ('0' + (diaY.getMonth() + 1)).slice(-2) + '-' + diaY.getDate();
                var diaX = createDate(fecha1, day);
                var dia3 = diaX.getFullYear() + '-' + ('0' + (diaX.getMonth() + 1)).slice(-2) + '-' + diaX.getDate();

                $("#monthly-payments").append('<label id="label-payment">1° pago el próximo <input class="form-control-sm field-disabld" name="mensualidades[]" type="date" value="' + dia1 + '"/> cada uno con un valor de <b>$' + formatMoney($costoMensualidad) + '</b></label><br>'
                    + '<label id="label-payment">2° pago el próximo <input class="form-control-sm field-disabld" name="mensualidades[]" type="date" value="' + dia2 + '"/> cada uno con un valor de <b>$' + formatMoney($costoMensualidad) + '</b></label><br>'
                    + '<label id="label-payment">3° pago el próximo <input class="form-control-sm field-disabld" name="mensualidades[]" type="date" value="' + dia3 + '"/> cada uno con un valor de <b>$' + formatMoney($costoMensualidad) + '</b></label><br>');
                break;

            case '4':
                var diaZ = createDate(fecha1, day);
                var dia1 = diaZ.getFullYear() + '-' + ('0' + (diaZ.getMonth() + 1)).slice(-2) + '-' + diaZ.getDate();
                var diaY = createDate(fecha1, day2);
                var dia2 = diaY.getFullYear() + '-' + ('0' + (diaY.getMonth() + 1)).slice(-2) + '-' + diaY.getDate();
                var diaX = createDate(fecha1, day);
                var dia3 = diaX.getFullYear() + '-' + ('0' + (diaX.getMonth() + 1)).slice(-2) + '-' + diaX.getDate();
                var diaW = createDate(fecha1, day2);
                var dia4 = diaW.getFullYear() + '-' + ('0' + (diaW.getMonth() + 1)).slice(-2) + '-' + diaW.getDate();

                $("#monthly-payments").append('<label id="label-payment">1° pago el próximo <input class="form-control-sm field-disabld" name="mensualidades[]" type="date" value="' + dia1 + '"/> cada uno con un valor de <b>$' + formatMoney($costoMensualidad) + '</b></label><br>'
                    + '<label id="label-payment">2° pago el próximo <input class="form-control-sm field-disabld" name="mensualidades[]" type="date" value="' + dia2 + '"/> cada uno con un valor de <b>$' + formatMoney($costoMensualidad) + '</b></label><br>'
                    + '<label id="label-payment">3° pago el próximo <input class="form-control-sm field-disabld" name="mensualidades[]" type="date" value="' + dia3 + '"/> cada uno con un valor de <b>$' + formatMoney($costoMensualidad) + '</b></label><br>'
                    + '<label id="label-payment">4° pago el próximo <input class="form-control-sm field-disabld" name="mensualidades[]" type="date" value="' + dia4 + '"/> cada uno con un valor de <b>$' + formatMoney($costoMensualidad) + '</b></label><br>');
                break;

            case '5':
                var diaZ = createDate(fecha1, day);
                var dia1 = diaZ.getFullYear() + '-' + ('0' + (diaZ.getMonth() + 1)).slice(-2) + '-' + diaZ.getDate();
                var diaY = createDate(fecha1, day2);
                var dia2 = diaY.getFullYear() + '-' + ('0' + (diaY.getMonth() + 1)).slice(-2) + '-' + diaY.getDate();
                var diaX = createDate(fecha1, day);
                var dia3 = diaX.getFullYear() + '-' + ('0' + (diaX.getMonth() + 1)).slice(-2) + '-' + diaX.getDate();
                var diaW = createDate(fecha1, day2);
                var dia4 = diaW.getFullYear() + '-' + ('0' + (diaW.getMonth() + 1)).slice(-2) + '-' + diaW.getDate();
                var diaV = createDate(fecha1, day);
                var dia5 = diaV.getFullYear() + '-' + ('0' + (diaV.getMonth() + 1)).slice(-2) + '-' + diaV.getDate();
                $("#monthly-payments").append('<label id="label-payment">1° pago el próximo <input class="form-control-sm field-disabld" name="mensualidades[]" type="date" value="' + dia1 + '"/> cada uno con un valor de <b>$' + formatMoney($costoMensualidad) + '</b></label><br>'
                    + '<label id="label-payment">2° pago el próximo <input class="form-control-sm field-disabld" name="mensualidades[]" type="date" value="' + dia2 + '"/> cada uno con un valor de <b>$' + formatMoney($costoMensualidad) + '</b></label><br>'
                    + '<label id="label-payment">3° pago el próximo <input class="form-control-sm field-disabld" name="mensualidades[]" type="date" value="' + dia3 + '"/> cada uno con un valor de <b>$' + formatMoney($costoMensualidad) + '</b></label><br>'
                    + '<label id="label-payment">4° pago el próximo <input class="form-control-sm field-disabld" name="mensualidades[]" type="date" value="' + dia4 + '"/> cada uno con un valor de <b>$' + formatMoney($costoMensualidad) + '</b></label><br>'
                    + '<label id="label-payment">5° pago el próximo <input class="form-control-sm field-disabld" name="mensualidades[]" type="date" value="' + dia5 + '"/> cada uno con un valor de <b>$' + formatMoney($costoMensualidad) + '</b></label><br>');

                break;

            case '6':
                var diaZ = createDate(fecha1, day);
                var dia1 = diaZ.getFullYear() + '-' + ('0' + (diaZ.getMonth() + 1)).slice(-2) + '-' + diaZ.getDate();
                var diaY = createDate(fecha1, day2);
                var dia2 = diaY.getFullYear() + '-' + ('0' + (diaY.getMonth() + 1)).slice(-2) + '-' + diaY.getDate();
                var diaX = createDate(fecha1, day);
                var dia3 = diaX.getFullYear() + '-' + ('0' + (diaX.getMonth() + 1)).slice(-2) + '-' + diaX.getDate();
                var diaW = createDate(fecha1, day2);
                var dia4 = diaW.getFullYear() + '-' + ('0' + (diaW.getMonth() + 1)).slice(-2) + '-' + diaW.getDate();
                var diaV = createDate(fecha1, day);
                var dia5 = diaV.getFullYear() + '-' + ('0' + (diaV.getMonth() + 1)).slice(-2) + '-' + diaV.getDate();
                var diaU = createDate(fecha1, day2);
                var dia6 = diaU.getFullYear() + '-' + ('0' + (diaU.getMonth() + 1)).slice(-2) + '-' + diaU.getDate();
                $("#monthly-payments").append('<label id="label-payment">1° pago el próximo <input class="form-control-sm field-disabld" name="mensualidades[]" type="date" value="' + dia1 + '"/> cada uno con un valor de <b>$' + formatMoney($costoMensualidad) + '</b></label><br>'
                    + '<label id="label-payment">2° pago el próximo <input class="form-control-sm field-disabld" name="mensualidades[]" type="date" value="' + dia2 + '"/> cada uno con un valor de <b>$' + formatMoney($costoMensualidad) + '</b></label><br>'
                    + '<label id="label-payment">3° pago el próximo <input class="form-control-sm field-disabld" name="mensualidades[]" type="date" value="' + dia3 + '"/> cada uno con un valor de <b>$' + formatMoney($costoMensualidad) + '</b></label><br>'
                    + '<label id="label-payment">4° pago el próximo <input class="form-control-sm field-disabld" name="mensualidades[]" type="date" value="' + dia4 + '"/> cada uno con un valor de <b>$' + formatMoney($costoMensualidad) + '</b></label><br>'
                    + '<label id="label-payment">5° pago el próximo <input class="form-control-sm field-disabld" name="mensualidades[]" type="date" value="' + dia5 + '"/> cada uno con un valor de <b>$' + formatMoney($costoMensualidad) + '</b></label><br>'
                    + '<label id="label-payment">6° pago el próximo <input class="form-control-sm field-disabld" name="mensualidades[]" type="date" value="' + dia6 + '"/> cada uno con un valor de <b>$' + formatMoney($costoMensualidad) + '</b></label><br>');
                break;
        }
        $("#monthly-payments").append('<br>');
    }

    function calcularAnticipo(){
        $('#pagoCon').val(0);
        $precioFinal = parseInt($('#precioFinalC').val());
        if(parseInt($("#precioFinalA").val()) == parseInt($("#pagoConA").val())){
            if ($precioFinal >= 10000) {
                $("#pagoCon").val($precioFinal * 0.10);
                $("#aPagar").val($precioFinal * 0.10);
            }
            else if ($precioFinal > 1000 && $precioFinal < 10000) {
                $("#pagoCon").val(1000);
                $("#aPagar").val(1000);
            }
            else{
                $("#pagoCon").val($precioFinal);
                $("#aPagar").val($precioFinal);
            }
        }
        else{
            if ($precioFinal >= 10000) {
                $("#pagoCon").val(($precioFinal * 0.10) - parseInt($("#pagoConA").val()));
                $("#aPagar").val(($precioFinal * 0.10) - parseInt($("#pagoConA").val()));
            }
            else if ($precioFinal > 1000 && $precioFinal < 10000) {
                $("#pagoCon").val(1000 - parseInt($("#pagoConA").val()));
                $("#aPagar").val(1000 - parseInt($("#pagoConA").val()));
            }
            else{
                $("#pagoCon").val($precioFinal);
                $("#aPagar").val($precioFinal);
            }
        }
        validateAdvance();
    }

    function resetAnticipoAreasIf() {
        var valor = parseInt(unmaskMoney($(".rate-sl1").val())) + parseInt(unmaskMoney($(".rate-sl2").val())) + parseInt(unmaskMoney($(".rate-sl3").val())) + parseInt(unmaskMoney($(".rate-sl4").val())) + parseInt(unmaskMoney($(".rate-sl5").val()));
        $("#total").val(valor);

        var areas = parseInt($(".total-areas1").val()) + parseInt($(".total-areas2").val()) + parseInt($(".total-areas3").val()) + parseInt($(".total-areas4").val()) + parseInt($(".total-areas5").val());

        $(".total-areas").val(areas);

        if (parseInt($(".total-areas").val()) == 1) {
            $("#descuento").val(parseInt($("#total").val()) * 0.40);
        }
        if (parseInt($(".total-areas").val()) == 2) {
            $("#descuento").val(parseInt($("#total").val()) * 0.50);
        }
        if (parseInt($(".total-areas").val()) == 3) {
            $("#descuento").val(parseInt($("#total").val()) * 0.60);
        }
        if (parseInt($(".total-areas").val()) >= 4) {
            $("#descuento").val(parseInt($("#total").val()) * 0.65);
        }

        
        $(".precioFinal").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
        $(".precioFinal2").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
        $("#precioFinalC").val(parseInt($(".precioFinal").val()) + parseInt($("#totalrf").val()));

        validateAdvance();
        changeAPagar();
        changeEntrance();
        valorMensualidad();
    }

    function resetAnticipoAreasElse() {
        var valor = parseInt(unmaskMoney($(".rate-sl1").val())) + parseInt(unmaskMoney($(".rate-sl2").val())) + parseInt(unmaskMoney($(".rate-sl3").val())) + parseInt(unmaskMoney($(".rate-sl4").val())) + parseInt(unmaskMoney($(".rate-sl5").val()));
        $("#total").val(valor);
        var areas = parseInt($(".total-areas1").val()) + parseInt($(".total-areas2").val()) + parseInt($(".total-areas3").val()) + parseInt($(".total-areas4").val()) + parseInt($(".total-areas5").val());
        $(".total-areas").val(areas);

        if (parseInt($(".total-areas").val()) == parseInt($("#areasa").val())) {
            $("#descuento").val(0);
            $("#precioFinalC").val(0);
            $("#precioFinal2").val(0);
        } else {
            if (parseInt($(".total-areas").val()) == 1)
                $("#descuento").val(parseInt($("#total").val()) * 0.40);

            if (parseInt($(".total-areas").val()) == 2)
                $("#descuento").val(parseInt($("#total").val()) * 0.50);

            if (parseInt($(".total-areas").val()) == 3)
                $("#descuento").val(parseInt($("#total").val()) * 0.60);

            if (parseInt($(".total-areas").val()) >= 4)
                $("#descuento").val(parseInt($("#total").val()) * 0.65);

            
            $(".precioFinal").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $(".precioFinal2").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $("#precioFinalC").val(parseInt($(".precioFinal").val()) + parseInt($("#totalrf").val()));
        }

        validateAdvance();
        changeAPagar();
        changeEntrance();
        valorMensualidad();
    }

    $('#select1').change(function () {
        // Obtenemos el total de opiones seleccionadas
        var slValue = $(this).val();
        if (slValue != undefined && slValue != null && slValue != '') {
            var contador = $('.select-uno option:selected').length;
            $(".total-areas1").val(contador);
            $(".row-tbl1").remove();
            if ($('.select-uno option:selected').length > 0) {
                var noArea = 1;
                var tarifas1 = $('.select-uno option:selected').map(function () {
                    $("#tbody-areas1").append('<tr class="row-tbl1" style="text-align:center"><td>' + noArea + '</td><td>' + $(this).attr("tipo") + '</td><td>' + $(this).attr("no-sesion") + '</td><td>' + $(this).attr("nombre") + '</td><td>$' + formatMoney($(this).attr("data-value")) + '</td></tr>');
                    noArea++;
                    return $(this).attr("data-value");
                }).get();
            }

            var suma1 = 0;
            if (tarifas1 != undefined) {
                for (i = 0; i < tarifas1.length; i++) {
                    suma1 = (suma1 + parseInt(tarifas1[i]));
                }
            }

            $(".precioFinal").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $(".precioFinal2").val(parseInt($("#total").val()) - parseInt($("#descuento").val()));
            $("#precioFinalC").val(parseInt($(".precioFinal").val()) + parseInt($("#totalrf").val()));


            //Evaluamos si el el precio total anterior es igual al anticipo, significa que está saldado
            if (parseInt($('#precioFinalA').val()) == parseInt($('#pagoConA').val())) $(".rate-sl1").val('$'+formatMoney(suma1));
            else $(".rate-sl1").val('$' + formatMoney(suma1));

            //Función para asignar total en base a las áreas seleccionadas
            resetAnticipoAreasIf();
        } else {
            $(".total-areas1").val($(".total-areaa1").val());
            $(".row-tbl1").remove();
            $(".rate-sl1").val('$' + formatMoney(0));
            //Función para reajustar el anticipo en caso de que el select esté vacio
            resetAnticipoAreasElse();
        }

    });

    // Obtiene total respecto a las áreas seleccionadas select2T
    $('.select-dos').change(function () {
        // Obtenemos el total de opiones seleccionadas
        var slValue = $(this).val();
        if (slValue != undefined && slValue != null && slValue != '') {
            var contador = $('.select-dos option:selected').length;
            $(".total-areas2").val(parseInt($(".total-areaa2").val()) + contador);
            $(".row-tbl2").remove();
            if ($('.select-dos option:selected').length > 0) {
                var noArea = 1;
                var tarifas2 = $('.select-dos option:selected').map(function () {
                    $("#tbody-areas2").append('<tr class="row-tbl2" style="text-align:center"><td>' + noArea + '</td><td>' + $(this).attr("tipo") + '</td><td>' + $(this).attr("no-sesion") + '</td><td>' + $(this).attr("nombre") + '</td><td>$' + formatMoney($(this).attr("data-value")) + '</td></tr>');
                    noArea++;
                    return $(this).attr("data-value");
                }).get();
            }

            var suma2 = 0;
            if (tarifas2 != undefined) {
                for (i = 0; i < tarifas2.length; i++) {
                    suma2 = (suma2 + parseInt(tarifas2[i]));
                }
            }
            //Evaluamos si el el precio total anterior es igual al anticipo, significa que está saldado
            if (parseInt($('#precioFinalA').val()) == parseInt($('#pagoConA').val())) $(".rate-sl2").val('$'+formatMoney(suma2));
            else $(".rate-sl2").val('$' + formatMoney(suma2));

            //Función para asignar total en base a las áreas seleccionadas
            resetAnticipoAreasIf();
        } else {
            $(".total-areas2").val($(".total-areaa2").val());
            $(".row-tbl2").remove();
            $(".rate-sl2").val('$' + formatMoney(0));
            //Función para reajustar el anticipo en caso de que el select esté vacio
            resetAnticipoAreasElse();
        }
    });

    // Obtiene total respecto a las áreas seleccionadas select3
    $('.select-tres').change(function () {
        // Obtenemos el total de opiones seleccionadas
        var slValue = $(this).val();
        if (slValue != undefined && slValue != null && slValue != '') {
            var contador = $('.select-tres option:selected').length;
            $(".total-areas3").val(parseInt($(".total-areaa3").val()) + contador);
            $(".row-tbl3").remove();
            if ($('.select-tres option:selected').length > 0) {
                var noArea = 1;
                var tarifas3 = $('.select-tres option:selected').map(function () {
                    $("#tbody-areas3").append('<tr class="row-tbl3" style="text-align:center"><td>' + noArea + '</td><td>' + $(this).attr("tipo") + '</td><td>' + $(this).attr("no-sesion") + '</td><td>' + $(this).attr("nombre") + '</td><td>$' + formatMoney($(this).attr("data-value")) + '</td></tr>');
                    noArea++;
                    return $(this).attr("data-value");
                }).get();
            }

            var suma3 = 0;
            if (tarifas3 != undefined) {
                for (i = 0; i < tarifas3.length; i++) {
                    suma3 = (suma3 + parseInt(tarifas3[i]));
                }
            }
            //Evaluamos si el el precio total anterior es igual al anticipo, significa que está saldado
            if (parseInt($('#precioFinalA').val()) == parseInt($('#pagoConA').val())) $(".rate-sl3").val('$'+formatMoney(suma3));
            else $(".rate-sl3").val('$' + formatMoney(suma3));

            //Función para asignar total en base a las áreas seleccionadas
            resetAnticipoAreasIf();
        } else {
            $(".total-areas3").val($(".total-areaa3").val());
            $(".row-tbl3").remove();
            $(".rate-sl3").val('$' + formatMoney(0));
            //Función para reajustar el anticipo en caso de que el select este vacio
            resetAnticipoAreasElse();
        }
    });

    // Obtiene total respecto a las áreas seleccionadas select4
    $('.select-cuatro').change(function () {
        // Obtenemos el total de opiones seleccionadas
        var slValue = $(this).val();
        if (slValue != undefined && slValue != null && slValue != '') {
            var contador = $('.select-cuatro option:selected').length;
            $(".total-areas4").val(parseInt($(".total-areaa4").val()) + contador);
            $(".row-tbl4").remove();
            if ($('.select-cuatro option:selected').length > 0) {
                var noArea = 1;
                var tarifas4 = $('.select-cuatro option:selected').map(function () {
                    $("#tbody-areas4").append('<tr class="row-tbl4" style="text-align:center"><td>' + noArea + '</td><td>' + $(this).attr("tipo") + '</td><td>' + $(this).attr("no-sesion") + '</td><td>' + $(this).attr("nombre") + '</td><td>$' + formatMoney($(this).attr("data-value")) + '</td></tr>');
                    noArea++;
                    return $(this).attr("data-value");
                }).get();
            }

            var suma4 = 0;
            if (tarifas4 != undefined) {
                for (i = 0; i < tarifas4.length; i++) {
                    suma4 = (suma4 + parseInt(tarifas4[i]));
                }
            }
            //Evaluamos si el el precio total anterior es igual al anticipo, significa que está saldado
            if (parseInt($('#precioFinalA').val()) == parseInt($('#pagoConA').val())) $(".rate-sl4").val('$'+formatMoney(suma4));
            else $(".rate-sl4").val('$' + formatMoney(suma4));

            //Función para asignar total en base a las áreas seleccionadas
            resetAnticipoAreasIf();
        } else {
            $(".total-areas4").val($(".total-areaa4").val());
            $(".row-tbl4").remove();
            $(".rate-sl4").val('$' + formatMoney(0));

            //Función para reajustar el anticipo en caso de que el select este vacio
            resetAnticipoAreasElse();
        }
    });

    // Obtiene total respecto a las áreas seleccionadas select5
    $('.select-cinco').change(function () {
        // Obtenemos el total de opiones seleccionadas
        var slValue = $(this).val();
        if (slValue != undefined && slValue != null && slValue != '') {
            var contador = $('.select-cinco option:selected').length;
            $(".total-areas5").val(parseInt($(".total-areaa5").val()) + contador);
            $(".row-tbl5").remove();
            if ($('.select-cinco option:selected').length > 0) {
                var noArea = 1;
                var tarifas5 = $('.select-cinco option:selected').map(function () {
                    $("#tbody-areas5").append('<tr class="row-tbl5" style="text-align:center"><td>' + noArea + '</td><td>' + $(this).attr("tipo") + '</td><td>' + $(this).attr("no-sesion") + '</td><td>' + $(this).attr("nombre") + '</td><td>$' + formatMoney($(this).attr("data-value")) + '</td></tr>');
                    noArea++;
                    return $(this).attr("data-value");
                }).get();
            }

            var suma5 = 0;
            if (tarifas5 != undefined) {
                for (i = 0; i < tarifas5.length; i++) {
                    suma5 = (suma5 + parseInt(tarifas5[i]));
                }
            }
            //Evaluamos si el el precio total anterior es igual al anticipo, significa que está saldado
            if (parseInt($('#precioFinalA').val()) == parseInt($('#pagoConA').val())) $(".rate-sl5").val('$'+formatMoney(suma5));
            else $(".rate-sl5").val('$' + formatMoney(suma5));

            //Función para asignar total en base a las áreas seleccionadas
            resetAnticipoAreasIf();
        } else {
            $(".total-areas5").val($(".total-areaa5").val());
            $(".row-tbl5").remove();
            $(".rate-sl5").val('$' + formatMoney(0));

            //Función para reajustar el anticipo en caso de que el select este vacio
            resetAnticipoAreasElse();
        }
    });

    //Cambiar opción seleccionada tarjeta titular
    $("#tp1").change(function () {
        var valor = $(this).val();
        if (valor = 1) {
            $("#tp2").val(2);
        }
    });

    //Cambiar opción seleccionada tarjeta titular
    $("#tp2").change(function () {
        var valor = $(this).val();
        if (valor = 1) {
            $("#tp1").val(2);
        }
    });

    $('#changeTipoTar2').change(function () {
        $('.box-msi2').removeClass('d-none');
        $("#msi2").empty();
        if ($(this).val() == 2) {
            $("#msi2").append('<option value="0" selected>NORMAL</option>');
        } else {
            $("#msi2").append('<option value="">Seleccione una opción</option>');
            $("#msi2").append('<option value="0">NORMAL</option>');
            $("#msi2").append('<option value="3">3</option>');
            $("#msi2").append('<option value="6">6</option>');
            $("#msi2").append('<option value="9">9</option>');
            $("#msi2").append('<option value="12">12</option>');
        }
    });

    $('#changeTipoTar1').change(function () {
        if ($('.protegida').is(':checked')) {
            $('.box-msi').addClass('d-none');
            $("#msi1").empty();
            $("#msi1").append('<option value="0" selected>NORMAL</option>');
        } else {
            $('.box-msi').removeClass('d-none');
            $("#msi1").empty();
            if ($(this).val() == 2) {
                $("#msi1").append('<option value="0" selected>NORMAL</option>');
            } else {
                $("#msi1").append('<option value="">Seleccione una opción</option>');
                $("#msi1").append('<option value="0">NORMAL</option>');
                $("#msi1").append('<option value="3">3</option>');
                $("#msi1").append('<option value="6">6</option>');
                $("#msi1").append('<option value="9">9</option>');
                $("#msi1").append('<option value="12">12</option>');
            }
        }
    });

    function evalueEntranceE(e) {
        if (!$('.protegida').is(':checked')) {
            if (parseInt(e) + parseInt($('#montoTU').val()) + parseInt($('#montoTD').val()) + parseInt($('#monto_tb').val()) > parseInt($('#pagoCon').val())) {
                $(".pago-menor-div").remove();
                $(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El monto ingresado es mayor al anticipo</b></label></center> <center><button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button></center></div>');
                jQuery("#modalPagoMenor").modal("show");
                $("#efectivo").val('');
            }
        }
    }

    function evalueEntranceTU(e) {
        if (parseInt(e) + parseInt($('#efectivo').val()) + parseInt($('#montoTD').val()) + parseInt($('#monto_tb').val()) > parseInt($('#pagoCon').val())) {
            $(".pago-menor-div").remove();
            $(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El monto ingresado es mayor al anticipo</b></label></center> <center><button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button></center></div>');
            jQuery("#modalPagoMenor").modal("show");
            $("#montoTU").val('');
        }
    }

    function evalueEntranceTD(e) {
        if (parseInt(e) + parseInt($('#efectivo').val()) + parseInt($('#montoTU').val()) + parseInt($('#monto_tb').val()) > parseInt($('#pagoCon').val())) {
            $(".pago-menor-div").remove();
            $(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El monto ingresado es mayor al anticipo</b></label></center> <center><button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button></center></div>');
            jQuery("#modalPagoMenor").modal("show");
            $("#montoTD").val('');
        }
    }

    function evalueEntranceTB(e) {
        if (parseInt(e) + parseInt($('#efectivo').val()) + parseInt($('#montoTU').val()) + parseInt($('#montoTD').val()) > parseInt($('#pagoCon').val())) {
            $(".pago-menor-div").remove();
            $(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El monto ingresado es mayor al anticipo</b></label></center> <center><button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button></center></div>');
            jQuery("#modalPagoMenor").modal("show");
            $("#monto_tb").val('');
        }
    }

    $(".listado-tipos").ready(function () {
        // $(".listado-tipos").append('<option value="">Seleccione una opción</option>');
        $.getJSON(url2 + "Clientes/lista_tipos").done(function (data) {
            $.each(data, function (i, v) {
                event.preventDefault();
                jQuery.noConflict();
                $(".listado-tipos").append('<option value="' + v.id_opcion + '" data-value="' + v.id_catalogo + '">' + v.nombre + '</option>');
            });
        });
    });

    $(".listado-bancos").ready(function () {
        $(".listado-bancos").append('<option value="">Seleccione una opción</option>');
        $.getJSON(url2 + "Clientes/lista_bancos").done(function (data) {
            $.each(data, function (i, v) {
                event.preventDefault();
                jQuery.noConflict();
                $(".listado-bancos").append('<option value="' + v.id_banco + '">' + v.nombre + '</option>');
            });
        });
    });

    function loadEnfermeras() {
        $('#loader').removeClass('hidden');
        var vc_ar = Array();
        $.ajax({
            url: '<?=base_url()?>index.php/ClientesReventaInst/getVCByContrato/' + <?=$id_contrato?>,
            type: 'post',
            dataType: 'json',
            success: function (data) {
                var long_data = data.length;
                if (long_data > 0) {

                    $('.box-compartida').removeClass('d-none');
                    $('#compartida').prop('checked', true);
                    for (var i = 0; i < long_data; i++) {
                        vc_ar.push(data[i].id_usuario);
                    }
                }
            },
            error: function (xhr, object, message) {
            }
        });
        $.getJSON(url2 + "Clientes/getEnfermeras").done(function (data) {
            $.each(data, function (i, v) {
                event.preventDefault();
                jQuery.noConflict();
                found = vc_ar.find(element => element == v.id_usuario);
                if (found != undefined) {
                    $(".listado-enfermeras").append('<option selected value="' + v.id_usuario + '">' + v.name_enfermera + '</option>');
                } else {
                    $(".listado-enfermeras").append('<option value="' + v.id_usuario + '">' + v.name_enfermera + '</option>');
                }
            });
            $('#loader').addClass('hidden');
        });
    };

    $(document).ready(function () {
        var servicio = '<?=$servicio?>';
        if (servicio == 1) {
            $(".btn-moldeo").addClass('d-none');
            $(".btn-facial").addClass('d-none');
            $(".btn-facmol").addClass('d-none');
        } else if (servicio == 2) {
            $(".btn-depila").addClass('d-none');
            $(".btn-facial").addClass('d-none');
        } else if (servicio == 3) {
            $(".btn-depila").addClass('d-none');
            $(".btn-moldeo").addClass('d-none');
            $(".btn-facial").addClass('d-none');
            $(".btn-facmol").addClass('d-none');
        } else if (servicio == 4) {
            $(".btn-depila").addClass('d-none');
            $(".btn-moldeo").addClass('d-none');
            $(".btn-depmol").addClass('d-none');
        } else if (servicio == 5) {
            $(".btn-depila").addClass('d-none');
            $(".btn-moldeo").addClass('d-none');
            $(".btn-depmol").addClass('d-none');
            $(".btn-facial").addClass('d-none');
        }
        $("#modalTipoArea").modal("show");

        //Habilitamos formaPago para que sea Multiselect
        $('#formaPago').multiselect({
            nonSelectedText: 'Seleccione una opción'
        });

        $("#parcialidades option[value='<?=$parcialidades?>']").attr("selected", true);

        $('#efectivo').on('click focusin', function () {
            this.value = '';
            changeEntrance();
        });

        $('#efectivo').focusout(function () {
            if ($('#efectivo').val() != '')
                jQuery("#modalEfectivo").modal("show");
        });

        $('#montoTU').on('click focusin', function () {
            this.value = '';
            changeEntrance();
        });

        $('#montoTD').on('click focusin', function () {
            this.value = '';
            changeEntrance();
        });

        $('#monto_tb').on('click focusin', function () {
            this.value = '';
            changeEntrance();
        });

        $(document).on('click', '#btnsubmit', function () {
            $('#tp1').prop("disabled", false);
            $('#tp2').prop("disabled", false);
            $('#pagoConA').prop("disabled", false);
            $('.radioBtn').prop("disabled", false);
            $('#parcialidades').prop("disabled", false);

            var values1 = $('.select-uno');
            $(".corte1").val(values1.val().length);

            if ($('#trdos').is(':hidden')) {
                $("#trdos").remove();
            } else {
                var values2 = $('.select-dos');
                $(".corte2").val(values2.val().length);
            }

            if ($('#trtres').is(':hidden')) {
                $("#trtres").remove();
            } else {
                var values3 = $('.select-tres');
                $(".corte3").val(values3.val().length);
            }

            if ($('#trcuatro').is(':hidden')) {
                $("#trcuatro").remove();
            } else {
                var values4 = $('.select-cuatro');
                $(".corte4").val(values4.val().length);
            }

            if ($('#trcinco').is(':hidden')) {
                $("#trcinco").remove();
            } else {
                var values5 = $('.select-cinco');
                $(".corte5").val(values5.val().length);
            }
        });
    });

    $(".btn-area").click(function () {
        $('#loader').removeClass('hidden');
        seleccionPrincipal = $(this).val();
        $("#area_sel").val(seleccionPrincipal);
        var old_contrato = $("#id_contrato").val();
        $.getJSON(url2 + "ClientesReventaInst/areas_contrato/" + seleccionPrincipal + "/" + old_contrato).done(function (data) {
            $.each(data, function (i, v) {
                jQuery.noConflict();
                if (v.tipo == "Depilación") {
                    $(".option-group-d").append('<option value="' + v.id_area + '" data-value="' + v.tarifa + '" tipo="' + v.tipo + '" no-sesion="' + v.no_sesion + '" nombre="' + v.nombre + '" selected>' + v.nombre + '</option>');
                } else if (v.tipo == "Moldeo") {
                    $(".option-group-m").append('<option value="' + v.id_area + '" data-value="' + v.tarifa + '" tipo="' + v.tipo + '" no-sesion="' + v.no_sesion + '" nombre="' + v.nombre + '">' + v.nombre + '</option>');
                } else if (v.tipo == "Rejuvenecimiento facial") {
                    $(".option-group-rf").append('<option value="' + v.id_area + '" data-value="' + v.tarifa + '" tipo="' + v.tipo + '" no-sesion="' + v.no_sesion + '" data-piezas="' + v.piezas_edit + '" data-sesione = "' + v.sesiones_e + '" data-promo="' + v.promo_sesion + '" nombre="' + v.nombre + '" venus="' + v.venus + '">' + v.nombre + '</option>');
                }

            });
            defaultValues();
            $('#loader').addClass('hidden');
        });

        if (seleccionPrincipal == 1 || seleccionPrincipal == 3) $(".cuerpo-completo-btn").removeClass('d-none');
        if (seleccionPrincipal == 4 || seleccionPrincipal == 5) $(".row-tratamientos").removeClass('d-none');
        if (seleccionPrincipal == 4) {
            $(".areas-depmol").addClass('d-none');
            $('.precioFinal').attr('disabled', 'disabled');
        }
        loadEnfermeras();
        // pushOldArray();
    });

    //AA: Función para evaluar que áreas ya fueron seleccionadas en su momento
    function defaultValues() {
        let arrayAntMD = [], arrayAntRF = [];
        let y = 6;
        for (let x = 0; x < 4; x++) {
            let z = x + 1;
            if ($("#areas_ant" + x).val() != undefined) {
                let arrayAntMD = ($("#areas_ant" + x).val()).split(',');
                jQuery('#select' + z).select2().val(arrayAntMD).trigger('change');
            }
            if ($("#areasrf_ant" + y).val() != undefined) {
                let arrayAntRF = ($("#areasrf_ant" + y).val()).split(',');
                jQuery('#select' + y).select2().val(arrayAntRF).trigger('change');
                y++;
            }
        }
    }

    function defaultValuesLipo(origen){
        let arrayLipo = [];
        let arrayDetailAreas = identificarDetail(origen);
        for(let x=0; x<arrayDetailAreas.length; x++){
            if(arrayDetailAreas[x].id_area == "75"){
                arrayLipo.push(arrayDetailAreas[x].id_area_lipo);
            }
        }
        jQuery('#tbody-tratamientos'+origen+' .areaslipo').select2().val(arrayLipo).trigger('change');
    }

    //Función para habilitar card-box en venta protegida
    $(".protegida").change(function () {
        //Limpiamos inputs en caso de vener con info
        cleanTarjeta();
        if ($('.protegida').is(':checked')) {
            $("#referencia").val("0");
            $("#lblProtegida").removeClass('d-none');
            //Asignamos un valor por defecto al monto para jqueryValidation (no lo tomamos en back)
            $("#montoTU").val("0");
            $("#referencia").addClass('d-none');
            //Activamos y deshabilitamos datos que requerimos y no requerimos
            $("#box-card").removeClass('d-none');
            $("#tarjeta1").addClass('active');
            $("#tarjeta1").addClass('show');
            $("#tarjeta2").addClass('d-none');
            $("#tabtjt2").addClass('d-none');
            $(".box-monto").addClass('d-none');
            $(".box-msi").addClass('d-none');
        } else {
            $("#lblProtegida").addClass('d-none');
            //Habilitamos tarjeta 2
            $("#box-card").addClass('d-none');
            $("#tabtjt2").removeClass('d-none');
            $("#referencia").removeClass('d-none');
            $("#referencia").val("0");
        }
    });

    //Función para validar si es venta compartida o no
    $('#compartida').change(function () {
        if ($('#compartida').is(':checked')) {
            $('.box-compartida').removeClass('d-none');
        } else {
            $('.box-compartida').addClass('d-none');
            $('#enfermeras').prop('selectedIndex', 0);
        }
    });
</script>

<script>
    function deselectMulti() {
        jQuery('#formaPago').multiselect('deselect', ['1', '2']);
        $('#lblProtegida').addClass('d-none');
        $('#box-cash').addClass('d-none');
        $('.protegida').prop('checked', false);
        $('.protegida').prop('disabled', false);
        $('#box-card').addClass('d-none');
        cleanTarjeta();
    }

    function cleanTarjeta() {
        if (parseInt($('#precioFinal').val()) == parseInt($('#pagoCon').val()) || parseInt($('#precioFinal').val()) == (parseInt($('#pagoCon').val()) + parseInt($('#pagoConA').val()))) {
            $('#tp1').prop('selectedIndex', 0);
            $('#tp2').prop('selectedIndex', 0);
            $('#tp1').prop('disabled', true);
            $('#tp2').prop('disabled', true);
        } else {
            if ($('#prosa').val() == true) {
                $('#tp1').prop('selectedIndex', 0);
                $('#tp1').prop('disabled', true);
                $('#tp2').prop('disabled', true);
            } else if ($('#prosaa').val() == true) {
                $('#tp1').prop('selectedIndex', 1);
                $('#tp1').prop('disabled', true);
                $('#tp2').prop('disabled', true);
            } else {
                $('#tp1').prop('selectedIndex', 1);
                $('#tp1').prop('disabled', false);
                $('#tp2').prop('disabled', false);
            }
            $('#tp2').prop('selectedIndex', 0);
        }
        $('#tipoCobro').prop('selectedIndex', 0);
        $('#tipoCobro2').prop('selectedIndex', 0);
        $('#changeTipoTar1').prop('selectedIndex', 0);
        $('#changeTipoTar2').prop('selectedIndex', 0);
        $('#montoTU').val('0.00');
        $('#montoTD').val('0.00');
        $('#msi1').prop('selectedIndex', 0);
        $('#msi2').prop('selectedIndex', 0);
        $('#cardNumber').val('');
        $('#cardNumber2').val('');
        $('#mes').val('');
        $('#mes2').val('');
        $('#anio').val('');
        $('#anio2').val('');
        $('#referencia').val('0');
        $('#nameInCard').val('');
        $('#nameInCard2').val('');
        $('#tipoTarjeta').prop('selectedIndex', 0);
        $('#tipoTarjeta2').prop('selectedIndex', 0);
        $('#banco').prop('selectedIndex', 0);
        $('#banco2').prop('selectedIndex', 0);
    }

    function saldoPendienteCalc() {
        if (parseInt($('#precioFinalA').val()) == parseInt($('#pagoConA').val())) {
            $('#saldoPendiente').val( parseFloat($('#precioFinalC').val()) - parseFloat($('#pagoCon').val()));
        } else {   
            $('#saldoPendiente').val(parseFloat($('#precioFinalC').val()) - (parseFloat($('#pagoCon').val()) + parseFloat($('#pagoConA').val())));
        }
    }

    $(document).on('click', '#btn-save-documents', function () {
        $('#loader').removeClass('hidden');
        if ($("#protegida").prop("checked") == true || $("#tp1").val() == 1 || $("#tp2").val() == 1) { // PIDO PROTEGINA
            prosa = 1;
        } else { // NO PIDO PROTEGIDA
            prosa = 0;
        }

        $.ajax({
            type: 'POST',
            url: url2 + "ClientesReventaInst/guardarDocumentos",
            data: {
                'recibo_nameFile': $('#recibo_nameFile').val(),
                'ine_nameFile': $('#ine_nameFile').val(),
                'tarjeta_nameFile': $('#tarjeta_nameFile').val(),
                'contrato_nameFile': $('#contrato_nameFile').val(),
                'cprosa_nameFile': $('#cprosa_nameFile').val(),
                'id_titular': $('#id_titular1').val(),
                'prosaa': $('#prosaa').val(),
                'prosa': prosa,
                'id_contrato': $('#id_contrato').val()
            },
            dataType: 'json',
            success: function (data) {
                $('#loader').addClass('hidden');
                if (data.resultado) {
                    jQuery("#modalSaveDocuments").modal("show");
                } else {
                    jQuery("#modal_fail").modal("show");
                }
            }, error: function () {
                $('#loader').addClass('hidden');
                jQuery("#modal_fail").modal("show");
            }
        });
    });

    function activarBoton() {
        if ($('#protegida').is(':checked') || $('#protegidas').is(':checked') || $('#prosaa').val() == 1 || $('#tp1').val() == 1 || $('#tp2').val() == 1) {
            if ($('#prosaa').val() == "0") {
                if ($("#contrato_nameFile").val() != '' && $("#cprosa_nameFile").val() != '' && $('#tarjeta_nameFile').val() != '' && $("#recibo_nameFile").val() != '')
                    $('#btn-save-documents').removeClass('d-none');
            } else {
                if ($("#contrato_nameFile").val() != '' && $("#cprosa_nameFile").val() != '' && $("#recibo_nameFile").val() != '')
                    $('#btn-save-documents').removeClass('d-none');
            }
        } else {
            if ($("#contrato_nameFile").val() != '' && $("#recibo_nameFile").val() != '')
                $('#btn-save-documents').removeClass('d-none');
        }
    }

    $().ready(function () {
        $("#miform").validate({
            rules: {
                'nombre[]': {
                    required: true,
                },
                'apellido_paterno[]': {
                    required: true,
                },
                'apellido_materno[]': {
                    required: true,
                },
                'correo[]': {
                    required: true,
                },
                'telefono[]': {
                    required: true,
                },
                'parcialidades': {
                    required: true,
                },
                'tipoCobro': {
                    required: ".tarRequired:checked"
                },
                'tipoCreDeb[]': {
                    required: ".tarRequired:checked"
                },
                'montoT[]': {
                    required: ".tarRequired:checked",
                },
                'cardNumber[]': {
                    required: ".tarRequired:checked"
                },
                'mes[]': {
                    required: ".tarRequired:checked",
                    minlength: 2
                },
                'anio[]': {
                    required: ".tarRequired:checked",
                    minlength: 2
                },
                'referencia': {
                    required: ".tarRequired:checked"
                },
                'nameInCard[]': {
                    required: ".tarRequired:checked"
                },
                'tipoTarjeta[]': {
                    required: ".tarRequired:checked"
                },
                'banco[]': {
                    required: ".tarRequired:checked"
                },
                'efectivo': {
                    required: ".efeRequired:checked",
                    min: 1 + Number.MIN_VALUE
                },
                'clave_rastreo_tb': {
                    required: ".tranRequired:checked"
                },
                'monto_tb': {
                    required: ".tranRequired:checked",
                    min: 1 + Number.MIN_VALUE
                },
                'enfermeras': {
                    required: "#compartida:checked"
                },
            },
            // Se especifican los mensajes del error ante el required: true u otro atributo que se desee
            messages: {
                'nombre[]': {
                    required: "Dato requerido"
                },
                'apellido_paterno[]': {
                    required: "Dato requerido"
                },
                'apellido_materno[]': {
                    required: "Dato requerido"
                },
                'correo[]': {
                    required: "Dato requerido"
                },
                'telefono[]': {
                    required: "Dato requerido"
                },
                'parcialidades': {
                    required: "Seleccione el número de pagos"
                },
                'tipoCobro': {
                    required: "Dato requerido"
                },
                'tipoCreDeb[]': {
                    required: "Seleccione opción"
                },
                'montoT[]': {
                    required: "Dato requerido",
                },
                'cardNumber[]': {
                    required: "Dato requerido",
                    minlength: jQuery.validator.format("Ingresa un número de tarjeta válido (16 caracteres)"),
                },
                'mes[]': {
                    required: "Dato requerido",
                    minlength: "Formato MM"
                },
                'anio[]': {
                    required: "Dato requerido",
                    minlength: "Formato AA"
                },
                'referencia': {
                    required: "Dato requerido",
                },
                'nameInCard[]': {
                    required: "Dato requerido"
                },
                'tipoTarjeta[]': {
                    required: "Dato requerido"
                },
                'banco[]': {
                    required: "Dato requerido"
                },
                'efectivo': {
                    required: "Ingrese un monto",
                    min: "Ingrese un monto mayor a cero"
                },
                'clave_rastreo_tb': {
                    required: "Dato requerido"
                },
                'monto_tb': {
                    required: "Ingrese un monto",
                    min: "Ingrese un monto mayor a cero"
                },
                'enfermeras': {
                    required: "Seleccione una opción"
                },
            },
            //Se evaluan las rules anteriores después se puede ejectur el submit de la form
            submitHandler: function (form) {
                $('#loader').removeClass('hidden');
                var data = new FormData($(form)[0]);
                data.append('arrayTratamientos1', JSON.stringify(arrayTratamientos1));
                data.append('arrayTratamientos2', JSON.stringify(arrayTratamientos2));
                data.append('arrayTratamientos3', JSON.stringify(arrayTratamientos3));
                data.append('arrayTratamientos4', JSON.stringify(arrayTratamientos4));
                data.append('arrayTratamientos5', JSON.stringify(arrayTratamientos5));
                var tarjeta = 0;
                $.ajax({
                    url: url2 + "ClientesReventaInst/guardar_clientes",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    method: 'POST',
                    type: 'POST',
                    success: function (data) {
                        if (data.resultado) {
                            $('#loader').addClass('hidden');
                            disableFields();
                            $("#id_contrato").val(data.id_contrato);
                            jQuery("#modalClientAdded").modal("show");
                            imprimirContrato();
                            imprimirReciboPago();
                            if (data.prosa == 1) {
                                imprimirCartaProsa();
                                $('#carta-prosa-row').removeAttr("style");
                                if (data.prosaa == 0) $('#tarjeta-row').removeAttr("style");
                            }
                        } else {
                            $('#loader').addClass('hidden');
                            jQuery("#modal_fail").modal("show");
                        }
                    }
                });
            }
        })
    });
</script>


<script type="text/javascript">
    var creditcard = document.getElementById('cardNumber');

    function onkeyPress(event) {
        creditcard.value = creditcard.value.replace(/[a-zA-Z]/g, '');
        //validamos si es american express para esto quitamos todos los espacios en blaco y luego veriricamos que tenga 4, 6 y 5 digitos.
        if (creditcard.value.replace(/ /g, '').match(/\b(\d{4})(\d{6})(\d{5})\b/))
            creditcard.value = creditcard.value
                .replace(/\W/gi, '')//quitamos todos los espacios demas
                .replace(/\b(\d{4})(\d{6})(\d{5})\b/, '$1 $2 $3') //si cumple el formato añadimos 3,6 y 5 digitos
                .trim();
        else //si no es american express entonces es una tarjeta visa o master card
            creditcard.value = creditcard.value
                .replace(/\W/gi, '')
                .replace(/(.{4})/g, '$1 ')
                .trim()
    }

    creditcard.addEventListener('keypress', onkeyPress);
    creditcard.addEventListener('keydown', onkeyPress);
    creditcard.addEventListener('keyup', onkeyPress);
</script>


<script type="text/javascript">
    var creditcard2 = document.getElementById('cardNumber2');

    function onkeyPress(event) {
        creditcard2.value = creditcard2.value.replace(/[a-zA-Z]/g, '');
        //validamos si es american express para esto quitamos todos los espacios en blaco y luego veriricamos que tenga 4, 6 y 5 digitos.
        if (creditcard2.value.replace(/ /g, '').match(/\b(\d{4})(\d{6})(\d{5})\b/))
            creditcard2.value = creditcard2.value
                .replace(/\W/gi, '')//quitamos todos los espacios demas
                .replace(/\b(\d{4})(\d{6})(\d{5})\b/, '$1 $2 $3') //si cumple el formato añadimos 3,6 y 5 digitos
                .trim();
        else //si no es american express entonces es una tarjeta visa o master card
            creditcard2.value = creditcard2.value
                .replace(/\W/gi, '')
                .replace(/(.{4})/g, '$1 ')
                .trim()
    }

    creditcard2.addEventListener('keypress', onkeyPress);
    creditcard2.addEventListener('keydown', onkeyPress);
    creditcard2.addEventListener('keyup', onkeyPress);


    $.post("<?=base_url()?>index.php/Home/get_total_dia/", function (data) {
        var total_hoy = 0;
        for (var i = 0; i < data.length; i++) {
            total_hoy += parseFloat(data[i]['suma_hoy_cobros']);
        }
        $('#venta_diaria').append(addCommas(total_hoy) + " MXN");
    }, 'json');

    //get_venta_semanal
    $.post("<?=base_url()?>index.php/Home/get_total_semana/", function (data) {
        var total_semana = 0;
        for (var i = 0; i < data.length; i++) {
            total_semana += parseFloat(data[i]['suma_semana_cobros']);
        }

        $('#venta_semanal').append(addCommas(total_semana) + " MXN");
    }, 'json');

    function addCommas(nStr) {
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

    $('.header').click(function () {
        $(this).find('span').text(function (_, value) {
            return value == '-' ? '+' : '-'
        });
        $(this).nextUntil('tr.header').slideToggle(100, function () {
        });
    });

    $('#flechaDesplegar').click(function () {
        $("i", this).toggleClass("fa-chevron-up fa-chevron-down");
    });
    $('#flechaDesplegar_2').click(function () {
        $("i", this).toggleClass("fa-chevron-up fa-chevron-down");
    });
    $('#flechaDesplegar_3').click(function () {
        $("i", this).toggleClass("fa-chevron-up fa-chevron-down");
    });
    $('#flechaDesplegar_4').click(function () {
        $("i", this).toggleClass("fa-chevron-up fa-chevron-down");
    });
    $('#flechaDesplegar_5').click(function () {
        $("i", this).toggleClass("fa-chevron-up fa-chevron-down");
    });

    function buildTable(t) {
        let id_select = t.id;
        let origen = id_select.replace('select', '');
        let slValue = $('#' + id_select).val();
        let slValueOld = $('#areasrf_ant' + origen).val();
        let noVenus = 0;

        //AA:  Limpiamos el array del select donde se dispara la función después se hace el push de los obj.
        if (slValue != undefined && slValue != null && slValue != '') {
            arrayDinamico = identificarArray(origen);
            $('#' + id_select + ' option:selected').map(function (index, value) {
                let indexx = index + 1;
                let opcion = compararArraysNpush(arrayDinamico, slValue, value, false, origen);                
                if (opcion.nuevaOp) {
                    html = '<tr class="content-tabs" id="row-b-tbl' + opcion.id + '_' + origen + '">';
                    html += '<td>' + indexx + '</td>';
                    // html += '<td>1</td>';
                    html += '<td>' + $(this).attr("tipo") + '</td>';
                    html += '<td><input type="text" id="sesiones_' + opcion.id + '" class="form-control readonlys" onkeypress="return onlyNumbers(event)" value="' + opcion.sesiones + '"/></td>';
                    html += '<td>' + $(this).attr("nombre") + '</td>';

                    //AA: Validamos si vamos si el área seleccionada es Lipoenzímatica si sí aplicamos multiselect si no N/A
                    if (opcion.id == "75") html += '<td><select class="g-disabld form-control scroll-styles areaslipo areastratamiento_' + opcion.id + '" data-name="areastratamiento_' + opcion.id + '" style="overflow: auto !important; height: 60px !important;" name="areaslipo" multiple></select></td>';
                    else html += '<td><input type="text" class="form-control" value="N/A" disabled/></td>';

                    if (opcion.id == "75") html += '<td><input type="text" id="piezas_' + opcion.id + '" class="form-control readonlys" onkeypress="return onlyNumbers(event)" value="' + opcion.sesiones + '"></td>';
                    else html += '<td><input type="text" id="piezas_' + opcion.id + '" class="form-control readonlys" onkeypress="return onlyNumbers(event)" value="' + opcion.piezas + '"></td>';

                    if (opcion.id == "75") html += '<td><input type="text" class="form-control" value="$' + formatMoney(opcion.costo) + '" disabled style="color: white;"></td>';
                    else html += '<td><input type="text" class="form-control" value="$' + formatMoney(opcion.costo) + '" disabled></td>';

                    html += '<td><input  id="precio_' + opcion.id + '" type="text" class="form-control" onkeypress="return onlyNumbers(event)" value="$' + formatMoney(opcion.costo) + '" disabled></td></tr>';
                    $("#tbody-tratamientos" + origen).append(html);

                    let id_tratamiento = opcion.id;
                    let input_piezas = document.querySelector('#row-b-tbl' + opcion.id + '_' + origen + ' #piezas_' + opcion.id);
                    let input_precio = document.querySelector('#row-b-tbl' + opcion.id + '_' + origen + ' #precio_' + opcion.id);
                    let input_sesiones = document.querySelector('#row-b-tbl' + opcion.id + '_' + origen + ' #sesiones_' + opcion.id);

                    let precioBase = $("select[id='select" + origen + "'] option[value='" + opcion.id + "']").data("value");
                    let promociones = $("select[id='select" + origen + "'] option[value='" + opcion.id + "']").data("promo");

                    //AA: Evaluamos si se pueden editar las sesiones si es 0 no se editan.
                    if ($(this).attr("data-sesione") == "0" || opcion.id == "75") input_sesiones.disabled = true;
                    else input_sesiones.style.border = "3px solid #a06fce";

                    //AA: Evaluamos si las piezas serán editables o no
                    if ($(this).attr("data-piezas") == "1" || opcion.id == "75") input_piezas.disabled = true;
                    else input_piezas.style.border = "3px solid #a06fce";

                    //AA: Añadimos funcionalidad select2 a selects que tengan clase areastratamiento_x
                    let multiareas = document.querySelector('#tbody-tratamientos' + origen + ' .areastratamiento_' + opcion.id);
                    if (multiareas != null) {
                        jQuery(multiareas).select2({
                            allowClear: false
                        }).on("select2:unselecting", function (e) {
                            $(this).data('state', 'unselected');
                        }).on("select2:open", function (e) {
                            if ($(this).data('state') === 'unselected') {
                                $(this).removeData('state');
                                jQuery(multiareas).select2('close');
                            }
                        });

                        jQuery(multiareas).on("select2:select", function (evt) {
                            var element = evt.params.data.element;
                            var $element = $(element);
                            $element.detach();
                            $(this).append($element);
                        });
                        getAreasLipoenzimas(multiareas, id_tratamiento, origen);
                    }

                    //AA: Cuando la opció sea editable para piezas o sesiones ejecutamos las funciones para calcular los costos para sesiones y unidades precargadas. 
                    if ($(this).attr("data-sesione") != "0" && opcion.id != "75") { sesionesXprecio(id_tratamiento, origen, input_precio, input_sesiones, precioBase, promociones, false); }
                    if ($(this).attr("data-piezas") != "1" && opcion.id != "75") { piezasXprecio(id_tratamiento, origen, input_piezas, input_precio, precioBase); }
                    
                    //AA: Como vamos a precargar info tiene que hacer el calculo sin que se disparé el onchange
                    calcMontosTratamientos(origen);

                    input_piezas.onkeyup = () => piezasXprecio(id_tratamiento, origen, input_piezas, input_precio, precioBase);
                    input_piezas.onchange = () => validateEmpty(id_tratamiento, origen, input_piezas, input_precio, input_sesiones, precioBase);
                    input_sesiones.onkeyup = () => sesionesXprecio(id_tratamiento, origen, input_precio, input_sesiones, precioBase, promociones, false);
                    input_sesiones.onchange = () => validateEmpty(id_tratamiento, origen, input_piezas, input_precio, input_sesiones, precioBase);
                    if (multiareas != null) multiareas.onchange = () => buildSubtable(id_tratamiento, origen, multiareas, input_precio, input_sesiones, input_piezas);
                }
                if (opcion.deleteOp) {
                    $("#row-b-tbl" + opcion.id + '_' + origen).remove();
                    calcMontosTratamientos(origen);
                }
            });
        } else {
            //AA: Limpiamos toda la tabla del clienteX, dejamos el encabezado e inicialisamos el arrayX en []
            $("#tbody-tratamientos" + origen + " .content-tabs").remove();
            limpiarArrays(origen);
            calcMontosTratamientos(origen);
            validateVenus();
        }
    }

    //AA: Función para eliminar la subtable del tratamiento lipoenzimas
    function buildSubtable(id_tratamiento, origen, multiareas){        
        let class_lipoen = multiareas.dataset.name;
        let valueSlc =  $('#tbody-tratamientos'+origen+ ' .'+class_lipoen).val();
        arrayDinamico = identificarArray(origen);
        //AA: Array de las áreas de lipoenzimas, puede ser del cliente1, cliente2, etc...
        objectFound = arrayDinamico.find(obj => obj.id == id_tratamiento);        
        if( valueSlc != undefined && valueSlc != null && valueSlc != ''){
            //AA: Solo creamos el encabezado para el primera opción
            $('#tbody-tratamientos' +origen+ ' .'+class_lipoen+' option:selected').map(function (index, value) {
                //AA: Recibimos un objeto con un id y una bandera para identificar si se eliminó o añadió una nueva área al select de lipo
                opcionn = compararArraysNpush(objectFound.areas, valueSlc, value, true, origen);                
                let id_area = opcionn.id;
                //AA: Si es verdadero significa que el ID del área seleccionada aún no existia en el array y lo agregamos a la subtabla.
                if (opcionn.nuevaOp){
                    html = '<tr class="detail-tabs" id="row-tbl-detail'+opcionn.id+'_'+origen+'" style="text-align:center">';
                    // html += '<td>'+indexx+'</td>';
                    html += '<td>1</td>';
                    html += '<td>Lipoenzimas</td>';
                    html += '<td><input type="text" id="sesionesd_'+opcionn.id+'" class="form-control readonlys" onkeypress="return onlyNumbers(event)" value="'+opcionn.sesiones+'" style="text-align:center; background-color: #eee7f5; border: 3px solid #a06fce;"/></td>';
                    html += '<td>'+$(this).attr("nombre")+'</td>';
                    html += '<td><input type="text" id="preciobase_'+opcionn.id+'" class="form-control" value="$'+formatMoney(opcionn.costo)+'" style="text-align:center; background-color: #eee7f5;" disabled></td>';
                    html += '<td><input type="text" id="precio_'+opcionn.id+'" class="form-control" onkeypress="return onlyNumbers(event)" value="$'+formatMoney(opcionn.costo)+'" style="text-align:center; background-color: #eee7f5;" disabled></td></tr>';
                    $("#tbody-lipoenzimas"+origen).append(html);

                    let input_sesiones = document.querySelector('#row-tbl-detail'+opcionn.id+'_'+origen+' #sesionesd_'+opcionn.id);
                    let input_precio = document.querySelector('#row-tbl-detail'+opcionn.id+'_'+origen+' #precio_'+opcionn.id);
                    let input_preciobase = document.querySelector('#row-tbl-detail'+opcionn.id+'_'+origen+' #preciobase_'+opcionn.id);

                    let precioBase = parseInt(unmaskMoney(input_preciobase.value));

                    sesionesXdetail(origen, objectFound, input_precio, precioBase, id_area, id_tratamiento);
                    input_sesiones.onkeyup = ()=> sesionesXdetail(origen, objectFound, input_precio, precioBase, id_area, id_tratamiento);
                    input_sesiones.onchange = () => validateEmptyDetail(origen, objectFound, input_sesiones, input_precio, precioBase, id_area, id_tratamiento);
                    calcLipoenzimas(origen, objectFound, id_tratamiento);
                }
                // AA: Si es falso, significa que ya no existe en el array pero que si existe en la subtabla por tanto eliminaos en base a la clase en espcifico
                if(opcionn.deleteOp){
                    $("#row-tbl-detail"+opcionn.id+'_'+origen).remove();
                    //AA: Se vuelve a hacer el calculo de los totales que llevamos al eliminar un elemento
                    calcLipoenzimas(origen, objectFound, id_tratamiento);
                }
            });
        }
        else{
            //AA: Limpiamos toda la subtable de lipoenzimas, dejamos el encabezado e inicialisampos el array de áreas lipoenzimas a []
            $("#tbody-tratamientos"+origen+" .detail-tabs").remove();
            objectFound.areas = [];
            calcLipoenzimas(origen, objectFound, id_tratamiento);
        }
    }

    function compararArraysNpush(arrayDinamico, slValue, option, lipoenzimas, origen) {
        let arrayDetailAreas = identificarDetail(origen);
        if(arrayDetailAreas.length == 0){            
            arrayDetailAreas = [];
        }
        
        let objetoArea = compararOldArrayVSNew(option, lipoenzimas, arrayDetailAreas, arrayDinamico);
        let objectFoundd = arrayDinamico.find(obj => obj.id == objetoArea.id);

        (!lipoenzimas) ? slValue = $('#select'+origen).val(): slValue = $("#tbody-tratamientos"+origen+" .areaslipo").val();

        if(arrayDinamico.length < slValue.length){
            if(objectFoundd == undefined){                
                objetoArea.nuevaOp = true;
                arrayDinamico.push(objetoArea);
            }
            else{
                objetoArea.nuevaOp = false;
                objetoArea.deleteOp = false;
            }
        }
        else if(arrayDinamico.length > slValue.length){            
            arrayDinamico.forEach((el, ind) =>{                       
                deleted = slValue.find(obj => obj == el.id);
                if (deleted == undefined) {
                    el.nuevaOp = false;
                    el.deleteOp = true;
                    objetoArea = el;
                    
                    arrayDinamico.splice(ind, 1);                    
                    //AA: Evaluamos si el área eliminada es Lipoenzias para limpiar el encabezado de subtable lipoenzimas
                    if (objetoArea.id == '75') {
                        document.getElementById("tr_subTable_" + origen + "").innerHTML = '';
                    }
                }
                else el.nuevaOp = false;            
            });
        }
        
        if (!lipoenzimas) validateVenus();
        return objetoArea;
    }

    function compararOldArrayVSNew(option, lipoenzimas, arrayDetailAreas, arrayDinamico){
        let tratamientoObj = {};
        let areaFoundN;
        let areaFound;
        if (!lipoenzimas){
            areaFound = arrayDetailAreas.find(obj => obj.id_area == option.value);
            (areaFound != undefined) ? areaFoundN = arrayDinamico.find(obj => obj.id == areaFound.id_area) : areaFoundN = arrayDinamico.find(obj => obj.id == option.value);
        }
        else areaFound = arrayDetailAreas.find(obj => obj.id_area_lipo == option.value);

        if ( (areaFound == undefined && areaFoundN == undefined) || (areaFound == undefined && areaFoundN != undefined)){
            if (!lipoenzimas) {
                tratamientoObj = { nuevaOp: false, deleteOp: false, id: option.value, sesiones: option.getAttribute("no-sesion"), costo : option.getAttribute("data-value"), areas: [], piezas: '1', venus: option.getAttribute("venus")};
            }
            else{
                tratamientoObj = { nuevaOp: false, deleteOp: false, id: option.value, sesiones: option.getAttribute("no-sesion"), costo : option.getAttribute("data-value"), piezas: '1'};
            }
        }
        else{
            if (!lipoenzimas) {
                tratamientoObj = { nuevaOp: false, deleteOp: false, id: areaFound.id_area, sesiones: areaFound.num_sesion, costo: areaFound.tarifa, areas: [], piezas: areaFound.unidades, venus: areaFound.venus };
            } 
            else {
                tratamientoObj = { nuevaOp: false, deleteOp: false, id: areaFound.id_area_lipo, sesiones: areaFound.sesiones_lipo, costo: areaFound.tarifa_lipo, piezas: '1' };
            }
        }        
        return tratamientoObj;
    }

    //AA: Función para validad si al menos uno de los array por cliente trae algun área de Venus, de ser así cambiamos el valor de area_sel, para imprimir el contrato mixto
    function validateVenus() {
        let cont = 0;
        for (let i = 0; i < arrayTratamientos1.length; i++) {
            if (arrayTratamientos1[i].venus == 1) cont++;
        }
        for (let i = 0; i < arrayTratamientos2.length; i++) {
            if (arrayTratamientos2[i].venus == 1) cont++;
        }
        for (let i = 0; i < arrayTratamientos3.length; i++) {
            if (arrayTratamientos3[i].venus == 1) cont++;
        }
        for (let i = 0; i < arrayTratamientos4.length; i++) {
            if (arrayTratamientos4[i].venus == 1) cont++;
        }
        for (let i = 0; i < arrayTratamientos5.length; i++) {
            if (arrayTratamientos5[i].venus == 1) cont++;
        }

        if (cont > 0) {
            venus = true
            $("#area_sel").val(5);
        } else if (seleccionPrincipal != 5) {
            venus = false;
            $("#area_sel").val(4);
        }
    }

    function getAreasLipoenzimas(multiareas, id_tratamiento, origen) {
        $('#loader').removeClass('hidden');
        $.getJSON(url2 + "Clientes/get_areasLipoenzimas").done(function (data) {
            $.each(data, function (i, v) {
                event.preventDefault();
                jQuery.noConflict();
                multiareas.innerHTML += '<option value="' + v.id_area + '" data-value="' + v.tarifa + '" no-sesion="1" nombre="' + v.nombre + '">' + v.nombre + '</option>';
            });
            defaultValuesLipo(origen);
            $('#loader').addClass('hidden');
        });
        let row_tratamiento = document.getElementById('row-b-tbl' + id_tratamiento + '_' + origen);
        var tr_base = document.createElement("tr");
        tr_base.setAttribute("id", "tr_subTable_" + origen + "");

        tr_base.innerHTML = '<td colspan="13" style="padding: 10px 50px"><table class="table" style="background-color: #eee7f5!important; border-radius: 10px;"><tbody id="tbody-lipoenzimas' + origen + '""><tr style="border-bottom: 1px solid #fff; color: #4b4b4b; text-align:center"><td style="width: 8%; font-size: 12px; border-top:0;">No. área</td><td style="width:15%; border-top:0;">Tipo</td><td style="width:12%; border-top:0;">No. sesiones</td><td style="width:75px; border-top:0;">Área</td><td style="width:20%; border-top:0;">Precio unitario</td><td style="width:20%; border-top:0;">Precio total</td></tr></tbody></table></td>';
        row_tratamiento.insertAdjacentElement('afterend', tr_base);

    }

    function calcMontosTratamientos(origen) {
        let suma = 0;
        let total = 0;
        let input_suma = document.querySelector('#sumat_' + origen);
        arrayDinamico = identificarArray(origen);
        if (arrayDinamico.length > 0) {
            for (let i = 0; i < arrayDinamico.length; i++) {
                suma = suma + parseInt(arrayDinamico[i].costo);
            }
        }
        input_suma.value = '$' + formatMoney(suma);
        input_totalrf = document.querySelector('#totalrf');
        input_totaldm = document.querySelector('.precioFinal');
        input_total = document.querySelector('#precioFinalC');
        for (i = 6; i < 11; i++) {
            let input_t = document.querySelector('#sumat_' + i);
            total = total + parseInt(unmaskMoney(input_t.value));
        }
        input_totalrf.value = total;
        input_total.value = parseInt(input_totalrf.value) + parseInt(input_totaldm.value);
        calcularAnticipo();
        valorMensualidad();
    }

    function piezasXprecio(id_tratamiento, origen, input_piezas, input_precio, precioBase){        
        let newPrice =  input_piezas.value * precioBase;
        input_precio.value = '$' +formatMoney(newPrice);
        arrayDinamico = identificarArray(origen);
        //AA: Buscamos en el array el objeto por su id y lo modificamos
        if(arrayDinamico.length > 0) objectFound = arrayDinamico.find(obj => obj.id == id_tratamiento);
        objectFound.piezas = input_piezas.value;
        objectFound.costo = unmaskMoney(input_precio.value);
        calcMontosTratamientos(origen);
    }

    function sesionesXprecio(id_tratamiento, origen, input_precio, input_sesiones, precioBase, promociones, lipoenzimas){
        if (promociones != "0"){
            if (input_sesiones.value != "3" && input_sesiones.value != "4" && input_sesiones.value != "6"){
                input_precio.value = '$'+formatMoney(input_sesiones.value * precioBase);
            }
            else{
                arrayPromo = promociones.toString().split(',');
                for(let i=0; i<arrayPromo.length; i++){
                    if(input_sesiones.value == arrayPromo[i] && input_sesiones.value == "3" ){
                        if(id_tratamiento == "74") input_precio.value = '$'+formatMoney(5400);
                        break;
                    }
                    else if(input_sesiones.value == arrayPromo[i] && input_sesiones.value == "4" ){
                        if(id_tratamiento == "66") input_precio.value = '$'+formatMoney(16900);
                        else if(id_tratamiento == "68" || id_tratamiento == "69" || id_tratamiento == "70" || id_tratamiento == "71" || id_tratamiento == "73"){
                            input_precio.value = '$'+formatMoney(10900);
                        }
                        else if(id_tratamiento == "72") input_precio.value = '$'+formatMoney(5900);
                        else if(id_tratamiento == "76" || id_tratamiento == "77") input_precio.value = '$'+formatMoney(4900);
                        break;
                    }
                    else if(input_sesiones.value == arrayPromo[i] && input_sesiones.value == "6" ){
                        if(id_tratamiento == "68" || id_tratamiento == "69" || id_tratamiento == "70" || id_tratamiento == "71")input_precio.value = '$'+formatMoney(14900);
                        else if(id_tratamiento == "75" || id_tratamiento == "76" || id_tratamiento == "77")input_precio.value = '$'+formatMoney(9900);
                        break;
                    }
                    else{
                        input_precio.value = '$'+formatMoney(input_sesiones.value * precioBase);
                    }
                }
            }
        }
        else{
            input_precio.value = '$'+formatMoney(input_sesiones.value * precioBase);
        }
        arrayDinamico = identificarArray(origen);
        if(arrayDinamico.length > 0) objectFound = arrayDinamico.find(obj => obj.id == id_tratamiento);
        objectFound.costo = unmaskMoney(input_precio.value);
        calcMontosTratamientos(origen);
    }

    //AA: Función para validar si algún fue dejado en blanco en el evento on change de ser así, arrojo un valor default de 1 y precio base
    function validateEmpty(id_tratamiento, origen, input_piezas, input_precio, input_sesiones, precioBase){
        if( input_piezas.value == '' || input_piezas.value == 0){
            input_piezas.value = 1;
            let newPrice =  input_piezas.value * precioBase;
            input_precio.value = '$'+formatMoney(newPrice);
        }
        if (input_sesiones.value == '' || input_sesiones.value == 0){
            input_sesiones.value = 1;
            let newPrice = input_sesiones.value * precioBase;
            input_precio.value = '$'+formatMoney(newPrice);
        }
        arrayDinamico = identificarArray(origen);
        //AA: Buscamos en el array el objeto por su id y lo modificamos
        if(arrayDinamico.length > 0) objectFound = arrayDinamico.find(obj => obj.id == id_tratamiento);
        objectFound.piezas = input_piezas.value;
        objectFound.sesiones = input_sesiones.value;
        objectFound.costo = unmaskMoney(input_precio.value);
        calcMontosTratamientos(origen);
    }

    //AA: Función para validar si algún fue dejado en blanco en el evento on change de ser así, arrojo un valor default de 1 y precio base
    function validateEmptyDetail(origen, arrayDetail, input_sesiones, input_precio, precioBase, id_area, id_tratamiento){
        let newPrice = '';
        if (input_sesiones.value == '' || input_sesiones.value == 0){
            input_sesiones.value = 1;
            newPrice = input_sesiones.value * precioBase;
            input_precio.value = '$'+formatMoney(newPrice);

            for(let i=0; i < arrayDetail.areas.length; i++){
                if (arrayDetail.areas[i].id == id_area.value){
                    arrayDetail.areas[i].costo = newPrice;
                    arrayDetail.areas[i].sesiones =  1;
                    break;
                }
            }
            calcLipoenzimas(origen, arrayDetail, id_tratamiento);
        }
    }

    function sesionesXdetail(origen, arrayDetail, input_precio, precioBase, id_area, id_tratamiento) {
        let input_sesiones = document.querySelector('#row-tbl-detail'+id_area+'_'+origen+' #sesionesd_'+id_area);        
        input_precio.value = '$' + formatMoney(input_sesiones.value * precioBase);        
        let objectFound = (arrayDetail.areas).find(obj => obj.id == id_area);        
        if (objectFound != undefined){
            objectFound.sesiones = input_sesiones.value;
        }

        calcLipoenzimas(origen, arrayDetail, id_tratamiento);
    }

    function calcLipoenzimas(origen, arrayDinamico, id_tratamiento){
        let suma = 0;
        let sesiones = 0;
        let noareas = 0;

        let input_piezas_g = document.querySelector('#row-b-tbl'+id_tratamiento+'_'+origen+' #piezas_'+id_tratamiento);
        let input_precio_g = document.querySelector('#row-b-tbl'+id_tratamiento+'_'+origen+' #precio_'+id_tratamiento);
        let input_sesiones_g = document.querySelector('#row-b-tbl'+id_tratamiento+'_'+origen+' #sesiones_'+id_tratamiento);
        if ((arrayDinamico.areas).length > 0) {
            noareas = noareas + (arrayDinamico.areas).length;
            for(let i=0; i < (arrayDinamico.areas).length; i++){
                suma = suma + (parseInt(arrayDinamico.areas[i].costo) * parseInt(arrayDinamico.areas[i].sesiones));
                sesiones = sesiones + parseInt(arrayDinamico.areas[i].sesiones); 
                
            }
        }
        input_piezas_g.value = noareas;
        input_sesiones_g.value = sesiones;
        input_precio_g.value = '$'+formatMoney(suma);
        arrayDinamico.costo = suma;
        arrayDinamico.sesiones = sesiones;
        calcMontosTratamientos(origen);
    }

    function changePriceDepMol(){
        $precioFinal = parseInt($('.precioFinal2').val());
        if ($('.precioFinal').val() < $precioFinal) {
            $('.precioFinal').val($precioFinal);
            $("#precioFinalC").val($precioFinal + parseFloat($("#totalrf").val()));
            validateAdvance();
            $(".pago-menor-div").remove();
            $(".pago-menor").append('<div class="pago-menor-div"><div><center><img src="<?= base_url("assets/img/falla_general.png")?>" style="width:130px; height: 120px"></center></div><center><label><b>El costo total del servicio no puede ser menor a $'+ $precioFinal +'.</b></label></center> <center><button type="button" class="btn btn-body" data-dismiss="modal">Aceptar</button></center></div>');
            jQuery("#modalPagoMenor").modal("show");
        }
        else{
            $('#pagoCon').val(0);
            $precioFinal = parseFloat($('.precioFinal').val());
            $("#precioFinalC").val($precioFinal + parseFloat($("#totalrf").val()));
            if ($precioFinal >= 10000) {
                $("#pagoCon").val(($precioFinal * 0.10) + parseFloat($("#totalrf").val()));
                $("#aPagar").val($precioFinal * 0.10  + parseFloat($("#totalrf").val()));
            }
            else if ($precioFinal > 1000 && $precioFinal < 10000) {
                $("#pagoCon").val(1000  + parseFloat($("#totalrf").val()));
                $("#aPagar").val(1000  + parseFloat($("#totalrf").val()));
            }

            validateAdvance();
        }
    }

    function identificarArray(origen) {
        if (origen == 6) return arrayTratamientos1;
        else if (origen == 7) return arrayTratamientos2;
        else if (origen == 8) return arrayTratamientos3;
        else if (origen == 9) return arrayTratamientos4;
        else if (origen == 10) return arrayTratamientos5;
    }

    function limpiarArrays(origen) {
        if (origen == 6) arrayTratamientos1 = [];
        else if (origen == 7) arrayTratamientos2 = [];
        else if (origen == 8) arrayTratamientos3 = [];
        else if (origen == 9) arrayTratamientos4 = [];
        else if (origen == 10) arrayTratamientos5 = [];
    }

    function identificarDetail(origen){
        if( origen == 6) return clte_datail6;
        else if( origen == 7) return clte_datail7;
        else if( origen == 8) return clte_datail8;
        else if( origen == 9) return clte_datail9;
        else if( origen == 10) return clte_datail10;
    }

    function mayus(e) {
        e.value = e.value.toUpperCase();
    }

    function unmaskMoney(str) {
        str = str.replace('$', '');
        str = str.replace(',', '');
        return str;
    }

    function onlyLetters(e) {
        key = e.keyCode || e.which;
        tecla = String.fromCharCode(key).toUpperCase();
        letras = " ÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
        especiales = [8, 37, 39, 46];

        tecla_especial = false
        for (var i in especiales) {
            if (key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }

        if (letras.indexOf(tecla) == -1 && !tecla_especial)
            return false;
    }

    function onlyNumbers(e) {
        key = e.keyCode || e.which;
        tecla = String.fromCharCode(key);
        letras = " 0123456789";
        especiales = [8, 37, 39, 46];

        tecla_especial = false
        for (var i in especiales) {
            if (key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }

        if (letras.indexOf(tecla) == -1 && !tecla_especial)
            return false;
    }

    function formatMoney(n) {
        var c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;

        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };
</script>