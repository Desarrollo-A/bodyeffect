<?php

// require __DIR__ . '/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea



spl_autoload_register ( function ($class) {
 
	$prefix = "Mike42\\";
	// echo __DIR__;
	$base_dir = __DIR__ . "/src/Mike42/";
	
	/* Only continue for classes in this namespace */
	$len = strlen ( $prefix );
	if (strncmp ( $prefix, $class, $len ) !== 0) {
		return;
	}
	
	/* Require the file if it exists */
	$relative_class = substr ( $class, $len );
	$file = $base_dir . str_replace ( '\\', '/', $relative_class ) . '.php';
	if (file_exists ( $file )) {
		require $file;
	}
} );



use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

$nombre_impresora = "ImpresoraAurea"; 
$nombreUser  = "Adriana Aurea Argaiz Cabrera"; 

$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);

# Vamos a alinear al centro lo próximo que imprimamos
$printer->setJustification(Printer::JUSTIFY_CENTER);
/*
	Intentaremos cargar e imprimir
	el logo
*/
// try{
// 	$logo = EscposImage::load("https://i.pinimg.com/564x/ba/5a/19/ba5a191dea829f5baa7dbe7f9497e377.jpg", false);
//     $printer->bitImage($logo);
// }catch(Exception $e){/*No hacemos nada si hay error*/}


$printer->text("\n"."B O D Y   E F F E C T" . "\n");
$printer->text("___________________________" . "\n\n\n");
$printer->text("Plaza Midtown Jalisco, Local 53-A planta alta,"."\n"."Italia Providencia Guadalajara, Jal."."\n\n");

$printer->text("Teléfono: (332) 310 59 07" . "\n");
#La fecha también
date_default_timezone_set("America/Mexico_City");
$printer->text(date("d-m-Y H:i:s") . "\n\n\n");
$printer->text("FOLIO: 0023BE\n");
 
	/*Alinear a la izquierda para la cantidad y el nombre*/
	$printer->setJustification(Printer::JUSTIFY_CENTER);
    
    $printer->text("\n");
    $printer->text("RECIBÍ DE:\n");
    $printer->text($nombreUser."\n\n\n");

    $printer->setJustification(Printer::JUSTIFY_CENTER);

    $printer->text("\n");
    $printer->text("LA CANTIDAD DE:\n");
    $printer->text("QUINCE MIL TREINTA PESOS CON 0/0 CENTAVOS M.N\n\n\n");


     $printer->setJustification(Printer::JUSTIFY_CENTER);

    $printer->text("\n");
    $printer->text("FORMA DE PAGO:\n");
    $printer->text("TARJETA CRÉDITO, EFECTIVO\n\n\n");


    $printer->setJustification(Printer::JUSTIFY_CENTER);
    

    $printer->text("\n\n");
    $printer->text("Pago de servicios\n");

    for($i = 0; $i<=3; $i++){
    	$sum = $i+1; 
    	$printer->text( $sum." pago  12/11/2019  $5,010.00\n");

    }

$printer->setJustification(Printer::JUSTIFY_RIGHT);
$printer->text("\n\n\n");
$printer->text("SUBTOTAL: $15,030.00\n");
$printer->text("IVA:      $0.00\n");
$printer->text("TOTAL: $15,030.00\n\n");

$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("\n\n\n");
$printer->text("¡En Body Effect queremos lo mejor para ti!\n\n\n");
$printer->setJustification(Printer::JUSTIFY_CENTER);

$printer->text("\n");
$printer->text("Si requiere factura favor de solicitarla al"."\n"."momento o bien proporcionar sus datos fiscales"."\n"."al siguiente correo electrónico"."\n"."facturacion@bodyeffect.com.mx"."\n"."en un tiempo no mayor a 72 horas se le hará"."\n"."llegar su comprobante");

/*Alimentamos el papel 3 veces*/
$printer->feed(3);

$printer->cut();

$printer->pulse();

$printer->close();

?>